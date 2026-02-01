<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bibliothèque Universitaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .slide-in-left {
            animation: slideInLeft 1s ease-out;
        }
        
        .slide-in-right {
            animation: slideInRight 1s ease-out;
        }
        
        .pulse-animation {
            animation: pulse 3s ease-in-out infinite;
        }
        
        .glass-morphism {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #E0E7FF 0%, #C7D2FE 100%);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .shape-decoration {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            filter: blur(40px);
        }
        
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg overflow-hidden">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="mx-auto w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl mb-4 pulse-animation">
                    <span class="text-2xl">📚</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Bibliothèque</h2>
                <p class="text-base text-gray-600">Universitaire</p>
            </div>

        <!-- Messages d'alerte -->
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-2xl shadow-lg fade-in mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-700 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-2xl shadow-lg fade-in mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

                    <!-- Formulaire de connexion -->
        <form id="loginForm" class="space-y-6" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="glass-morphism rounded-3xl shadow-xl p-8 space-y-6">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">
                        Bon retour
                    </h3>
                    <p class="text-gray-600">
                        Connectez-vous pour accéder à votre espace
                    </p>
                </div>
                
                <!-- Champ Login -->
                <div>
                    <label for="login" class="block text-xs font-medium text-gray-700 mb-1">
                        Login / Matricule
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <input 
                            id="login" 
                            name="login" 
                            type="text" 
                            required 
                            class="input-field appearance-none block w-full pl-7 pr-2 py-1.5 border border-gray-200 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent bg-white/80 text-xs" 
                            placeholder="ex: ETU202401"
                            value="{{ old('login') }}"
                        >
                    </div>
                    @error('login')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Mot de passe -->
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="input-field appearance-none block w-full pl-7 pr-6 py-1.5 border border-gray-200 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent bg-white/80 text-xs" 
                            placeholder="••••••••"
                        >
                        <a href="#" onclick="document.getElementById('loginForm').style.display='none'; document.getElementById('registerForm').style.display='block'; return false;" class="text-purple-600 font-semibold hover:text-purple-700 hover:underline transition-colors">Créer votre compte lecteur</a>
                </div>
            </div>
        </form>

        <!-- Formulaire d'inscription lecteur (caché par défaut) -->
        <form id="registerForm" class="space-y-6 hidden" action="{{ route('register.post') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="Rlecteur">
            <div class="glass-morphism rounded-3xl shadow-xl p-8 space-y-6">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">
                        Devenir lecteur
                    </h3>
                    <p class="text-gray-600">
                        Créez votre compte pour accéder à la bibliothèque
                    </p>
                </div>
                
                <!-- Champs Nom et Prénom -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input 
                                id="nom" 
                                name="nom" 
                                type="text" 
                                required 
                                class="input-field appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80 text-sm" 
                                placeholder="Votre nom"
                                value="{{ old('nom') }}"
                            >
                        </div>
                        @error('nom')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                            Prénom
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input 
                                id="prenom" 
                                name="prenom" 
                                type="text" 
                                required 
                                class="input-field appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80 text-sm" 
                                placeholder="Votre prénom"
                                value="{{ old('prenom') }}"
                            >
                        </div>
                        @error('prenom')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Champ Login -->
                <div>
                    <label for="register_login" class="block text-sm font-medium text-gray-700 mb-1">
                        Login / Matricule
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <input 
                            id="register_login" 
                            name="login" 
                            type="text" 
                            required 
                            class="input-field appearance-none block w-full pl-12 pr-4 py-2 border border-gray-200 rounded-2xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80 text-sm" 
                            placeholder="ex: ETU202401"
                            value="{{ old('login') }}"
                        >
                    </div>
                    @error('login')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email (optionnel)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            class="input-field appearance-none block w-full pl-12 pr-4 py-2 border border-gray-200 rounded-2xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80 text-sm" 
                            placeholder="votre.email@example.com"
                            value="{{ old('email') }}"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champs Mot de passe -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                id="register_password" 
                                name="password" 
                                type="password" 
                                required 
                                class="input-field appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80 text-sm" 
                                placeholder="••••••••"
                            >
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmation
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required 
                                class="input-field appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80 text-sm" 
                                placeholder="••••••••"
                            >
                        </div>
                    </div>
                </div>

                <!-- Bouton d'inscription -->
                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="btn-primary w-full flex justify-center py-4 px-6 border border-transparent text-base font-semibold rounded-2xl text-white shadow-lg"
                    >
                        <span class="flex items-center">
                            Créer mon compte lecteur
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Lien de retour -->
                <div class="text-center pt-4 border-t border-gray-200 mt-6">
                    <button 
                        onclick="document.getElementById('registerForm').style.display='none'; document.getElementById('loginForm').style.display='block';" 
                        class="text-purple-600 font-bold hover:text-purple-700 transition-colors underline"
                    >
                        ← Retour à la connexion
                    </button>
                </div>
            </div>
        </form>

        <!-- Comptes de test -->
        <div class="glass-morphism rounded-2xl p-6 shadow-lg fade-in">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Comptes de démonstration
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-white/60 rounded-xl hover-lift">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-xs">👑</span>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Administrateur</span>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">ADMIN001</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white/60 rounded-xl hover-lift">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-xs">📚</span>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Bibliothécaire</span>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">BIB001</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white/60 rounded-xl hover-lift">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-xs">🎓</span>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Lecteur</span>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">ETU202401</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 text-center mt-3">
                Mot de passe : identique au login + @2024
            </p>
        </div>
    </div>

    <script>
        function showRegisterForm() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registerForm').classList.remove('hidden');
        }

        function hideRegisterForm() {
            document.getElementById('registerForm').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
        }
    </script>
</body>
</html>

