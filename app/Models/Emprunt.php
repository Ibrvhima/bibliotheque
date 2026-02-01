<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Emprunt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'livre_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effective',
        'statut',
        'remarques',
    ];

    protected $casts = [
        'date_emprunt' => 'date',
        'date_retour_prevue' => 'date',
        'date_retour_effective' => 'date',
    ];

    /**
     * Relation ManyToOne : Un emprunt appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation ManyToOne : Un emprunt appartient à un livre
     */
    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    /**
     * Relation OneToOne : Un emprunt peut avoir une pénalité
     */
    public function penalite()
    {
        return $this->hasOne(Penalite::class);
    }

    /**
     * Vérifier si l'emprunt peut être prolongé
     */
    public function canBeExtended()
    {
        return $this->statut === 'en_cours' && 
               !$this->penalite && 
               $this->date_retour_prevue->diffInDays(now()) <= 7;
    }

    /**
     * Vérifier si l'emprunt est en retard
     */
    public function isEnRetard(): bool
    {
        if ($this->statut === 'retourne') {
            return false;
        }

        return Carbon::now()->isAfter($this->date_retour_prevue);
    }

    /**
     * Calculer le nombre de jours de retard
     */
    public function getJoursRetardAttribute(): int
    {
        if (!$this->isEnRetard()) {
            return 0;
        }

        $dateReference = $this->date_retour_effective ?? Carbon::now();
        return $this->date_retour_prevue->diffInDays($dateReference);
    }

    /**
     * Calculer le montant de la pénalité (500 FCFA par jour)
     */
    public function calculerPenalite(): float
    {
        return $this->jours_retard * 500;
    }

    /**
     * Scope pour les emprunts en retard
     */
    public function scopeEnRetard($query)
    {
        return $query->where('statut', '!=', 'retourne')
                     ->where('date_retour_prevue', '<', Carbon::now());
    }

    /**
     * Scope pour les emprunts en cours
     */
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    /**
     * Scope pour les emprunts en attente de validation
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Valider l'emprunt
     */
    public function valider()
    {
        $this->update([
            'statut' => 'en_cours',
            'date_emprunt' => Carbon::now(),
        ]);

        // Mettre à jour la disponibilité du livre si nécessaire
        $this->livre->update([
            'disponible' => $this->livre->exemplaires_disponibles > 1
        ]);
    }

    /**
     * Retourner le livre
     */
    public function retourner()
    {
        $this->update([
            'statut' => 'retourne',
            'date_retour_effective' => Carbon::now(),
        ]);

        // Remettre le livre comme disponible
        $this->livre->update(['disponible' => true]);

        // Créer une pénalité si retard
        if ($this->jours_retard > 0) {
            Penalite::create([
                'emprunt_id' => $this->id,
                'montant' => $this->calculerPenalite(),
                'jours_retard' => $this->jours_retard,
                'date_penalite' => Carbon::now(),
            ]);
        }
    }

    /**
     * Mettre à jour le statut automatiquement
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($emprunt) {
            if ($emprunt->isEnRetard() && $emprunt->statut !== 'retourne') {
                $emprunt->statut = 'en_retard';
            }
        });
    }
}
