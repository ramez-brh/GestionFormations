<?php
$nom = "AYARI";
$prenom = "Asma";
$email = "asma.ayari@email.com";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil utilisateur</title>
</head>
<body>
    <h1>Profil utilisateur</h1>
    <p><strong>Nom :</strong> <?= $nom ?></p>
    <p><strong>Prénom :</strong> <?= $prenom ?></p>
    <p><strong>Email :</strong> <?= $email ?></p>
    <p><strong>Date :</strong> <?= date("H:i:s") ?></p>
</body>
</html>