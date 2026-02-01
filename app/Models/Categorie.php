<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
    ];

    /**
     * Relation OneToMany : Une catégorie peut avoir plusieurs livres
     */
    public function livres()
    {
        return $this->hasMany(Livre::class);
    }

    /**
     * Obtenir le nombre de livres dans la catégorie
     */
    public function getNombreLivresAttribute(): int
    {
        return $this->livres()->count();
    }

    /**
     * Obtenir le nombre de livres disponibles
     */
    public function getNombreLivresDisponiblesAttribute(): int
    {
        return $this->livres()->disponible()->count();
    }
}
