<?php
require_once '../config.php';
$db = config::getConnexion();

// Check if ID is passed
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de l'événement non valide.");
}

$id_event = (int) $_GET['id'];

// Fetch event details for reservation
$stmt = $db->prepare("SELECT * FROM gestion_event WHERE id_event = ?");
$stmt->execute([$id_event]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Événement non trouvé.");
}

// Handle form submission for reservation
$reservation_success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nbr = $_POST['nbr'];
    $total_price = $event['prix_e'] * $nbr; // Calculate total price
    $date_res = date('Y-m-d H:i:s'); // Get current date and time

    // Insert reservation into the database
    $stmt = $db->prepare("INSERT INTO reservation (id_event, nbr, total_price, status, date_res) VALUES (?, ?, ?, 'reserved', ?)");
    $stmt->execute([$id_event, $nbr, $total_price, $date_res]);

    // Set reservation success flag
    $reservation_success = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réservation pour <?= htmlspecialchars($event['nom_e']) ?></title>
  <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('../uploads/<?= htmlspecialchars($event['image']) ?>') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 0;
        }

        h2 {
            color: #fff;
            text-align: center;
            padding-top: 30px;
            position: relative;
            z-index: 1;
        }

        form, .confirmation-message {
            background-color: rgba(255, 255, 255, 0.95);
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
        }

        label {
            font-weight: bold;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="file"] {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        button {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: 0.3s ease;
        }

        button:hover {
            opacity: 0.9;
        }

        #imagePreview {
            display: none;
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 15px;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .confirmation-message h3 {
            color: #2c3e50;
            font-size: 24px;
            text-align: center;
        }

        .confirmation-message p {
            color: #2c3e50;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Event Details Display -->
<h2>Réservation pour <?= htmlspecialchars($event['nom_e']) ?></h2>
<p style="text-align: center;"><strong>Prix par billet:</strong> <?= htmlspecialchars($event['prix_e']) ?> TND</p>

<?php if ($reservation_success): ?>
    <!-- Reservation Confirmation Message -->
    <div class="confirmation-message">
        <h3>Réservation réussie !</h3>
        <p><strong>Nom de l'événement:</strong> <?= htmlspecialchars($event['nom_e']) ?></p>
        <p><strong>Prix total:</strong> <?= $total_price ?> TND</p>
        <p><strong>Date de la réservation:</strong> <?= $date_res ?></p>
    </div>
<?php else: ?>
    <!-- Reservation Form -->
    <form method="POST" action="">
        <!-- Hidden input for id_event -->
        <input type="hidden" name="id_event" value="<?= $id_event ?>">

        <label for="nbr">Number of Tickets:</label>
        <input type="number" name="nbr" id="nbr" required min="1"><br>

        <button type="submit">Réserver</button>
    </form>
<?php endif; ?>

</body>
</html>
