<?php
/**
 * fonctions.php
 * Fonctions utilitaires d'affichage partagées entre les pages.
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

/**
 * Génère un bloc HTML d'affichage d'erreurs.
 *
 * @param string $message  Contenu HTML des erreurs
 * @return string          Bloc <div> stylisé
 */
function afficherErreur(string $message): string
{
    return '<div class="message erreur">
                <strong>&#9888; Erreur(s) détectée(s) :</strong><br>'
                . $message .
            '</div>';
}

/**
 * Génère un bloc HTML de message de succès.
 *
 * @param string $message  Texte du succès
 * @return string          Bloc <div> stylisé
 */
function afficherSucces(string $message): string
{
    return '<div class="message succes">
                <strong>&#10004; ' . htmlspecialchars($message) . '</strong>
            </div>';
}

/**
 * Retourne le badge HTML coloré selon le niveau de la formation.
 *
 * @param string $niveau
 * @return string  Span HTML avec classe CSS correspondante
 */
function badgeNiveau(string $niveau): string
{
    $classes = [
        'Débutant'      => 'badge badge-debutant',
        'Intermédiaire' => 'badge badge-intermediaire',
        'Avancé'        => 'badge badge-avance',
    ];

    $classe = $classes[$niveau] ?? 'badge badge-default';

    return '<span class="' . $classe . '">' . htmlspecialchars($niveau) . '</span>';
}

/**
 * Formate un prix en dinars tunisiens.
 *
 * @param float $prix
 * @return string  Ex : "249,00 DT"
 */
function formatPrix(float $prix): string
{
    return number_format($prix, 2, ',', ' ') . ' DT';
}
