<?php
include_once '../../controller/reclamationC.php'; // Chemin selon ton projet

$reclamationC = new ReclamationC();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reclamation = new Reclamation(
        null, // ID = auto-incrémenté
        $_POST['nom'],
        $_POST['email'],
        $_POST['tel'],
        // On ne récupère plus date_creation ni etat
        // Valeurs par défaut définies dans la base de données
        $_POST['type_reclamation'],
        $_POST['evenement_concerne'],
        $_POST['description']
    );

    $reclamationC->ajouterReclamation($reclamation);
    header('Location: ajouterreclamation.php?success=true'); // Ajout du paramètre success
    exit();
}
?>  
<!DOCTYPE html>

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
<style>

.success-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #4CAF50;
    color: white;
    border-radius: 8px;
    padding: 15px 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    animation: slideIn 0.5s ease-out;
    max-width: 400px;
}

.success-content {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.success-notification svg {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
    margin-top: 2px;
}

.success-notification h3 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
}

.success-notification p {
    margin: 0;
    font-size: 14px;
    opacity: 0.9;
}

.close-btn {
    margin-left: 15px;
    cursor: pointer;
    font-size: 18px;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.close-btn:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}


</style>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Fermer la notification de succès
    const closeBtn = document.querySelector('.close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            this.closest('.success-notification').style.display = 'none';
        });
        
        // Fermer automatiquement après 10 secondes
        setTimeout(() => {
            document.querySelector('.success-notification')?.remove();
        }, 10000);
    }
});
</script>

    <main class="container">
        <h1>Envoyer une Réclamation</h1>
        <?php
// Afficher le message de succès si le paramètre 'success' est présent dans l'URL
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo '
    <div class="success-notification">
        <div class="success-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <div>
                <h3>Réclamation envoyée avec succès</h3>
                <p>Nous avons bien reçu votre réclamation et la traiterons dans les plus brefs délais.</p>
            </div>
            <span class="close-btn">&times;</span>
        </div>
    </div>';
}
?>
        <form action="ajouterreclamation.php" method="POST" class="reclamation-form" onsubmit="return validateForm(event)">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom"  />

            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email"  />

            <label for="tel">Téléphone :</label>
            <input type="text" id="tel" name="tel"  />


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
