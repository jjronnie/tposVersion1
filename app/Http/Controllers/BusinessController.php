<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $business = auth()->user()->business;
         $user = auth()->user();

    return view('business.settings.index', compact('business', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function onboarding()
    {
        return view('business.setup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Business $business)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'timezone' => 'required|string|max:100',
            'tin_no' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($business->logo_path && Storage::exists($business->logo_path)) {
                Storage::delete($business->logo_path);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $business->logo_path = $path;
        }

        // Auto-generate account number if missing
        if (!$business->account_number) {
            $lastBusiness = Business::whereNotNull('account_number')
                ->where('account_number', 'like', '10001604%')
                ->orderByDesc('account_number')
                ->first();

            if ($lastBusiness) {
                $lastNumber = intval($lastBusiness->account_number);
                $nextNumber = $lastNumber + 5;
            } else {
                $nextNumber = 10001604200; // First number
            }

            $business->account_number = $nextNumber;
        }

        // Update other fields
        $business->fill($request->only([
            'name',
            'short_name',
            'currency',
            'email',
            'phone',
            'country',
            'address',
            'timezone',
            'tin_no',
            'website'
        ]));

        $business->save();

        return redirect()->back()->with('success', 'Business details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }
}
