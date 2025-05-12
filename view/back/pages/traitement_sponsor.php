<?php
require_once '../../../Controller/sponsorsC.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_sponsor'], $_POST['action'])) {
        $id = intval($_POST['id_sponsor']);
        $action = $_POST['action'];

        $sponsorC = new SponsorC();
        if ($action === 'accepter') {
            $sponsorC->changerStatut($id, 'oui');
        } elseif ($action === 'rejeter') {
            $sponsorC->changerStatut($id, 'non');
        }
    }
}

header("Location: liste_sponsors.php");
exit();
?>
