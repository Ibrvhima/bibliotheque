@extends('app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des utilisateurs</h1>
                    <p class="mt-2 text-gray-600">Gérez les comptes utilisateurs de la bibliothèque</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter un utilisateur
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nom, login, email...">
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                        <select name="role" id="role" class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tous les rôles</option>
                            <option value="Radmin" {{ request('role') == 'Radmin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="Rbibliothecaire" {{ request('role') == 'Rbibliothecaire' ? 'selected' : '' }}>Bibliothécaire</option>
                            <option value="Rlecteur" {{ request('role') == 'Rlecteur' ? 'selected' : '' }}>Lecteur</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select name="statut" id="statut" class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg transition-colors text-center">
                        <i class="fas fa-times mr-2"></i>
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau des utilisateurs -->
        <!-- Version Desktop -->
        <div class="hidden lg:block bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Login</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->login }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->nom }} {{ $user->prenom }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($user->role == 'Radmin') bg-purple-100 text-purple-800
                                        @elseif($user->role == 'Rbibliothecaire') bg-blue-100 text-blue-800
                                        @elseif($user->role == 'Rlecteur') bg-gray-300 text-gray-800
                                        else bg-gray-200 text-gray-800
                                        @endif">
                                        @if($user->role == 'Radmin') Administrateur
                                        @elseif($user->role == 'Rbibliothecaire') Bibliothécaire
                                        @else Lecteur
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($user->actif) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $user->actif ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button type="button" 
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                    title="{{ $user->actif ? 'Désactiver' : 'Activer' }}"
                                                    onclick="confirmToggle({{ $user->id }}, '{{ $user->actif ? 'Désactiver' : 'Activer' }}', '{{ $user->login }}')">
                                                @if($user->actif)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <form id="toggle-{{ $user->id }}" action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="hidden">
                                                @csrf
                                            </form>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Supprimer"
                                                    onclick="showConfirmModal(
                                                        'Supprimer l\'utilisateur',
                                                        'Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.',
                                                        function() { document.getElementById('delete-{{ $user->id }}').submit(); }
                                                    )">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 016.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            <form id="delete-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun utilisateur trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Version Mobile -->
        <div class="lg:hidden">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->login }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->nom }} {{ $user->prenom }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($user->role == 'Radmin') bg-purple-100 text-purple-800
                                            @elseif($user->role == 'Rbibliothecaire') bg-blue-100 text-blue-800
                                            @elseif($user->role == 'Rlecteur') bg-gray-300 text-gray-800
                                            else bg-gray-200 text-gray-800
                                            @endif">
                                            @if($user->role == 'Radmin') Admin
                                            @elseif($user->role == 'Rbibliothecaire') Biblio
                                            @else Lecteur
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($user->actif) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $user->actif ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-1 justify-end">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 p-2 rounded hover:bg-indigo-100" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($user->id !== auth()->id())
                                                <button type="button" 
                                                        class="text-yellow-600 hover:text-yellow-900 p-2 rounded hover:bg-yellow-100"
                                                        title="{{ $user->actif ? 'Désactiver' : 'Activer' }}"
                                                        onclick="confirmToggle({{ $user->id }}, '{{ $user->actif ? 'Désactiver' : 'Activer' }}', '{{ $user->login }}')">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            @endif
                                            
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-100"
                                                    title="Supprimer"
                                                    onclick="showConfirmModal(
                                                        'Supprimer l\'utilisateur',
                                                        'Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.',
                                                        function() { document.getElementById('delete-{{ $user->id }}').submit(); }
                                                    )">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">
                                        Aucun utilisateur trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <!-- Mobile Pagination -->
                <div class="flex flex-col sm:hidden space-y-2">
                    <div class="text-sm text-gray-700 text-center">
                        Page {{ $users->currentPage() }} sur {{ $users->lastPage() }}
                        <span class="text-xs text-gray-500">({{ $users->total() }} utilisateurs)</span>
                    </div>
                    <div class="flex justify-center items-center space-x-1">
                        {{-- Previous --}}
                        @if($users->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 text-sm text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                        
                        {{-- Page Numbers --}}
                        @foreach(range(1, $users->lastPage()) as $page)
                            @if($page == $users->currentPage())
                                <span class="px-3 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium">
                                    {{ $page }}
                                </span>
                            @elseif(abs($page - $users->currentPage()) <= 2)
                                <a href="{{ $users->url($page) }}" class="px-3 py-2 text-sm text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    {{ $page }}
                                </a>
                            @elseif($page == 1 || $page == $users->lastPage())
                                <a href="{{ $users->url($page) }}" class="px-3 py-2 text-sm text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    {{ $page }}
                                </a>
                            @elseif(abs($page - $users->currentPage()) == 3)
                                <span class="px-2 py-2 text-sm text-gray-400">...</span>
                            @endif
                        @endforeach
                        
                        {{-- Next --}}
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 text-sm text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Desktop Pagination -->
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Affichage de <span class="font-medium">{{ $users->firstItem() }}</span> à 
                            <span class="font-medium">{{ $users->lastItem() }}</span> sur 
                            <span class="font-medium">{{ $users->total() }}</span> résultats
                        </p>
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function confirmToggle(userId, title, userLogin) {
    showConfirmModal(
        title,
        'Êtes-vous sûr de vouloir ' + title.toLowerCase() + ' l\'utilisateur ' + userLogin + ' ?',
        function() {
            console.log('Soumission du formulaire toggle pour l\'utilisateur ID:', userId);
            const form = document.getElementById('toggle-' + userId);
            if (form) {
                form.submit();
            } else {
                console.error('Formulaire non trouvé pour l\'ID:', userId);
                alert('Erreur: Formulaire non trouvé');
            }
        }
    );
}
</script>
