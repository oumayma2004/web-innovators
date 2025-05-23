<?php
require_once '../../../Controller/sponsorsC.php';
require_once '../../../Controller/ContratC.php';
require_once '../../../Model/Contrat.php';
require_once __DIR__ . '../../../../vendor/autoload.php';
use Twilio\Rest\Client;

$contratC = new ContratC();
$sponsorC = new SponsorC();

$sponsors = $sponsorC->afficherSponsors();
$errors = [];
$success = false;

if (isset($_POST['submit'])) {
    if (empty($_POST['id_sponsor'])) {
        $errors['id_sponsor'] = "Le sponsor est requis.";
    }
    if (empty($_POST['montant']) || $_POST['montant'] < 100) {
        $errors['montant'] = "Montant invalide (min: 100 TND).";
    }
    if (empty($_POST['date_signature'])) {
        $errors['date_signature'] = "Date de signature requise.";
    }
    if (empty($_POST['date_fin'])) {
        $errors['date_fin'] = "Date de fin requise.";
    }
    if (empty($_POST['type_contrat'])) {
        $errors['type_contrat'] = "Type de contrat requis.";
    }

    if (empty($errors)) {
        $contrat = new Contrat(
            null,
            $_POST['id_sponsor'],
            $_POST['date_signature'],
            $_POST['date_fin'],
            $_POST['montant'],
            $_POST['type_contrat']
        );

        $success = $contratC->ajouterContrat($contrat);

        if ($success) {
            // Envoi SMS via Twilio
            $account_sid = 'ACf5fc8a36db6d9a5bbfa595e21ab34876';
            $auth_token = '7c9a01cf920fede48dc9eed8f657513b';
            $twilio_number = '+18104280546';
            $client = new Client($account_sid, $auth_token);

            $sponsor = $sponsorC->recupererSponsor($_POST['id_sponsor']);
            if ($sponsor && !empty($sponsor['telephone'])) {
                // Formater le numéro en +216XXXXXXXX
                $rawNumber = preg_replace('/\D/', '', $sponsor['telephone']);
                if (strlen($rawNumber) === 8) {
                    $formattedNumber = '+216' . $rawNumber;
                } elseif (strlen($rawNumber) === 9 && $rawNumber[0] === '0') {
                    $formattedNumber = '+216' . substr($rawNumber, 1);
                } elseif (strpos($rawNumber, '216') !== 0) {
                    $formattedNumber = '+216' . $rawNumber;
                } else {
                    $formattedNumber = '+' . $rawNumber;
                }

                try {
                    $client->messages->create(
                        $formattedNumber,
                        [
                            'from' => $twilio_number,
                            'body' => "Bonjour " . $sponsor['nom_complet'] . ", un nouveau contrat a été signé avec vous. Merci pour votre collaboration."
                        ]
                    );
                } catch (Exception $e) {
                    error_log("Erreur Twilio : " . $e->getMessage());
                }
            }

            header("Location: liste_sponsors.php?success=1");
            exit();
        } else {
            $errors['global'] = "Erreur lors de l’ajout du contrat.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Material Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Creative Tim</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="../pages/liste_sponsors.php">
            <i class="material-symbols-rounded opacity-5"> </i>
            <span class="nav-link-text ms-1">liste Sponsors</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">reclamation </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">evenenment</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">packs</span>
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
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="https://www.creative-tim.com/builder?ref=navbar-material-dashboard">Online Builder</a>
            </li>
            <li class="mt-1">
              <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
            </li>
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
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
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
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
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
        <div class="col-12">
          <div class="card my-4">

            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
              <div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>ajouter un contrat</h4>
    </div>
    <div class="card-body">
    <div class="container mt-5">
  <div class="card shadow-lg">

    <div class="card-body p-4">
      <form method="POST" id="contratForm" novalidate>
        
        <!-- Section Sponsor -->
        <div class="mb-4">
          <label for="id_sponsor" class="form-label fw-bold">Sponsor <span class="text-danger">*</span></label>
          <select class="form-select <?= isset($errors['id_sponsor']) ? 'is-invalid' : '' ?>" 
                  name="id_sponsor" required style="height: 45px;">
            <option value="">Sélectionner un sponsor</option>
            <?php foreach ($sponsors as $sponsor): ?>
              <option value="<?= $sponsor['id_sponsor'] ?>" 
                <?= isset($_POST['id_sponsor']) && $_POST['id_sponsor'] == $sponsor['id_sponsor'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($sponsor['nom_complet']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= $errors['id_sponsor'] ?? 'Veuillez sélectionner un sponsor' ?></div>
        </div>

        <!-- Section Montant -->
        <div class="mb-4">
          <label for="montant" class="form-label fw-bold">Montant (TND) <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="number" step="0.01" min="100" max="1000000" name="montant" 
                   class="form-control <?= isset($errors['montant']) ? 'is-invalid' : '' ?>" 
                   value="<?= isset($_POST['montant']) ? htmlspecialchars($_POST['montant']) : '' ?>" 
                   required style="height: 45px;">
            <span class="input-group-text bg-light">TND</span>
          </div>
          <div class="invalid-feedback">
            <?= $errors['montant'] ?? 'Le montant doit être entre 100 et 1 000 000 TND' ?>
          </div>
        </div>

        <!-- Section Dates -->
        <div class="row mb-4">
          <div class="col-md-6 mb-3 mb-md-0">
            <label for="date_signature" class="form-label fw-bold">Date de signature <span class="text-danger">*</span></label>
            <input type="date" name="date_signature" 
                   class="form-control <?= isset($errors['date_signature']) ? 'is-invalid' : '' ?>" 
                   value="<?= isset($_POST['date_signature']) ? htmlspecialchars($_POST['date_signature']) : '' ?>" 
                   required style="height: 45px;"
                   max="<?= date('Y-m-d') ?>">
            <div class="invalid-feedback">
              <?= $errors['date_signature'] ?? 'La date de signature ne peut pas être dans le futur' ?>
            </div>
          </div>

          <div class="col-md-6">
            <label for="date_fin" class="form-label fw-bold">Date de fin <span class="text-danger">*</span></label>
            <input type="date" name="date_fin" 
       class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>" 
       value="<?= isset($_POST['date_fin']) ? htmlspecialchars(substr($_POST['date_fin'], 0, 10)) : '' ?>" 
       required style="height: 45px;"
       min="<?= isset($_POST['date_signature']) ? htmlspecialchars(substr($_POST['date_signature'], 0, 10)) : '' ?>">

            <div class="invalid-feedback">
              <?= $errors['date_fin'] ?? 'La date de fin doit être après la date de signature' ?>
            </div>
          </div>
        </div>

        <!-- Section Type de contrat -->
        <div class="mb-4">
          <label for="type_contrat" class="form-label fw-bold">Type de contrat <span class="text-danger">*</span></label>
          <select name="type_contrat" class="form-select <?= isset($errors['type_contrat']) ? 'is-invalid' : '' ?>" 
                  required style="height: 45px;">
            <option value="">Sélectionner un type</option>
            <option value="Exclusif" <?= isset($_POST['type_contrat']) && $_POST['type_contrat'] === 'Exclusif' ? 'selected' : '' ?>>Exclusif</option>
            <option value="Non-exclusif" <?= isset($_POST['type_contrat']) && $_POST['type_contrat'] === 'Non-exclusif' ? 'selected' : '' ?>>Non-exclusif</option>
            <option value="Saison" <?= isset($_POST['type_contrat']) && $_POST['type_contrat'] === 'Saison' ? 'selected' : '' ?>>Saison</option>
            <option value="Événementiel" <?= isset($_POST['type_contrat']) && $_POST['type_contrat'] === 'Événementiel' ? 'selected' : '' ?>>Événementiel</option>
          </select>
          <div class="invalid-feedback">
            <?= $errors['type_contrat'] ?? 'Veuillez sélectionner un type de contrat' ?>
          </div>
        </div>

        <!-- Boutons -->
        <div class="d-flex justify-content-between mt-4">
          <button type="submit" name="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill me-2"></i>Ajouter le contrat
          </button>
          <a href="liste_sponsors.php" class="btn btn-outline-secondary px-4 py-2">
            <i class="bi bi-x-circle-fill me-2"></i>Annuler
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Fonction pour formater le montant
function formatMontant(input) {
    let value = input.value.replace(/[^0-9.]/g, '');
    if (value.split('.').length > 2) {
        value = value.substring(0, value.lastIndexOf('.'));
    }
    input.value = value;
}

// Synchronisation des dates
document.querySelector('input[name="date_signature"]').addEventListener('change', function() {
    const dateFin = document.querySelector('input[name="date_fin"]');
    dateFin.min = this.value;
    if (new Date(dateFin.value) < new Date(this.value)) {
        dateFin.value = this.value;
    }
});
</script>

<style>
  .card {
    border-radius: 12px;
    border: none;
    overflow: hidden;
  }
  .card-header {
    border-radius: 0 !important;
    padding: 1.2rem;
  }
  .form-control, .form-select {
    border-radius: 8px;
    padding: 0.6rem 1rem;
    border: 1px solid #ced4da;
    font-size: 0.95rem;
  }
  .form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
  }
  .btn {
    border-radius: 8px;
    padding: 0.6rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s;
  }
  .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
  }
  .btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
  }
  .invalid-feedback {
    font-size: 0.85rem;
    margin-top: 0.3rem;
  }
  .input-group-text {
    background-color: #f8f9fa;
    border-radius: 0 8px 8px 0 !important;
  }
</style>

              </div>
            </div>
          </div>
        </div>
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
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
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
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>