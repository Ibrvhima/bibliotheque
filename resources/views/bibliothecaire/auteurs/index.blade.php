@extends('app')

@section('title', 'Gestion des Auteurs')

@section('content')
<div class="py-4 sm:py-6">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Gestion des Auteurs</h1>
                <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Organisation des auteurs de livres</p>
            </div>
            <a href="{{ route('bibliothecaire.auteurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center sm:justify-start w-full sm:w-auto">
                <i class="fas fa-plus mr-2"></i>
                <span class="text-sm sm:text-base">Ajouter un auteur</span>
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Auteurs</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $auteurs->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Livres</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $auteurs->sum('livres_count') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg sm:col-span-2 lg:col-span-1">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Moyenne par auteur</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ round($auteurs->avg('livres_count'), 1) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('bibliothecaire.auteurs.index') }}" class="space-y-3 sm:space-y-4">
                <div class="w-full">
                    <input type="text" name="search" placeholder="Rechercher un auteur..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center text-sm sm:text-base">
                        <i class="fas fa-search mr-2"></i>
                        <span>Rechercher</span>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('bibliothecaire.auteurs.index') }}" class="w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors flex items-center justify-center text-sm sm:text-base">
                            <i class="fas fa-times mr-2"></i>
                            <span>Réinitialiser</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Liste des auteurs -->
        <div class="bg-white shadow overflow-hidden rounded-md">
            @if($auteurs->count() > 0)
                <!-- Mobile Scroll Horizontal -->
                <div class="sm:hidden">
                    <div class="overflow-x-auto">
                        <div class="min-w-full">
                            @foreach($auteurs as $auteur)
                            <div class="border-b border-gray-200 last:border-b-0">
                                <div class="px-3 py-3">
                                    <div class="flex items-start space-x-3">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-medium text-sm">{{ strtoupper(substr($auteur->nom, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Contenu -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <h3 class="text-sm font-medium text-gray-900 truncate">{{ $auteur->prenom }} {{ $auteur->nom }}</h3>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 whitespace-nowrap">
                                                    {{ $auteur->livres_count }} livre(s)
                                                </span>
                                            </div>
                                            
                                            @if($auteur->biographie)
                                                <p class="text-xs text-gray-500 mb-2">{{ Str::limit($auteur->biographie, 80) }}</p>
                                            @endif
                                            
                                            <div class="text-xs text-gray-400 mb-3">
                                                <span>Ajouté le {{ $auteur->created_at->format('d/m/Y') }}</span>
                                                @if($auteur->updated_at != $auteur->created_at)
                                                    <span class="ml-2">• Modifié le {{ $auteur->updated_at->format('d/m/Y') }}</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Actions Mobile -->
                                            <div class="flex gap-2 overflow-x-auto pb-1">
                                                <a href="{{ route('bibliothecaire.auteurs.edit', $auteur->id) }}" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors flex items-center whitespace-nowrap flex-shrink-0">
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Modifier
                                                </a>
                                                
                                                @if($auteur->livres_count == 0)
                                                    <form action="{{ route('bibliothecaire.auteurs.destroy', $auteur->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?')" class="inline flex-shrink-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition-colors flex items-center whitespace-nowrap">
                                                            <i class="fas fa-trash mr-2"></i>
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="bg-gray-400 text-white px-3 py-2 rounded text-sm cursor-not-allowed flex items-center whitespace-nowrap flex-shrink-0" title="Impossible de supprimer un auteur ayant des livres">
                                                        <i class="fas fa-trash mr-2"></i>
                                                        Supprimer
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Desktop Layout avec Scroll Horizontal -->
                <div class="hidden sm:block overflow-x-auto">
                    <div class="min-w-[1000px]">
                        <ul class="divide-y divide-gray-200">
                            @foreach($auteurs as $auteur)
                                <li class="hover:bg-gray-50">
                                    <div class="px-3 sm:px-4 py-3 sm:py-4">
                                        <div class="flex items-center justify-between space-x-4">
                                            <div class="flex items-center space-x-4">
                                                <!-- Avatar de l'auteur -->
                                                <div class="flex-shrink-0">
                                                    <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium text-lg">{{ strtoupper(substr($auteur->nom, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Informations de l'auteur -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-3">
                                                        <h3 class="text-sm font-medium text-gray-900 truncate min-w-[200px]">{{ $auteur->prenom }} {{ $auteur->nom }}</h3>
                                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 whitespace-nowrap">
                                                            {{ $auteur->livres_count }} livre(s)
                                                        </span>
                                                    </div>
                                                    
                                                    @if($auteur->biographie)
                                                        <p class="mt-1 text-sm text-gray-500 line-clamp-2 min-w-[300px]">{{ Str::limit($auteur->biographie, 100) }}</p>
                                                    @endif
                                                    
                                                    <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500 whitespace-nowrap">
                                                        <span>
                                                            <i class="fas fa-calendar mr-1"></i>
                                                            Ajouté le {{ $auteur->created_at->format('d/m/Y') }}
                                                        </span>
                                                        @if($auteur->updated_at != $auteur->created_at)
                                                            <span>
                                                                <i class="fas fa-edit mr-1"></i>
                                                                Modifié le {{ $auteur->updated_at->format('d/m/Y') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Actions Desktop -->
                                            <div class="flex items-center space-x-2 whitespace-nowrap">
                                                <a href="{{ route('bibliothecaire.auteurs.edit', $auteur->id) }}" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors flex items-center">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Modifier
                                                </a>
                                                
                                                @if($auteur->livres_count == 0)
                                                    <form action="{{ route('bibliothecaire.auteurs.destroy', $auteur->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition-colors flex items-center">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="bg-gray-400 text-white px-3 py-2 rounded text-sm cursor-not-allowed flex items-center" title="Impossible de supprimer un auteur ayant des livres">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Supprimer
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Pagination Mobile Optimisée -->
                <div class="bg-white px-3 sm:px-4 py-4 sm:py-3 border-t border-gray-200">
                    <!-- Mobile Pagination -->
                    <div class="sm:hidden">
                        <div class="flex flex-col space-y-3">
                            <!-- Info de pagination -->
                            <div class="text-center text-sm text-gray-600">
                                @if($auteurs->total() > 0)
                                    Page {{ $auteurs->currentPage() }} sur {{ $auteurs->lastPage() }}
                                    ({{ $auteurs->firstItem() }}-{{ $auteurs->lastItem() }} sur {{ $auteurs->total() }})
                                @endif
                            </div>
                            
                            <!-- Boutons de navigation -->
                            <div class="flex justify-between items-center">
                                @if(!$auteurs->onFirstPage())
                                    <a href="{{ $auteurs->previousPageUrl() }}" 
                                       class="flex-1 mr-2 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center text-sm font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        Précédent
                                    </a>
                                @else
                                    <div class="flex-1 mr-2 bg-gray-300 text-gray-500 px-4 py-3 rounded-lg flex items-center justify-center text-sm font-medium cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        Précédent
                                    </div>
                                @endif
                                
                                @if($auteurs->hasMorePages())
                                    <a href="{{ $auteurs->nextPageUrl() }}" 
                                       class="flex-1 ml-2 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center text-sm font-medium">
                                        Suivant
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @else
                                    <div class="flex-1 ml-2 bg-gray-300 text-gray-500 px-4 py-3 rounded-lg flex items-center justify-center text-sm font-medium cursor-not-allowed">
                                        Suivant
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Navigation rapide (pages) -->
                            @if($auteurs->lastPage() > 1)
                            <div class="flex justify-center">
                                <div class="inline-flex rounded-lg shadow-sm">
                                    @for($i = 1; $i <= min(5, $auteurs->lastPage()); $i++)
                                        @if($i == $auteurs->currentPage())
                                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-l-lg rounded-r-lg">
                                                {{ $i }}
                                            </span>
                                        @else
                                            <a href="{{ $auteurs->url($i) }}" 
                                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 {{ $i == 1 ? 'rounded-l-lg' : '' }} {{ $i == min(5, $auteurs->lastPage()) ? 'rounded-r-lg' : '' }}">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor
                                    
                                    @if($auteurs->lastPage() > 5)
                                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300">
                                            ...
                                        </span>
                                        <a href="{{ $auteurs->url($auteurs->lastPage()) }}" 
                                           class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-r-lg">
                                            {{ $auteurs->lastPage() }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Desktop Pagination -->
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de <span class="font-medium">{{ $auteurs->firstItem() }}</span> à 
                                <span class="font-medium">{{ $auteurs->lastItem() }}</span> sur 
                                <span class="font-medium">{{ $auteurs->total() }}</span> résultats
                            </p>
                        </div>
                        <div>
                            {{ $auteurs->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 sm:py-12">
                    <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun auteur trouvé</h3>
                    <p class="mt-1 text-sm text-gray-500 px-4">Commencez par ajouter des auteurs pour organiser vos livres.</p>
                    <div class="mt-4 sm:mt-6">
                        <a href="{{ route('bibliothecaire.auteurs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un auteur
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
