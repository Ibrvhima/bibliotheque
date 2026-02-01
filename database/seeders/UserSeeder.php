<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrateur - Nom guinéen prestigieux
        User::create([
            'login' => 'ADMIN001',
            'password' => Hash::make('ADMIN001@2024'),
            'nom' => 'Touré',
            'prenom' => 'Sékou',
            'email' => 'admin@bibliotheque.gn',
            'role' => 'Radmin',
            'actif' => true,
        ]);

        // Bibliothécaires - Noms guinéens variés
        User::create([
            'login' => 'BIB001',
            'password' => Hash::make('BIB001@2024'),
            'nom' => 'Diallo',
            'prenom' => 'Aminata',
            'email' => 'a.diallo@bibliotheque.gn',
            'role' => 'Rbibliothecaire',
            'actif' => true,
        ]);

        User::create([
            'login' => 'BIB002',
            'password' => Hash::make('Biblio@2024'),
            'nom' => 'Bah',
            'prenom' => 'Mamadou',
            'email' => 'm.bah@bibliotheque.gn',
            'role' => 'Rbibliothecaire',
            'actif' => true,
        ]);

        User::create([
            'login' => 'BIB003',
            'password' => Hash::make('Biblio@2024'),
            'nom' => 'Sow',
            'prenom' => 'Fatoumata',
            'email' => 'f.sow@bibliotheque.gn',
            'role' => 'Rbibliothecaire',
            'actif' => true,
        ]);

        // Étudiants - Noms guinéens authentiques
        $etudiants = [
            ['login' => 'ETU202401', 'nom' => 'Camara', 'prenom' => 'Ibrahim', 'email' => 'i.camara@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202402', 'nom' => 'Keïta', 'prenom' => 'Mariam', 'email' => 'm.keita@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202403', 'nom' => 'Bangoura', 'prenom' => 'Abdoulaye', 'email' => 'a.bangoura@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202404', 'nom' => 'Kaba', 'prenom' => 'Aïssatou', 'email' => 'a.kaba@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202405', 'nom' => 'Sylla', 'prenom' => 'Mamadou', 'email' => 'm.sylla@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202406', 'nom' => 'Cissé', 'prenom' => 'Hadja', 'email' => 'h.cisse@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202407', 'nom' => 'Diallo', 'prenom' => 'Ousmane', 'email' => 'o.diallo@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202408', 'nom' => 'Barry', 'prenom' => 'Kadiatou', 'email' => 'k.barry@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202409', 'nom' => 'Condé', 'prenom' => 'Mamadou', 'email' => 'm.conde@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202410', 'nom' => 'Savane', 'prenom' => 'Nabé', 'email' => 'n.savane@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202411', 'nom' => 'Fofana', 'prenom' => 'Moussa', 'email' => 'm.fofana@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202412', 'nom' => 'Baldé', 'prenom' => 'Aminata', 'email' => 'a.balde@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202413', 'nom' => 'Soumah', 'prenom' => 'Sékou', 'email' => 's.soumah@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202414', 'nom' => 'Kourouma', 'prenom' => 'Fatou', 'email' => 'f.kourouma@etudiant.bibliotheque.gn'],
            ['login' => 'ETU202415', 'nom' => 'Magassouba', 'prenom' => 'Ibrahim', 'email' => 'i.magassouba@etudiant.bibliotheque.gn'],
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
            ['login' => 'ENS004', 'nom' => 'Diané', 'prenom' => 'Aïssatou', 'email' => 'a.diane@enseignant.bibliotheque.gn'],
            ['login' => 'ENS005', 'nom' => 'Bérété', 'prenom' => 'Mamadou', 'email' => 'm.berete@enseignant.bibliotheque.gn'],
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
    }
}
