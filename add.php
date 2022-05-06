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

// Nettoie les données
foreach ($datas as $key => $value) {
    $datas[$key] = htmlspecialchars(strip_tags($value)); 
}

/**
 * Si tous les champs sont bien remplis, on insère en BDD
 */
if (
    !empty($datas['title']) 
    && !empty($datas['description'])
    && !empty($datas['date'])
    && !empty($datas['time'])
    && !empty($datas['director'])
    && !empty($datas['image'])
    && !empty($datas['trailer'])
) {
    echo json_encode($datas);
}
// Sinon on retourne une erreur...
else {
    http_response_code(400);

    echo json_encode([
        'status' => 400,
        'message' => 'Bad Request'
    ]);

    exit;
}