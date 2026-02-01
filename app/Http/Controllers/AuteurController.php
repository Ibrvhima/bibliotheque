<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use Illuminate\Http\Request;

class AuteurController extends Controller
{
    /**
     * Afficher la liste des auteurs
     */
    public function index(Request $request)
    {
        $query = Auteur::withCount('livres');

        // Recherche par nom ou prénom
        if ($search = $request->get('search')) {
            $query->where('nom', 'LIKE', "%{$search}%")
                  ->orWhere('prenom', 'LIKE', "%{$search}%")
                  ->orWhere('biographie', 'LIKE', "%{$search}%");
        }

        $auteurs = $query->latest()->paginate(15);

        return view('bibliothecaire.auteurs.index', compact('auteurs'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('bibliothecaire.auteurs.create');
    }

    /**
     * Enregistrer un nouvel auteur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'biographie' => 'nullable|string',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
        ]);

        Auteur::create($validated);

        return redirect()->route('bibliothecaire.auteurs.index')
            ->with('success', 'L\'auteur a été ajouté avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $auteur = Auteur::findOrFail($id);

        return view('bibliothecaire.auteurs.edit', compact('auteur'));
    }

    /**
     * Mettre à jour un auteur
     */
    public function update(Request $request, $id)
    {
        $auteur = Auteur::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'biographie' => 'nullable|string',
        ]);

        $auteur->update($validated);

        return redirect()->route('bibliothecaire.auteurs.index')
            ->with('success', 'L\'auteur a été mis à jour avec succès.');
    }

    /**
     * Supprimer un auteur (seulement si aucun livre associé)
     */
    public function destroy($id)
    {
        $auteur = Auteur::findOrFail($id);

        if ($auteur->livres()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cet auteur car il a des livres associés.');
        }

        $auteur->delete();

        return redirect()->route('bibliothecaire.auteurs.index')
            ->with('success', 'L\'auteur a été supprimé avec succès.');
    }
}
