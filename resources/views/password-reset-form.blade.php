<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - {{ config('app.name') }}</title>
    
    <!-- Filament Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Colores de Filament */
        :root {
            --primary-50: 238 242 255;
            --primary-400: 129 140 248;
            --primary-500: 99 102 241;
            --primary-600: 79 70 229;
            --primary-900: 49 46 129;
            
            --danger-50: 254 242 242;
            --danger-400: 248 113 113;
            --danger-600: 220 38 38;
            --danger-700: 185 28 28;
            --danger-800: 153 27 27;
        }
        
        .fi-color-primary {
            --c-400: var(--primary-400);
            --c-500: var(--primary-500);
            --c-600: var(--primary-600);
        }
        
        /* Botón estilo Filament */
        .fi-btn {
            --c-400: var(--primary-400);
            --c-500: var(--primary-500);
            --c-600: var(--primary-600);
        }
        
        .fi-input-wrapper-focus-within {
            border-color: rgb(var(--primary-600));
            box-shadow: 0 0 0 1px rgb(var(--primary-600));
        }
        
        body { 
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: 'rgb(var(--primary-50) / <alpha-value>)',
                            400: 'rgb(var(--primary-400) / <alpha-value>)',
                            500: 'rgb(var(--primary-500) / <alpha-value>)',
                            600: 'rgb(var(--primary-600) / <alpha-value>)',
                            900: 'rgb(var(--primary-900) / <alpha-value>)'
                        },
                        danger: {
                            50: 'rgb(var(--danger-50) / <alpha-value>)',
                            400: 'rgb(var(--danger-400) / <alpha-value>)',
                            600: 'rgb(var(--danger-600) / <alpha-value>)',
                            700: 'rgb(var(--danger-700) / <alpha-value>)',
                            800: 'rgb(var(--danger-800) / <alpha-value>)'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full bg-gray-50">
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo/Icon área -->
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-xl bg-primary-600">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                Restablecer contraseña
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ingresa tu nueva contraseña para continuar
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10">
                
                <!-- Errores al estilo Filament -->
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-danger-50 p-4 ring-1 ring-danger-600/20">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-danger-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-danger-800">
                                    Se encontraron algunos errores:
                                </h3>
                                <div class="mt-2 text-sm text-danger-700">
                                    <ul class="list-disc space-y-1 pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('custom.password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <!-- Campo Email (estilo Filament) -->
                    <div class="fi-color-primary">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo electrónico
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ $email }}" 
                                readonly
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-500 shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-primary-600 disabled:cursor-not-allowed disabled:bg-gray-50"
                            >
                        </div>
                    </div>

                    <!-- Campo Nueva Contraseña (estilo Filament) -->
                    <div class="fi-color-primary">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nueva contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="block w-full rounded-lg border-gray-300 px-3 py-2 text-sm shadow-sm placeholder:text-gray-400 focus:border-primary-600 focus:ring-1 focus:ring-primary-600 @error('password') border-danger-600 focus:border-danger-600 focus:ring-danger-600 @enderror"
                                placeholder="Ingresa tu nueva contraseña"
                            >
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo Confirmar Contraseña (estilo Filament) -->
                    <div class="fi-color-primary">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                                class="block w-full rounded-lg border-gray-300 px-3 py-2 text-sm shadow-sm placeholder:text-gray-400 focus:border-primary-600 focus:ring-1 focus:ring-primary-600"
                                placeholder="Confirma tu nueva contraseña"
                            >
                        </div>
                    </div>

                    <!-- Botón Submit (estilo Filament) -->
                    <div>
                        <button 
                            type="submit" 
                            class="fi-btn flex w-full justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors duration-75 hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 disabled:pointer-events-none disabled:opacity-70"
                        >
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Restablecer contraseña
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Link de regreso (estilo Filament) -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-2 text-gray-500">¿Ya tienes acceso?</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a 
                            href="/admin/login" 
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 transition-colors duration-75 hover:text-primary-500"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para mejorar la experiencia del usuario -->
    <script>
        // Auto-focus al primer campo de contraseña
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            if (passwordField) {
                passwordField.focus();
            }
        });
        
        // Validación en tiempo real
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        function validatePasswordMatch() {
            if (password.value && passwordConfirmation.value) {
                if (password.value !== passwordConfirmation.value) {
                    passwordConfirmation.setCustomValidity('Las contraseñas no coinciden');
                } else {
                    passwordConfirmation.setCustomValidity('');
                }
            }
        }
        
        password.addEventListener('input', validatePasswordMatch);
        passwordConfirmation.addEventListener('input', validatePasswordMatch);
    </script>
</body>
</html>