<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Livre;
use App\Models\Emprunt;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Export des emprunts en PDF
     */
    public function exportEmpruntsPDF()
    {
        $emprunts = Emprunt::with(['user', 'livre.categorie'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'emprunts' => $emprunts,
            'date_export' => Carbon::now()->format('d/m/Y H:i'),
            'total_emprunts' => $emprunts->count(),
            'emprunts_en_cours' => $emprunts->where('statut', 'en_cours')->count(),
            'emprunts_en_retard' => $emprunts->where('statut', 'en_retard')->count(),
        ];

        // Pour l'instant, on retourne une vue HTML (plus tard on convertira en PDF)
        return view('exports.emprunts_pdf', $data);
    }

    /**
     * Export des emprunts en Excel
     */
    public function exportEmpruntsExcel()
    {
        $emprunts = Emprunt::with(['user', 'livre.categorie'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Création du CSV simple (compatible Excel)
        $filename = "emprunts_" . date('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($emprunts) {
            $file = fopen('php://output', 'w');
            
            // En-tête CSV
            fputcsv($file, [
                'ID',
                'Utilisateur',
                'Livre',
                'Catégorie',
                'Date Emprunt',
                'Date Retour Prévue',
                'Date Retour Effectif',
                'Statut'
            ]);

            // Données
            foreach ($emprunts as $emprunt) {
                fputcsv($file, [
                    $emprunt->id,
                    $emprunt->user->getFullNameAttribute(),
                    $emprunt->livre->titre,
                    $emprunt->livre->categorie->nom ?? 'Non catégorisé',
                    $emprunt->date_emprunt->format('d/m/Y'),
                    $emprunt->date_retour_prevue->format('d/m/Y'),
                    $emprunt->date_retour_effectif ? $emprunt->date_retour_effectif->format('d/m/Y') : 'Non retourné',
                    ucfirst(str_replace('_', ' ', $emprunt->statut))
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export des statistiques en PDF
     */
    public function exportStatistiquesPDF()
    {
        $stats = [
            'total_users' => User::count(),
            'total_lecteurs' => User::where('role', 'Rlecteur')->count(),
            'total_livres' => Livre::count(),
            'livres_disponibles' => Livre::where('disponible', true)->count(),
            'total_emprunts' => Emprunt::count(),
            'emprunts_en_cours' => Emprunt::where('statut', 'en_cours')->count(),
            'emprunts_en_retard' => Emprunt::enRetard()->count(),
            'categories_count' => Categorie::count(),
        ];

        // Emprunts par mois
        $emprunts_par_mois = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $emprunts_par_mois[$month->format('M Y')] = Emprunt::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }
        krsort($emprunts_par_mois);

        $data = [
            'stats' => $stats,
            'emprunts_par_mois' => $emprunts_par_mois,
            'date_export' => Carbon::now()->format('d/m/Y H:i'),
        ];

        return view('exports.statistiques_pdf', $data);
    }

    /**
     * Export des livres en Excel
     */
    public function exportLivresExcel()
    {
        $livres = Livre::with(['categorie', 'auteurs'])
            ->orderBy('titre')
            ->get();

        $filename = "livres_" . date('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($livres) {
            $file = fopen('php://output', 'w');
            
            // En-tête CSV
            fputcsv($file, [
                'ID',
                'Titre',
                'ISBN',
                'Auteur(s)',
                'Catégorie',
                'Disponible',
                'Date Création'
            ]);

            // Données
            foreach ($livres as $livre) {
                fputcsv($file, [
                    $livre->id,
                    $livre->titre,
                    $livre->isbn ?? 'Non défini',
                    $livre->auteurs->pluck('nom')->implode(', '),
                    $livre->categorie->nom ?? 'Non catégorisé',
                    $livre->disponible ? 'Oui' : 'Non',
                    $livre->created_at->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export des utilisateurs en Excel
     */
    public function exportUsersExcel()
    {
        $users = User::orderBy('role')->orderBy('nom')->get();

        $filename = "utilisateurs_" . date('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // En-tête CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Prénom',
                'Login',
                'Email',
                'Téléphone',
                'Rôle',
                'Actif',
                'Date Création'
            ]);

            // Données
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->nom,
                    $user->prenom,
                    $user->login,
                    $user->email ?? 'Non défini',
                    $user->telephone ?? 'Non défini',
                    match($user->role) {
                        'Radmin' => 'Administrateur',
                        'Rbibliothecaire' => 'Bibliothécaire',
                        'Rlecteur' => 'Lecteur',
                        default => 'Inconnu'
                    },
                    $user->actif ? 'Oui' : 'Non',
                    $user->created_at->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
