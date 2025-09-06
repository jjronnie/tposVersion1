<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPOS: The Next-Gen POS Software</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.webp') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#001529">

    <meta name="mobile-web-app-capable" content="yes">
     @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d1117;
            color: #e2e8f0;
            line-height: 1.6;
        }

        .shining-text {
            background-image: linear-gradient(to right, #4ade80, #16a34a, #4ade80);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shine 2s linear infinite;
        }

        @keyframes shine {
            0% {
                background-position: -200%;
            }

            100% {
                background-position: 200%;
            }
        }

        .highlight-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-bg {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(30, 41, 59, 0.5);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1f2732, #10151a);
        }

        .hero-bg {
            background: linear-gradient(180deg, #1f2732, #10151a);
        }

        /* SVG Leaf Animation */
        .leaf-path {
            fill: none;
            stroke: url(#leafGradient);
            stroke-width: 2;
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: dash 10s linear forwards infinite;
        }

        .leaf-fill {
            fill: url(#leafGradient);
            animation: fillFadeIn 5s ease-in-out forwards;
            opacity: 0;
            transition: transform 0.5s ease-in-out;
        }

        .animated-leaf {
            animation: leafPulse 5s ease-in-out infinite alternate;
        }

        @keyframes dash {
            0% {
                stroke-dashoffset: 1000;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes fillFadeIn {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes leafPulse {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.05);
            }
        }

        /* Custom Feature Card styles */
        .feature-card {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .feature-card:hover .icon-bounce {
            animation: bounce 0.6s ease-in-out;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* FAQ styles */
        .faq-item input[type="checkbox"] {
            display: none;
        }

        .faq-item-label {
            cursor: pointer;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-item-label::after {
            content: '+';
            font-size: 2rem;
            transition: transform 0.3s ease;
        }

        .faq-item input[type="checkbox"]:checked~.faq-item-label::after {
            transform: rotate(45deg);
        }

        .faq-item-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding: 0 1.5rem;
        }

        .faq-item input[type="checkbox"]:checked~.faq-item-content {
            max-height: 500px;
            /* Large enough to accommodate content */
            padding-bottom: 1.5rem;
        }

        /* Pricing Toggle styles */
        .pricing-toggle {
            position: relative;
            background-color: #1f2732;
            border-radius: 9999px;
            padding: 4px;
            display: flex;
            transition: all 0.3s ease;
        }

        .pricing-toggle .toggle-active {
            position: absolute;
            height: calc(100% - 8px);
            width: 50%;
            background-color: #16a34a;
            border-radius: 9999px;
            transition: transform 0.3s ease;
            z-index: 0;
        }

        .pricing-toggle .toggle-button {
            position: relative;
            z-index: 1;
            flex: 1;
            text-align: center;
            padding: 8px 16px;
            cursor: pointer;
            transition: color 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 glass-bg py-4 px-6 md:px-12 rounded-b-3xl shadow-lg">
        <nav class="flex justify-between items-center max-w-7xl mx-auto">
            <a href="#" class="text-2xl font-bold text-green-400">TPOS</a>
            <div class="hidden md:flex items-center space-x-6">
                <a href="#features" class="text-gray-300 hover:text-green-400 transition">Features</a>
                <a href="#pricing" class="text-gray-300 hover:text-green-400 transition">Pricing</a>
                <a href="#faqs" class="text-gray-300 hover:text-green-400 transition">FAQs</a>
                <a href="#contact" class="text-gray-300 hover:text-green-400 transition">Contact</a>
            </div>
            <div class="flex items-center space-x-4">

                @guest
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-green-400 transition">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                        Register
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-2 bg-blue-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                        Dashboard</a>

                @endguest
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-bg relative py-16 md:py-32 px-4 overflow-hidden">
        <!-- SVG Leaf Animation -->
        <div class="absolute inset-0 z-0 opacity-20">
            <svg class="w-full h-full" viewBox="0 0 1000 500" preserveAspectRatio="xMidYMid slice">
                <defs>
                    <linearGradient id="leafGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#34d399;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#16a34a;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <g class="animated-leaf" transform="translate(100, 50)">
                    <path class="leaf-path"
                        d="M 250 250 C 200 150, 100 100, 50 200 C 0 300, 100 400, 250 350 C 400 300, 500 400, 550 300 C 600 200, 500 100, 450 150 Z" />
                    <path class="leaf-fill"
                        d="M 250 250 C 200 150, 100 100, 50 200 C 0 300, 100 400, 250 350 C 400 300, 500 400, 550 300 C 600 200, 500 100, 450 150 Z" />
                </g>
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight mb-4">
                <span class="block">Simplify Your Business with</span>
                <span class="block shining-text">TPOS: The Next-Gen POS</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto mb-8">
                Manage sales, track inventory, and grow your business with our intuitive, cloud-based Point of Sale
                software.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="#"
                    class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                    Start Free Trial
                </a>
                <a href="#"
                    class="px-8 py-3 bg-transparent border-2 border-green-500 hover:bg-green-500 text-green-300 hover:text-white font-semibold rounded-full transition duration-300 transform hover:scale-105">
                    Learn More
                </a>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="highlight-card p-6 rounded-2xl shadow-xl backdrop-filter backdrop-blur-sm">
                    <h3 class="text-3xl font-bold text-white mb-2">99.9%</h3>
                    <p class="text-gray-400">Uptime Guarantee</p>
                </div>
                <div class="highlight-card p-6 rounded-2xl shadow-xl backdrop-filter backdrop-blur-sm">
                    <h3 class="text-3xl font-bold text-white mb-2">5,000+</h3>
                    <p class="text-gray-400">Happy Businesses</p>
                </div>
                <div class="highlight-card p-6 rounded-2xl shadow-xl backdrop-filter backdrop-blur-sm">
                    <h3 class="text-3xl font-bold text-white mb-2">24/7</h3>
                    <p class="text-gray-400">Dedicated Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 md:px-8 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-green-400 mb-4">Everything You Need to Grow</h2>
            <p class="text-xl text-gray-400">Powerful features designed to streamline your business operations and drive
                growth.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 12l3-3m-3 3l-3-3m3 3v8m4-13h6m-6 4h6m6-4v6m0 0l-3 3m3-3l-3-3m0-3h6m0 4h6m0-4h6" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Real-time Analytics</h3>
                <p class="text-gray-300">Track sales, inventory, and customer data with comprehensive reporting and
                    insights.</p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m4 4V3m4 4V3m4 8V3m4 8V3M4 19v-4h6m-6 4h6" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Inventory Management</h3>
                <p class="text-gray-300">Automated stock tracking, low-stock alerts, and seamless supplier management.
                </p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4s-4 4-4 8 4 8 4 8 4-4 4-8-4-8-4-8zm0 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Customer Management</h3>
                <p class="text-gray-300">Build customer profiles, track purchase history, and create loyalty programs.
                </p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9l-4 4-4-4m4 4V3m12 0H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2z" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Payment Processing</h3>
                <p class="text-gray-300">Accept all payment methods with secure, fast transaction processing.</p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 2.21-1.79 4-4 4s-4-1.79-4-4 1.79-4 4-4 4 1.79 4 4z" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Security & Compliance</h3>
                <p class="text-gray-300">Enterprise-grade security with PCI compliance and data encryption.</p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 2.21-1.79 4-4 4s-4-1.79-4-4 1.79-4 4-4 4 1.79 4 4zM12 11v8m0-8h8m-8 0H4M20 19l-4-4m4 4l-4 4m-4-4l4-4m-4 4l-4 4" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Mobile Ready</h3>
                <p class="text-gray-300">Full mobile app support for on-the-go business management.</p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 2.21-1.79 4-4 4s-4-1.79-4-4 1.79-4 4-4 4 1.79 4 4zM12 11v8m0-8h8m-8 0H4M20 19l-4-4m4 4l-4 4m-4-4l4-4m-4 4l-4 4" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Multi-location</h3>
                <p class="text-gray-300">Manage multiple stores from one centralized dashboard.</p>
            </div>
            <div class="highlight-card p-8 rounded-2xl shadow-lg feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-400 icon-bounce"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 2.21-1.79 4-4 4s-4-1.79-4-4 1.79-4 4-4 4 1.79 4 4zM12 11v8m0-8h8m-8 0H4M20 19l-4-4m4 4l-4 4m-4-4l4-4m-4 4l-4 4" />
                </svg>
                <h3 class="text-2xl font-bold mb-2">Lightning Fast</h3>
                <p class="text-gray-300">Optimized for speed with 99.9% uptime guarantee.</p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 px-4 md:px-8 max-w-7xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-green-400 mb-4">Simple, Transparent Pricing</h2>
        <p class="text-xl text-gray-400 mb-8">Choose the perfect plan for your business. All plans include a 30-day
            free trial.</p>

        <div class="flex justify-center mb-10">
            <div class="pricing-toggle" id="pricing-toggle">
                <div class="toggle-active"></div>
                <div class="toggle-button" id="monthly-toggle">Monthly</div>
                <div class="toggle-button" id="annual-toggle">Annual (Save 20%)</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Starter Plan -->
            <div
                class="highlight-card p-8 rounded-2xl shadow-xl flex flex-col items-center text-center hover:scale-105 transition duration-300">
                <h3 class="text-2xl font-bold mb-2">Starter</h3>
                <p class="text-gray-400 mb-6">Perfect for small businesses just getting started.</p>
                <div class="text-5xl font-extrabold mb-4">
                    <span id="starter-price" class="text-green-400">$23</span>
                    <span class="text-xl text-gray-500 font-normal">/month</span>
                </div>
                <a href="#"
                    class="w-full px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300">
                    Start Free Trial
                </a>
                <ul class="text-left mt-6 space-y-2 text-gray-300 w-full">
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Up to 1,000
                            transactions/month</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Basic inventory
                            management</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Email
                            support</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Single
                            location</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Basic
                            reporting</span></li>
                </ul>
            </div>

            <!-- Professional Plan -->
            <div
                class="highlight-card p-8 rounded-2xl shadow-xl flex flex-col items-center text-center border-4 border-green-500 hover:scale-105 transition duration-300 relative">
                <span
                    class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Most
                    Popular</span>
                <h3 class="text-2xl font-bold mb-2">Professional</h3>
                <p class="text-gray-400 mb-6">Ideal for growing businesses with advanced needs.</p>
                <div class="text-5xl font-extrabold mb-4">
                    <span id="professional-price" class="text-green-400">$63</span>
                    <span class="text-xl text-gray-500 font-normal">/month</span>
                </div>
                <a href="#"
                    class="w-full px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300">
                    Start Free Trial
                </a>
                <ul class="text-left mt-6 space-y-2 text-gray-300 w-full">
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Up to 10,000
                            transactions/month</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Advanced
                            inventory management</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Priority
                            support</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Up to 3
                            locations</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Advanced
                            analytics</span></li>
                </ul>
            </div>

            <!-- Enterprise Plan -->
            <div
                class="highlight-card p-8 rounded-2xl shadow-xl flex flex-col items-center text-center hover:scale-105 transition duration-300">
                <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                <p class="text-gray-400 mb-6">For large businesses requiring full customization.</p>
                <div class="text-5xl font-extrabold mb-4">
                    <span id="enterprise-price" class="text-green-400">$159</span>
                    <span class="text-xl text-gray-500 font-normal">/month</span>
                </div>
                <a href="#"
                    class="w-full px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300">
                    Contact Sales
                </a>
                <ul class="text-left mt-6 space-y-2 text-gray-300 w-full">
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Unlimited
                            transactions</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Full inventory
                            suite</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>24/7 phone
                            support</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Unlimited
                            locations</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Custom
                            reporting</span></li>
                </ul>
            </div>

            <!-- One-Time Purchase Plan -->
            <div
                class="highlight-card p-8 rounded-2xl shadow-xl flex flex-col items-center text-center hover:scale-105 transition duration-300">
                <h3 class="text-2xl font-bold mb-2">One-Time Purchase</h3>
                <p class="text-gray-400 mb-6">Complete ownership with lifetime access.</p>
                <div class="text-5xl font-extrabold mb-4">
                    <span id="onetime-price" class="text-green-400">$500</span>
                    <span class="text-xl text-gray-500 font-normal">/one-time</span>
                </div>
                <a href="#"
                    class="w-full px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300">
                    Purchase Now
                </a>
                <ul class="text-left mt-6 space-y-2 text-gray-300 w-full">
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Everything in
                            Professional</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Lifetime
                            license</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>No monthly
                            fees</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Source code
                            access</span></li>
                    <li class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Custom
                            modifications</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Get Started Section -->
    <section class="py-20 px-4 md:px-8 max-w-7xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-green-400 mb-4">Get Started in 3 Simple Steps</h2>
        <p class="text-xl text-gray-400 max-w-3xl mx-auto mb-16">Join thousands of successful businesses using T-POS to
            streamline operations and boost sales.</p>
        <div class="flex flex-col md:flex-row justify-between items-start md:space-x-12 space-y-12 md:space-y-0">
            <div class="flex-1 flex flex-col items-center text-center">
                <div class="relative w-24 h-24 mb-4 flex items-center justify-center">
                    <div class="w-full h-full rounded-full bg-blue-500 opacity-20 animate-pulse"></div>
                    <div class="absolute w-16 h-16 rounded-full bg-blue-500 opacity-40"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute h-10 w-10 text-blue-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.418 0-8 4-8 8h16c0-4-3.582-8-8-8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold">Sign Up</h3>
                <p class="text-gray-300">Create your free account in under 2 minutes.</p>
            </div>
            <div class="flex-1 flex flex-col items-center text-center">
                <div class="relative w-24 h-24 mb-4 flex items-center justify-center">
                    <div class="w-full h-full rounded-full bg-green-500 opacity-20 animate-pulse"></div>
                    <div class="absolute w-16 h-16 rounded-full bg-green-500 opacity-40"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute h-10 w-10 text-green-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.941 3.31 1.353 2.89 2.706a1.724 1.724 0 00-1.81 2.928c1.543.941 3.31-1.353 2.89-2.706a1.724 1.724 0 001.81-2.928z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0 2.21-1.79 4-4 4s-4-1.79-4-4 1.79-4 4-4 4 1.79 4 4z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold">Setup Business</h3>
                <p class="text-gray-300">Configure your business preferences and settings.</p>
            </div>
            <div class="flex-1 flex flex-col items-center text-center">
                <div class="relative w-24 h-24 mb-4 flex items-center justify-center">
                    <div class="w-full h-full rounded-full bg-purple-500 opacity-20 animate-pulse"></div>
                    <div class="absolute w-16 h-16 rounded-full bg-purple-500 opacity-40"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute h-10 w-10 text-purple-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold">Start Selling</h3>
                <p class="text-gray-300">Begin processing sales and growing your business.</p>
            </div>
        </div>
        <div class="mt-16 bg-gray-800 p-8 rounded-2xl max-w-4xl mx-auto shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center text-lg">
                <div>
                    <h4 class="font-bold text-green-400">No Setup Fees</h4>
                    <p class="text-gray-400 text-sm">Get started immediately</p>
                </div>
                <div>
                    <h4 class="font-bold text-green-400">30-Day Free Trial</h4>
                    <p class="text-gray-400 text-sm">Full access, no commitment</p>
                </div>
                <div>
                    <h4 class="font-bold text-green-400">24/7 Support</h4>
                    <p class="text-gray-400 text-sm">Expert help when needed</p>
                </div>
                <div>
                    <h4 class="font-bold text-green-400">Cancel Anytime</h4>
                    <p class="text-gray-400 text-sm">No long-term contracts</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section id="faqs" class="py-20 px-4 md:px-8 max-w-5xl mx-auto">
        <h2 class="text-4xl font-extrabold text-green-400 text-center mb-12">Frequently Asked Questions</h2>
        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div class="faq-item highlight-card rounded-xl">
                <input type="checkbox" id="faq1" name="faq">
                <label for="faq1" class="faq-item-label font-semibold text-lg">
                    Is TPOS compatible with my existing hardware?
                </label>
                <div class="faq-item-content">
                    <p class="text-gray-300">TPOS is a cloud-based software, so it's compatible with most modern
                        hardware, including PCs, tablets, and smartphones. It supports a wide range of receipt printers,
                        barcode scanners, and cash drawers.</p>
                </div>
            </div>
            <!-- FAQ Item 2 -->
            <div class="faq-item highlight-card rounded-xl">
                <input type="checkbox" id="faq2" name="faq">
                <label for="faq2" class="faq-item-label font-semibold text-lg">
                    How secure is my data with TPOS?
                </label>
                <div class="faq-item-content">
                    <p class="text-gray-300">We prioritize your data security with enterprise-grade encryption and PCI
                        compliance. All data is backed up to secure cloud servers, ensuring your information is safe and
                        accessible only to you.</p>
                </div>
            </div>
            <!-- FAQ Item 3 -->
            <div class="faq-item highlight-card rounded-xl">
                <input type="checkbox" id="faq3" name="faq">
                <label for="faq3" class="faq-item-label font-semibold text-lg">
                    Do I need to be a tech expert to use TPOS?
                </label>
                <div class="faq-item-content">
                    <p class="text-gray-300">Not at all! TPOS is designed to be intuitive and easy to use. Our simple
                        interface and 24/7 support team ensure you can get started quickly and get help whenever you
                        need it.</p>
                </div>
            </div>
            <!-- FAQ Item 4 -->
            <div class="faq-item highlight-card rounded-xl">
                <input type="checkbox" id="faq4" name="faq">
                <label for="faq4" class="faq-item-label font-semibold text-lg">
                    Can I use TPOS for multiple business locations?
                </label>
                <div class="faq-item-content">
                    <p class="text-gray-300">Yes, our multi-location feature allows you to manage all your stores from
                        one centralized dashboard. Track sales, manage inventory, and monitor employee performance
                        across all locations with ease.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 px-4 md:px-8 gradient-bg rounded-t-3xl text-center shadow-2xl">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-extrabold mb-4">Get In Touch</h2>
            <p class="text-lg text-gray-300 mb-8">
                Have questions or need a custom plan? Our team is ready to help.
            </p>
            <div class="bg-gray-800 p-8 rounded-2xl shadow-xl text-left">
                <form class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                        <input type="text" id="name" name="name"
                            class="mt-1 block w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300">Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="mt-1 block w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="px-12 py-4 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-lg transition duration-300 transform hover:scale-105 text-lg">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
            <div class="mt-12 text-gray-400 space-y-2">
                <p><strong class="text-white">Email:</strong> info@tpos.com</p>
                <p><strong class="text-white">Phone:</strong> +1 (555) 123-4567</p>
                <p><strong class="text-white">Address:</strong> 123 Business Way, Suite 100, Business City, BS 12345
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-10 px-4 md:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">TPOS</h3>
                <p class="text-sm">TPOS is the leading cloud-based Point of Sale solution designed for modern
                    businesses.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="#features" class="hover:text-green-400 transition">Features</a></li>
                    <li><a href="#pricing" class="hover:text-green-400 transition">Pricing</a></li>
                    <li><a href="#faqs" class="hover:text-green-400 transition">FAQs</a></li>
                    <li><a href="#contact" class="hover:text-green-400 transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">Services</h3>
                <ul class="space-y-2">
                    <li><a href="https://services.thetechtower.com" target="_blank" rel="noopener noreferrer"
                            class="hover:text-green-400 transition">Web Design</a></li>
                    <li><a href="https://services.thetechtower.com" target="_blank" rel="noopener noreferrer"
                            class="hover:text-green-400 transition">Mobile Development</a></li>
                    <li><a href="https://services.thetechtower.com" target="_blank" rel="noopener noreferrer"
                            class="hover:text-green-400 transition">SEO & Marketing</a></li>
                    <li><a href="https://services.thetechtower.com" target="_blank" rel="noopener noreferrer"
                            class="hover:text-green-400 transition">Cloud Solutions</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">Contact</h3>
                <p class="text-sm">123 Business Way, Suite 100</p>
                <p class="text-sm">Business City, BS 12345</p>
                <p class="text-sm">info@tpos.com</p>
                <p class="text-sm">+1 (555) 123-4567</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">Legal</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-green-400 transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-green-400 transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-10 pt-6 border-t border-gray-700 text-center text-sm">
            <p>&copy; 2024 TPOS. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pricingToggle = document.getElementById('pricing-toggle');
            const monthlyToggle = document.getElementById('monthly-toggle');
            const annualToggle = document.getElementById('annual-toggle');

            const starterPrice = document.getElementById('starter-price');
            const professionalPrice = document.getElementById('professional-price');
            const enterprisePrice = document.getElementById('enterprise-price');

            // Set initial state to monthly
            monthlyToggle.classList.add('font-bold', 'text-white');
            annualToggle.classList.remove('font-bold', 'text-white');

            pricingToggle.style.transform = `translateX(0)`;

            monthlyToggle.addEventListener('click', () => {
                pricingToggle.querySelector('.toggle-active').style.transform = 'translateX(0)';
                monthlyToggle.classList.add('font-bold', 'text-white');
                annualToggle.classList.remove('font-bold', 'text-white');

                starterPrice.textContent = '$23';
                professionalPrice.textContent = '$63';
                enterprisePrice.textContent = '$159';
            });

            annualToggle.addEventListener('click', () => {
                pricingToggle.querySelector('.toggle-active').style.transform = 'translateX(100%)';
                annualToggle.classList.add('font-bold', 'text-white');
                monthlyToggle.classList.remove('font-bold', 'text-white');

                starterPrice.textContent = '$18';
                professionalPrice.textContent = '$50';
                enterprisePrice.textContent = '$127';
            });
        });

        // FAQ accordion logic
        document.querySelectorAll('.faq-item input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    document.querySelectorAll('.faq-item input[type="checkbox"]').forEach(otherCheckbox => {
                        if (otherCheckbox !== checkbox) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });
    </script>
     @vite('resources/js/app.js')
        <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
