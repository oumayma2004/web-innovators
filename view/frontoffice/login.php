<?php
require_once '../../config.php';
require_once '../../controller/userc.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; 
    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }
    $controller = new userc();
    $user = $controller->loginUser($email, $password);
    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        echo "success";
    } else {
        echo "failure";
    }
}
?>
