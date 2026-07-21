<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    /**
     * Affiche la liste des trajets avec possibilité de filtrage.
     */
    public function index(Request $request)
    {
        $query = Trajet::with('conducteur');

        $query->when($request->filled('ville_depart'), function ($q) use ($request) {
            return $q->where('ville_depart', 'like', '%' . $request->ville_depart . '%');
        });

        $query->when($request->filled('ville_arrivee'), function ($q) use ($request) {
            return $q->where('ville_arrivee', 'like', '%' . $request->ville_arrivee . '%');
        });

        $trajets = $query->latest()->get();

        return view('trajets.index', compact('trajets'));
    }

    /**
     * Affiche les détails d'un trajet spécifique.
     */
    public function show(Trajet $trajet)
    {
        // Chargement des relations du conducteur et des réservations existantes
        $trajet->load(['conducteur.entreprise', 'reservations.passager']);

        return view('trajets.show', compact('trajet'));
    }
}
