<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;

class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Romans guinéens et ouest-africains
        $livre1 = Livre::create([
            'titre' => 'Le Fils du pauvre',
            'isbn' => '978-2-7089-5012-3',
            'resume' => 'Roman autobiographique de Siradiou Diallo sur l\'enfance en Guinée',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Présence Africaine',
            'annee_publication' => 1956,
        ]);
        $livre1->auteurs()->attach(Auteur::where('nom', 'Diallo')->first()->id);

        $livre2 = Livre::create([
            'titre' => 'Les Soleils des indépendances',
            'isbn' => '978-2-86537-200-9',
            'resume' => 'Roman d\'Ahmadou Kourouma sur les dérives de l\'indépendance en Afrique',
            'nombre_exemplaires' => 4,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Éditions du Seuil',
            'annee_publication' => 1968,
        ]);
        $livre2->auteurs()->attach(Auteur::where('nom', 'Kourouma')->first()->id);

        $livre3 = Livre::create([
            'titre' => 'Ségou',
            'isbn' => '978-2-253-09633-4',
            'resume' => 'Saga historique de Maryse Condé sur l\'empire bambara du Mali',
            'nombre_exemplaires' => 5,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Éditions Robert Laffont',
            'annee_publication' => 1984,
        ]);
        $livre3->auteurs()->attach(Auteur::where('nom', 'Condé')->first()->id);

        $livre4 = Livre::create([
            'titre' => 'L\'Enfant noir',
            'isbn' => '978-2-7089-5015-4',
            'resume' => 'Autobiographie de Camara Laye sur son enfance en Guinée',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Plon',
            'annee_publication' => 1953,
        ]);
        $livre4->auteurs()->attach(Auteur::where('nom', 'Laye')->first()->id);

        $livre5 = Livre::create([
            'titre' => 'Une si longue lettre',
            'isbn' => '978-2-86537-201-6',
            'resume' => 'Roman épistolaire de Mariama Bâ sur la condition féminine au Sénégal',
            'nombre_exemplaires' => 4,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Nouvelles Éditions Africaines',
            'annee_publication' => 1979,
        ]);
        $livre5->auteurs()->attach(Auteur::where('nom', 'Bâ')->first()->id);

        // Littérature classique française
        $livre6 = Livre::create([
            'titre' => 'Les Misérables',
            'isbn' => '978-2-253-09634-1',
            'resume' => 'Chef-d\'œuvre de Victor Hugo sur la justice sociale en France du XIXe siècle',
            'nombre_exemplaires' => 5,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Roman')->first()->id,
            'editeur' => 'Le Livre de Poche',
            'annee_publication' => 1862,
        ]);
        $livre6->auteurs()->attach(Auteur::where('nom', 'Hugo')->first()->id);

        $livre7 = Livre::create([
            'titre' => 'L\'Étranger',
            'isbn' => '978-2-07-036002-4',
            'resume' => 'Roman philosophique d\'Albert Camus sur l\'absurde de la condition humaine',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Roman')->first()->id,
            'editeur' => 'Éditions Gallimard',
            'annee_publication' => 1942,
        ]);
        $livre7->auteurs()->attach(Auteur::where('nom', 'Camus')->first()->id);

        // Philosophie et sciences humaines
        $livre8 = Livre::create([
            'titre' => 'Critique de la raison pure',
            'isbn' => '978-2-13-044424-7',
            'resume' => 'Œuvre fondamentale d\'Emmanuel Kant sur la philosophie de la connaissance',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Philosophie')->first()->id,
            'editeur' => 'Presses Universitaires de France',
            'annee_publication' => 1781,
        ]);
        $livre8->auteurs()->attach(Auteur::where('nom', 'Kant')->first()->id);

        $livre9 = Livre::create([
            'titre' => 'L\'Existentialisme est un humanisme',
            'isbn' => '978-2-07-032423-8',
            'resume' => 'Texte fondateur de Jean-Paul Sartre présentant sa philosophie existentialiste',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Philosophie')->first()->id,
            'editeur' => 'Éditions Gallimard',
            'annee_publication' => 1946,
        ]);
        $livre9->auteurs()->attach(Auteur::where('nom', 'Sartre')->first()->id);

        // Sciences et technologie
        $livre10 = Livre::create([
            'titre' => 'Relativity: The Special and the General Theory',
            'isbn' => '978-0-517-88441-6',
            'resume' => 'Présentation accessible de la théorie de la relativité par Albert Einstein',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Sciences')->first()->id,
            'editeur' => 'Crown Publishers',
            'annee_publication' => 1916,
        ]);
        $livre10->auteurs()->attach(Auteur::where('nom', 'Einstein')->first()->id);

        $livre11 = Livre::create([
            'titre' => 'A Brief History of Time',
            'isbn' => '978-0-553-38016-3',
            'resume' => 'Exploration de l\'univers par Stephen Hawking, du Big Bang aux trous noirs',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Sciences')->first()->id,
            'editeur' => 'Bantam Books',
            'annee_publication' => 1988,
        ]);
        $livre11->auteurs()->attach(Auteur::where('nom', 'Hawking')->first()->id);

        // Informatique et mathématiques
        $livre12 = Livre::create([
            'titre' => 'The Art of Computer Programming, Volume 1',
            'isbn' => '978-0-201-89683-1',
            'resume' => 'Traité fondamental de Donald Knuth sur les algorithmes et structures de données',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Informatique')->first()->id,
            'editeur' => 'Addison-Wesley',
            'annee_publication' => 1968,
        ]);
        $livre12->auteurs()->attach(Auteur::where('nom', 'Knuth')->first()->id);

        // Économie et société
        $livre13 = Livre::create([
            'titre' => 'The Wealth of Nations',
            'isbn' => '978-0-14-043615-0',
            'resume' => 'Œuvre fondatrice d\'Adam Smith de l\'économie classique moderne',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Économie')->first()->id,
            'editeur' => 'Penguin Classics',
            'annee_publication' => 1776,
        ]);
        $livre13->auteurs()->attach(Auteur::where('nom', 'Smith')->first()->id);

        $livre14 = Livre::create([
            'titre' => 'Creating a World Without Poverty',
            'isbn' => '978-1-58648-493-4',
            'resume' => 'Vision de Muhammad Yunus sur la microfinance et l\'entrepreneuriat social',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Économie')->first()->id,
            'editeur' => 'PublicAffairs',
            'annee_publication' => 2007,
        ]);
        $livre14->auteurs()->attach(Auteur::where('nom', 'Yunus')->first()->id);

        // Littérature jeunesse
        $livre15 = Livre::create([
            'titre' => 'Le Petit Prince',
            'isbn' => '978-2-07-040860-2',
            'resume' => 'Conte philosophique d\'Antoine de Saint-Exupéry sur l\'amitié et la vie',
            'nombre_exemplaires' => 6,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Jeunesse')->first()->id,
            'editeur' => 'Éditions Gallimard',
            'annee_publication' => 1943,
        ]);
        $livre15->auteurs()->attach(Auteur::where('nom', 'Saint-Exupéry')->first()->id);

        // Histoire et culture africaine
        $livre16 = Livre::create([
            'titre' => 'Civilisation ou Barbarie',
            'isbn' => '978-2-7089-5018-5',
            'resume' => 'Œuvre majeure de Cheikh Anta Diop sur l\'apport de l\'Afrique à la civilisation',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Histoire')->first()->id,
            'editeur' => 'Présence Africaine',
            'annee_publication' => 1965,
        ]);
        $livre16->auteurs()->attach(Auteur::where('nom', 'Diop')->first()->id);

        $livre17 = Livre::create([
            'titre' => 'Hosties noires',
            'isbn' => '978-2-7089-5019-2',
            'resume' => 'Recueil de poèmes de Léopold Sédar Senghor célébrant la négritude',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Poésie')->first()->id,
            'editeur' => 'Éditions du Seuil',
            'annee_publication' => 1948,
        ]);
        $livre17->auteurs()->attach(Auteur::where('nom', 'Senghor')->first()->id);

        // Romans contemporains africains
        $livre18 = Livre::create([
            'titre' => 'Things Fall Apart',
            'isbn' => '978-0-435-90550-3',
            'resume' => 'Roman de Chinua Achebe sur l\'impact de la colonisation en Afrique',
            'nombre_exemplaires' => 4,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Heinemann',
            'annee_publication' => 1958,
        ]);
        $livre18->auteurs()->attach(Auteur::where('nom', 'Achebe')->first()->id);

        $livre19 = Livre::create([
            'titre' => 'A Grain of Wheat',
            'isbn' => '978-0-435-90987-7',
            'resume' => 'Roman de Ngugi wa Thiong\'o sur l\'indépendance du Kenya',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Heinemann',
            'annee_publication' => 1967,
        ]);
        $livre19->auteurs()->attach(Auteur::where('nom', 'Ngugi wa Thiong\'o')->first()->id);

        // Théâtre africain
        $livre20 = Livre::create([
            'titre' => 'Les Tragédies congolaises',
            'isbn' => '978-2-7089-5020-8',
            'resume' => 'Pièces théâtrales de Tchicaya U Tam\'si sur la politique congolaise',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Théâtre')->first()->id,
            'editeur' => 'Présence Africaine',
            'annee_publication' => 1970,
        ]);
        $livre20->auteurs()->attach(Auteur::where('nom', 'U Tam\'si')->first()->id);
        $livre3->auteurs()->attach(Auteur::where('nom', 'Hugo')->first()->id);

        $livre4 = Livre::create([
            'titre' => 'L\'Étranger',
            'isbn' => '978-2-07-036002-4',
            'resume' => 'Roman philosophique d\'Albert Camus',
            'nombre_exemplaires' => 4,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Roman')->first()->id,
            'editeur' => 'Gallimard',
            'annee_publication' => 1942,
        ]);
        $livre4->auteurs()->attach(Auteur::where('nom', 'Camus')->first()->id);

        // Philosophie
        $livre5 = Livre::create([
            'titre' => 'La République',
            'isbn' => '978-2-08-070653-1',
            'resume' => 'Dialogue de Platon portant sur la justice',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Philosophie')->first()->id,
            'editeur' => 'Flammarion',
            'annee_publication' => -380,
        ]);
        $livre5->auteurs()->attach(Auteur::where('nom', 'Platon')->first()->id);

        $livre6 = Livre::create([
            'titre' => 'Critique de la raison pure',
            'isbn' => '978-2-08-070842-9',
            'resume' => 'Œuvre majeure d\'Emmanuel Kant',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Philosophie')->first()->id,
            'editeur' => 'Flammarion',
            'annee_publication' => 1781,
        ]);
        $livre6->auteurs()->attach(Auteur::where('nom', 'Kant')->first()->id);

        // Histoire
        $livre7 = Livre::create([
            'titre' => 'Nations nègres et culture',
            'isbn' => '978-2-7089-0024-2',
            'resume' => 'Ouvrage majeur de Cheikh Anta Diop sur l\'histoire africaine',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Histoire')->first()->id,
            'editeur' => 'Présence Africaine',
            'annee_publication' => 1954,
        ]);
        $livre7->auteurs()->attach(Auteur::where('nom', 'Diop')->first()->id);

        // Science
        $livre8 = Livre::create([
            'titre' => 'Une brève histoire du temps',
            'isbn' => '978-2-08-081238-5',
            'resume' => 'Livre de vulgarisation scientifique par Stephen Hawking',
            'nombre_exemplaires' => 4,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Science')->first()->id,
            'editeur' => 'Flammarion',
            'annee_publication' => 1988,
        ]);
        $livre8->auteurs()->attach(Auteur::where('nom', 'Hawking')->first()->id);

        // Informatique
        $livre9 = Livre::create([
            'titre' => 'The Art of Computer Programming',
            'isbn' => '978-0-201-89683-1',
            'resume' => 'Série de monographies sur les algorithmes',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Informatique')->first()->id,
            'editeur' => 'Addison-Wesley',
            'annee_publication' => 1968,
        ]);
        $livre9->auteurs()->attach(Auteur::where('nom', 'Knuth')->first()->id);

        // Économie
        $livre10 = Livre::create([
            'titre' => 'La Richesse des nations',
            'isbn' => '978-2-08-070400-1',
            'resume' => 'Œuvre fondatrice de l\'économie politique par Adam Smith',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Économie')->first()->id,
            'editeur' => 'Flammarion',
            'annee_publication' => 1776,
        ]);
        $livre10->auteurs()->attach(Auteur::where('nom', 'Smith')->first()->id);

        // Poésie
        $livre11 = Livre::create([
            'titre' => 'Chants d\'ombre',
            'isbn' => '978-2-02-000285-6',
            'resume' => 'Recueil de poèmes de Léopold Sédar Senghor',
            'nombre_exemplaires' => 4,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Poésie')->first()->id,
            'editeur' => 'Seuil',
            'annee_publication' => 1945,
        ]);
        $livre11->auteurs()->attach(Auteur::where('nom', 'Senghor')->first()->id);

        $livre12 = Livre::create([
            'titre' => 'Cahier d\'un retour au pays natal',
            'isbn' => '978-2-7089-0003-7',
            'resume' => 'Poème d\'Aimé Césaire',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Poésie')->first()->id,
            'editeur' => 'Présence Africaine',
            'annee_publication' => 1939,
        ]);
        $livre12->auteurs()->attach(Auteur::where('nom', 'Césaire')->first()->id);

        // Jeunesse
        $livre13 = Livre::create([
            'titre' => 'Le Petit Prince',
            'isbn' => '978-2-07-061275-8',
            'resume' => 'Conte philosophique et poétique',
            'nombre_exemplaires' => 5,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Jeunesse')->first()->id,
            'editeur' => 'Gallimard',
            'annee_publication' => 1943,
        ]);
        $livre13->auteurs()->attach(Auteur::where('nom', 'Saint-Exupéry')->first()->id);

        // Romans africains supplémentaires
        $livre14 = Livre::create([
            'titre' => 'Le Baobab fou',
            'isbn' => '978-2-7089-5230-1',
            'resume' => 'Roman autobiographique de Ken Bugul',
            'nombre_exemplaires' => 2,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Présence Africaine',
            'annee_publication' => 1982,
        ]);
        $livre14->auteurs()->attach(Auteur::where('nom', 'Bugul')->first()->id);

        $livre15 = Livre::create([
            'titre' => 'Things Fall Apart',
            'isbn' => '978-0-385-47454-2',
            'resume' => 'Roman de Chinua Achebe sur le colonialisme',
            'nombre_exemplaires' => 3,
            'disponible' => true,
            'categorie_id' => Categorie::where('libelle', 'Littérature africaine')->first()->id,
            'editeur' => 'Anchor Books',
            'annee_publication' => 1958,
        ]);
        $livre15->auteurs()->attach(Auteur::where('nom', 'Achebe')->first()->id);
    }
}
