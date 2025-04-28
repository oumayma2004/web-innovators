<?php
session_start();
require_once '../../config.php';
require_once '../../controller/reservationc.php'; 
require_once '../../controller/packc.php'; 
require_once '../../controller/userc.php';  // Ajout du contrôleur User
require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Récupérer les données envoyées par AJAX
$user_id = $_POST['user_id'];
$pack_id = $_POST['pack_id'];
$reservation_date = $_POST['reservation_date'];

// Créer une instance du contrôleur de réservation
$reservationC = new ReservationC();

// Créer l'objet réservation (vous pouvez étendre le modèle selon vos besoins)
$reservation = new Reservation(null, $user_id, $pack_id, $reservation_date);

// Ajouter la réservation via le contrôleur
if ($reservationC->addReservation($reservation)) {
    // Si la réservation est ajoutée, on continue avec l'envoi de l'email
    // Récupérer l'utilisateur pour envoyer l'email
    $userc = new userc();
    $user = $userc->getUserById($user_id); // Récupérer l'utilisateur par ID
    $userEmail = $user['email']; // Email de l'utilisateur

    // Informations sur le pack
    $packc = new packc();
    $pack = $packc->getPackById($pack_id);
    $packName = $pack['titre']; // Titre du pack

    // Créer une instance de PHPMailer pour envoyer l'email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "Nayssenreclamation@gmail.com";
        $mail->Password = "rlrj sked pxol nhma";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom("noreply@example.com", "Your Application");
        $mail->addAddress($userEmail); // Email de l'utilisateur

        // Sujet
        $mail->Subject = 'Confirmation de votre réservation';

        // Corps de l'email
        $mailContent = "
        <h2>Confirmation de votre réservation</h2>
        <p>Bonjour {$user['nom']},</p>
        <p>Nous avons bien reçu votre réservation pour le pack <strong>{$packName}</strong>.</p>
        <p><strong>Date de réservation:</strong> {$reservation_date}</p>
        <p>Nous vous remercions pour votre confiance et vous souhaitons une excellente expérience !</p>
        <p>Cordialement,</p>
        <p><strong>L'équipe Tfarhida</strong></p>
        ";

        $mail->isHTML(true);
        $mail->Body = $mailContent;

        // Envoi de l'email
        $mail->send();

        // Retourner une réponse en JSON à AJAX
        echo json_encode(['status' => 'success', 'message' => 'Réservation ajoutée et email envoyé']);
    } catch (Exception $e) {
        // Si l'email échoue, afficher l'erreur
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $mail->ErrorInfo]);
    }

} else {
    // Sinon, retour de l'erreur
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de la réservation.']);
}
?>
