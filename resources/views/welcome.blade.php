<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <title>Arrow Security Systems HRMS</title>
    <link rel="icon" href="favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')
    
</head>

<body class="bg-[#eafff6] text-white">

    <!-- Main Container -->
    <div class=" bg-gradient-to-r from-[#0F1C35] to-blue-900 min-h-screen flex flex-col justify-between relative overflow-hidden shadow-2xl">

        <!-- Header -->
        <!-- Header -->
        {{-- <header class="relative z-10 flex items-center justify-between px-6 py-4">
            <div class="text-white text-lg font-bold">
                <a href="https://arrowsecurity.ug/" target="_blank" rel="noreferrer nofollow"
                    class="text-sm text-white  hover:underline px-4 py-2 rounded-md">Visit Our Website</a>
            </div>

        </header> --}}
        <!-- Hero Section -->
        <section class="relative z-10 flex-1 flex flex-col justify-center items-center text-center px-4 py-16 md:py-28">

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight mb-6 max-w-4xl">
                Arrow Security Systems e-HRMS
            </h1>
            <span class="inline-block bg-white text-[#0f1c35] text-sm font-semibold px-4 py-1 rounded-full mb-4">We've
                got you covered</span>


            <p class="text-lg text-gray-300 max-w-2xl mb-10">This system is designed exclusively for Arrow Security
                Systems personnel. </p>



            <div class="flex flex-wrap justify-center gap-4 mt-8">
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-md font-semibold text-sm">Login</a>

                         <a href="{{ route('register') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-md font-semibold text-sm">Create account</a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold text-sm">Go to
                        Dashboard</a>
                @endguest


            </div>



        </section>

      



        <!-- Footer -->
        <footer class="relative z-10 bg-[#0c1629] text-gray-400 text-center py-6 px-4">
            <p class="text-sm">&copy; {{ now()->year }} Arrow Security Systems Ltd. All rights reserved.</p>
        </footer>

    </div>

</body>

</html>
