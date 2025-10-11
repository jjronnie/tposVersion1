<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function searchCustomers(Request $request)
    {
        $query = $request->input('search', '');

        $customers = Customer::where('status', 'enabled')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email']);

        return response()->json($customers);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('search', '');

        $products = Product::where('is_active', true)
            ->where('quantity', '>', 0) 
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'selling_price', 'quantity', 'unit', 'barcode']);

        return response()->json($products);
    }

    public function index(Request $request): View
    {
        $sales = Sale::with(['customer', 'creator'])
            ->latest()
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {

        

        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'nullable|date',
            'payment_method' => 'required|in:cash,card,transfer,other',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $itemsData = $validated['items'];
            $invoiceNumber = $this->generateUniqueInvoiceNumber();

            $subtotal = 0;
            $taxAmount = $validated['tax_amount'] ?? 0;
            $discountAmount = $validated['discount_amount'] ?? 0;
            $saleItemsToStore = [];
            $productsToUpdate = [];

            foreach ($itemsData as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product || !$product->is_active) {
                    throw ValidationException::withMessages([
                        'items' => "Product is unavailable or inactive."
                    ]);
                }

                if ($product->quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient stock for {$product->name}. Only {$product->quantity} available."
                    ]);
                }

                $sellingPrice = $item['price'];
                $quantity = $item['quantity'];
                $itemSubtotal = $sellingPrice * $quantity;

                $subtotal += $itemSubtotal;

                $saleItemsToStore[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'selling_price' => $sellingPrice,
                    'quantity' => $quantity,
                    'unit' => $product->unit,
                    'item_discount' => 0,
                    'item_tax' => 0,
                    'subtotal' => $itemSubtotal,
                ];

                $productsToUpdate[$product->id] = $quantity;
            }

            $finalGrandTotal = $validated['grand_total'];
            $amountPaid = $validated['amount_paid'];
            $balance = $amountPaid - $finalGrandTotal;

            $paymentStatus = 'paid';
            if ($amountPaid < $finalGrandTotal) {
                $paymentStatus = 'partial';
            } elseif ($amountPaid == 0) {
                $paymentStatus = 'pending';
            }

            $sale = Sale::create([
                'business_id' => $user->business_id,
                'customer_id' => $validated['customer_id'],
                'created_by' => $user->id,
                'invoice_number' => $invoiceNumber,
                'sale_date' => $validated['sale_date'] ?? now(),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'grand_total' => $finalGrandTotal,
                'amount_paid' => $amountPaid,
                'balance' => $balance,
                'payment_status' => $paymentStatus,
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'],
            ]);

            $saleItemsToStore = array_map(function ($item) use ($sale) {
                $item['sale_id'] = $sale->id;
                $item['created_at'] = now();
                $item['updated_at'] = now();
                return $item;
            }, $saleItemsToStore);

            DB::table('sale_items')->insert($saleItemsToStore);

            foreach ($productsToUpdate as $productId => $quantitySold) {
                DB::table('products')
                    ->where('id', $productId)
                    ->decrement('quantity', $quantitySold);
            }

            DB::commit();

            return response()->json([
                'message' => 'Sale recorded successfully',
                'sale_id' => $sale->id,
                'invoice_number' => $invoiceNumber,
                'change' => max(0, $balance)
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Sale creation failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Sale failed. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    protected function generateUniqueInvoiceNumber(): string
    {
        $user = Auth::user();
        $prefix = 'INV-' . $user->business_id . '-';
        $date = now()->format('Ymd');
        
        do {
            $random = mt_rand(1000, 9999);
            $invoiceNumber = $prefix . $date . '-' . $random;
        } while (Sale::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    public function show(Sale $sale): View
    {
        $sale->load(['customer', 'items', 'items.product', 'creator']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        //
    }
}