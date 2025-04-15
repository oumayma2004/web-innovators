<?php
include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/sponsors.php';

class SponsorC
{
    // ✅ Ajouter un sponsor (statut par défaut = "En attente")
    public function ajouterSponsor($sponsor)
    {
        $sql = "INSERT INTO sponsors (
                nom_complet, entreprise, telephone, contact_email, secteur,
                budget, type_sponsoring, message, site_web, image, statut, date_envoi
            ) VALUES (
                :nom_complet, :entreprise, :telephone, :contact_email, :secteur,
                :budget, :type_sponsoring, :message, :site_web, :image, :statut, NOW()
            )";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom_complet'     => $sponsor->getNomComplet(),
                'entreprise'      => $sponsor->getEntreprise(),
                'telephone'       => $sponsor->getTelephone(),
                'contact_email'   => $sponsor->getContactEmail(),
                'secteur'         => $sponsor->getSecteur(),
                'budget'          => $sponsor->getBudget(),
                'type_sponsoring' => $sponsor->getTypeSponsoring(),
                'message'         => $sponsor->getMessage(),
                'site_web'        => $sponsor->getSiteWeb(),
                'image'           => $sponsor->getImage(),
                'statut'          => 'En attente' // Default status is "En attente"
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Erreur lors de l\'ajout du sponsor : ' . $e->getMessage();
            return false;
        }
    }
    // ✅ Supprimer un sponsor
    public function supprimerSponsor($id)
    {
        $sql = "DELETE FROM sponsors WHERE id_sponsor = :id";
        $db = config::getConnexion();
        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // ✅ Valider un sponsor
    public function validerSponsor($id)
    {
        $sql = "UPDATE sponsors SET statut = 'oui' WHERE id_sponsor = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    // ✅ Rejeter un sponsor
    public function rejeterSponsor($id)
    {
        $sql = "UPDATE sponsors SET statut = 'Rejeté' WHERE id_sponsor = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    // ✅ Afficher tous les sponsors
    public function afficherSponsors()
    {
        $sql = "SELECT * FROM sponsors ORDER BY date_envoi DESC";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // ✅ Récupérer un sponsor par ID
    public function recupererSponsor($id)
    {
        $sql = "SELECT * FROM sponsors WHERE id_sponsor = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    public function changerStatut($id_sponsor, $nouveauStatut) {
        $sql = "UPDATE sponsors SET statut = :statut WHERE id_sponsor = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'statut' => $nouveauStatut,
                'id' => $id_sponsor
            ]);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
    public function getValidSponsors()
    {
        $sql = "SELECT * FROM sponsors WHERE statut = 'oui' ORDER BY date_envoi DESC";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    
}



?>
