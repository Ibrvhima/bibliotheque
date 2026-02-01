<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\User;
use App\Models\Livre;
use Illuminate\Http\Request;
use TCPDF;

class SimpleExportController extends Controller
{
    public function exportEmpruntsPDF()
    {
        $emprunts = Emprunt::with(['user', 'livre.categorie'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Créer un nouveau document PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Mettre les informations du document
        $pdf->SetCreator('Bibliothèque Universitaire');
        $pdf->SetAuthor('Bibliothèque Universitaire');
        $pdf->SetTitle('Rapport des Emprunts');
        $pdf->SetSubject('Rapport des Emprunts');

        // Ajouter une page
        $pdf->AddPage();

        // Définir la police
        $pdf->SetFont('helvetica', '', 12);

        // Construire le contenu HTML
        $html = $this->generatePDFHTMLContent($emprunts);

        // Écrire le contenu HTML
        $pdf->writeHTML($html, true, false, true, false, '');

        // Fermer et sortir le PDF
        $filename = "rapport_emprunts_" . date('Y-m-d_H-i') . ".pdf";
        
        return response($pdf->Output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"")
            ->header('Content-Length', strlen($pdf->Output($filename, 'S')));
    }

    public function exportEmpruntsExcel()
    {
        $emprunts = Emprunt::with(['user', 'livre.categorie'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "emprunts_" . date('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($emprunts) {
            $file = fopen('php://output', 'w');
            
            // Ajouter BOM pour Excel
            fwrite($file, "\xEF\xBB\xBF");
            
            fputcsv($file, [
                'ID',
                'Utilisateur',
                'Livre',
                'Catégorie',
                'Date Emprunt',
                'Date Retour Prévue',
                'Date Retour Effectif',
                'Statut'
            ]);

            foreach ($emprunts as $emprunt) {
                fputcsv($file, [
                    $emprunt->id,
                    $emprunt->user->getFullNameAttribute(),
                    $emprunt->livre->titre,
                    $emprunt->livre->categorie->nom ?? 'Non catégorisé',
                    $emprunt->date_emprunt->format('d/m/Y'),
                    $emprunt->date_retour_prevue->format('d/m/Y'),
                    $emprunt->date_retour_effectif ? $emprunt->date_retour_effectif->format('d/m/Y') : 'Non retourné',
                    ucfirst(str_replace('_', ' ', $emprunt->statut))
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generatePDFHTMLContent($emprunts)
    {
        $total_emprunts = $emprunts->count();
        $emprunts_en_cours = $emprunts->where('statut', 'en_cours')->count();
        $emprunts_en_retard = $emprunts->where('statut', 'en_retard')->count();
        $date_export = now()->format('d/m/Y H:i');

        $html = '
        <style>
            .header {
                text-align: center;
                border-bottom: 2px solid #3b82f6;
                padding-bottom: 20px;
                margin-bottom: 30px;
            }
            .stats {
                display: flex;
                justify-content: space-around;
                margin-bottom: 30px;
                background: #f3f4f6;
                padding: 20px;
                border-radius: 8px;
            }
            .stat-item {
                text-align: center;
            }
            .stat-number {
                font-size: 24px;
                font-weight: bold;
                color: #3b82f6;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #3b82f6;
                color: white;
            }
            .statut-en_cours { background-color: #dcfce7; }
            .statut-en_retard { background-color: #fee2e2; }
            .statut-retourne { background-color: #dbeafe; }
            .statut-en_attente { background-color: #fef3c7; }
            .footer {
                margin-top: 40px;
                text-align: center;
                color: #666;
                font-size: 12px;
            }
        </style>

        <div class="header">
            <h1>📚 Rapport des Emprunts</h1>
            <p><strong>Bibliothèque Universitaire</strong></p>
            <p>Généré le ' . $date_export . '</p>
        </div>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">' . $total_emprunts . '</div>
                <div>Total Emprunts</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">' . $emprunts_en_cours . '</div>
                <div>En Cours</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">' . $emprunts_en_retard . '</div>
                <div>En Retard</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th><strong>ID</strong></th>
                    <th><strong>Utilisateur</strong></th>
                    <th><strong>Livre</strong></th>
                    <th><strong>Catégorie</strong></th>
                    <th><strong>Date Emprunt</strong></th>
                    <th><strong>Retour Prévu</strong></th>
                    <th><strong>Retour Effectif</strong></th>
                    <th><strong>Statut</strong></th>
                </tr>
            </thead>
            <tbody>';

        foreach ($emprunts as $emprunt) {
            $statutClass = str_replace('_', '-', $emprunt->statut);
            $html .= '
                <tr>
                    <td><strong>#' . $emprunt->id . '</strong></td>
                    <td>' . htmlspecialchars($emprunt->user->getFullNameAttribute()) . '</td>
                    <td>' . htmlspecialchars($emprunt->livre->titre) . '</td>
                    <td>' . htmlspecialchars($emprunt->livre->categorie->nom ?? 'Non catégorisé') . '</td>
                    <td>' . $emprunt->date_emprunt->format('d/m/Y') . '</td>
                    <td>' . $emprunt->date_retour_prevue->format('d/m/Y') . '</td>
                    <td>' . ($emprunt->date_retour_effectif ? $emprunt->date_retour_effectif->format('d/m/Y') : 'Non retourné') . '</td>
                    <td>
                        <span class="statut-' . $statutClass . '">
                            ' . ucfirst(str_replace('_', ' ', $emprunt->statut)) . '
                        </span>
                    </td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <div class="footer">
            <p><strong>© ' . date('Y') . ' Bibliothèque Universitaire</strong></p>
            <p>Rapport généré automatiquement le ' . $date_export . '</p>
        </div>';

        return $html;
    }

    private function generateSimpleHTMLContent($emprunts)
    {
        $total_emprunts = $emprunts->count();
        $emprunts_en_cours = $emprunts->where('statut', 'en_cours')->count();
        $emprunts_en_retard = $emprunts->where('statut', 'en_retard')->count();
        $date_export = now()->format('d/m/Y H:i');

        $html = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Emprunts - Bibliothèque Universitaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 30px;
            border-radius: 10px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0;
            color: #64748b;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        .stat-item {
            text-align: center;
            padding: 15px;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
            display: block;
        }
        .stat-label {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
        }
        td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        .statut-en_cours { 
            background-color: #dcfce7; 
            color: #166534;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .statut-en_retard { 
            background-color: #fee2e2; 
            color: #dc2626;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .statut-retourne { 
            background-color: #dbeafe; 
            color: #2563eb;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .statut-en_attente { 
            background-color: #fef3c7; 
            color: #d97706;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .print-info {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        @media print {
            body { margin: 10px; font-size: 12px; }
            .print-info { display: none; }
            .header { background: none; border: 1px solid #ccc; }
        }
    </style>
</head>
<body>
    <div class="print-info">
        <strong>💡 Astuce :</strong> Pour imprimer ce rapport en PDF, utilisez Ctrl+P (Windows) ou Cmd+P (Mac) et choisissez "Enregistrer en PDF"
    </div>

    <div class="header">
        <h1>📚 Rapport des Emprunts</h1>
        <p><strong>Bibliothèque Universitaire</strong></p>
        <p>Généré le ' . $date_export . '</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <span class="stat-number">' . $total_emprunts . '</span>
            <div class="stat-label">Total Emprunts</div>
        </div>
        <div class="stat-item">
            <span class="stat-number">' . $emprunts_en_cours . '</span>
            <div class="stat-label">En Cours</div>
        </div>
        <div class="stat-item">
            <span class="stat-number">' . $emprunts_en_retard . '</span>
            <div class="stat-label">En Retard</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Livre</th>
                <th>Catégorie</th>
                <th>Date Emprunt</th>
                <th>Retour Prévu</th>
                <th>Retour Effectif</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($emprunts as $emprunt) {
            $statutClass = str_replace('_', '-', $emprunt->statut);
            $html .= '
            <tr>
                <td><strong>#' . $emprunt->id . '</strong></td>
                <td>' . htmlspecialchars($emprunt->user->getFullNameAttribute()) . '</td>
                <td>' . htmlspecialchars($emprunt->livre->titre) . '</td>
                <td>' . htmlspecialchars($emprunt->livre->categorie->nom ?? 'Non catégorisé') . '</td>
                <td>' . $emprunt->date_emprunt->format('d/m/Y') . '</td>
                <td>' . $emprunt->date_retour_prevue->format('d/m/Y') . '</td>
                <td>' . ($emprunt->date_retour_effectif ? $emprunt->date_retour_effectif->format('d/m/Y') : '<em>Non retourné</em>') . '</td>
                <td>
                    <span class="statut-' . $statutClass . '">
                        ' . ucfirst(str_replace('_', ' ', $emprunt->statut)) . '
                    </span>
                </td>
            </tr>';
        }

        $html .= '
        </tbody>
    </table>

    <div class="footer">
        <p><strong>© ' . date('Y') . ' Bibliothèque Universitaire</strong></p>
        <p>Rapport généré automatiquement le ' . $date_export . '</p>
        <p><em>Ce document peut être imprimé en PDF via Ctrl+P ou Cmd+P</em></p>
    </div>
</body>
</html>';

        return $html;
    }

    private function generatePDFContent($emprunts)
    {
        $total_emprunts = $emprunts->count();
        $emprunts_en_cours = $emprunts->where('statut', 'en_cours')->count();
        $emprunts_en_retard = $emprunts->where('statut', 'en_retard')->count();
        $date_export = now()->format('d/m/Y H:i');

        $html = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Emprunts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #3b82f6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3b82f6;
            color: white;
        }
        .statut-en_cours { background-color: #dcfce7; }
        .statut-en_retard { background-color: #fee2e2; }
        .statut-retourne { background-color: #dbeafe; }
        .statut-en_attente { background-color: #fef3c7; }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        @media print {
            body { margin: 10px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Rapport des Emprunts</h1>
        <p>Bibliothèque Universitaire</p>
        <p>Généré le ' . $date_export . '</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">' . $total_emprunts . '</div>
            <div>Total Emprunts</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">' . $emprunts_en_cours . '</div>
            <div>En Cours</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">' . $emprunts_en_retard . '</div>
            <div>En Retard</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Livre</th>
                <th>Catégorie</th>
                <th>Date Emprunt</th>
                <th>Retour Prévu</th>
                <th>Retour Effectif</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($emprunts as $emprunt) {
            $html .= '
            <tr>
                <td>' . $emprunt->id . '</td>
                <td>' . $emprunt->user->getFullNameAttribute() . '</td>
                <td>' . $emprunt->livre->titre . '</td>
                <td>' . ($emprunt->livre->categorie->nom ?? 'Non catégorisé') . '</td>
                <td>' . $emprunt->date_emprunt->format('d/m/Y') . '</td>
                <td>' . $emprunt->date_retour_prevue->format('d/m/Y') . '</td>
                <td>' . ($emprunt->date_retour_effectif ? $emprunt->date_retour_effectif->format('d/m/Y') : 'Non retourné') . '</td>
                <td>
                    <span class="statut-' . $emprunt->statut . '">
                        ' . ucfirst(str_replace('_', ' ', $emprunt->statut)) . '
                    </span>
                </td>
            </tr>';
        }

        $html .= '
        </tbody>
    </table>

    <div class="footer">
        <p>© ' . date('Y') . ' Bibliothèque Universitaire - Rapport généré automatiquement</p>
    </div>
</body>
</html>';

        return $html;
    }
}
