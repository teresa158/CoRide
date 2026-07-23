<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoRide - Espace Salarié : {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-8">

    <div class="max-w-6xl mx-auto">
        <!-- Header / Navigation -->
        <div class="flex justify-between items-center mb-8 border-b border-gray-800 pb-4">
            <div>
                <a href="{{ route('trajets.index') }}" class="text-emerald-400 hover:underline text-sm font-semibold">← Liste des trajets</a>
                <h1 class="text-3xl font-extrabold text-white mt-1">💼 Espace Salarié</h1>
            </div>
            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs px-3 py-1.5 rounded-full font-semibold">
                {{ $user->entreprise->nom ?? 'Hors entreprise' }}
            </span>
        </div>

        <!-- Profil info -->
        <div class="bg-gray-800 border border-gray-700/60 rounded-2xl p-6 mb-8 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-emerald-400 text-sm font-medium">{{ $user->email }}</p>
            </div>
            <div class="text-sm text-gray-400 space-y-1">
                <div>🏢 <span class="font-semibold text-gray-200">Entreprise :</span> {{ $user->entreprise->nom ?? 'Indépendant' }}</div>
                <div>📍 <span class="font-semibold text-gray-200">Résidence :</span> {{ $user->ville_residence ?? 'Non spécifiée' }}</div>
                <div>🎭 <span class="font-semibold text-gray-200">Rôle favori :</span> {{ ucfirst($user->role) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 1. Trajets Proposés (Conducteur) -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    🚗 Mes trajets proposés (Conducteur)
                </h3>

                @forelse($user->trajets as $trajet)
                    <div class="bg-gray-800 border border-gray-700/40 rounded-xl p-5 shadow">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs font-semibold text-emerald-400 uppercase">Trajet #{{ $trajet->id }}</span>
                            <span class="text-xs text-gray-400 font-medium">🕒 {{ $trajet->horaire }}</span>
                        </div>
                        <h4 class="text-base font-bold text-white mb-4">
                            {{ $trajet->ville_depart }} ➔ {{ $trajet->ville_arrivee }}
                        </h4>

                        <!-- Demandes reçues pour ce trajet -->
                        <div class="border-t border-gray-700/60 pt-3">
                            <h5 class="text-xs font-bold uppercase text-gray-400 mb-2">Demandes de passagers ({{ $trajet->reservations->count() }})</h5>
                            @forelse($trajet->reservations as $reservation)
                                <div class="bg-gray-900/40 p-3 rounded-lg border border-gray-700/30 flex justify-between items-center text-xs mb-2">
                                    <div>
                                        <p class="font-semibold text-white">{{ $reservation->passager->name }}</p>
                                        <p class="text-gray-400">{{ $reservation->passager->entreprise->nom ?? '' }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded font-bold uppercase {{ $reservation->statut === 'confirmee' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-blue-500/20 text-blue-300' }}">
                                        {{ $reservation->statut }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 italic">Aucune demande reçue.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">Vous n'avez proposé aucun trajet pour le moment.</p>
                @endforelse
            </div>

            <!-- 2. Mes Réservations (Passager) -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    📅 Mes réservations (Passager)
                </h3>

                @forelse($user->reservations as $reservation)
                    @php
                        $detailsIA = json_decode($reservation->resultat_ia, true);
                    @endphp
                    <div class="bg-gray-800 border border-gray-700/40 rounded-xl p-5 shadow">
                        <div class="flex justify-between items-center mb-3">
                            <span class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $reservation->statut === 'confirmee' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-blue-500/20 text-blue-300' }}">
                                {{ $reservation->statut }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">🕒 {{ $reservation->trajet->horaire }}</span>
                        </div>
                        <h4 class="text-base font-bold text-white mb-2">
                            {{ $reservation->trajet->ville_depart }} ➔ {{ $reservation->trajet->ville_arrivee }}
                        </h4>
                        <p class="text-xs text-gray-400 mb-3">Conducteur : <span class="text-gray-200 font-semibold">{{ $reservation->trajet->conducteur->name }}</span></p>

                        <!-- Analyse Compatibilité IA -->
                        @if($detailsIA)
                            <div class="bg-gray-900/60 p-3 rounded-lg border border-emerald-500/10 text-xs">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-emerald-400 font-semibold">🤖 Score de compatibilité IA :</span>
                                    <span class="font-bold text-emerald-300 bg-emerald-500/10 px-1.5 py-0.5 rounded">{{ $detailsIA['score'] ?? 80 }}%</span>
                                </div>
                                <p class="text-gray-400 italic">"{{ $detailsIA['justification'] ?? '' }}"</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">Vous n'avez fait aucune demande de réservation pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>
