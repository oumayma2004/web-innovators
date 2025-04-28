<?php
include '../../controller/codePromoc.php';  
$codePromoc = new codePromoc(); 

// Check if there is a search input
if (isset($_GET['input']) && !empty($_GET['input'])) {
    $searchInput = $_GET['input'];
    $list = $codePromoc->searchCodePromo($searchInput);  // Search method for codePromo
    
    // If search results are found, display them
    if (!empty($list)) {
        foreach ($list as $codePromo) {
            echo "<tr>";
            echo "<td>
                    <div class='d-flex px-2 py-1'>
                        <div>
                            " . htmlspecialchars($codePromo['id_code']) . "
                        </div>
                    </div>
                  </td>";
            echo "<td>
                    <div class='avatar-group mt-2'>
                        " . htmlspecialchars($codePromo['code']) . "
                    </div>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['reduction']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['date_debut']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['date_fin']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['id_pack']) . "</span>
                  </td>";
            echo "<td class='align-middle text-center text-sm'>
                    <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['actif']) . "</span>
                  </td>";
            echo "<td class='align-middle'>
                    <a href='deletecodep.php?id_code=" . htmlspecialchars($codePromo['id_code']) . "' class='btn btn-danger'>
                        <i class='fa-solid fa-trash'></i> Delete
                    </a>
                  </td>";
            echo "<td class='align-middle'>
                    <a href='updatecodeP.php?id_code=" . htmlspecialchars($codePromo['id_code']) . "' class='btn btn-primary'>
                        <i class='fa-solid fa-pen'></i> Update
                    </a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<div style='font-size:20px'>Aucun code promo trouvé</div>"; // No results found
    }
} else {
    // If no search term is provided, show the entire list of promo codes
    $list = $codePromoc->searchCodePromo("");  // Assuming you can pass an empty string to get all code promos

    foreach ($list as $codePromo) {
        echo "<tr>";
        echo "<td>
                <div class='d-flex px-2 py-1'>
                    <div>
                        " . htmlspecialchars($codePromo['id_code']) . "
                    </div>
                </div>
              </td>";
        echo "<td>
                <div class='avatar-group mt-2'>
                    " . htmlspecialchars($codePromo['code']) . "
                </div>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['reduction']) . "</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['date_debut']) . "</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['date_fin']) . "</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['id_pack']) . "</span>
              </td>";
        echo "<td class='align-middle text-center text-sm'>
                <span class='text-xs font-weight-bold'>" . htmlspecialchars($codePromo['actif']) . "</span>
              </td>";
        echo "<td class='align-middle'>
                <a href='deletecodep.php?id_code=" . htmlspecialchars($codePromo['id_code']) . "' class='btn btn-danger'>
                    <i class='fa-solid fa-trash'></i> Delete
                </a>
              </td>";
        echo "<td class='align-middle'>
                <a href='updatecodeP.php?id_code=" . htmlspecialchars($codePromo['id_code']) . "' class='btn btn-primary'>
                    <i class='fa-solid fa-pen'></i> Update
                </a>
              </td>";
        echo "</tr>";
    }
}
?>
