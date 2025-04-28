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
            echo "<tr>";
            echo "<td>
                    <div class='d-flex px-2 py-1'>
                        <div>
                            " . htmlspecialchars($pack['id']) . "
                        </div>
                    </div>
                  </td>";
            echo "<td>
                    <div class='avatar-group mt-2'>
                        " . htmlspecialchars($pack['titre']) . "
                    </div>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['description']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['prix']) . " €</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['nombre_places']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['date_d']) . "</span>
                  </td>";
            echo "<td class='align-middle'>
                    <a href='deletepack.php?id=" . htmlspecialchars($pack['id']) . "' class='btn btn-danger'>
                        <i class='fa-solid fa-trash'></i> Delete
                    </a>
                  </td>";
            echo "<td class='align-middle'>
                    <a href='updatepack.php?id=" . htmlspecialchars($pack['id']) . "' class='btn btn-primary'>
                        <i class='fa-solid fa-pen'></i> Update
                    </a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<div style='font-size:20px'>Aucun pack trouvé</div>"; // No results found
    }
} else {
    // If no search term is provided, show the entire list of packs
    $list = $packc->searchPacks("");  // Assuming you can pass an empty string to get all packs

    foreach ($list as $pack) {
        echo "<tr>";
        echo "<td>
                <div class='d-flex px-2 py-1'>
                    <div>
                        " . htmlspecialchars($pack['id']) . "
                    </div>
                </div>
              </td>";
        echo "<td>
                <div class='avatar-group mt-2'>
                    " . htmlspecialchars($pack['titre']) . "
                </div>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['description']) . "</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['prix']) . " €</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['nombre_places']) . "</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($pack['date_d']) . "</span>
              </td>";
        echo "<td class='align-middle'>
                <a href='deletepack.php?id=" . htmlspecialchars($pack['id']) . "' class='btn btn-danger'>
                    <i class='fa-solid fa-trash'></i> Delete
                </a>
              </td>";
        echo "<td class='align-middle'>
                <a href='updatepack.php?id=" . htmlspecialchars($pack['id']) . "' class='btn btn-primary'>
                    <i class='fa-solid fa-pen'></i> Update
                </a>
              </td>";
        echo "</tr>";
    }
}
?>
