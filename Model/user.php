<?php
class User {
    private $nom;
    private $prenom;
    private $date_c;
    private $photo;
    private $adresse;
    private $password;
    private $email;
    private $phone;

    public function __construct($nom, $prenom, $date_c, $photo, $adresse, $password, $email, $phone) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_c = $date_c;
        $this->photo = $photo;
        $this->adresse = $adresse;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
    }
    //getters
    public function getNom() {
        return $this->nom;
    }
    public function getPrenom() {
        return $this->prenom;
    }

    public function getDateC() {
        return $this->date_c;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }
    public function getPhone() {
        return $this->phone;
    }
    //setters
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setDateC($date_c) {
        $this->date_c = $date_c;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
}
?>
