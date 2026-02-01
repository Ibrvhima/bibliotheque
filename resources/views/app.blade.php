<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bibliothèque')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        // Dark mode configuration
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#1a1a1a',
                            card: '#2d2d2d',
                            text: '#e5e5e5'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        .modal-content {
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .dark {
            background-color: #1a1a1a;
            color: #e5e5e5;
        }
        .dark .bg-white {
            background-color: #2d2d2d !important;
        }
        .dark .bg-gray-50 {
            background-color: #1a1a1a !important;
        }
        .dark .text-gray-900 {
            color: #e5e5e5 !important;
        }
        .dark .text-gray-600 {
            color: #a0a0a0 !important;
        }
        .dark .text-gray-500 {
            color: #888888 !important;
        }
        .dark .border-gray-200 {
            border-color: #404040 !important;
        }
        .dark .border-gray-300 {
            border-color: #404040 !important;
        }
        .dark .hover\:bg-gray-50:hover {
            background-color: #2d2d2d !important;
        }
        .dark .shadow {
            box-shadow: 0 1px 3px 0 rgba(255, 255, 255, 0.1) !important;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        
        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-slate-700 to-slate-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Mobile menu button (gauche) -->
                <div class="md:hidden flex items-center">
                    @auth
                        <button onclick="toggleMobileMenu()" class="text-white hover:bg-slate-600 p-2 rounded-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    @endauth
                </div>

                <!-- Logo centré sur mobile, à gauche sur desktop -->
                <div class="flex-1 flex items-center justify-center md:justify-start md:flex-none">
                    <div class="flex-shrink-0 flex items-center">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 md:space-x-3">
                                    <img src="/images/logo-bubo-icon-pro.svg" alt="B-UBO" class="h-8 w-8">
                                    <span class="text-xl md:text-2xl font-bold text-white">B-UBO</span>
                                </a>
                            @elseif(auth()->user()->isBibliothecaire())
                                <a href="{{ route('bibliothecaire.dashboard') }}" class="flex items-center space-x-2 md:space-x-3">
                                    <img src="/images/logo-bubo-icon-pro.svg" alt="B-UBO" class="h-8 w-8">
                                    <span class="text-xl md:text-2xl font-bold text-white">B-UBO</span>
                                </a>
                            @else
                                <a href="{{ route('lecteur.catalogue') }}" class="flex items-center space-x-2 md:space-x-3">
                                    <img src="/images/logo-bubo-icon-pro.svg" alt="B-UBO" class="h-8 w-8">
                                    <span class="text-xl md:text-2xl font-bold text-white">B-UBO</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="flex items-center space-x-2 md:space-x-3">
                                <img src="/images/logo-bubo-icon-pro.svg" alt="B-UBO" class="h-8 w-8">
                                <span class="text-xl md:text-2xl font-bold text-white">B-UBO</span>
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Navigation Desktop -->
                <div class="hidden md:flex items-center space-x-1">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Utilisateurs
                            </a>
                            <a href="{{ route('admin.statistiques') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Statistiques
                            </a>
                            <!-- Séparateur -->
                            <div class="border-l border-gray-600 h-6 mx-2"></div>
                            <!-- Fonctionnalités Bibliothécaire -->
                            <a href="{{ route('bibliothecaire.livres.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Livres
                            </a>
                            <a href="{{ route('bibliothecaire.emprunts.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Emprunts
                            </a>
                            <a href="{{ route('bibliothecaire.categories.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 002.828 0l-7-7A1.994 1.994 0 003 12V7a4 4 0 00-4-4z"></path>
                                </svg>
                                Catégories
                            </a>
                            <a href="{{ route('bibliothecaire.auteurs.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Auteurs
                            </a>
                        @elseif(auth()->user()->isBibliothecaire())
                            <a href="{{ route('bibliothecaire.dashboard') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('bibliothecaire.livres.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Livres
                            </a>
                            <a href="{{ route('bibliothecaire.emprunts.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Emprunts
                            </a>
                            <a href="{{ route('bibliothecaire.categories.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 002.828 0l-7-7A1.994 1.994 0 003 12V7a4 4 0 00-4-4z"></path>
                                </svg>
                                Catégories
                            </a>
                            <a href="{{ route('bibliothecaire.auteurs.index') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Auteurs
                            </a>
                        @else
                            <a href="{{ route('lecteur.catalogue') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Catalogue
                            </a>
                            <a href="{{ route('lecteur.emprunts') }}" class="text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Mes emprunts
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- User Menu (droite) -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="text-white hover:bg-slate-600 p-2 rounded-md transition-all duration-200" title="Basculer mode sombre/clair">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    
                    @auth
                        <div class="relative">
                            <button onclick="toggleUserMenu()" class="flex items-center text-white hover:bg-slate-600 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="hidden md:block">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->login }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:bg-slate-600 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu" class="hidden bg-slate-800 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Admin
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-users mr-2"></i>Utilisateurs
                    </a>
                    <a href="{{ route('admin.statistiques') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-chart-bar mr-2"></i>Statistiques
                    </a>
                    <!-- Séparateur -->
                    <div class="border-t border-gray-600 my-2"></div>
                    <!-- Fonctionnalités Bibliothécaire -->
                    <a href="{{ route('bibliothecaire.livres.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-book mr-2"></i>Livres
                    </a>
                    <a href="{{ route('bibliothecaire.emprunts.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-clipboard-list mr-2"></i>Emprunts
                    </a>
                    <a href="{{ route('bibliothecaire.categories.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-tag mr-2"></i>Catégories
                    </a>
                    <a href="{{ route('bibliothecaire.auteurs.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-user-edit mr-2"></i>Auteurs
                    </a>
                @elseif(auth()->user()->isBibliothecaire())
                    <a href="{{ route('bibliothecaire.dashboard') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('bibliothecaire.livres.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-book mr-2"></i>Livres
                    </a>
                    <a href="{{ route('bibliothecaire.emprunts.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-clipboard-list mr-2"></i>Emprunts
                    </a>
                    <a href="{{ route('bibliothecaire.categories.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-tag mr-2"></i>Catégories
                    </a>
                    <a href="{{ route('bibliothecaire.auteurs.index') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-user-edit mr-2"></i>Auteurs
                    </a>
                @else
                    <a href="{{ route('lecteur.catalogue') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-book mr-2"></i>Catalogue
                    </a>
                    <a href="{{ route('lecteur.emprunts') }}" class="text-white hover:bg-slate-700 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-clipboard-list mr-2"></i>Mes emprunts
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Messages flash -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('footer')

    <!-- Modal de confirmation -->
    <div id="confirmModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-backdrop fixed inset-0"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 text-center mb-2" id="modalTitle">Confirmation</h3>
                    <p class="text-sm text-gray-500 text-center mb-6" id="modalMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
                    
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeConfirmModal()" 
                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">
                            Annuler
                        </button>
                        <button type="button" id="confirmButton" 
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showConfirmModal(title, message, onConfirm) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('confirmModal').classList.remove('hidden');
            
            const confirmBtn = document.getElementById('confirmButton');
            confirmBtn.onclick = function() {
                onConfirm();
                closeConfirmModal();
            };
        }
        
        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
        
        // Fermer la modale en cliquant sur le backdrop
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this || e.target.classList.contains('modal-backdrop')) {
                closeConfirmModal();
            }
        });

        // Menu utilisateur
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Menu mobile
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const isHidden = menu.classList.contains('hidden');
            
            if (isHidden) {
                menu.classList.remove('hidden');
                console.log('Menu mobile ouvert');
            } else {
                menu.classList.add('hidden');
                console.log('Menu mobile fermé');
            }
        }

        // Fermer les menus en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const mobileMenu = document.getElementById('mobileMenu');
            const userMenuButton = event.target.closest('button[onclick="toggleUserMenu()"]');
            const mobileMenuButton = event.target.closest('button[onclick="toggleMobileMenu()"]');
            
            // Fermer le menu utilisateur si clic extérieur
            if (!userMenuButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
            
            // Fermer le menu mobile si clic extérieur
            if (!mobileMenuButton && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Debug : vérifier que les éléments existent au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuButton = document.querySelector('button[onclick="toggleMobileMenu()"]');
            
            console.log('Menu mobile trouvé:', mobileMenu);
            console.log('Bouton menu mobile trouvé:', mobileMenuButton);
            
            if (!mobileMenu) {
                console.error('Menu mobile non trouvé!');
            }
            if (!mobileMenuButton) {
                console.error('Bouton menu mobile non trouvé!');
            }
        });
    </script>
</body>
</html>
