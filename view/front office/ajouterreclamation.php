<?php
require '../../controller/reclamationC.php'; // Chemin selon ton projet
require '../../model/Reclamation.php';

$reclamationC = new ReclamationC();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reclamation = new Reclamation(
        null, // ID = auto-incrémenté
        $_POST['nom'],
        $_POST['email'],
        $_POST['tel'],
        $_POST['date_creation'],
        $_POST['etat'],
        $_POST['type_reclamation'],
        $_POST['evenement_concerne'],
        $_POST['description']
    );

    $reclamationC->ajouterReclamation($reclamation);
    header('Location: listreclamation.php'); // rediriger vers la liste
    exit();
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamation - Événement</title>
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
        <h1>Envoyer une Réclamation</h1>

        <form action="ajouterreclamation.php" method="POST" class="reclamation-form" onsubmit="return validateForm(event)">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom"  />

            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email"  />

            <label for="tel">Téléphone :</label>
            <input type="text" id="tel" name="tel"  />

            <label for="date_creation">Date :</label>
            <input type="date" id="date_creation" name="date_creation"  />

            <label for="etat">État de la réclamation :</label>
            <select id="etat" name="etat" >
                <option value="en attente">En attente</option>
                <option value="traitée">Traitée</option>
                <option value="rejetée">Rejetée</option>
            </select>

            <label for="type_reclamation">Type de réclamation :</label>
            <select id="type_reclamation" name="type_reclamation" >
                <option value="retard">Retard ou annulation</option>
                <option value="accueil">Problème d’accueil</option>
                <option value="remboursement">Demande de remboursement</option>
                <option value="autre">Autre</option>
            </select>

            <label for="evenement_concerne">Événement concerné :</label>
            <select id="evenement_concerne" name="evenement_concerne" >
                <option value="">-- Sélectionnez un événement --</option>
                <option value="ete2025">Festival d'été 2025</option>
                <option value="noel2024">Marché de Noël 2024</option>
                <option value="printemps2025">Salon Printemps 2025</option>
            </select>

            <label for="description">Description de la réclamation :</label>
            <textarea id="description" name="description" rows="5" ></textarea>

            <button type="submit">Envoyer la réclamation</button>
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
