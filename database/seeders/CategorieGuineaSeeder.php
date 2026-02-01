<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieGuineaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Catégories littéraires africaines
            ['libelle' => 'Littérature africaine', 'description' => 'Romans, nouvelles et récits d\'auteurs africains'],
            ['libelle' => 'Littérature guinéenne', 'description' => 'Œuvres littéraires spécifiquement guinéennes'],
            ['libelle' => 'Poésie africaine', 'description' => 'Poèmes et recueils poétiques africains'],
            ['libelle' => 'Contes et légendes', 'description' => 'Patrimoine oral et traditions africaines'],
            
            // Catégories historiques et culturelles
            ['libelle' => 'Histoire de la Guinée', 'description' => 'Ouvrages sur l\'histoire passée et présente de la Guinée'],
            ['libelle' => 'Histoire africaine', 'description' => 'Histoire du continent africain et de ses civilisations'],
            ['libelle' => 'Culture guinéenne', 'description' => 'Traditions, coutumes et pratiques culturelles guinéennes'],
            ['libelle' => 'Anthropologie', 'description' => 'Études des sociétés et cultures africaines'],
            
            // Catégories sciences humaines
            ['libelle' => 'Sociologie', 'description' => 'Études des sociétés africaines contemporaines'],
            ['libelle' => 'Science politique', 'description' => 'Politique et gouvernance en Afrique'],
            ['libelle' => 'Économie africaine', 'description' => 'Développement économique et modèles africains'],
            
            // Catégories artistiques
            ['libelle' => 'Cinéma africain', 'description' => 'Films et études cinématographiques africaines'],
            ['libelle' => 'Théâtre africain', 'description' => 'Pièces théâtrales et arts dramatiques africains'],
            ['libelle' => 'Musique africaine', 'description' => 'Traditions musicales et musiques contemporaines'],
            
            // Catégories linguistiques
            ['libelle' => 'Langues africaines', 'description' => 'Études linguistiques et littératures en langues nationales'],
            ['libelle' => 'Littérature orale', 'description' => 'Traditions orales et littérature parlée'],
            
            // Catégories classiques
            ['libelle' => 'Roman', 'description' => 'Romans internationaux et classiques'],
            ['libelle' => 'Philosophie', 'description' => 'Œuvres philosophiques et pensée critique'],
            ['libelle' => 'Sciences', 'description' => 'Ouvrages scientifiques et techniques'],
            ['libelle' => 'Informatique', 'description' => 'Technologies de l\'information et programmation'],
            ['libelle' => 'Jeunesse', 'description' => 'Littérature jeunesse et éducation'],
            
            // Catégories spécialisées Guinée
            ['libelle' => 'Empires du Sahel', 'description' => 'Histoire des grands empires ouest-africains'],
            ['libelle' => 'Résistance anticoloniale', 'description' => 'Luttes contre la colonisation en Afrique'],
            ['libelle' => 'Développement durable', 'description' => 'Environnement et développement en Afrique'],
            ['libelle' => 'Diaspora guinéenne', 'description' => 'Études sur la diaspora guinéenne dans le monde'],
        ];

        foreach ($categories as $categorie) {
            Categorie::updateOrCreate(
                ['libelle' => $categorie['libelle']],
                ['description' => $categorie['description']]
            );
        }
    }
}
