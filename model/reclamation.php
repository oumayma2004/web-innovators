<?php
class Reclamation
{
    private $id_reclamation;
    private $nom;
    private $email;
    private $tel;
    private $date_creation;
    private $etat;
    private $type_reclamation;
    private $evenement_concerne;
    private $description;

    public function __construct(
        $id_reclamation = null,
        $nom,
        $email,
        $tel,
        $type_reclamation,
        $evenement_concerne,
        $description,
        $etat = 'en attente',
        $date_creation = null
    ) {
        $this->id_reclamation = $id_reclamation;
        $this->nom = $nom;
        $this->email = $email;
        $this->tel = $tel;
        $this->type_reclamation = $type_reclamation;
        $this->evenement_concerne = $evenement_concerne;
        $this->description = $description;
        $this->etat = $etat;
        $this->date_creation = $date_creation ?? date('Y-m-d');
    }

    // Getters
    public function getId() {
        return $this->id_reclamation;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTel() {
        return $this->tel;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function getTypeReclamation() {
        return $this->type_reclamation;
    }

    public function getEvenementConcerne() {
        return $this->evenement_concerne;
    }

    public function getDescription() {
        return $this->description;
    }

    // Setters
    public function setId($id) {
        $this->id_reclamation = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function setDateCreation($date) {
        $this->date_creation = $date;
    }

    public function setEtat($etat) {
        if (in_array($etat, ['en attente', 'repondu'])) {
            $this->etat = $etat;
        }
    }

    public function setTypeReclamation($type) {
        $this->type_reclamation = $type;
    }

    public function setEvenementConcerne($event) {
        $this->evenement_concerne = $event;
    }

    public function setDescription($desc) {
        $this->description = $desc;
    }
}
?>
