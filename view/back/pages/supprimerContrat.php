<?php
require_once '../../Controller/contratC.php';

$contratC = new ContratC();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $contratC->supprimerContrat($id);
    header("Location: liste_sponsors.php"); // Redirige vers la liste des sponsors
    exit();
}
?>
