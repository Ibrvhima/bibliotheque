<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    /**
     * Afficher le catalogue (public/lecteur)
     */
    public function catalogue(Request $request)
    {
        $query = Livre::with(['categorie', 'auteurs']);

        // Recherche
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        // Filtre par auteur
        if ($request->filled('auteur')) {
            $query->whereHas('auteurs', function($q) use ($request) {
                $q->where('auteurs.id', $request->auteur);
            });
        }

        // Filtre disponibilité
        if ($request->filled('disponible') && $request->disponible == '1') {
            $query->disponible();
        }

        $livres = $query->paginate(12);
        $categories = Categorie::all();
        $auteurs = Auteur::all();

        return view('lecteur.catalogue', compact('livres', 'categories', 'auteurs'));
    }

    /**
     * Afficher le détail d'un livre
     */
    public function show($id)
    {
        $livre = Livre::with(['categorie', 'auteurs', 'emprunts'])->findOrFail($id);
        
        // Récupérer les avis approuvés avec pagination
        $avis = \App\Models\Avis::with('user')
            ->where('livre_id', $id)
            ->approuves()
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        // Calculer les statistiques
        $moyenneNotes = \App\Models\Avis::getMoyenneNotes($id);
        $totalAvis = \App\Models\Avis::getTotalAvis($id);
        $repartitionNotes = \App\Models\Avis::getRepartitionNotes($id);
        
        return view('lecteur.livre-detail', compact('livre', 'avis', 'moyenneNotes', 'totalAvis', 'repartitionNotes'));
    }

    /**
     * Afficher la liste des livres (bibliothécaire)
     */
    public function index(Request $request)
    {
        $query = Livre::with(['categorie', 'auteurs']);

        // Recherche par texte
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                  ->orWhere('isbn', 'LIKE', "%{$search}%")
                  ->orWhereHas('auteurs', function($authorQuery) use ($search) {
                      $authorQuery->where('nom', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filtre par catégorie
        if ($categorie = $request->get('categorie')) {
            $query->where('categorie_id', $categorie);
        }

        // Filtre par disponibilité
        if ($disponibilite = $request->get('disponibilite') !== null) {
            $query->where('disponible', $request->get('disponibilite'));
        }

        $livres = $query->latest()->paginate(15);

        return view('bibliothecaire.livres.index', compact('livres'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = Categorie::orderBy('libelle')->get();
        $auteurs = Auteur::orderBy('nom')->orderBy('prenom')->get();

        return view('bibliothecaire.livres.create', compact('categories', 'auteurs'));
    }

    /**
     * Enregistrer un nouveau livre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:livres,isbn|max:20',
            'resume' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'auteurs' => 'required|array|min:1',
            'auteurs.*' => 'exists:auteurs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disponible' => 'boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'auteurs.required' => 'Au moins un auteur est obligatoire.',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('livres', 'public');
        }

        // Gérer le champ disponible
        $validated['disponible'] = $request->has('disponible');

        $livre = Livre::create($validated);

        // Attacher les auteurs
        $livre->auteurs()->attach($request->auteurs);

        return redirect()->route('bibliothecaire.livres.index')
            ->with('success', 'Le livre a été ajouté avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $livre = Livre::with('auteurs')->findOrFail($id);
        $categories = Categorie::orderBy('libelle')->get();
        $auteurs = Auteur::orderBy('nom')->orderBy('prenom')->get();

        return view('bibliothecaire.livres.edit', compact('livre', 'categories', 'auteurs'));
    }

    /**
     * Mettre à jour un livre
     */
    public function update(Request $request, $id)
    {
        $livre = Livre::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:livres,isbn,' . $id,
            'resume' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'auteurs' => 'required|array|min:1',
            'auteurs.*' => 'exists:auteurs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disponible' => 'boolean',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($livre->image) {
                Storage::disk('public')->delete($livre->image);
            }
            $validated['image'] = $request->file('image')->store('livres', 'public');
        }

        // Gérer le champ disponible
        $validated['disponible'] = $request->has('disponible');

        $livre->update($validated);

        // Mettre à jour les auteurs
        $livre->auteurs()->sync($request->auteurs);

        return redirect()->route('bibliothecaire.livres.index')
            ->with('success', 'Le livre a été mis à jour avec succès.');
    }

    /**
     * Marquer un livre comme indisponible
     */
    public function toggleDisponibilite($id)
    {
        $livre = Livre::findOrFail($id);
        $livre->update(['disponible' => !$livre->disponible]);

        $status = $livre->disponible ? 'disponible' : 'indisponible';
        
        return back()->with('success', "Le livre est maintenant {$status}.");
    }

    /**
     * Supprimer un livre (admin uniquement)
     */
    public function destroy($id)
    {
        $livre = Livre::findOrFail($id);

        // Vérifier s'il y a des emprunts en cours
        if ($livre->emprunts()->whereIn('statut', ['en_cours', 'valide'])->exists()) {
            return back()->with('error', 'Impossible de supprimer ce livre car il a des emprunts en cours.');
        }

        // Supprimer l'image
        if ($livre->image) {
            Storage::disk('public')->delete($livre->image);
        }

        $livre->delete();

        return redirect()->route('admin.livres.index')
            ->with('success', 'Le livre a été supprimé avec succès.');
    }
}
