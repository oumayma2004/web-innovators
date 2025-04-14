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