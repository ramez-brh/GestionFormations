<?php

/**
 * Affiche un message d'erreur en rouge
 */
function afficherErreur($erreur) {
    if (!empty($erreur)) {
        return "<div class='message erreur'>
                    <span>❌</span> $erreur
                </div>";
    }
}

/**
 * Affiche un message de succès en vert
 */
function afficherSucces($nom, $prenom, $email) {
    return "<div class='message succes'>
                <strong>✔ Formulaire valide</strong><br><br>
                <b>Nom :</b> $nom <br>
                <b>Prénom :</b> $prenom <br>
                <b>Email :</b> $email
            </div>";
}

/**
 * Nettoie une donnée utilisateur (XSS protection)
 */
function nettoyer($data) {
    return htmlspecialchars(trim($data));
}
?>
