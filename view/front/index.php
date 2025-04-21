<?php
include_once "../../Controller/sponsorsC.php";

$sponsorController = new SponsorC();
$sponsors = $sponsorController->getValidSponsors();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tfarhida</title>
    <link rel="icon" href="assets/logo.jpg" style="border-radius: 50%;">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="tel">
        <img src="assets/téléchargé__1_-removebg-preview.png" alt="tel">
        <a href="tel:+21692000500"> +216 92 000 500 </a>
        <img src="assets/téléchargé__1_-removebg-preview.png" alt="tel">
        <a href="tel:+21692500200"> +216 92 500 200</a>
    </div>
    <div class="links">
        <img src="assets/images-removebg-preview.png" class="li">
        <a href="">Log in |</a>
        <img src="assets/user.png">
        <a href="">Sign up</a>
    </div>
</header>

<hr>

<nav>
    <a href="index.html"><img src="assets/logo-removebg-preview.png" alt="logo"> </a>
    <div class="link"> 
        <a href="index.php">Home |</a>
        <a href="form.php">add sponsor |</a>

        <a href="">About |</a>
        <a href="">FA&Q |</a>
        <a href="">Contact</a>
    </div>
</nav>

<h2> ✨Devenez Partenaire de Nos Événements Inoubliables✨</h2> <br><br>

<div class="row1">
    <?php if (!empty($sponsors)) : ?>
        <?php foreach ($sponsors as $sponsor): ?>
            <div class="event1">
            <?php if (!empty($sponsor['image'])): ?>
    <img src="path/to/your/image/directory/<?= htmlspecialchars($sponsor['image']) ?>" alt="Image sponsor">
<?php else: ?>
    <img src="assets/default-image.jpg" alt="Image par défaut">
<?php endif; ?>

                <h6><?= htmlspecialchars($sponsor['nom_complet']) ?></h6>
                <p><strong>Entreprise :</strong> <?= htmlspecialchars($sponsor['entreprise']) ?></p>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($sponsor['telephone']) ?></p>
                <p><strong>Secteur :</strong> <?= htmlspecialchars($sponsor['secteur']) ?></p>
                <p><strong>Budget :</strong> <?= htmlspecialchars($sponsor['budget']) ?> TND</p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun sponsor validé trouvé.</p>
    <?php endif; ?>
</div>


<br><br>

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