<?php
include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/Contrat.php';

class ContratC
{



    // ✅ Ajouter un contrat
    public function ajouterContrat($contrat)
    {
        $sql = "INSERT INTO contrat (
                    id_sponsor, date_signature, date_fin, montant, type_contrat
                ) VALUES (
                    :id_sponsor, :date_signature, :date_fin, :montant, :type_contrat
                )";
    
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_sponsor'    => $contrat->getIdSponsor(),
                'date_signature'=> $contrat->getDateSignature(),
                'date_fin'      => $contrat->getDateFin(),
                'montant'       => $contrat->getMontant(),
                'type_contrat'  => $contrat->getTypeContrat()
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Erreur lors de l\'ajout du contrat : ' . $e->getMessage();
            return false;
        }
    }
    
    

    // ✅ Supprimer un contrat
    public function supprimerContrat($id)
    {
        $sql = "DELETE FROM contrat WHERE id_contrat = :id";
        $db = config::getConnexion();
        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // ✅ Modifier un contrat
    public function modifierContrat($contrat)
    {
        $sql = "UPDATE contrat SET 
                    id_sponsor = :id_sponsor,
                    date_signature = :date_signature,
                    date_fin = :date_fin,
                    montant = :montant,
                    type_contrat = :type_contrat
                WHERE id_contrat = :id_contrat";
    
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_sponsor'    => $contrat['id_sponsor'],
                'date_signature'=> $contrat['date_signature'],
                'date_fin'      => $contrat['date_fin'],
                'montant'       => $contrat['montant'],
                'type_contrat'  => $contrat['type_contrat'],
                'id_contrat'    => $contrat['id_contrat']
            ]);
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    

    // ✅ Récupérer tous les contrats
    public function afficherContrats()
    {
        $sql = "SELECT * FROM contrat ORDER BY date_signature DESC";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // ✅ Récupérer un contrat par ID
    public function recupererContrat($id)
    {
        $sql = "SELECT * FROM contrat WHERE id_contrat = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    // ✅ Récupérer les contrats d’un sponsor donné
    public function getContratsParSponsor($id_sponsor)
    {
        $sql = "SELECT * FROM contrat WHERE id_sponsor = :id_sponsor ORDER BY date_signature DESC";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id_sponsor' => $id_sponsor]);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Compter le nombre de contrats avec recherche
    public function countContratsWithSearch($search, $typeContrat = '')
    {
        $sql = "SELECT COUNT(*) AS total FROM contrat
                WHERE (
                    id_sponsor LIKE :search OR
                    date_signature LIKE :search OR
                    date_fin LIKE :search OR
                    montant LIKE :search OR
                    type_contrat LIKE :search
                )";
                
        // Ajouter le filtre par type de contrat si spécifié
        if (!empty($typeContrat)) {
            $sql .= " AND type_contrat = :typeContrat";
        }
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            
            if (!empty($typeContrat)) {
                $query->bindValue(':typeContrat', $typeContrat, PDO::PARAM_STR);
            }
            
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    // Récupérer une liste de contrats avec recherche, tri et pagination
    public function fetchFilteredSortedContrats($search, $sort, $limit, $offset, $typeContrat = '')
    {
        $db = config::getConnexion();
       
        $sql = "SELECT * FROM contrat WHERE (
                    id_sponsor LIKE :search OR
                    date_signature LIKE :search OR
                    date_fin LIKE :search OR
                    montant LIKE :search OR
                    type_contrat LIKE :search
                )";
                
        // Ajouter le filtre par type de contrat si spécifié
        if (!empty($typeContrat)) {
            $sql .= " AND type_contrat = :typeContrat";
        }
        
        $allowedSortValues = ['ASC', 'DESC'];
        $sort = in_array(strtoupper($sort), $allowedSortValues) ? strtoupper($sort) : 'ASC';
        $sql .= " ORDER BY date_signature $sort LIMIT :limit OFFSET :offset";
        
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            
            if (!empty($typeContrat)) {
                $query->bindValue(':typeContrat', $typeContrat, PDO::PARAM_STR);
            }
            
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }


    public function countContratsByType() {
        $sql = "SELECT type_contrat, COUNT(*) as count FROM contrat GROUP BY type_contrat";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    

}
?>
