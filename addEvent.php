<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config.php';
    $db = config::getConnexion();

    // Vérifier si l'image est bien reçue
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "Erreur lors de l'upload de l'image : " . $_FILES['image']['error'];
        exit;
    }

    // Vérification du type d'image
    $imageType = $_FILES['image']['type'];
    $allowedTypes = ['image/jpeg', 'image/png'];

    if (!in_array($imageType, $allowedTypes)) {
        echo "Seuls les fichiers JPG et PNG sont autorisés.";
        exit;
    }

    // Générer un nom unique pour l'image
    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
    $uploadDir = __DIR__ . '/uploads/';
    $imagePath = $uploadDir . $imageName;

    // Créer le dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        echo "Erreur lors du déplacement de l'image.";
        exit;
    }

    // Nettoyage des données
    $nom_e = htmlspecialchars($_POST['nom_e']);
    $date_de_e = htmlspecialchars($_POST['date_de_e']);
    $date_f_e = htmlspecialchars($_POST['date_f_e']);
    $lieu_e = htmlspecialchars($_POST['lieu_e']);
    $prix_e = filter_var($_POST['prix_e'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $nbr_e = filter_var($_POST['nbr_e'], FILTER_SANITIZE_NUMBER_INT);
    $category_e = htmlspecialchars($_POST['category_e']);
    $desc_e = htmlspecialchars($_POST['desc_e']);

    // Préparer les données
    $data = [
        ':nom_e' => $nom_e,
        ':date_de_e' => $date_de_e,
        ':date_f_e' => $date_f_e,
        ':lieu_e' => $lieu_e,
        ':prix_e' => $prix_e,
        ':nbr_e' => $nbr_e,
        ':category_e' => $category_e,
        ':desc_e' => $desc_e,
        ':image' => $imageName
    ];

    // Requête d'insertion
    $sql = "INSERT INTO gestion_event 
        (nom_e, date_de_e, date_f_e, lieu_e, prix_e, nbr_e, etat_e, category_e, desc_e, image) 
        VALUES 
        (:nom_e, :date_de_e, :date_f_e, :lieu_e, :prix_e, :nbr_e, 'in stock', :category_e, :desc_e, :image)";

    $stmt = $db->prepare($sql);

    if ($stmt->execute($data)) {
        // Redirection vers la page de gestion des événements
        header('Location: ./pages/tables.php?success=1');
        exit;
    } else {
        echo "Erreur lors de l'ajout de l'événement.";
    }
}
?>
