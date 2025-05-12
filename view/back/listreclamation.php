<?php
include_once "../../config.php";
include_once "../../controller/reclamationC.php";
include_once "../../controller/ReponseC.php";

// Création des contrôleurs
$reclamationC = new ReclamationC();
$reponseC = new ReponseC();

// Paramètres pour Réclamations
$searchReclamation = isset($_GET['searchReclamation']) ? $_GET['searchReclamation'] : '';
$etatFilter = isset($_GET['etat']) ? $_GET['etat'] : '';
$sortReclamation = isset($_GET['sortReclamation']) ? $_GET['sortReclamation'] : 'ASC';
$pageReclamation = isset($_GET['pageReclamation']) ? (int)$_GET['pageReclamation'] : 1;
$limit = 3;
$offsetReclamation = ($pageReclamation - 1) * $limit;

// Paramètres pour Réponses
$searchReponse = isset($_GET['searchReponse']) ? $_GET['searchReponse'] : '';
$sortReponse = isset($_GET['sortReponse']) ? $_GET['sortReponse'] : 'ASC';
$pageReponse = isset($_GET['pageReponse']) ? (int)$_GET['pageReponse'] : 1;
$offsetReponse = ($pageReponse - 1) * $limit;

// Récupération des réclamations
$totalReclamations = $reclamationC->countReclamationsWithSearch($searchReclamation, $etatFilter);
$totalPagesReclamations = ceil($totalReclamations / $limit);
$listReclamations = $reclamationC->fetchFilteredSortedReclamations($searchReclamation, $sortReclamation, $limit, $offsetReclamation, $etatFilter);

// Récupération des réponses
$totalReponses = $reponseC->countReponsesWithSearch($searchReponse);
$totalPagesReponses = ceil($totalReponses / $limit);
$listReponses = $reponseC->fetchFilteredSortedReponses($searchReponse, $sortReponse, $limit, $offsetReponse);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/tfarhida.png">
  <title>
    Material Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="assets/img/tfarhida.png" class="navbar-brand-img" width="150" height="150" alt="main_logo">
        <span class="ms-1 text-sm text-dark"></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/dashboard.html">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
                <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="#reclamationMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reclamationMenu">
            <i class="material-symbols-rounded opacity-5">report_problem</i>
            <span class="nav-link-text ms-1">Réclamations</span>
          </a>

        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="pages/liste_sponsors.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">sponsor</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-dark" href="user.php">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">user</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="pack.php">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">pack</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tables</li>
          </ol>
        </nav>
        <!-- settings eli zedethomm  -->
        <div class="d-flex ms-auto"> <!-- Conteneur flex poussé à droite -->
  <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
      <div class="sidenav-toggler-inner">
        <i class="sidenav-toggler-line"></i>
        <i class="sidenav-toggler-line"></i>
        <i class="sidenav-toggler-line"></i>
      </div>
    </a>
  </li>
  <li class="nav-item px-3 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-body p-0">
      <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
    </a>
  </li>
</div>
           
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="input-group input-group-outline">
        <form method="GET" class="d-flex justify-content-center align-items-center my-5 gap-3">
          
       
  <!-- Champ de recherche -->
  <div class="input-group input-group-outline me-2" style="max-width: 300px;">
    <label class="form-label" style="transform: translateY(-24px) scale(0.8); color: #6c757d; transition: all 0.2s;">Rechercher</label>
    <input type="text" 
           class="form-control" 
           name="searchReclamation" 
           value="<?php echo isset($_GET['searchReclamation']) ? htmlspecialchars($_GET['searchReclamation']) : ''; ?>"
           style="padding: 12px 16px; border-radius: 8px; border: 1px solid #e0e0e0; background-color: #f8f9fa;">
    <span class="position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;">

    </span>
  </div>

  <!-- Filtrage par état -->
  <div class="input-group input-group-outline me-2" style="max-width: 250px;">
    <label class="form-label" style="transform: translateY(-24px) scale(0.8); color: #6c757d; transition: all 0.2s;">Filtrer par État</label>
    <select name="etat" class="form-control" style="
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background-color: #f8f9fa;
        color: #495057;
        font-size: 14px;
        transition: all 0.3s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill=\"%236c757d\" height=\"24\" viewBox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>');
        background-repeat: no-repeat;
        background-position: right 8px center;
    ">
        <option value=""></option>
        <option value="pending" <?php if (isset($_GET['etat']) && $_GET['etat'] == 'pending') echo 'selected'; ?>>En attente</option>
        <option value="repondu" <?php if (isset($_GET['etat']) && $_GET['etat'] == 'repondu') echo 'selected'; ?>>Répondu</option>
    </select>
  </div>

  <!-- Boutons -->
  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4" style="height: 44px; border-radius: 8px;">
      <i class="fas fa-search me-2"></i>Filtrer
    </button>
    <a href="?page=1" class="btn btn-outline-secondary px-4" style="height: 44px; border-radius: 8px;">
      <i class="fas fa-undo me-2"></i>Réinitialiser
    </a>
  </div>
