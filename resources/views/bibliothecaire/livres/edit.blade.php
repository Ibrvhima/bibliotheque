@extends('app')

@section('title', 'Modifier un Livre')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier un Livre</h1>
            <p class="mt-2 text-gray-600">Mettre à jour les informations du livre</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('bibliothecaire.livres.update', $livre->id) }}" method="POST" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informations principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="titre" name="titre" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('titre', $livre->titre) }}" placeholder="Titre du livre">
                        @error('titre')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                            ISBN
                        </label>
                        <input type="text" id="isbn" name="isbn"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('isbn', $livre->isbn) }}" placeholder="ISBN du livre">
                        @error('isbn')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catégorie -->
                <div class="mb-6">
                    <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select id="categorie_id" name="categorie_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner une catégorie</option>
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ old('categorie_id', $livre->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->libelle }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Aucune catégorie disponible</option>
                        @endif
                    </select>
                    @error('categorie_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Auteurs -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Auteurs <span class="text-red-500">*</span>
                    </label>
                    <div id="auteurs-container" class="space-y-2">
                        @if($livre->auteurs->count() > 0)
                            @foreach($livre->auteurs as $index => $auteur)
                                <div class="auteur-field flex items-center space-x-2">
                                    <select name="auteurs[]" required
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Sélectionner un auteur</option>
                                        @if(isset($auteurs) && $auteurs->count() > 0)
                                            @foreach($auteurs as $auteur_option)
                                                <option value="{{ $auteur_option->id }}" {{ $auteur_option->id == $auteur->id ? 'selected' : '' }}>
                                                    {{ $auteur_option->prenom }} {{ $auteur_option->nom }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($index > 0)
                                        <button type="button" onclick="removeAuteurField(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="auteur-field flex items-center space-x-2">
                                <select name="auteurs[]" required
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Sélectionner un auteur</option>
                                    @if(isset($auteurs) && $auteurs->count() > 0)
                                        @foreach($auteurs as $auteur)
                                            <option value="{{ $auteur->id }}">{{ $auteur->prenom }} {{ $auteur->nom }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addAuteurField()" class="mt-2 bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                        <i class="fas fa-plus mr-1"></i>
                        Ajouter un auteur
                    </button>
                    @error('auteurs')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Résumé -->
                <div class="mb-6">
                    <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                        Résumé
                    </label>
                    <textarea id="resume" name="resume" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Résumé du livre...">{{ old('resume', $livre->resume) }}</textarea>
                    @error('resume')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Image du livre
                    </label>
                    @if($livre->image)
                        <div class="mb-2">
                            <img src="/storage/{{ $livre->image }}" alt="{{ $livre->titre }}" class="h-20 w-auto rounded">
                            <p class="text-sm text-gray-500 mt-1">Image actuelle</p>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">
                        Optionnel. Laissez vide pour conserver l'image actuelle.
                    </p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Disponibilité -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="disponible" name="disponible" value="1" {{ old('disponible', $livre->disponible) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="disponible" class="ml-2 block text-sm text-gray-700">
                            Livre disponible pour l'emprunt
                        </label>
                    </div>
                    @error('disponible')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Informations sur le livre</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">ID:</span>
                            <span class="font-medium">{{ $livre->id }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Créé le:</span>
                            <span class="font-medium">{{ $livre->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Modifié le:</span>
                            <span class="font-medium">{{ $livre->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Statut:</span>
                            <span class="font-medium">{{ $livre->disponible ? 'Disponible' : 'Indisponible' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('bibliothecaire.livres.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-4 sm:py-2 sm:px-4 rounded-md transition-colors min-w-[44px] min-h-[44px] w-full sm:w-auto text-center inline-flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 sm:py-2 sm:px-6 rounded-md transition-colors flex items-center justify-center min-w-[44px] min-h-[44px] w-full sm:w-auto">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addAuteurField() {
    const container = document.getElementById('auteurs-container');
    const newField = document.createElement('div');
    newField.className = 'auteur-field flex items-center space-x-2';
    newField.innerHTML = `
        <select name="auteurs[]" required class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Sélectionner un auteur</option>
            @foreach($auteurs as $auteur)
                <option value="{{ $auteur->id }}">{{ $auteur->prenom }} {{ $auteur->nom }}</option>
            @endforeach
        </select>
        <button type="button" onclick="removeAuteurField(this)" class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(newField);
}

function removeAuteurField(button) {
    button.parentElement.remove();
}
</script>
@endsection
