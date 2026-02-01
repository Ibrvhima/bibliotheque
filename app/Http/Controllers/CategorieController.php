<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index(Request $request)
    {
        $query = Categorie::withCount('livres');

        // Recherche par libelle
        if ($search = $request->get('search')) {
            $query->where('libelle', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        $categories = $query->latest()->paginate(15);

        return view('bibliothecaire.categories.index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('bibliothecaire.categories.create');
    }

    /**
     * Enregistrer une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:categories,libelle',
            'description' => 'nullable|string',
        ], [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.unique' => 'Cette catégorie existe déjà.',
        ]);

        Categorie::create($validated);

        return redirect()->route('bibliothecaire.categories.index')
            ->with('success', 'La catégorie a été ajoutée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);

        return view('bibliothecaire.categories.edit', compact('categorie'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:categories,libelle,' . $id,
            'description' => 'nullable|string',
        ]);

        $categorie->update($validated);

        return redirect()->route('bibliothecaire.categories.index')
            ->with('success', 'La catégorie a été mise à jour avec succès.');
    }

    /**
     * Supprimer une catégorie (seulement si aucun livre associé)
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        if ($categorie->livres()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des livres.');
        }

        $categorie->delete();

        return redirect()->route('bibliothecaire.categories.index')
            ->with('success', 'La catégorie a été supprimée avec succès.');
    }
}
