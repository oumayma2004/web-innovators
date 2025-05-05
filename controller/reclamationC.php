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
    public function countReclamationsWithSearch($search)
    {
        $sql = "SELECT COUNT(*) AS total FROM reclamtion
                WHERE 
                nom LIKE :search OR 
                email LIKE :search OR 
                tel LIKE :search OR 
                date_creation LIKE :search OR 
                etat LIKE :search OR 
                type_reclamation LIKE :search OR 
                evenement_concerne LIKE :search OR 
                description LIKE :search";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([':search' => '%' . $search . '%']);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

// Récupérer une liste de réclamations avec recherche, tri et pagination
public function fetchFilteredSortedReclamations($search, $sort, $limit, $offset, $etatFilter = '')
{
    $db = config::getConnexion();
    
    // Construction dynamique de la requête
    $sql = "SELECT * FROM reclamtion WHERE (
                nom LIKE :search OR 
                email LIKE :search OR 
                tel LIKE :search OR 
                date_creation LIKE :search OR 
                etat LIKE :search OR 
                type_reclamation LIKE :search OR 
                evenement_concerne LIKE :search OR 
                description LIKE :search
            )";
    
    if (!empty($etatFilter)) {
        $sql .= " AND etat = :etatFilter";
    }

    // Sécurité tri
    $allowedSortValues = ['ASC', 'DESC'];
    $sort = in_array(strtoupper($sort), $allowedSortValues) ? strtoupper($sort) : 'ASC';

    $sql .= " ORDER BY date_creation $sort LIMIT :limit OFFSET :offset";

    try {
        $query = $db->prepare($sql);
        $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        if (!empty($etatFilter)) {
            $query->bindValue(':etatFilter', $etatFilter, PDO::PARAM_STR);
        }

        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
// Ajouter une méthode pour récupérer les statistiques des réclamations
public function getStatistiquesReclamations()
{
    $db = config::getConnexion();

    try {
        // Statistiques sur les réclamations répondues
        $sqlRepondu = "SELECT COUNT(*) AS total_repondu FROM reclamtion WHERE etat = 'repondu'";
        $queryRepondu = $db->prepare($sqlRepondu);
        $queryRepondu->execute();
        $totalRepondu = $queryRepondu->fetch(PDO::FETCH_ASSOC)['total_repondu'];

        // Statistiques sur les réclamations non répondues
        $sqlNonRepondu = "SELECT COUNT(*) AS total_non_repondu FROM reclamtion WHERE etat = 'en attente'";
        $queryNonRepondu = $db->prepare($sqlNonRepondu);
        $queryNonRepondu->execute();
        $totalNonRepondu = $queryNonRepondu->fetch(PDO::FETCH_ASSOC)['total_non_repondu'];

        // Retourner les résultats sous forme de tableau
        return [
            'total_repondu' => $totalRepondu,
            'total_non_repondu' => $totalNonRepondu
        ];

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
   
}

    



?>
