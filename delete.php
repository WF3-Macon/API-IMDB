<?php

/**
 * Supprime un film
 * Méthode : DELETE
 */

// Retour d'en-tête
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Récupération de la méthode
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Si la méthode est différente de "DELETE", 
 * on retourne une erreur
 */
if ($method !== 'DELETE') {
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

// Connexion à la BDD
require_once 'connexion.php';

// Suppression d'un film
$query = $db->prepare('DELETE FROM movies WHERE id = :id');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

if ($query->rowcount() === 0) {
    http_response_code(404);

    echo json_encode([
        'status' => 404,
        'message' => 'Not Found'
    ]);

    exit;
}

http_response_code(204);
