<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trajet_id',
        'passager_id',
        'statut',
        'resultat_ia',
    ];

    /**
     * La réservation concerne un trajet précis.
     */
    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class, 'trajet_id');
    }

    /**
     * La réservation a été faite par un passager (User).
     */
    public function passager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'passager_id');
    }
}
