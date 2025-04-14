<?php
require_once '../../Model/pack.php'; 
require_once '../../config.php';
require_once '../../controller/packc.php'; 
if (
    isset($_POST["titre"]) &&
    isset($_POST["description"]) &&
    isset($_POST["prix"]) &&
    isset($_POST["nombre_places"])  &&  
    isset($_POST["date_d"])
) {
    if (
        !empty($_POST["titre"]) &&
        !empty($_POST["description"]) &&
        !empty($_POST["prix"]) &&
        !empty($_POST["nombre_places"]) &&  
        !empty($_POST["date_d"])
    ) {
        $pack = new pack(
            null,
            $_POST["titre"],
            $_POST["description"],
            $_POST["prix"],
            $_POST["nombre_places"],
            $_POST["date_d"]
        );

        $packc = new packc;
        $titre= $_POST["titre"];
        if ($packc->chercher_titre($titre) === NULL) {
             $packc->addPack($pack)
?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Welcome</title>
                    <style>
                        body, html {
                            margin: 0;
                            padding: 0;
                            height: 100%;
                            background-color: #f4f4f4; /* Couleur de fond */
                        }

                        .welcome-container {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100%;
                        }

                        .welcome-text {
                            font-size: 5em;
                            animation: fadeInOut 3s forwards;
                            color: #007bff; /* Couleur du texte */
                        }

                        @keyframes fadeInOut {
                            0% { opacity: 0; }
                            10% { opacity: 1; }
                            90% { opacity: 1; }
                            100% { opacity: 0; }
                        }
                    </style>
                </head>
                <body>
                    <div class="welcome-container">
                        <p class="welcome-text">Ajout avec succès</p>
                    </div>

                    <script>
                        setTimeout(function() {
                            window.location.href = "pack.php";
                        }, 2000);
                    </script>
                </body>
                </html>

<?php
        } else {
            echo
             '<script>alert("titre existe déjà"); window.location.href = "ajoutpack.html";</script>';
        }
    } else {
        echo 
        '<script>alert("Erreur lors de l\'ajout"); window.location.href = "ajoutpack.html";</script>';
    }
} else {
    echo 
    '<script>alert("remplir tous les chemps"); window.location.href = "ajoutpack.html";</script>';
}
?>
