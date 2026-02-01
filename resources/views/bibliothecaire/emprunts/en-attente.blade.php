@extends('app')

@section('title', 'Emprunts en Attente')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Emprunts en Attente</h1>
            <p class="mt-2 text-gray-600">Validation des demandes d'emprunt</p>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('bibliothecaire.emprunts.en-attente') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" name="search" placeholder="Rechercher par utilisateur, livre..." 
                           value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    Rechercher
                </button>
                @if(request('search'))
                    <a href="{{ route('bibliothecaire.emprunts.en-attente') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        <!-- Liste des emprunts -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($emprunts->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($emprunts as $emprunt)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <!-- Avatar utilisateur -->
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-medium text-lg">{{ $emprunt->user->initials }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Informations -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">
                                                        {{ $emprunt->user->getFullNameAttribute() }}
                                                    </h3>
                                                    <p class="text-sm text-gray-500">{{ $emprunt->user->login }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $emprunt->user->getRoleDisplayAttribute() }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-2">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $emprunt->livre->titre }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $emprunt->livre->auteurs->pluck('nom')->implode(', ') }} • 
                                                    {{ $emprunt->livre->categorie->nom }}
                                                </p>
                                            </div>
                                            
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                                <span>
                                                    <i class="fas fa-calendar-alt mr-1"></i>
                                                    Demandé le {{ $emprunt->created_at->format('d/m/Y H:i') }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Retour prévu le {{ $emprunt->date_retour_prevue->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('bibliothecaire.emprunt.valider', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition-colors flex items-center">
                                                <i class="fas fa-check mr-1"></i>
                                                Valider
                                            </button>
                                        </form>
                                        
                                        <button type="button" onclick="openRefuserModal({{ $emprunt->id }})" class="bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition-colors flex items-center">
                                            <i class="fas fa-times mr-1"></i>
                                            Refuser
                                        </button>
                                        
                                        <a href="{{ route('bibliothecaire.emprunt.show', $emprunt->id) }}" class="bg-gray-600 text-white px-3 py-2 rounded text-sm hover:bg-gray-700 transition-colors flex items-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($emprunts->hasMorePages())
                            <a href="{{ $emprunts->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </a>
                        @endif
                        @if($emprunts->hasPreviousPages())
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
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune demande en attente</h3>
                    <p class="mt-1 text-sm text-gray-500">Toutes les demandes d'emprunt ont été traitées.</p>
                    <div class="mt-6">
                        <a href="{{ route('bibliothecaire.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour au dashboard
                        </a>
                    </div>
                </div>
            @endif
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
