<?php
require_once '../config.php';
$db = config::getConnexion();

// Check if ID is passed
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de l'événement non valide.");
}

$id = (int) $_GET['id'];

// Fetch event from DB
$stmt = $db->prepare("SELECT * FROM gestion_event WHERE id_event = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Événement non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($event['nom_e']) ?></title>
  <style>
    /* General body and background */
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }

    /* Hero section with event image */
    .hero-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        position: relative;
        top: 0;
    }

    /* Content container */
    .event-container {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      z-index: 2;
    }

    /* Event title and description */
    .event-container h1 {
      font-size: 36px;
      margin-bottom: 20px;
      color: #333;
      font-weight: bold;
    }

    .info p {
      font-size: 18px;
      line-height: 1.6;
      margin: 8px 0;
      color: #555;
    }

    .info p strong {
      color: #333;
    }

    .price-tag {
      font-size: 22px;
      font-weight: bold;
      color: #ff5733;
      margin-top: 15px;
    }

    /* Scrollable content below the image */
    .info {
      background: rgba(255, 255, 255, 0.9);
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Parent container for left and right content */
    .info-content {
      display: flex;
      justify-content: space-between; /* Distribute items */
      align-items: flex-start;
      margin-top: 20px;
    }

    /* Left content (prix and description) */
    .left-content {
      width: 60%; /* You can adjust this width as needed */
    }

    /* Right content (status button) */
    .right-content {
      width: 35%; /* Adjust based on your layout needs */
      text-align: right;
    }

    /* Status button styles */
    /* Status button styles */
.status-btn {
  display: inline-block;
  padding: 10px 20px;
  font-size: 18px;
  color: white; /* Ensure the text is white */
  border-radius: 8px;
  text-align: center;
  cursor: pointer;
  text-decoration: none;
  margin-right: 0; /* Reset any margin right that might have been set elsewhere */
  background-color: inherit; /* Ensure background-color is inherited */
  font-weight: bold; /* Optional: Make the text bold for better readability */
}

/* Style for 'In stock' status (green) */
.status-instock {
  background-color: green !important; /* Ensure this is not overridden */
}

/* Style for 'Sold out' status (red) */
.status-soldout {
  background-color: red !important; /* Ensure this is not overridden */
}


    .header_info {
      display: flex;
      justify-content: space-around;
      align-items: center;
      background-color: #fff;
      padding: 15px 20px;
      margin-bottom: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      font-size: 16px;
      color: #333;
      gap: 20px;
      flex-wrap: wrap;
    }

    .header_info div {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .header_info img {
      width: 25px;
      height: 25px;
      object-fit: contain;
    }

    .img_center {
      width: 600px;
      display: block;
      margin: 20px auto;
      border-radius: 12px;
    }

    .info h1 {
      text-align: center;
      font-size: 32px;
      margin-bottom: 20px;
    }

    /* Reserve Now button */
    .reserve-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background-color: #ff5733;
      color: white;
      padding: 12px;
      font-size: 18px;
      text-decoration: none;
      border-radius: 8px;
      width: fit-content;
      margin: 20px auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .reserve-btn img {
      width: 24px;
      height: 24px;
    }

  </style>
</head>
<body>

<!-- Hero image section -->
<img class="hero-image" src="../uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['nom_e']) ?>">

<!-- Event details container -->
<div class="event-container">

    <div class="header_info">
        <div><img src="../assets/amphitheatre.png" alt="lieu"> <?= htmlspecialchars($event['lieu_e']) ?></div>
        <div><img src="../assets/calendrier (1).png" alt="date"> <?= date('d/m/Y', strtotime($event['date_de_e'])) ?></div>
        <div><img src="../assets/lhorloge.png" alt="heure"> <?= date('H:i', strtotime($event['date_de_e'])) ?></div>
    </div>

    <div class="info">
        <h1><?= htmlspecialchars($event['nom_e']) ?></h1>
        <img class="img_center" src="../uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['nom_e']) ?>">
        <div class="info-content">
            <!-- Left side content -->
            <div class="left-content">
                <p><strong>Catégorie:</strong> <?= htmlspecialchars($event['category_e']) ?></p>
                <p><strong>Prix:</strong> <?= $event['prix_e'] ? htmlspecialchars($event['prix_e']) . ' TND' : 'Gratuit' ?></p>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($event['description_e'] ?? 'Aucune description.')) ?></p>
            </div>
            
            <!-- Right side content (status button) -->
            <div class="right-content">
                <a class="status-btn <?= $event['etat_e'] === 'In stock' ? 'status-instock' : 'status-soldout' ?>">
                    <?= htmlspecialchars($event['etat_e']) ?>
                </a>
            </div>
        </div>

    </div>

    <a href="add_reservation.php?id=<?php echo $id; ?>" class="reserve-btn">
    <img src="../assets/billet.png" alt="billet">
    Réserver maintenant
    </a>

</div>

</body>
</html>
