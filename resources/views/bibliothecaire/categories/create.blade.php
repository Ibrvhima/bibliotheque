@extends('app')

@section('title', 'Ajouter une Catégorie')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Ajouter une Catégorie</h1>
            <p class="mt-2 text-gray-600">Créer une nouvelle catégorie pour organiser les livres</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('bibliothecaire.categories.store') }}" method="POST" class="p-6">
                @csrf
                
                <!-- Nom de la catégorie -->
                <div class="mb-6">
                    <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la catégorie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="libelle" name="libelle" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('libelle') }}" placeholder="Ex: Roman, Science-Fiction, Histoire...">
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
                              placeholder="Description détaillée de la catégorie...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Optionnel. Décrivez le type de livres que cette catégorie contient.
                    </p>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('bibliothecaire.categories.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer la catégorie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
