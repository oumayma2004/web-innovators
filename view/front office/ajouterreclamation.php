<?php
include_once '../../controller/reclamationC.php'; // Chemin selon ton projet
require_once '../../vendor/autoload.php'; // Ensure you include the Composer autoload file

use Twilio\Rest\Client;

$reclamationC = new ReclamationC();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reclamation = new Reclamation(
        null, // ID = auto-incrémenté
        $_POST['nom'],
        $_POST['email'],
        $_POST['tel'],
        // On ne récupère plus date_creation ni etat
        // Valeurs par défaut définies dans la base de données
        $_POST['type_reclamation'],
        $_POST['evenement_concerne'],
        $_POST['description']
    );

    $reclamationC->ajouterReclamation($reclamation);
    
    // Send SMS with Twilio
    $sid = 'AC99a440f3ceb445fc89c2ae862aef1a62';
    $token = '0095df58991ccd93ebf40d28d89e9465';
    $twilioNumber = '+16204008831';
    $client = new Client($sid, $token);
    
    $message = "Bonjour " . $_POST['nom'] . ", votre réclamation concernant l'événement '" . $_POST['evenement_concerne'] . "' a été ajoutée avec succès.";
    try {
        $client->messages->create(
            $_POST['tel'], // numéro du destinataire
            [
                'from' => $twilioNumber,
                'body' => $message
            ]
        );
    } catch (Exception $e) {
        // Log error if SMS fails to send
        error_log("Twilio SMS send failed: " . $e->getMessage());
    }

    header('Location: ajouterreclamation.php?success=true'); // Ajout du paramètre success
    exit();
}
?>



<!-- le header de la page  -->




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamation - Événement</title>
    <link rel="stylesheet" href="style1.css">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      
      :root {
        --primary-color: #e60e44;
        --secondary-color: #f3b1d2;
        --text-light: #ffffff;
        --text-dark: #2c3e50;
        --transition-speed: 0.4s;
      }
      
      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
      }

      /* MENU FIXE */
      .luxury-navbar {
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, var(--primary-color), #ee356c);
        padding: 0 3rem;
        height: 80px;
        width: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
      }
      
      .luxury-logo {
        color: var(--secondary-color);
        font-size: 2rem;
        font-weight: 700;
        margin-right: auto;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      }
      
      .luxury-menu ul {
        display: flex;
        list-style: none;
        height: 100%;
      }
      
      .luxury-menu li {
        position: relative;
      }
      
      .luxury-menu > ul > li > a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        padding: 0 1.5rem;
        height: 80px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
      }
      
      .luxury-menu > ul > li > a:hover {
        background: rgba(255,255,255,0.1);
      }
      
      /* DROPDOWN */
      .luxury-dropdown-content {
        position: absolute;
        top: 80px;
        left: 0;
        background: white;
        min-width: 250px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
      }
      
      .luxury-dropdown:hover .luxury-dropdown-content {
        opacity: 1;
        visibility: visible;
      }
      
      .luxury-dropdown-content a {
        color: #333;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
      }
      
      .luxury-dropdown-content a:hover {
        background: #f5f5f5;
        padding-left: 25px;
      }
      
      .luxury-dropdown-content ion-icon {
        margin-right: 10px;
        color: var(--primary-color);
      }
      
      /* Compense l'espace du menu fixe */
      body {
        padding-top: 80px;
      }
    </style>
    <script src="assets/js/validforme.js" defer></script>
</head>
<body>
    <!-- Menu -->
    <nav class="luxury-navbar">
        <div class="luxury-logo">تفرهيدة</div>
        <div class="luxury-menu">
            <ul>
                <li><a href="#"><span>Home</span></a></li>
                <li><a href="#"><span>Evenement</span></a></li>
                <li><a href="#"><span>Packs</span></a></li>
                <li><a href="#"><span>sponsor</span></a></li>
                <li class="luxury-dropdown">
                    <a href="#">
                        <span>Réclamation</span>
                        <ion-icon name="chevron-down-outline"></ion-icon>
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
    </nav>

</body>
</html>


<style>

.success-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #4CAF50;
    color: white;
    border-radius: 8px;
    padding: 15px 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    animation: slideIn 0.5s ease-out;
    max-width: 400px;
}

.success-content {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.success-notification svg {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
    margin-top: 2px;
}

.success-notification h3 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
}

.success-notification p {
    margin: 0;
    font-size: 14px;
    opacity: 0.9;
}

.close-btn {
    margin-left: 15px;
    cursor: pointer;
    font-size: 18px;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.close-btn:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}


</style>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Fermer la notification de succès
    const closeBtn = document.querySelector('.close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            this.closest('.success-notification').style.display = 'none';
        });
        
        // Fermer automatiquement après 10 secondes
        setTimeout(() => {
            document.querySelector('.success-notification')?.remove();
        }, 10000);
    }
});
</script>

    <main class="container">
        <h1>Envoyer une Réclamation</h1>
        <?php
