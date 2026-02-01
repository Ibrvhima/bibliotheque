<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'isbn',
        'resume',
        'prix',
        'disponible',
        'categorie_id',
        'image',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'prix' => 'decimal:2',
    ];

    /**
     * Relation ManyToOne : Un livre appartient à une catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Relation ManyToMany : Un livre peut avoir plusieurs auteurs
     */
    public function auteurs()
    {
        return $this->belongsToMany(Auteur::class, 'livre_auteur');
    }

    /**
     * Relation OneToMany : Un livre peut avoir plusieurs emprunts
     */
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

    /**
     * Vérifier si le livre est disponible pour l'emprunt
     */
    public function isDisponible()
    {
        return $this->disponible;
    }
    public function getExemplairesDisponiblesAttribute(): int
    {
        $empruntsEnCours = $this->emprunts()
            ->whereIn('statut', ['en_cours', 'valide'])
            ->count();
        
        return max(0, $this->nombre_exemplaires - $empruntsEnCours);
    }

    /**
     * Scope pour les livres disponibles
     */
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true)
                     ->where('nombre_exemplaires', '>', 0);
    }

    /**
     * Scope pour rechercher des livres
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('isbn', 'like', "%{$search}%")
              ->orWhereHas('auteurs', function($query) use ($search) {
                  $query->where('nom', 'like', "%{$search}%");
              });
        });
    }

    /**
     * Obtenir les noms des auteurs
     */
    public function getAuteursNamesAttribute(): string
    {
        return $this->auteurs->pluck('nom')->implode(', ');
    }
}
