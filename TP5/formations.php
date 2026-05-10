<?php
/**
 * formations.php
 * Affiche la liste des formations depuis la base de données.
 * Permet le filtrage par niveau via le paramètre GET ?niveau=
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

require 'includes/connexion.php';
require 'includes/fonctions.php';

$pdo = getConnexion();

// Récupérer le filtre niveau depuis l'URL (optionnel)
// Exemple : formations.php?niveau=Débutant
$niveau = trim($_GET['niveau'] ?? '');

if (!empty($niveau)) {
    // Requête préparée avec paramètre variable → protection contre les injections SQL
    $stmt = $pdo->prepare('SELECT * FROM formations WHERE niveau = ? ORDER BY id ASC');
    $stmt->execute([$niveau]);
} else {
    // Aucun filtre → toutes les formations triées par id
    $stmt = $pdo->query('SELECT * FROM formations ORDER BY id ASC');
}

$formations = $stmt->fetchAll();

// Compter le total par niveau pour l'affichage du badge compteur dans les filtres
$stmtComptage = $pdo->query(
    "SELECT niveau, COUNT(*) AS total FROM formations GROUP BY niveau"
);
$comptages = [];
foreach ($stmtComptage->fetchAll() as $row) {
    $comptages[$row['niveau']] = $row['total'];
}
$totalTous = array_sum($comptages);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Formations – GestionFormations</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <h1>&#127891; GestionFormations</h1>
    <p>ISET'COM – Licence GTIC – TP5</p>
</header>

<main class="container">

    <h2>Liste des Formations</h2>

    <!-- Barre de filtrage par niveau -->
    <nav class="filtres">
        <a href="formations.php"
           class="filtre-lien <?= empty($niveau) ? 'actif' : '' ?>">
            Toutes
            <span class="compteur"><?= $totalTous ?></span>
        </a>
        <?php foreach (['Débutant', 'Intermédiaire', 'Avancé'] as $niv): ?>
        <a href="formations.php?niveau=<?= urlencode($niv) ?>"
           class="filtre-lien <?= ($niveau === $niv) ? 'actif' : '' ?>">
            <?= htmlspecialchars($niv) ?>
            <span class="compteur"><?= $comptages[$niv] ?? 0 ?></span>
        </a>
        <?php endforeach; ?>
    </nav>

    <!-- Message si aucune formation trouvée -->
    <?php if (empty($formations)): ?>
        <p class="aucun-resultat">
            Aucune formation disponible pour le niveau
            <strong><?= htmlspecialchars($niveau) ?></strong>.
            <a href="formations.php">Voir toutes les formations</a>
        </p>

    <?php else: ?>

        <!-- Grille des formations -->
        <div class="grille-formations">
            <?php foreach ($formations as $f): ?>
            <div class="card-formation">

                <div class="card-header">
                    <h3><?= htmlspecialchars($f['titre']) ?></h3>
                    <?= badgeNiveau($f['niveau']) ?>
                </div>

                <p class="card-description">
                    <?= htmlspecialchars($f['description']) ?>
                </p>

                <div class="card-meta">
                    <span>&#9201; <?= htmlspecialchars($f['duree']) ?></span>
                    <span class="prix"><?= formatPrix((float)$f['prix']) ?></span>
                </div>

                <a href="inscription.php?formation_id=<?= (int)$f['id'] ?>"
                   class="btn btn-primaire">
                    S'inscrire
                </a>

            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

<footer class="site-footer">
    <p>&copy; 2025/2026 ISET'COM – Dr. Asma Ayari</p>
</footer>

</body>
</html>
