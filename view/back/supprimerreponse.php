<?php

require '../../controller/reponseC.php'; 
=
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id']; 

    
    $reponseC = new ReponseC();

    
    $reponseC->supprimerReponse($id);

    // Rediriger vers la page d'affichage des réclamations après suppression
    header("Location: listreclamation.php");  // Remplace par la page qui affiche la liste des réclamations
    exit(); // Assurer qu'il n'y a pas de code après la redirection
} else {
    echo "ID de réclamation non spécifié.";
}
?>
