<?php
session_start();
require_once '../../config.php';
$db = config::getConnexion();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("ID non valide.");
$id_event = (int) $_GET['id'];

$stmt = $db->prepare("SELECT * FROM gestion_event WHERE id_event = ?");
$stmt->execute([$id_event]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$event) die("Événement non trouvé.");
$available_tickets = $event['nbr_e']; // Available tickets for the event

if (!isset($_GET['nbr']) || !is_numeric($_GET['nbr']) || $_GET['nbr'] <= 0) die("Billets invalides.");
$nbr = (int) $_GET['nbr'];

// Check if requested tickets exceed available tickets
if ($nbr > $available_tickets) {
    // Update event status to "sold out"
    $stmt = $db->prepare("UPDATE gestion_event SET etat_e = 'Sold Out' WHERE id_event = ?");
    $stmt->execute([$id_event]);

    // Disable the reservation button
    $sold_out = true;
} else {
    $sold_out = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_number = $_POST['card_number'];
    $card_name = $_POST['card_name'];
    $exp_date = $_POST['exp_date'];
    $cvv = $_POST['cvv'];
    $email = $_POST['email'];

    if (!empty($card_number) && !empty($card_name) && !empty($exp_date) && !empty($cvv) && !empty($email)) {
        $total_price = $event['prix_e'] * $nbr;
        $date_res = date('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO reservation (id_event, nbr, total_price, status, date_res) VALUES (?, ?, ?, 'reserved', ?)");
        $stmt->execute([$id_event, $nbr, $total_price, $date_res]);
        $reservation_id = $db->lastInsertId();

        $qr_data = urlencode("Réservation #$reservation_id\nÉvénement: {$event['nom_e']}\nTotal: $total_price TND\nDate: $date_res");
        $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=$qr_data";

        $_SESSION['reservation_success'] = [
            'nom_e' => $event['nom_e'],
            'total' => $total_price,
            'date' => $date_res,
            'qr' => $qr_code_url,
            'email' => $email
        ];

        header("Location: add_reservation_e.php?id=$id_event&nbr=$nbr&success=1");
        exit;
    }
}

$reservation_success = isset($_GET['success']) && $_GET['success'] == 1 && isset($_SESSION['reservation_success']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réservation - <?= htmlspecialchars($event['nom_e']) ?></title>
  <link rel="icon" href="../../assets/logo-removebg-preview.png" style="border-radius: 50%;" />
  <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('../../uploads/<?= htmlspecialchars($event['image']) ?>') no-repeat center center fixed;
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
        h2, h3 {
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
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background-color: #f06292;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .confirmation-message h3, .confirmation-message p {
            text-align: center;
            color: #2c3e50;
        }
        .confirmation-message img {
            display: block;
            margin: 20px auto;
            max-width: 250px;
        }
        .summary {
            text-align: center;
            color: #fff;
            font-size: 18px;
            margin-top: 15px;
        }
        .reserve-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f06292;
            color: white;
            padding: 12px;
            font-size: 18px;
            text-decoration: none;
            border-radius: 8px;
            width: fit-content;
            margin: 20px auto;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
  </style>
</head>
<body>

<h2>Réservation pour <?= htmlspecialchars($event['nom_e']) ?></h2>
<p class="summary"><strong>Prix par billet:</strong> <?= htmlspecialchars($event['prix_e']) ?> TND</p>
<p class="summary"><strong>Nombre de billets:</strong> <?= $nbr ?></p>
<p class="summary"><strong>Total:</strong> <?= $nbr * $event['prix_e'] ?> TND</p>

<?php if (!$reservation_success): ?>
<form method="POST">
    <h3>Paiement</h3>
    <label>Numéro de carte</label>
    <input type="text" name="card_number" placeholder="1234 5678 9012 3456">
    <label>Nom du titulaire</label>
    <input type="text" name="card_name" placeholder="Nom Prénom">
    <label>Date d’expiration (MM/AA)</label>
    <input type="text" name="exp_date" placeholder="MM/AA">
    <label>Code CVV</label>
    <input type="text" name="cvv" placeholder="123">
    <label>Adresse Email</label>
    <input type="text" name="email" placeholder="exemple@mail.com">
    <button type="submit">Payer & Réserver</button>
</form>

<?php else: 
$details = $_SESSION['reservation_success'];
unset($_SESSION['reservation_success']);
?>
<div class="confirmation-message">
    <h3>Réservation réussie !</h3>
    <p><strong>Nom de l'événement:</strong> <?= htmlspecialchars($details['nom_e']) ?></p>
    <p><strong>Prix total:</strong> <?= $details['total'] ?> TND</p>
    <p><strong>Date de la réservation:</strong> <?= $details['date'] ?></p>
    <p>Scannez ce QR code pour vos informations :</p>
    <img id="qr-img" src="<?= $details['qr'] ?>" alt="QR Code">
    <button id="download-pdf" class="reserve-btn">Télécharger le PDF</button>
    <a href="event.html" class="reserve-btn">Retour à l'accueil</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    (function() {
        emailjs.init("emtdO7278-ioftF43");
    })();

    window.onload = function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const nom_event = "<?= htmlspecialchars($details['nom_e']) ?>";
        const total = "<?= $details['total'] ?> TND";
        const date = "<?= $details['date'] ?>";
        const qr = "<?= $details['qr'] ?>";
        const email = "<?= $details['email'] ?>";

        doc.setFontSize(18);
        doc.text("Confirmation de Réservation", 20, 20);
        doc.setFontSize(12);
        doc.text(`Événement : ${nom_event}`, 20, 40);
        doc.text(`Date : ${date}`, 20, 50);
        doc.text(`Total : ${total}`, 20, 60);
        doc.text(`Email : ${email}`, 20, 70);
        doc.text("Merci pour votre réservation.", 20, 80);

        const qrImage = new Image();
        qrImage.crossOrigin = "Anonymous";
        qrImage.src = qr;

        qrImage.onload = function () {
            doc.addImage(qrImage, "PNG", 20, 90, 50, 50);

            const pdfBlob = doc.output("blob");
            const reader = new FileReader();
            reader.onloadend = function () {
                const base64pdf = reader.result.split(',')[1];

                emailjs.send("service_zmbayft", "template_64k5hai", {
                    email: email,
                    nom_event: nom_event,
                    total: total,
                    date: date,
                    attachment: base64pdf,
                    filename: "reservation_confirmation.pdf"
                }).then(() => {
                    console.log("Email envoyé avec PDF !");
                }, (err) => {
                    console.error("Erreur EmailJS :", err);
                });
            };
            reader.readAsDataURL(pdfBlob);

            document.getElementById("download-pdf").addEventListener("click", function () {
                doc.save("reservation_confirmation.pdf");
            });
        };
    };
</script>

<?php endif; ?>
</body>
</html>
