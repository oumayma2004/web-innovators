<?php
require_once '../config.php';
$db = config::getConnexion();

// Handle deletion of reservation
if (isset($_GET['delete_reservation']) && is_numeric($_GET['delete_reservation'])) {
    $id_reservation = (int) $_GET['delete_reservation'];

    // Delete reservation
    $stmt = $db->prepare("DELETE FROM reservation WHERE id_res = ?");
    $stmt->execute([$id_reservation]);

    header("Location: panier.php"); // Redirect back to panier page after deletion
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

    header("Location: panier.php"); // Redirect back to panier page after modification
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
  <title>Panier - Mes Réservations</title>
  <link rel="icon" href="assets/logo-removebg-preview.png" style="border-radius: 50%;" />
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
        .back-button {
            display: inline-block;
            text-align: center;
            text-decoration: none;
            background-color: #f06292;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: white;
            color: #f06292;
            border: 1px solid #f06292;
        }
  </style>
</head>
<body>
<a href="../index.html"><img src="../assets/logo-removebg-preview.png" alt="logo" width="90px" style="margin-left: 80%;" /></a>
<div class="back-button-container">
    <a href="../index.html" class="back-button">← Retour</a>
</div>

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
