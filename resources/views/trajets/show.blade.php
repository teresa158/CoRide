<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoRide - Détails du trajet #{{ $trajet->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto">
        <!-- Lien Retour -->
        <a href="{{ route('trajets.index') }}" class="inline-flex items-center text-emerald-400 hover:text-emerald-300 mb-6 transition text-sm font-semibold">
            ← Retour à la liste des trajets
        </a>

        <!-- Carte Principale -->
        <div class="bg-gray-800 border border-gray-700/60 rounded-2xl p-8 shadow-xl">
            
            <div class="flex justify-between items-center pb-6 border-b border-gray-700/60 mb-6">
                <div>
                    <span class="text-xs uppercase font-bold text-emerald-400">Trajet #{{ $trajet->id }}</span>
                    <h1 class="text-3xl font-extrabold text-white">
                        {{ $trajet->ville_depart }} <span class="text-emerald-400">➔</span> {{ $trajet->ville_arrivee }}
                    </h1>
                </div>
                <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $trajet->places_disponibles > 0 ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-red-500/20 text-red-300 border border-red-500/30' }}">
                    {{ $trajet->places_disponibles }} place(s) disponible(s)
                </span>
            </div>

            <!-- Infos Trajet & Conducteur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-200 mb-4 flex items-center gap-2">
                        🚗 Détails de l'itinéraire
                    </h3>
                    <div class="space-y-3 bg-gray-900/60 rounded-xl p-5 border border-gray-700/40 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Horaire de départ :</span>
                            <span class="font-bold text-white">{{ $trajet->horaire }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Récurrence :</span>
                            <span class="font-bold text-white">{{ $trajet->jours_recurrence ?: 'Ponctuel' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Places totales :</span>
                            <span class="font-bold text-white">{{ $trajet->places_disponibles }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-200 mb-4 flex items-center gap-2">
                        👤 Conducteur & Entreprise
                    </h3>
                    <div class="space-y-3 bg-gray-900/60 rounded-xl p-5 border border-gray-700/40 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Nom du conducteur :</span>
                            <span class="font-bold text-emerald-400">{{ $trajet->conducteur->name ?? 'Non spécifié' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Email :</span>
                            <span class="font-medium text-gray-300">{{ $trajet->conducteur->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Entreprise :</span>
                            <span class="font-bold text-white">{{ $trajet->conducteur->entreprise->nom ?? 'Non rattaché' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des réservations actuelles -->
            <div class="mt-8 pt-6 border-t border-gray-700/60">
                <h3 class="text-lg font-bold text-gray-200 mb-4">📋 Passagers inscrits ({{ $trajet->reservations->count() }})</h3>
                
                @if($trajet->reservations->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($trajet->reservations as $reservation)
                            <div class="bg-gray-900/40 p-4 rounded-xl border border-gray-700/40 flex justify-between items-center text-sm">
                                <div>
                                    <span class="font-semibold text-white">{{ $reservation->passager->name ?? 'Passager' }}</span>
                                    <span class="text-xs text-gray-400 block">{{ $reservation->passager->email ?? '' }}</span>
                                </div>
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold uppercase tracking-wider bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    {{ $reservation->statut }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm italic">Aucune réservation pour ce trajet actuellement.</p>
                @endif
            </div>

        </div>
    </div>

</body>
</html>
