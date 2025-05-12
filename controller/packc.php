<?php
require_once '../../config.php';
require_once '../../Model/pack.php'; 

class packc 
{
    public function addPack($pack) {
        try {
            $db = config::getConnexion();
            $sql = "INSERT INTO pack (titre, description, prix, nombre_places, date_d) 
                    VALUES (:titre, :description, :prix, :nombre_places, :date_d)";
            $query = $db->prepare($sql);
            $query->execute([
                'titre' => $pack->getTitre(),
                'description' => $pack->getDescription(),
                'prix' => $pack->getPrix(),
                'nombre_places' => $pack->getNombrePlaces(),
                'date_d' => $pack->getDateD()
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    public function getAllPacks() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM pack";
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
    public function getAllPacks1($start_from = 0, $records_per_page = 3) {
        $sql = "SELECT * FROM pack LIMIT $start_from, $records_per_page";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    

    public function getPackById($id) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM pack WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }
    public function searchPacks($searchInput) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM pack WHERE titre LIKE :searchInput OR description LIKE :searchInput";
            $query = $db->prepare($sql);
            $query->bindValue(':searchInput', '%' . $searchInput . '%');
            $query->execute();
            $packs = $query->fetchAll(PDO::FETCH_ASSOC);
            return $packs;
            
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];  // Return an empty array in case of an error
        }
    }
    public function getTotalPacks() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT COUNT(*) AS total FROM pack";
            $query = $db->query($sql);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total'];  // Retourne le nombre total de packs
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }
    public function getAveragePrix() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT AVG(prix) AS average_prix FROM pack";
            $query = $db->query($sql);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['average_prix'];  // Retourne le prix moyen
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }
    public function getPacksByPlaceRange($min, $max) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM pack WHERE nombre_places BETWEEN :min AND :max";
            $query = $db->prepare($sql);
            $query->bindParam(':min', $min, PDO::PARAM_INT);
            $query->bindParam(':max', $max, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getPackWithMaxPlaces() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM pack ORDER BY nombre_places DESC LIMIT 1";
            $query = $db->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC);  // Retourne le pack avec le plus grand nombre de places
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function getMostRecentPack() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM pack ORDER BY date_d DESC LIMIT 1";
            $query = $db->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC);  // Retourne le pack le plus récent
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function getCountByTitle() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT titre, COUNT(*) AS count FROM pack GROUP BY titre";
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);  // Retourne un tableau avec les titres et leur nombre de packs
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
    
    
    

    public function updatePack($pack) {
        try {
            $db = config::getConnexion();
            $sql = "UPDATE pack SET titre = :titre, description = :description, prix = :prix, nombre_places = :nombre_places,
                    date_d = :date_d WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute([
                'titre' => $pack->getTitre(),
                'description' => $pack->getDescription(),
                'prix' => $pack->getPrix(),
                'nombre_places' => $pack->getNombrePlaces(),
                'date_d' => $pack->getDateD(),
                'id' => $pack->getId()
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function deletePack($id) {
        try {
            $db = config::getConnexion();
            $sql = "DELETE FROM pack WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    function chercher_titre($titre)
    {
        $db = config::getConnexion();
        $search_query = "SELECT * FROM pack WHERE titre = :titre";
        $stmt = $db->prepare($search_query);
        $stmt->execute(array(':titre' => $titre));
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return NULL;
        }
    }

}
?>