<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        $entreprises = [
            ['nom' => 'MobiliTech', 'secteur_activite' => 'Mobilité Durable', 'adresse' => 'Rabat Agdal'],
            ['nom' => 'NextBuild', 'secteur_activite' => 'BTP & Ingénierie', 'adresse' => 'Casablanca Nearshore'],
            ['nom' => 'Atlas Digital', 'secteur_activite' => 'Technologies & SI', 'adresse' => 'Rabat Technopolis'],
            ['nom' => 'GreenLogix', 'secteur_activite' => 'Logistique Durable', 'adresse' => 'Mohammedia Port'],
            ['nom' => 'Kandia Solutions', 'secteur_activite' => 'Conseil & RSE', 'adresse' => 'Casablanca Finance City'],
        ];

        foreach ($entreprises as $entreprise) {
            Entreprise::firstOrCreate(
                ['nom' => $entreprise['nom']],
                $entreprise
            );
        }

        $this->command->info('✅ 5 Entreprises créées avec succès !');
    }
}
