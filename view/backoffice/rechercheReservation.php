<?php
include '../../controller/ReservationC.php'; 
$ReservationC = new ReservationC();  // Assuming this is your controller class

// Check if there is a search input
if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $_GET['input'];
    $list = $ReservationC->searchReservation($searchInput);  // Assuming you have a method to search for reservations by user or pack

    // If search results are found, display them
    if (!empty($list)) {
        foreach ($list as $Reservation) {
            // Assuming the getUserById() and getPackById() methods exist in your controller
            $user = $ReservationC->getUserById($Reservation['user_id']);
            $pack = $ReservationC->getPackById($Reservation['pack_id']);
            
            echo "<tr>";
            echo "<td>
                    <div class='d-flex px-2 py-1'>
                        <div>" . htmlspecialchars($Reservation['id']) . "</div>
                    </div>
                  </td>";
            echo "<td>
                    <div class='d-flex align-items-center'>" . htmlspecialchars($user['nom']) . "</div>
                  </td>";
            echo "<td class='align-middle text-center'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['titre']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($Reservation['date_reservation']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center'>
                    <a href='deletereservation.php?id=" . urlencode($Reservation['id']) . "' class='btn btn-danger btn-sm'>
                        <i class='fa fa-trash'></i> Supprimer
                    </a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<div style='font-size:20px'>Aucune réservation trouvée</div>";  // No results found
    }
} else {
    // If no search term is provided, show the entire list of reservations
    $list = $ReservationC->getAllReservations();  // Assuming this method returns all reservations

    foreach ($list as $Reservation) {
        $user = $ReservationC->getUserById($Reservation['user_id']);
        $pack = $ReservationC->getPackById($Reservation['pack_id']);
        
        echo "<tr>";
        echo "<td>
                <div class='d-flex px-2 py-1'>
                    <div>" . htmlspecialchars($Reservation['id']) . "</div>
                </div>
              </td>";
        echo "<td>
                <div class='d-flex align-items-center'>" . htmlspecialchars($user['nom']) . "</div>
              </td>";
        echo "<td class='align-middle text-center'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['titre']) . "</span>
              </td>";
        echo "<td class='align-middle text-center'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($Reservation['date_reservation']) . "</span>
              </td>";
        echo "<td class='align-middle text-center'>
                <a href='deletereservation.php?id=" . urlencode($Reservation['id']) . "' class='btn btn-danger btn-sm'>
                    <i class='fa fa-trash'></i> Supprimer
                </a>
              </td>";
        echo "</tr>";
    }
}
?>
