@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full bg-white rounded-lg border border-gray-200 shadow-sm p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">Sistema de Piezas</h2>
            <p class="text-gray-500 mt-2 text-sm">Inicia sesión para continuar</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                    Email
                </label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                    Contraseña
                </label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2.5 px-4 rounded-md transition">
                Iniciar Sesión
            </button>
        </form>

        <!-- Credentials Info -->
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-md">
            <p class="text-xs text-gray-600 text-center font-medium">Usuarios de prueba:</p>
            <p class="text-xs text-gray-500 text-center mt-1">luis@example.com / 0000</p>
            <p class="text-xs text-gray-500 text-center">gabriel@example.com / 1111</p>
            <p class="text-xs text-gray-500 text-center">sergio@example.com / 2222</p>
        </div>
    </div>
</div>
@endsection
