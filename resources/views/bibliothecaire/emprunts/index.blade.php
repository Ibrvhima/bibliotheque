@extends('app')

@section('title', 'Gestion des Emprunts')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Gestion des Emprunts</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Suivi et gestion de tous les emprunts de la bibliothèque</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Emprunts</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $emprunts->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">En Attente</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                    {{ App\Models\Emprunt::enAttente()->count() }}
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
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">En Cours</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                    {{ App\Models\Emprunt::enCours()->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg sm:col-span-2 lg:col-span-1">
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
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">En Retard</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                    {{ App\Models\Emprunt::enRetard()->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('bibliothecaire.emprunts.index') }}" class="space-y-3 sm:space-y-0 sm:flex sm:flex-row sm:gap-4">
                <!-- Champ recherche -->
                <div class="w-full sm:flex-1">
                    <input type="text" name="search" placeholder="Rechercher par livre, utilisateur..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>
                
                <!-- Filtre statut mobile -->
                <div class="sm:hidden">
                    <select name="statut" class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">Tous statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="termine" {{ request('statut') == 'termine' ? 'selected' : '' }}>Terminé</option>
                        <option value="en_retard" {{ request('statut') == 'en_retard' ? 'selected' : '' }}>En retard</option>
                    </select>
                </div>
                
                <!-- Filtre statut desktop -->
                <div class="hidden sm:block">
                    <select name="statut" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base min-w-[140px]">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="termine" {{ request('statut') == 'termine' ? 'selected' : '' }}>Terminé</option>
                        <option value="en_retard" {{ request('statut') == 'en_retard' ? 'selected' : '' }}>En retard</option>
                    </select>
                </div>
                
                <!-- Boutons mobile -->
                <div class="sm:hidden">
                    <div class="grid grid-cols-2 gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-md transition-colors flex items-center justify-center text-sm min-h-[44px]">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher
                        </button>
                        @if(request('search') || request('statut'))
                            <a href="{{ route('bibliothecaire.emprunts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-4 rounded-md transition-colors flex items-center justify-center text-sm min-h-[44px]">
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
                    @if(request('search') || request('statut'))
                        <a href="{{ route('bibliothecaire.emprunts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center text-sm sm:text-base min-h-[44px]">
                            <i class="fas fa-times mr-2"></i>
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Actions rapides -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 sm:gap-4">
                <a href="{{ route('bibliothecaire.emprunts.en-attente') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 sm:px-4 py-2.5 rounded-md transition-colors flex items-center justify-center sm:justify-start text-sm sm:text-base min-h-[44px]">
                    <i class="fas fa-clock mr-2"></i>
                    <span class="hidden sm:inline">Emprunts en attente</span>
                    <span class="sm:hidden">En attente</span>
                    ({{ App\Models\Emprunt::enAttente()->count() }})
                </a>
                <a href="{{ route('bibliothecaire.emprunts.en-retard') }}" class="bg-red-600 hover:bg-red-700 text-white px-3 sm:px-4 py-2.5 rounded-md transition-colors flex items-center justify-center sm:justify-start text-sm sm:text-base min-h-[44px]">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="hidden sm:inline">Emprunts en retard</span>
                    <span class="sm:hidden">En retard</span>
                    ({{ App\Models\Emprunt::enRetard()->count() }})
                </a>
            </div>
        </div>

        <!-- Liste des emprunts -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="overflow-x-auto">
                @if($emprunts->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Livre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date d'emprunt
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Retour prévu
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
                            @foreach($emprunts as $emprunt)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($emprunt->livre->image)
                                                <img src="/storage/{{ $emprunt->livre->image }}" alt="{{ $emprunt->livre->titre }}" 
                                                     class="h-10 w-8 object-cover rounded mr-3"
                                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA2NCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjQ4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0NFY0MEgyMFYyMFoiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iTTI4IDI2SDM2VjM0SDI4VjI2WiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                                            @else
                                                <div class="h-10 w-8 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                    <i class="fas fa-book text-gray-400 text-sm"></i>
                                                </div>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($emprunt->livre->titre, 30) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">{{ $emprunt->user->nom }} {{ $emprunt->user->prenom }}</div>
                                            <div class="text-gray-500">{{ $emprunt->user->login }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $emprunt->date_emprunt->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($emprunt->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                            @elseif($emprunt->statut == 'en_cours') bg-green-100 text-green-800
                                            @elseif($emprunt->statut == 'en_retard') bg-red-100 text-red-800
                                            @elseif($emprunt->statut == 'termine') bg-gray-100 text-gray-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            @if($emprunt->statut == 'en_attente')
                                                <form action="{{ route('bibliothecaire.emprunt.valider', $emprunt->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition-colors">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Valider
                                                    </button>
                                                </form>
                                                <button type="button" onclick="openRefuserModal({{ $emprunt->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition-colors">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Refuser
                                                </button>
                                            @elseif($emprunt->statut == 'en_cours')
                                                <form action="{{ route('bibliothecaire.emprunt.retour', $emprunt->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition-colors">
                                                        <i class="fas fa-undo mr-1"></i>
                                                        Retour
                                                    </button>
                                                </form>
                                                <form action="{{ route('bibliothecaire.emprunt.prolonger', $emprunt->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-yellow-600 text-white px-3 py-1 rounded text-xs hover:bg-yellow-700 transition-colors">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Prolonger
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('bibliothecaire.emprunt.show', $emprunt->id) }}" class="text-gray-600 hover:text-gray-900 px-3 py-1 rounded text-xs hover:bg-gray-100 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Détails
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun emprunt trouvé</h3>
                        <p class="text-gray-500">Aucun emprunt n'a été trouvé pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($emprunts->hasMorePages())
                    <a href="{{ $emprunts->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Suivant
                    </a>
                @endif
                @if(!$emprunts->onFirstPage())
                    <a href="{{ $emprunts->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Précédent
                    </a>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Affichage de <span class="font-medium">{{ $emprunts->firstItem() }}</span> à 
                        <span class="font-medium">{{ $emprunts->lastItem() }}</span> sur 
                        <span class="font-medium">{{ $emprunts->total() }}</span> résultats
                    </p>
                </div>
                <div>
                    {{ $emprunts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de refus d'emprunt -->
<div id="refuserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Refuser l'emprunt</h3>
                <button type="button" onclick="closeRefuserModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="refuserForm" method="POST" action="">
                @csrf
                <input type="hidden" name="emprunt_id" id="emprunt_id">
                
                <div class="mb-4">
                    <label for="remarques" class="block text-sm font-medium text-gray-700 mb-2">
                        Motif du refus <span class="text-red-500">*</span>
                    </label>
                    <textarea name="remarques" id="remarques" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Veuillez indiquer le motif du refus..."></textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        Ce motif sera visible par l'emprunteur.
                    </p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRefuserModal()" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Refuser l'emprunt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRefuserModal(empruntId) {
    document.getElementById('emprunt_id').value = empruntId;
    document.getElementById('refuserForm').action = '/bibliothecaire/emprunt/' + empruntId + '/refuser';
    document.getElementById('refuserModal').classList.remove('hidden');
    document.getElementById('remarques').focus();
}

function closeRefuserModal() {
    document.getElementById('refuserModal').classList.add('hidden');
    document.getElementById('refuserForm').reset();
}

// Fermer la modal avec la touche Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRefuserModal();
    }
});
</script>
@endsection
