<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    use HasFactory;

    protected $table = 'auteurs';

    protected $fillable = [
        'nom',
        'prenom',
        'biographie',
    ];

    /**
     * Relation ManyToMany : Un auteur peut avoir plusieurs livres
     */
    public function livres()
    {
        return $this->belongsToMany(Livre::class, 'livre_auteur');
    }

    /**
     * Obtenir le nom complet de l'auteur
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    /**
     * Obtenir le nombre de livres de l'auteur
     */
    public function getNombreLivresAttribute(): int
    {
        return $this->livres()->count();
    }
}
