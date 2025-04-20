<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../model/Reclamation.php';

class ReclamationC
{

    
    // Dans ReclamationC.php
    public function updateReclamationStatus($id_reclamation, $newStatus) {
        $sql = "UPDATE reclamation SET etat = :etat WHERE id_reclamation = :id";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id_reclamation,
                'etat' => $newStatus
            ]);
            return true;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    // Ajouter une réclamation
    public function ajouterReclamation($reclamation)
    {
        $sql = "INSERT INTO reclamtion (nom, email, tel, date_creation, etat, type_reclamation, evenement_concerne, description) 
                VALUES (:nom, :email, :tel, :date_creation, :etat, :type_reclamation, :evenement_concerne, :description)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $reclamation->getNom(),
                'email' => $reclamation->getEmail(),
                'tel' => $reclamation->getTel(),
                'date_creation' => $reclamation->getDateCreation(),
                'etat' => $reclamation->getEtat(),
                'type_reclamation' => $reclamation->getTypeReclamation(),
                'evenement_concerne' => $reclamation->getEvenementConcerne(),
                'description' => $reclamation->getDescription()
            ]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    // Afficher toutes les réclamations
    public function afficherReclamations()
    {
        $sql = "SELECT * FROM reclamtion ORDER BY date_creation DESC";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Supprimer une réclamation
    public function supprimerReclamation($id)
    {
        $sql = "DELETE FROM reclamtion WHERE id_reclamation = :id";
        $db = config::getConnexion();
        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Récupérer une réclamation spécifique
    public function recupererReclamation($id)
    {
        $sql = "SELECT * FROM reclamtion WHERE id_reclamation = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    // Modifier une réclamation
    public function modifierReclamation($reclamation, $id)
    {
        $sql = "UPDATE reclamtion SET 
                    nom = :nom,
                    email = :email,
                    tel = :tel,
                    date_creation = :date_creation,
                    etat = :etat,
                    type_reclamation = :type_reclamation,
                    evenement_concerne = :evenement_concerne,
                    description = :description
                WHERE id_reclamation = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $reclamation->getNom(),
                'email' => $reclamation->getEmail(),
                'tel' => $reclamation->getTel(),
                'date_creation' => $reclamation->getDateCreation(),
                'etat' => $reclamation->getEtat(),
                'type_reclamation' => $reclamation->getTypeReclamation(),
                'evenement_concerne' => $reclamation->getEvenementConcerne(),
                'description' => $reclamation->getDescription(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    // Afficher avec éventuelles réponses (si tu ajoutes la table "reponse")
    public function afficherReclamationsAvecReponses()
    {
        $sql = "SELECT r.*, rep.contenu AS reponse 
                FROM reclamtion r 
                LEFT JOIN reponse rep ON r.id_reclamation = rep.id_reclamation 
                ORDER BY r.date_creation DESC";
        
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getReclamationById($id) {
        $sql = "SELECT * FROM reclamtion WHERE id_reclamation = :id";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
            $row = $query->fetch();
    
            if ($row) {
                $reclamation = new Reclamation(
                    $row['id_reclamation'],
                    $row['nom'],
                    $row['email'],
                    $row['tel'],
                    $row['date_creation'],
                    $row['etat'],
                    $row['type_reclamation'],
                    $row['evenement_concerne'],
                    $row['description']
                );
                return $reclamation;
            }
    
            return null;
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

   
}

    



?>
