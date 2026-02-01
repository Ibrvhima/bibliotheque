@extends('app')

@section('title', 'Gestion des Livres')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Gestion des Livres</h1>
                <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Catalogue complet de la bibliothèque</p>
            </div>
            <a href="{{ route('bibliothecaire.livres.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center sm:justify-start w-full sm:w-auto">
                <i class="fas fa-plus mr-2"></i>
                <span class="text-sm sm:text-base">Ajouter un livre</span>
            </a>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
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
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $livres->where('disponible', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Indisponibles</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $livres->where('disponible', false)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg sm:col-span-2 lg:col-span-1">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Catégories</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ \App\Models\Categorie::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('bibliothecaire.livres.index') }}" class="space-y-3 sm:space-y-0 sm:flex sm:flex-row sm:gap-4">
                <!-- Champ recherche -->
                <div class="w-full sm:flex-1">
                    <input type="text" name="search" placeholder="Rechercher par titre, auteur, ISBN..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>
                
                <!-- Filtres sur mobile -->
                <div class="sm:hidden">
                    <div class="grid grid-cols-2 gap-2">
                        <select name="categorie" class="px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">Catégories</option>
                            @foreach(\App\Models\Categorie::all() as $categorie)
                                <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                    {{ Str::limit($categorie->libelle, 15) }}
                                </option>
                            @endforeach
                        </select>
                        <select name="disponibilite" class="px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">État</option>
                            <option value="1" {{ request('disponibilite') == '1' ? 'selected' : '' }}>Dispo</option>
                            <option value="0" {{ request('disponibilite') == '0' ? 'selected' : '' }}>Indispo</option>
                        </select>
                    </div>
                </div>
                
                <!-- Filtres sur desktop -->
                <div class="hidden sm:flex sm:gap-3">
                    <select name="categorie" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base min-w-[140px]">
                        <option value="">Toutes catégories</option>
                        @foreach(\App\Models\Categorie::all() as $categorie)
                            <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->libelle }}
                            </option>
                        @endforeach
                    </select>
                    <select name="disponibilite" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base min-w-[120px]">
                        <option value="">Tous états</option>
                        <option value="1" {{ request('disponibilite') == '1' ? 'selected' : '' }}>Disponibles</option>
                        <option value="0" {{ request('disponibilite') == '0' ? 'selected' : '' }}>Indisponibles</option>
                    </select>
                </div>
                
                <!-- Boutons mobile -->
                <div class="sm:hidden">
                    <div class="grid grid-cols-2 gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-md transition-colors flex items-center justify-center text-sm min-h-[44px]">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher
                        </button>
                        @if(request()->hasAny(['search', 'categorie', 'disponibilite']))
                            <a href="{{ route('bibliothecaire.livres.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-4 rounded-md transition-colors flex items-center justify-center text-sm min-h-[44px]">
                                <i class="fas fa-times mr-2"></i>
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Boutons desktop -->
                <div class="hidden sm:flex sm:gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center text-sm sm:text-base min-h-[44px]">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                    @if(request()->hasAny(['search', 'categorie', 'disponibilite']))
                        <a href="{{ route('bibliothecaire.livres.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center text-sm sm:text-base min-h-[44px]">
                            <i class="fas fa-times mr-2"></i>
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Liste des livres -->
        <!-- Version Desktop -->
        <div class="hidden lg:block">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="overflow-x-auto">
                    @if($livres->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Livre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Auteur(s)
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Catégorie
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($livres as $livre)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($livre->image)
                                                    <img src="/storage/{{ $livre->image }}" alt="{{ $livre->titre }}" 
                                                         class="h-10 w-8 object-cover rounded mr-3"
                                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA2NCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjQ4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0NFY0MEgyMFYyMFoiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iTTI4IDI2SDM2VjM0SDI4VjI2WiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                                                @else
                                                    <div class="h-10 w-8 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                        <i class="fas fa-book text-gray-400 text-sm"></i>
                                                    </div>
                                                @endif
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($livre->titre, 30) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $livre->auteurs->pluck('nom')->take(2)->implode(', ') }}
                                                @if($livre->auteurs->count() > 2)
                                                    <span class="text-gray-400">+{{ $livre->auteurs->count() - 2 }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($livre->categorie)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $livre->categorie->libelle }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $livre->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $livre->disponible ? 'Disponible' : 'Indisponible' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-1 sm:space-x-2">
                                                <form action="{{ route('bibliothecaire.livre.toggle', $livre->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-3 sm:p-2 text-{{ $livre->disponible ? 'green' : 'yellow' }}-600 hover:text-{{ $livre->disponible ? 'green' : 'yellow' }}-800 transition-colors min-w-[44px] min-h-[44px] rounded-md hover:bg-{{ $livre->disponible ? 'green' : 'yellow' }}-50" title="{{ $livre->disponible ? 'Rendre indisponible' : 'Rendre disponible' }}">
                                                        <svg class="w-4 h-4 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <a href="{{ route('bibliothecaire.livres.edit', $livre->id) }}" class="p-3 sm:p-2 text-blue-600 hover:text-blue-800 transition-colors min-w-[44px] min-h-[44px] rounded-md hover:bg-blue-50 inline-flex items-center justify-center" title="Modifier">
                                                    <svg class="w-4 h-4 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('bibliothecaire.livres.show', $livre->id) }}" class="p-3 sm:p-2 text-gray-600 hover:text-gray-800 transition-colors min-w-[44px] min-h-[44px] rounded-md hover:bg-gray-50 inline-flex items-center justify-center" title="Détails">
                                                    <svg class="w-4 h-4 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun livre trouvé</h3>
                            <p class="text-gray-500">Commencez par ajouter votre premier livre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Version Mobile -->
        <div class="lg:hidden">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="overflow-x-auto">
                    @if($livres->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Livre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Auteur(s)
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Catégorie
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($livres as $livre)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($livre->image)
                                                    <img src="/storage/{{ $livre->image }}" alt="{{ $livre->titre }}" 
                                                         class="h-10 w-8 object-cover rounded mr-3"
                                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA2NCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjQ4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0NFY0MEgyMFYyMFoiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iTTI4IDI2SDM2VjM0SDI4VjI2WiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                                                @else
                                                    <div class="h-10 w-8 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                        <i class="fas fa-book text-gray-400 text-sm"></i>
                                                    </div>
                                                @endif
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($livre->titre, 30) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $livre->auteurs->pluck('nom')->take(2)->implode(', ') }}
                                                @if($livre->auteurs->count() > 2)
                                                    <span class="text-gray-400">+{{ $livre->auteurs->count() - 2 }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($livre->categorie)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $livre->categorie->libelle }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $livre->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $livre->disponible ? 'Disponible' : 'Indisponible' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-1 sm:space-x-2">
                                                <form action="{{ route('bibliothecaire.livre.toggle', $livre->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-3 sm:p-2 text-{{ $livre->disponible ? 'green' : 'yellow' }}-600 hover:text-{{ $livre->disponible ? 'green' : 'yellow' }}-800 transition-colors min-w-[44px] min-h-[44px] rounded-md hover:bg-{{ $livre->disponible ? 'green' : 'yellow' }}-50" title="{{ $livre->disponible ? 'Rendre indisponible' : 'Rendre disponible' }}">
                                                        <svg class="w-4 h-4 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <a href="{{ route('bibliothecaire.livres.edit', $livre->id) }}" class="p-3 sm:p-2 text-blue-600 hover:text-blue-800 transition-colors min-w-[44px] min-h-[44px] rounded-md hover:bg-blue-50 inline-flex items-center justify-center" title="Modifier">
                                                    <svg class="w-4 h-4 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('bibliothecaire.livres.show', $livre->id) }}" class="p-3 sm:p-2 text-gray-600 hover:text-gray-800 transition-colors min-w-[44px] min-h-[44px] rounded-md hover:bg-gray-50 inline-flex items-center justify-center" title="Détails">
                                                    <svg class="w-4 h-4 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun livre trouvé</h3>
                            <p class="text-gray-500">Commencez par ajouter votre premier livre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
