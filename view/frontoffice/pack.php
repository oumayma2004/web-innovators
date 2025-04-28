<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit();
}

require_once '../../config.php'; 
require_once '../../controller/userc.php'; 
include '../../controller/packc.php'; 
$packc = new packc(); 
// Nouvelle logique de pagination
$records_per_page = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Charger uniquement les packs nécessaires pour la page actuelle
$list = $packc->getAllPacks1($start_from, $records_per_page); 

$user_id = $_SESSION['user']['id']; 
$controller = new userc();
$user = $controller->getUserById($user_id);
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
    /* Style pour la modal */
.modal {
  display: none; /* Par défaut, la modal est cachée */
  position: fixed;
  z-index: 1; /* Pour être au-dessus de tout le contenu */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto; /* Permet le défilement si le contenu est trop grand */
  background-color: rgba(0, 0, 0, 0.5); /* Fond sombre */
}

/* Contenu de la modal */
.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border-radius: 10px;
  width: 300px;
  text-align: center;
}

/* Style pour le bouton de fermeture */
.close-btn {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 10px;
  right: 20px;
}

/* Changer la couleur au survol */
.close-btn:hover,
.close-btn:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Style des boutons de confirmation et annulation */
button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 10px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

button:hover {
  background-color: #45a049;
}
.pagination {
    display: flex;
    list-style: none;
    justify-content: center;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination a {
    text-decoration: none;
    padding: 8px 12px;
    color: #333;
    background-color: #f2f2f2;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: #ddd;
}

.pagination .active a {
    background-color: #4CAF50;
    color: white;
}

.pagination .disabled a {
    background-color: #ddd;
    color: #ccc;
    pointer-events: none;
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
        <img src="<?php echo $user['photo']; ?>" alt="Profile" class="profile-img" id="profileIcon">
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="update.php">👤 Profile</a>
          <a href="logout.php">🔓 Logout</a>
        </div>
      </div>
      <div id="reservationsModal" class="modal">
      <div class="modal-content" style="color: black;">
    <span class="close-btn" onclick="closeReservationsModal()">&times;</span>
    <h2>Mes Réservations</h2>
    <div id="reservationsList">
      <!-- Les réservations seront affichées ici -->
    </div>
</div>

</div>

  </header>
    <hr>
    <nav>
        <a href="pack.php"><img src="assets/logo-removebg-preview.png" alt="logo"> </a>
        <div class="link"> 
            <a href="index.html">Home |</a>
            <a href="pack.php">Packs |</a>
            <a href="">Sponsors   |</a>
            <a href="">Reclamation</a>
            <a href="javascript:void(0);" onclick="openReservationsModal()">Réservations |</a>

        </div>
    </nav>
  
    </header>
    <div class="search">
                    <label>
                        <input type="text" id="live_search12" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#live_search12").on('keyup change', function(){
                        $('#recentOrders').html(''); 
                        var input =$(this).val();
                        console.log(input);
                        $.ajax({
                            type: 'GET',
                            url:"recherchePackF.php",
                            data: 'input=' + encodeURIComponent(input),
                            success: function(data){
                                if(data!=""){
                                    $('#recentOrders').append(data); 
                                }else{
                                    document.getElementById('recentOrders').innerHTML = "<div style='font-size:20px'>aucun offre</div>"
                                }
                            }
                        });
                    });
                 });
            </script>
    <div id="confirmationModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Confirmer la réservation</h2>
    <p>Êtes-vous sûr de vouloir réserver ce pack ?</p>
    <p><strong>Titre du pack :</strong> <span id="packTitle"></span></p>
    <p><strong>Description :</strong> <span id="packDescription"></span></p>
    <p><strong>Prix :</strong> <span id="packPrice"></span></p>
    <button onclick="submitReservation()">Confirmer</button>
    <button onclick="closeModal()">Annuler</button>
  </div>
</div>



    <!-- Contenu principal des packs -->
    <h1>Nos Packs</h1>

    <div class="packs-container" id="recentOrders">
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

        <a href="javascript:void(0);" class="btn" onclick="openModal(<?= htmlspecialchars($pack['id']); ?>, '<?= htmlspecialchars($pack['titre']); ?>', 'TND <?= htmlspecialchars($pack['prix']); ?>', '<?= htmlspecialchars($pack['description']); ?>')">
  Réserver
</a>
</div>
      <?php
         }
        ?>
    </div>
    <?php
try {
    $db = config::getConnexion();
    $stmt = $db->query("SELECT COUNT(id) AS total FROM pack");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_records = $row['total'];

    $records_per_page = 3;
    $total_pages = ceil($total_records / $records_per_page);

    if ($total_pages > 1) {
        echo '<ul class="pagination">';
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul>';
    }
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>


    <script>
// Ouvrir la modale de confirmation
function openModal(packId, packTitle, packPrice, packDescription) {
  packIdToReserve = packId;
  document.getElementById("confirmationModal").style.display = "block";

  // Mettre à jour les détails de la réservation dans le formulaire de confirmation
  document.getElementById("packTitle").innerText = packTitle;
  document.getElementById("packPrice").innerText = packPrice;
  document.getElementById("packDescription").innerText = packDescription;
}

function submitReservation() {
  var formData = new FormData();
  var reservationDate = new Date().toISOString().split('T')[0]; // Date au format YYYY-MM-DD

  formData.append("user_id", <?= $_SESSION['user']['id']; ?>);  // ID de l'utilisateur
  formData.append("pack_id", packIdToReserve);
  formData.append("reservation_date", reservationDate); // Ajouter la date de réservation

  // Envoi de la requête AJAX pour ajouter la réservation
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "add_reservation.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      alert(xhr.responseText);  // Afficher le message retourné par PHP
      closeModal(); // Fermer la modale après confirmation
    }
  };
  xhr.send(formData);
}
function closeModal() {
  document.getElementById("confirmationModal").style.display = "none";
}
</script>
<script>
function openReservationsModal() {
  document.getElementById("reservationsModal").style.display = "block";

  // Charger les réservations de l'utilisateur connecté
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_user_reservations.php", true); // Ce fichier renverra les réservations
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("reservationsList").innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}

function closeReservationsModal() {
  document.getElementById("reservationsModal").style.display = "none";
}
</script>

<script>
  var userId = <?php echo $_SESSION['user']['id']; ?>;  // Assurez-vous que l'ID utilisateur est récupéré
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
