<?php
include_once "../../Controller/sponsorsC.php";

$sponsorController = new SponsorC();
$sponsors = $sponsorController->getValidSponsors();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tfarhida</title>
    <link rel="icon" href="assets/logo.jpg" style="border-radius: 50%;">
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --primary-color: #e60e44;
            --secondary-color: #f3b1d2;
            --text-light: #ffffff;
            --text-dark: #2c3e50;
            --transition-speed: 0.4s;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }

        .content-wrapper {
            padding-top: 80px; /* Compensation pour le menu fixe */
        }

        /* Menu décalé vers la gauche */
        .luxury-navbar {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #e60e44, #ee356c);
            padding: 0 3rem 0 1.5rem;
            height: 80px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            margin-left: -15px;
        }

        .luxury-logo {
            color: #f3b1d2;
            font-size: 2rem;
            font-weight: 700;
            margin-right: auto;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            letter-spacing: 1px;
            padding-left: 15px;
        }

        .luxury-menu ul {
            display: flex;
            list-style: none;
            height: 100%;
            gap: 2px;
            margin: 0;
            padding: 0;
        }

        .luxury-menu li {
            position: relative;
            display: flex;
            align-items: center;
        }

        .luxury-menu > ul > li > a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            padding: 0 1.5rem;
            height: 100%;
            display: flex;
            align-items: center;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .luxury-menu > ul > li > a span {
            position: relative;
            z-index: 1;
        }

        .luxury-menu > ul > li > a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background-color: rgba(255,255,255,0.2);
            transition: all var(--transition-speed) ease;
        }

        .luxury-menu > ul > li > a:hover {
            color: var(--secondary-color);
        }

        .luxury-menu > ul > li > a:hover::before {
            height: 100%;
        }

        /* Dropdown */
        .luxury-dropdown-content {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 250px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all var(--transition-speed) ease;
            z-index: 100;
            padding: 10px 0;
        }

        .luxury-dropdown:hover .luxury-dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .luxury-dropdown-content a {
            color: var(--text-dark);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
        }

        .luxury-dropdown-content a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: var(--secondary-color);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .luxury-dropdown-content a:hover {
            background: #f9f9f9;
            padding-left: 30px;
        }

        .luxury-dropdown-content a:hover::before {
            transform: scaleY(1);
        }

        /* Icônes */
        .luxury-arrow {
            font-size: 0.9rem;
            margin-left: 0.5rem;
            transition: all var(--transition-speed) ease;
        }

        .luxury-dropdown:hover .luxury-arrow {
            transform: rotate(180deg);
            color: var(--secondary-color);
        }

        .luxury-dropdown-content ion-icon {
            margin-right: 1rem;
            color: var(--primary-color);
            font-size: 1.1rem;
            min-width: 20px;
        }
    </style>
</head>
<body>

<header>
    <div class="tel">
        <img src="assets/téléchargé__1_-removebg-preview.png" alt="tel">
        <a href="tel:+21692000500"> +216 92 000 500 </a>
        <img src="assets/téléchargé__1_-removebg-preview.png" alt="tel">
        <a href="tel:+21692500200"> +216 92 500 200</a>
    </div>
    <div class="links">
        <img src="assets/images-removebg-preview.png" class="li">
        <a href="">Log in |</a>
        <img src="assets/user.png">
        <a href="">Sign up</a>
    </div>
</header>

<hr>

<!-- New Navbar -->
<div class="luxury-navbar">
    <div class="luxury-logo">تفرهيدة</div>
    <div class="luxury-menu">
        <ul>
            <li><a href="index.html"><span>Home</span></a></li>
            <li><a href="#"><span>Evenement</span></a></li>
            <li><a href="#"><span>Packs</span></a></li>
            <li><a href="form.php"><span>Sponsor</span></a></li>
            <li class="luxury-dropdown">
                <a href="#">
                    <span>Réclamation</span>
                    <ion-icon name="chevron-down-outline" class="luxury-arrow"></ion-icon>
                </a>
                 <div class="luxury-dropdown-content">
                        <a href="listreclamation.php">
                            <ion-icon name="list-outline"></ion-icon>
                            <span>Liste des réclamations</span>
                        </a>
                        <a href="ajouterreclamation.php">
                            <ion-icon name="add-outline"></ion-icon>
                            <span>Ajouter une réclamation</span>
                        </a>
                    </div>
            </li>
            <li><a href="#"><span>Contact</span></a></li>
        </ul>
    </div>
