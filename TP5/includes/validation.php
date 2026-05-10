<?php
/**
 * validation.php
 * Fonctions de validation des données du formulaire d'inscription.
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

/**
 * Valide les champs nom, prénom et email du formulaire.
 * Retourne une chaîne HTML contenant les erreurs, ou une chaîne vide si tout est valide.
 *
 * @param string $nom
 * @param string $prenom
 * @param string $email
 * @return string  Erreurs HTML ou chaîne vide
 */
function validerFormulaire(string $nom, string $prenom, string $email): string
{
    $erreurs = '';

    // Validation du nom
    if (empty($nom)) {
        $erreurs .= 'Le nom est obligatoire.<br>';
    } elseif (strlen($nom) < 2) {
        $erreurs .= 'Le nom doit contenir au moins 2 caractères.<br>';
    } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $nom)) {
        $erreurs .= 'Le nom ne doit contenir que des lettres.<br>';
    }

    // Validation du prénom
    if (empty($prenom)) {
        $erreurs .= 'Le prénom est obligatoire.<br>';
    } elseif (strlen($prenom) < 2) {
        $erreurs .= 'Le prénom doit contenir au moins 2 caractères.<br>';
    } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $prenom)) {
        $erreurs .= 'Le prénom ne doit contenir que des lettres.<br>';
    }

    // Validation de l'email
    if (empty($email)) {
        $erreurs .= "L'adresse email est obligatoire.<br>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs .= "L'adresse email n'est pas valide.<br>";
    }

    return $erreurs;
}
