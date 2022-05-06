<?php

/**
 * Ajoute un film
 * Méthode : POST
 */

// Retour d'en-tête
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Récupération de la méthode
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Si la méthode est différente de "POST", 
 * on retourne une erreur
 */
if ($method !== 'POST') {
    // Récupère ou définit le code de réponse HTTP
    http_response_code(405);

    echo json_encode([
        'status' => 405,
        'message' => 'Method Not Allowed'
    ]);

    exit;
}

// Récupère les données envoyées en POST
$datas = json_decode(file_get_contents('php://input'), true);

echo json_encode($datas['image']);