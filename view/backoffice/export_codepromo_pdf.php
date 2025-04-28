<?php
require_once('src/tcpdf/tcpdf.php');
require_once '../../config.php';
require_once '../../Controller/codePromoC.php'; // Ton controller pour code promo

if (isset($_POST['export_codepromo_pdf'])) {
    ob_start();

    $codePromoC = new codePromoC();  // Instantiate le controller
    $codes = $codePromoC->getAllCodes(); // Appelle la bonne fonction (pas afficher, pas d'erreur)

    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Company Name');
    $pdf->SetTitle('Liste des Codes Promo');
    $pdf->SetSubject('Export PDF');
    $pdf->SetKeywords('Code Promo, PDF, Export');

    $pdf->AddPage();
    $pdf->SetFont('dejavusans', '', 10);

    $html = "<h2 style='text-align:center;'>Liste des Codes Promo</h2>";

    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th><b>ID</b></th>
                        <th><b>Code</b></th>
                        <th><b>Réduction</b></th>
                        <th><b>Date Début</b></th>
                        <th><b>Date Fin</b></th>
                        <th><b>ID Pack</b></th>
                        <th><b>Actif</b></th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($codes as $codePromo) {
        $html .= '<tr>
                    <td>'.htmlspecialchars($codePromo['id_code']).'</td>
                    <td>'.htmlspecialchars($codePromo['code']).'</td>
                    <td>'.htmlspecialchars($codePromo['reduction']).'</td>
                    <td>'.htmlspecialchars($codePromo['date_debut']).'</td>
                    <td>'.htmlspecialchars($codePromo['date_fin']).'</td>
                    <td>'.htmlspecialchars($codePromo['id_pack']).'</td>
                    <td>'.htmlspecialchars($codePromo['actif']).'</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('codes_promo.pdf', 'D');

    ob_end_flush();
}
?>
