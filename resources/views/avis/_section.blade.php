<!-- Section Avis et Notes -->
@if($moyenneNotes || $avis->count() > 0)
<div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6">
        <h2 class="text-2xl font-bold text-white">Avis et Notes</h2>
    </div>

    <div class="p-6">
        <!-- Statistiques -->
        @if($moyenneNotes)
        <div class="mb-6 bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center">
                        <span class="text-3xl font-bold text-gray-800">{{ number_format($moyenneNotes, 1) }}</span>
                        <span class="text-2xl ml-2">{{ str_repeat('⭐', round($moyenneNotes)) }}</span>
                    </div>
                    <p class="text-gray-600 mt-1">{{ $totalAvis }} avis</p>
                </div>
                
                @if($repartitionNotes)
                <div class="flex-1 ml-8">
                    @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center mb-1">
                        <span class="text-sm w-8">{{ $i }}⭐</span>
                        <div class="flex-1 mx-2 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $totalAvis > 0 ? ($repartitionNotes[$i] / $totalAvis) * 100 : 0 }}%"></div>
                        </div>
                        <span class="text-sm w-8 text-right">{{ $repartitionNotes[$i] }}</span>
                    </div>
                    @endfor
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Bouton pour donner un avis -->
        @if(auth()->check() && auth()->user()->role === 'Rlecteur')
            <?php
            $aEmprunte = \App\Models\Emprunt::where('user_id', auth()->id())
                ->where('livre_id', $livre->id)
                ->where('statut', 'retourne')
                ->exists();
            
            $aDejaAvis = \App\Models\Avis::where('user_id', auth()->id())
                ->where('livre_id', $livre->id)
                ->exists();
            ?>
            
            @if($aEmprunte && !$aDejaAvis)
            <div class="mb-6 text-center">
                <a href="{{ route('avis.create', $livre->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Donner votre avis
                </a>
            </div>
            @elseif($aDejaAvis)
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 text-sm">✅ Vous avez déjà donné votre avis pour ce livre.</p>
            </div>
            @elseif(!$aEmprunte)
            <div class="mb-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                <p class="text-gray-600 text-sm">📚 Vous devez avoir emprunté et retourné ce livre pour donner un avis.</p>
            </div>
            @endif
        @endif

        <!-- Liste des avis -->
        @if($avis->count() > 0)
        <div class="space-y-4">
            @foreach($avis as $avi)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                {{ strtoupper(substr($avi->user->nom, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $avi->user->getFullNameAttribute() }}</h4>
                                <div class="flex items-center">
                                    <span class="text-yellow-400">{{ $avi->note_eoiles }}</span>
                                    <span class="text-gray-500 text-sm ml-2">{{ $avi->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($avi->commentaire)
                        <p class="text-gray-700 mt-2">{{ $avi->commentaire }}</p>
                        @endif
                    </div>
                    
                    <!-- Actions pour l'auteur ou admin -->
                    @if(auth()->check() && (auth()->user()->id === $avi->user_id || auth()->user()->role === 'Radmin'))
                    <div class="ml-4 flex space-x-2">
                        @if(auth()->user()->id === $avi->user_id)
                        <a href="{{ route('avis.edit', $avi) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Modifier
                        </a>
                        @endif
                        
                        <form action="{{ route('avis.destroy', $avi) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800 text-sm"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($avis->hasPages())
        <div class="mt-6">
            {{ $avis->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p>Aucun avis pour ce livre</p>
            <p class="text-sm mt-2">Soyez le premier à donner votre avis !</p>
        </div>
        @endif
    </div>
</div>
@endif
