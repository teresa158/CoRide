@php
    $allUsers = \App\Models\User::orderBy('name')->get();
    $allEntreprises = \App\Models\Entreprise::orderBy('nom')->get();
@endphp

<nav class="bg-gray-800 border-b border-gray-700/80 px-6 py-4 mb-8 shadow-lg">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        
        <!-- Logo et Liens principaux -->
        <div class="flex items-center gap-6">
            <a href="{{ route('trajets.index') }}" class="flex items-center gap-2">
                <span class="text-2xl">🚗</span>
                <span class="text-xl font-extrabold text-emerald-400 tracking-wider">CoRide</span>
            </a>
            <div class="flex gap-4 text-sm font-semibold">
                <a href="{{ route('trajets.index') }}" class="text-gray-300 hover:text-white transition">Liste des Trajets</a>
                <a href="{{ route('trajets.create') }}" class="text-emerald-400 hover:text-emerald-300 transition">+ Proposer un trajet</a>
            </div>
        </div>

        <!-- Sélecteurs de Test (Simulateurs) -->
        <div class="flex flex-wrap items-center gap-3">
            
            <!-- Sélecteur Entreprises -->
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 font-medium uppercase">🏢 Entreprise :</span>
                <select onchange="window.location.href='/entreprises/' + this.value" class="bg-gray-900 border border-gray-700 text-xs text-white rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-emerald-500">
                    <option value="">-- Choisir --</option>
                    @foreach($allEntreprises as $ent)
                        <option value="{{ $ent->id }}" {{ isset($entreprise) && $entreprise->id == $ent->id ? 'selected' : '' }}>
                            {{ $ent->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Simulateur Utilisateur Connecté -->
            <div class="flex items-center gap-2">
                <span class="text-xs text-emerald-400 font-medium uppercase">👤 Simuler Salarié :</span>
                <select onchange="window.location.href='/dashboard/' + this.value" class="bg-gray-900 border border-emerald-500/30 text-xs text-white rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-emerald-500">
                    <option value="">-- Choisir --</option>
                    @foreach($allUsers as $u)
                        <option value="{{ $u->id }}" {{ isset($user) && $user->id == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</nav>
