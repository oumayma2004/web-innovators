<?php
require '../../controller/reclamationC.php'; // Chemin selon ton projet

$reclamationC = new ReclamationC();
$list = $reclamationC->afficherReclamationsAvecReponses(); // Récupération des réclamations
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamations - Liste</title>
    <link rel="stylesheet" href="">
    <style>
        body {
        margin: 0;
        padding: 0;
        background: url('assets/background.jpg') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
      }

      /* Contenu principal avec transparence */
      .content-wrapper {
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 10px;
        padding: 20px;
        margin: 100px auto 30px;
        max-width: 1200px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      }
       
      .main, .content, .card-container, .card {
        background-color: transparent !important;
      }

        /* Conteneur des cartes */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Carte individuelle */
        .card {
            border: none;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
        }

        /* En-tête de carte */
        .card-header {
            font-size: 1.4em;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .card-header::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 20px;
            background-color: #3498db;
            margin-right: 10px;
            border-radius: 4px;
        }

        /* Corps de carte */
        .card-body {
            font-size: 0.95em;
            margin-bottom: 20px;
            color: #555;
        }

        .card-body p {
            margin: 8px 0;
            display: flex;
        }

        .card-body strong {
            color: #2c3e50;
            min-width: 150px;
            display: inline-block;
        }

        /* Pied de carte */
        .card-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn ion-icon {
            font-size: 1.1em;
        }

        /* Style pour le bouton Supprimer */
        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        /* Badge pour le type de réclamation */
        .reclamation-type {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f1c40f;
            color: #2c3e50;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
                padding: 15px;
            }
            
            .card-body strong {
                min-width: 120px;
            }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Conteneur des cartes */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        /* Style des cartes */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }

        /* En-tête de carte */
        .card-header {
            padding: 20px;
            background-color: #2c3e50;
            color: white;
            position: relative;
        }

        .card-title {
            font-size: 1.3em;
            margin: 0;
            font-weight: 600;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 0.9em;
            color: #ecf0f1;
        }

        .card-type {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #3498db;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 500;
        }

        /* Corps de carte */
        .card-body {
            padding: 20px;
        }

        .info-row {
            margin-bottom: 12px;
            display: flex;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            min-width: 120px;
        }

        .info-value {
            color: #555;
            flex: 1;
        }

        /* Section réponse */
        .response-section {
            margin-top: 20px;
            border-top: 1px dashed #ddd;
            padding-top: 20px;
        }

        .response-header {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .response-header:before {
            content: "⤷";
            margin-right: 8px;
            color: #3498db;
            font-size: 1.2em;
        }

        .response-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            color: #555;
            line-height: 1.5;
        }

        .no-response {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-style: italic;
        }

        /* Pied de carte */
        .card-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
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
        background: url('assets/background.jpg') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
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
        padding: 0 3rem 0 1.5rem; /* Réduit le padding à droite */
        height: 80px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        margin-left: -15px; /* Décalage vers la gauche */
      }

      .luxury-logo {
        color: #f3b1d2;
        font-size: 2rem;
        font-weight: 700;
        margin-right: auto;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        letter-spacing: 1px;
        padding-left: 15px; /* Compensation du décalage */
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
    <!-- Menu -->
    <div class="luxury-navbar">
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
       
    </div>
<div class="main">
    <!-- Votre navbar existante reste inchangée -->
    
    <div class="content">
        <div class="card-container">
            <?php
            foreach ($list as $reclamation) {
                echo '<div class="card">';
                
                // En-tête de la carte
                echo '<div class="card-header">';
                echo '<div class="card-title">Réclamation #' . htmlspecialchars($reclamation['id_reclamation']) . '</div>';
                echo '<div class="card-meta">';
                echo '<span>' . htmlspecialchars($reclamation['date_creation']) . '</span>';
                echo '</div>';
                echo '</div>';
                
                // Corps de la carte
                echo '<div class="card-body">';
                echo '<div class="info-row">';
                echo '<span class="info-label">Nom:</span>';
                echo '<span class="info-value">' . htmlspecialchars($reclamation['nom']) . '</span>';
                echo '</div>';
                
                echo '<div class="info-row">';
                echo '<span class="info-label">Email:</span>';
                echo '<span class="info-value">' . htmlspecialchars($reclamation['email']) . '</span>';
                echo '</div>';
                
                echo '<div class="info-row">';
                echo '<span class="info-label">Téléphone:</span>';
                echo '<span class="info-value">' . htmlspecialchars($reclamation['tel']) . '</span>';
                echo '</div>';
                
                echo '<div class="info-row">';
                echo '<span class="info-label">Téléphone:</span>';
                echo '<span class="info-value">' . htmlspecialchars($reclamation['type_reclamation']) . '</span>';
                echo '</div>';

                echo '<div class="info-row">';
                echo '<span class="info-label">Événement:</span>';
                echo '<span class="info-value">' . htmlspecialchars($reclamation['evenement_concerne']) . '</span>';
                echo '</div>';
                
                echo '<div class="info-row">';
                echo '<span class="info-label">Description:</span>';
                echo '<span class="info-value">' . nl2br(htmlspecialchars($reclamation['description'])) . '</span>';
                echo '</div>';
                
                // Section réponse
                echo '<div class="response-section">';
                if (!empty($reclamation['reponse'])) {
                    echo '<div class="response-header">Réponse de l\'administration</div>';
                    echo '<div class="response-content">' . nl2br(htmlspecialchars($reclamation['reponse'])) . '</div>';
                } else {
                    echo '<div class="no-response">En attente de réponse</div>';
                }
                echo '</div>';
                
                echo '</div>'; // Fin du card-body
                
                // Pied de carte (vide dans votre cas)
                echo '<div class="card-footer"></div>';
                
                echo '</div>'; // Fin de la card
            }
            ?>
        </div>
    </div>
</div>

<style>
    /* Styles existants */
    .card {
        position: relative;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .response-container {
        margin-top: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #3498db;
    }
    
    .response-header {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    
    .response-header:before {
        content: "→";
        margin-right: 8px;
        color: #3498db;
    }
    
    .response-content {
        color: #555;
        line-height: 1.5;
    }
    
    .no-response {
        margin-top: 20px;
        padding: 10px;
        background-color: #fff3cd;
        color: #856404;
        border-radius: 5px;
        text-align: center;
        font-style: italic;
    }
    
    /* Animation pour les réponses */
    .response-container {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</div>

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
</body>
</html>