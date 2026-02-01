@extends('app')

@section('title', 'Dashboard Bibliothécaire')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dashboard Bibliothécaire</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Gestion de la bibliothèque</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Livres</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['total_livres'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Livres Disponibles</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['livres_disponibles'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Emprunts en Cours</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['emprunts_en_cours'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg sm:col-span-2 lg:col-span-1">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Emprunts en Attente</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['emprunts_en_attente'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertes -->
        @if($emprunts_en_attente->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 sm:p-4 mb-4 sm:mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <p class="text-xs sm:text-sm text-yellow-700">
                        <strong>{{ $emprunts_en_attente->count() }}</strong> demande(s) d'emprunt en attente de validation.
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if($emprunts_en_retard->count() > 0)
        <div class="bg-red-50 border-l-4 border-red-400 p-3 sm:p-4 mb-4 sm:mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <p class="text-xs sm:text-sm text-red-700">
                        <strong>{{ $emprunts_en_retard->count() }}</strong> emprunt(s) en retard.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Activité du jour -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">Activité du jour</h3>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-500">Emprunts aujourd'hui</span>
                            <span class="text-xs sm:text-sm font-medium text-gray-900">{{ $activite['emprunts_today'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-500">Retours aujourd'hui</span>
                            <span class="text-xs sm:text-sm font-medium text-gray-900">{{ $activite['retours_today'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">Actions rapides</h3>
                    <div class="space-y-2 sm:space-y-3">
                        <a href="{{ route('bibliothecaire.emprunts.en-attente') }}" class="block w-full text-center bg-blue-600 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-md hover:bg-blue-700 transition-colors text-xs sm:text-sm font-medium">
                            <i class="fas fa-check-circle mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Valider les</span> emprunts
                        </a>
                        <a href="{{ route('bibliothecaire.emprunts.en-retard') }}" class="block w-full text-center bg-red-600 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-md hover:bg-red-700 transition-colors text-xs sm:text-sm font-medium">
                            <i class="fas fa-exclamation-triangle mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Voir les</span> retards
                        </a>
                        <a href="{{ route('bibliothecaire.livres.index') }}" class="block w-full text-center bg-green-600 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-md hover:bg-green-700 transition-colors text-xs sm:text-sm font-medium">
                            <i class="fas fa-book mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Gérer les</span> livres
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emprunts récents -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-3 sm:px-4 py-4 sm:py-5 sm:px-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Demandes d'emprunt récentes</h3>
                <p class="mt-1 max-w-2xl text-xs sm:text-sm text-gray-500">
                    Les 5 dernières demandes d'emprunt en attente
                </p>
            </div>
            <ul class="divide-y divide-gray-200">
                @if($emprunts_en_attente->count() > 0)
                    @foreach($emprunts_en_attente->take(5) as $emprunt)
                    <li class="px-3 sm:px-4 py-3 sm:py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                    <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium text-xs sm:text-sm">{{ $emprunt->user->initials }}</span>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $emprunt->user->getFullNameAttribute() }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 truncate">{{ $emprunt->livre->titre }}</div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 gap-2 sm:gap-0">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 text-center">
                                    En attente
                                </span>
                                <form action="{{ route('bibliothecaire.emprunt.valider', $emprunt->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-2 sm:px-3 py-1 sm:py-1.5 rounded text-xs hover:bg-green-700 transition-colors w-full sm:w-auto">
                                        <i class="fas fa-check mr-1"></i>
                                        <span class="hidden sm:inline">Valider</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                @else
                    <li class="px-3 sm:px-4 py-3 sm:py-4 sm:px-6">
                        <div class="text-center text-gray-500 text-xs sm:text-sm">
                            Aucune demande d'emprunt en attente
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
