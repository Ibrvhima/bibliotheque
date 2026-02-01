<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorieSeeder::class,        // Catégories générales d'abord
            CategorieGuineaSeeder::class,  // Catégories spécifiques à la Guinée
            AuteurSeeder::class,          // Auteurs guinéens et africains
            LivreSeeder::class,           // Livres généraux
            LivreGuineaSeeder::class,     // Livres spécifiquement guinéens
        ]);
    }
}
