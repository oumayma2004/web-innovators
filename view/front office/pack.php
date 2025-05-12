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

// Pagination logic
$records_per_page = 3; // Increased from 3 to 6 for better display
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

// Load only the necessary packs for the current page
$list = $packc->getAllPacks1($start_from, $records_per_page); 

$user_id = $_SESSION['user']['id']; 
$controller = new userc();
$user = $controller->getUserById($user_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Packs | Travel Agency</title>
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Ion Icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        :root {
            --primary-color: #e60e44;
            --secondary-color: #f3b1d2;
            --text-light: #ffffff;
            --text-dark: #2c3e50;
            --transition-speed: 0.4s;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background-color: var(--light-bg);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Styles (from index.html) */
        .luxury-navbar {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary-color), #ee356c);
            padding: 0 3rem;
            height: 80px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }
        
        .luxury-logo {
            color: var(--secondary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-right: auto;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            letter-spacing: 1px;
        }
        
        .luxury-menu ul {
            display: flex;
            list-style: none;
            height: 100%;
            gap: 2px;
            margin: 0;
            padding: 0;
            align-items: center;
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
        
        /* Dropdown for Réclamation */
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

        /* Profile Dropdown */
        .profile-container {
            position: relative;
            display: inline-block;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            object-fit: cover;
            border: 2px solid var(--secondary-color);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            min-width: 180px;
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--text-dark);
            transition: var(--transition);
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background-color: #f0f0f0;
            color: var(--primary-color);
        }

        /* Search Bar */
        .search {
            max-width: 500px;
            margin: 0 20px;
        }

        .search label {
            position: relative;
            display: block;
        }

        .search input {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            box-shadow: var(--box-shadow);
            font-size: 16px;
            transition: var(--transition);
        }

        .search input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .search ion-icon, .search i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dark);
            font-size: 20px;
        }

        /* Main Content */
        h1 {
            text-align: center;
            margin: 30px 0;
            color: var(--text-dark);
            font-size: 36px;
            font-weight: 700;
        }

        .packs-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 5% 50px;
        }

        .pack-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .pack-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .pack-title {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 15px;
            font-size: 20px;
            text-align: center;
        }

        .pack-description {
            padding: 15px;
            color: var(--text-dark);
            min-height: 100px;
        }

        .pack-price {
            padding: 0 15px;
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color);
            margin-top: 10px;
        }

        .pack-places {
            padding: 0 15px;
            margin: 10px 0;
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--text-light);
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 5px;
            margin: 15px;
            text-align: center;
            transition: var(--transition);
            font-weight: 500;
        }

        .btn:hover {
            background-color: #c10b3a;
        }

        /* Pagination */
        .pagination {
            display: flex;
            list-style: none;
            justify-content: center;
            padding: 0;
            margin: 30px 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            background-color: white;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: inline-block;
            min-width: 40px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .pagination .active a {
            background-color: var(--primary-color);
            color: var(--text-light);
        }

        .pagination .disabled a {
            background-color: #ddd;
            color: #ccc;
            pointer-events: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: var(--border-radius);
            width: 400px;
            max-width: 90%;
            text-align: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-btn:hover {
            color: var(--text-dark);
        }

        .modal h2 {
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .modal p {
            margin: 10px 0;
            text-align: left;
        }

        .modal button {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 10px 20px;
            margin: 15px 5px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: 500;
            transition: var(--transition);
        }

        .modal button:hover {
            background-color: #c10b3a;
        }

        .modal button:last-child {
            background-color: #f44336;
        }

        .modal button:last-child:hover {
            background-color: #d32f2f;
        }

        /* User Reservations Modal */
        #reservationsList {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .luxury-navbar {
                padding: 0 1rem;
                flex-direction: column;
                height: auto;
            }
            
            .luxury-menu > ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                margin-top: 10px;
            }
            
            .luxury-menu > ul > li > a {
                padding: 0 0.8rem;
                font-size: 0.9rem;
            }
            
            .search {
                margin: 10px 0;
                width: 100%;
            }
            
            .profile-container {
                margin-top: 10px;
            }
            
            .packs-container {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                width: 90%;
                margin: 20% auto;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation (Adapted from index.html) -->
    <div class="luxury-navbar">
        <div class="luxury-logo">تفرهيدة</div>
        <div class="search">
            <label>
                <input type="text" id="live_search12" placeholder="Rechercher un pack...">
                <i class="fas fa-search"></i>
            </label>
        </div>
        <div class="luxury-menu">
            <ul>
                <li><a href="index.html"><span>Accueil</span></a></li>
                <li><a href="pack.php" class="active"><span>Packs</span></a></li>
                <li><a href="liste_sponsors.php"><span>Sponsors</span></a></li>
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
                <li><a href="javascript:void(0);" onclick="openReservationsModal()"><span>Mes Réservations</span></a></li>
                <li class="profile-container">
                    <img src="<?php echo $user['photo']; ?>" alt="Profile" class="profile-img" id="profileIcon">
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="update.php"><i class="fas fa-user"></i> Profil</a>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Reservations Modal -->
    <div id="reservationsModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeReservationsModal()">×</span>
            <h2>Mes Réservations</h2>
            <div id="reservationsList">
                <!-- Les réservations seront chargées ici via AJAX -->
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h2>Confirmer la réservation</h2>
            <p>Êtes-vous sûr de vouloir réserver ce pack ?</p>
            <p><strong>Titre du pack :</strong> <span id="packTitle"></span></p>
            <p><strong>Description :</strong> <span id="packDescription"></span></p>
            <p><strong>Prix :</strong> <span id="packPrice"></span></p>
            <button onclick="submitReservation()">Confirmer</button>
            <button onclick="closeModal()">Annuler</button>
        </div>
    </div>

    <!-- Main Content -->
    <h1>Découvrez Nos Packs</h1>

    <div class="packs-container" id="recentOrders">
        <?php foreach ($list as $pack): ?>
            <div class="pack-card">
                <h2 class="pack-title"><?= htmlspecialchars($pack['titre']); ?></h2>
                <p class="pack-description">
                    <?= htmlspecialchars($pack['description']); ?>
                </p>
                <p class="pack-price">TND <?= htmlspecialchars($pack['prix']); ?></p>
                <p class="pack-places"><i class="fas fa-users"></i> Places disponibles: <?= htmlspecialchars($pack['nombre_places']); ?></p>
                <p class="pack-places"><i class="far fa-calendar-alt"></i> Date: <?= htmlspecialchars($pack['date_d']); ?></p>
                <a href="javascript:void(0);" class="btn"
                   onclick='openModal(
                       <?= json_encode($pack['id']) ?>,
                       <?= json_encode(htmlspecialchars($pack['titre'], ENT_QUOTES)) ?>,
                       <?= json_encode("TND " . $pack['prix']) ?>,
                       <?= json_encode(htmlspecialchars($pack['description'], ENT_QUOTES)) ?>
                   )'>
                   <i class="fas fa-bookmark"></i> Réserver
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php
    try {
        $db = config::getConnexion();
        $stmt = $db->query("SELECT COUNT(id) AS total FROM pack");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_records = $row['total'];

        $total_pages = ceil($total_records / $records_per_page);

        if ($total_pages > 1) {
            echo '<ul class="pagination">';
            
            // Previous page link
            if ($page > 1) {
                echo '<li><a href="?page=' . ($page - 1) . '"><i class="fas fa-chevron-left"></i></a></li>';
            } else {
                echo '<li class="disabled"><a><i class="fas fa-chevron-left"></i></a></li>';
            }
            
            // Page numbers
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $page ? ' class="active"' : '';
                echo '<li' . $active . '><a href="?page=' . $i . '">' . $i . '</a></li>';
            }
            
            // Next page link
            if ($page < $total_pages) {
                echo '<li><a href="?page=' . ($page + 1) . '"><i class="fas fa-chevron-right"></i></a></li>';
            } else {
                echo '<li class="disabled"><a><i class="fas fa-chevron-right"></i></a></li>';
            }
            
            echo '</ul>';
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    ?>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <!-- Live Search Script -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#live_search12").on('keyup change', function(){
                $('#recentOrders').html(''); 
                var input = $(this).val();
                console.log(input);
                $.ajax({
                    type: 'GET',
                    url: "recherchePackF.php",
                    data: 'input=' + encodeURIComponent(input),
                    success: function(data){
                        if(data != ""){
                            $('#recentOrders').append(data); 
                        } else {
                            document.getElementById('recentOrders').innerHTML = "<div style='text-align: center; font-size: 20px; padding: 50px 0;'>Aucun pack ne correspond à votre recherche</div>";
                        }
                    }
                });
            });
        });
    </script>
    
    <!-- Modal and Reservation Scripts -->
    <script>
        // Variable to store the pack ID for reservation
        let packIdToReserve;

        // Open the confirmation modal
        function openModal(packId, packTitle, packPrice, packDescription) {
            packIdToReserve = packId;
            console.log("Modal Opened", { packId, packTitle, packPrice, packDescription });
            document.getElementById("confirmationModal").style.display = "block";

            // Update the reservation details in the confirmation form
            document.getElementById("packTitle").innerText = packTitle;
            document.getElementById("packPrice").innerText = packPrice;
            document.getElementById("packDescription").innerText = packDescription;
        }

        // Submit the reservation
        function submitReservation() {
            var formData = new FormData();
            var reservationDate = new Date().toISOString().split('T')[0]; // Date in YYYY-MM-DD format

            formData.append("user_id", <?= $_SESSION['user']['id']; ?>);  // User ID
            formData.append("pack_id", packIdToReserve);
            formData.append("reservation_date", reservationDate); // Add reservation date

            // Send AJAX request to add the reservation
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "add_reservation.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);  // Display the message returned by PHP
                    closeModal(); // Close the modal after confirmation
                }
            };
            xhr.send(formData);
        }

        // Close the confirmation modal
        function closeModal() {
            document.getElementById("confirmationModal").style.display = "none";
        }

        // Open the reservations modal
        function openReservationsModal() {
            document.getElementById("reservationsModal").style.display = "block";

            // Load the connected user's reservations
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_user_reservations.php", true); // This file will return the reservations
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("reservationsList").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Close the reservations modal
        function closeReservationsModal() {
            document.getElementById("reservationsModal").style.display = "none";
        }

        // Profile dropdown toggle
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

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = "none";
            }
        }
    </script>
</body>
</html>