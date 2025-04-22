<?php
require_once '../config.php';
$db = config::getConnexion();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de l'événement non valide.");
}

$id = (int) $_GET['id'];

$stmt = $db->prepare("SELECT * FROM gestion_event WHERE id_event = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Événement non trouvé.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer le nombre de billets (nbr)
    if (isset($_POST['nbr'])) {
        $nbr = (int) $_POST['nbr'];
    } else {
        die("Le nombre de billets est requis.");
    }

    // Insertion de la réservation dans la table 'reservation'
    $stmt = $db->prepare("INSERT INTO reservation (id_event, nbr) VALUES (?, ?)");
    $stmt->execute([$id, $nbr]);

    // Redirection ou message de succès
    header("Location: add_reservation.php?id=$id&nbr=$nbr");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($event['nom_e']) ?></title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }

    .hero-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        position: relative;
    }

    .event-container {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

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

    .price-tag {
      font-size: 22px;
      font-weight: bold;
      color: #ff5733;
      margin-top: 15px;
    }

    .info {
      background: rgba(255, 255, 255, 0.9);
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .info-content {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-top: 20px;
      gap: 30px;
      flex-wrap: wrap;
    }

    .left-content {
      width: 60%;
    }

    .right-content {
      width: 35%;
      text-align: right;
    }

    .status-btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 18px;
      color: white;
      border-radius: 8px;
      text-align: center;
      cursor: pointer;
      text-decoration: none;
      font-weight: bold;
    }

    .status-instock {
      background-color: green !important;
    }

    .status-soldout {
      background-color: red !important;
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

    /* Style champ billet */
    .ticket-quantity {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 5px;
      margin-top: 15px;
    }

    .ticket-quantity label {
      font-weight: bold;
      font-size: 16px;
      color: #333;
      text-align:right
    }

    .ticket-input {
      width: 100%;
      padding: 10px 15px;
      font-size: 16px;
      border: 2px solid #ddd;
      border-radius: 8px;
      transition: border-color 0.3s, box-shadow 0.3s;
      box-sizing: border-box;
    }

    .ticket-input:focus {
      border-color: #ff5733;
      outline: none;
      box-shadow: 0 0 5px rgba(255, 87, 51, 0.4);
    }
  </style>
</head>
<body>

<img class="hero-image" src="../uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['nom_e']) ?>">

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
            <div class="left-content">
                <p><strong>Catégorie:</strong> <?= htmlspecialchars($event['category_e']) ?></p>
                <p><strong>Prix:</strong> <?= $event['prix_e'] ? htmlspecialchars($event['prix_e']) . ' TND' : 'Gratuit' ?></p>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($event['description_e'] ?? 'Aucune description.')) ?></p>
            </div>

            <div class="right-content">
                <a class="status-btn <?= $event['etat_e'] === 'In stock' ? 'status-instock' : 'status-soldout' ?>">
                    <?= htmlspecialchars($event['etat_e']) ?>
                </a>
            </div>
            <form action="" method="POST" style="margin-top: 20px;">
                <div class="ticket-quantity">
                    <label for="nbr">Nombre de billets :</label>
                    <input type="number" name="nbr" id="nbr" class="ticket-input" required min="1" value="1">
                </div>

                <button type="submit" class="reserve-btn">
                    <img src="../assets/billet.png" alt="billet">
                    Réserver maintenant
                </button>
              </form>

</div>

</body>
</html>
