@extends('app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                <h1 class="text-2xl font-bold text-white">Donner votre avis</h1>
                <p class="text-blue-100 mt-2">{{ $livre->titre }}</p>
            </div>

            <div class="p-6">
                <form action="{{ route('avis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="livre_id" value="{{ $livre->id }}">

                    <!-- Note -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Note <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="note" value="{{ $i }}" class="hidden" required>
                                    <span class="star text-3xl text-gray-300 hover:text-yellow-400 transition-colors" data-rating="{{ $i }}">
                                        ☆
                                    </span>
                                </label>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Cliquez sur les étoiles pour noter</p>
                    </div>

                    <!-- Commentaire -->
                    <div class="mb-6">
                        <label for="commentaire" class="block text-gray-700 text-sm font-bold mb-2">
                            Commentaire (optionnel)
                        </label>
                        <textarea 
                            id="commentaire" 
                            name="commentaire" 
                            rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Partagez votre expérience avec ce livre..."
                            maxlength="1000"
                        ></textarea>
                        <p class="text-sm text-gray-500 mt-1">
                            <span id="charCount">0</span>/1000 caractères
                        </p>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-between">
                        <a href="{{ route('livres.show', $livre->id) }}" 
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Soumettre l'avis
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold">Règles d'avis :</p>
                    <ul class="mt-1 list-disc list-inside space-y-1">
                        <li>Vous devez avoir emprunté et retourné ce livre pour donner un avis</li>
                        <li>Un seul avis par livre et par utilisateur</li>
                        <li>Les avis sont modérés avant publication</li>
                        <li>Soyez respectueux et constructif dans vos commentaires</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const commentTextarea = document.getElementById('commentaire');
    const charCount = document.getElementById('charCount');

    // Gestion des étoiles
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            const radio = document.querySelector(`input[name="note"][value="${rating}"]`);
            radio.checked = true;
            updateStars(rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            updateStars(rating);
        });
    });

    document.querySelector('.flex.items-center.space-x-2').addEventListener('mouseleave', function() {
        const checkedRadio = document.querySelector('input[name="note"]:checked');
        const rating = checkedRadio ? parseInt(checkedRadio.value) : 0;
        updateStars(rating);
    });

    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.textContent = '⭐';
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300');
            } else {
                star.textContent = '☆';
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    // Compteur de caractères
    commentTextarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length;
        
        if (length > 900) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    });
});
</script>
@endsection
