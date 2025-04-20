<?php
class Reclamation
{
    public $id_reclamation;
    public $nom;
    public $email;
    public $tel;
    public $date_creation;
    public $etat;
    public $type_reclamation;
    public $evenement_concerne;
    public $description;

    public function __construct($id_reclamation, $nom, $email, $tel, $date_creation, $etat, $type_reclamation, $evenement_concerne, $description)
    {
        $this->id_reclamation = $id_reclamation;
        $this->nom = $nom;
        $this->email = $email;
        $this->tel = $tel;
        $this->date_creation = $date_creation;
        $this->etat = $etat;
        $this->type_reclamation = $type_reclamation;
        $this->evenement_concerne = $evenement_concerne;
        $this->description = $description;
    }

    // Getters et Setters
    public function getId() {
        return $this->id_reclamation;
    }

    public function setId($id) {
        $this->id_reclamation = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTel() {
        return $this->tel;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }

    public function setDateCreation($date) {
        $this->date_creation = $date;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
    }

    public function getTypeReclamation() {
        return $this->type_reclamation;
    }

    public function setTypeReclamation($type) {
        $this->type_reclamation = $type;
    }

    public function getEvenementConcerne() {
        return $this->evenement_concerne;
    }

    public function setEvenementConcerne($event) {
        $this->evenement_concerne = $event;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($desc) {
        $this->description = $desc;
    }
}
?>
