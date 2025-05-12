<?php
session_start();
require_once '../../config.php';
require_once '../../controller/reservationc.php';
require_once '../../controller/packc.php';

if (!isset($_SESSION['user'])) {
    echo "<p style='color:black;'>Utilisateur non connecté.</p>";
    exit();
}

$userId = $_SESSION['user']['id'];

$reservationC = new ReservationC();
$packC = new PackC();

$reservations = $reservationC->getReservationsByUserId($userId);

if (empty($reservations)) {
    echo "<p style='color:black;'>Vous n'avez pas encore de réservations.</p>";
} else {
    echo "<ul style='list-style-type:none;padding:0;color:black;'>";

    foreach ($reservations as $reservation) {
        // Récupération du pack lié
        $pack = $packC->getPackById($reservation['pack_id']);
        if (!$pack) continue;

        $titre = htmlspecialchars($pack['titre']);
        $datePack = htmlspecialchars($pack['date_d']);
        $prix = htmlspecialchars($pack['prix']);
        $dateReservation = htmlspecialchars($reservation['date_reservation']);
        $packId = $pack['id'];

        // Contenu du QR code
        $qrContent = "Pack ID: $packId | Titre: $titre | Date: $datePack | Réservé le: $dateReservation";
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($qrContent);

        echo "<li style='margin-bottom:20px; border:1px solid #ccc; padding:10px; border-radius:8px;'>";
        echo "<strong>$titre</strong><br>";
        echo "Date du pack : $datePack<br>";
        echo "Réservé le : $dateReservation<br>";
        echo "Prix : TND $prix<br><br>";
        echo "<img src='$qrUrl' alt='QR Code' style='width:120px;height:120px;'>";
        echo "</li>";
    }

    echo "</ul>";
}
?>
