<?php
require_once '../../config.php';
require_once '../../Model/codePromo.php'; 

class codePromoc 
{
    public function addCodePromo($codePromo) {
        try {
            $db = config::getConnexion();
            $sql = "INSERT INTO codepromo (code, reduction, date_debut, date_fin, id_pack, actif)
                    VALUES (:code, :reduction, :date_debut, :date_fin, :id_pack, :actif)";
            $query = $db->prepare($sql);
            $query->execute([
                'code' => $codePromo->getCode(),
                'reduction' => $codePromo->getReduction(),
                'date_debut' => $codePromo->getDateDebut(),
                'date_fin' => $codePromo->getDateFin(),
                'id_pack' => $codePromo->getIdPack(),
                'actif' => $codePromo->isActif()
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    public function searchCodePromo($searchInput) {
        try {
            $db = config::getConnexion();
    
            // SQL query to search by code, reduction, or date
            $sql = "SELECT * FROM codePromo WHERE code LIKE :searchInput OR reduction LIKE :searchInput";
    
            $query = $db->prepare($sql);
            $query->bindValue(':searchInput', '%' . $searchInput . '%');
    
            $query->execute();
    
            // Fetch results as an associative array
            $codePromos = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $codePromos;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];  // Return an empty array in case of an error
        }
    }

    public function getAllCodes() {
        $sql = "SELECT * FROM codepromo";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    public function getCountByStatus() {
        try {
            $db = config::getConnexion();
            
            // Compter le nombre de codes promo actifs
            $sqlActive = "SELECT COUNT(*) AS count FROM codepromo WHERE actif = 1";
            $queryActive = $db->query($sqlActive);
            $activeCount = $queryActive->fetch(PDO::FETCH_ASSOC)['count'];
            
            // Compter le nombre de codes promo non actifs
            $sqlInactive = "SELECT COUNT(*) AS count FROM codepromo WHERE actif = 0";
            $queryInactive = $db->query($sqlInactive);
            $inactiveCount = $queryInactive->fetch(PDO::FETCH_ASSOC)['count'];
    
            return ['active' => $activeCount, 'inactive' => $inactiveCount];
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return ['active' => 0, 'inactive' => 0];  // Retourne 0 en cas d'erreur
        }
    }
    
    

    public function getAllCodePromos() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM codepromo";
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getCodePromoById($id_code) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM codepromo WHERE id_code = :id_code";
            $query = $db->prepare($sql);
            $query->execute(['id_code' => $id_code]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function updateCodePromo($codePromo) {
        try {
            $db = config::getConnexion();
            $sql = "UPDATE codepromo SET code = :code, reduction = :reduction, date_debut = :date_debut, 
                    date_fin = :date_fin, id_pack = :id_pack, actif = :actif
                    WHERE id_code = :id_code";
            $query = $db->prepare($sql);
            $query->execute([
                'code' => $codePromo->getCode(),
                'reduction' => $codePromo->getReduction(),
                'date_debut' => $codePromo->getDateDebut(),
                'date_fin' => $codePromo->getDateFin(),
                'id_pack' => $codePromo->getIdPack(),
                'actif' => $codePromo->isActif(),
                'id_code' => $codePromo->getIdCode()
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteCodePromo($id_code) {
        try {
            $db = config::getConnexion();
            $sql = "DELETE FROM codepromo WHERE id_code = :id_code";
            $query = $db->prepare($sql);
            $query->execute(['id_code' => $id_code]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }


}
?>