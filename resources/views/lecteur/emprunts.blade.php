@extends('app')

@section('title', 'Mes Emprunts')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Mes Emprunts</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Suivez vos emprunts en cours et votre historique</p>
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
                                    {{ App\Models\Emprunt::where('user_id', auth()->id())->where('statut', 'en_attente')->count() }}
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
                                    {{ App\Models\Emprunt::where('user_id', auth()->id())->where('statut', 'en_cours')->count() }}
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
                                    {{ App\Models\Emprunt::where('user_id', auth()->id())->where('statut', 'en_retard')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:gap-4">
                <a href="{{ route('lecteur.catalogue') }}" class="bg-blue-600 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center text-sm sm:text-base min-w-[44px] min-h-[44px]">
                    <i class="fas fa-book mr-2"></i>
                    <span class="hidden sm:inline">Parcourir le catalogue</span>
                    <span class="sm:hidden">Catalogue</span>
                </a>
                <a href="{{ route('lecteur.catalogue') }}?disponible=1" class="bg-green-600 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-md hover:bg-green-700 transition-colors flex items-center justify-center text-sm sm:text-base min-w-[44px] min-h-[44px]">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="hidden sm:inline">Livres disponibles</span>
                    <span class="sm:hidden">Disponibles</span>
                </a>
            </div>
        </div>

        <!-- Liste des emprunts -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($emprunts->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($emprunts as $emprunt)
                        <li class="hover:bg-gray-50">
                            <div class="px-3 sm:px-4 py-3 sm:py-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-0">
                                    <div class="flex items-start sm:items-center space-x-3 sm:space-x-4">
                                        <!-- Livre -->
                                        <div class="flex-shrink-0">
                                            @if($emprunt->livre->image)
                                                <img src="/storage/{{ $emprunt->livre->image }}" alt="{{ $emprunt->livre->titre }}" class="h-10 w-10 sm:h-12 sm:w-12 object-cover rounded">
                                            @else
                                                <div class="h-10 w-10 sm:h-12 sm:w-12 bg-gray-200 rounded flex items-center justify-center">
                                                    <i class="fas fa-book text-gray-400 text-sm sm:text-base"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Informations de l'emprunt -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 gap-2 sm:gap-0">
                                                <h3 class="text-sm sm:text-sm font-medium text-gray-900 truncate">{{ $emprunt->livre->titre }}</h3>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full inline-flex items-center justify-center min-w-[60px]
                                                    @if($emprunt->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                                    @elseif($emprunt->statut == 'en_cours') bg-green-100 text-green-800
                                                    @elseif($emprunt->statut == 'en_retard') bg-red-100 text-red-800
                                                    @elseif($emprunt->statut == 'refuse') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    @if($emprunt->statut == 'refuse')
                                                        Refusé
                                                    @else
                                                        {{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            <div class="mt-1 text-xs sm:text-sm text-gray-500">
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                                    <span><i class="fas fa-calendar mr-1"></i> Du {{ $emprunt->date_emprunt->format('d/m/Y') }} au {{ $emprunt->date_retour_prevue->format('d/m/Y') }}</span>
                                                    @if($emprunt->livre->prix)
                                                        <span class="hidden sm:inline">•</span>
                                                        <span><i class="fas fa-tag mr-1"></i>{{ number_format($emprunt->livre->prix, 0, ',', ' ') }} GNF</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($emprunt->date_retour_effectif)
                                                <p class="mt-1 text-xs sm:text-sm text-gray-500">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Retourné le {{ $emprunt->date_retour_effectif->format('d/m/Y') }}
                                                </p>
                                            @endif
                                            
                                            @if($emprunt->statut == 'en_retard')
                                                <p class="mt-1 text-xs sm:text-sm text-red-600">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Retard de {{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s)
                                                </p>
                                            @endif
                                            
                                            @if($emprunt->penalite)
                                                <p class="mt-1 text-xs sm:text-sm text-orange-600">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Pénalité : {{ number_format($emprunt->penalite->montant, 0, ',', ' ') }} GNF
                                                    @if($emprunt->penalite->payee)
                                                        <span class="text-green-600">(Payée)</span>
                                                    @else
                                                        <span class="text-red-600">(Non payée)</span>
                                                    @endif
                                                </p>
                                            @endif
                                            
                                            @if($emprunt->statut == 'refuse' && $emprunt->remarques)
                                                <div class="mt-2 sm:mt-3 p-2 sm:p-3 bg-red-50 border border-red-200 rounded-md">
                                                    <p class="text-xs sm:text-sm font-medium text-red-800 mb-1">
                                                        <i class="fas fa-info-circle mr-1"></i>
                                                        Motif du refus :
                                                    </p>
                                                    <p class="text-xs sm:text-sm text-red-700">{{ $emprunt->remarques }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                                        <a href="{{ route('lecteur.emprunt.show', $emprunt->id) }}" class="bg-gray-600 text-white px-3 py-2 rounded text-xs sm:text-sm hover:bg-gray-700 transition-colors flex items-center justify-center min-w-[44px] min-h-[44px]">
                                            <i class="fas fa-eye mr-1"></i>
                                            <span class="hidden sm:inline">Détails</span>
                                            <span class="sm:hidden">Voir</span>
                                        </a>
                                        
                                        @if($emprunt->statut == 'en_cours' && $emprunt->canBeExtended())
                                            <form action="{{ route('lecteur.emprunt.prolonger', $emprunt->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded text-xs sm:text-sm hover:bg-blue-700 transition-colors flex items-center justify-center min-w-[44px] min-h-[44px]">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span class="hidden sm:inline">Prolonger</span>
                                                    <span class="sm:hidden">+</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <!-- Pagination -->
                <div class="bg-white px-3 sm:px-4 py-3 border-t border-gray-200">
                    {{ $emprunts->links() }}
                </div>
            @else
                <div class="text-center py-8 sm:py-12">
                    <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun emprunt trouvé</h3>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">Vous n'avez pas encore d'emprunt.</p>
                    <div class="mt-4 sm:mt-6">
                        <a href="{{ route('lecteur.catalogue') }}" class="inline-flex items-center px-3 sm:px-4 py-2 sm:py-2.5 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 min-w-[44px] min-h-[44px]">
                            <i class="fas fa-book mr-2"></i>
                            <span class="hidden sm:inline">Parcourir le catalogue</span>
                            <span class="sm:hidden">Catalogue</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
