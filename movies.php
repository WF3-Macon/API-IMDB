<?php

/**
 * Récupération de tous les films
 * Méthode : GET
 */

// Retour d'en-tête
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Récupération de la méthode
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Si la méthode est différente de "GET", 
 * on retourne une erreur 405
 */
if ($method !== 'GET') {
    // Récupère ou définit le code de réponse HTTP
    http_response_code(405);

    echo json_encode([
        'status' => 405,
        'message' => 'Method Not Allowed'
    ]);

    exit;
}

// Connexion à la BDD
require_once 'connexion.php';

$limit = null;
if (isset($_GET['limit']) && !empty($_GET['limit'])) {
    $value = htmlspecialchars(strip_tags($_GET['limit']));
    $limit = "LIMIT {$value}";
}

$order = null;
if (isset($_GET['order']) && !empty($_GET['order'])) {
    $value = htmlspecialchars(strip_tags($_GET['order']));
    $order = "ORDER BY title {$value}";
}

// Sélection de tous les films en BDD
$query = $db->query("SELECT * FROM movies $order $limit");
$movies = $query->fetchAll();

// 200 - OK
http_response_code(200);

// Retourne les données au format JSON
echo json_encode($movies);
