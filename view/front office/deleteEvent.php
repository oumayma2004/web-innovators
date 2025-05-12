<?php
    // Include your database connection file
    require_once '../config.php';
    $db = config::getConnexion();

    if (isset($_POST['id_event']) && is_numeric($_POST['id_event'])) {
        $id_event = $_POST['id_event'];

        // Prepare the SQL query to delete the event
        $query = "DELETE FROM gestion_event WHERE id_event = ?";
        $stmt = $db->prepare($query);

        // Execute the query
        if ($stmt->execute([$id_event])) {
            echo 'success';  // Respond with success
        } else {
            // Log error details to the server log for debugging
            error_log("Error deleting event with ID: $id_event");
            echo 'error';  // Respond with error if deletion fails
        }
    } else {
        // Log invalid ID input for debugging
        error_log("Invalid ID provided for deletion");
        echo 'error';  // Respond with error if no valid ID is provided
    }
?>
