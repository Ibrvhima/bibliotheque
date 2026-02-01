<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpruntController extends Controller
{
    /**
     * Afficher les emprunts du lecteur connecté
     */
    public function mesEmprunts()
    {
        $emprunts = auth()->user()->emprunts()
            ->with(['livre.categorie', 'livre.auteurs', 'penalite'])
            ->latest()
            ->paginate(10);

        return view('lecteur.emprunts', compact('emprunts'));
    }

    /**
     * Demander un emprunt (lecteur)
     */
    public function demander(Request $request, $livreId)
    {
        $livre = Livre::findOrFail($livreId);

        // Vérifier la disponibilité
        if (!$livre->isDisponible()) {
            return back()->with('error', 'Ce livre n\'est pas disponible pour le moment.');
        }

        // Vérifier que l'utilisateur n'a pas déjà emprunté ce livre et ne l'a pas encore retourné
        $empruntExistant = Emprunt::where('user_id', auth()->id())
            ->where('livre_id', $livreId)
            ->whereIn('statut', ['en_attente', 'en_cours', 'en_retard'])
            ->exists();

        if ($empruntExistant) {
            return back()->with('error', 'Vous avez déjà un emprunt en cours pour ce livre. Vous devez le retourner avant de pouvoir l\'emprunter à nouveau.');
        }

        // Vérifier également si l'utilisateur a des emprunts en retard (optionnel)
        $empruntsEnRetard = Emprunt::where('user_id', auth()->id())
            ->where('statut', 'en_retard')
            ->exists();

        if ($empruntsEnRetard) {
            return back()->with('error', 'Vous avez des emprunts en retard. Veuillez les retourner avant de faire une nouvelle demande.');
        }

        // Créer la demande d'emprunt
        Emprunt::create([
            'user_id' => auth()->id(),
            'livre_id' => $livreId,
            'date_emprunt' => Carbon::now(),
            'date_retour_prevue' => Carbon::now()->addDays(14), // 14 jours d'emprunt
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Votre demande d\'emprunt a été envoyée. Elle sera validée par un bibliothécaire.');
    }

    /**
     * Afficher tous les emprunts (bibliothécaire)
     */
    public function index(Request $request)
    {
        $query = Emprunt::with(['user', 'livre.categorie', 'livre.auteurs']);

        // Recherche par texte
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->whereHas('livre', function($livreQuery) use ($search) {
                    $livreQuery->where('titre', 'LIKE', "%{$search}%")
                              ->orWhere('isbn', 'LIKE', "%{$search}%");
                })->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('nom', 'LIKE', "%{$search}%")
                             ->orWhere('prenom', 'LIKE', "%{$search}%");
                });
            });
        }

        // Filtrer par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrer par utilisateur
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $emprunts = $query->latest()->paginate(15);

        return view('bibliothecaire.emprunts.index', compact('emprunts'));
    }

    /**
     * Afficher les emprunts en attente
     */
    public function enAttente()
    {
        $emprunts = Emprunt::with(['user', 'livre.categorie', 'livre.auteurs'])
            ->enAttente()
            ->latest()
            ->paginate(15);

        return view('bibliothecaire.emprunts.en-attente', compact('emprunts'));
    }

    /**
     * Afficher les emprunts en retard
     */
    public function enRetard()
    {
        $emprunts = Emprunt::with(['user', 'livre.categorie', 'livre.auteurs', 'penalite'])
            ->enRetard()
            ->latest('date_retour_prevue')
            ->paginate(15);

        return view('bibliothecaire.emprunts.en-retard', compact('emprunts'));
    }

    /**
     * Valider un emprunt (bibliothécaire)
     */
    public function valider($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        if ($emprunt->statut !== 'en_attente') {
            return back()->with('error', 'Cet emprunt ne peut pas être validé.');
        }

        // Vérifier la disponibilité du livre
        if (!$emprunt->livre->isDisponible()) {
            return back()->with('error', 'Ce livre n\'est plus disponible.');
        }

        $emprunt->valider();

        return back()->with('success', 'L\'emprunt a été validé avec succès.');
    }

    /**
     * Refuser un emprunt (bibliothécaire)
     */
    public function refuser(Request $request, $id)
    {
        $emprunt = Emprunt::findOrFail($id);

        if ($emprunt->statut !== 'en_attente') {
            return back()->with('error', 'Cet emprunt ne peut pas être refusé.');
        }

        $request->validate([
            'remarques' => 'required|string|max:500',
        ], [
            'remarques.required' => 'Le motif du refus est obligatoire.',
            'remarques.max' => 'Le motif ne peut pas dépasser 500 caractères.',
        ]);

        $emprunt->update([
            'statut' => 'refuse',
            'remarques' => $request->remarques,
        ]);

        return back()->with('success', 'L\'emprunt a été refusé avec motif.');
    }

    /**
     * Valider le retour d'un livre (bibliothécaire)
     */
    public function validerRetour($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        if (!in_array($emprunt->statut, ['en_cours', 'en_retard'])) {
            return back()->with('error', 'Ce livre ne peut pas être retourné.');
        }

        $emprunt->retourner();

        $message = 'Le retour a été validé avec succès.';
        if ($emprunt->penalite) {
            $message .= ' Une pénalité de ' . $emprunt->penalite->montant_formate . ' a été appliquée.';
        }

        return back()->with('success', $message);
    }

    /**
     * Prolonger un emprunt (bibliothécaire)
     */
    public function prolonger($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        if ($emprunt->statut !== 'en_cours') {
            return back()->with('error', 'Cet emprunt ne peut pas être prolongé.');
        }

        // Prolonger de 7 jours
        $emprunt->update([
            'date_retour_prevue' => $emprunt->date_retour_prevue->addDays(7),
            'statut' => 'en_cours', // Remettre en cours si était en retard
        ]);

        return back()->with('success', 'L\'emprunt a été prolongé de 7 jours.');
    }

    /**
     * Afficher le détail d'un emprunt
     */
    public function show($id)
    {
        $emprunt = Emprunt::with(['user', 'livre.categorie', 'livre.auteurs', 'penalite'])
            ->findOrFail($id);

        // Vérifier les permissions
        if (auth()->user()->isLecteur() && $emprunt->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('emprunts.show', compact('emprunt'));
    }

    /**
     * Supprimer un emprunt (admin uniquement)
     */
    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        if (in_array($emprunt->statut, ['en_cours', 'valide'])) {
            return back()->with('error', 'Impossible de supprimer un emprunt en cours.');
        }

        $emprunt->delete();

        return back()->with('success', 'L\'emprunt a été supprimé.');
    }
}
