<x-guest-layout>
   
    <div class="flex flex-col md:flex-row min-h-screen w-full">
        <!-- Left: Register Form -->
        <div class="w-full md:w-1/3 flex flex-col justify-center px-6 py-12 sm:px-10">
            <div class="w-full max-w-md mx-auto px-10">
                <div class="md:hidden mb-2 mx-auto flex items-center justify-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Tpos Logo" class="w-62 h-62 object-contain" />
                </div>
                   <div class="text-center">

                <h1 class="font-bold mb-3  text-xl">Create Account</h1>

                 @include('auth.google-button')

                <p class="mb-6  text-sm">
                    Enter your credentials to create a free account and get a <span class="text-green-500 font-bold"> 30 days free trial. </span> No Credit card Required
                </p>
                   </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Business Name -->
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            autofocus placeholder="Business Name"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="name"
                            class="absolute left-4 top-2 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Business Name
                        </label>
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            placeholder="Email"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="email"
                            class="absolute left-4 top-2 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Email
                        </label>
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>              

                    <!-- Password -->
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Password"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="password"
                            class="absolute left-4 top-2 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Password
                        </label>
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="password_confirmation"
                            class="absolute left-4 top-2 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Confirm Password
                        </label>
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="terms-and-conditions" name="terms-and-conditions" value="1"
                            required class="rounded text-green-600 focus:ring-green-500 h-4 w-4" />
                        <label for="terms-and-conditions" class="text-sm text-gray-900">
                            I agree to the
                            <a href="/terms-and-conditions" class="text-green-600 hover:underline">
                                Terms and Conditions of Tpos
                            </a>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 register-button bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200">
                        Create Account
                    </button>
                </form>

            </div>
            <p class="text-sm mt-4 text-center">
                Already Registered?
                <span class="text-green-500">
                    <a href="{{ route('login') }}"> Login Here</a>
                </span>
            </p>
        </div>

        <!-- Right: Banner -->
        <div class="hidden md:flex w-full md:w-2/3 relative flex-col justify-center items-center text-center px-10 py-24"
            style="background-image: url('{{ asset('assets/img/banner.webp') }}'); background-size: cover; background-position: center;">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-50"></div>

            <!-- Content -->
            <img src="{{ asset('assets/img/tpos1.png') }}" alt=" Logo" class="h-[210px] mb-0 relative z-10" />

            <p class="max-w-2xl text-white text-base md:text-lg leading-relaxed px-4 relative z-10">
                Transform Your Business with T-POS | The complete point-of-sale solution designed to streamline your
                operations, boost sales, and grow your business.
            </p>
        </div>
    </div>

    <script>
        // Add loading state to register button
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('.register-button');
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Creating Account...
            `;
            button.disabled = true;
        });
    </script>
</x-guest-layout>
