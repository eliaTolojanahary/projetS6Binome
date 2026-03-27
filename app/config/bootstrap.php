<?php
// bootstrap.php

$ds = DIRECTORY_SEPARATOR;

// Charger l'autoloader Composer
require(__DIR__ . $ds . '..' . $ds . '..' . $ds . 'vendor' . $ds . 'autoload.php');

// Vérifier le fichier de config
if (!file_exists(__DIR__ . $ds . 'config.php')) {
    Flight::halt(500, 'Config file not found. Please create a config.php file in the app/config directory.');
}

// Charger la configuration
$config = require(__DIR__ . $ds . 'config.php');

// Mapper le service DB avec PDO
Flight::map('db', function() use ($config) {
    try {
        return new PDO(
            sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                $config['database']['host'],
                $config['database']['port'] ?? 3306,
                $config['database']['dbname'],
                $config['database']['charset'] ?? 'utf8mb4'
            ),
            $config['database']['user'],
            $config['database']['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die("Erreur DB : " . $e->getMessage());
    }
});

// Initialiser l'application Flight
$app = Flight::app();

// Initialiser le router avant de charger routes.php
$router = $app->router();

// Charger les routes
require(__DIR__ . $ds . 'routes.php');

// Charger les services si existants
if (file_exists(__DIR__ . $ds . 'services.php')) {
    require(__DIR__ . $ds . 'services.php');
}

// Démarrer l'application
$app->start();
