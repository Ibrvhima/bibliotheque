@extends('app')

@section('title', 'Catalogue des Livres')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Catalogue des Livres</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Découvrez notre collection de livres disponibles</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6 mb-6 sm:mb-8">
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
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $livres->total() }}</dd>
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
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Disponibles</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                    {{ App\Models\Livre::where('disponible', true)->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Catégories</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $categories->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('lecteur.catalogue') }}" class="space-y-3 sm:space-y-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Rechercher par titre, auteur..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <select name="categorie" class="px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-lg">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->libelle }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="disponible" class="px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-lg">
                        <option value="">Tous les livres</option>
                        <option value="1" {{ request('disponible') == '1' ? 'selected' : '' }}>Disponibles uniquement</option>
                        <option value="0" {{ request('disponible') == '0' ? 'selected' : '' }}>Indisponibles</option>
                    </select>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors text-sm sm:text-lg flex items-center justify-center min-w-[44px] min-h-[44px] w-full sm:w-auto">
                        <i class="fas fa-search mr-2"></i>
                        <span class="hidden sm:inline">Rechercher</span>
                        <span class="sm:hidden">Chercher</span>
                    </button>
                    
                    @if(request('search') || request('categorie') || request('disponible'))
                        <a href="{{ route('lecteur.catalogue') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors text-sm sm:text-lg flex items-center justify-center min-w-[44px] min-h-[44px] w-full sm:w-auto">
                            <i class="fas fa-times mr-2"></i>
                            <span class="hidden sm:inline">Réinitialiser</span>
                            <span class="sm:hidden">Effacer</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Grille des livres -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @foreach($livres as $livre)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group cursor-pointer">
                    <!-- Image du livre avec overlay -->
                    <div class="relative h-36 sm:h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden">
                        @if($livre->image)
                            <img src="/storage/{{ $livre->image }}" alt="{{ $livre->titre }}" 
                                 class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE5MiIgdmlld0JveD0iMCAwIDIwMCAxOTIiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMTkyIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik02MCA2MEgxNDBWMTIwSDYwVjYwWiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                        @else
                            <div class="relative">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <div class="absolute inset-0 bg-white/20 rounded-full blur-xl"></div>
                            </div>
                        @endif
                        
                        <!-- Badge de disponibilité en overlay -->
                        <div class="absolute top-2 right-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium backdrop-blur-sm {{ $livre->disponible ? 'bg-green-500/90 text-white' : 'bg-red-500/90 text-white' }} shadow-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                {{ $livre->disponible ? 'Dispo' : 'Indispo' }}
                            </span>
                        </div>
                        
                        <!-- Overlay au hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Informations du livre -->
                    <div class="p-3 sm:p-4 space-y-3">
                        <!-- En-tête avec titre et badge -->
                        <div class="space-y-2">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $livre->titre }}</h3>
                            
                            <!-- Auteurs -->
                            @if($livre->auteurs->count() > 0)
                                <p class="text-xs sm:text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-user-edit mr-1.5 text-gray-400"></i>
                                    {{ $livre->auteurs->take(2)->pluck('prenom')->implode(' ') . ' ' . $livre->auteurs->take(2)->pluck('nom')->implode(' ') }}
                                    @if($livre->auteurs->count() > 2)
                                        <span class="text-gray-400 ml-1">+{{ $livre->auteurs->count() - 2 }}</span>
                                    @endif
                                </p>
                            @endif
                            
                            <!-- Catégorie et prix -->
                            <div class="flex items-center justify-between">
                                @if($livre->categorie)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                        <i class="fas fa-tag mr-1"></i>{{ $livre->categorie->libelle }}
                                    </span>
                                @endif
                                
                                @if($livre->prix)
                                    <span class="text-xs sm:text-sm font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">
                                        {{ number_format($livre->prix, 0, ',', ' ') }} GNF
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Résumé -->
                        @if($livre->resume)
                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 leading-relaxed">{{ Str::limit($livre->resume, 80) }}</p>
                        @endif
                        
                        <!-- Actions -->
                        <div class="flex flex-col space-y-2 pt-2">
                            <a href="{{ route('lecteur.livre.show', $livre->id) }}" 
                               class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 text-xs sm:text-sm font-medium shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                <i class="fas fa-eye mr-1.5"></i>
                                <span class="hidden sm:inline">Voir les détails</span>
                                <span class="sm:hidden">Détails</span>
                            </a>
                            
                            @if($livre->disponible)
                                @php
                                    $dejaEmprunte = \App\Models\Emprunt::where('user_id', auth()->id())
                                        ->where('livre_id', $livre->id)
                                        ->whereIn('statut', ['en_attente', 'en_cours', 'en_retard'])
                                        ->exists();
                                @endphp
                                
                                @if($dejaEmprunte)
                                    <button disabled class="bg-gradient-to-r from-orange-400 to-orange-500 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg cursor-not-allowed text-xs sm:text-sm font-medium shadow-md opacity-75">
                                        <i class="fas fa-clock mr-1.5"></i>
                                        <span class="hidden sm:inline">Déjà emprunté</span>
                                        <span class="sm:hidden">Emprunté</span>
                                    </button>
                                @else
                                    <form action="{{ route('lecteur.emprunt.demander', $livre->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 text-xs sm:text-sm font-medium shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                            <i class="fas fa-book-reader mr-1.5"></i>
                                            <span class="hidden sm:inline">Emprunter</span>
                                            <span class="sm:hidden">Emprunt</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <button disabled class="bg-gradient-to-r from-gray-400 to-gray-500 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg cursor-not-allowed text-xs sm:text-sm font-medium shadow-md opacity-75">
                                    <i class="fas fa-times mr-1.5"></i>
                                    <span class="hidden sm:inline">Indisponible</span>
                                    <span class="sm:hidden">Indisp.</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($livres->hasPages())
            <div class="mt-8">
                {{ $livres->links() }}
            </div>
        @endif

        <!-- Message si aucun livre -->
        @if($livres->count() == 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun livre trouvé</h3>
                <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
            </div>
        @endif
    </div>
</div>
@endsection