</form>

<style>
  .form-control, .form-select {
    border: 1px solid #e0e0e0;
    transition: all 0.3s;
  }
  
  .form-control:focus, select:focus {
    outline: none;
    border-color: #d63384;
    box-shadow: 0 0 0 2px rgba(74, 139, 252, 0.2);
    background-color: white;
  }
  
  .input-group:focus-within label {
    color: #d63384 !important;
  }
  
  .form-control:hover, select:hover {
    border-color: #adb5bd;
  }
  
  option {
    padding: 8px 12px;
  }
  
  option:hover {
    background-color: #e9ecef !important;
  }
  
  @media (max-width: 768px) {
    form {
      flex-direction: column;
      align-items: stretch;
      gap: 1rem !important;
    }
    
    .input-group {
      max-width: 100% !important;
      width: 100%;
    }
  }
</style>

            </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">

            
          <li class="nav-item d-flex align-items-center">
  <a href="../pages/sign-in.html" class="nav-link px-0 position-relative">
    <span class="icon-backdrop bg-gradient-pink rounded-circle d-flex align-items-center justify-content-center" 
          style="width: 36px; height: 36px; box-shadow: 0 4px 6px rgba(233, 30, 99, 0.3);">
      <i class="material-symbols-rounded text-white" style="font-size: 20px;">account_circle</i>
    </span>
  </a>
</li>

<style>
  .bg-gradient-pink {
    background: linear-gradient(135deg, #ff80ab 0%, #ff4081 100%);
  }
  .icon-backdrop:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
  }
