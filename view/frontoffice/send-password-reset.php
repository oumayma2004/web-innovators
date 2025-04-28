<?php
require_once '../../config.php';
require_once '../../Model/user.php';

$email = $_POST["email"] ?? null;

// Vérifiez si l'email est fourni
if (!$email) {
    echo "Email is required.";
    exit;
}

// Génération du token sécurisé
try {
    $token = bin2hex(random_bytes(16)); // Token unique de 32 caractères
} catch (Exception $e) {
    echo "An error occurred while generating the token.";
    exit;
}

// Hash du token pour sécuriser son stockage
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // Expiration dans 30 minutes

try {
    // Connexion à la base de données
    $db = config::getConnexion();

    // Mise à jour du token dans la base de données
    $sql = "UPDATE users
            SET reset_token_hash = :token_hash,
                reset_token_expires_at = :expiry
            WHERE email = :email";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':token_hash', $token_hash, PDO::PARAM_STR);
    $stmt->bindParam(':expiry', $expiry, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    $stmt->execute();

    // Vérifier si un utilisateur a été mis à jour
    if ($stmt->rowCount() > 0) {
        // Chargement du mailer
        $mail = require __DIR__ . "/mailer.php";

        // Configuration de l'email
        $mail->setFrom("noreply@example.com", "Your Application");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";

        // Lien de réinitialisation
        $reset_link = "localhost/webproj/view/frontoffice/reset-password.php?token=" . urlencode($token);

        $mail->isHTML(true); // Activer HTML pour l'email
        $mail->Body = <<<END
        <p>Hi,</p>
        <p>You have requested to reset your password. Click the link below to reset it:</p>
        <p><a href="{$reset_link}">Reset Password</a></p>
        <p>If you did not request this, please ignore this email.</p>
        END;

        // Envoi de l'email
        try {
            $mail->send();
            echo "A reset link has been sent to your email address.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No account found with this email address.";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
