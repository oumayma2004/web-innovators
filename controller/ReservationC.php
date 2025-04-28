<?php
require_once '../../config.php';
require_once '../../Model/reservation.php';
require_once '../../Model/pack.php';  // Inclure le modèle de pack pour accéder à la table `pack`

class ReservationC {
    // Ajouter une réservation
    public function addReservation($reservation) {
        try {
            $db = config::getConnexion();

            // Démarrer une transaction pour s'assurer que les deux changements (réservation + mise à jour du pack) sont effectués ensemble
            $db->beginTransaction();

            // Insérer la réservation
            $sql = "INSERT INTO reservation (user_id, pack_id, date_reservation) 
                    VALUES (:user_id, :pack_id, :date_reservation)";
            $query = $db->prepare($sql);
            $query->execute([
                'user_id' => $reservation->getUserId(),
                'pack_id' => $reservation->getPackId(),
                'date_reservation' => $reservation->getDateReservation()
            ]);

            // Mettre à jour le nombre de places dans le pack
            $this->updatePackSeats($reservation->getPackId());

            // Si tout est correct, valider la transaction
            $db->commit();
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $db->rollBack();
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    public function searchReservation($input) {
        try {
            $db = config::getConnexion();
    
            // Requête pour rechercher par nom d'utilisateur ou titre de pack
            $sql = "
                SELECT r.* 
                FROM reservation r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN pack p ON r.pack_id = p.id
                WHERE u.nom LIKE :input OR p.titre LIKE :input
            ";
    
            $query = $db->prepare($sql);
            $query->bindValue(':input', '%' . $input . '%');
            $query->execute();
    
            return $query->fetchAll(PDO::FETCH_ASSOC);  // Retourne les réservations correspondantes
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
    function getAllPacksReservationCount() {
        try {
            $db = config::getConnexion();
            $sql = "
                SELECT p.id, p.titre, COUNT(r.id) AS reservation_count
                FROM reservation r
                INNER JOIN pack p ON r.pack_id = p.id
                GROUP BY p.id
                ORDER BY reservation_count DESC
            ";
    
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
    public function getReservationStats()
{
    try {
        $db = config::getConnexion();
        $sql = "SELECT p.titre AS pack_name, COUNT(r.id) AS total_reservations
                FROM reservation r
                JOIN pack p ON r.pack_id = p.id
                GROUP BY r.pack_id";
        $query = $db->query($sql);
        return $query->fetchAll();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}

    
    public function getMostReservedPack() {
        try {
            $db = config::getConnexion();
            $sql = "
                SELECT p.titre, COUNT(r.id) AS reservation_count
                FROM reservation r
                INNER JOIN pack p ON r.pack_id = p.id
                GROUP BY p.id
                ORDER BY reservation_count DESC
                LIMIT 1
            ";
    
            $query = $db->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }
    
    public function getPacksReservationStats() {
        try {
            $db = config::getConnexion();
            $sql = "
                SELECT p.titre, COUNT(r.id) AS reservation_count
                FROM reservation r
                INNER JOIN pack p ON r.pack_id = p.id
                GROUP BY p.id
                ORDER BY reservation_count DESC
            ";
    
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
        
    

    public function getReservationsByUserId($userId) {
        $sql = "SELECT * FROM reservation WHERE user_id = :user_id";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return [];
        }
    }
    
    // Récupérer toutes les réservations
    public function getAllReservations() {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM reservation";
            $query = $db->query($sql);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: '.$e->getMessage());
        }
    }
    
    public function getPackById($id) {
        $sql = "SELECT * FROM pack WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: '.$e->getMessage());
        }
    }

    // Récupérer une réservation par son ID
    public function getReservationById($id) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM reservation WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    // Mettre à jour une réservation
    public function updateReservation($reservation) {
        try {
            $db = config::getConnexion();
            $sql = "UPDATE reservation SET user_id = :user_id, pack_id = :pack_id, date_reservation = :date_reservation 
                    WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute([
                'user_id' => $reservation->getUserId(),
                'pack_id' => $reservation->getPackId(),
                'date_reservation' => $reservation->getDateReservation(),
                'id' => $reservation->getId()
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Supprimer une réservation
    public function deleteReservation($id) {
        try {
            $db = config::getConnexion();
            $sql = "DELETE FROM reservation WHERE id = :id";
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Chercher une réservation par ID d'utilisateur et ID de pack
    public function chercherReservation($user_id, $pack_id) {
        try {
            $db = config::getConnexion();
            $sql = "SELECT * FROM reservation WHERE user_id = :user_id AND pack_id = :pack_id";
            $query = $db->prepare($sql);
            $query->execute(['user_id' => $user_id, 'pack_id' => $pack_id]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    // Méthode pour mettre à jour le nombre de places disponibles dans un pack
    private function updatePackSeats($pack_id) {
        try {
            $db = config::getConnexion();

            // Récupérer le nombre de places restantes dans le pack
            $sql = "SELECT nombre_places FROM pack WHERE id = :pack_id";
            $query = $db->prepare($sql);
            $query->execute(['pack_id' => $pack_id]);
            $pack = $query->fetch();

            // Vérifier si des places sont disponibles
            if ($pack && $pack['nombre_places'] > 0) {
                // Décrémenter le nombre de places restantes
                $newSeats = $pack['nombre_places'] - 1;
                $sql = "UPDATE pack SET nombre_places = :nombre_places WHERE id = :pack_id";
                $query = $db->prepare($sql);
                $query->execute([
                    'nombre_places' => $newSeats,
                    'pack_id' => $pack_id
                ]);
            } else {
                throw new Exception('Aucune place disponible pour ce pack.');
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
