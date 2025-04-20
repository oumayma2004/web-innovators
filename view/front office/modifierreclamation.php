<?php
require '../../controller/reclamationC.php'; // Chemin selon ton projet
require '../../model/Reclamation.php';

// Vérifier si l'ID est passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Créer une instance de la classe ReclamationC
    $reclamationC = new ReclamationC();
    
    // Récupérer la réclamation par ID
    $reclamation = $reclamationC->getReclamationById($id);

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $date_creation = $_POST['date_creation'];
        $etat = $_POST['etat'];
        $type_reclamation = $_POST['type_reclamation'];
        $evenement_concerne = $_POST['evenement_concerne'];
        $description = $_POST['description'];

        // Mettre à jour la réclamation avec les nouvelles données
        $reclamation->setNom($nom);
        $reclamation->setEmail($email);
        $reclamation->setTel($tel);
        $reclamation->setDateCreation($date_creation);
        $reclamation->setEtat($etat);
        $reclamation->setTypeReclamation($type_reclamation);
        $reclamation->setEvenementConcerne($evenement_concerne);
        $reclamation->setDescription($description);

        // Enregistrer la réclamation modifiée dans la base de données
        $reclamationC->modifierReclamation($reclamation, $id);
        header('Location: listreclamation.php'); // Rediriger vers la liste des réclamations après modification
        exit();
    }
} else {
    echo "ID manquant.";
    exit;
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Réclamation</title>
    <link rel="stylesheet" href="style1.css">
    <script src="assets/js/validforme.js" defer></script> <!-- Inclure le fichier JS ici -->
</head>
<body>
    <header>
        <div id="bar">
            <a href="index.html"> <img id="logo" src="assets/logosite-removebg-preview.png" alt=""></a>
            <div id="RECLAMER"><a href="index.html"><label>Home</label></a></div>
        </div>
    </header>

    <main class="container">
        <h1>Modifier une Réclamation</h1>

        <form action="modifierreclamation.php?id=<?php echo $id; ?>" method="POST" class="reclamation-form" onsubmit="return validateForm(event)">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($reclamation->getNom()); ?>"  />

            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reclamation->getEmail()); ?>"  />

            <label for="tel">Téléphone :</label>
            <input type="text" id="tel" name="tel" value="<?php echo htmlspecialchars($reclamation->getTel()); ?>"  />

            <label for="date_creation">Date :</label>
            <input type="date" id="date_creation" name="date_creation" value="<?php echo htmlspecialchars($reclamation->getDateCreation()); ?>"   />

            <label for="etat">État de la réclamation :</label>
            <select id="etat" name="etat"  >
                <option value="en attente" <?php echo ($reclamation->getEtat() == 'en attente') ? 'selected' : ''; ?>>En attente</option>
                <option value="traitée" <?php echo ($reclamation->getEtat() == 'traitée') ? 'selected' : ''; ?>>Traitée</option>
                <option value="rejetée" <?php echo ($reclamation->getEtat() == 'rejetée') ? 'selected' : ''; ?>>Rejetée</option>
            </select>

            <label for="type_reclamation">Type de réclamation :</label>
            <select id="type_reclamation" name="type_reclamation"  >
                <option value="retard" <?php echo ($reclamation->getTypeReclamation() == 'retard') ? 'selected' : ''; ?>>Retard ou annulation</option>
                <option value="accueil" <?php echo ($reclamation->getTypeReclamation() == 'accueil') ? 'selected' : ''; ?>>Problème d’accueil</option>
                <option value="remboursement" <?php echo ($reclamation->getTypeReclamation() == 'remboursement') ? 'selected' : ''; ?>>Demande de remboursement</option>
                <option value="autre" <?php echo ($reclamation->getTypeReclamation() == 'autre') ? 'selected' : ''; ?>>Autre</option>
            </select>

            <label for="evenement_concerne">Événement concerné :</label>
            <select id="evenement_concerne" name="evenement_concerne"  >
                <option value="ete2025" <?php echo ($reclamation->getEvenementConcerne() == 'ete2025') ? 'selected' : ''; ?>>Festival d'été 2025</option>
                <option value="noel2024" <?php echo ($reclamation->getEvenementConcerne() == 'noel2024') ? 'selected' : ''; ?>>Marché de Noël 2024</option>
                <option value="printemps2025" <?php echo ($reclamation->getEvenementConcerne() == 'printemps2025') ? 'selected' : ''; ?>>Salon Printemps 2025</option>
            </select>

            <label for="description">Description de la réclamation :</label>
            <textarea id="description" name="description" rows="5"  ><?php echo htmlspecialchars($reclamation->getDescription()); ?></textarea>

            <button type="submit">Modifier la réclamation</button>
        </form>
    </main>

    <br><br><br><br><br><br>

    <footer>
        <div class="FO">
            <p class="p">Besoin d'aide ? 71717171</p>
        </div>
        <div class="FO">
            <p class="p">Meilleur prix GARANTI</p>
        </div>
        <div class="FO">
            <p class="p">Paiement 100% sécurisé</p>
        </div>
        <div class="FO">
            <p class="p">+200000 clients satisfaits</p>
        </div>

        <div class="FO">
            <p class="p">Suivez-nous :</p>
            <a href="http://www.facebook.com"><img class="social" src="assets/fb.png" alt=""></a>
            <img class="social" src="assets/instagram.png" alt=""><br>
            <img class="social" src="assets/twitter.png" alt="">
            <img class="social" src="assets/youtube.png" alt="">
        </div>
    </footer>
</body>
</html>
