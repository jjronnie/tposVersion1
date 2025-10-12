<?php

namespace App\Http\Controllers;

use App\Http\Requests\Onboarding\StepOneRequest;
use App\Http\Requests\Onboarding\StepTwoRequest;
use App\Models\Business;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    /**
     * Show the onboarding page
     */
    public function index()
    {
        $business = auth()->user()->business;

        // If onboarding is already completed, redirect to dashboard
        if ($business && $business->hasCompletedOnboarding()) {
            return redirect()->route('dashboard');
        }

        // Get available currencies and timezones
        $currencies = $this->getCurrencies();
        $timezones = timezone_identifiers_list();
        $countries = $this->getCountries();

        return view('business.setup', compact('business', 'currencies', 'timezones', 'countries'));
    }

    /**
     * Save step one data (Business Info)
     */
    public function saveStepOne(StepOneRequest $request): JsonResponse
    {
        try {
            $business = auth()->user()->business;

            if (!$business) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business not found'
                ], 404);
            }

            $business->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Business information saved successfully',
                'data' => $business->fresh()
            ]);

        } catch (\Exception $e) {
            Log::error('Onboarding Step 1 Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save business information'
            ], 500);
        }
    }

    /**
     * Save step two data (Additional Info)
     */
    public function saveStepTwo(StepTwoRequest $request): JsonResponse
    {
        try {
            $business = auth()->user()->business;

            if (!$business) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business not found'
                ], 404);
            }

            $data = $request->validated();

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($business->logo_path) {
                    Storage::disk('public')->delete($business->logo_path);
                }

                $logoPath = $request->file('logo')->store('logos', 'public');
                $data['logo_path'] = $logoPath;
            }

            $business->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Additional information saved successfully',
                'data' => $business->fresh()
            ]);

        } catch (\Exception $e) {
            Log::error('Onboarding Step 2 Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save additional information'
            ], 500);
        }
    }

    /**
     * Complete the onboarding process
     */
    public function complete(Request $request): JsonResponse
    {
        try {
            $business = auth()->user()->business;

            if (!$business) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business not found'
                ], 404);
            }

            // Validate required fields are filled
            $requiredFields = ['name', 'phone', 'country', 'currency', 'currency_symbol'];
            foreach ($requiredFields as $field) {
                if (empty($business->$field)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Please complete all required fields. Missing: {$field}"
                    ], 422);
                }
            }

            DB::beginTransaction();

            try {
                $business->completeOnboarding();
                
                // Log the onboarding completion
                Log::info('Business onboarding completed', [
                    'business_id' => $business->id,
                    'user_id' => auth()->id()
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Onboarding completed successfully',
                    'redirect' => route('dashboard')
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Onboarding Completion Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete onboarding'
            ], 500);
        }
    }

    /**
     * Get current onboarding data
     */
    public function getData(): JsonResponse
    {
        $business = auth()->user()->business;

        return response()->json([
            'success' => true,
            'data' => $business
        ]);
    }

    /**
     * Get available currencies
     */
    private function getCurrencies(): array
    {
        return [
            ['code' => 'UGX', 'name' => 'Uganda Shilling', 'symbol' => 'UGX'],
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'],
            ['code' => 'KES', 'name' => 'Kenya Shilling', 'symbol' => 'KSh'],
            ['code' => 'TZS', 'name' => 'Tanzania Shilling', 'symbol' => 'TSh'],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£'],
        ];
    }

    /**
     * Get common countries (you can expand this)
     */
    private function getCountries(): array
    {
        return [
            'UG' => 'Uganda',
            'KE' => 'Kenya',
            'TZ' => 'Tanzania',
            'RW' => 'Rwanda',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            // Add more countries as needed
        ];
    }
}