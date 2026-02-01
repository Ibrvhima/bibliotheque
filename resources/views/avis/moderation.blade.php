@extends('app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                <h1 class="text-2xl font-bold text-white">Modération des Avis</h1>
                <p class="text-purple-100 mt-2">Validez ou rejetez les avis soumis par les lecteurs</p>
            </div>

            <div class="p-6">
                @if($avisEnAttente->count() > 0)
                    <div class="mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-blue-800">
                                    <strong>{{ $avisEnAttente->count() }}</strong> avis en attente de validation
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($avisEnAttente as $avi)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- En-tête de l'avis -->
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                            {{ strtoupper(substr($avi->user->nom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $avi->user->getFullNameAttribute() }}</h4>
                                            <p class="text-sm text-gray-500">{{ $avi->user->email }}</p>
                                            <p class="text-xs text-gray-400">Avis soumis le {{ $avi->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                    </div>

                                    <!-- Détails du livre -->
                                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700">
                                            <strong>Livre :</strong> {{ $avi->livre->titre }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <strong>Auteur(s) :</strong> {{ $avi->livre->auteurs->pluck('nom')->implode(', ') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <strong>Catégorie :</strong> {{ $avi->livre->categorie->libelle ?? 'Non catégorisé' }}
                                        </p>
                                    </div>

                                    <!-- Note et commentaire -->
                                    <div class="mb-4">
                                        <div class="flex items-center mb-2">
                                            <span class="text-2xl mr-2">{{ $avi->note_eoiles }}</span>
                                            <span class="text-lg font-semibold text-gray-700">{{ $avi->note }}/5</span>
                                        </div>
                                        
                                        @if($avi->commentaire)
                                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                                            <h5 class="font-medium text-gray-700 mb-2">Commentaire :</h5>
                                            <p class="text-gray-600">{{ $avi->commentaire }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-3">
                                        <form action="{{ route('admin.avis.approuver', $avi) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Approuver
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.avis.rejeter', $avi) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir rejeter cet avis ? Cette action est irréversible.')">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Rejeter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($avisEnAttente->hasPages())
                    <div class="mt-8">
                        {{ $avisEnAttente->links() }}
                    </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tout est à jour !</h3>
                        <p class="text-gray-500">Aucun avis en attente de validation.</p>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Retour au dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
