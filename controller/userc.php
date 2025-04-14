<?php
require_once '../../config.php';
require_once '../../Model/user.php'; 

class userc 
{
    
   
    public function addUser($user) {
        try {
            $db = config::getConnexion();
            $sql = "INSERT INTO users (nom, prenom, date_c, photo, adresse, password, email, phone)  
                    VALUES (:nom, :prenom, :date_c, :photo, :adresse, :password, :email, :phone)";
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'date_c' => $user->getDateC(),
                'photo' => $user->getPhoto(),
                'adresse' => $user->getAdresse(),
                'password' => $user->getPassword(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone()
            ]);      
            return true; 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false; 
        }
    }

    public function updateUser($id, $nom, $prenom, $photo, $adresse, $password, $email, $phone) {
        try {
            $db = config::getConnexion();
            $sql = "UPDATE users 
                    SET nom = :nom, prenom = :prenom, photo = :photo,
                        adresse = :adresse, password = :password, email = :email, phone = :phone 
                    WHERE id = :id";

            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'nom' => $nom,
                'prenom' => $prenom,
                'photo' => $photo,
                'adresse' => $adresse,
                'password' => $password,
                'email' => $email,
                'phone' => $phone
            ]);

            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    
    
    
    
    public function loginUser($email, $password) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM users WHERE email = :email";
            $query = $db->prepare($sql);
            $query->execute(['email' => $email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false; 
        }
    }
    
    public function getUserById($id) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM users WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    
    public function deleteUser($id) {
        try {
            $db = config::getConnexion();
            $sql = "DELETE FROM users WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return true; 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false; 
        }
    }

    public function listen() 
    {
        $sql = "SELECT * FROM users"; 
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function toggleUserRole($userId) {
        try {
            $db = config::getConnexion();
            $query = "SELECT role FROM users WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $currentRole = $stmt->fetchColumn();
            if ($currentRole === 'admin') {
                $newRole = 'user';
            } else {
                $newRole = 'admin';
            }
            $updateQuery = "UPDATE users SET role = :role WHERE id = :id";
            $stmt = $db->prepare($updateQuery);
            $stmt->bindParam(':role', $newRole, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false; 
        }
    }
    
    

}
?>
