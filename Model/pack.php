<?php
class Pack {
    private $id;
    private $titre;
    private $description;
    private $prix;
    private $nombre_places;
    private $date_d;

    public function __construct($id, $titre, $description, $prix, $nombre_places,  $date_d) {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->prix = $prix;
        $this->nombre_places = $nombre_places;
        $this->date_d = $date_d;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function getNombrePlaces() {
        return $this->nombre_places;
    }

    
    public function getDateD() {
        return $this->date_d;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function setNombrePlaces($nombre_places) {
        $this->nombre_places = $nombre_places;
    }

    public function setDateD($date_d) {
        $this->date_d = $date_d;
    }
}
?>
