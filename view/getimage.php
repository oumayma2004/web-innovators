<?php
require_once '../config.php';
$db = config::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_e'];
    // récupérer les autres champs ici...

    // Vérifier que l'image est bien téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // Lire le fichier image
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

        // Préparer l'insertion dans la base de données
        $stmt = $db->prepare("INSERT INTO gestion_event (nom_e, image) VALUES (:nom, :image)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->execute();

        echo "Événement ajouté avec image !";
    } else {
        echo "Erreur d'upload de l'image.";
    }
}
?>
