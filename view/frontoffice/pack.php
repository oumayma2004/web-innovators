<?php
require_once '../../config.php'; 
include '../../controller/packc.php'; 
$packc = new packc(); 
$list = $packc->getAllPacks(); 


?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nos Packs</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Assurez-vous que le lien vers votre CSS est correct -->
    <!-- Importer la police cursive depuis Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap"
      rel="stylesheet"
    />
    <style>
       body {
      font-family: 'Poppins', sans-serif;
      justify-content: center;
      align-items: center;
    }
  
    .profile-container {
      position: relative;
      display: inline-block;
    }
    .profile-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 50px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      min-width: 150px;
      z-index: 1000;
    }

    .dropdown-menu a {
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      color: #333;
    }

    .dropdown-menu a:hover {
      background-color: #f0f0f0;
    }
   

    .form-container {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      padding: 30px;
      right: 100px;
    }

    h3 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      color: #555;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #5c6ac4;
      outline: none;
    }

    .form-group input[type="file"] {
      border: none;
    }
    </style>
  </head>
  <body>
    <!-- Header ajouté -->
    <header>
      <div class="tel">
          <img src="assets/tel.png" alt="tel">
          <a href="tel:+21692000500"> +216 92 000 500 </a>
          <img src="assets/tel.png" alt="tel">
          <a href="tel:+21692500200"> +216 92 500 200</a>
      </div>
      <div class="profile-container">
        <img src="" alt="Profile" class="profile-img" id="profileIcon">
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="update.php">👤 Profile</a>
          <a href="logout.php">🔓 Logout</a>
        </div>
      </div>
  </header>
    <hr>
    <nav>
        <a href="pack.php"><img src="assets/logo-removebg-preview.png" alt="logo"> </a>
        <div class="link"> 
            <a href="index.html">Home |</a>
            <a href="../backoffice/pack.php">Packs |</a>
            <a href="">Sponsors   |</a>
            <a href="">Reclamation</a>
        </div>
    </nav>
  
    </header>

    <!-- Contenu principal des packs -->
    <h1>Nos Packs</h1>

    <div class="packs-container">
      <?php
        foreach ($list as $pack) {
      ?>
      <div class="pack-card">
        <h2 class="pack-title"><?= htmlspecialchars($pack['titre']); ?></h2>
        <p class="pack-description">
              <?= htmlspecialchars($pack['description']); ?>
        </p>
        <p class="pack-price">TND <?= htmlspecialchars($pack['prix']); ?></p>
        <p class="pack-places">Places disponibles: <?= htmlspecialchars($pack['nombre_places']); ?></p>
        <p class="pack-places">Date: <?= htmlspecialchars($pack['date_d']); ?></p>

        <a href="#" class="btn" onclick="openForm(<?= htmlspecialchars($pack['titre']); ?>, 1, <?= htmlspecialchars($pack['prix']); ?>, 100, <?= htmlspecialchars($pack['description']); ?>, '2025-05-01', '2025-05-10')">Réserver</a>
      </div>
      <?php
         }
        ?>
    </div>

    <!-- Formulaire de réservation -->
    <div id="reservationForm" class="reservation-form">
      <form action="#" method="POST">
        <h2>Réserver le Pack</h2>
        <label for="nom">Nom du pack :</label>
        <input type="text" id="nom" name="nom" readonly>
        
        <label for="id_evenement">ID de l'événement :</label>
        <input type="number" id="id_evenement" name="id_evenement" readonly>
        
        <label for="places">Nombre de places :</label>
        <input type="number" id="places" name="places" readonly>
        
        <label for="description">Description :</label>
        <textarea id="description" name="description" readonly></textarea>
        
        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" readonly>
        
        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" readonly>
        
        <label for="prix">Prix :</label>
        <input type="text" id="prix" name="prix" readonly>
        
        <button type="submit">Confirmer la réservation</button>
        <button type="button" class="close" onclick="closeForm()">Fermer</button>
      </form>
    </div>

    <script>
      function openForm(nom, id, prix, places, description, dateDebut, dateFin) {
        document.getElementById('reservationForm').style.display = 'block';
        document.getElementById('nom').value = nom;
        document.getElementById('id_evenement').value = id;
        document.getElementById('places').value = places;
        document.getElementById('description').value = description;
        document.getElementById('date_debut').value = dateDebut;
        document.getElementById('date_fin').value = dateFin;
        document.getElementById('prix').value = prix + ' TND';
      }

      function closeForm() {
        document.getElementById('reservationForm').style.display = 'none';
      }
    </script>
  </body>
</html>
<script>
  const profileIcon = document.getElementById('profileIcon');
  const dropdownMenu = document.getElementById('dropdownMenu');

  profileIcon.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
  });

  // Close dropdown if clicking outside
  document.addEventListener('click', function(event) {
    if (!event.target.closest('.profile-container')) {
      dropdownMenu.style.display = 'none';
    }
  });
</script>
