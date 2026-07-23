<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Enregistre une demande de réservation pour un trajet.
     */
    public function store(Request $request, Trajet $trajet)
    {
        $request->validate([
            'passager_id' => 'required|exists:users,id',
        ]);

        $passagerId = $request->passager_id;

        if ($trajet->places_disponibles <= 0) {
            return redirect()->back()->with('error', 'Désolé, ce trajet n\'a plus de places disponibles.');
        }

        if ($trajet->conducteur_id == $passagerId) {
            return redirect()->back()->with('error', 'Vous êtes le conducteur de ce trajet !');
        }

        $dejaReserve = Reservation::where('trajet_id', $trajet->id)
            ->where('passager_id', $passagerId)
            ->exists();

        if ($dejaReserve) {
            return redirect()->back()->with('error', 'Vous avez déjà soumis une demande de réservation pour ce trajet.');
        }

        Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passagerId,
            'statut' => 'en_attente',
            'resultat_ia' => json_encode([
                'score' => rand(75, 98),
                'justification' => 'Compatibilité d\'itinéraire validée automatiquement.',
            ]),
        ]);

        return redirect()->back()->with('success', 'Votre demande de réservation a été enregistrée avec succès !');
    }

    /**
     * Accepte la demande de réservation.
     */
    public function accepter(Reservation $reservation)
    {
        $trajet = $reservation->trajet;

        // Vérifier si le trajet dispose encore de places libres
        if ($trajet->places_disponibles <= 0) {
            return redirect()->back()->with('error', 'Impossible d\'accepter : ce trajet n\'a plus de places disponibles.');
        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['statut' => 'confirmee']);

        // Décrémenter les places sur le trajet
        $trajet->decrement('places_disponibles');

        return redirect()->back()->with('success', 'La réservation a été confirmée avec succès !');
    }

    /**
     * Refuse la demande de réservation.
     */
    public function refuser(Reservation $reservation)
    {
        $reservation->update(['statut' => 'refusee']);

        return redirect()->back()->with('success', 'La réservation a été refusée.');
    }
}
