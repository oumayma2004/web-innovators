<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config.php';
    $db = config::getConnexion();

    // Vérifier l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageType = $_FILES['image']['type'];
        $allowedTypes = ['image/jpeg', 'image/png'];

        if (!in_array($imageType, $allowedTypes)) {
            echo "Seuls les fichiers JPG et PNG sont autorisés.";
            exit;
        }

        // Créer un nom unique
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $imagePath = __DIR__ . '/uploads/' . $imageName;

        // Déplacer le fichier vers le dossier uploads/
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            echo "Erreur lors du déplacement de l'image.";
            exit;
        }

    } else {
        echo "Erreur lors de l'upload de l'image : " . $_FILES['image']['error'];
        exit;
    }

    // Nettoyer les autres données
    $nom_e = htmlspecialchars($_POST['nom_e']);
    $date_de_e = htmlspecialchars($_POST['date_de_e']);
    $date_f_e = htmlspecialchars($_POST['date_f_e']);
    $lieu_e = htmlspecialchars($_POST['lieu_e']);
    $prix_e = filter_var($_POST['prix_e'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $etat_e = $_POST['etat_e'];
    $category_e = htmlspecialchars($_POST['category_e']);
    $desc_e = htmlspecialchars($_POST['desc_e']);

    // Données à insérer
    $data = [
        ':nom_e' => $nom_e,
        ':date_de_e' => $date_de_e,
        ':date_f_e' => $date_f_e,
        ':lieu_e' => $lieu_e,
        ':prix_e' => $prix_e,
        ':etat_e' => $etat_e,
        ':category_e' => $category_e,
        ':desc_e' => $desc_e,
        ':image' => $imageName // Juste le nom de fichier
    ];

    $sql = "INSERT INTO gestion_event 
        (nom_e, date_de_e, date_f_e, lieu_e, prix_e, etat_e, category_e, desc_e, image) 
        VALUES 
        (:nom_e, :date_de_e, :date_f_e, :lieu_e, :prix_e, :etat_e, :category_e, :desc_e, :image)";
    
    $stmt = $db->prepare($sql);

    if ($stmt->execute($data)) {
        echo "Événement ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'événement.";
    }
}
?>
