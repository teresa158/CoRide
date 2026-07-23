<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Affiche l'espace personnel (Dashboard) d'un salarié.
     */
    public function show(User $user = null)
    {
        // Si aucun utilisateur n'est spécifié, utiliser l'utilisateur connecté
        $user = $user ?? auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Chargement optimisé des relations
        $user->load([
            'entreprise',
            'trajets.reservations.passager',
            'reservations.trajet.conducteur'
        ]);

        return view('trajets.dashboard', compact('user'));
    }
}
