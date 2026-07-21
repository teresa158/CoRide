<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    /**
     * Affiche la liste de tous les trajets disponibles.
     */
    public function index()
    {
        // Récupération des trajets avec le conducteur (Eager Loading)
        $trajets = Trajet::with('conducteur')->latest()->get();

        return view('trajets.index', compact('trajets'));
    }
}
