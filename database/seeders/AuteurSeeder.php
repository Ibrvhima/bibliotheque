<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auteur;

class AuteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auteurs = [
            // Auteurs guinéens emblématiques
            ['nom' => 'Kourouma', 'prenom' => 'Ahmadou', 'biographie' => 'Écrivain ivoirien d\'origine guinéenne, auteur de "Les Soleils des indépendances" et "En attendant le vote des bêtes sauvages"'],
            ['nom' => 'Condé', 'prenom' => 'Maryse', 'biographie' => 'Romancière guinéenne, première femme lauréate du prix Renaudot pour "Windsor Plantation"'],
            ['nom' => 'Laye', 'prenom' => 'Camara', 'biographie' => 'Écrivain guinéen, auteur du célèbre roman "L\'Enfant noir" autobiographique'],
            ['nom' => 'Nabé', 'prenom' => 'Mamadou', 'biographie' => 'Poète et romancier guinéen, figure littéraire majeure de la Guinée indépendante'],
            ['nom' => 'Kouyaté', 'prenom' => 'Sékou', 'biographie' => 'Griot et écrivain guinéen, gardien de la tradition orale mandingue'],
            ['nom' => 'Diallo', 'prenom' => 'Siradiou', 'biographie' => 'Romancier guinéen, auteur de "Le Fils du pauvre" et "Radioscopies du temps"'],
            ['nom' => 'Bah', 'prenom' => 'Tierno Monénembo', 'biographie' => 'Écrivain guinéen, lauréat du prix Renaudot pour "Le Roi de Kahel"'],
            ['nom' => 'Cissé', 'prenom' => 'Mamadou', 'biographie' => 'Poète et essayiste guinéen, spécialiste de la culture mandingue'],
            ['nom' => 'Bangoura', 'prenom' => 'Mamadou', 'biographie' => 'Dramaturge et romancier guinéen, auteur de pièces sur l\'histoire guinéenne'],
            ['nom' => 'Savane', 'prenom' => 'Nabé', 'biographie' => 'Écrivain et journaliste guinéen, chroniqueur de la société guinéenne'],
            ['nom' => 'Touré', 'prenom' => 'Alpha Condé', 'biographie' => 'Historien et écrivain guinéen, spécialiste de l\'empire du Wassoulou'],
            ['nom' => 'Sylla', 'prenom' => 'N\'Faly', 'biographie' => 'Poète guinéen, militant de la culture pular'],
            ['nom' => 'Barry', 'prenom' => 'Boubacar', 'biographie' => 'Essayiste guinéen, auteur d\'ouvrages sur l\'histoire de la Guinée'],
            ['nom' => 'Soumah', 'prenom' => 'Mamadou', 'biographie' => 'Romancier guinéen, auteur de récits sur la vie rurale en Guinée'],
            ['nom' => 'Kaba', 'prenom' => 'Lanciné', 'biographie' => 'Cinéaste et écrivain guinéen, spécialiste du cinéma africain'],
            ['nom' => 'Fofana', 'prenom' => 'Moussa', 'biographie' => 'Conteur et écrivain guinéen, gardien des traditions soussou'],
            ['nom' => 'Baldé', 'prenom' => 'Mamadou', 'biographie' => 'Poète guinéen, militant de la littérature en langues nationales'],
            ['nom' => 'Magassouba', 'prenom' => 'Mamadou', 'biographie' => 'Écrivain guinéen, spécialiste des traditions maninka'],
            ['nom' => 'Kourouma', 'prenom' => 'Fatou', 'biographie' => 'Romancière guinéenne, auteure de romans sur la condition féminine'],
            ['nom' => 'Diané', 'prenom' => 'Oumar', 'biographie' => 'Historien guinéen, spécialiste de l\'histoire précoloniale'],
            
            // Auteurs africains classiques
            ['nom' => 'Senghor', 'prenom' => 'Léopold Sédar', 'biographie' => 'Poète, écrivain et homme d\'État sénégalais, père de la Négritude'],
            ['nom' => 'Césaire', 'prenom' => 'Aimé', 'biographie' => 'Poète et homme politique martiniquais, figure de la Négritude'],
            ['nom' => 'Sembène', 'prenom' => 'Ousmane', 'biographie' => 'Écrivain et cinéaste sénégalais, père du cinéma africain'],
            ['nom' => 'Diop', 'prenom' => 'Cheikh Anta', 'biographie' => 'Historien et anthropologue sénégalais, pionnier de l\'égyptologie africaine'],
            ['nom' => 'Sow Fall', 'prenom' => 'Aminata', 'biographie' => 'Romancière sénégalaise, première femme lauréate du grand prix littéraire d\'Afrique noire'],
            ['nom' => 'Bugul', 'prenom' => 'Ken', 'biographie' => 'Écrivaine sénégalaise, auteure de "Le Baobab fou"'],
            ['nom' => 'Achebe', 'prenom' => 'Chinua', 'biographie' => 'Romancier nigérian, auteur de "Things Fall Apart"'],
            ['nom' => 'Ngugi wa Thiong\'o', 'prenom' => 'James', 'biographie' => 'Écrivain kényan, militant de la littérature en langues africaines'],
            ['nom' => 'Bâ', 'prenom' => 'Mariama', 'biographie' => 'Romancière sénégalaise, auteure de "Une si longue lettre"'],
            ['nom' => 'Ousmane', 'prenom' => 'Sembène', 'biographie' => 'Cinéaste et écrivain sénégalais, pionnier du cinéma africain'],
            
            // Auteurs classiques internationaux
            ['nom' => 'Hugo', 'prenom' => 'Victor', 'biographie' => 'Poète, romancier et dramaturge français, auteur des "Misérables"'],
            ['nom' => 'Camus', 'prenom' => 'Albert', 'biographie' => 'Écrivain et philosophe français, prix Nobel de littérature'],
            ['nom' => 'Sartre', 'prenom' => 'Jean-Paul', 'biographie' => 'Philosophe et écrivain français, père de l\'existentialisme'],
            ['nom' => 'Kant', 'prenom' => 'Emmanuel', 'biographie' => 'Philosophe allemand, auteur de la "Critique de la raison pure"'],
            ['nom' => 'Platon', 'prenom' => '', 'biographie' => 'Philosophe grec de l\'Antiquité, disciple de Socrate'],
            ['nom' => 'Einstein', 'prenom' => 'Albert', 'biographie' => 'Physicien théoricien, père de la relativité'],
            ['nom' => 'Hawking', 'prenom' => 'Stephen', 'biographie' => 'Physicien théoricien britannique, spécialiste des trous noirs'],
            ['nom' => 'Knuth', 'prenom' => 'Donald', 'biographie' => 'Informaticien et mathématicien américain, auteur de "The Art of Computer Programming"'],
            ['nom' => 'Smith', 'prenom' => 'Adam', 'biographie' => 'Philosophe et économiste écossais, père de l\'économie moderne'],
            ['nom' => 'Keynes', 'prenom' => 'John Maynard', 'biographie' => 'Économiste britannique, père de la macroéconomie moderne'],
            ['nom' => 'Yunus', 'prenom' => 'Muhammad', 'biographie' => 'Économiste bangladais, prix Nobel de la paix pour la microfinance'],
            ['nom' => 'Saint-Exupéry', 'prenom' => 'Antoine de', 'biographie' => 'Écrivain et aviateur français, auteur du "Petit Prince"'],
        ];

        foreach ($auteurs as $auteur) {
            Auteur::create($auteur);
        }
    }
}
