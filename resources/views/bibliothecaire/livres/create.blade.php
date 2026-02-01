@extends('app')

@section('title', 'Ajouter un Livre')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Ajouter un Livre</h1>
            <p class="mt-2 text-gray-600">Ajouter un nouveau livre au catalogue</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('bibliothecaire.livres.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Informations principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="titre" name="titre" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('titre') }}" placeholder="Titre du livre">
                        @error('titre')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                            ISBN <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="isbn" name="isbn" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('isbn') }}" placeholder="978-0-00-000000-0">
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
                                <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
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
                    <div class="space-y-2" id="auteurs-container">
                        <div class="flex items-center space-x-2">
                            <select name="auteurs[]" required
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionner un auteur</option>
                                @if(isset($auteurs) && $auteurs->count() > 0)
                                    @foreach($auteurs as $auteur)
                                        <option value="{{ $auteur->id }}" {{ old('auteurs.0') == $auteur->id ? 'selected' : '' }}>
                                            {{ $auteur->prenom }} {{ $auteur->nom }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <button type="button" onclick="addAuthorField()" 
                                    class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
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
                              placeholder="Résumé du livre...">{{ old('resume') }}</textarea>
                    @error('resume')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Image de couverture
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Formats acceptés : JPG, PNG, GIF. Taille maximale : 2MB.
                    </p>
                </div>

                <!-- Disponibilité -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="disponible" name="disponible" value="1" checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="disponible" class="ml-2 block text-sm text-gray-700">
                            Livre disponible à l'emprunt
                        </label>
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
                        Enregistrer le livre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addAuthorField() {
    const container = document.getElementById('auteurs-container');
    const authorFields = container.querySelectorAll('select[name="auteurs[]"]');
    
    if (authorFields.length >= 5) {
        alert('Maximum 5 auteurs autorisés');
        return;
    }
    
    const newField = document.createElement('div');
    newField.className = 'flex items-center space-x-2';
    newField.innerHTML = `
        <select name="auteurs[]" required
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Sélectionner un auteur</option>
            @foreach($auteurs as $auteur)
                <option value="{{ $auteur->id }}">{{ $auteur->nom }}</option>
            @endforeach
        </select>
        <button type="button" onclick="this.parentElement.remove()" 
                class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700 transition-colors">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(newField);
}

// Validation du formulaire
document.querySelector('form').addEventListener('submit', function(e) {
    const auteurs = document.querySelectorAll('select[name="auteurs[]"]');
    const selectedAuteurs = Array.from(auteurs).filter(select => select.value !== '');
    
    if (selectedAuteurs.length === 0) {
        e.preventDefault();
        alert('Veuillez sélectionner au moins un auteur');
        return;
    }
    
    // Vérifier les doublons
    const values = selectedAuteurs.map(select => select.value);
    const uniqueValues = [...new Set(values)];
    
    if (values.length !== uniqueValues.length) {
        e.preventDefault();
        alert('Veuillez ne pas sélectionner le même auteur plusieurs fois');
        return;
    }
});
</script>
@endsection
