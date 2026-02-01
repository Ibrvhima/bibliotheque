<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'libelle' => 'Roman',
                'description' => 'Œuvres de fiction narrative en prose'
            ],
            [
                'libelle' => 'Science',
                'description' => 'Ouvrages scientifiques et techniques'
            ],
            [
                'libelle' => 'Histoire',
                'description' => 'Livres d\'histoire et documents historiques'
            ],
            [
                'libelle' => 'Philosophie',
                'description' => 'Ouvrages philosophiques et de réflexion'
            ],
            [
                'libelle' => 'Informatique',
                'description' => 'Livres sur la programmation et les technologies'
            ],
            [
                'libelle' => 'Littérature africaine',
                'description' => 'Œuvres de la littérature africaine'
            ],
            [
                'libelle' => 'Économie',
                'description' => 'Ouvrages d\'économie et de gestion'
            ],
            [
                'libelle' => 'Poésie',
                'description' => 'Recueils de poèmes et poésie'
            ],
            [
                'libelle' => 'Jeunesse',
                'description' => 'Livres pour enfants et adolescents'
            ],
            [
                'libelle' => 'Sciences sociales',
                'description' => 'Sociologie, anthropologie, psychologie'
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}
