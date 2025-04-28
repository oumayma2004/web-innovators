<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit();
}

require_once '../../config.php'; 
require_once '../../controller/userc.php'; 

$user_id = $_SESSION['user']['id']; 
$controller = new userc();
$user = $controller->getUserById($user_id); 
if (isset($_POST['update_2fa'])) {
  $enable_2fa = (int)$_POST['enable_2fa'];

  try {
      $db = config::getConnexion();
      $sql = "UPDATE users SET is_enabled_2fa = :enable_2fa WHERE id = :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':enable_2fa', $enable_2fa, PDO::PARAM_INT);
      $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      echo "Paramètres 2FA mis à jour avec succès!";
      header("Refresh:1"); // Rafraîchit la page pour afficher le nouveau statut
      exit;
  } catch (PDOException $e) {
      echo "Erreur lors de la mise à jour de la 2FA: " . $e->getMessage();
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $c_pass = $_POST['c_pass'];
    $adresse = $_POST['adresse'];
    $email = $user['email']; 
    $phone = $user['phone']; 

    if ($new_pass !== $c_pass) {
        echo "Les mots de passe ne correspondent pas!";
        exit();
    }
    if (!empty($old_pass) && password_verify($old_pass, $user['password'])) {
        $password = password_hash($new_pass, PASSWORD_DEFAULT);
    } else {
        $password = $user['password'];
    }
    $profile_pic = $user['photo'];  
    if ($_FILES['photo']['error'] == 0) {
        $img_name = $_FILES['photo']['name'];
        $img_tmp_name = $_FILES['photo']['tmp_name'];
        $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);
        $unique_name = uniqid() . '.' . $img_extension;
        $img_folder = 'uploads/' . $unique_name;
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true); 
        }
        if (move_uploaded_file($img_tmp_name, $img_folder)) {
            $profile_pic = $img_folder;  
        } else {
            echo "Erreur lors du téléchargement de l'image!";
            exit();
        }
    }
    $controller->updateUser($user_id, $nom, $prenom, $profile_pic, $adresse, $password, $email, $phone);
    echo "Profil mis à jour avec succès!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tfarhida - Accueil</title>
  <link rel="stylesheet" href="styleu.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
     body {
      font-family: 'Poppins', sans-serif;
      background: #f5f7fa;
      justify-content: center;
      align-items: center;
    }

    .profile-container {
      position: relative;
      display: inline-block;
    }

    .profile-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 50px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      min-width: 150px;
      z-index: 1000;
    }

    .dropdown-menu a {
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      color: #333;
    }

    .dropdown-menu a:hover {
      background-color: #f0f0f0;
    }
   

    .form-container {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      padding: 30px;
      right: 100px;
    }

    h3 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      color: #555;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #5c6ac4;
      outline: none;
    }

    .form-group input[type="file"] {
      border: none;
    }

    .btn {
      width: 100%;
      background-color: #5c6ac4;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #4b5abf;
    }

    .current-profile-pic {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .current-profile-pic img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 10px;
    }
  </style>
</head>

<body>
    <!-- Barre supérieure -->
    <div class="top-bar">
      <div class="phones">
        <img src="assets/tel1.png" class="icon-phone" alt="Téléphone" />
        <span>+216 50 548 028</span>
        <img src="assets/tel1.png" class="icon-phone" alt="Téléphone" />
        <span>+216 99 727 727</span>
      </div>
      <div class="profile-container">
        <img src="<?php echo $user['photo']; ?>" alt="Profile" class="profile-img" id="profileIcon">
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="update.php">👤 View Profile</a>
          <a href="logout.php">🔓 Logout</a>
        </div>
      </div>
   </div>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="logo">
      <img src="assets/logosite1.png">
    </div>
  </nav>

  <div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
      <h3>Modifier le Profil</h3>

      <div class="form-group">
        <label for="photo">Photo de profil</label>
        <input type="file" name="photo" id="photo" accept="image/*">
        <div class="current-profile-pic">
          <img src="<?php echo $user['photo']; ?>" alt="Photo actuelle">
          <span>Photo actuelle</span>
        </div>
      </div>
      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?php echo $user['nom']; ?>" required>
      </div>

      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="<?php echo $user['prenom']; ?>" required>
      </div>

      <div class="form-group">
        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" value="<?php echo $user['adresse']; ?>" required>
      </div>

      <div class="form-group">
        <label for="old_pass">Ancien mot de passe</label>
        <input type="password" name="old_pass" id="old_pass" placeholder="Saisissez l'ancien mot de passe">
      </div>

      <div class="form-group">
        <label for="new_pass">Nouveau mot de passe</label>
        <input type="password" name="new_pass" id="new_pass" placeholder="Nouveau mot de passe">
      </div>

      <div class="form-group">
        <label for="c_pass">Confirmer le mot de passe</label>
        <input type="password" name="c_pass" id="c_pass" placeholder="Confirmez le mot de passe">
      </div>

      

      <button type="submit" name="submit" class="btn">Mettre à jour</button>
    </form>
    <hr style="margin: 30px 0;">
            <form action="" method="POST">
                <h3>Authentification 2FA</h3>
                <div class="form-group">
                    <label for="enable_2fa">Activer l'authentification à deux facteurs (2FA)</label>
                    <select name="enable_2fa" id="enable_2fa" required>
                        <option value="1" <?php echo ($user['is_enabled_2fa'] ? 'selected' : ''); ?>>Activer</option>
                        <option value="0" <?php echo (!$user['is_enabled_2fa'] ? 'selected' : ''); ?>>Désactiver</option>
                    </select>
                </div>
                <button type="submit" name="update_2fa" class="btn">Mettre à jour 2FA</button>
            </form>
  </div>
</body>

</html>
<script>
  const profileIcon = document.getElementById('profileIcon');
  const dropdownMenu = document.getElementById('dropdownMenu');

  profileIcon.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
  });

  // Close dropdown if clicking outside
  document.addEventListener('click', function(event) {
    if (!event.target.closest('.profile-container')) {
      dropdownMenu.style.display = 'none';
    }
  });
</script>