<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'livre_id',
        'user_id',
        'note',
        'commentaire',
        'approuve',
    ];

    protected $casts = [
        'note' => 'integer',
        'approuve' => 'boolean',
    ];

    // Relations
    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeApprouves($query)
    {
        return $query->where('approuve', true);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('approuve', false);
    }

    // Accessors
    public function getNoteEtoilesAttribute()
    {
        return str_repeat('⭐', $this->note) . str_repeat('☆', 5 - $this->note);
    }

    public function getNotePourcentageAttribute()
    {
        return ($this->note / 5) * 100;
    }

    // Méthodes statiques
    public static function getMoyenneNotes($livreId)
    {
        return self::where('livre_id', $livreId)
            ->approuves()
            ->avg('note');
    }

    public static function getTotalAvis($livreId)
    {
        return self::where('livre_id', $livreId)
            ->approuves()
            ->count();
    }

    public static function getRepartitionNotes($livreId)
    {
        $repartition = [];
        for ($i = 1; $i <= 5; $i++) {
            $repartition[$i] = self::where('livre_id', $livreId)
                ->approuves()
                ->where('note', $i)
                ->count();
        }
        return $repartition;
    }
}
