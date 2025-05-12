
<?php
include '../../controller/ReservationC.php'; 
$ReservationC = new ReservationC(); 
$ReservationC->deleteReservation($_GET["id"]); 
header('Location:reservation.php');
?>