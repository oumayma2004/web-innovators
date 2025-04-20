<?php
require '../../config.php';
class ReclamationC
{
    public function listReclamations()
    {
        $sql = "SELECT * FROM reclamtion";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function ajouterReclamation($reclamation)
    {
        $sql = 'INSERT INTO reclamtion (id_reclamation, nom, email, tel, date_creation, etat, type_reclamation, evenement_concerne, description) 
                VALUES (:id, :nom, :email, :tel, :date_creation, :etat, :type_reclamation, :evenement_concerne, :description)';
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $reclamation->getId(),
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
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteReclamation($id)
    {
        $sql = "DELETE FROM reclamtion WHERE id_reclamation = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
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
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getReclamationById($id)
{
    $sql = "SELECT * FROM reclamtion WHERE id_reclamation = :id";
    $db = config::getConnexion();
    $req = $db->prepare($sql);
    $req->bindValue(':id', $id);
    
    try {
        $req->execute();
        $result = $req->fetch(); // Récupère une seule ligne
        
        // Vérifier si la réclamation existe
        if ($result) {
            // Créer un objet réclamation avec les résultats de la base de données
            $reclamation = new Reclamation(
                $result['id_reclamation'],
                $result['nom'],
                $result['email'],
                $result['tel'],
                $result['date_creation'],
                $result['etat'],
                $result['type_reclamation'],
                $result['evenement_concerne'],
                $result['description']
            );
            return $reclamation;
        } else {
            return null; // Si aucune réclamation n'a été trouvée
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
}

?>
