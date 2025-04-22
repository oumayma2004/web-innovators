<?php
include_once __DIR__ . '/../config.php';

class EventManager {
    public function listEvents() {
        $sql = "SELECT * FROM gestion_event";
        $db = config::getConnexion();
        try {
            return $db->query($sql);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getEventById($id) {
        $sql = "SELECT * FROM gestion_event WHERE id_event = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addEvent($nom, $date, $lieu, $prix, $etat, $categorie, $description) {
        $sql = "INSERT INTO gestion_event (nom_e, date_e, lieu_e, prix_e, etat_e, category_e, desc_e)
                VALUES (:nom, :date, :lieu, :prix, :etat, :categorie, :description)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':nom', $nom);
            $query->bindParam(':date', $date);
            $query->bindParam(':lieu', $lieu);
            $query->bindParam(':prix', $prix);
            $query->bindParam(':etat', $etat);
            $query->bindParam(':categorie', $categorie);
            $query->bindParam(':description', $description);
            $query->execute();
            echo "Événement ajouté avec succès.";
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function updateEvent($id, $nom, $date, $lieu, $prix, $etat, $categorie, $description) {
        $sql = "UPDATE gestion_event SET 
                    nom_e = :nom, 
                    date_e = :date, 
                    lieu_e = :lieu, 
                    prix_e = :prix, 
                    etat_e = :etat, 
                    category_e = :categorie, 
                    desc_e = :description
                WHERE id_event = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':nom', $nom);
            $query->bindParam(':date', $date);
            $query->bindParam(':lieu', $lieu);
            $query->bindParam(':prix', $prix);
            $query->bindParam(':etat', $etat);
            $query->bindParam(':categorie', $categorie);
            $query->bindParam(':description', $description);
            $query->execute();
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteEvent($id) {
        $sql = "DELETE FROM gestion_event WHERE id_event = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            return $query->execute();
        } catch (Exception $e) {
            die('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
?>
