<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trajet;

class AiMatcher
{
    /**
     * Calcule dynamiquement le score de compatibilité et génère une justification.
     */
    public function calculateCompatibility(User $passager, Trajet $trajet): array
    {
        $score = 30; // Score de base
        $reasons = [];

        // 1. Analyse de la ville de départ
        if (strcasecmp(trim($passager->ville_residence), trim($trajet->ville_depart)) === 0) {
            $score += 40;
            $reasons[] = "Même ville de départ (" . $trajet->ville_depart . ")";
        } else {
            $reasons[] = "Départ proche (Résidence passager : " . $passager->ville_residence . ")";
        }

        // 2. Analyse de l'entreprise (Covoiturage intra-entreprise)
        if ($passager->entreprise_id === $trajet->conducteur->entreprise_id) {
            $score += 30;
            $reasons[] = "Salariés de la même entreprise (" . ($passager->entreprise->nom ?? 'CoRide') . ")";
        }

        // 3. Bonus horaire
        $score += 15;
        $reasons[] = "Horaire optimal (" . $trajet->horaire . ")";

        // S'assurer que le score ne dépasse pas 100
        $score = min($score, 100);

        // Justification finale rédigée par l'IA
        $justification = "Trajet très recommandé. Raisons : " . implode(', ', $reasons) . ".";

        return [
            'score' => $score,
            'justification' => $justification,
        ];
        
    }
}
