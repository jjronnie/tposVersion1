<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{


    protected function validationRules(Unit $unit = null)
    {
        $businessId = Auth::user()->business_id;
        $unitId = $unit ? $unit->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                // Check uniqueness of name within the business
                Rule::unique('units')->where(function ($query) use ($businessId) {
                    return $query->where('business_id', $businessId);
                })->ignore($unitId),
            ],
            'short_name' => [
                'required',
                'string',
                'max:20',
                // Check uniqueness of short_name within the business
                Rule::unique('units')->where(function ($query) use ($businessId) {
                    return $query->where('business_id', $businessId);
                })->ignore($unitId),
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Global scope handles business_id filtering
        $units = Unit::when($request->search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('short_name', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(15);

        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        Unit::create($validated);



        return redirect()->back()->with('success', 'Unit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        // Global Scope handles authorization
        return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        // Global Scope handles authorization
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate($this->validationRules($unit));

        $unit->update($validated);

        return redirect()->route('units.index')
            ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        // Global Scope handles authorization
        try {
            $unit->delete();
            return redirect()->route('units.index')
                ->with('success', 'Unit deleted successfully.');
        } catch (\Exception $e) {
            \Log::error("Failed to delete unit ID {$unit->id}: " . $e->getMessage());
            return redirect()->route('units.index')
                ->with('error', 'Unit could not be deleted. It might be linked to existing products.');
        }
    }

}
