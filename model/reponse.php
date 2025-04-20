<?php
class Reponse
{
    private $idReponse;
    private $idReclamation;
    private $contenu;
    private $dateReponse;

    public function __construct($idReponse, $idReclamation, $contenu, $dateReponse)
    {
        $this->idReponse = $idReponse;
        $this->idReclamation = $idReclamation;
        $this->contenu = $contenu;
        $this->dateReponse = $dateReponse;
    }

    public function getIdReponse()
    {
        return $this->idReponse;
    }

    public function getIdReclamation()
    {
        return $this->idReclamation;
    }

    public function setIdReclamation($idReclamation)
    {
        $this->idReclamation = $idReclamation;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    public function getDateReponse()
    {
        return $this->dateReponse;
    }

    public function setDateReponse($dateReponse)
    {
        $this->dateReponse = $dateReponse;
    }
}
?>
