<?php
class Contrat
{
    private $idContrat;
    private $idSponsor;
    private $dateSignature;
    private $dateFin;
    private $montant;
    private $typeContrat;

    public function __construct($idContrat, $idSponsor, $dateSignature, $dateFin, $montant, $typeContrat)
    {
        $this->idContrat = $idContrat;
        $this->idSponsor = $idSponsor;
        $this->dateSignature = $dateSignature;
        $this->dateFin = $dateFin;
        $this->montant = $montant;
        $this->typeContrat = $typeContrat;
    }

    public function getIdContrat() { return $this->idContrat; }
    public function setIdContrat($idContrat) { $this->idContrat = $idContrat; }

    public function getIdSponsor() { return $this->idSponsor; }
    public function setIdSponsor($idSponsor) { $this->idSponsor = $idSponsor; }

    public function getDateSignature() { return $this->dateSignature; }
    public function setDateSignature($dateSignature) { $this->dateSignature = $dateSignature; }

    public function getDateFin() { return $this->dateFin; }
    public function setDateFin($dateFin) { $this->dateFin = $dateFin; }

    public function getMontant() { return $this->montant; }
    public function setMontant($montant) { $this->montant = $montant; }

    public function getTypeContrat() { return $this->typeContrat; }
    public function setTypeContrat($typeContrat) { $this->typeContrat = $typeContrat; }
}
?>
