<?php
include '../../controller/packc.php'; 
$packc = new packc(); 

// Check if there is a search input
if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $_GET['input'];
    $list = $packc->searchPacks($searchInput);  // Assuming you have a search method for packs
    
    // If search results are found, display them
    if (!empty($list)) {
        foreach ($list as $pack) {
            echo "<div class='pack-card'>";
            echo "<h2 class='pack-title'>" . htmlspecialchars($pack['titre']) . "</h2>";
            echo "<p class='pack-description'>" . htmlspecialchars($pack['description']) . "</p>";
            echo "<p class='pack-price'>TND " . htmlspecialchars($pack['prix']) . "</p>";
            echo "<p class='pack-places'>Places disponibles: " . htmlspecialchars($pack['nombre_places']) . "</p>";
            echo "<p class='pack-places'>Date: " . htmlspecialchars($pack['date_d']) . "</p>";
            echo "<a href='javascript:void(0);' class='btn' onclick='openModal(" . htmlspecialchars($pack['id']) . ", \"" . htmlspecialchars($pack['titre']) . "\", \"TND " . htmlspecialchars($pack['prix']) . "\", \"" . htmlspecialchars($pack['description']) . "\")'>Réserver</a>";
            echo "</div>";
        }
    } else {
        echo "<div style='font-size:20px'>Aucun pack trouvé</div>"; // No results found
    }
} else {
    // If no search term is provided, show the entire list of packs
    $list = $packc->searchPacks("");  // Assuming you can pass an empty string to get all packs

    foreach ($list as $pack) {
        echo "<div class='pack-card'>";
        echo "<h2 class='pack-title'>" . htmlspecialchars($pack['titre']) . "</h2>";
        echo "<p class='pack-description'>" . htmlspecialchars($pack['description']) . "</p>";
        echo "<p class='pack-price'>TND " . htmlspecialchars($pack['prix']) . "</p>";
        echo "<p class='pack-places'>Places disponibles: " . htmlspecialchars($pack['nombre_places']) . "</p>";
        echo "<p class='pack-places'>Date: " . htmlspecialchars($pack['date_d']) . "</p>";
        echo "<a href='javascript:void(0);' class='btn' onclick='openModal(" . htmlspecialchars($pack['id']) . ", \"" . htmlspecialchars($pack['titre']) . "\", \"TND " . htmlspecialchars($pack['prix']) . "\", \"" . htmlspecialchars($pack['description']) . "\")'>Réserver</a>";
        echo "</div>";
    }
}
?>
