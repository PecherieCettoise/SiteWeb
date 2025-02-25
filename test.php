<?php

// Paramètres de connexion à la base de données
$host = '172.17.0.2';
$dbname = 'PecherieCettoise'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur
$password = 'Corentin2004'; // Ton mot de passe

try {
    // Essaye de se connecter à la base de données
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $password);


    // Si la connexion est réussie, affiche ce message
    echo "Connexion à la base de données réussie !";
} catch (PDOException $e) {
    // Si la connexion échoue, affiche l'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

?>
