<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Étudiants - Noms guinéens respectés
        $etudiants = [
            ['login' => 'ETU202401', 'nom' => 'Touré', 'prenom' => 'Mamadou', 'email' => 'm.toure@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202402', 'nom' => 'Diallo', 'prenom' => 'Aminata', 'email' => 'a.diallo@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202403', 'nom' => 'Sylla', 'prenom' => 'Ibrahim', 'email' => 'i.sylla@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202404', 'nom' => 'Camara', 'prenom' => 'Fatoumata', 'email' => 'f.camara@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202405', 'nom' => 'Bah', 'prenom' => 'Oumar', 'email' => 'o.bah@etudiant.bibliotheque.gn'],
        ];

        foreach ($etudiants as $etudiant) {
            $password = strtolower($etudiant['login']) . '@2024';
            User::create([
                'login' => $etudiant['login'],
                'password' => Hash::make($password),
                'nom' => $etudiant['nom'],
                'prenom' => $etudiant['prenom'],
                'email' => $etudiant['email'],
                'role' => 'Rlecteur',
                'actif' => true,
            ]);
        }

        // Enseignants et chercheurs - Noms guinéens respectés
        $enseignants = [
            ['login' => 'ENS001', 'nom' => 'Nabé', 'prenom' => 'Mamadou', 'email' => 'm.nabe@enseignant.bibliotheque.gn'],
            ['login' => 'ENS002', 'nom' => 'Kouyaté', 'prenom' => 'Sékou', 'email' => 's.kouyate@enseignant.bibliotheque.gn'],
            ['login' => 'ENS003', 'nom' => 'Bancé', 'prenom' => 'Mamadou', 'email' => 'm.bance@enseignant.bibliotheque.gn'],
        ];

        foreach ($enseignants as $enseignant) {
            $password = strtolower($enseignant['login']) . '@2024';
            User::create([
                'login' => $enseignant['login'],
                'password' => Hash::make($password),
                'nom' => $enseignant['nom'],
                'prenom' => $enseignant['prenom'],
                'email' => $enseignant['email'],
                'role' => 'Rlecteur',
                'actif' => true,
            ]);
        }

        $this->command->info('Comptes lecteurs créés avec succès!');
        $this->command->info('Étudiants: ETU202401 à ETU202405 (mot de passe: login@2024 en minuscules)');
        $this->command->info('Enseignants: ENS001 à ENS003 (mot de passe: login@2024 en minuscules)');
    }
}
