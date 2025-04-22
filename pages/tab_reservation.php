<?php
require_once '../config.php';
$db = config::getConnexion();

// Handle deletion of reservation
if (isset($_GET['delete_reservation']) && is_numeric($_GET['delete_reservation'])) {
    $id_reservation = (int) $_GET['delete_reservation'];

    // Delete reservation
    $stmt = $db->prepare("DELETE FROM reservation WHERE id_res = ?");
    $stmt->execute([$id_reservation]);

    header("Location: tab_reservation.php"); // Redirect back to panier page after deletion
    exit;
}

// Handle reservation modification
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_reservation'])) {
    $id_reservation = $_POST['id_res']; // Correcting to id_res
    $nbr = $_POST['nbr'];
    $total_price = $_POST['total_price'];

    // Update reservation details
    $stmt = $db->prepare("UPDATE reservation SET nbr = ?, total_price = ? WHERE id_res = ?");
    $stmt->execute([$nbr, $total_price, $id_reservation]);

    header("Location: tab_reservation.php"); // Redirect back to panier page after modification
    exit;
}

// Fetch all reservations
$stmt = $db->prepare("SELECT r.*, e.nom_e, e.image FROM reservation r
                      JOIN gestion_event e ON r.id_event = e.id_event");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="../assets/logo.jpg" class="navbar-brand-img" width="95px" alt="main_logo">
        
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="../pages/tables.php">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">Tables</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/tab_reservation.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">reservation</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Virtual Reality</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">RTL</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/profile.html">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-up.html">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
      </div>
    </div>
  </aside>
  <title>Panier - Mes Réservations</title>
  <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            position: relative;
            margin-left: 140px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            padding-top: 30px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f06292;
            color: white;
        }

        tr:nth-child(even) {
            background-color:rgb(230, 202, 202);
        }

        tr:hover {
            background-color:rgb(252, 214, 228);
            cursor: pointer;
        }

        .event-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .total-reservations {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        button {
            padding: 8px 15px;
            background-color: #f06292;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #f06292;
        }

        .edit-form {
            display: none;
            margin: 20px auto;
            width: 80%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .edit-form button {
            background-color: #f06292;
            border: none;
        }

        .edit-form button:hover {
            background-color: #f06292;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
  </style>
</head>
<body>

<h2>Mes Réservations</h2>

<?php if (empty($reservations)): ?>
    <p style="text-align: center; font-size: 18px;">Aucune réservation trouvée.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Image de l'Événement</th>
                <th>Nom de l'Événement</th>
                <th>Nombre de Billets</th>
                <th>Prix Total (TND)</th>
                <th>Status</th>
                <th>Date de Réservation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td>
                        <img src="../uploads/<?= htmlspecialchars($reservation['image']) ?>" alt="Event Image" class="event-image">
                    </td>
                    <td><?= htmlspecialchars($reservation['nom_e']) ?></td>
                    <td><?= htmlspecialchars($reservation['nbr']) ?></td>
                    <td><?= htmlspecialchars($reservation['total_price']) ?> TND</td>
                    <td><?= htmlspecialchars($reservation['status']) ?></td>
                    <td><?= htmlspecialchars($reservation['date_res']) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="?delete_reservation=<?= $reservation['id_res'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">
                                <button>Supprimer</button>
                            </a>
                            <a href="javascript:void(0);" onclick="showEditForm(<?= $reservation['id_res'] ?>, <?= $reservation['nbr'] ?>, <?= $reservation['total_price'] ?>)">
                                <button>Modifier</button>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="total-reservations">
    <?php if (!empty($reservations)): ?>
        <p>Total des réservations: <?= count($reservations) ?></p>
    <?php endif; ?>
</div>

<!-- Edit reservation form -->
<div class="edit-form" id="editForm">
    <h3>Modifier la réservation</h3>
    <form method="POST">
        <input type="hidden" name="id_res" id="editIdReservation">
        <label for="nbr">Nombre de Billets:</label>
        <input type="number" name="nbr" id="editNbr" required min="1">
        <label for="total_price">Prix Total:</label>
        <input type="number" name="total_price" id="editTotalPrice" required readonly>
        <button type="submit" name="update_reservation">Mettre à jour</button>
    </form>
</div>

<script>
    function showEditForm(id, nbr, total_price) {
        document.getElementById("editForm").style.display = "block";
        document.getElementById("editIdReservation").value = id;
        document.getElementById("editNbr").value = nbr;
        document.getElementById("editTotalPrice").value = total_price;

        // Calculate total price based on number of tickets
        document.getElementById("editNbr").addEventListener("input", function() {
            document.getElementById("editTotalPrice").value = this.value * (total_price / nbr);
        });
    }
</script>

</body>
</html>
