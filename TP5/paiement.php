<?php
/**
 * paiement.php
 * Page de confirmation affichée après une inscription réussie.
 * Récupère l'inscription par ID et affiche le récapitulatif.
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

require 'includes/connexion.php';
require 'includes/fonctions.php';

$pdo = getConnexion();

// Récupérer l'identifiant de l'inscription depuis l'URL
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: formations.php');
    exit();
}

// Jointure : récupérer l'inscription ET les détails de la formation associée
$stmt = $pdo->prepare(
    'SELECT i.*, f.titre, f.description, f.prix, f.duree, f.niveau
     FROM inscriptions i
     INNER JOIN formations f ON i.formation_id = f.id
     WHERE i.id = ?'
);
$stmt->execute([$id]);
$inscription = $stmt->fetch();

if (!$inscription) {
    header('Location: formations.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'inscription – GestionFormations</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <h1>&#127891; GestionFormations</h1>
    <p>ISET'COM – Licence GTIC – TP5</p>
</header>

<main class="container">

    <!-- Bandeau de succès -->
    <div class="confirmation-succes">
        <div class="icone-succes">&#10004;</div>
        <h2>Inscription confirmée !</h2>
        <p>Votre inscription a bien été enregistrée. Référence :
           <strong>#<?= (int)$inscription['id'] ?></strong></p>
    </div>

    <!-- Récapitulatif de l'inscription -->
    <div class="recap-paiement">

        <h3>Récapitulatif de votre inscription</h3>

        <table class="table-recap">
            <tbody>
                <tr>
                    <th>Nom complet</th>
                    <td><?= htmlspecialchars($inscription['prenom']) ?>
                        <?= htmlspecialchars($inscription['nom']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($inscription['email']) ?></td>
                </tr>
                <tr>
                    <th>Formation</th>
                    <td><?= htmlspecialchars($inscription['titre']) ?></td>
                </tr>
                <tr>
                    <th>Niveau</th>
                    <td><?= badgeNiveau($inscription['niveau']) ?></td>
                </tr>
                <tr>
                    <th>Durée</th>
                    <td><?= htmlspecialchars($inscription['duree']) ?></td>
                </tr>
                <tr>
                    <th>Prix</th>
                    <td class="prix"><?= formatPrix((float)$inscription['prix']) ?></td>
                </tr>
                <tr>
                    <th>Statut paiement</th>
                    <td>
                        <span class="badge badge-attente">
                            <?= htmlspecialchars($inscription['statut_paiement']) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Date d'inscription</th>
                    <td><?= htmlspecialchars($inscription['date_inscription']) ?></td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- Actions -->
    <div class="actions-paiement">
        <a href="formations.php" class="btn btn-secondaire">
            &larr; Retour aux formations
        </a>
        <a href="inscription.php?formation_id=<?= (int)$inscription['formation_id'] ?>"
           class="btn btn-primaire">
            Inscrire une autre personne
        </a>
    </div>

</main>

<footer class="site-footer">
    <p>&copy; 2025/2026 ISET'COM – Dr. Asma Ayari</p>
</footer>

</body>
</html>
