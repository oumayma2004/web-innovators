<?php
require '../../controller/reclamationC.php'; // Chemin selon ton projet

$reclamationC = new ReclamationC();
$list = $reclamationC->listReclamations(); // Récupération des réclamations
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamations - Liste</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style pour les cartes */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Grille responsive avec des cartes de 300px minimum */
            gap: 20px;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-header {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Modifier la couleur du texte dans le corps de la carte */
        .card-body {
            font-size: 1em;
            margin-bottom: 15px;
            color: #333; /* Couleur du texte noir ou gris foncé */
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="main">
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">تفرهيدة</h2>
        </div>

        <div class="menu">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">SERVICE</a></li>
                <li><a href="#">DESIGN</a></li>
                <li class="dropdown">
                        <a href="#" class="dropbtn">Réclamation</a>
                        <ul class="dropdown-content">
                            <li><a href="listreclamation.php">Liste des réclamations</a></li>
                            <li><a href="ajouterreclamation.php">Ajouter une réclamation</a></li>
                        </ul>
                    </li>
                <li><a href="#">CONTACT</a></li>
            </ul>
        </div>

        <div class="search">
            <input class="srch" type="search" name="" placeholder="Type To text">
            <a href="#"> <button class="btn">Search</button></a>
        </div>
    </div>

    <div class="content">
        <a href="index.html"> <img id="logo" class="logo" src="file/logosite.png" alt=""></a>

        <div class="card-container">
            <?php
            foreach ($list as $reclamation) {
                echo '<div class="card">';
                echo '<div class="card-header">' . htmlspecialchars($reclamation['nom']) . '</div>';
                echo '<div class="card-body">';
                echo '<p><strong>E-mail:</strong> ' . htmlspecialchars($reclamation['email']) . '</p>';
                echo '<p><strong>Téléphone:</strong> ' . htmlspecialchars($reclamation['tel']) . '</p>';
                echo '<p><strong>Type de réclamation:</strong> ' . htmlspecialchars($reclamation['type_reclamation']) . '</p>';
                echo '<p><strong>Événement concerné:</strong> ' . htmlspecialchars($reclamation['evenement_concerne']) . '</p>';
                echo '<p><strong>Description:</strong> ' . nl2br(htmlspecialchars($reclamation['description'])) . '</p>';  /* nl2br pour les sauts de ligne dans la description */
                echo '</div>';
                echo '<div class="card-footer">';
                echo '<a href="modifierreclamation.php?id=' . $reclamation['id_reclamation'] . '" class="btn">Modifier</a>';
                echo '<a href="supprimerreclamation.php?id=' . $reclamation['id_reclamation'] . '" class="btn" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette réclamation ?\')">Supprimer</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>

</body>
</html>
