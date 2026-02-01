@extends('app')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Gestion des Catégories</h1>
                <p class="mt-2 text-gray-600 text-sm sm:text-base">Organisation des catégories de livres</p>
            </div>
            <a href="{{ route('bibliothecaire.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center sm:justify-start">
                <i class="fas fa-plus mr-2"></i>
                <span class="text-sm sm:text-base">Ajouter</span>
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Catégories</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $categories->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Livres</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $categories->sum('livres_count') }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Moyenne par catégorie</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ round($categories->avg('livres_count'), 1) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('bibliothecaire.categories.index') }}" class="space-y-4">
                <div class="w-full">
                    <input type="text" name="search" placeholder="Rechercher une catégorie..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center text-sm sm:text-base">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                    @if(request('search'))
                        <a href="{{ route('bibliothecaire.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors flex items-center text-sm sm:text-base">
                            <i class="fas fa-times mr-2"></i>
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Liste des catégories -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="overflow-x-auto">
                @if($categories->count() > 0)
                    <ul class="divide-y divide-gray-200 min-w-full">
                    @foreach($categories as $categorie)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6 min-w-[800px]">
                                <div class="flex items-center justify-between space-x-4">
                                    <div class="flex items-start sm:items-center space-x-3 sm:space-x-4">
                                        <!-- Icône de catégorie -->
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 sm:h-12 sm:w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-tag text-blue-600 text-sm sm:text-lg"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Informations de la catégorie -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3">
                                                <h3 class="text-sm font-medium text-gray-900 truncate min-w-[150px]">{{ $categorie->libelle }}</h3>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 whitespace-nowrap">
                                                    {{ $categorie->livres_count }} livre(s)
                                                </span>
                                            </div>
                                            
                                            @if($categorie->description)
                                                <p class="mt-1 text-sm text-gray-500 line-clamp-2 min-w-[200px]">{{ $categorie->description }}</p>
                                            @endif
                                            
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500 whitespace-nowrap">
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    Créée le {{ $categorie->created_at->format('d/m/Y') }}
                                                </span>
                                                @if($categorie->updated_at != $categorie->created_at)
                                                    <span>
                                                        <i class="fas fa-edit mr-1"></i>
                                                        Modifiée le {{ $categorie->updated_at->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2 whitespace-nowrap">
                                        <a href="{{ route('bibliothecaire.categories.edit', $categorie->id) }}" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors flex items-center">
                                            <i class="fas fa-edit mr-1"></i>
                                            <span>Modifier</span>
                                        </a>
                                        
                                        @if($categorie->livres_count == 0)
                                            <form action="{{ route('bibliothecaire.categories.destroy', $categorie->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition-colors flex items-center">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    <span>Supprimer</span>
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="bg-gray-400 text-white px-3 py-2 rounded text-sm cursor-not-allowed flex items-center" title="Impossible de supprimer une catégorie contenant des livres">
                                                <i class="fas fa-trash mr-1"></i>
                                                <span>Supprimer</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
                
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="text-center sm:text-left">
                            <p class="text-sm text-gray-700">
                                <span class="block sm:inline">Affichage de <span class="font-medium">{{ $categories->firstItem() }}</span> à 
                                <span class="font-medium">{{ $categories->lastItem() }}</span> sur 
                                <span class="font-medium">{{ $categories->total() }}</span> résultats</span>
                            </p>
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune catégorie trouvée</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez par ajouter des catégories pour organiser vos livres.</p>
                    <div class="mt-6">
                        <a href="{{ route('bibliothecaire.categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter une catégorie
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
