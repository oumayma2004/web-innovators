<?php
require_once 'config.php';
$db = config::getConnexion();
$query = $db->query("SELECT * FROM gestion_event");
$events = $query->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($events);
?>
