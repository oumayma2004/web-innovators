<?php
class CodePromo {
    private $id_code;
    private $code;
    private $reduction;
    private $date_debut;
    private $date_fin;
    private $id_pack;
    private $actif;

    public function __construct($id_code, $code, $reduction, $date_debut, $date_fin, $id_pack, $actif) {
        $this->id_code = $id_code;
        $this->code = $code;
        $this->reduction = $reduction;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->id_pack = $id_pack;
        $this->actif = $actif;
    }

    // Getters
    public function getIdCode() {
        return $this->id_code;
    }

    public function getCode() {
        return $this->code;
    }

    public function getReduction() {
        return $this->reduction;
    }

    public function getDateDebut() {
        return $this->date_debut;
    }

    public function getDateFin() {
        return $this->date_fin;
    }

    public function getIdPack() {
        return $this->id_pack;
    }

    public function isActif() {
        return $this->actif;
    }

    // Setters
    public function setIdCode($id_code) {
        $this->id_code = $id_code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setReduction($reduction) {
        $this->reduction = $reduction;
    }

    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function setIdPack($id_pack) {
        $this->id_pack = $id_pack;
    }

    public function setActif($actif) {
        $this->actif = $actif;
    }
}
?>
