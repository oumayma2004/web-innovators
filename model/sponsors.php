<?php
class Sponsor
{
    private $idSponsor;
    private $nomComplet;
    private $entreprise;
    private $telephone;
    private $contactEmail;
    private $secteur;
    private $budget;
    private $typeSponsoring;
    private $siteWeb;
    private $message;
    private $statut;
    private $dateEnvoi;
    private $image;

    public function __construct($idSponsor, $nomComplet, $entreprise, $telephone, $contactEmail, $secteur, $budget, $typeSponsoring, $siteWeb, $message, $statut, $dateEnvoi, $image)
    {
        $this->idSponsor = $idSponsor;
        $this->nomComplet = $nomComplet;
        $this->entreprise = $entreprise;
        $this->telephone = $telephone;
        $this->contactEmail = $contactEmail;
        $this->secteur = $secteur;
        $this->budget = $budget;
        $this->typeSponsoring = $typeSponsoring;
        $this->siteWeb = $siteWeb;
        $this->message = $message;
        $this->statut = $statut;
        $this->dateEnvoi = $dateEnvoi;
        $this->image = $image;
    }

    public function getIdSponsor() { return $this->idSponsor; }
    public function getNomComplet() { return $this->nomComplet; }
    public function setNomComplet($nomComplet) { $this->nomComplet = $nomComplet; }

    public function getEntreprise() { return $this->entreprise; }
    public function setEntreprise($entreprise) { $this->entreprise = $entreprise; }

    public function getTelephone() { return $this->telephone; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }

    public function getContactEmail() { return $this->contactEmail; }
    public function setContactEmail($contactEmail) { $this->contactEmail = $contactEmail; }

    public function getSecteur() { return $this->secteur; }
    public function setSecteur($secteur) { $this->secteur = $secteur; }

    public function getBudget() { return $this->budget; }
    public function setBudget($budget) { $this->budget = $budget; }

    public function getTypeSponsoring() { return $this->typeSponsoring; }
    public function setTypeSponsoring($typeSponsoring) { $this->typeSponsoring = $typeSponsoring; }

    public function getSiteWeb() { return $this->siteWeb; }
    public function setSiteWeb($siteWeb) { $this->siteWeb = $siteWeb; }

    public function getMessage() { return $this->message; }
    public function setMessage($message) { $this->message = $message; }

    public function getStatut() { return $this->statut; }
    public function setStatut($statut) { $this->statut = $statut; }

    public function getDateEnvoi() { return $this->dateEnvoi; }
    public function setDateEnvoi($dateEnvoi) { $this->dateEnvoi = $dateEnvoi; }

    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; }
}
?>
