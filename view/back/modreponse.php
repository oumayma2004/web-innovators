<?php
// Include necessary files
include_once '../../controller/reponseC.php';
include_once '../../model/reponse.php';

// Create ReponseC controller instance
$reponseC = new ReponseC();

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    header("Location: listreclamation.php?error=ID de réponse manquant");
    exit();
}

$id_reponse = $_GET['id'];

// Fetch the existing response data
$reponseData = $reponseC->recupererReponse($id_reponse);

if (!$reponseData) {
    header("Location: listreclamation.php?error=Réponse non trouvée");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contenu'])) {
    try {
        // Get form data
        $contenu = $_POST['contenu'];
        
        // Create Reponse object with new content
        $reponse = new Reponse($id_reponse, $reponseData['id_reclamation'], $contenu, $reponseData['date_reponse']);
        
        // Update the response
        $reponseC->modifierReponse($reponse, $id_reponse);

        // Redirect with success message
        header("Location: listreclamation.php?message=Réponse modifiée avec succès");
        exit();
    } catch (Exception $e) {
        $error = "Erreur: " . $e->getMessage();
    }
}
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
  <script src="assets/js/validforme.js" ></script> <!-- Inclure le fichier JS ici -->
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
      <img src="assets/img/tfarhida.png" class="navbar-brand-img" width="150" height="150" alt="main_logo">
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
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">sponsor</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">evenement</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">user</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
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

<!-- settings eli zedethomm -->

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
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
           



          
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
            
<!-- icone homme-->
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
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <!-- Titre -->
     <div class="card shadow-lg border-0 overflow-hidden">
  <!-- En-tête avec animation fluide -->
  <div class="card-header text-center py-4 rounded-top position-relative" 
       style="background: linear-gradient(195deg, #FF009A, #D10068);
              background-size: 200% 200%;
              animation: gradientFlow 8s ease infinite;
              overflow: hidden;">
    
    <!-- Effet de vague lumineuse -->
    <div class="position-absolute w-200 h-100 bg-white/10 -bottom-20 -left-20 rotate-3" 
         style="animation: waveMove 7s linear infinite;"></div>
    
    <!-- Contenu (protégé par z-index) -->
    <div class="position-relative" style="z-index: 2;">
      <h4 class="mb-0 font-weight-bold text-white">
        <i class="fas fa-edit mr-2"></i>Modifier la Réponse
      </h4>
      <p class="mb-0 opacity-8">Mise à jour de la réponse à la réclamation</p>
    </div>
  </div>
  
  <!-- Corps de la carte -->
  <div class="card-body">
    <!-- Votre contenu ici -->
  </div>
</div>

<style>
  /* Animation du dégradé */
  @keyframes gradientFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  
  /* Animation de la vague */
  @keyframes waveMove {
    0% { transform: translateX(-100%) rotate(3deg); }
    100% { transform: translateX(100%) rotate(3deg); }
  }
  
  /* Effet de survol optionnel */
  .card-header:hover {
    box-shadow: inset 0 0 30px rgba(255,255,255,0.1);
  }
</style>


    <div class="card-body p-5 rounded-bottom" style="background-color: #f1f1f1;">
        <form action="modreponse.php?id=<?= htmlspecialchars($id_reponse) ?>" method="POST" onsubmit="return validateUpdateReponse();">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="id_reclamation" class="form-label text-dark font-weight-bold">Réclamation #</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-tag text-dark"></i></span>
                            <input type="text" class="form-control bg-white" value="RC-<?= htmlspecialchars($reponseData['id_reclamation']) ?>" disabled style="font-weight: 500;">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="date_reponse" class="form-label text-dark font-weight-bold">Date de réponse</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-dark"></i></span>
                            <input type="text" class="form-control bg-white" value="<?= htmlspecialchars(date('Y-m-d H:i', strtotime($reponseData['date_reponse']))) ?>" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="contenu" class="form-label text-dark font-weight-bold">Contenu de la réponse</label>
                <textarea name="contenu" id="contenu" rows="8" class="form-control border-2" 
                          style="border-color: #d1d1d1; border-radius: 8px; min-height: 150px;"
                          placeholder="Saisissez le contenu détaillé de votre réponse..."><?= htmlspecialchars($reponseData['contenu']) ?></textarea>
                <div class="invalid-feedback d-block animate-fade" id="updateContenuError">
                    <i class="fas fa-exclamation-circle mr-1"></i> Le contenu doit contenir au moins 5 caractères.
                </div>
            </div>

            <div class="form-group mt-5 pt-3 text-right">
                <a href="reclamations.php" class="btn btn-outline-dark btn-lg px-4 mr-2">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
                <button type="submit" class="btn btn-lg px-5 position-relative overflow-hidden" 
        style="
          background: linear-gradient(195deg, #ec407a, #d81b60);
          border: none;
          border-radius: 0.5rem;
          color: white;
          box-shadow: 0 4px 15px rgba(236, 64, 122, 0.4);
          transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
          z-index: 1;
        ">
  <i class="fas fa-save mr-2"></i> Enregistrer
  
  <!-- Effet de vague rose -->
  <span style="
    position: absolute;
    bottom: 0;
    left: 0;
    width: 200%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transform: rotate(-5deg);
    animation: waveMove 3s linear infinite;
    z-index: -1;
  "></span>
</button>

<style>
  @keyframes waveMove {
    0% { transform: translateX(-100%) rotate(-5deg); }
    100% { transform: translateX(100%) rotate(-5deg); }
  }
  
  button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(216, 27, 96, 0.6);
  }
  
  button:active {
    transform: translateY(1px);
  }
</style>

            </div>
        </form>
    </div>
</div>

<style>
.btn-rose-gradient {
  background: linear-gradient(45deg, #FF009A, #ff66c4);
  border: none;
  color: white;
}
.btn-rose-gradient:hover {
  opacity: 0.9;
}


    .bg-dark-gradient {
        background: linear-gradient(135deg, #2c3e50 0%, #1a1a1a 100%) !important;
    }
    
    .btn-dark-gradient {
        background: linear-gradient(to right, #434343, #000000);
        border: none;
        color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .btn-dark-gradient:hover {
        background: linear-gradient(to right, #383838, #000000);
        color: #f8f9fa;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }
    
    .animate-fade {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    textarea:focus {
        border-color: #555 !important;
        box-shadow: 0 0 0 0.2rem rgba(85, 85, 85, 0.25);
    }
    
    .card-header {
        border-bottom: none;
    }
    
    .input-group-text {
        border-right: none;
    }
    
    .form-control:disabled {
        background-color: #f8f9fa;
    }
</style>

<script>
    function validateUpdateReponse() {
        const contenu = document.getElementById('contenu').value.trim();
        const errorElement = document.getElementById('updateContenuError');
        
        // Reset state
        errorElement.style.display = 'none';
        document.getElementById('contenu').classList.remove('is-invalid');
        
        if (contenu.length < 5) {
            errorElement.style.display = 'block';
            document.getElementById('contenu').classList.add('is-invalid');
            return false;
        }
        
        return true;
    }
    
    // Dynamic character count
    document.getElementById('contenu').addEventListener('input', function() {
        const contenu = this.value.trim();
        if (contenu.length > 0 && contenu.length < 5) {
            document.getElementById('updateContenuError').style.display = 'block';
        } else {
            document.getElementById('updateContenuError').style.display = 'none';
        }
    });
</script>
    </div> <!-- fin col -->
  </div> <!-- fin row -->
</div> <!-- fin container -->

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
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
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