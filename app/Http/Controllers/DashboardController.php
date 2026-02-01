<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Livre;
use App\Models\Emprunt;
use App\Models\Penalite;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_lecteurs' => User::where('role', 'Rlecteur')->count(),
            'total_bibliothecaires' => User::where('role', 'Rbibliothecaire')->count(),
            'total_livres' => Livre::count(),
            'livres_disponibles' => Livre::where('disponible', true)->count(),
            'total_emprunts' => Emprunt::count(),
            'emprunts_en_cours' => Emprunt::where('statut', 'en_cours')->count(),
            'emprunts_en_retard' => Emprunt::enRetard()->count(),
            'emprunts_en_attente' => Emprunt::where('statut', 'en_attente')->count(),
            'total_penalites' => Penalite::sum('montant'),
            'penalites_impayees' => Penalite::where('payee', false)->sum('montant'),
        ];

        // Emprunts récents
        $emprunts_recents = Emprunt::with(['user', 'livre'])
            ->latest()
            ->take(10)
            ->get();

        // Livres les plus empruntés
        $livres_populaires = Livre::withCount('emprunts')
            ->orderBy('emprunts_count', 'desc')
            ->take(5)
            ->get();

        // Catégories les plus empruntées
        $categories_populaires = Categorie::withCount(['livres' => function($query) {
                $query->withCount('emprunts');
            }])
            ->get()
            ->map(function($categorie) {
                $categorie->total_emprunts = $categorie->livres->sum('emprunts_count');
                return $categorie;
            })
            ->sortByDesc('total_emprunts')
            ->take(8);

        // Distribution par catégorie
        $categories = Categorie::withCount('livres')->get();

        // Emprunts par mois pour les graphiques
        $emprunts_par_mois = Emprunt::selectRaw('MONTH(date_emprunt) as mois_num, MONTHNAME(date_emprunt) as mois, COUNT(*) as total')
            ->whereYear('date_emprunt', date('Y'))
            ->groupBy('mois_num', 'mois')
            ->orderBy('mois_num')
            ->get();

        return view('admin.dashboard', compact('stats', 'emprunts_recents', 'livres_populaires', 'categories', 'categories_populaires', 'emprunts_par_mois'));
    }

    /**
     * Dashboard Bibliothécaire
     */
    public function bibliothecaireDashboard()
    {
        $stats = [
            'emprunts_en_attente' => Emprunt::where('statut', 'en_attente')->count(),
            'emprunts_en_cours' => Emprunt::where('statut', 'en_cours')->count(),
            'emprunts_en_retard' => Emprunt::enRetard()->count(),
            'livres_disponibles' => Livre::where('disponible', true)->count(),
            'total_livres' => Livre::count(),
        ];

        // Emprunts en attente de validation
        $emprunts_en_attente = Emprunt::with(['user', 'livre'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        // Emprunts en retard
        $emprunts_en_retard = Emprunt::with(['user', 'livre', 'penalite'])
            ->enRetard()
            ->latest('date_retour_prevue')
            ->take(10)
            ->get();

        // Activité du jour
        $today = Carbon::today();
        $activite = [
            'emprunts_today' => Emprunt::whereDate('date_emprunt', $today)->count(),
            'retours_today' => Emprunt::whereDate('date_retour_effective', $today)->count(),
        ];

        return view('bibliothecaire.dashboard', compact('stats', 'emprunts_en_attente', 'emprunts_en_retard', 'activite'));
    }

    /**
     * Gestion des utilisateurs (Admin)
     */
    public function users()
    {
        $query = User::latest();
        
        // Filtrer par recherche
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('login', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtrer par rôle
        if ($role = request('role')) {
            $query->where('role', $role);
        }
        
        // Filtrer par statut
        if ($statut = request('statut')) {
            $query->where('actif', $statut === 'actif');
        }
        
        $users = $query->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Créer un utilisateur
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistrer un utilisateur
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string|unique:users,login|max:255',
            'password' => 'required|string|min:8',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'role' => 'required|in:Radmin,Rbibliothecaire,Rlecteur',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['actif'] = $request->has('actif') ? 1 : 0;
        
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été créé avec succès.');
    }

    /**
     * Éditer un utilisateur
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'login' => 'required|string|max:255|unique:users,login,' . $id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'role' => 'required|in:Radmin,Rbibliothecaire,Rlecteur',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $validated['actif'] = $request->has('actif') ? 1 : 0;

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été mis à jour avec succès.');
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleUserStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Empêcher de se désactiver soi-même
            if ($user->id === auth()->id()) {
                return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
            }

            $oldStatus = $user->actif;
            $user->update(['actif' => !$user->actif]);
            $newStatus = $user->actif;

            $status = $newStatus ? 'activé' : 'désactivé';
            
            return back()->with('success', "L'utilisateur {$user->login} a été {$status} (ancien statut: {$oldStatus}, nouveau: {$newStatus}).");
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Empêcher de se supprimer soi-même
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Vérifier s'il y a des emprunts en cours
        if ($user->emprunts()->whereIn('statut', ['en_cours', 'valide'])->exists()) {
            return back()->with('error', 'Impossible de supprimer cet utilisateur car il a des emprunts en cours.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été supprimé avec succès.');
    }

    /**
     * Statistiques détaillées (Admin)
     */
    public function statistiques()
    {
        // Stats générales
        $stats = [
            'total_users' => User::count(),
            'total_livres' => Livre::count(),
            'total_emprunts' => Emprunt::count(),
            'emprunts_en_cours' => Emprunt::where('statut', 'en_cours')->count(),
            'emprunts_retournes' => Emprunt::where('statut', 'retourne')->count(),
            'emprunts_en_retard' => Emprunt::enRetard()->count(),
        ];

        // Emprunts par mois (6 derniers mois)
        $empruntsParMois = Emprunt::selectRaw('MONTH(date_emprunt) as mois, COUNT(*) as total')
            ->whereYear('date_emprunt', date('Y'))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Top 10 livres les plus empruntés
        $topLivres = Livre::withCount('emprunts')
            ->orderBy('emprunts_count', 'desc')
            ->take(10)
            ->get();

        // Lecteurs les plus actifs
        $topLecteurs = User::where('role', 'Rlecteur')
            ->withCount('emprunts')
            ->orderBy('emprunts_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.statistiques', compact('stats', 'empruntsParMois', 'topLivres', 'topLecteurs'));
    }
}