</style>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-pink shadow-pink border-radius-lg pt-4 pb-3" style="background: linear-gradient(195deg, #ec407a, #d81b60);">
    <h6 class="text-white text-capitalize ps-3">Table Reclamation</h6>
</div>
            </div>
            <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
  <thead>
    <tr>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nom</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Téléphone</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">État</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Événement</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($listReclamations as $rec): ?>
      <tr>
        <td><p class="text-sm mb-0">RC-<?= htmlspecialchars($rec['id_reclamation']) ?></p></td>
        <td><p class="text-sm mb-0"><?= htmlspecialchars($rec['nom']) ?></p></td>
        <td><p class="text-sm mb-0"><?= htmlspecialchars($rec['email']) ?></p></td>
        <td><p class="text-sm mb-0"><?= htmlspecialchars($rec['tel']) ?></p></td>
        <td><p class="text-sm mb-0"><?= htmlspecialchars($rec['date_creation']) ?></p></td>
        <td>
          <span class="badge bg-gradient-<?= $rec['etat'] === 'repondu' ? 'success' : 'primary' ?>">
            <?= htmlspecialchars($rec['etat']) ?>
          </span>
        </td>
        <td><p class="text-sm mb-0"><?= htmlspecialchars($rec['type_reclamation']) ?></p></td>
        <td><p class="text-sm mb-0"><?= htmlspecialchars($rec['evenement_concerne']) ?></p></td>
        <td><p class="text-sm mb-0"><?= nl2br(htmlspecialchars($rec['description'])) ?></p></td>
        <td class="text-center">
          <a href="repondrerec.php?id=<?= $rec['id_reclamation'] ?>" class="btn btn-primary">repondre </a>
          <a href="supprimerReclamation.php?id=<?= $rec['id_reclamation'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette réclamation ?');">Supprimer</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<style>
.pagination {
    margin: 20px 0;
    display: flex;
    justify-content: center;
    gap: 5px;
}

.pagination a {
    color: #d63384; /* Rose foncé */
    background-color: #fff;
    border: 1px solid #d63384;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.pagination a:hover {
    background-color: #d63384;
    color: white;
}

/* Style pour la page active (vous devrez ajouter une classe 'active' au lien de la page courante) */
.pagination a.active {
    background-color: #d63384;
    color: white;
    font-weight: bold;
}
</style>
</div>
</div>
<?php
$totalPagesReclamations = ceil($totalReclamations / $limit);
$currentPageReclamation = isset($_GET['pageReclamation']) ? (int)$_GET['pageReclamation'] : 1;

echo '<div class="pagination">';
for ($i = 1; $i <= $totalPagesReclamations; $i++) {
    $activeClass = ($i == $currentPageReclamation) ? 'active' : '';
    echo "<a class='$activeClass' href='?pageReclamation=$i&searchReclamation=" . urlencode($searchReclamation) . "&etat=" . urlencode($etatFilter) . "&sortReclamation=" . urlencode($sortReclamation) . "'>$i</a> ";
}
echo '</div>';
?>
</div>

            </div>
          </div>
        </div>
      </div>


    <!--        ///////////////////////////      table reponse         /////////////////////// -->
      <div class="container-fluid py-2">
      
      <div class="row">

      <div class="input-group input-group-outline">
      <form method="GET" class="d-flex justify-content-center align-items-center my-5" style="max-width: 600px; margin: 0 auto;">
    <div class="d-flex align-items-center gap-3 w-100">
        <!-- Champ de recherche pour Réponses -->
        <div class="input-group input-group-outline me-2 flex-grow-1">
            <label class="form-label" style="transform: translateY(-24px) scale(0.8); color: #6c757d; transition: all 0.2s;">Rechercher</label>
            <input type="text" 
                   class="form-control" 
                   name="searchReponse" 
                   value="<?php echo isset($_GET['searchReponse']) ? htmlspecialchars($_GET['searchReponse']) : ''; ?>"
                   style="padding: 12px 16px; border-radius: 8px; border: 1px solid #e0e0e0; background-color: #f8f9fa;">
            <span class="position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;">

            </span>
        </div>

        <!-- Boutons -->
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary px-4" style="height: 44px; border-radius: 8px;">
                <i class="fas fa-search me-2"></i>Rechercher
            </button>
            <a href="?pageReponse=1" class="btn btn-outline-secondary px-4" style="height: 44px; border-radius: 8px;">
                <i class="fas fa-undo me-2"></i>Réinitialiser
            </a>
        </div>
    </div>
</form>

<style>
    .form-control {
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
        padding-left: 40px !important;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #d63384;
        box-shadow: 0 0 0 2px rgba(74, 139, 252, 0.2);
        background-color: white;
    }
    
    .input-group:focus-within label {
        color: #d63384 !important;
    }
    
    .form-control:hover {
        border-color: #adb5bd;
    }
    
    @media (max-width: 768px) {
        form {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem !important;
        }
        
        .input-group {
            width: 100% !important;
        }
        
        .d-flex.align-items-center.gap-2 {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
</div>

        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-pink shadow-pink border-radius-lg pt-4 pb-3" style="background: linear-gradient(195deg, #ec407a, #d81b60);">
    <h6 class="text-white text-capitalize ps-3">Table Repense</h6>
</div>
            </div>
            <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
    <thead>
      <tr>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Réponse</th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID Réclamation</th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contenu</th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($listReponses as $rep): ?>
        <tr>
          <td><p class="text-sm mb-0">RP-<?= htmlspecialchars($rep['id_reponse']) ?></p></td>
          <td><p class="text-sm mb-0">RC-<?= htmlspecialchars($rep['id_reclamation']) ?></p></td>
          <td><p class="text-sm mb-0"><?= nl2br(htmlspecialchars($rep['contenu'])) ?></p></td>
          <td><p class="text-sm mb-0"><?= htmlspecialchars($rep['date_reponse']) ?></p></td>
          <td class="text-center">
            <a href="modreponse.php?id=<?= $rep['id_reponse'] ?>" class="btn btn-primary">Modifier</a>
            <a href="supprimerReponse.php?id=<?= $rep['id_reponse'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette réponse ?');">Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

            </div>
                          <?php
              $totalPagesReponses = ceil($totalReponses / $limit);
              $currentPageReponse = isset($_GET['pageReponse']) ? (int)$_GET['pageReponse'] : 1;

              echo '<div class="pagination">';
              for ($i = 1; $i <= $totalPagesReponses; $i++) {
                  $activeClass = ($i == $currentPageReponse) ? 'active' : '';
                  echo "<a class='$activeClass' href='?pageReponse=$i&searchReponse=" . urlencode($searchReponse) . "&sortReponse=" . urlencode($sortReponse) . "'>$i</a> ";
              }
              echo '</div>';
              ?>
          </div>
        </div>
      </div>
      
        <?php
$s = $reclamationC->getStatistiquesReclamations();
?>

<div class="card my-2">
  <div class="card-header p-2 bg-gradient-pink text-white">
    <h6 class="m-0">Stats Réclamations</h6>
  </div>
  <div class="card-body p-2">
    <div class="row g-1 text-center">
      <div class="col-4">
        <div class="p-1 border rounded">
          <div class="text-success fw-bold"><?= $s['total_repondu'] ?></div>
          <small>Répondues</small>
        </div>
      </div>
      <div class="col-4">
        <div class="p-1 border rounded">
          <div class="text-danger fw-bold"><?= $s['total_non_repondu'] ?></div>
          <small>Non répondues</small>
        </div>
      </div>
      <div class="col-4">
        <div class="p-1 border rounded">
          <div class="fw-bold"><?= $s['total_repondu'] + $s['total_non_repondu'] ?></div>
          <small>Total</small>
        </div>
      </div>
    </div>
    
    <canvas id="rcChart" height="300px" width="300px" class="mt-2" style="max-width: 300px; margin: auto;"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      new Chart(document.getElementById('rcChart'), {
        type: 'doughnut',
        data: {
          labels: ['Répondues', 'En attente'],
          datasets: [{
            data: [<?= $s['total_repondu'] ?>, <?= $s['total_non_repondu'] ?>],
            backgroundColor: ['#DA1884', '#FF91A4']
          }]
        },
        options: {
          cutout: '65%',
          plugins: {
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                boxWidth: 12,
                font: {
                  size: 10
                }
              }
            }
          }
        }
      });
    </script>
  </div>
</div>
<footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        


        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">


        <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>