<?php
include '../../controller/userc.php'; 
$userc = new userc(); 

// Check if there is a search input
if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $_GET['input'];
    $list = $userc->searchUsers($searchInput); 
    
    // If search results are found, display them
    if (!empty($list)) {
        foreach ($list as $user) {
            echo "<tr>";
            echo "<td>
                    <div class='d-flex px-2 py-1'>
                        <div>";
            if (!empty($user['photo'])) {
                echo "<img style='width: 50px; height: 50px;' src='" . htmlspecialchars($user['photo']) . "' alt='User Photo'>";
            } else {
                echo "<span>No Photo</span>";
            }
            echo "</div></div></td>";
            echo "<td>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['nom']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['prenom']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['password']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['adresse']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['date_c']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['phone']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($user['role']) . "</td>";
            echo "<td class='text-center'>
                    <form action='deleteuser.php' method='GET'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($user['id']) . "'>
                        <button type='submit' class='delete-btn'>
                            <i class='fa-solid fa-trash'></i>
                        </button>
                    </form>
                  </td>";
            echo "<td class='text-center'>
                    <form action='changerole.php' method='GET'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($user['id']) . "'>
                        <button type='submit'>
                            <i>Changer Role</i>
                        </button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<div style='font-size:20px'>Aucun utilisateur trouvé</div>"; // No results found
    }
} else {
    // If no search term is provided, show the entire list of users
    $list = $userc->searchUsers(""); // Pass an empty string to get all users

    foreach ($list as $user) {
        echo "<tr>";
        echo "<td>
                <div class='d-flex px-2 py-1'>
                    <div>";
        if (!empty($user['photo'])) {
            echo "<img style='width: 50px; height: 50px;' src='" . htmlspecialchars($user['photo']) . "' alt='User Photo'>";
        } else {
            echo "<span>No Photo</span>";
        }
        echo "</div></div></td>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['nom']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['prenom']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['password']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['adresse']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['date_c']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['phone']) . "</td>";
        echo "<td class='text-center'>" . htmlspecialchars($user['role']) . "</td>";
        echo "<td class='text-center'>
                <form action='deleteuser.php' method='GET'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($user['id']) . "'>
                    <button type='submit' class='delete-btn'>
                        <i class='fa-solid fa-trash'></i>
                    </button>
                </form>
              </td>";
        echo "<td class='text-center'>
                <form action='changerole.php' method='GET'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($user['id']) . "'>
                    <button type='submit'>
                        <i>Changer Role</i>
                    </button>
                </form>
              </td>";
        echo "</tr>";
    }
}
?>
