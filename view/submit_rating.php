<?php
require_once '../config.php';
$db = config::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $rating = intval($_POST['rating']);

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Note invalide']);
        exit;
    }

    try {
        $stmt = $db->prepare("INSERT INTO ratings (event_id, rating) VALUES (?, ?)");
        $stmt->execute([$event_id, $rating]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement']);
    }
}
