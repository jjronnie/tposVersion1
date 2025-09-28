<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Example: Get products, ordered by name, with low stock products first.
        $products = Product::query()
            ->orderByRaw('CASE WHEN quantity <= quantity_alert THEN 0 ELSE 1 END')
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(null));

        // Use a transaction for safety (especially with file uploads)
         return DB::transaction(function () use ($request, $validated) {

             // 1. Handle Avatar Upload
            if ($request->hasFile('avatar')) {
                // Store the file in 'avatars/products' on the 'public' disk
                $validated['avatar'] = $request->file('avatar')->store('avatars/products', 'public');
            } else {
                // Ensure the field is null if no file was uploaded
                unset($validated['avatar']);
            }

            // Note: business_id is automatically set by the trait
            $product = Product::create($validated);
            // TODO: Handle 'avatar' file upload and update the model

            $generator = new BarcodeGeneratorPNG();
            $barcodeValue = $product->barcode; // The unique string you generated

            $image = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);

            // Save the image to storage (e.g., storage/app/public/barcodes)
            $path = 'barcodes/' . $barcodeValue . '.png';
            Storage::disk('public')->put($path, $image);

            $product->update(['barcode_image_path' => $path]); 

           return redirect()->route('products.index')->with('success', 'Product created successfully!');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // The trait's Global Scope ensures that $product is only found if it belongs
        // to the current business, otherwise a 404 will be thrown.
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->validationRules($product->id));

        return DB::transaction(function () use ($product, $validated) {
            $product->update($validated);
            // TODO: Handle 'avatar' file update/deletion

              return redirect()->route('products.index')->with('success', 'Product Details updated successfully.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Product $product)
    {
        // Ensure the global scope protects against deleting products from other businesses.

        return DB::transaction(function () use ($product) {

            // 1. Delete the product photo (avatar) if it exists
            if ($product->avatar) {
                // Assuming you store avatars in the 'public' disk under a directory like 'avatars'
                // Adjust the path as necessary if you store it in a different location
                Storage::disk('public')->delete($product->avatar);
            }

            // 2. Delete the generated barcode image if it exists
            if ($product->barcode_image_path) {
                // Assuming barcode images are also stored on the 'public' disk
                Storage::disk('public')->delete($product->barcode_image_path);
            }

            // 3. Delete the database record
            $product->delete();

            // 4. Redirect to the index page with a success message
            return redirect()->route('products.index')->with('success', 'Product successfully deleted.');
        });
    }

    protected function validationRules($productId)
    {
        $businessId = auth()->user()->business_id;

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['product', 'service'])],

            // Pricing
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',

            // Inventory
            'unit' => 'nullable|string|max:50',
            'quantity' => 'required_if:type,product|nullable|integer|min:0',
            'quantity_alert' => 'required_if:type,product|nullable|integer|min:0',

            // Barcode is nullable, but if provided, it must be unique within the business.
            'barcode' => [
                'nullable', // Allows sending null/empty string, triggering auto-generation
                'string',
                'max:255',
                Rule::unique('products')->where(function ($query) use ($businessId, $productId) {
                    $query->where('business_id', $businessId);
                    if ($productId) {
                        $query->where('id', '!=', $productId);
                    }
                }),
            ],

            'avatar' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            // created_by is NOT required as the model handles it
        ];
    }
}
