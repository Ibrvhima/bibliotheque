<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Emprunts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
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
        .statut-en-cours { background-color: #dcfce7; }
        .statut-en-retard { background-color: #fee2e2; }
        .statut-retourne { background-color: #dbeafe; }
        .statut-en_attente { background-color: #fef3c7; }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Rapport des Emprunts</h1>
        <p>Bibliothèque Universitaire</p>
        <p>Généré le {{ $date_export }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $total_emprunts }}</div>
            <div>Total Emprunts</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $emprunts_en_cours }}</div>
            <div>En Cours</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $emprunts_en_retard }}</div>
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
        <tbody>
            @foreach($emprunts as $emprunt)
            <tr>
                <td>{{ $emprunt->id }}</td>
                <td>{{ $emprunt->user->getFullNameAttribute() }}</td>
                <td>{{ $emprunt->livre->titre }}</td>
                <td>{{ $emprunt->livre->categorie->nom ?? 'Non catégorisé' }}</td>
                <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                <td>{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</td>
                <td>{{ $emprunt->date_retour_effectif ? $emprunt->date_retour_effectif->format('d/m/Y') : 'Non retourné' }}</td>
                <td>
                    <span class="statut-{{ $emprunt->statut }}">
                        {{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} Bibliothèque Universitaire - Rapport généré automatiquement</p>
    </div>
</body>
</html>
