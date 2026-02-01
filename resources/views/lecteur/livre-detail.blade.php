@extends('app')

@section('title', $livre->titre)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $livre->titre }}</h1>
                    <p class="mt-2 text-gray-600">Informations complètes sur ce livre</p>
                </div>
                <a href="{{ route('lecteur.catalogue') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au catalogue
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <!-- Image et informations de base -->
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3">
                            <div class="h-96 bg-gray-200 flex items-center justify-center">
                                @if($livre->image)
                                    <img src="/storage/{{ $livre->image }}" alt="{{ $livre->titre }}" 
                                         class="h-full w-full object-cover"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDMwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9IjkwIDEwMEgyMTBWMTUwSDkwVjEwMFoiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iMTIwIDE4MEgxODBWMjIwSDEyMFYxODBWiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'">
                                @else
                                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        <div class="md:w-2/3 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $livre->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $livre->disponible ? 'Disponible' : 'Indisponible' }}
                                </span>
                                @if($livre->prix)
                                    <span class="text-lg font-medium text-gray-900">{{ number_format($livre->prix, 0, ',', ' ') }} GNF</span>
                                @endif
                            </div>
                            
                            @if($livre->auteurs->count() > 0)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Auteur(s)</h3>
                                    <p class="text-lg text-gray-900">
                                        {{ $livre->auteurs->pluck('prenom')->implode(' ') . ' ' . $livre->auteurs->pluck('nom')->implode(' ') }}
                                    </p>
                                </div>
                            @endif
                            
                            @if($livre->categorie)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Catégorie</h3>
                                    <p class="text-lg text-gray-900">{{ $livre->categorie->libelle }}</p>
                                </div>
                            @endif
                            
                            @if($livre->isbn)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">ISBN</h3>
                                    <p class="text-lg text-gray-900">{{ $livre->isbn }}</p>
                                </div>
                            @endif
                            
                            @if($livre->resume)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Résumé</h3>
                                    <p class="text-gray-700 leading-relaxed">{{ $livre->resume }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Informations supplémentaires -->
                <div class="bg-white shadow rounded-lg p-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations supplémentaires</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date d'ajout</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $livre->created_at->format('d/m/Y') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dernière modification</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $livre->updated_at->format('d/m/Y') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Statut actuel</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $livre->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $livre->disponible ? 'Disponible à l\'emprunt' : 'Actuellement emprunté' }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre d'emprunts</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $livre->emprunts->count() }} fois</dd>
                        </div>
                    </div>
                </div>
                
                <!-- Historique des emprunts -->
                @if($livre->emprunts->count() > 0)
                    <div class="bg-white shadow rounded-lg p-6 mt-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Historique des emprunts</h2>
                        
                        <div class="space-y-3">
                            @foreach($livre->emprunts->take(5) as $emprunt)
                                <div class="border-l-4 border-gray-200 pl-4 py-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                Emprunté par {{ $emprunt->user->prenom }} {{ $emprunt->user->nom }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Du {{ $emprunt->date_emprunt->format('d/m/Y') }} 
                                                @if($emprunt->date_retour_effectif)
                                                    au {{ $emprunt->date_retour_effectif->format('d/m/Y') }}
                                                @else
                                                    (en cours)
                                                @endif
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($emprunt->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                            @elseif($emprunt->statut == 'en_cours') bg-green-100 text-green-800
                                            @elseif($emprunt->statut == 'en_retard') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($livre->emprunts->count() > 5)
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-500">
                                    et {{ $livre->emprunts->count() - 5 }} autre(s) emprunt(s)...
                                </p>
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
                        @if($livre->disponible)
                            @php
                                $dejaEmprunte = \App\Models\Emprunt::where('user_id', auth()->id())
                                    ->where('livre_id', $livre->id)
                                    ->whereIn('statut', ['en_attente', 'en_cours', 'en_retard'])
                                    ->exists();
                            @endphp
                            
                            @if($dejaEmprunte)
                                <button disabled class="w-full bg-orange-600 text-white px-4 py-3 rounded-md cursor-not-allowed flex items-center justify-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    Vous avez déjà emprunté ce livre
                                </button>
                                <p class="text-sm text-gray-500 text-center mt-2">
                                    Vous devez le retourner avant de pouvoir l'emprunter à nouveau.
                                </p>
                            @else
                                <form action="{{ route('lecteur.emprunt.demander', $livre->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-md hover:bg-green-700 transition-colors flex items-center justify-center">
                                        <i class="fas fa-book-reader mr-2"></i>
                                        Emprunter ce livre
                                    </button>
                                </form>
                            @endif
                        @else
                            <button disabled class="w-full bg-gray-400 text-white px-4 py-3 rounded-md cursor-not-allowed flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>
                                Indisponible
                            </button>
                        @endif
                        
                        <a href="{{ route('lecteur.catalogue') }}" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>
                            Chercher d'autres livres
                        </a>
                        
                        <a href="{{ route('lecteur.emprunts') }}" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i>
                            Mes emprunts
                        </a>
                    </div>
                    
                    <!-- Livres similaires -->
                    @if($livre->categorie)
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Livres similaires</h3>
                            <div class="space-y-2">
                                @php
                                    $similaires = App\Models\Livre::where('categorie_id', $livre->categorie_id)
                                        ->where('id', '!=', $livre->id)
                                        ->where('disponible', true)
                                        ->take(3)
                                        ->get();
                                @endphp
                                
                                @if($similaires->count() > 0)
                                    @foreach($similaires as $similaire)
                                        <a href="{{ route('lecteur.livre.show', $similaire->id) }}" class="block p-2 border rounded hover:bg-gray-50 transition-colors">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $similaire->titre }}</p>
                                            <p class="text-xs text-gray-500">{{ $similaire->auteurs->first()->prenom ?? '' }} {{ $similaire->auteurs->first()->nom ?? '' }}</p>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">Aucun livre similaire disponible</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclure la section des avis -->
@include('avis._section', ['livre' => $livre, 'avis' => $avis, 'moyenneNotes' => $moyenneNotes, 'totalAvis' => $totalAvis, 'repartitionNotes' => $repartitionNotes])
@endsection
