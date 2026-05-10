<?php
/**
 * connexion.php
 * Fournit la connexion PDO à la base de données gestion_formations.
 *
 * TP5 - ISET'COM - Licence GTIC
 * Dr. Asma Ayari - 2025/2026
 */

function getConnexion(): PDO
{
    // Paramètres de connexion XAMPP par défaut
    $host   = 'localhost';
    $dbname = 'gestion_formations';
    $user   = 'root';
    $pass   = '';

    try {
        // DSN : Data Source Name — identifie le driver, le serveur, la base et le charset
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $pass,
            [
                // Lance une PDOException en cas d'erreur SQL
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Retourne les lignes sous forme de tableaux associatifs : $row['titre']
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Désactive l'émulation des requêtes préparées → sécurité renforcée
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );

        return $pdo;

    } catch (PDOException $e) {
        // Arrête le script et affiche le message d'erreur PDO
        die('<p style="color:red;font-family:Arial;padding:20px;">
             <strong>Erreur de connexion à la base de données :</strong><br>'
             . htmlspecialchars($e->getMessage()) .
             '</p>');
    }
}