// Afficher le message de succès si le paramètre 'success' est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo '
    <div class="success-notification">
        <div class="success-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <div>
                <h3>Réclamation envoyée avec succès</h3>
                <p>Nous avons bien reçu votre réclamation et la traiterons dans les plus brefs délais.</p>
            </div>
            <span class="close-btn">&times;</span>
        </div>
    </div>';
}
?>
        <form action="ajouterreclamation.php" method="POST" class="reclamation-form" onsubmit="return validateForm(event)">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom"  />

            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email"  />

            <label for="tel">Téléphone :</label>
            <input type="text" id="tel" name="tel"  />


            <label for="type_reclamation">Type de réclamation :</label>
            <select id="type_reclamation" name="type_reclamation" >
                <option value="retard">Retard ou annulation</option>
                <option value="accueil">Problème d’accueil</option>
                <option value="remboursement">Demande de remboursement</option>
                <option value="autre">Autre</option>
            </select>

            <label for="evenement_concerne">Événement concerné :</label>
            <select id="evenement_concerne" name="evenement_concerne" >
                <option value="">-- Sélectionnez un événement --</option>
                <option value="ete2025">Festival d'été 2025</option>
                <option value="noel2024">Marché de Noël 2024</option>
                <option value="printemps2025">Salon Printemps 2025</option>
            </select>

            <label for="description">Description de la réclamation :</label>
            <textarea id="description" name="description" rows="5" ></textarea>

            <button type="submit">Envoyer la réclamation</button>
        </form>
    </main>

   
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
                <li><a href="#">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="listreclamation.php">Réclamations</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Contactez-nous</h4>
            <ul class="contact-info">
                <li><ion-icon name="mail-outline"></ion-icon> contact@votresite.com</li>
                <li><ion-icon name="call-outline"></ion-icon> +212 6 12 34 56 78</li>
                <li><ion-icon name="location-outline"></ion-icon> Casablanca, Maroc</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2023 تفرهيدة. Tous droits réservés.</p>
    </div>


    <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized")
{window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};
window.chatbase=new Proxy(window.chatbase,
{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}
const onLoad=function(){const script=document.createElement("script");
script.src="https://www.chatbase.co/embed.min.js";script.id="rqcUar_D0fUndvYJLxMV1";
script.domain="www.chatbase.co";document.body.appendChild(script)};
if(document.readyState==="complete"){onLoad()}
else{window.addEventListener("load",onLoad)}})();
</script>
</footer>

<style>
    /* Style du footer avec hauteur augmentée */
    .luxury-footer {
        background: linear-gradient(135deg, #2c3e50, #1a252f);
        color: #ecf0f1;
        padding: 70px 0 0; /* Augmentation du padding top */
        font-family: 'Segoe UI', sans-serif;
        position: relative;
        margin-top: 50px;
        min-height: 400px; /* Hauteur minimale augmentée */
        display: flex;
        flex-direction: column;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        flex: 1; /* Prend tout l'espace disponible */
    }

    .footer-section h3 {
        color: #f3b1d2;
        font-size: 1.8rem;
        margin-bottom: 25px; /* Marge augmentée */
        font-weight: 700;
    }

    .footer-section h4 {
        color: #f3b1d2;
        font-size: 1.2rem;
        margin-bottom: 25px; /* Marge augmentée */
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
        margin-bottom: 25px; /* Marge augmentée */
        line-height: 1.6;
        font-size: 1rem; /* Taille de police légèrement augmentée */
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 15px; /* Marge augmentée */
    }

    .footer-section ul li a {
        color: #ecf0f1;
        text-decoration: none;
        transition: color 0.3s;
        display: block;
        font-size: 1rem; /* Taille de police légèrement augmentée */
    }

    .footer-section ul li a:hover {
        color: #f3b1d2;
        padding-left: 5px;
    }

    .contact-info li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px; /* Marge augmentée */
        font-size: 1rem; /* Taille de police légèrement augmentée */
    }

    .contact-info ion-icon {
        font-size: 1.3rem; /* Taille d'icône augmentée */
        color: #e60e44;
    }

    .social-icons {
        display: flex;
        gap: 20px; /* Espacement augmenté */
        margin-top: 30px; /* Marge augmentée */
    }

    .social-icons a {
        color: #ecf0f1;
        font-size: 1.8rem; /* Taille d'icône augmentée */
        transition: transform 0.3s, color 0.3s;
    }

    .social-icons a:hover {
        color: #f3b1d2;
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        padding: 25px 0; /* Padding augmenté */
        margin-top: 60px; /* Marge augmentée */
        background: rgba(0, 0, 0, 0.2);
        font-size: 1rem; /* Taille de police légèrement augmentée */
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
        }
        
        .footer-section {
            margin-bottom: 40px; /* Marge augmentée */
        }
        
        .luxury-footer {
            min-height: auto; /* Hauteur automatique sur mobile */
            padding: 50px 0 0; /* Padding ajusté */
        }
    }
</style>
</body>
</html>