</div>

<div class="content-wrapper">
    <h2> ✨Devenez Partenaire de Nos Événements Inoubliables✨</h2> <br><br>

    <div class="row1">
        <?php if (!empty($sponsors)) : ?>
            <?php foreach ($sponsors as $sponsor): ?>
                <div class="event1">
                    <?php if (!empty($sponsor['image']) && file_exists('../tfarhida/view/uploads/' . $sponsor['image'])): ?>
                        <img src="../tfarhida/view/uploads/<?= htmlspecialchars($sponsor['image']) ?>" alt="Sponsor Image">
                    <?php else: ?>
                        <span>No Image</span>
                    <?php endif; ?>
                    <h6><?= htmlspecialchars($sponsor['nom_complet']) ?></h6>
                    <p><strong>Entreprise :</strong> <?= htmlspecialchars($sponsor['entreprise']) ?></p>
                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($sponsor['telephone']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun sponsor validé trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<br><br>

    <!-- [Previous content: main-content, forms, etc.] -->

   <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>

<footer class="luxury-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>تفرهيدة</h3>
            <p>Plateforme de gestion des réclamations et services clients</p>
            <div class="social-icons">
                <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="#"><ion-icon name="logo-linkedin"></ion-icon></a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Liens rapides</h4>
            <ul>
                <li><a href="#"><H1>Home</H1></a></li>
                <li><a href="#">Evenement</a></li>
                <li><a href="#">Packs</a></li>
                <li><a href="#">Sponsor</a></li>
                <li><a href="listreclamation.php">Réclamations</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Contactez-nous</h4>
            <ul class="contact-info">
                <li><ion-icon name="mail-outline"></ion-icon> contact@votresite.com</li>
                <li><ion-icon name="call-outline"></ion-icon> +212 6 12 34 56 78</li>
                <li><ion-icon name="location-outline"></ion-icon> Marsa,Tunisie</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2023 تفرهيدة. Tous droits réservés.</p>
    </div>
</footer>

<style>
    /* Style du footer */
    .luxury-footer {
        background: linear-gradient(135deg, #2c3e50, #1a252f);
        color: #ecf0f1;
        padding: 50px 0 0;
        font-family: 'Segoe UI', sans-serif;
        position: relative;
        margin-top: 50px;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .footer-section h3 {
        color: #f3b1d2;
        font-size: 1.8rem;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .footer-section h4 {
        color: #f3b1d2;
        font-size: 1.2rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-section h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background: #e60e44;
    }

    .footer-section p {
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        color: #ecf0f1;
        text-decoration: none;
        transition: color 0.3s;
        display: block;
    }

    .footer-section ul li a:hover {
        color: #f3b1d2;
        padding-left: 5px;
    }

    .contact-info li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .contact-info ion-icon {
        font-size: 1.2rem;
        color: #e60e44;
    }

    .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-icons a {
        color: #ecf0f1;
        font-size: 1.5rem;
        transition: transform 0.3s, color 0.3s;
    }

    .social-icons a:hover {
        color: #f3b1d2;
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        padding: 20px 0;
        margin-top: 50px;
        background: rgba(0, 0, 0, 0.2);
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
        }
        
        .footer-section {
            margin-bottom: 30px;
        }
    }
</style>
    <!-- JavaScript pour la gestion des formulaires -->
    <script>
        function showLogin() {
            document.getElementById("login").style.display = "block";
            document.getElementById("signup").style.display = "none";
        }

        function showSignup() {
            document.getElementById("signup").style.display = "block";
            document.getElementById("login").style.display = "none";
        }

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

<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>