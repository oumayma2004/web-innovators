<?php
require_once '../../config.php';
require_once '../../Model/user.php';

// Vérifiez si le token est fourni dans les paramètres GET
$token = $_GET["token"] ?? null;
if (!$token) {
    die("Token is required.");
}

// Hash du token pour la recherche sécurisée dans la base de données
$token_hash = hash("sha256", $token);

try {
    // Connexion à la base de données
    $db = config::getConnexion();

    // Requête pour trouver l'utilisateur avec le token correspondant
    $sql = "SELECT * FROM users
            WHERE reset_token_hash = :reset_token_hash";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':reset_token_hash', $token_hash, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifiez si aucun utilisateur n'a été trouvé
    if ($user === false) {
        die("Token not found.");
    }

    // Vérifiez si le token a expiré
    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Token has expired.");
    }

    // Si le token est valide, continuer avec le processus de réinitialisation
    echo "Token is valid. Proceed with password reset.";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>Reset Password</h1>

    <form method="post" action="process-reset-password.php">

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New password</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation"
               name="password_confirmation">

        <button>Send</button>
    </form>

</body>
</html>