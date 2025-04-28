<?php
require_once('src/tcpdf/tcpdf.php');
require_once '../../Model/user.php'; 
require_once '../../config.php';
require_once '../../Controller/userc.php'; 

// Check if the 'PDF' button was pressed and 'id' is set in POST
if(isset($_POST['PDF']) && isset($_POST['id']) && !empty($_POST['id'])) {
    ob_start();

    $id = $_POST['id'];  // Get the ID from POST request

    // Instantiate the user controller and fetch user by ID
    $userc = new userc(); 
    $user = $userc->getUserById($id);  // Fetch user by ID

    // Check if the user exists
    if ($user) {
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company Name');
        $pdf->SetTitle('User Profile PDF');
        $pdf->SetSubject('User Profile Details');
        $pdf->SetKeywords('User, Profile, PDF');

        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 12);

        // Display the user details in the PDF
        $html = "<h2>User Profile Details</h2>";
        $html .= "<p><strong>First Name:</strong> {$user['prenom']}</p>";
        $html .= "<p><strong>Last Name:</strong> {$user['nom']}</p>";
        $html .= "<p><strong>Email:</strong> {$user['email']}</p>";
        $html .= "<p><strong>Phone Number:</strong> {$user['phone']}</p>";
        $html .= "<p><strong>Address:</strong> {$user['adresse']}</p>";
        $html .= "<p><strong>Role:</strong> {$user['role']}</p>";
        $html .= "<p><strong>Profile Picture:</strong> <img src='{$user['photo']}' alt='Profile Picture' width='50'></p>";

        // Write the HTML content to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Generate and download the PDF file
        $pdf->Output('user_profile.pdf', 'D');
    } else {
        // If no user is found or the ID is invalid, display an error message
        echo "User not found or invalid ID.";
    }

    // End the output buffer
    ob_end_flush();
} else {
    // If the 'id' is not set or the form was not submitted properly
    echo "Error: No user ID provided.";
}
?>
