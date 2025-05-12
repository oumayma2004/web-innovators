<?php
include '../../controller/packc.php'; 
$packc = new packc(); 
$list = $packc->getAllPacks(); 
// Obtenir les statistiques du pack
// Récupérer les packs avec des intervalles de places spécifiques
$packsBetween5And10 = $packc->getPacksByPlaceRange(5, 10);
$packsBetween20And30 = $packc->getPacksByPlaceRange(20, 30);
$packsMoreThan30 = $packc->getPacksByPlaceRange(30, 1000); // Choisi une valeur maximale large, ici 1000

// Obtenir le nombre de packs dans chaque catégorie
$packs5To10Count = count($packsBetween5And10);
$packs20To30Count = count($packsBetween20And30);
$packsMoreThan30Count = count($packsMoreThan30);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/logosite1.png">
  <title>
    Tfarhida
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
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                { pageLanguage: 'en' },
                'google_translate_element'
            );
        }
    </script>
  
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
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" style="background-image: url('img/back.jpeg'); background-size: cover; background-position: center;">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
            
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
            <li class="nav-item dropdown pe-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-symbols-rounded">notifications</i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
                <i class="material-symbols-rounded">account_circle</i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Dashboard Pack</h3>
        </div>
      </div>
    </div>
    <div style="margin: 20px 0;">
    <div style="display: flex; max-width: 400px; position: relative; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 50px; overflow: hidden; transition: all 0.3s ease;">
        <input type="text" id="live_search12" placeholder="Search here..." 
               style="flex: 1; border: none; background-color: #f8f9fa; padding: 14px 20px; font-size: 16px; border-radius: 50px 0 0 50px; outline: none; transition: all 0.3s ease;">
        <button type="button" 
                style="background-color: pink; border: none; color: white; padding: 0 20px; cursor: pointer; border-radius: 0 50px 50px 0; transition: background-color 0.3s ease;">
            <i class="fas fa-search" style="font-size: 18px;"></i>
        </button>
    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#live_search12").on('keyup change', function(){
          $('#recentOrders').html(''); 
          var input =$(this).val();
          console.log(input);
          $.ajax({
            type: 'GET',
            url:"recherchePack.php",
            data: 'input=' + encodeURIComponent(input),
            success: function(data){
              if(data!=""){
                $('#recentOrders').append(data); 
              }else{
                document.getElementById('recentOrders').innerHTML = "<div style='font-size:20px'>aucun offre</div>"
              }
            }
          });
        });
      });
    </script>
    <div class="row mb-4">
      <div class="col-lg-8 col-md-6 mb-md-0 mb-4 w-100">
        <div class="card">
          <div class="card-header pb-0">
            <button class="btn btn-outline-dark mt-3 w-10" data-bs-toggle="modal" data-bs-target="#addPackModal" type="button">
              <i class="fas fa-plus me-1"></i> Add Pack
            </button>  
            <div class="row">
              <div class="col-lg-6 col-7">
                <h6>Table Pack</h6>
              </div>
              <div class="col-lg-6 col-5 my-auto text-end">
                <div class="dropdown float-lg-end pe-4">
                  <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v text-secondary"></i>
                  </a>
                  <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <form method="POST" action="export_packs_pdf.php">
                  <button type="submit" name="export_packs_pdf" class="btn btn-success">
                    <i class="fas fa-file-pdf me-1"></i> Export Packs as PDF
                  </button>
                </form>

                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Places</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                  </tr>
                </thead>
                <tbody id="recentOrders">
                  <?php foreach ($list as $pack): ?>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div><?= $pack['id']; ?></div>
                      </div>
                    </td>
                    <td>
                      <div class="avatar-group mt-2">
                        <?= htmlspecialchars($pack['titre']); ?>
                      </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"><?= htmlspecialchars($pack['description']); ?></span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"><?= htmlspecialchars($pack['prix']); ?></span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"><?= htmlspecialchars($pack['nombre_places']); ?></span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"><?= htmlspecialchars($pack['date_d']); ?></span>
                    </td>
                    <td class="align-middle text-center">
                      <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editPackModal" 
                        onclick="setEditFormValues(
                          '<?= $pack['id'] ?>',
                          '<?= htmlspecialchars($pack['titre'], ENT_QUOTES) ?>',
                          '<?= htmlspecialchars($pack['description'], ENT_QUOTES) ?>',
                          '<?= htmlspecialchars($pack['prix']) ?>',
                          '<?= htmlspecialchars($pack['nombre_places']) ?>',
                          '<?= htmlspecialchars($pack['date_d']) ?>'
                        )">
                        <i class="fas fa-edit"></i> Edit
                      </button>
                      <a href="deletepack.php?id=<?= $pack['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this pack?');">
                        <i class="fas fa-trash"></i> Delete
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Pack Modal -->
    <div class="modal fade" id="addPackModal" tabindex="-1" aria-labelledby="addPackModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-gradient-dark">
            <h5 class="modal-title text-white" id="addPackModalLabel">Add New Pack</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addPackForm" action="addpack.php" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="titre" class="form-label">Title</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="prix" class="form-label">Price</label>
                    <input type="number" class="form-control" id="prix" name="prix" step="0.01" required>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_places" class="form-label">Number of Places</label>
                    <input type="number" class="form-control" id="nombre_places" name="nombre_places" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date_d" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date_d" name="date_d" required>
                  </div>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Pack</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Pack Modal -->
    <div class="modal fade" id="editPackModal" tabindex="-1" aria-labelledby="editPackModalLabel" aria-hidden="true" >
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-image: url('img/back.jpeg'); background-size: cover; background-position: center;">
          <div class="modal-header bg-gradient-dark">
            <h5 class="modal-title text-white" id="editPackModalLabel">Edit Pack</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editPackForm" action="updatepack.php" method="POST">
              <input type="hidden" id="edit_id" name="id">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_titre" class="form-label">Title</label>
                    <input type="text" class="form-control" id="edit_titre" name="titre" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_prix" class="form-label">Price</label>
                    <input type="number" class="form-control" id="edit_prix" name="prix" step="0.01" required>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_nombre_places" class="form-label">Number of Places</label>
                    <input type="number" class="form-control" id="edit_nombre_places" name="nombre_places" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edit_date_d" class="form-label">Date</label>
                    <input type="date" class="form-control" id="edit_date_d" name="date_d" required>
                  </div>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="edit_description" class="form-label">Description</label>
                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Pack</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <h1>Statistiques des Packs par Nombre de Places</h1>
      <div class="row">
        <!-- Graphique Packs entre 5 et 10 places -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Packs entre 5 et 10 places</h5>
              <canvas id="packs5to10Chart"></canvas>
            </div>
          </div>
        </div>

        <!-- Graphique Packs entre 20 et 30 places -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Packs entre 20 et 30 places</h5>
              <canvas id="packs20to30Chart"></canvas>
            </div>
          </div>
        </div>

        <!-- Graphique Packs plus de 30 places -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Packs plus de 30 places</h5>
              <canvas id="packsMoreThan30Chart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Function to set values in edit form
      function setEditFormValues(id, titre, description, prix, nombre_places, date_d) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_titre').value = titre;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_prix').value = prix;
        document.getElementById('edit_nombre_places').value = nombre_places;
        document.getElementById('edit_date_d').value = date_d;
      }

      // Initialize charts
      document.addEventListener('DOMContentLoaded', function () {
        // Graphique Packs entre 5 et 10 places
        var ctx5to10 = document.getElementById('packs5to10Chart').getContext('2d');
        new Chart(ctx5to10, {
          type: 'bar',
          data: {
            labels: ['Packs entre 5 et 10 places'],
            datasets: [{
              label: 'Nombre de Packs',
              data: [<?= $packs5To10Count ?>],
              backgroundColor: '#36a2eb',
              borderColor: '#36a2eb',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        // Graphique Packs entre 20 et 30 places
        var ctx20to30 = document.getElementById('packs20to30Chart').getContext('2d');
        new Chart(ctx20to30, {
          type: 'bar',
          data: {
            labels: ['Packs entre 20 et 30 places'],
            datasets: [{
              label: 'Nombre de Packs',
              data: [<?= $packs20To30Count ?>],
              backgroundColor: '#ff6384',
              borderColor: '#ff6384',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        // Graphique Packs plus de 30 places
        var ctxMoreThan30 = document.getElementById('packsMoreThan30Chart').getContext('2d');
        new Chart(ctxMoreThan30, {
          type: 'bar',
          data: {
            labels: ['Packs plus de 30 places'],
            datasets: [{
              label: 'Nombre de Packs',
              data: [<?= $packsMoreThan30Count ?>],
              backgroundColor: '#ff9f40',
              borderColor: '#ff9f40',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      });
    </script>

    <footer class="footer py-4">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Tfarhida</a>
              for a better web.
            </div>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Views",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: [50, 45, 22, 28, 50, 60, 76],
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
          label: "Sales",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
          maxBarThickness: 6
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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