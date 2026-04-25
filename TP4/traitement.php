<?php
require "includes/fonctions.php";
require "includes/validation.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des données (protection XSS)
    $nom    = nettoyer($_POST["nom"]);
    $prenom = nettoyer($_POST["prenom"]);
    $email  = nettoyer($_POST["email"]);

    // Validation
    $erreur = validerFormulaire($nom, $prenom, $email);

    // Affichage du résultat
    if (!empty($erreur)) {
        $message = afficherErreur($erreur);
    } else {
        $message = afficherSucces($nom, $prenom, $email);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 - Résultat du formulaire</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
            line-height: 1.8;
        }
        .message.erreur {
            background-color: #fdecea;
            color: #c0392b;
            border-left: 5px solid #e74c3c;
        }
        .message.succes {
            background-color: #eafaf1;
            color: #1e8449;
            border-left: 5px solid #27ae60;
        }
        .btn-retour {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn-retour:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Résultat du traitement</h2>

        <?php if (!empty($message)): ?>
            <?= $message ?>
        <?php else: ?>
            <p>Aucune donnée reçue. Veuillez soumettre le formulaire.</p>
        <?php endif; ?>

        <a href="formulaire.php" class="btn-retour">← Retour au formulaire</a>
    </div>
</body>
</html>
