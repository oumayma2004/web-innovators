<?php
require_once '../../../Controller/sponsorsC.php';

$sponsorC = new SponsorC();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sponsorC->supprimerSponsor($id);
    header("Location: liste_sponsors.php"); // Redirige vers la liste des sponsors
    exit();
}
?>
