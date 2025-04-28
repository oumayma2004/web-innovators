<?php
require_once('src/tcpdf/tcpdf.php');
require_once '../../config.php';
require_once '../../Controller/packC.php'; 

if (isset($_POST['export_packs_pdf'])) {
    ob_start();

    $packC = new packC();
    $packs = $packC->getAllPacks(); 
    

    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Company Name');
    $pdf->SetTitle('Liste des Packs');
    $pdf->SetSubject('Export PDF');
    $pdf->SetKeywords('Pack, PDF, Export');

    $pdf->AddPage();
    $pdf->SetFont('dejavusans', '', 10);

    // Titre
    $html = "<h2 style='text-align:center;'>Liste des Packs</h2>";

    // Début du tableau HTML
    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th><b>ID</b></th>
                        <th><b>Titre</b></th>
                        <th><b>Description</b></th>
                        <th><b>Prix</b></th>
                        <th><b>Nombre Places</b></th>
                        <th><b>Date</b></th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($packs as $pack) {
        $html .= '<tr>
                    <td>'.htmlspecialchars($pack['id']).'</td>
                    <td>'.htmlspecialchars($pack['titre']).'</td>
                    <td>'.htmlspecialchars($pack['description']).'</td>
                    <td>'.htmlspecialchars($pack['prix']).'</td>
                    <td>'.htmlspecialchars($pack['nombre_places']).'</td>
                    <td>'.htmlspecialchars($pack['date_d']).'</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Ecrire dans le PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Sortie PDF
    $pdf->Output('packs.pdf', 'D');

    ob_end_flush();
}
?>
