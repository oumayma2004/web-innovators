<?php
// Inclure la classe ReclamationC
require '../../controller/reponseC.php'; // Chemin selon ton projet

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id']; // Récupérer l'ID depuis l'URL

    // Créer une instance de la classe ReclamationC
    $reponseC = new ReponseC();

    // Appeler la méthode pour supprimer la réclamation
    $reponseC->supprimerReponse($id);

    // Rediriger vers la page d'affichage des réclamations après suppression
    header("Location: listreclamation.php");  // Remplace par la page qui affiche la liste des réclamations
    exit(); // Assurer qu'il n'y a pas de code après la redirection
} else {
    echo "ID de réclamation non spécifié.";
}
?>
