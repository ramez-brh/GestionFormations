<?php
/**
 * inscription.php
 * Formulaire d'inscription à une formation.
 * Reçoit formation_id via GET, affiche le formulaire de saisie étudiant.
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

require 'includes/connexion.php';
require 'includes/fonctions.php';

$pdo = getConnexion();

// Récupérer et valider l'identifiant de la formation depuis l'URL
$formation_id = (int)($_GET['formation_id'] ?? 0);

if ($formation_id <= 0) {
    // Identifiant invalide → rediriger vers la liste
    header('Location: formations.php');
    exit();
}

// Récupérer la formation correspondante depuis la BD
$stmt = $pdo->prepare('SELECT * FROM formations WHERE id = ?');
$stmt->execute([$formation_id]);
$formation = $stmt->fetch();

if (!$formation) {
    // Formation introuvable → rediriger vers la liste
    header('Location: formations.php');
    exit();
}

// Repopuler les champs après une erreur de validation (valeurs saisies conservées)
$ancienNom    = htmlspecialchars($_POST['nom']    ?? '');
$ancienPrenom = htmlspecialchars($_POST['prenom'] ?? '');
$ancienEmail  = htmlspecialchars($_POST['email']  ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription – <?= htmlspecialchars($formation['titre']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <h1>&#127891; GestionFormations</h1>
    <p>ISET'COM – Licence GTIC – TP5</p>
</header>

<main class="container">

    <a href="formations.php" class="lien-retour">&larr; Retour aux formations</a>

    <!-- Récapitulatif de la formation choisie -->
    <div class="recap-formation">
        <h2>Inscription à la formation</h2>
        <div class="recap-detail">
            <h3><?= htmlspecialchars($formation['titre']) ?></h3>
            <p><?= htmlspecialchars($formation['description']) ?></p>
            <div class="recap-meta">
                <span>&#9201; <?= htmlspecialchars($formation['duree']) ?></span>
                <?= badgeNiveau($formation['niveau']) ?>
                <span class="prix"><?= formatPrix((float)$formation['prix']) ?></span>
            </div>
        </div>
    </div>

    <!-- Formulaire d'inscription -->
    <div class="formulaire-container">
        <h3>Vos informations</h3>

        <form action="traitement.php" method="POST" novalidate>

            <!-- Champ caché : transmet l'identifiant de la formation au traitement -->
            <input type="hidden" name="formation_id" value="<?= (int)$formation['id'] ?>">

            <div class="champ">
                <label for="nom">Nom <span class="obligatoire">*</span></label>
                <input type="text"
                       id="nom"
                       name="nom"
                       value="<?= $ancienNom ?>"
                       placeholder="Votre nom de famille"
                       autocomplete="family-name">
            </div>

            <div class="champ">
                <label for="prenom">Prénom <span class="obligatoire">*</span></label>
                <input type="text"
                       id="prenom"
                       name="prenom"
                       value="<?= $ancienPrenom ?>"
                       placeholder="Votre prénom"
                       autocomplete="given-name">
            </div>

            <div class="champ">
                <label for="email">Adresse email <span class="obligatoire">*</span></label>
                <input type="email"
                       id="email"
                       name="email"
                       value="<?= $ancienEmail ?>"
                       placeholder="exemple@email.com"
                       autocomplete="email">
            </div>

            <p class="mention-obligatoire">
                <span class="obligatoire">*</span> Champs obligatoires
            </p>

            <button type="submit" class="btn btn-primaire btn-large">
                Confirmer l'inscription
            </button>

        </form>
    </div>

</main>

<footer class="site-footer">
    <p>&copy; 2025/2026 ISET'COM – Dr. Asma Ayari</p>
</footer>

</body>
</html>
