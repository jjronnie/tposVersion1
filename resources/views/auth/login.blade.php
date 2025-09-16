<x-guest-layout>

    <div class="flex flex-col md:flex-row min-h-screen w-full">

        <!-- Left: Login Form -->
        <div class="w-full md:w-1/3 flex flex-col justify-center px-6 py-12 sm:px-10">

            <div class="w-full max-w-md mx-auto px-10">
                <div class="md:hidden mb-2 mx-auto flex items-center justify-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Tpos Logo" class=" w-62 h-62 object-contain" />
                </div>

                <h1 class="font-bold  mb-3 text-left text-xl">Sign In</h1>
                <p class="mb-6 text-left text-sm">Enter your credentials to login</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus placeholder="Email"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="email"
                            class="absolute left-4 top-2 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600 dark:peer-focus:text-green-400">
                            Username
                        </label>
                        @error('email')
                            <p class="text-red-600 text-sm mt-2 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Password"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="password"
                            class="absolute left-4 top-2 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600 dark:peer-focus:text-green-400">
                            Password
                        </label>

                        <!-- Toggle Eye Icon -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-4 focus:outline-none text-gray-700 dark:text-gray-300">
                            <i data-lucide="eye" id="eye-icon" class="w-5 h-5"></i>
                        </button>

                        @error('password')
                            <p class="text-red-600 text-sm mt-2 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 dark:border-gray-500 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-900 dark:text-gray-100">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-gray-900 dark:text-gray-100"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="login-button w-full flex items-center justify-center gap-2 py-3 bg-green-600 dark:bg-green-500 text-white font-semibold rounded-full transition duration-300 hover:bg-green-700 dark:hover:bg-green-600">
                        <span>Sign In</span>
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                    </button>

                </form>

            </div>
            <p class="text-sm mt-4 text-center ">Dont have an Account? <span class="text-green-500 underline "><a
                        href="{{ route('register') }}"> Register Here</a></span></p>
        </div>

        <div class="hidden md:flex w-full md:w-2/3 relative flex-col justify-center items-center text-center px-10 py-24"
            style="background-image: url('{{ asset('assets/img/banner.webp') }}'); background-size: cover; background-position: center;">

            {{-- Overlay to darken the background image --}}
            <div class="absolute inset-0 bg-black opacity-50"></div> {{-- Adjust opacity-XX for desired darkness --}}

            {{-- Content on top of the darkened image --}}
            <img src="{{ asset('assets/img/tpos1.png') }}" alt=" Logo" class="h-[210px] mb-0 relative z-10" />

            {{-- <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 relative z-10">Track. Record. Grow.</h2> --}}

            <p class="max-w-2xl text-white text-base md:text-lg leading-relaxed px-4 relative z-10">
                Transform Your Business with T-POS | The complete point-of-sale solution designed to streamline your
                operations, boost sales, and grow your business.
            </p>

        </div>
    </div>




    <script>
        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('.login-button');
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Signing in...
            `;
            button.disabled = true;
        });
    </script>

</x-guest-layout>
