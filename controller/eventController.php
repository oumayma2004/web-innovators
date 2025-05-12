<?php
require_once '../model/eventModel.php';

class EventController {
    private $db;
    private $eventModel;

    public function __construct($db) {
        $this->db = $db;
        $this->eventModel = new EventModel($db);
    }

    public function handleAdd($postData, $fileData) {
        // Default image filename
        $imageFileName = null;

        // Handle image upload
        if (isset($fileData['image']) && $fileData['image']['error'] === 0) {
            $imageName = time() . '_' . basename($fileData['image']['name']);
            $targetDir = '../uploads/';
            $targetPath = $targetDir . $imageName;

            // Only allow image extensions
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (in_array($fileData['image']['type'], $allowedTypes)) {
                if (move_uploaded_file($fileData['image']['tmp_name'], $targetPath)) {
                    $imageFileName = $imageName;
                } else {
                    echo "Image upload failed.";
                    return;
                }
            } else {
                echo "Invalid image type.";
                return;
            }
        }

        // Add event to database
        $this->eventModel->addEvent([
            ':nom_e' => $postData['nom_e'],
            ':date_de_e' => $postData['date_de_e'],
            ':date_f_e' => $postData['date_f_e'],
            ':lieu_e' => $postData['lieu_e'],
            ':prix_e' => $postData['prix_e'],
            ':etat_e' => $postData['etat_e'],
            ':category_e' => $postData['category_e'],
            ':desc_e' => $postData['desc_e'],
            ':image' => $imageFileName
        ]);

        header("Location: ./pages/tables.php");
        exit;
    }

    public function showDashboard() {
        return $this->eventModel->getAllEvents();
    }

    public function showFrontOffice() {
        return $this->eventModel->getActiveUpcomingEvents();
    }

    public function getEventById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM gestion_event WHERE id_event = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function deleteEvent($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM gestion_event WHERE id_event = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
