@extends('app')

@section('title', 'Administration - Livres')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Administration des Livres</h1>
                <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Gestion complète des livres avec droits de suppression</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('bibliothecaire.livres.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center text-sm sm:text-base">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Ajouter</span>
                </a>
            </div>
        </div>

        <!-- Statistiques Admin -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-book text-white text-sm sm:text-base"></i>
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
                                <i class="fas fa-check text-white text-sm sm:text-base"></i>
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
                                <i class="fas fa-times text-white text-sm sm:text-base"></i>
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
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-trash text-white text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Supprimables</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $livres->whereDoesntHave('emprunts')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white shadow rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('admin.livres.index') }}" class="space-y-3 sm:space-y-0 sm:flex sm:flex-row sm:gap-4">
                <div class="w-full sm:flex-1">
                    <input type="text" name="search" placeholder="Rechercher par titre, auteur, ISBN..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>
                
                <div class="flex gap-2 sm:gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center text-sm sm:text-base">
                        <i class="fas fa-search mr-2"></i>
                        <span>Rechercher</span>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.livres.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors flex items-center text-sm sm:text-base">
                            <i class="fas fa-times mr-2"></i>
                            <span>Réinitialiser</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tableau des livres avec scroll horizontal -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="overflow-x-auto">
                @if($livres->count() > 0)
                    <table class="min-w-[1200px] divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[300px]">Livre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">Auteur(s)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">Catégorie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">ISBN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Emprunts</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($livres as $livre)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($livre->image)
                                                <img src="/storage/{{ $livre->image }}" alt="{{ $livre->titre }}" class="h-12 w-10 object-cover rounded mr-3">
                                            @else
                                                <div class="h-12 w-10 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                    <i class="fas fa-book text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($livre->titre, 40) }}</div>
                                                @if($livre->prix)
                                                    <div class="text-xs text-gray-500">{{ number_format($livre->prix, 0, ',', ' ') }} GNF</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $livre->auteurs->take(2)->pluck('nom')->implode(', ') }}
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $livre->isbn ?: 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $livre->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $livre->disponible ? 'Disponible' : 'Indisponible' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $livre->emprunts_count ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('bibliothecaire.livres.show', $livre->id) }}" class="text-gray-600 hover:text-gray-900 p-2 rounded hover:bg-gray-100" title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('bibliothecaire.livres.edit', $livre->id) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-100" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($livre->emprunts_count == 0)
                                                <form action="{{ route('admin.livres.destroy', $livre->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-100" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled class="text-gray-400 p-2 rounded cursor-not-allowed" title="Non supprimable (emprunts associés)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
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
@endsection
