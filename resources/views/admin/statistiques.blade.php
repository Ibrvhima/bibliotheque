@extends('app')

@section('title', 'Statistiques')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Statistiques de la bibliothèque</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Vue d'ensemble détaillée des activités de la bibliothèque</p>
        </div>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-3 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Utilisateurs</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['total_users'] }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Livres</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['total_livres'] }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Emprunts en cours</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['emprunts_en_cours'] }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Emprunts en retard</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['emprunts_en_retard'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique des emprunts par mois -->
        <div class="bg-white shadow rounded-lg mb-6 sm:mb-8">
            <div class="px-3 sm:px-4 py-4 sm:py-5 sm:p-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">Évolution des emprunts par mois</h3>
                <div class="space-y-3 sm:space-y-4">
                    @forelse ($empruntsParMois as $data)
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                            <div class="w-full sm:w-24 text-sm text-gray-600 font-medium">
                                {{ date('F', mktime(0, 0, 0, $data->mois, 1)) }}
                            </div>
                            <div class="flex-1 sm:mx-4">
                                <div class="bg-gray-200 rounded-full h-6 sm:h-8 relative">
                                    <div class="bg-blue-600 h-6 sm:h-8 rounded-full flex items-center justify-end pr-2" 
                                         style="width: {{ $data->total > 0 ? min(($data->total / $empruntsParMois->max('total')) * 100, 100) : 0 }}%">
                                        <span class="text-xs text-white font-medium">{{ $data->total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Aucune donnée disponible</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            <!-- Top livres -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-3 sm:px-4 py-4 sm:py-5 sm:p-6">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">Livres les plus empruntés</h3>
                    <div class="space-y-2 sm:space-y-3">
                        @forelse ($topLivres as $index => $livre)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1 min-w-0">
                                    <span class="flex-shrink-0 w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $livre->titre }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $livre->auteur ?? 'Auteur inconnu' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs sm:text-sm font-medium text-gray-900 ml-2 flex-shrink-0">{{ $livre->emprunts_count }} <span class="hidden sm:inline">emprunts</span></span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Aucun emprunt enregistré</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Top lecteurs -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-3 sm:px-4 py-4 sm:py-5 sm:p-6">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">Lecteurs les plus actifs</h3>
                    <div class="space-y-2 sm:space-y-3">
                        @forelse ($topLecteurs as $index => $lecteur)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1 min-w-0">
                                    <span class="flex-shrink-0 w-6 h-6 sm:w-8 sm:h-8 bg-green-100 text-green-800 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $lecteur->login }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $lecteur->nom }} {{ $lecteur->prenom }}</p>
                                    </div>
                                </div>
                                <span class="text-xs sm:text-sm font-medium text-gray-900 ml-2 flex-shrink-0">{{ $lecteur->emprunts_count }} <span class="hidden sm:inline">emprunts</span></span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Aucun lecteur actif</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="mt-6 sm:mt-8">
            <div class="bg-white shadow rounded-lg p-4 sm:p-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-3 sm:mb-4">Actions rapides</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 sm:p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 truncate">Gérer les utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.livres.index') }}" class="flex items-center p-3 sm:p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 truncate">Gérer les livres</span>
                    </a>
                    <a href="{{ route('admin.penalites.index') }}" class="flex items-center p-3 sm:p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900 truncate">Gérer les pénalités</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
