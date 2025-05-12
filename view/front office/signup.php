<?php
require_once '../../controller/userc.php';
require_once '../../Model/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date_c = $_POST['date_c'];
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $password = htmlspecialchars($_POST['password']);
    $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);

    if ($password !== $passwordConfirm) {
        die('Les mots de passe ne correspondent pas.');
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $user = new User($nom, $prenom, $date_c, "default.jpg", $adresse, $hashedPassword, $email, $phone);
    $userc = new userc();

    if ($userc->addUser($user)) {
        header("Location: index.html");
        exit();
    } else {
        echo "Une erreur est survenue lors de l'inscription.";
    }
}
?>
<html>
    <head>
        <style>
            
        
        </style>
    </head>
    <body>
        <div class="form-popup" id="signup">
        <form id="signupForm" action="signup.php" method="POST">
            <h3>Inscription</h3>
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required />
            <input type="text" id="nom" name="nom" placeholder="Nom" required />
            <input type="email" id="email" name="email" placeholder="Email" required />
            <input type="tel" id="phone" name="phone" placeholder="Numéro de téléphone" required />
            <input type="text" id="adresse" name="adresse" placeholder="Adresse" required />
            <input type="date" id="date_c" name="date_c" placeholder="Date de naissance" required />
            <input type="password" id="signupPassword" name="password" placeholder="Mot de passe" required />
            <input type="password" id="signupPasswordConfirm" name="passwordConfirm" placeholder="Confirmer le mot de passe" required />
            <button type="submit">S'inscrire</button>
            <button type="button" class="close-btn" onclick="closeForms()">Fermer</button>
        </form>
    </div>
    <script>
        function closeForms() {
            document.getElementById("login").style.display = "none";
            document.getElementById("signup").style.display = "none";
        }
    
    </script>
    <script>
        document.getElementById("signupForm").addEventListener("submit", function (event) {
            event.preventDefault();
            const prenom = document.getElementById("prenom").value;
            const nom = document.getElementById("nom").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const adresse = document.getElementById("adresse").value;
            const date_c = document.getElementById("date_c").value;
            const password = document.getElementById("signupPassword").value;
            const passwordConfirm = document.getElementById("signupPasswordConfirm").value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[0-9]{8,15}$/;
            const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!prenom) {
                alert("Le prénom est requis.");
                return;
            }
            if (!nom) {
                alert("Le nom est requis.");
                return;
            }
            if (prenom.length <= 2) {
                alert("Le prénom doit avoir plus de 2 caractères.");
                return;
            }
            if (nom.length <= 3) {
                alert("Le nom doit avoir plus de 3 caractères.");
                return;
            }
            if (!email) {
                alert("L'email est requis.");
                return;
            } else if (!emailPattern.test(email)) {
                alert("L'email n'est pas valide.");
                return;
            }
            if (!phone) {
                alert("Le numéro de téléphone est requis.");
                return;
            } else if (!phonePattern.test(phone)) {
                alert("Le numéro de téléphone n'est pas valide.");
                return;
            }
            if (!adresse) {
                alert("L'adresse est requise.");
                return;
            }
            if (!date_c) {
                alert("La date de naissance est requise.");
                return;
            }
            if (!password) {
                alert("Le mot de passe est requis.");
                return;
            } else if (!passwordPattern.test(password)) {
                alert("Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.");
                return;
            }
            if (password !== passwordConfirm) {
                alert("Les mots de passe ne correspondent pas.");
                return;
            }
            alert("Formulaire envoyé avec succès !");
            this.submit();
        });
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