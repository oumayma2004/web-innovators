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
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style général amélioré */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            color: #333;
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
<body>
<div class="main">
        <div class="navbar">
*

            <div class="menu">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">ABOUT</a></li>
                    <li><a href="#">SERVICE</a></li>
                    <li><a href="#">DESIGN</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Réclamation <ion-icon name="chevron-down-outline" style="font-size: 12px; vertical-align: middle;"></ion-icon></a>
                        <ul class="dropdown-content">
                            <li><a href="listreclamation.php"><ion-icon name="list-outline" style="margin-right: 8px;"></ion-icon> Liste des réclamations</a></li>
                            <li><a href="ajouterreclamation.php"><ion-icon name="add-outline" style="margin-right: 8px;"></ion-icon> Ajouter une réclamation</a></li>
                        </ul>
                    </li>
                    <li><a href="#">CONTACT</a></li>
                </ul>
            </div>

        </div> 
        <div class="content">
            <a href="index.html"> <img id="logo" class="logo" src="file/logosite.png" alt=""></a>
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

</body>
</html>