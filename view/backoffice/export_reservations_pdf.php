<?php
require_once('src/tcpdf/tcpdf.php');
require_once '../../config.php';
require_once '../../Controller/reservationC.php'; 

if (isset($_POST['export_reservations_pdf'])) {
    ob_start();

    // Instancier ReservationC
    $reservationC = new ReservationC();

    // Récupérer toutes les réservations
    $reservations = $reservationC->getAllReservations();

    // Récupérer les statistiques des packs
    $stats = $reservationC->getReservationStats();

    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Company Name');
    $pdf->SetTitle('Liste des Réservations');
    $pdf->SetSubject('Export PDF');
    $pdf->SetKeywords('Reservation, PDF, Export');

    $pdf->AddPage();
    $pdf->SetFont('dejavusans', '', 10);

    // Titre
    $html = "<h2 style='text-align:center;'>Liste des Réservations</h2>";

    // Début tableau HTML
    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><b>ID</b></th>
                        <th><b>Nom Utilisateur</b></th>
                        <th><b>Nom du Pack</b></th>
                        <th><b>Date de Réservation</b></th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($reservations as $reservation) {
        $user = $reservationC->getUserById($reservation['user_id']);
        $pack = $reservationC->getPackById($reservation['pack_id']);
        
        $html .= '<tr>
                    <td>'.htmlspecialchars($reservation['id']).'</td>
                    <td>'.htmlspecialchars($user['nom']).'</td>
                    <td>'.htmlspecialchars($pack['titre']).'</td>
                    <td>'.htmlspecialchars($reservation['date_reservation']).'</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Espace avant stats
    $html .= "<br><h3 style='text-align:center;'>Statistiques de Réservations (%)</h3>";

    // Calcul total pour pourcentage
    $totalReservations = array_sum(array_column($stats, 'total_reservations'));

    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><b>Nom du Pack</b></th>
                        <th><b>Nombre de Réservations</b></th>
                        <th><b>Pourcentage (%)</b></th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($stats as $stat) {
        $percentage = ($totalReservations > 0) ? round(($stat['total_reservations'] / $totalReservations) * 100, 2) : 0;
        $html .= '<tr>
                    <td>'.htmlspecialchars($stat['pack_name']).'</td>
                    <td>'.htmlspecialchars($stat['total_reservations']).'</td>
                    <td>'.$percentage.'%</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Ecrire dans PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Sortie PDF
    $pdf->Output('reservations.pdf', 'D');

    ob_end_flush();
}
?>
