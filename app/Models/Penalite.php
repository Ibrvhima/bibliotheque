<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
    use HasFactory;

    protected $fillable = [
        'emprunt_id',
        'montant',
        'payee',
        'jours_retard',
        'date_penalite',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'payee' => 'boolean',
        'date_penalite' => 'date',
    ];

    /**
     * Relation ManyToOne : Une pénalité appartient à un emprunt
     */
    public function emprunt()
    {
        return $this->belongsTo(Emprunt::class);
    }

    /**
     * Marquer la pénalité comme payée
     */
    public function marquerPayee()
    {
        $this->update(['payee' => true]);
    }

    /**
     * Scope pour les pénalités impayées
     */
    public function scopeImpayees($query)
    {
        return $query->where('payee', false);
    }

    /**
     * Obtenir le montant formaté
     */
    public function getMontantFormateAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }
}
