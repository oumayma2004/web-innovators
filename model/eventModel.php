<?php
class EventModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Add new event with image support
    public function addEvent($data) {
        $sql = "INSERT INTO gestion_event 
            (nom_e, date_de_e, date_f_e, lieu_e, prix_e, etat_e, category_e, desc_e, image)
            VALUES (:nom_e, :date_de_e, :date_f_e, :lieu_e, :prix_e, :etat_e, :category_e, :desc_e, :image)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Show all events (for dashboard)
    public function getAllEvents() {
        return $this->db->query("SELECT * FROM gestion_event ORDER BY date_de_e DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    // Show only active & upcoming events (for front-office)
    public function getActiveUpcomingEvents() {
        $stmt = $this->db->prepare(
            "SELECT * FROM gestion_event 
             WHERE etat_e = 'active' AND date_de_e >= CURDATE() 
             ORDER BY date_de_e ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
