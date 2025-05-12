<?php
require_once './config.php';
require_once './Controller/eventController.php';

$db=config::getConnexion();
$controller = new EventController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form submission
    $event_id = $_POST['id_event'];
    $event_name = $_POST['nom_e'];
    $description = $_POST['desc_e'];
    $date = $_POST['date_e'];

    // Update query
    $stmt = $pdo->prepare("UPDATE events SET nom_e = ?, desc_e = ?,  date_e = ? WHERE id_event = ?");
    $stmt->execute([$nom_e, $desc_e, $date_e, $id_event]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
