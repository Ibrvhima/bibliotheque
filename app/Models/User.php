<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'password',
        'role',
        'actif',
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'actif' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Relation OneToMany : Un utilisateur peut avoir plusieurs emprunts
     */
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

    /**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Radmin';
    }

    /**
     * Vérifier si l'utilisateur est bibliothécaire
     */
    public function isBibliothecaire(): bool
    {
        return $this->role === 'Rbibliothecaire';
    }

    /**
     * Vérifier si l'utilisateur est lecteur
     */
    public function isLecteur(): bool
    {
        return $this->role === 'Rlecteur';
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    /**
     * Obtenir l'affichage du rôle en français
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'Radmin' => 'Administrateur',
            'Rbibliothecaire' => 'Bibliothécaire',
            'Rlecteur' => 'Lecteur',
            default => 'Inconnu'
        };
    }

    /**
     * Obtenir les initiales de l'utilisateur
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->prenom, 0, 1) . substr($this->nom, 0, 1));
    }

    /**
     * Emprunts en cours
     */
    public function empruntsEnCours()
    {
        return $this->emprunts()->where('statut', 'en_cours');
    }

    /**
     * Emprunts en retard
     */
    public function empruntsEnRetard()
    {
        return $this->emprunts()->where('statut', 'en_retard');
    }

    /**
     * Vérifier si l'utilisateur a des pénalités impayées
     */
    public function hasPenalitesImpayees(): bool
    {
        return $this->emprunts()
            ->whereHas('penalite', function($query) {
                $query->where('payee', false);
            })
            ->exists();
    }
}
