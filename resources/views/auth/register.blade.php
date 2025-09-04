<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - TPOS</title>
    <link rel="icon" href="favicon.png">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#eafff6] flex flex-col">

    <div class="flex flex-col md:flex-row min-h-screen w-full">

        <!-- Left: Login Form -->
        <div class="w-full md:w-[45%] bg-white flex flex-col justify-center px-6 py-12 sm:px-10">

            <div class="w-full max-w-md mx-auto px-10">
                <div class="w-32 h-32 mb-2 mx-auto flex items-center justify-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Tpos Logo" class="w-20 h-20 object-contain" />
                </div>


                <h1 class="font-bold text-gray-800 mb-3 text-left text-xl">Create an account</h1>
                <p class="text-gray-600 mb-6 text-left text-sm">Enter your credentials to create a free account for your
                    business. No Credit card Required</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4 ">
                    @csrf

                    <!-- name -->
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            autofocus placeholder="name"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="name"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Full Name
                        </label>
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus placeholder="Email"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="email"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Email
                        </label>
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- phone -->
                    <div class="relative">
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                            autofocus placeholder="phone"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <label for="phone"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Pnone Number
                        </label>
                        @error('phone')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>




                    <!-- Country -->
                    <div class="mt-4">
                        <x-input-label for="country" :value="__('Country')" />
                        <select name="country" id="country" required
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach (countries() as $code => $country)
                                <option value="{{ $code }}"
                                    {{ old('country', 'UG') == $code ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Password"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />

                        <label for="password"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Password
                        </label>

                        <!-- Toggle Eye Icon -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i data-lucide="eye" id="eye-icon" class="w-5 h-5"></i>
                        </button>

                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- password_confirmation -->
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />

                        <label for="password_confirmation"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                           Confirm Password
                        </label>

                        <!-- Toggle Eye Icon -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i data-lucide="eye" id="eye-icon" class="w-5 h-5"></i>
                        </button>

                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>





                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200">
                        Register
                    </button>
                </form>
            </div>
            <p class="text-sm mt-4 text-center text-gray-600">Already Registered? <span
                    class="text-green-500 underline "><a href="{{ route('login') }}"> Login Here</a></span></p>
        </div>

        <div class="hidden md:flex w-full md:w-[55%] relative flex-col justify-center items-center text-center px-10 py-24"
            style="background-image: url('{{ asset('assets/img/banner.webp') }}'); background-size: cover; background-position: center;">

            {{-- Overlay to darken the background image --}}
            <div class="absolute inset-0 bg-black opacity-50"></div> {{-- Adjust opacity-XX for desired darkness --}}

            {{-- Content on top of the darkened image --}}
            <span
                class="inline-block bg-white text-[#0f1c35] text-sm md:text-base font-semibold px-6 py-2 rounded-full mb-6 relative z-10">
                TPOS
            </span>

            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 relative z-10">Track. Record. Grow.</h2>

            <p class="max-w-2xl text-gray-300 text-base md:text-lg leading-relaxed px-4 relative z-10">
                Transform Your Business with T-POS | The complete point-of-sale solution designed to streamline your
                operations, boost sales, and grow your business.
            </p>

        </div>
    </div>

    @vite('resources/js/app.js')

</body>

</html>
