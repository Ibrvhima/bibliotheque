@extends('app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl mb-3 sm:mb-4">
                <i class="fas fa-book text-xl sm:text-3xl text-purple-600"></i>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-1 sm:mb-2">Bibliothèque Universitaire</h1>
            <p class="text-sm sm:text-base text-gray-600">Connectez-vous à votre espace</p>
        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg sm:shadow-2xl p-4 sm:p-6 lg:p-8 border border-white/20">
            <!-- Messages d'alerte -->
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg mb-4 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg mb-4 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf
                
                <!-- Champ Login -->
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        Identifiant ou email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 text-sm sm:text-base"></i>
                        </div>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            class="block w-full pl-9 sm:pl-10 pr-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base transition-colors"
                            placeholder="Votre identifiant"
                            required
                            value="{{ old('login') }}"
                        >
                    </div>
                    @error('login')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Champ Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                        Mot de passe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm sm:text-base"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="block w-full pl-9 sm:pl-10 pr-10 sm:pr-12 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base transition-colors"
                            placeholder="Votre mot de passe"
                            required
                        >
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            onclick="togglePassword()"
                        >
                            <i id="password-toggle" class="fas fa-eye text-gray-400 hover:text-gray-600 text-sm sm:text-base transition-colors"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Options supplémentaires -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium transition-colors">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Bouton de connexion -->
                <button 
                    type="submit" 
                    class="w-full flex justify-center items-center py-2.5 sm:py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm sm:text-base font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>

                <!-- Lien de création de compte -->
                <div class="text-center pt-4 sm:pt-6 border-t border-gray-200">
                    <p class="text-gray-600 text-sm sm:text-base">
                        Pas encore de compte ? 
                        <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-700 hover:underline transition-colors">
                            Créer votre compte lecteur
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Comptes de test -->
        <div class="mt-4 sm:mt-6 bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-xl p-3 sm:p-4 border border-white/20">
            <h3 class="text-sm font-semibold text-gray-700 mb-2 sm:mb-3 flex items-center">
                <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                Comptes de démonstration
            </h3>
            <div class="space-y-1.5 sm:space-y-2">
                <div class="flex justify-between items-center p-2 bg-white/60 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-crown text-purple-500 mr-2 text-xs sm:text-sm"></i>
                        <span class="text-xs sm:text-sm font-medium">Administrateur</span>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">ADMIN001</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white/60 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-book text-indigo-500 mr-2 text-xs sm:text-sm"></i>
                        <span class="text-xs sm:text-sm font-medium">Bibliothécaire</span>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">BIB001</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white/60 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap text-pink-500 mr-2 text-xs sm:text-sm"></i>
                        <span class="text-xs sm:text-sm font-medium">Lecteur</span>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">ETU202401</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 text-center mt-2">
                Mot de passe : identique au login + @2024
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('password-toggle');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Prevent form resubmission on page refresh
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>
@endsection

