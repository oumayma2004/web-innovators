<?php
class Reservation {
    private $id;
    private $user_id;
    private $pack_id;
    private $date_reservation;

    public function __construct($id, $user_id, $pack_id, $date_reservation) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->pack_id = $pack_id;
        $this->date_reservation = $date_reservation;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getPackId() {
        return $this->pack_id;
    }

    public function getDateReservation() {
        return $this->date_reservation;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setPackId($pack_id) {
        $this->pack_id = $pack_id;
    }

    public function setDateReservation($date_reservation) {
        $this->date_reservation = $date_reservation;
    }
}
?>
