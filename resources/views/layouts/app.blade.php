<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 500: '#3b82f6', 600: '#2563eb', 900: '#1e3a8a' },
                        secondary: { 500: '#6b7280', 600: '#4b5563' },
                        success: { 500: '#10b981', 600: '#059669' },
                        danger: { 500: '#ef4444', 600: '#dc2626' },
                        'pos-blue': '#1e40af',
                        'pos-green': '#059669',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'pulse-slow': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

    <style>
        .navbar-gradient { 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); 
        }
        .dropdown-hover:hover .dropdown-menu { opacity: 1; transform: translateY(0); visibility: visible; }
        .dropdown-menu { opacity: 0; transform: translateY(-10px); visibility: hidden; transition: all 0.3s; }
        .alert-pulse { animation: pulse-slow 2s infinite; }
    </style>
</head>

<body class="bg-gray-50 antialiased transition-colors duration-300">
    <div id="app">

        <!-- Navbar -->
        <nav class="navbar-gradient navbar-shadow border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">

                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">POS ARTDEVATA</a>
                    </div>

                    <div class="flex items-center space-x-4">

                        <!-- Desktop Menu -->
                      <div class="hidden md:flex items-center space-x-6">
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('products.index') }}" class="relative text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 group">
                Produk
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary rounded opacity-0 group-hover:opacity-100 transition-opacity"></span>
            </a>
            <a href="{{ route('categories.index') }}" class="relative text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 group">
                Kategori
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary rounded opacity-0 group-hover:opacity-100 transition-opacity"></span>
            </a>
            <a href="{{ route('users.index') }}" class="relative text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 group">
                Kasir
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary rounded opacity-0 group-hover:opacity-100 transition-opacity"></span>
            </a>
            <a href="{{ route('sales.index') }}" class="relative text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 group">
                Penjualan
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary rounded opacity-0 group-hover:opacity-100 transition-opacity"></span>
            </a>
        @endif
        <a href="{{ route('pos.index') }}" class="relative bg-pos-green text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 hover:bg-pos-green/90 shadow-md">
            POS
            <span class="absolute inset-0 bg-pos-green opacity-0 hover:opacity-100 transition-opacity rounded-lg"></span>
        </a>
    @endauth
</div>

                        <div class="flex items-center space-x-4">

                            @auth
                                <div class="relative dropdown-hover">
                                    <button class="flex items-center space-x-2 text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>

                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded-full">
                                            ({{ ucfirst(Auth::user()->role) }})
                                        </span>

                                        <svg class="w-4 h-4" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 dropdown-menu border border-gray-200">
                                        <div class="px-4 py-2 border-b border-gray-200">
                                            <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                                        </div>

                                        <a href="{{ route('logout') }}"
                                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </a>
                                    </div>
                                </div>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>

                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">Login</a>
                               
                            @endauth

                        </div>
                    </div>

                    <!-- Mobile Button -->
                    <div class="md:hidden flex items-center">
                        <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-primary p-2 rounded-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
    <div class="px-2 pt-2 pb-3 space-y-1">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-primary px-3 py-2 rounded-md text-base font-medium transition-colors">Produk</a>
                <a href="{{ route('categories.index') }}" class="block text-gray-700 hover:text-primary px-3 py-2 rounded-md text-base font-medium transition-colors">Kategori</a>
                <a href="{{ route('users.index') }}" class="block text-gray-700 hover:text-primary px-3 py-2 rounded-md text-base font-medium transition-colors">Kasir</a>
                <a href="{{ route('sales.index') }}" class="block text-gray-700 hover:text-primary px-3 py-2 rounded-md text-base font-medium transition-colors">Penjualan</a>
            @endif
            <a href="{{ route('pos.index') }}" class="block bg-pos-green text-white px-3 py-2 rounded-md text-base font-medium transition-colors">POS</a>
        @endauth
    </div>
</div>

        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4">
            @yield('content')
        </main>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>

    @stack('scripts')
</body>
</html>
