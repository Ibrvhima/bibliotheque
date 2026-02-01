<?php

namespace App\Http\Controllers;

use App\Models\Penalite;
use Illuminate\Http\Request;

class PenaliteController extends Controller
{
    /**
     * Afficher toutes les pénalités (Admin)
     */
    public function index(Request $request)
    {
        $query = Penalite::with(['emprunt.user', 'emprunt.livre']);

        // Filtre par statut de paiement
        if ($request->filled('payee')) {
            $query->where('payee', $request->payee === '1');
        }

        $penalites = $query->latest()->paginate(15);

        // Calcul des totaux
        $total_penalites = Penalite::sum('montant');
        $total_impayees = Penalite::where('payee', false)->sum('montant');
        $total_payees = Penalite::where('payee', true)->sum('montant');

        return view('admin.penalites.index', compact('penalites', 'total_penalites', 'total_impayees', 'total_payees'));
    }

    /**
     * Marquer une pénalité comme payée
     */
    public function marquerPayee($id)
    {
        $penalite = Penalite::findOrFail($id);

        if ($penalite->payee) {
            return back()->with('error', 'Cette pénalité est déjà payée.');
        }

        $penalite->marquerPayee();

        return back()->with('success', 'La pénalité a été marquée comme payée.');
    }
}
