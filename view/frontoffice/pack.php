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
    <style>
        :root {
            --primary-color: #FFC0CB;
            --primary-hover: #FF69B4;
            --secondary-color: #5c6ac4;
            --text-color: white;
            --light-text: #555;
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
            color: var(--text-color);
            background-color: var(--light-bg);
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            background-color: white;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .tel {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tel img {
            width: 20px;
            height: 20px;
        }

        .tel a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .tel a:hover {
            color: var(--primary-color);
        }

        .profile-container {
            position: relative;
            display: inline-block;
            margin-left: 20px
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            object-fit: cover;
            border: 2px solid var(--primary-color);
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
            color: pink;
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

        /* Navigation Styles */
        nav {
          z-index: 9999;
          top:0;
          position: fixed;
            background-color: #FFC0CB;
            padding: 10px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav img {
            height: 60px;
        }

        .link {
            display: flex;
            gap: 20px;
        }

        .link a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .link a:hover {
          filter: brightness(0.5);
        }

        .link a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: var(--transition);
        }

        .link a:hover::after {
            width: 100%;
        }

        /* Search Bar */
        .search {
            max-width: 500px;
            margin: auto;
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
            color: var(--light-text);
            font-size: 20px;
        }

        /* Main Content */
        h1 {
            text-align: center;
            margin: 30px 0;
            margin-left: 60px;
            color: white;
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
            color: white;
            padding: 15px;
            font-size: 20px;
            text-align: center;
        }

        .pack-description {
            padding: 15px;
            color: var(--light-text);
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
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 5px;
            margin: 15px;
            text-align: center;
            transition: var(--transition);
            font-weight: 500;
        }

        .btn:hover {
            background-color: var(--primary-hover);
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
            color: white;
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
            color: var(--text-color);
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
            color: white;
            padding: 10px 20px;
            margin: 15px 5px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: 500;
            transition: var(--transition);
        }

        .modal button:hover {
            background-color: var(--primary-hover);
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
            header, nav {
                flex-direction: column;
                padding: 10px;
            }
            
            .link {
                margin-top: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .tel {
                margin-bottom: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .profile-container {
                margin-top: 15px;
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
    <!-- Navigation -->
    <nav style="width: 100%">
        <div class="tel">
            <i class="fas fa-phone-alt"></i>
            <a href="tel:+21692000500"> +216 92 000 500 </a>
            <i class="fas fa-phone-alt"></i>
            <a href="tel:+21692500200"> +216 92 500 200</a>
        </div>

            <!-- Search Bar -->
    <div class="search">
        <label>
            <input type="text" id="live_search12" placeholder="Rechercher un pack...">
            <i class="fas fa-search"></i>
        </label>
    </div>

        <div class="link">
            <a href="index.html">Home</a>
            <a href="pack.php" class="active">Packs</a>
            <a href="">Sponsors</a>
            <a href="">Reclamation</a>
            <a href="javascript:void(0);" onclick="openReservationsModal()">Mes Réservations</a>
        </div>
        <div class="profile-container">
            <img src="<?php echo $user['photo']; ?>" alt="Profile" class="profile-img" id="profileIcon">
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="update.php"><i class="fas fa-user"></i> Profile</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <span style="margin: 40px auto;" />
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
                <a href="javascript:void(0);" class="btn" onclick="openModal(<?= htmlspecialchars($pack['id']); ?>, '<?= htmlspecialchars($pack['titre']); ?>', 'TND <?= htmlspecialchars($pack['prix']); ?>', '<?= htmlspecialchars($pack['description']); ?>')">
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

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Confirmer la réservation</h2>
            <p>Êtes-vous sûr de vouloir réserver ce pack ?</p>
            <p><strong>Titre du pack :</strong> <span id="packTitle"></span></p>
            <p><strong>Description :</strong> <span id="packDescription"></span></p>
            <p><strong>Prix :</strong> <span id="packPrice"></span></p>
            <button onclick="submitReservation()"><i class="fas fa-check"></i> Confirmer</button>
            <button onclick="closeModal()"><i class="fas fa-times"></i> Annuler</button>
        </div>
    </div>

    <!-- Reservations Modal -->
    <div id="reservationsModal" class="modal">
        <div class="modal-content" style="width: 600px; max-width: 90%;">
            <span class="close-btn" onclick="closeReservationsModal()">&times;</span>
            <h2>Mes Réservations</h2>
            <div id="reservationsList">
                <!-- Reservations will be displayed here -->
                <p>Chargement de vos réservations...</p>
            </div>
        </div>
    </div>

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