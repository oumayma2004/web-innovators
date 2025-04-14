<?php
require_once '../../controller/userc.php';
require_once '../../Model/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date_c = $_POST['date_c'];
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $password = htmlspecialchars($_POST['password']);
    $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);

    if ($password !== $passwordConfirm) {
        die('Les mots de passe ne correspondent pas.');
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $user = new User($nom, $prenom, $date_c, "default.jpg", $adresse, $hashedPassword, $email, $phone);
    $userc = new userc();

    if ($userc->addUser($user)) {
        header("Location: index.html");
        exit();
    } else {
        echo "Une erreur est survenue lors de l'inscription.";
    }
}
?>
