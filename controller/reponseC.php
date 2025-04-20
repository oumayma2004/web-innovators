<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../model/Reponse.php';

class ReponseC
{
    // Ajouter une réponse
    public function ajouterReponse($reponse)
    {
        $db = config::getConnexion();
        
        try {
            // Debug information
            error_log("ajouterReponse called with ID: " . $reponse->getIdReclamation() . ", content: " . $reponse->getContenu());
            
            // Commencer une transaction
            $db->beginTransaction();
    
            // 1. Ajouter la réponse
            $sqlInsert = "INSERT INTO reponse (id_reclamation, contenu) 
                         VALUES (:id_reclamation, :contenu)";
            $queryInsert = $db->prepare($sqlInsert);
            $queryInsert->execute([
                'id_reclamation' => $reponse->getIdReclamation(),
                'contenu' => $reponse->getContenu()
            ]);
            
            error_log("Response inserted successfully");
    
            // 2. Mettre à jour le statut de la réclamation
            // Test both table names to see which one works
            try {
                $sqlUpdate = "UPDATE reclamation SET etat = 'repondu' 
                             WHERE id_reclamation = :id_reclamation";
                $queryUpdate = $db->prepare($sqlUpdate);
                $queryUpdate->execute(['id_reclamation' => $reponse->getIdReclamation()]);
                error_log("Updated table 'reclamation', rows affected: " . $queryUpdate->rowCount());
            } catch (Exception $e) {
                error_log("Error updating 'reclamation': " . $e->getMessage());
                // Try alternative table name
                $sqlUpdate = "UPDATE reclamtion SET etat = 'repondu' 
                             WHERE id_reclamation = :id_reclamation";
                $queryUpdate = $db->prepare($sqlUpdate);
                $queryUpdate->execute(['id_reclamation' => $reponse->getIdReclamation()]);
                error_log("Updated table 'reclamtion', rows affected: " . $queryUpdate->rowCount());
            }
    
            // Valider la transaction si tout s'est bien passé
            $db->commit();
            
            // Vérifier si la mise à jour a affecté des lignes
            if ($queryUpdate->rowCount() === 0) {
                error_log("Warning: No claims were updated with the status change. ID: " . $reponse->getIdReclamation());
                // This is not a fatal error, so we'll still return true
            }
            
            return true;
    
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $db->rollBack();
            
            error_log("Error in ajouterReponse: " . $e->getMessage());
            throw new Exception("Error adding response: " . $e->getMessage());
        }
    }

    // Afficher toutes les réponses
    public function afficherReponses()
    {
        $sql = "SELECT * FROM reponse ORDER BY date_reponse DESC";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Afficher les réponses d'une réclamation spécifique
    public function afficherReponsesParReclamation($idReclamation)
    {
        $sql = "SELECT * FROM reponse WHERE id_reclamation = :id_reclamation ORDER BY date_reponse DESC";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id_reclamation' => $idReclamation]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Supprimer une réponse
    public function supprimerReponse($id)
    {
        $sql = "DELETE FROM reponse WHERE id_reponse = :id";
        $db = config::getConnexion();
        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Récupérer une réponse
    public function recupererReponse($id)
    {
        $sql = "SELECT * FROM reponse WHERE id_reponse = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    // Modifier une réponse
    public function modifierReponse($reponse, $id)
    {
        $sql = "UPDATE reponse SET contenu = :contenu WHERE id_reponse = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $reponse->getContenu(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    
}
?>
