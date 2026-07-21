<?php

namespace Database\Seeders;

use App\Models\Trajet;
use App\Models\User;
use Illuminate\Database\Seeder;

class TrajetSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('seeders/data/trajets.csv');

        if (!file_exists($filePath)) {
            $this->command->error("Fichier CSV introuvable : {$filePath}");
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file); // en-tête : id,conducteurid,villedepart,villearrivee,horaire,placesdisponibles,jours_recurrence

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            $conducteurId = (int) trim($data['conducteurid']);

            // Vérifier que le conducteur existe
            if (!User::find($conducteurId)) {
                continue;
            }

            Trajet::firstOrCreate(
                [
                    'id' => (int) trim($data['id']),
                ],
                [
                    'conducteur_id' => $conducteurId,
                    'ville_depart' => trim($data['villedepart']),
                    'ville_arrivee' => trim($data['villearrivee']),
                    'horaire' => trim($data['horaire']),
                    'places_disponibles' => (int) trim($data['placesdisponibles']),
                    'jours_recurrence' => trim($data['jours_recurrence']),
                ]
            );
        }

        fclose($file);
        $this->command->info('✅ 25 Trajets importés depuis le CSV !');
    }
}
