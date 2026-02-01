@extends('app')

@section('title', 'Modifier un Auteur')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier un Auteur</h1>
            <p class="mt-2 text-gray-600">Mettre à jour les informations de l'auteur</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('bibliothecaire.auteurs.update', $auteur->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Nom et Prénom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nom" name="nom" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('nom', $auteur->nom) }}" placeholder="Ex: Touré, Diallo, Condé...">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                            Prénom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="prenom" name="prenom" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('prenom', $auteur->prenom) }}" placeholder="Ex: Sékou, Aminata, Maryse...">
                        @error('prenom')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Biographie -->
                <div class="mb-6">
                    <label for="biographie" class="block text-sm font-medium text-gray-700 mb-2">
                        Biographie
                    </label>
                    <textarea id="biographie" name="biographie" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Biographie détaillée de l'auteur...">{{ old('biographie', $auteur->biographie) }}</textarea>
                    @error('biographie')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Optionnel. Décrivez l'auteur, ses œuvres, son parcours...
                    </p>
                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Informations sur l'auteur</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">ID:</span>
                            <span class="font-medium">{{ $auteur->id }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Nombre de livres:</span>
                            <span class="font-medium">{{ $auteur->livres_count ?? $auteur->livres()->count() }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Créé le:</span>
                            <span class="font-medium">{{ $auteur->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Modifié le:</span>
                            <span class="font-medium">{{ $auteur->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-between">
                    <div>
                        @if($auteur->livres_count ?? $auteur->livres()->count() == 0)
                            <form action="{{ route('bibliothecaire.auteurs.destroy', $auteur->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors flex items-center">
                                    <i class="fas fa-trash mr-2"></i>
                                    Supprimer
                                </button>
                            </form>
                        @else
                            <button disabled class="bg-gray-400 text-white px-4 py-2 rounded-md cursor-not-allowed flex items-center" title="Impossible de supprimer un auteur ayant des livres">
                                <i class="fas fa-trash mr-2"></i>
                                Supprimer (non disponible)
                            </button>
                            <p class="text-sm text-gray-500 mt-1">
                                Cet auteur a {{ $auteur->livres_count ?? $auteur->livres()->count() }} livre(s) et ne peut pas être supprimé.
                            </p>
                        @endif
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('bibliothecaire.auteurs.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
