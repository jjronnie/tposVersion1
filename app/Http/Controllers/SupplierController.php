<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{

     protected function validationRules(Supplier $supplier = null)
    {
        // The business_id is handled by the global scope for the unique rule
        $businessId = Auth::user()->business_id;
        $supplierId = $supplier ? $supplier->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Unique rule still needs to be explicitly scoped to the business
                Rule::unique('suppliers')->where(function ($query) use ($businessId) {
                    return $query->where('business_id', $businessId);
                })->ignore($supplierId),
            ],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['enabled', 'disabled'])],
            'opening_balance' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'tax_id' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate($this->validationRules());
        
        // Handle default for nullable numeric field
        $validated['opening_balance'] = $validated['opening_balance'] ?? 0.00;

        // 2. Create the model.
        // The Trait's 'creating' hook will automatically set business_id and created_by.
        Supplier::create($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        // Model binding fails (404) if the global scope doesn't find the model
        // within the current business. No manual authorization needed.
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(Supplier $supplier)
    {
        // Model binding/Global Scope protects this route.
        return view('suppliers.edit', compact('supplier'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        // 1. Validation
        $validated = $request->validate($this->validationRules($supplier));
        
        // Handle default for nullable numeric field
        $validated['opening_balance'] = $validated['opening_balance'] ?? 0.00;

        // 2. Update the model.
        $supplier->update($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Model binding/Global Scope protects this route.
        try {
            $supplier->delete();
            return redirect()->route('suppliers.index')
                             ->with('success', 'Supplier deleted successfully.');
        } catch (\Exception $e) {
            \Log::error("Failed to delete supplier ID {$supplier->id}: " . $e->getMessage());
            return redirect()->route('suppliers.index')
                             ->with('error', 'Supplier could not be deleted. It might be linked to existing transactions.');
        }
    }
}
