<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $customers = auth()->user()->business->customers;
        return view('customers.index', compact('customers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,NULL,id,business_id,' . Auth::user()->business_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tin_number' => 'nullable|string|max:100',
            'status' => 'required|in:enabled,disabled',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $validated['business_id'] = Auth::user()->business_id;
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars/customers', 'public');
            $validated['avatar'] = $path;
        }

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Make sure this customer belongs to the logged-in user's business
        if ($customer->business_id !== Auth::user()->business_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('customers', 'email')->ignore($customer->id), // Ignore current customer
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tin_number' => 'nullable|string|max:100',
            'status' => 'required|in:enabled,disabled',
            'avatar' => 'nullable|image|max:2048',
        ]);

      

            // Handle avatar upload
    if ($request->hasFile('avatar')) {
        // Delete old avatar if exists
        if ($customer->avatar && Storage::disk('public')->exists($customer->avatar)) {
            Storage::disk('public')->delete($customer->avatar);
        }

        // Store new avatar
        $validated['avatar'] = $request->file('avatar')->store('customers', 'public');
    }

        // Update the customer
        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
 public function destroy(Customer $customer)
{   

    // Ensure tenant ownership
    if ($customer->business_id !== auth()->user()->business_id) {
        abort(403, 'Unauthorized action.');
    }

    // Delete avatar if exists
    if ($customer->avatar && Storage::disk('public')->exists($customer->avatar)) {
        Storage::disk('public')->delete($customer->avatar);
    }

    $customer->delete();

    return redirect()->route('customers.index')
        ->with('success', 'Customer deleted successfully!');
}

}
