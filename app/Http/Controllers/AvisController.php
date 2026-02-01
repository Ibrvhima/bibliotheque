<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Livre;
use App\Models\Emprunt;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function index()
    {
        $avis = Avis::with(['user', 'livre'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('avis.index', compact('avis'));
    }

    public function create($livreId)
    {
        $livre = Livre::findOrFail($livreId);
        
        // Vérifier si l'utilisateur a déjà emprunté ce livre
        $aEmprunte = Emprunt::where('user_id', auth()->id())
            ->where('livre_id', $livreId)
            ->where('statut', 'retourne')
            ->exists();

        // Vérifier si l'utilisateur a déjà donné un avis
        $aDejaAvis = Avis::where('user_id', auth()->id())
            ->where('livre_id', $livreId)
            ->exists();

        if (!$aEmprunte) {
            return back()->with('error', 'Vous devez avoir emprunté et retourné ce livre pour donner un avis.');
        }

        if ($aDejaAvis) {
            return back()->with('error', 'Vous avez déjà donné un avis pour ce livre.');
        }

        return view('avis.create', compact('livre'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'livre_id' => 'required|exists:livres,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Vérifier si l'utilisateur a déjà emprunté ce livre
        $aEmprunte = Emprunt::where('user_id', auth()->id())
            ->where('livre_id', $request->livre_id)
            ->where('statut', 'retourne')
            ->exists();

        if (!$aEmprunte) {
            return back()->with('error', 'Vous devez avoir emprunté et retourné ce livre pour donner un avis.');
        }

        // Vérifier si l'utilisateur a déjà donné un avis
        $aDejaAvis = Avis::where('user_id', auth()->id())
            ->where('livre_id', $request->livre_id)
            ->exists();

        if ($aDejaAvis) {
            return back()->with('error', 'Vous avez déjà donné un avis pour ce livre.');
        }

        Avis::create([
            'livre_id' => $request->livre_id,
            'user_id' => auth()->id(),
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'approuve' => false, // Les avis doivent être approuvés par un admin
        ]);

        return redirect()->route('livres.show', $request->livre_id)
            ->with('success', 'Votre avis a été soumis et sera visible après validation.');
    }

    public function show(Avis $avi)
    {
        return view('avis.show', compact('avi'));
    }

    public function edit(Avis $avi)
    {
        // Seul l'auteur de l'avis peut le modifier
        if ($avi->user_id !== auth()->id()) {
            abort(403);
        }

        return view('avis.edit', compact('avi'));
    }

    public function update(Request $request, Avis $avi)
    {
        // Seul l'auteur de l'avis peut le modifier
        if ($avi->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $avi->update([
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'approuve' => false, // Remettre en attente après modification
        ]);

        return redirect()->route('livres.show', $avi->livre_id)
            ->with('success', 'Votre avis a été modifié et sera de nouveau validé.');
    }

    public function destroy(Avis $avi)
    {
        // Seul l'auteur de l'avis ou un admin peut le supprimer
        if ($avi->user_id !== auth()->id() && auth()->user()->role !== 'Radmin') {
            abort(403);
        }

        $livreId = $avi->livre_id;
        $avi->delete();

        return redirect()->route('livres.show', $livreId)
            ->with('success', 'L\'avis a été supprimé.');
    }

    // Méthodes pour les administrateurs
    public function approuver(Avis $avi)
    {
        if (auth()->user()->role !== 'Radmin') {
            abort(403);
        }

        $avi->update(['approuve' => true]);

        return back()->with('success', 'L\'avis a été approuvé.');
    }

    public function rejeter(Avis $avi)
    {
        if (auth()->user()->role !== 'Radmin') {
            abort(403);
        }

        $avi->delete();

        return back()->with('success', 'L\'avis a été rejeté.');
    }

    public function moderation()
    {
        if (auth()->user()->role !== 'Radmin') {
            abort(403);
        }

        $avisEnAttente = Avis::with(['user', 'livre'])
            ->enAttente()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('avis.moderation', compact('avisEnAttente'));
    }
}
