<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;

class LivreGuineaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Livres spécifiquement guinéens
        $livresGuineens = [
            [
                'titre' => 'L\'Enfant noir',
                'isbn' => '978-2-07-036002-4',
                'resume' => 'Autobiographie de Camara Laye décrivant son enfance à Kouroussa, en Haute-Guinée. Un témoignage poignant sur les traditions mandingues et le passage du monde rural à l\'école coloniale.',
                'nombre_exemplaires' => 5,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
                'editeur' => 'Plon',
                'annee_publication' => 1953,
                'langue' => 'Français',
                'nombre_pages' => 256,
                'auteurs' => ['Laye']
            ],
            [
                'titre' => 'Le Roi de Kahel',
                'isbn' => '978-2-02-097915-6',
                'resume' => 'Roman historique de Tierno Monénembo sur la conquête du Fouta-Djalon par l\'explorateur français Olivier de Sanderval. Une plongée fascinante dans l\'histoire précoloniale de la Guinée.',
                'nombre_exemplaires' => 3,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
                'editeur' => 'Éditions du Seuil',
                'annee_publication' => 2008,
                'langue' => 'Français',
                'nombre_pages' => 288,
                'auteurs' => ['Bah']
            ],
            [
                'titre' => 'Le Fils du pauvre',
                'isbn' => '978-2-7089-5012-3',
                'resume' => 'Roman autobiographique de Siradiou Diallo sur la condition des jeunes guinéens face à la pauvreté et à l\'éducation coloniale. Un classique de la littérature guinéenne.',
                'nombre_exemplaires' => 4,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
                'editeur' => 'Présence Africaine',
                'annee_publication' => 1956,
                'langue' => 'Français',
                'nombre_pages' => 192,
                'auteurs' => ['Diallo']
            ],
            [
                'titre' => 'Ségou',
                'isbn' => '978-2-253-09633-4',
                'resume' => 'Saga historique monumentale de Maryse Condé sur l\'empire bambara du Mali au XVIIIe siècle. Une fresque épique sur la traite des esclaves et la résistance africaine.',
                'nombre_exemplaires' => 4,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
                'editeur' => 'Éditions Robert Laffont',
                'annee_publication' => 1984,
                'langue' => 'Français',
                'nombre_pages' => 512,
                'auteurs' => ['Condé']
            ],
            [
                'titre' => 'Les Soleils des indépendances',
                'isbn' => '978-2-86537-200-9',
                'resume' => 'Roman d\'Ahmadou Kourouma sur les dérives des indépendances africaines. Une satire politique décapante sur l\'espoir trahi de la décolonisation.',
                'nombre_exemplaires' => 5,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
                'editeur' => 'Éditions du Seuil',
                'annee_publication' => 1968,
                'langue' => 'Français',
                'nombre_pages' => 320,
                'auteurs' => ['Kourouma']
            ],
            [
                'titre' => 'Histoire de la Guinée',
                'isbn' => '978-2-7089-5018-5',
                'resume' => 'Ouvrage de référence de Boubacar Barry sur l\'histoire complète de la Guinée, de l\'empire du Ghana à nos jours. Une synthèse historique indispensable.',
                'nombre_exemplaires' => 3,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Histoire')->first()->id,
                'editeur' => 'Présence Africaine',
                'annee_publication' => 1995,
                'langue' => 'Français',
                'nombre_pages' => 448,
                'auteurs' => ['Barry']
            ],
            [
                'titre' => 'Poèmes de la terre guinéenne',
                'isbn' => '978-2-7089-5019-2',
                'resume' => 'Recueil de poésie de Mamadou Nabé célébrant la beauté des paysages guinéens et la richesse de ses cultures. Une hymne à la patrie guinéenne.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Poésie')->first()->id,
                'editeur' => 'Éditions L\'Harmattan',
                'annee_publication' => 2002,
                'langue' => 'Français',
                'nombre_pages' => 128,
                'auteurs' => ['Nabé']
            ],
            [
                'titre' => 'Contes et légendes du Fouta-Djalon',
                'isbn' => '978-2-7089-5020-8',
                'resume' => 'Recueil de contes traditionnels guinéens recueillis par Moussa Fofana. Une immersion dans la richesse du patrimoine oral peul et mandingue.',
                'nombre_exemplaires' => 4,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Contes')->first()->id,
                'editeur' => 'Présence Africaine',
                'annee_publication' => 1988,
                'langue' => 'Français',
                'nombre_pages' => 224,
                'auteurs' => ['Fofana']
            ],
            [
                'titre' => 'L\'Empire du Wassoulou',
                'isbn' => '978-2-7089-5021-5',
                'resume' => 'Étude historique d\'Alpha Condé Touré sur l\'empire fondé par Samory Touré. Une analyse approfondie de la résistance à la colonisation française.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Histoire')->first()->id,
                'editeur' => 'Éditions Karthala',
                'annee_publication' => 2005,
                'langue' => 'Français',
                'nombre_pages' => 384,
                'auteurs' => ['Touré']
            ],
            [
                'titre' => 'Cinéma africain : regards croisés',
                'isbn' => '978-2-7089-5022-2',
                'resume' => 'Essai de Lanciné Kaba sur le cinéma africain et son rôle dans la décolonisation culturelle. Une réflexion sur l\'identité à travers le 7ème art.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Cinéma')->first()->id,
                'editeur' => 'Éditions L\'Harmattan',
                'annee_publication' => 2010,
                'langue' => 'Français',
                'nombre_pages' => 256,
                'auteurs' => ['Kaba']
            ],
            [
                'titre' => 'La femme guinéenne dans la société moderne',
                'isbn' => '978-2-7089-5023-9',
                'resume' => 'Essai de Fatou Kourouma sur la condition féminine en Guinée contemporaine. Une analyse sociologique sur les défis et les réussites des femmes guinéennes.',
                'nombre_exemplaires' => 3,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Sociologie')->first()->id,
                'editeur' => 'Éditions L\'Harmattan',
                'annee_publication' => 2015,
                'langue' => 'Français',
                'nombre_pages' => 192,
                'auteurs' => ['Kourouma']
            ],
            [
                'titre' => 'Traditions et modernité en Guinée',
                'isbn' => '978-2-7089-5024-6',
                'resume' => 'Étude de Mamadou Soumah sur les tensions entre traditions ancestrales et modernité en Guinée. Une réflexion sur l\'identité culturelle guinéenne.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Anthropologie')->first()->id,
                'editeur' => 'Éditions Karthala',
                'annee_publication' => 2012,
                'langue' => 'Français',
                'nombre_pages' => 288,
                'auteurs' => ['Soumah']
            ],
            [
                'titre' => 'Littératures guinéennes',
                'isbn' => '978-2-7089-5025-3',
                'resume' => 'Anthologie critique de Mamadou Cissé présentant les grands auteurs guinéens. Un panorama complet de la production littéraire guinéenne.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
                'editeur' => 'Éditions L\'Harmattan',
                'annee_publication' => 2008,
                'langue' => 'Français',
                'nombre_pages' => 320,
                'auteurs' => ['Cissé']
            ],
            [
                'titre' => 'Théâtre guinéen contemporain',
                'isbn' => '978-2-7089-5026-0',
                'resume' => 'Recueil de pièces de théâtre de Mamadou Bangoura sur les questions sociales guinéennes. Un théâtre engagé et politique.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Théâtre')->first()->id,
                'editeur' => 'Présence Africaine',
                'annee_publication' => 2011,
                'langue' => 'Français',
                'nombre_pages' => 224,
                'auteurs' => ['Bangoura']
            ],
            [
                'titre' => 'La Guinée précoloniale',
                'isbn' => '978-2-7089-5027-7',
                'resume' => 'Recherche historique d\'Oumar Diané sur les royaumes et empires de la Guinée avant la colonisation. Une contribution majeure à l\'histoire africaine.',
                'nombre_exemplaires' => 2,
                'disponible' => true,
                'categorie_id' => Categorie::where('libelle', 'Histoire')->first()->id,
                'editeur' => 'Éditions Karthala',
                'annee_publication' => 2014,
                'langue' => 'Français',
                'nombre_pages' => 416,
                'auteurs' => ['Diané']
            ]
        ];

        // Création des livres
        foreach ($livresGuineens as $livreData) {
            $livre = Livre::create([
                'titre' => $livreData['titre'],
                'isbn' => $livreData['isbn'],
                'resume' => $livreData['resume'],
                'nombre_exemplaires' => $livreData['nombre_exemplaires'],
                'disponible' => $livreData['disponible'],
                'categorie_id' => $livreData['categorie_id'],
                'editeur' => $livreData['editeur'],
                'annee_publication' => $livreData['annee_publication'],
                'langue' => $livreData['langue'],
                'nombre_pages' => $livreData['nombre_pages'],
            ]);

            // Association des auteurs
            foreach ($livreData['auteurs'] as $auteurNom) {
                $auteur = Auteur::where('nom', $auteurNom)->first();
                if ($auteur) {
                    $livre->auteurs()->attach($auteur->id);
                }
            }
        }
    }
}
