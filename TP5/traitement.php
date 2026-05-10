<?php
/**
 * traitement.php
 * Traite le formulaire d'inscription POST.
 * Valide les données, insère l'inscription en BD, redirige vers paiement.php.
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

require 'includes/connexion.php';
require 'includes/validation.php';
require 'includes/fonctions.php';

// Sécurité : ce fichier n'accepte que les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formations.php');
    exit();
}

// ── 1. Récupération et nettoyage des données du formulaire ─────────────────
$nom          = trim($_POST['nom']           ?? '');
$prenom       = trim($_POST['prenom']        ?? '');
$email        = trim($_POST['email']         ?? '');
$formation_id = (int)($_POST['formation_id'] ?? 0);

// ── 2. Validation ──────────────────────────────────────────────────────────
$erreur = validerFormulaire($nom, $prenom, $email);

if ($formation_id <= 0) {
    $erreur .= 'Veuillez choisir une formation valide.<br>';
}

// ── 3a. Erreurs de validation → réafficher le formulaire ──────────────────
if (!empty($erreur)) {

    $pdo  = getConnexion();
    $stmt = $pdo->prepare('SELECT * FROM formations WHERE id = ?');
    $stmt->execute([$formation_id]);
    $formation = $stmt->fetch();

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erreur d'inscription – GestionFormations</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

    <header class="site-header">
        <h1>&#127891; GestionFormations</h1>
        <p>ISET'COM – Licence GTIC – TP5</p>
    </header>

    <main class="container">

        <a href="formations.php" class="lien-retour">&larr; Retour aux formations</a>

        <?= afficherErreur($erreur) ?>

        <?php if ($formation): ?>
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
        <?php endif; ?>

        <div class="formulaire-container">
            <h3>Vos informations</h3>

            <form action="traitement.php" method="POST" novalidate>
                <input type="hidden" name="formation_id" value="<?= (int)$formation_id ?>">

                <div class="champ">
                    <label for="nom">Nom <span class="obligatoire">*</span></label>
                    <input type="text"
                           id="nom"
                           name="nom"
                           value="<?= htmlspecialchars($nom) ?>"
                           placeholder="Votre nom de famille">
                </div>

                <div class="champ">
                    <label for="prenom">Prénom <span class="obligatoire">*</span></label>
                    <input type="text"
                           id="prenom"
                           name="prenom"
                           value="<?= htmlspecialchars($prenom) ?>"
                           placeholder="Votre prénom">
                </div>

                <div class="champ">
                    <label for="email">Adresse email <span class="obligatoire">*</span></label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="<?= htmlspecialchars($email) ?>"
                           placeholder="exemple@email.com">
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
    <?php
    exit();
}

// ── 3b. Données valides → Insertion en base de données ────────────────────
$pdo = getConnexion();

// Requête préparée : les ? évitent toute injection SQL
// Les valeurs réelles sont transmises séparément dans execute()
$stmt = $pdo->prepare(
    'INSERT INTO inscriptions
        (nom, prenom, email, formation_id, statut_paiement, date_inscription)
     VALUES
        (?, ?, ?, ?, "en_attente", NOW())'
);

$stmt->execute([$nom, $prenom, $email, $formation_id]);

// Récupérer l'identifiant auto-généré de la ligne insérée
$id = $pdo->lastInsertId();

// ── 4. Redirection vers la page de confirmation paiement ──────────────────
header('Location: paiement.php?id=' . (int)$id);
exit();
