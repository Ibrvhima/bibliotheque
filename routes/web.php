<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PenaliteController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SimpleExportController;
use App\Http\Controllers\AvisController;

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes Lecteur (Rlecteur)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Rlecteur'])->prefix('lecteur')->name('lecteur.')->group(function () {
    // Catalogue
    Route::get('/catalogue', [LivreController::class, 'catalogue'])->name('catalogue');
    Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livre.show');
    
    // Emprunts
    Route::get('/mes-emprunts', [EmpruntController::class, 'mesEmprunts'])->name('emprunts');
    Route::post('/emprunt/demander/{livre}', [EmpruntController::class, 'demander'])->name('emprunt.demander');
    Route::get('/emprunt/{id}', [EmpruntController::class, 'show'])->name('emprunt.show');
    
    // Avis
    Route::get('/avis/creer/{livre}', [AvisController::class, 'create'])->name('avis.create');
    Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::get('/avis/{avi}/modifier', [AvisController::class, 'edit'])->name('avis.edit');
    Route::put('/avis/{avi}', [AvisController::class, 'update'])->name('avis.update');
    Route::delete('/avis/{avi}', [AvisController::class, 'destroy'])->name('avis.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Bibliothécaire (Rbibliothecaire)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Rbibliothecaire,Radmin'])->prefix('bibliothecaire')->name('bibliothecaire.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'bibliothecaireDashboard'])->name('dashboard');
    
    // Gestion des livres
    Route::resource('livres', LivreController::class)->except(['show']);
    Route::get('/livre/{id}', [LivreController::class, 'show'])->name('livres.show');
    Route::post('/livre/{id}/toggle-disponibilite', [LivreController::class, 'toggleDisponibilite'])->name('livre.toggle');
    
    // Gestion des auteurs
    Route::resource('auteurs', AuteurController::class)->except(['show']);
    
    // Gestion des catégories
    Route::resource('categories', CategorieController::class)->except(['show']);
    
    // Gestion des emprunts
    Route::get('/emprunts', [EmpruntController::class, 'index'])->name('emprunts.index');
    Route::get('/emprunts/en-attente', [EmpruntController::class, 'enAttente'])->name('emprunts.en-attente');
    Route::get('/emprunts/en-retard', [EmpruntController::class, 'enRetard'])->name('emprunts.en-retard');
    Route::post('/emprunt/{id}/valider', [EmpruntController::class, 'valider'])->name('emprunt.valider');
    Route::post('/emprunt/{id}/refuser', [EmpruntController::class, 'refuser'])->name('emprunt.refuser');
    Route::post('/emprunt/{id}/retour', [EmpruntController::class, 'validerRetour'])->name('emprunt.retour');
    Route::post('/emprunt/{id}/prolonger', [EmpruntController::class, 'prolonger'])->name('emprunt.prolonger');
    Route::get('/emprunt/{id}', [EmpruntController::class, 'show'])->name('emprunt.show');
});

/*
|--------------------------------------------------------------------------
| Routes Administrateur (Radmin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Radmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');
    Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [DashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{id}/toggle', [DashboardController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::delete('/users/{id}', [DashboardController::class, 'deleteUser'])->name('users.delete');
    
    // Gestion des livres (avec suppression)
    Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
    Route::delete('/livres/{id}', [LivreController::class, 'destroy'])->name('livres.destroy');
    
    // Gestion des emprunts (avec suppression)
    Route::delete('/emprunts/{id}', [EmpruntController::class, 'destroy'])->name('emprunts.destroy');
    
    // Gestion des pénalités
    Route::get('/penalites', [PenaliteController::class, 'index'])->name('penalites.index');
    Route::post('/penalite/{id}/marquer-payee', [PenaliteController::class, 'marquerPayee'])->name('penalite.payer');
    
    // Modération des avis
    Route::get('/avis/moderation', [AvisController::class, 'moderation'])->name('avis.moderation');
    Route::post('/avis/{avi}/approuver', [AvisController::class, 'approuver'])->name('avis.approuver');
    Route::post('/avis/{avi}/rejeter', [AvisController::class, 'rejeter'])->name('avis.rejeter');
    
    // Exports
    Route::get('/export/emprunts/pdf', [ExportController::class, 'exportEmpruntsPDF'])->name('export.emprunts.pdf');
    Route::get('/export/emprunts/excel', [ExportController::class, 'exportEmpruntsExcel'])->name('export.emprunts.excel');
    Route::get('/export/statistiques/pdf', [ExportController::class, 'exportStatistiquesPDF'])->name('export.statistiques.pdf');
    Route::get('/export/livres/excel', [ExportController::class, 'exportLivresExcel'])->name('export.livres.excel');
    Route::get('/export/users/excel', [ExportController::class, 'exportUsersExcel'])->name('export.users.excel');
    
    // Routes de test (simple)
    Route::get('/test/export/emprunts/pdf', [SimpleExportController::class, 'exportEmpruntsPDF'])->name('test.export.emprunts.pdf');
    Route::get('/test/export/emprunts/excel', [SimpleExportController::class, 'exportEmpruntsExcel'])->name('test.export.emprunts.excel');
    
    // Statistiques
    Route::get('/statistiques', [DashboardController::class, 'statistiques'])->name('statistiques');
});
