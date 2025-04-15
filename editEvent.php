<?php
require_once '../config.php';
$db = config::getConnexion();

if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM gestion_event WHERE id_event = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "Événement introuvable.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE gestion_event SET 
                nom_e = :nom_e, 
                date_de_e = :date_de_e,
                date_f_e = :date_f_e,
                lieu_e = :lieu_e,
                prix_e = :prix_e,
                etat_e = :etat_e,
                category_e = :category_e,
                desc_e = :desc_e";

    $params = [
        ':id_event' => $_POST['id_event'],
        ':nom_e' => $_POST['nom_e'],
        ':date_de_e' => $_POST['date_de_e'],
        ':date_f_e' => $_POST['date_f_e'],
        ':lieu_e' => $_POST['lieu_e'],
        ':prix_e' => $_POST['prix_e'],
        ':etat_e' => $_POST['etat_e'],
        ':category_e' => $_POST['category_e'],
        ':desc_e' => $_POST['desc_e']
    ];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $imageType = $_FILES['image']['type'];

        if (!in_array($imageType, $allowedTypes)) {
            echo "Seuls les fichiers JPG et PNG sont autorisés.";
            exit;
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid('event_', true) . '.' . $ext;
        $uploadPath = __DIR__ . '/../uploads/' . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $sql .= ", image = :image";
            $params[':image'] = $imageName;
        } else {
            echo "Erreur lors de l'upload de la nouvelle image.";
            exit;
        }
    }

    $sql .= " WHERE id_event = :id_event";
    $stmt = $db->prepare($sql);

    if ($stmt->execute($params)) {
        echo "✅ Événement mis à jour avec succès.<br><a href='../pages/tables.php'>← Retour</a>";
    } else {
        echo "❌ Erreur lors de la mise à jour.";
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'Événement</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('../assets/festevio.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* dark overlay */
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

        form {
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
    </style>
</head>
<body>

<h2>Modifier l'événement</h2>

<form id="eventForm" action="editEvent.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_event" value="<?= htmlspecialchars($event['id_event']) ?>">

    <label>Nom de l'événement :</label>
    <input type="text" name="nom_e" value="<?= htmlspecialchars($event['nom_e']) ?>" required>

    <label>Date début :</label>
    <input type="datetime-local" name="date_de_e" value="<?= htmlspecialchars($event['date_de_e']) ?>" required>

    <label>Date fin :</label>
    <input type="datetime-local" name="date_f_e" value="<?= htmlspecialchars($event['date_f_e']) ?>" required>

    <label>Lieu :</label>
    <input type="text" name="lieu_e" value="<?= htmlspecialchars($event['lieu_e']) ?>" required>

    <label>Prix :</label>
    <input type="number" step="0.01" name="prix_e" value="<?= htmlspecialchars($event['prix_e']) ?>" required>

    <label>État :</label>
    <select name="etat_e" required>
        <option value="In stock" <?= $event['etat_e'] == 'In stock' ? 'selected' : '' ?>>In stock</option>
        <option value="Sold out" <?= $event['etat_e'] == 'Sold out' ? 'selected' : '' ?>>Sold out</option>
    </select>

    <label>Catégorie :</label>
    <input type="text" name="category_e" value="<?= htmlspecialchars($event['category_e']) ?>" required>

    <label>Description :</label>
    <textarea name="desc_e" rows="4" required><?= htmlspecialchars($event['desc_e']) ?></textarea>

    <label>Image actuelle :</label><br>
    <?php if (!empty($event['image'])): ?>
        <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" width="100"><br>
    <?php else: ?>
        <em>Aucune image actuelle</em><br>
    <?php endif; ?>

    <label>Nouvelle image (facultatif) :</label><br>
    <input type="file" name="image" id="imageInput" accept="image/*"><br><br>

    <img id="imagePreview" alt="Image Preview" />

    <button type="submit">Enregistrer</button>
</form>

<script>
    // Image preview
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.style.display = 'block';
            imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // JS Form validation
    document.getElementById("eventForm").addEventListener("submit", function(e) {
        const nom = document.querySelector('[name="nom_e"]');
        const dateDebut = document.querySelector('[name="date_de_e"]');
        const dateFin = document.querySelector('[name="date_f_e"]');
        const lieu = document.querySelector('[name="lieu_e"]');
        const prix = document.querySelector('[name="prix_e"]');
        const etat = document.querySelector('[name="etat_e"]');
        const category = document.querySelector('[name="category_e"]');
        const desc = document.querySelector('[name="desc_e"]');

        let isValid = true;
        let message = "";

        // Check all required fields
        if (
            !nom.value.trim() || !dateDebut.value || !dateFin.value ||
            !lieu.value.trim() || !prix.value || !etat.value || !category.value.trim() || !desc.value.trim()
        ) {
            isValid = false;
            message += "⚠️ Tous les champs doivent être remplis.\n";
        }

        // Alphabetic check for event name
        if (!/^[a-zA-ZÀ-ÿ\s\-']+$/.test(nom.value)) {
            isValid = false;
            message += "❌ Le nom de l'événement doit contenir uniquement des lettres.\n";
        }

        // Date check: end date must be after start date
        if (new Date(dateDebut.value) >= new Date(dateFin.value)) {
            isValid = false;
            message += "📅 La date de fin doit être après la date de début.\n";
        }

        // Positive number check
        if (parseFloat(prix.value) <= 0) {
            isValid = false;
            message += "💸 Le prix doit être un nombre positif.\n";
        }

        if (!isValid) {
            e.preventDefault();
            alert(message);
        }
    });
</script>

</body>
</html>
