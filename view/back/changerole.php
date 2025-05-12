<?php
include '../../controller/userc.php'; 

if (isset($_GET["id"])) {
    // Get the user ID from the URL
    $userId = $_GET["id"];
    
    // Create an instance of userc
    $userc = new userc();
    
    // Call the method to toggle the user's role
    if ($userc->toggleUserRole($userId)) {
        // Redirect back to the users page after successful role toggle
        header('Location: user.php');
        exit();
    } else {
        // Error message if toggling the role failed
        echo "Error toggling user role!";
    }
} else {
    // Error message if no user ID is provided
    echo "User ID not provided!";
}
?>
