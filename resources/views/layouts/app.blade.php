<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Registro de Piezas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @auth
    <!-- Navbar -->
    <nav class="bg-gray-900 border-b border-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-white font-semibold text-lg tracking-tight">
                            Sistema de Piezas
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-1">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-md transition">
                            Dashboard
                        </a>
                        
                        <a href="{{ route('proyectos.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('proyectos.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-md transition">
                            Proyectos
                        </a>
                        
                        <a href="{{ route('bloques.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('bloques.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-md transition">
                            Bloques
                        </a>
                        
                        <a href="{{ route('piezas.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('piezas.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-md transition">
                            Piezas
                        </a>
                        
                        <a href="{{ route('piezas.formulario') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('piezas.formulario') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-md transition">
                            Registrar Peso
                        </a>
                        
                        <a href="{{ route('piezas.reporte') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('piezas.reporte') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-md transition">
                            Reporte
                        </a>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300 text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md">Dashboard</a>
                <a href="{{ route('proyectos.index') }}" class="block px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md">Proyectos</a>
                <a href="{{ route('bloques.index') }}" class="block px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md">Bloques</a>
                <a href="{{ route('piezas.index') }}" class="block px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md">Piezas</a>
                <a href="{{ route('piezas.formulario') }}" class="block px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md">Registrar Peso</a>
                <a href="{{ route('piezas.reporte') }}" class="block px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800 rounded-md">Reporte</a>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Page Content -->
    <main class="py-6">
        @yield('content')
    </main>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-white border-l-4 border-green-500 text-gray-900 px-6 py-4 rounded-lg shadow-xl z-50 transform transition-all duration-300 animate-slide-in" id="flash-message">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-message');
                if(el) {
                    el.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(() => el.remove(), 300);
                }
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-white border-l-4 border-red-500 text-gray-900 px-6 py-4 rounded-lg shadow-xl z-50 transform transition-all duration-300 animate-slide-in" id="flash-error">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-error');
                if(el) {
                    el.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(() => el.remove(), 300);
                }
            }, 3000);
        </script>
    @endif

    <style>
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in { animation: slide-in 0.3s ease-out; }
    </style>
</body>
</html>
