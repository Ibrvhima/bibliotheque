@extends('app')

@section('title', 'Emprunts en Retard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Emprunts en Retard</h1>
            <p class="mt-2 text-gray-600">Gestion des emprunts dépassant la date de retour</p>
        </div>

        <!-- Alertes -->
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        <strong>{{ $emprunts->count() }}</strong> emprunt(s) en retard nécessitent une attention immédiate.
                    </p>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('bibliothecaire.emprunts.en-retard') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" name="search" placeholder="Rechercher par utilisateur, livre..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                    Rechercher
                </button>
                @if(request('search'))
                    <a href="{{ route('bibliothecaire.emprunts.en-retard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        <!-- Liste des emprunts en retard -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($emprunts->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($emprunts as $emprunt)
                        <li class="hover:bg-red-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <!-- Avatar utilisateur -->
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                                <span class="text-red-600 font-medium text-lg">{{ $emprunt->user->initials }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Informations -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">
                                                        {{ $emprunt->user->getFullNameAttribute() }}
                                                    </h3>
                                                    <p class="text-sm text-gray-500">{{ $emprunt->user->login }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                            RETARD
                                                        </span>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $emprunt->user->getRoleDisplayAttribute() }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-2">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $emprunt->livre->titre }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $emprunt->livre->auteurs->pluck('nom')->implode(', ') }} • 
                                                    {{ $emprunt->livre->categorie->nom }}
                                                </p>
                                            </div>
                                            
                                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                                <div class="flex items-center text-gray-500">
                                                    <i class="fas fa-calendar-check mr-1 text-green-500"></i>
                                                    Emprunté le {{ $emprunt->date_emprunt->format('d/m/Y') }}
                                                </div>
                                                <div class="flex items-center text-red-600 font-medium">
                                                    <i class="fas fa-calendar-times mr-1"></i>
                                                    Retour prévu le {{ $emprunt->date_retour_prevue->format('d/m/Y') }}
                                                </div>
                                                <div class="flex items-center text-red-600 font-medium">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s) de retard
                                                </div>
                                            </div>

                                            @if($emprunt->penalite)
                                                <div class="mt-2 bg-yellow-50 border border-yellow-200 rounded p-2">
                                                    <p class="text-xs text-yellow-800">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        Pénalité : {{ number_format($emprunt->penalite->montant, 0, ',', ' ') }} GNF
                                                        @if(!$emprunt->penalite->payee)
                                                            <span class="font-medium"> (Non payée)</span>
                                                        @else
                                                            <span class="text-green-600"> (Payée)</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        @if($emprunt->statut === 'en_cours')
                                            <form action="{{ route('bibliothecaire.emprunt.retour', $emprunt->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition-colors flex items-center">
                                                    <i class="fas fa-undo mr-1"></i>
                                                    Retour enregistré
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('bibliothecaire.emprunt.prolonger', $emprunt->id) }}" method="POST" class="inline" onsubmit="return confirm('Prolonger cet emprunt de 15 jours ?')">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors flex items-center">
                                                <i class="fas fa-calendar-plus mr-1"></i>
                                                Prolonger
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('bibliothecaire.emprunt.show', $emprunt->id) }}" class="bg-gray-600 text-white px-3 py-2 rounded text-sm hover:bg-gray-700 transition-colors flex items-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($emprunts->hasMorePages())
                            <a href="{{ $emprunts->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </a>
                        @endif
                        @if($emprunts->hasPreviousPages())
                            <a href="{{ $emprunts->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Précédent
                            </a>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de <span class="font-medium">{{ $emprunts->firstItem() }}</span> à 
                                <span class="font-medium">{{ $emprunts->lastItem() }}</span> sur 
                                <span class="font-medium">{{ $emprunts->total() }}</span> résultats
                            </p>
                        </div>
                        <div>
                            {{ $emprunts->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun emprunt en retard</h3>
                    <p class="mt-1 text-sm text-gray-500">Tous les emprunts sont à jour !</p>
                    <div class="mt-6">
                        <a href="{{ route('bibliothecaire.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour au dashboard
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Statistiques des retards -->
        @if($emprunts->count() > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total en retard</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $emprunts->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Retard moyen</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $emprunts->avg(function($e) { return $e->date_retour_prevue->diffInDays(now()); }) }} jours
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pénalités totales</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ number_format($emprunts->sum(function($e) { return $e->penalite ? $e->penalite->montant : 0; }), 0, ',', ' ') }} GNF
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
