<?php
session_start();
require_once '../../config.php';
require_once '../../controller/reservationc.php';
require_once '../../controller/packc.php';

if (!isset($_SESSION['user'])) {
    echo "Utilisateur non connecté.";
    exit();
}

$userId = $_SESSION['user']['id'];

$reservationC = new ReservationC();
$packC = new PackC();

$reservations = $reservationC->getReservationsByUserId($userId);

if (empty($reservations)) {
    echo "<p style='color:black;'>Vous n'avez pas encore de réservations.</p>";
} else {
    echo "<ul style='list-style-type:none;padding:0;color:black;'>"; // couleur noire ici
    foreach ($reservations as $reservation) {
        echo "<li style='margin-bottom:10px;'>";
        echo "Pack ID : " . htmlspecialchars($reservation['pack_id']) . "<br>";
        echo "Date : " . htmlspecialchars($reservation['date_reservation']);
        echo "</li>";
    }
    echo "</ul>";
}
?>
