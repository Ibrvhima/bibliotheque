<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Bibliothèque') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col">
            @if (Route::has('login'))
                <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex items-center">
                                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ config('app.name', 'Bibliothèque') }}
                                </h1>
                            </div>

                            <div class="flex items-center space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                        Connexion
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Inscription
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </nav>
            @endif

            <main class="flex-grow">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            Bienvenue dans votre Bibliothèque
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                            Gérez vos livres, emprunts et découvrez de nouvelles lectures
                        </p>

                        @guest
                            <div class="space-x-4">
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                    Se connecter
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                        Créer un compte
                                    </a>
                                @endif
                            </div>
                        @else
                            <a href="{{ url('/dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                Accéder au Dashboard
                            </a>
                        @endguest
                    </div>

                    <!-- Features -->
                    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                            <div class="text-blue-600 text-4xl mb-4">📚</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Catalogue</h3>
                            <p class="text-gray-600 dark:text-gray-300">Parcourez notre collection complète de livres</p>
                        </div>

                        <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                            <div class="text-green-600 text-4xl mb-4">📖</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Emprunts</h3>
                            <p class="text-gray-600 dark:text-gray-300">Gérez vos emprunts en quelques clics</p>
                        </div>

                        <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                            <div class="text-purple-600 text-4xl mb-4">📊</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Statistiques</h3>
                            <p class="text-gray-600 dark:text-gray-300">Suivez l'activité de la bibliothèque</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
