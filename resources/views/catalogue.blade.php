@extends('app')

@section('title', 'Catalogue des livres')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Catalogue des livres</h1>
    <p class="mt-2 text-gray-600">Explorez notre collection de livres</p>
</div>

<!-- Formulaire de recherche et filtres -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <form method="GET" action="{{ route('lecteur.catalogue') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Recherche -->
            <div class="md:col-span-2">
                <label for="search" class="label">Rechercher</label>
                <input 
                    type="text" 
                    name="search" 
                    id="search" 
                    placeholder="Titre, auteur, ISBN..."
                    value="{{ request('search') }}"
                    class="input-field"
                >
            </div>

            <!-- Catégorie -->
            <div>
                <label for="categorie" class="label">Catégorie</label>
                <select name="categorie" id="categorie" class="input-field">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Disponibilité -->
            <div>
                <label for="disponible" class="label">Disponibilité</label>
                <select name="disponible" id="disponible" class="input-field">
                    <option value="">Tous</option>
                    <option value="1" {{ request('disponible') == '1' ? 'selected' : '' }}>Disponibles uniquement</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('lecteur.catalogue') }}" class="btn-secondary">Réinitialiser</a>
            <button type="submit" class="btn-primary">Rechercher</button>
        </div>
    </form>
</div>

<!-- Grille des livres -->
@if($livres->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($livres as $livre)
            <div class="card hover:shadow-xl transition duration-200">
                <!-- Image du livre -->
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($livre->image)
                        <img src="{{ Storage::url($livre->image) }}" alt="{{ $livre->titre }}" class="h-full w-full object-cover">
                    @else
                        <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    @endif
                </div>

                <!-- Informations du livre -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate" title="{{ $livre->titre }}">
                        {{ $livre->titre }}
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-2">
                        Par {{ $livre->auteurs_names }}
                    </p>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs text-gray-500">{{ $livre->categorie->libelle }}</span>
                        @if($livre->disponible)
                            <span class="badge-success">Disponible</span>
                        @else
                            <span class="badge-danger">Indisponible</span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ Str::limit($livre->resume, 80) }}
                    </p>

                    <div class="flex space-x-2">
                        <a href="{{ route('lecteur.livre.show', $livre->id) }}" class="flex-1 text-center btn-secondary text-sm py-1">
                            Détails
                        </a>
                        @if($livre->disponible)
                            <form method="POST" action="{{ route('lecteur.emprunt.demander', $livre->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full btn-primary text-sm py-1">
                                    Emprunter
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $livres->links() }}
    </div>
@else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun livre trouvé</h3>
        <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
    </div>
@endif
@endsection
