@extends('app')

@section('title', 'Détails de l\'Emprunt')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Détails de l'Emprunt</h1>
                    <p class="mt-2 text-gray-600">Informations complètes sur votre emprunt</p>
                </div>
                <a href="{{ route('lecteur.emprunts') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à mes emprunts
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations de l'Emprunt</h2>
                    
                    <!-- Livre -->
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="flex-shrink-0">
                            @if($emprunt->livre->image)
                                <img src="/storage/{{ $emprunt->livre->image }}" alt="{{ $emprunt->livre->titre }}" class="h-24 w-20 object-cover rounded">
                            @else
                                <div class="h-24 w-20 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">{{ $emprunt->livre->titre }}</h3>
                            
                            @if($emprunt->livre->auteurs->count() > 0)
                                <p class="text-sm text-gray-600 mt-1">
                                    Auteur(s) : {{ $emprunt->livre->auteurs->pluck('prenom')->implode(' ') . ' ' . $emprunt->livre->auteurs->pluck('nom')->implode(' ') }}
                                </p>
                            @endif
                            
                            @if($emprunt->livre->categorie)
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-tag mr-1"></i>{{ $emprunt->livre->categorie->libelle }}
                                </p>
                            @endif
                            
                            @if($emprunt->livre->resume)
                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($emprunt->livre->resume, 200) }}</p>
                            @endif
                            
                            @if($emprunt->livre->prix)
                                <p class="text-sm font-medium text-gray-900 mt-2">
                                    <i class="fas fa-tag mr-1"></i>{{ number_format($emprunt->livre->prix, 0, ',', ' ') }} GNF
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Détails de l'emprunt -->
                    <div class="border-t pt-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date d'emprunt</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $emprunt->date_emprunt->format('d/m/Y H:i') }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de retour prévue</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</dd>
                            </div>
                            
                            @if($emprunt->date_retour_effectif)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date de retour effectif</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $emprunt->date_retour_effectif->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
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
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    @if($emprunt->statut == 'en_retard')
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Retard constaté</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>Cet emprunt est en retard de {{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s).</p>
                                        @if($emprunt->penalite)
                                            <p class="mt-1">Une pénalité de {{ number_format($emprunt->penalite->montant, 0, ',', ' ') }} GNF a été appliquée.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($emprunt->statut == 'refuse' && $emprunt->remarques)
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Motif du refus</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ $emprunt->remarques }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Pénalités -->
                @if($emprunt->penalite)
                    <div class="bg-white shadow rounded-lg p-6 mt-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pénalité</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Montant</dt>
                                <dd class="mt-1 text-lg font-medium text-gray-900">{{ number_format($emprunt->penalite->montant, 0, ',', ' ') }} GNF</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut de paiement</dt>
                                <dd class="mt-1">
                                    @if($emprunt->penalite->payee)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Payée
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            Non payée
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de création</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $emprunt->penalite->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            
                            @if($emprunt->penalite->date_paiement)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date de paiement</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $emprunt->penalite->date_paiement->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                        </div>
                        
                        @if($emprunt->penalite->motif)
                            <div class="mt-4">
                                <dt class="text-sm font-medium text-gray-500">Motif</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $emprunt->penalite->motif }}</dd>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                    
                    <div class="space-y-3">
                        @if(auth()->user()->isLecteur() && $emprunt->statut == 'en_cours' && $emprunt->canBeExtended())
                            <form action="{{ route('lecteur.emprunt.prolonger', $emprunt->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    Demander une prolongation
                                </button>
                            </form>
                        @endif
                        
                        @if(auth()->user()->isLecteur())
                            <a href="{{ route('lecteur.catalogue') }}" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-book mr-2"></i>
                                Parcourir le catalogue
                            </a>
                            
                            <a href="{{ route('lecteur.emprunts') }}" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-list mr-2"></i>
                                Mes emprunts
                            </a>
                        @else
                            <a href="{{ route('bibliothecaire.emprunts.index') }}" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-list mr-2"></i>
                                Retour aux emprunts
                            </a>
                        @endif
                    </div>
                    
                    <!-- Informations supplémentaires -->
                    <div class="mt-6 pt-6 border-t">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Informations système</h3>
                        <dl class="space-y-1 text-sm text-gray-500">
                            <div>
                                <dt class="font-medium">ID Emprunt</dt>
                                <dd>{{ $emprunt->id }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium">ID Livre</dt>
                                <dd>{{ $emprunt->livre->id }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium">Créé le</dt>
                                <dd>{{ $emprunt->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @if($emprunt->updated_at != $emprunt->created_at)
                                <div>
                                    <dt class="font-medium">Modifié le</dt>
                                    <dd>{{ $emprunt->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
