<?php

/**
 * Ajoute un film
 * Méthode : POST
 */

// Retour d'en-tête
header('Access-Control-Allow-Origin: *');
header('Access-Control-Request-Method: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type');

// Récupération de la méthode
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Si la méthode est différente de "POST", 
 * on retourne une erreur
 */
if ($method !== 'POST' && $method !== 'OPTIONS') {
    // Récupère ou définit le code de réponse HTTP
    http_response_code(405);

    echo json_encode([
        'status' => 405,
        'message' => 'Method Not Allowed'
    ]);

    exit;
}

// Récupère les données envoyées en POST et les converties en un tableau associatif
$datas = json_decode(file_get_contents('php://input'), true);

// Nettoie les données
foreach ($datas as $key => $value) {
    $datas[$key] = htmlspecialchars(strip_tags($value)); 
}

// Connexion à la BDD
require_once 'connexion.php'; 

// Insertion en BDD
$query = $db->prepare('INSERT INTO movies (title, description, date, time, director, image, trailer) VALUES (:title, :description, :date, :time, :director, :image, :trailer)');
$query->bindValue(':title', $datas['title']);
$query->bindValue(':description', $datas['description']);
$query->bindValue(':date', date('Y-m-d', strtotime($datas['date'])));
$query->bindValue(':time', $datas['time'], PDO::PARAM_INT);
$query->bindValue(':director', $datas['director']);
$query->bindValue(':image', $datas['image']);
$query->bindValue(':trailer', $datas['trailer']);
$query->execute();

// Récupération de l'ID nouvellement inséré
// https://www.php.net/manual/fr/pdo.lastinsertid.php
$id = $db->lastInsertId();

// 201 - Created
http_response_code(201);

// Retour de la ressource
echo json_encode([
    'id' => $id,
    ...$datas
]);
