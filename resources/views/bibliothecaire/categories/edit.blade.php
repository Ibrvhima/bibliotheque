@extends('app')

@section('title', 'Modifier une Catégorie')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier une Catégorie</h1>
            <p class="mt-2 text-gray-600">Mettre à jour les informations de la catégorie</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('bibliothecaire.categories.update', $categorie->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Nom de la catégorie -->
                <div class="mb-6">
                    <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la catégorie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="libelle" name="libelle" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('libelle', $categorie->libelle) }}" placeholder="Ex: Roman, Science-Fiction, Histoire...">
                    @error('libelle')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Description détaillée de la catégorie...">{{ old('description', $categorie->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Optionnel. Décrivez le type de livres que cette catégorie contient.
                    </p>
                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Informations sur la catégorie</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">ID:</span>
                            <span class="font-medium">{{ $categorie->id }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Nombre de livres:</span>
                            <span class="font-medium">{{ $categorie->livres_count ?? $categorie->livres()->count() }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Créée le:</span>
                            <span class="font-medium">{{ $categorie->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Modifiée le:</span>
                            <span class="font-medium">{{ $categorie->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-between">
                    <div>
                        @if($categorie->livres_count ?? $categorie->livres()->count() == 0)
                            <form action="{{ route('bibliothecaire.categories.destroy', $categorie->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors flex items-center">
                                    <i class="fas fa-trash mr-2"></i>
                                    Supprimer
                                </button>
                            </form>
                        @else
                            <button disabled class="bg-gray-400 text-white px-4 py-2 rounded-md cursor-not-allowed flex items-center" title="Impossible de supprimer une catégorie contenant des livres">
                                <i class="fas fa-trash mr-2"></i>
                                Supprimer (non disponible)
                            </button>
                            <p class="text-sm text-gray-500 mt-1">
                                Cette catégorie contient {{ $categorie->livres_count ?? $categorie->livres()->count() }} livre(s) et ne peut pas être supprimée.
                            </p>
                        @endif
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('bibliothecaire.categories.index') }}" 
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
