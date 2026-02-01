<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Statistiques</title>
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #3b82f6;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        .chart-container {
            margin: 30px 0;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }
        .bar-chart {
            display: flex;
            align-items: flex-end;
            height: 200px;
            gap: 10px;
            padding: 20px;
        }
        .bar {
            flex: 1;
            background: #3b82f6;
            color: white;
            text-align: center;
            border-radius: 4px 4px 0 0;
            position: relative;
            min-height: 20px;
        }
        .bar-label {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            font-size: 12px;
            transform: rotate(-45deg);
            transform-origin: center;
        }
        .bar-value {
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Rapport de Statistiques</h1>
        <p>Bibliothèque Universitaire</p>
        <p>Généré le {{ $date_export }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_lecteurs'] }}</div>
            <div class="stat-label">Lecteurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_livres'] }}</div>
            <div class="stat-label">Total Livres</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['livres_disponibles'] }}</div>
            <div class="stat-label">Livres Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_emprunts'] }}</div>
            <div class="stat-label">Total Emprunts</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['emprunts_en_cours'] }}</div>
            <div class="stat-label">Emprunts en Cours</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['emprunts_en_retard'] }}</div>
            <div class="stat-label">Emprunts en Retard</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['categories_count'] }}</div>
            <div class="stat-label">Catégories</div>
        </div>
    </div>

    <div class="chart-container">
        <h3>📈 Évolution des Emprunts (12 derniers mois)</h3>
        <div class="bar-chart">
            @foreach($emprunts_par_mois as $mois => $nombre)
                <?php
                $maxValue = max($emprunts_par_mois);
                $height = $maxValue > 0 ? ($nombre / $maxValue) * 160 : 20;
                ?>
                <div class="bar" style="height: {{ $height }}px;">
                    <div class="bar-value">{{ $nombre }}</div>
                    <div class="bar-label">{{ $mois }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Bibliothèque Universitaire - Rapport généré automatiquement</p>
        <p>Période d'analyse : {{ collect($emprunts_par_mois)->keys()->first() }} - {{ collect($emprunts_par_mois)->keys()->last() }}</p>
    </div>
</body>
</html>
