<?php
include_once "../../Controller/sponsorsC.php";

$sponsorC = new SponsorC();
$formSubmitted = false;
$formError = false;
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_sponsor'])) {
    try {
        $nom_complet = htmlspecialchars($_POST['nom_complet']);
        $entreprise = htmlspecialchars($_POST['entreprise']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $contact_email = htmlspecialchars($_POST['contact_email']);
        $secteur = htmlspecialchars($_POST['secteur']);
        $budget = floatval($_POST['budget']);
        $type_sponsoring = htmlspecialchars($_POST['type_sponsoring']);
        $message = htmlspecialchars($_POST['message']);
        $site_web = htmlspecialchars($_POST['site_web']);
        $statut = "En attente";

        // Validation des champs
        if (empty($nom_complet) || empty($entreprise) || empty($telephone) || empty($contact_email) || 
            empty($secteur) || $budget <= 0 || empty($type_sponsoring) || empty($message)) {
            throw new Exception("Tous les champs obligatoires doivent être remplis correctement.");
        }

        if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide.");
        }

        // Traitement de l'image en BLOB
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                throw new Exception("L'image doit être au format JPG, JPEG, PNG ou GIF.");
            }

            if ($_FILES['image']['size'] > 2000000) {
                throw new Exception("L'image est trop volumineuse (max 2MB).");
            }

            // Lire l'image en tant que BLOB
            $image = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            throw new Exception("Veuillez sélectionner une image.");
        }

        // Créer l'objet Sponsor
        $sponsor = new Sponsor(
            null,
            $nom_complet,
            $entreprise,
            $telephone,
            $contact_email,
            $secteur,
            $budget,
            $type_sponsoring,
            $message,
            $site_web,
            $image, // image binaire
            $statut,
            date("Y-m-d H:i:s")
        );

        // Enregistrement
        $result = $sponsorC->ajouterSponsor($sponsor);
        
        if ($result) {
            $formSubmitted = true;
            header("refresh:3;url=index.php");
        } else {
            throw new Exception("Erreur lors de l'enregistrement. Veuillez réessayer.");
        }

    } catch (Exception $e) {
        $formError = true;
        $errorMessage = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir Sponsor - tfarhida</title>
    <link rel="icon" href="assets/logo.jpg" style="border-radius: 50%;">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles spécifiques au formulaire */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .text-danger {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            margin-top: 20px;
        }
        
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Style pour les champs requis */
        .required::after {
            content: " *";
            color: red;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <header>
      
        
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
    <h2>✨Devenez Partenaire de Nos Événements Inoubliables✨</h2> <br>
    
    <main class="container">
        <h1>Formulaire d'ajout de Sponsor</h1>
        
        <?php if ($formSubmitted): ?>
            <div class="alert alert-success">
                <p>Votre demande de sponsoring a été enregistrée avec succès !</p>
                <p>Un administrateur examinera votre demande prochainement.</p>
                <p>Vous allez être redirigé vers la page d'accueil dans quelques secondes...</p>
            </div>
        <?php endif; ?>
        
        <?php if ($formError): ?>
            <div class="alert alert-danger">
                <p>Erreur : <?php echo $errorMessage; ?></p>
            </div>
        <?php endif; ?>
    
        <?php if (!$formSubmitted): ?>
            <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <!-- Nom & Prénom -->
                <div class="form-group">
                    <label for="nom_complet" class="required">Nom & Prénom</label>
                    <input type="text" class="form-control" id="nom_complet" name="nom_complet" placeholder="Entrez votre nom et prénom" >
                    <small class="text-danger" id="nomCompletError"></small>
                </div>
        
                <!-- Nom de l'entreprise -->
                <div class="form-group">
                    <label for="entreprise" class="required">Nom de l'entreprise</label>
                    <input type="text" class="form-control" id="entreprise" name="entreprise" placeholder="Entrez le nom de l'entreprise" >
                    <small class="text-danger" id="entrepriseError"></small>
                </div>
        
                <!-- Téléphone -->
                <div class="form-group">
                    <label for="telephone" class="required">Numéro de téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Ex: 92000500" >
                    <small class="text-danger" id="telephoneError"></small>
                </div>
        
                <!-- Email de contact -->
                <div class="form-group">
                    <label for="contact_email" class="required">Email de contact</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="Entrez votre email" >
                    <small class="text-danger" id="contactEmailError"></small>
                </div>
        
                <!-- Secteur -->
                <div class="form-group">
                    <label for="secteur" class="required">Secteur d'activité</label>
                    <input type="text" class="form-control" id="secteur" name="secteur" placeholder="Entrez le secteur de l'entreprise" >
                    <small class="text-danger" id="secteurError"></small>
                </div>
        
                <!-- Budget -->
                <div class="form-group">
                    <label for="budget" class="required">Budget (TND)</label>
                    <input type="number" min="1" step="0.01" class="form-control" id="budget" name="budget" placeholder="Entrez le budget" >
                    <small class="text-danger" id="budgetError"></small>
                </div>
        
                <!-- Type de sponsoring -->
                <div class="form-group">
                    <label for="type_sponsoring" class="required">Type de sponsoring souhaité</label>
                    <select class="form-control" id="type_sponsoring" name="type_sponsoring" >
                        <option value="">-- Choisissez un type --</option>
                        <option value="financier">Financier</option>
                        <option value="logistique">Logistique</option>
                        <option value="visibilité">Visibilité</option>
                        <option value="autre">Autre</option>
                    </select>
                    <small class="text-danger" id="typeSponsoringError"></small>
                </div>
        
                <!-- Message / Motivation -->
                <div class="form-group">
                    <label for="message" class="required">Message / Motivation</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Décrivez vos motivations et ce que vous souhaitez apporter à nos événements" ></textarea>
                    <small class="text-danger" id="messageError"></small>
                </div>
        
                <!-- Site Web -->
                <div class="form-group">
                    <label for="site_web">Site Web</label>
                    <input type="url" class="form-control" id="site_web" name="site_web" placeholder="Ex: https://www.entreprise.com">
                    <small class="text-danger" id="siteWebError"></small>
                </div>
        
                <!-- Image (Logo ou image du sponsor) -->
                <div class="form-group">
                    <label for="image" class="required">Logo de l'entreprise</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png,.gif" >
                    <small class="text-muted">Formats acceptés: JPG, JPEG, PNG, GIF. Taille max: 2MB</small>
                    <small class="text-danger" id="imageError"></small>
                </div>
        
                <!-- Statut - Caché pour éviter manipulation -->
                <input type="hidden" name="statut" value="En attente">
        
                <!-- Soumettre le formulaire -->
                <button type="submit" name="add_sponsor" class="btn btn-primary">Soumettre ma demande</button>
            </form>
            
            <p style="text-align: center; margin-top: 15px;">
                <small>Toutes les demandes de sponsoring sont soumises à validation par notre équipe.</small>
            </p>
        <?php endif; ?>
    </main>
    
    <script>
    function validateForm() {
        let isValid = true;
    
        // Vider tous les messages d'erreur précédents
        document.querySelectorAll(".text-danger").forEach(el => el.innerText = "");
        
        // Vérifier le nom complet
        const nomComplet = document.getElementById('nom_complet').value;
        if (nomComplet.trim() === "") {
            document.getElementById('nomCompletError').innerText = "Le nom et prénom sont obligatoires.";
            isValid = false;
        } else if (nomComplet.trim().length < 3) {
            document.getElementById('nomCompletError').innerText = "Le nom doit contenir au moins 3 caractères.";
            isValid = false;
        }
    
        // Vérifier le nom de l'entreprise
        const entreprise = document.getElementById('entreprise').value;
        if (entreprise.trim() === "") {
            document.getElementById('entrepriseError').innerText = "Le nom de l'entreprise est obligatoire.";
            isValid = false;
        } else if (entreprise.trim().length < 2) {
            document.getElementById('entrepriseError').innerText = "Le nom de l'entreprise doit contenir au moins 2 caractères.";
            isValid = false;
        }
    
        // Vérifier le secteur
        const secteur = document.getElementById('secteur').value;
        if (secteur.trim() === "") {
            document.getElementById('secteurError').innerText = "Le secteur est obligatoire.";
            isValid = false;
        }
    
        // Vérifier le budget
        const budget = document.getElementById('budget').value;
        if (budget === "" || budget <= 0) {
            document.getElementById('budgetError').innerText = "Le budget doit être supérieur à zéro.";
            isValid = false;
        }
    
        // Vérifier le type de sponsoring
        const typeSponsoring = document.getElementById('type_sponsoring').value;
        if (typeSponsoring === "") {
            document.getElementById('typeSponsoringError').innerText = "Le type de sponsoring est obligatoire.";
            isValid = false;
        }
    
        // Vérifier le message
        const message = document.getElementById('message').value;
        if (message.trim() === "") {
            document.getElementById('messageError').innerText = "Le message est obligatoire.";
            isValid = false;
        } else if (message.trim().length < 10) {
            document.getElementById('messageError').innerText = "Veuillez fournir un message plus détaillé (min. 10 caractères).";
            isValid = false;
        }
    
        // Vérifier l'email
        const contactEmail = document.getElementById('contact_email').value;
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (contactEmail.trim() === "") {
            document.getElementById('contactEmailError').innerText = "L'email est obligatoire.";
            isValid = false;
        } else if (!emailRegex.test(contactEmail)) {
            document.getElementById('contactEmailError').innerText = "L'email est invalide.";
            isValid = false;
        }
    
        // Vérifier le téléphone
        const telephone = document.getElementById('telephone').value;
        const phoneRegex = /^[0-9]{8}$/; // Numéro tunisien à 8 chiffres
        if (telephone.trim() === "") {
            document.getElementById('telephoneError').innerText = "Le numéro de téléphone est obligatoire.";
            isValid = false;
        } else if (!phoneRegex.test(telephone)) {
            document.getElementById('telephoneError').innerText = "Veuillez entrer un numéro de téléphone valide à 8 chiffres.";
            isValid = false;
        }
    
        // Vérifier le site web (s'il est rempli)
        const siteWeb = document.getElementById('site_web').value;
        if (siteWeb.trim() !== "") {
            const urlRegex = /^(https?:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
            if (!urlRegex.test(siteWeb)) {
                document.getElementById('siteWebError').innerText = "L'URL du site web est invalide.";
                isValid = false;
            }
        }
    
        // Vérifier l'image
        const image = document.getElementById('image').files[0];
        if (!image) {
            document.getElementById('imageError').innerText = "L'image est obligatoire.";
            isValid = false;
        } else {
            // Vérifier l'extension
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            const fileExtension = image.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExtension)) {
                document.getElementById('imageError').innerText = "Le fichier doit être une image (JPG, JPEG, PNG, GIF).";
                isValid = false;
            }
            
            // Vérifier la taille (max 2MB)
            if (image.size > 2000000) {
                document.getElementById('imageError').innerText = "L'image doit faire moins de 2MB.";
                isValid = false;
            }
        }
    
        return isValid;
    }
    </script>
    
    
    <footer class="luxury-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>تفرهيدة</h3>
            <p>Plateforme de gestion des réclamations et services clients</p>
            <div class="social-icons">
                <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="#"><ion-icon name="logo-linkedin"></ion-icon></a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Liens rapides</h4>
            <ul>
                <li><a href="#" class="main-link">Home</a></li>
                <li><a href="#">Evenement</a></li>
                <li><a href="#">Packs</a></li>
                <li><a href="#">Sponsor</a></li>
                <li><a href="listreclamation.php">Réclamations</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Contactez-nous</h4>
            <ul class="contact-info">
                <li><ion-icon name="mail-outline"></ion-icon> contact@votresite.com</li>
                <li><ion-icon name="call-outline"></ion-icon> +212 6 12 34 56 78</li>
                <li><ion-icon name="location-outline"></ion-icon> Marsa,Tunisie</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2023 تفرهيدة. Tous droits réservés.</p>
    </div>
</footer>

<style>
    /* Style du footer */
    .luxury-footer {
        background: linear-gradient(135deg, #2c3e50, #1a252f);
        color: #ecf0f1;
        padding: 80px 0 30px;
        font-family: 'Segoe UI', sans-serif;
        position: relative;
        margin-top: 50px;
        min-height: 400px;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .footer-section h3 {
        color: #f3b1d2;
        font-size: 1.8rem;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .footer-section h4 {
        color: #f3b1d2;
        font-size: 1.2rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-section h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background: #e60e44;
    }

    .footer-section p {
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 20px;
    }

    .footer-section ul li a {
        color: #ecf0f1;
        text-decoration: none;
        transition: color 0.3s;
        display: block;
        padding: 8px 0;
    }

    .footer-section ul li a:hover {
        color: #f3b1d2;
        padding-left: 5px;
    }

    .main-link {
        font-size: 1.4rem;
        font-weight: bold;
        color: #f3b1d2 !important;
    }

    .contact-info li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .contact-info ion-icon {
        font-size: 1.2rem;
        color: #e60e44;
    }

    .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-icons a {
        color: #ecf0f1;
        font-size: 1.5rem;
        transition: transform 0.3s, color 0.3s;
    }

    .social-icons a:hover {
        color: #f3b1d2;
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        padding: 20px 0;
        margin-top: 50px;
        background: rgba(0, 0, 0, 0.2);
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
        }
        
        .footer-section {
            margin-bottom: 30px;
        }
        
        .luxury-footer {
            min-height: auto;
            padding: 50px 0 20px;
        }
    }
</style>

</body>
</html>