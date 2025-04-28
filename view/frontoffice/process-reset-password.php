<?php
require_once '../../config.php';
require_once '../../Model/user.php';

if (!isset($_POST["token"], $_POST["password"], $_POST["password_confirmation"])) {
    die("Missing required fields.");
}

$token = $_POST["token"];
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

// Hash du token pour la recherche dans la base de données
$token_hash = hash("sha256", $token);

try {
    // Connexion à la base de données
    $db = config::getConnexion();

    // Requête pour récupérer l'utilisateur associé au token
    $sql = "SELECT * FROM users WHERE reset_token_hash = :reset_token_hash";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':reset_token_hash', $token_hash, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le token est valide
    if (!$user) {
        die("Token not found.");
    }

    // Vérifier si le token a expiré
    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Token has expired.");
    }

    // Vérifications sur le mot de passe
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters.");
    }

    if (!preg_match("/[a-z]/i", $password)) {
        die("Password must contain at least one letter.");
    }

    if (!preg_match("/[0-9]/", $password)) {
        die("Password must contain at least one number.");
    }

    if ($password !== $password_confirmation) {
        die("Passwords must match.");
    }

    // Hacher le nouveau mot de passe
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Mettre à jour le mot de passe et réinitialiser les colonnes liées au token
    $sql = "UPDATE users
            SET password = :password_hash,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);
    $stmt->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $stmt->execute();

    session_start();
    $_SESSION['success_message'] = "Password updated successfully. You can now login.";

    // Redirection vers index.html après succès
    header("Location: index.html");
    exit; // Important pour arrêter le script ici

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
