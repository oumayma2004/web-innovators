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