@extends('layouts.main')
@section('content')
    <div x-data="onboardingWizard()" 
         x-init="init()"
         class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">
        <div class="w-full max-w-5xl">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex items-center flex-1">
                            <div class="relative flex items-center justify-center">
                                <div 
                                    :class="currentStep >= index ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600'"
                                    class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 transform"
                                    :class="currentStep === index ? 'scale-110 ring-4 ring-blue-200' : ''"
                                >
                                    <span x-show="currentStep > index">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span x-show="currentStep <= index" x-text="index + 1"></span>
                                </div>
                            </div>
                            <div 
                                x-show="index < steps.length - 1"
                                class="flex-1 h-1 mx-2 transition-all duration-300"
                                :class="currentStep > index ? 'bg-blue-600' : 'bg-gray-300'"
                            ></div>
                        </div>
                    </template>
                </div>
                <div class="flex justify-between text-xs text-gray-600 mt-2 px-2">
                    <template x-for="(step, index) in steps" :key="index">
                        <span 
                            class="transition-all duration-300"
                            :class="currentStep === index ? 'font-semibold text-blue-600' : ''"
                            x-text="step.title"
                        ></span>
                    </template>
                </div>
            </div>

            <!-- Auto-save Indicator -->
            <div x-show="saving" class="mb-4 text-center">
                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </div>

            <!-- Success Message -->
            <div x-show="saveSuccess" 
                 x-transition
                 class="mb-4 text-center">
                <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span x-text="saveMessage"></span>
                </span>
            </div>

            <!-- Error Message -->
            <div x-show="errors.length > 0" 
                 x-transition
                 class="mb-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-red-800 mb-1">Please fix the following errors:</h3>
                            <ul class="list-disc list-inside text-sm text-red-700">
                                <template x-for="error in errors" :key="error">
                                    <li x-text="error"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Step 0: Welcome -->
                <div x-show="currentStep === 0" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     class="p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Welcome to TPOS! </h1>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Let's get you set up in just a few steps and you'll be ready to start selling!</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6 mt-12">
                        <div class="text-center p-6 rounded-xl bg-blue-50 transform transition hover:scale-105">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-full mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Lightning Fast</h3>
                            <p class="text-sm text-gray-600">Process sales in seconds with our intuitive interface</p>
                        </div>
                        
                        <div class="text-center p-6 rounded-xl bg-purple-50 transform transition hover:scale-105">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-600 rounded-full mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Smart Analytics</h3>
                            <p class="text-sm text-gray-600">Track sales, inventory, and profits in real-time</p>
                        </div>
                        
                        <div class="text-center p-6 rounded-xl bg-green-50 transform transition hover:scale-105">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-green-600 rounded-full mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Secure & Reliable</h3>
                            <p class="text-sm text-gray-600">Your data is encrypted and backed up automatically</p>
                        </div>
                    </div>
                </div>

                <!-- Step 1: Business Info -->
                <div x-show="currentStep === 1" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     class="p-8 md:p-12">
                    <div class="flex items-start mb-8">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Business Information</h2>
                        </div>
                    </div>

                    <form @submit.prevent="saveStepOne" class="space-y-6 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Business Name <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                x-model="formData.name"
                                @input="autoSaveStepOne"
                                placeholder="Enter Full Business Name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Short Name</label>
                            <input 
                                type="text" 
                                x-model="formData.short_name"
                                @input="autoSaveStepOne"
                                placeholder="Enter Short Name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            >
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input 
                                    type="tel" 
                                    x-model="formData.phone"
                                    @input="autoSaveStepOne"
                                    placeholder="include country code"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input 
                                    type="email" 
                                    x-model="formData.email"
                                    @input="autoSaveStepOne"
                                    placeholder="company email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                >
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country <span class="text-red-500">*</span></label>
                                <select 
                                    x-model="formData.country"
                                    @change="autoSaveStepOne"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    required
                                >
                                    <option value="">Select country</option>
                                    @foreach($countries as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency <span class="text-red-500">*</span></label>
                                <select 
                                    x-model="formData.currency"
                                    @change="updateCurrencySymbol(); autoSaveStepOne();"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    required
                                >
                                    <option value="">Select currency</option>
                                    @foreach($currencies as $curr)
                                        <option value="{{ $curr['code'] }}" data-symbol="{{ $curr['symbol'] }}">
                                            {{ $curr['code'] }} - {{ $curr['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Step 2: Additional Info -->
                <div x-show="currentStep === 2" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     class="p-8 md:p-12">
                    <div class="flex items-start mb-8">
                        <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Additional Information</h2>
                            <p class="text-gray-600">These details are optional but help personalize your experience</p>
                        </div>
                    </div>

                    <form @submit.prevent="saveStepTwo" class="space-y-6 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Business Address</label>
                            <textarea 
                                x-model="formData.address"
                                @input="autoSaveStepTwo"
                                rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            ></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                                <select 
                                    x-model="formData.timezone"
                                    @change="autoSaveStepTwo"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                >
                                    <option value="">Select timezone</option>
                                    @foreach($timezones as $tz)
                                        <option value="{{ $tz }}">{{ $tz }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">TIN Number</label>
                                <input 
                                    type="text" 
                                    x-model="formData.tin_no"
                                    @input="autoSaveStepTwo"
                                    placeholder="Tax Identification Number"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Business Logo</label>
                            <div class="mt-1 flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img x-show="logoPreview" 
                                         :src="logoPreview" 
                                         class="h-16 w-16 rounded-lg object-cover border-2 border-gray-300"
                                         alt="Logo preview">
                                    <div x-show="!logoPreview" 
                                         class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input 
                                        type="file" 
                                        @change="handleLogoUpload"
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    >
                                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">How did you hear about us?</label>
                            <select 
                                x-model="formData.source"
                                @change="autoSaveStepTwo"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            >
                                <option value="" selected disabled>Select source</option>
                                <option value="facebook">Facebook</option>
                                <option value="x">X (Twitter)</option>
                                <option value="tiktok">TikTok</option>
                                <option value="instagram">Instagram</option>
                                <option value="google">Google Search</option>
                                <option value="website">Website</option>
                                <option value="referral">Referral</option>
                                <option value="walk_in">Walk-in</option>
                                <option value="agent">Agent</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div x-show="formData.source" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Details</label>
                            <textarea 
                                x-model="formData.source_details"
                                @input="autoSaveStepTwo"
                                rows="2"
                                placeholder="Tell us more about how you found TPOS..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            ></textarea>
                        </div>
                    </form>
                </div>

                <!-- Step 3: Complete -->
                <div x-show="currentStep === 3" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     class="p-8 md:p-12">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mb-6 animate-pulse">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">You're All Set! </h1>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">Your Business is configured and ready to go. Let's start making sales!</p>

                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 max-w-2xl mx-auto mb-8">
                            <h3 class="font-semibold text-gray-900 mb-4 text-left">Quick Summary:</h3>
                            <div class="space-y-3 text-left">
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Business Name:</span>
                                    <span class="font-medium text-gray-900" x-text="formData.name || 'Not set'"></span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium text-gray-900" x-text="formData.phone || 'Not set'"></span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Country:</span>
                                    <span class="font-medium text-gray-900" x-text="formData.country || 'Not set'"></span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-600">Currency:</span>
                                    <span class="font-medium text-gray-900" x-text="formData.currency || 'Not set'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 max-w-2xl mx-auto mb-8">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-left">
                                    <h4 class="font-semibold text-yellow-900 mb-1">Next Steps:</h4>
                                    <ul class="text-sm text-yellow-800 space-y-1">
                                        <li>• Add your first products to inventory</li>
                                        <li>• Set up customer records (optional)</li>
                                        <li>• Start making your first sale!</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="px-8 md:px-12 pb-8 flex items-center justify-between border-t pt-6">
                    <button 
                        @click="prevStep()"
                        x-show="currentStep > 0 && currentStep < 3"
                        type="button"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </button>
                    
                    <div x-show="currentStep === 0" class="w-full"></div>
                    
                    <button 
                        @click="nextStep()"
                        x-show="currentStep < 3"
                        type="button"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition transform hover:scale-105 ml-auto"
                    >
                        <span x-text="currentStep === 0 ? 'Get Started' : 'Continue'"></span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <button 
                        @click="completeOnboarding()"
                        x-show="currentStep === 3"
                        :disabled="saving"
                        type="button"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition transform hover:scale-105 ml-auto disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span x-show="!saving">Launch POS System</span>
                        <span x-show="saving">Completing...</span>
                        <svg x-show="!saving" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function onboardingWizard() {
            return {
                currentStep: 0,
                saving: false,
                saveSuccess: false,
                saveMessage: '',
                errors: [],
                autoSaveTimeout: null,
                logoFile: null,
                logoPreview: null,
                steps: [
                    { title: 'Welcome', icon: 'zap' },
                    { title: 'Business Info', icon: 'building' },
                    { title: 'Additional Info', icon: 'settings' },
                    { title: 'Complete', icon: 'check' }
                ],
                formData: {
                    name: '',
                    short_name: '',
                    phone: '',
                    email: '',
                    country: '',
                    currency: '',
                    currency_symbol: '',
                    address: '',
                    timezone: '',
                    tin_no: '',
                    source: '',
                    source_details: ''
                },
                currencies: @json($currencies),

                init() {
                    // Load existing business data
                    this.loadBusinessData();
                },

                async loadBusinessData() {
                    try {
                        const response = await fetch('{{ route("onboarding.data") }}');
                        const data = await response.json();
                        
                        if (data.success && data.data) {
                            const business = data.data;
                            this.formData = {
                                name: business.name || '',
                                short_name: business.short_name || '',
                                phone: business.phone || '',
                                email: business.email || '',
                                country: business.country || '',
                                currency: business.currency || 'UGX',
                                currency_symbol: business.currency_symbol || 'UGX',
                                address: business.address || '',
                                timezone: business.timezone || '',
                                tin_no: business.tin_no || '',
                                source: business.source || '',
                                source_details: business.source_details || ''
                            };

                            if (business.logo_path) {
                                this.logoPreview = '/storage/' + business.logo_path;
                            }
                        }
                    } catch (error) {
                        console.error('Failed to load business data:', error);
                    }
                },

                nextStep() {
                    // Validate current step
                    if (this.currentStep === 1) {
                        if (!this.validateStepOne()) {
                            return;
                        }
                    }
                    
                    if (this.currentStep < this.steps.length - 1) {
                        this.currentStep++;
                    }
                },

                prevStep() {
                    if (this.currentStep > 0) {
                        this.currentStep--;
                    }
                },

                validateStepOne() {
                    this.errors = [];
                    
                    if (!this.formData.name) this.errors.push('Business name is required');
                    if (!this.formData.phone) this.errors.push('Phone number is required');
                    if (!this.formData.country) this.errors.push('Country is required');
                    if (!this.formData.currency) this.errors.push('Currency is required');

                    return this.errors.length === 0;
                },

                autoSaveStepOne() {
                    clearTimeout(this.autoSaveTimeout);
                    this.autoSaveTimeout = setTimeout(() => {
                        this.saveStepOne();
                    }, 1000); // Auto-save after 1 second of inactivity
                },

                autoSaveStepTwo() {
                    clearTimeout(this.autoSaveTimeout);
                    this.autoSaveTimeout = setTimeout(() => {
                        this.saveStepTwo();
                    }, 1000);
                },

                async saveStepOne() {
                    if (!this.formData.name && !this.formData.phone) {
                        return; // Don't save if critical fields are empty
                    }

                    this.saving = true;
                    this.errors = [];

                    try {
                        const response = await fetch('{{ route("onboarding.step-one") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.showSuccessMessage('Progress saved automatically');
                        } else {
                            if (data.errors) {
                                this.errors = Object.values(data.errors).flat();
                            }
                        }
                    } catch (error) {
                        console.error('Auto-save failed:', error);
                    } finally {
                        this.saving = false;
                    }
                },

                async saveStepTwo() {
                    this.saving = true;
                    this.errors = [];

                    try {
                        const formData = new FormData();
                        
                        // Append text fields
                        Object.keys(this.formData).forEach(key => {
                            if (this.formData[key]) {
                                formData.append(key, this.formData[key]);
                            }
                        });

                        // Append logo if exists
                        if (this.logoFile) {
                            formData.append('logo', this.logoFile);
                        }

                        const response = await fetch('{{ route("onboarding.step-two") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.showSuccessMessage('Progress saved automatically');
                        } else {
                            if (data.errors) {
                                this.errors = Object.values(data.errors).flat();
                            }
                        }
                    } catch (error) {
                        console.error('Auto-save failed:', error);
                    } finally {
                        this.saving = false;
                    }
                },

                async completeOnboarding() {
                    if (!this.validateStepOne()) {
                        this.currentStep = 1;
                        return;
                    }

                    this.saving = true;
                    this.errors = [];

                    try {
                        const response = await fetch('{{ route("onboarding.complete") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            this.errors = [data.message];
                        }
                    } catch (error) {
                        this.errors = ['Failed to complete onboarding. Please try again.'];
                        console.error('Onboarding completion failed:', error);
                    } finally {
                        this.saving = false;
                    }
                },

                updateCurrencySymbol() {
                    const selected = this.currencies.find(c => c.code === this.formData.currency);
                    if (selected) {
                        this.formData.currency_symbol = selected.symbol;
                    }
                },

                handleLogoUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.logoFile = file;
                        
                        // Create preview
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.logoPreview = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        // Trigger save
                        this.saveStepTwo();
                    }
                },

                showSuccessMessage(message) {
                    this.saveMessage = message;
                    this.saveSuccess = true;
                    setTimeout(() => {
                        this.saveSuccess = false;
                    }, 3000);
                }
            }
        }
    </script>
    @endsection