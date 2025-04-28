<?php
session_start();

// Si l'utilisateur n'est pas connecté ou si le code de vérification n'est pas dans la session
if (!isset($_SESSION['verification_code']) || !isset($_SESSION['user'])) {
    header("Location: login.php"); // Rediriger si l'utilisateur n'a pas essayé de se connecter
    exit();
}

// Vérifiez si le code est expiré
if (isset($_SESSION['twofa_expires_at']) && time() > strtotime($_SESSION['twofa_expires_at'])) {
    echo "<p style='color: red;'>Le code de vérification a expiré. Veuillez en demander un nouveau.</p>";
    exit();
}

// Logique de traitement du formulaire lorsqu'il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['verification_code'];

    // Vérifie si le code correspond
    if ($entered_code == $_SESSION['verification_code']) {
        // Le code est correct, l'utilisateur est authentifié
        unset($_SESSION['verification_code']);  // Supprimer le code après la vérification

        // On suppose que l'utilisateur a déjà été stocké dans la session lors de l'étape de connexion
        $user = $_SESSION['user'];

        // Debug: afficher le rôle pour voir si cela fonctionne
        // Cette ligne est temporaire, juste pour déboguer. À retirer dans la version finale.
        // echo "<pre>";
        // var_dump($user);
        // echo "</pre>";

        // Redirige vers la bonne page en fonction du rôle
        if ($user['role'] === 'admin') {
            header("Location: ../backoffice/user.php"); // Page admin
            exit();
        } else {
            header("Location: pack.php"); // Page utilisateur
            exit();
        }
    } else {
        $error_message = "Code de vérification incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification 2FA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Vérification de votre compte</h2>
    <p>Un code de vérification a été envoyé à votre adresse e-mail. Veuillez entrer le code ci-dessous pour compléter votre connexion.</p>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="verification_code">Entrez le code 2FA :</label>
        <input type="text" id="verification_code" name="verification_code" required>
        <button type="submit">Vérifier</button>
    </form>
</div>

</body>
</html>
