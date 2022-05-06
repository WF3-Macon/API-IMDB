<?php

/**
 * Mise à jour d'un film
 * Méthode : PUT
 */

// Retour d'en-tête
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Récupération de la méthode
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Si la méthode est différente de "PUT", 
 * on retourne une erreur
 */
if ($method !== 'PUT') {
    // Récupère ou définit le code de réponse HTTP
    http_response_code(405);

    echo json_encode([
        'status' => 405,
        'message' => 'Method Not Allowed'
    ]);

    exit;
}

/**
 * Si le paramètre "id" n'existe pas dans l'URL,
 * on retourne une erreur 400
 */
if (empty($_GET['id'])) {
    http_response_code(400);

    echo json_encode([
        'status' => 400,
        'message' => 'Bad Request'
    ]);

    exit;
}

// Récupération de la valeur du paramètre "id"
$id = htmlspecialchars(strip_tags($_GET['id']));