<?php
require '../../config.php';
require_once '../../controller/userc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["mot_de_passe"])) {
        session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        echo "Connexion réussie !";
        // header("Location: dashboard.php"); // exemple de redirection
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}

// ...


// Vérifiez si l'email et le mot de passe sont fournis
if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Email and password are required."]);
    exit;
}

// Vérifier si l'email est valide
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    exit;
}

try {
    // Connexion à la base de données
    $db = config::getConnexion();
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Vérifier si un utilisateur existe avec cet email
    if ($stmt->rowCount() > 0) {
        // Récupérer l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le mot de passe est correct
        if (!password_verify($password, $user['password'])) {
            echo json_encode(["status" => "error", "message" => "Incorrect password."]);
            exit;
        }

        // Stocker l'utilisateur dans la session
        $_SESSION['user'] = $user;

        // Vérifier si la 2FA est activée pour l'utilisateur
        if ($user['is_enabled_2fa'] == 1) {
            // Générer un code 2FA aléatoire
            $verification_code = rand(100000, 999999);
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['user_id'] = $user['id'];  // Stocker l'ID de l'utilisateur dans la session

            // Mettre à jour la base de données avec le code 2FA et son expiration
            $twofa_expires_at = date("Y-m-d H:i:s", time() + 300); // Code valable pendant 5 minutes
            $sql = "UPDATE users SET twofa_code = :code, twofa_expires_at = :expires_at WHERE id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':code', $verification_code);
            $stmt->bindParam(':expires_at', $twofa_expires_at);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();

            // Charger le mailer pour l'envoi du code 2FA
            $mail = require __DIR__ . "/mailer.php"; // Charger le mailer

            // Configuration de l'email
            $mail->setFrom("noreply@example.com", "Your Application");
            $mail->addAddress($email); // Email de l'utilisateur
            $mail->Subject = "2FA Verification Code";

            // Code 2FA dans l'email
            $mail->isHTML(true); // Activer HTML pour l'email
            $mail->Body = <<<END
            <p>Hi,</p>
            <p>We received a request to log in to your account. Use the following verification code to complete the authentication process:</p>
            <p><strong>{$verification_code}</strong></p>
            <p>This code is valid for 5 minutes. If you did not request this, please ignore this email.</p>
            END;

            // Envoi de l'email
            try {
                $mail->send();
                echo json_encode(["status" => "success", "message" => "A 2FA verification code has been sent to your email."]);
            } catch (Exception $e) {
                echo json_encode(["status" => "error", "message" => "Message could not be sent. Mailer error: {$mail->ErrorInfo}"]);
            }
        } else {
            // Si la 2FA n'est pas activée, on renvoie les détails de l'utilisateur sans passer par la 2FA
            echo json_encode([
                "status" => "success",
                "role" => $user['role'],
                "id" => $user['id'],
                "nom" => $user['nom'],
                "prenom" => $user['prenom'],
                "photo" => $user['photo'],
                "adresse" => $user['adresse'],
                "phone" => $user['phone'],
                "is_enabled_2fa" => $user['is_enabled_2fa']
            ]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No account found with this email address."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
}
?>
<html>
    <body>
        
        <div class="form-popup" id="login">
            <form id="loginForm" action="login.php" method="POST">
                <h3>Connexion</h3>
                <input type="email" id="loginEmail" placeholder="Email" required />
                <input type="password" id="loginPassword" placeholder="Mot de passe" required />
                <a href="forgot-password.php">Mot de passe oublié ?</a>
                <button type="submit">Se connecter</button>
                <button type="button" class="close-btn" onclick="closeForms()">Fermer</button>
            </form>
        </div>
        <script>
            function showLogin() {
                document.getElementById("login").style.display = "block";
                document.getElementById("signup").style.display = "none";
            }
        </script>
        <script>
        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var email = document.getElementById("loginEmail").value;
            var password = document.getElementById("loginPassword").value;
            var formData = new FormData();
            formData.append("email", email);
            formData.append("password", password);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "login.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            console.log(response);
                            if (response.status === "success") {
                                if (response.message && response.message.includes("A 2FA verification code has been sent")) {
                                    alert(response.message);
                                    window.location.href = "verify_2fa.php";
                                } else {
                                    if (response.role === "admin") {
                                        window.location.href = "../back/user.php";
                                    } else {
                                        window.location.href = "pack.php";
                                    }
                                }
                            } else {
                                alert(response.message);
                            }
                        } catch (e) {
                            console.error("Erreur lors du parsing JSON : ", e);
                            console.error("Réponse brute du serveur : ", xhr.responseText);
                            alert("Erreur lors du traitement de la réponse du serveur.");
                        }
                    } else {
                        console.error("Erreur du serveur : statut ", xhr.status);
                        alert("Erreur lors de la connexion, veuillez réessayer.");
                    }
                }
            };
            xhr.send(formData);
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>
</html>
