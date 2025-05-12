<?php
session_start();
require_once '../../config.php';
require_once '../../controller/reservationc.php'; 
require_once '../../controller/packc.php'; 
require_once '../../controller/userc.php';
require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$user_id = $_POST['user_id'];
$pack_id = $_POST['pack_id'];
$reservation_date = $_POST['reservation_date'];

$reservationC = new ReservationC();
$reservation = new Reservation(null, $user_id, $pack_id, $reservation_date);

if ($reservationC->addReservation($reservation)) {
    $userc = new userc();
    $user = $userc->getUserById($user_id);
    $userEmail = $user['email'];

    $packc = new packc();
    $pack = $packc->getPackById($pack_id);
    $packName = $pack['titre'];
    $packDate = $pack['date_d'];
    $packPrice = $pack['prix'];

    // Générer QR code depuis une API et le sauvegarder temporairement
    $qrContent = "Pack: $packName | Date: $packDate | Prix: TND $packPrice | Réservation: $reservation_date";
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrContent);
    $qrImage = file_get_contents($qrUrl);
    $qrPath = sys_get_temp_dir() . '/qr_' . uniqid() . '.png';
    file_put_contents($qrPath, $qrImage);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "Nayssenreclamation@gmail.com";
        $mail->Password = "rlrj sked pxol nhma";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("noreply@example.com", "Tfarhida");
        $mail->addAddress($userEmail);
        $mail->Subject = 'Confirmation de votre réservation';

        // Ajouter QR en tant qu’image intégrée
        $mail->AddEmbeddedImage($qrPath, 'qr_code_image');

        // HTML avec image intégrée
        $mailContent = "
        <h2>Confirmation de votre réservation</h2>
        <p>Bonjour {$user['nom']},</p>
        <p>Merci pour votre réservation pour le pack <strong>{$packName}</strong>.</p>
        <p><strong>Date du pack:</strong> {$packDate}</p>
        <p><strong>Date de réservation:</strong> {$reservation_date}</p>
        <p><strong>Prix:</strong> TND {$packPrice}</p>
        <p>Voici votre QR code de confirmation :</p>
        <img src='cid:qr_code_image' alt='QR Code de votre réservation' style='width:150px;height:150px;'>
        <p>Cordialement,<br><strong>L'équipe Tfarhida</strong></p>
        ";

        $mail->isHTML(true);
        $mail->Body = $mailContent;

        $mail->send();

        // Supprimer le fichier temporaire
        unlink($qrPath);

        echo json_encode(['status' => 'success', 'message' => 'Réservation ajoutée et email envoyé']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $mail->ErrorInfo]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de la réservation.']);
}
?>
