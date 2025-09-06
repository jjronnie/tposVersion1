<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - TPOS</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.webp') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#001529">
    <meta name="mobile-web-app-capable" content="yes">

    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#eafff6] flex flex-col">
    <!-- Preloader-->
    @include('layouts.preloader')
    <div class="flex flex-col md:flex-row min-h-screen w-full">
        <!-- Left: Login Form -->
        <div class="w-full md:w-[45%] bg-white flex flex-col justify-center px-6 py-12 sm:px-10">
            <div class="w-full max-w-md mx-auto px-10">
                <div class="md:hidden mb-2 mx-auto flex items-center justify-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Tpos Logo" class=" w-62 h-62 object-contain" />
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

                    <!-- Country Selection -->
                    <div class="relative mb-6">
                        <select id="country" name="country" required
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                            <option value="" disabled selected>--select--</option>

                            @foreach (countries() as $code => $country)
                                <option value="{{ $code }}">
                                    {{ $country }}
                                </option>
                            @endforeach

                        </select>
                        <label for="country"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Country
                        </label>
                        @error('country')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Password"
                            class="peer w-full px-4 pt-6 pb-2 rounded-lg border border-gray-300 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />

                        <label for="password"
                            class="absolute left-4 top-2 text-gray-600 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
                            Password
                        </label>

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
            <img src="{{ asset('assets/img/tpos1.png') }}" alt=" Logo" class="h-[210px] mb-0 relative z-10" />

            {{-- <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 relative z-10">Track. Record. Grow.</h2> --}}

            <p class="max-w-2xl text-gray-300 text-base md:text-lg leading-relaxed px-4 relative z-10">
                Transform Your Business with T-POS | The complete point-of-sale solution designed to streamline your
                operations, boost sales, and grow your business.
            </p>
        </div>
    </div>
    @vite('resources/js/app.js')
       <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
