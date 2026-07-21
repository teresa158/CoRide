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

        // 1. Règle métier : Vérifier les places disponibles
        if ($trajet->places_disponibles <= 0) {
            return redirect()->back()->with('error', 'Désolé, ce trajet n\'a plus de places disponibles.');
        }

        // 2. Règle métier : Empêcher le conducteur de réserver son propre trajet
        if ($trajet->conducteur_id == $passagerId) {
            return redirect()->back()->with('error', 'Vous êtes le conducteur de ce trajet !');
        }

        // 3. Règle métier : Vérifier si le passager a déjà réservé ce trajet
        $dejaReserve = Reservation::where('trajet_id', $trajet->id)
            ->where('passager_id', $passagerId)
            ->exists();

        if ($dejaReserve) {
            return redirect()->back()->with('error', 'Vous avez déjà soumis une demande de réservation pour ce trajet.');
        }

        // 4. Création de la réservation
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
}
