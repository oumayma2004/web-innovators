<?php
// Inclusion des fichiers nécessaires
require_once '../../../../../Controller/sponsorsC.php';
require_once '../../../../../Controller/ContratC.php';
require_once '../../../../../config.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Twilio\Rest\Client;

// Instanciation des classes
$sponsorC = new SponsorC();
$contratC = new ContratC();

// Paramètres Sponsors
$searchSponsor = $_GET['searchSponsor'] ?? '';
$statutFilter = $_GET['statut'] ?? '';
$sortSponsor = $_GET['sortSponsor'] ?? 'ASC';
$pageSponsor = (int) ($_GET['pageSponsor'] ?? 1);
$limit = 3;
$offsetSponsor = ($pageSponsor - 1) * $limit;

// Paramètres Contrats
$searchContrat = $_GET['searchContrat'] ?? '';
$typeContrat = $_GET['type_contrat'] ?? '';
$sortContrat = $_GET['sortContrat'] ?? 'ASC';
$pageContrat = (int) ($_GET['pageContrat'] ?? 1);
$offsetContrat = ($pageContrat - 1) * $limit;

// Récupération des données
$totalSponsors = $sponsorC->countSponsorsWithSearch($searchSponsor);
$totalPagesSponsors = ceil($totalSponsors / $limit);
$listSponsors = $sponsorC->fetchFilteredSortedSponsors($searchSponsor, $sortSponsor, $limit, $offsetSponsor, $statutFilter);

$totalContrats = $contratC->countContratsWithSearch($searchContrat, $typeContrat);
$totalPagesContrats = ceil($totalContrats / $limit);
$listContrats = $contratC->fetchFilteredSortedContrats($searchContrat, $sortContrat, $limit, $offsetContrat, $typeContrat);

// --- Twilio credentials ---
define('TWILIO_ACCOUNT_SID', 'ACf5fc8a36db6d9a5bbfa595e21ab34876');
define('TWILIO_AUTH_TOKEN', '7c9a01cf920fede48dc9eed8f657513b');
define('TWILIO_PHONE_NUMBER', '+18104280546');

// Fonction pour envoyer un SMS
function sendExpirationSMS($phoneNumber, $sponsorName, $contractId, $expirationDate) {
    try {
        $client = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);

        $formattedNumber = formatPhoneNumber($phoneNumber);
        if (!$formattedNumber) {
            throw new Exception("Numéro de téléphone invalide");
        }

        $message = $client->messages->create(
            $formattedNumber,
            [
                'from' => TWILIO_PHONE_NUMBER,
                'body' => "Bonjour $sponsorName, votre contrat (ID: $contractId) expire aujourd'hui ($expirationDate). Merci de nous contacter pour renouveler."
            ]
        );

        return $message->sid;
    } catch (Exception $e) {
        error_log("Erreur Twilio: " . $e->getMessage());
        return false;
    }
}

// Fonction de formatage du numéro
function formatPhoneNumber($phoneNumber) {
    $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Format : 0XXXXXXXX
    if (strlen($cleaned) === 8) {
        return '+216' . $cleaned;
    }

    // Déjà en format international
    if (substr($cleaned, 0, 3) === '216' && strlen($cleaned) === 11) {
        return '+' . $cleaned;
    }

    return false;
}

// Vérification automatique de la date de fin de contrat
foreach ($listContrats as $contrat): 
    $sponsor = $sponsorC->recupererSponsor($contrat['id_sponsor']);
    
    if (!$sponsor || empty($sponsor['telephone'])) continue;

    $dateFin = (new DateTime($contrat['date_fin']))->format('Y-m-d');
    $today = (new DateTime())->format('Y-m-d');

    if ($dateFin === $today) {
        $smsResult = sendExpirationSMS(
            $sponsor['telephone'],
            $sponsor['nom_complet'],
            $contrat['id_contrat'],
            $dateFin
        );

        if ($smsResult) {
            echo "<script>console.log('✅ SMS envoyé à {$sponsor['telephone']}');</script>";
        } else {
            echo "<script>console.error('❌ Échec SMS à {$sponsor['telephone']}');</script>";
        }
    }
endforeach;


$typeStats = $contratC->countContratsByType();
$labels = [];
$counts = [];

foreach ($typeStats as $stat) {
    $labels[] = $stat['type_contrat'];
    $counts[] = $stat['count'];
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logosite.png">
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
        <img src="../assets/img/logosite.png" class="navbar-brand-img" width="150" height="150" >
        <span class="ms-1 text-sm text-dark"></span>
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
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <form method="GET" class="sponsor-filter-form">
  <div class="filter-container">
    <!-- Champ de recherche -->
    <div class="search-group">
      <div class="input-wrapper">
        <input type="text" class="search-input" name="searchSponsor" 
               placeholder=" " 
               value="<?php echo isset($_GET['searchSponsor']) ? htmlspecialchars($_GET['searchSponsor']) : ''; ?>">
        <label>Rechercher un sponsor</label>
        <i class="fas fa-search icon"></i>
      </div>
    </div>

    <!-- Filtrage par statut -->
    <div class="filter-group">
      <div class="select-wrapper">
        <select name="statut" class="form-select">
          <option value="">Tous les statuts</option>
          <option value="En attente" <?php if (isset($_GET['statut']) && $_GET['statut'] == 'En attente') echo 'selected'; ?>>En attente</option>
          <option value="oui" <?php if (isset($_GET['statut']) && $_GET['statut'] == 'oui') echo 'selected'; ?>>Accepté</option>
          <option value="non" <?php if (isset($_GET['statut']) && $_GET['statut'] == 'non') echo 'selected'; ?>>Refusé</option>
        </select>
        <i class="fas fa-chevron-down icon"></i>
      </div>
    </div>

    <!-- Boutons -->
    <div class="button-group">
      <button type="submit" class="btn-filter">
        <i class="fas fa-filter"></i> Appliquer
      </button>
      <a href="?page=1" class="btn-reset">
        <i class="fas fa-times"></i> reinitialiser
      </a>
    </div>
  </div>
</form>

<style>
.sponsor-filter-form {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  margin-bottom: 2rem;
}

.filter-container {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  align-items: center;
}

.search-group, .filter-group {
  flex: 1;
  min-width: 200px;
}

.input-wrapper {
  position: relative;
}

.search-input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.5rem;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  background-color: white;
  color: #495057;
  font-size: 0.9rem;
  transition: all 0.3s;
}

.search-input:focus {
  border-color: #d63384;
  box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.2);
  outline: none;
}

.search-input:focus + label,
.search-input:not(:placeholder-shown) + label {
  transform: translateY(-130%) scale(0.85);
  background: white;
  padding: 0 0.3rem;
  color: #d63384;
}

.search-input + label {
  position: absolute;
  left: 2.5rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6c757d;
  pointer-events: none;
  transition: all 0.2s;
}

.select-wrapper {
  position: relative;
}

.form-select {
  width: 100%;
  padding: 0.75rem 2.5rem 0.75rem 1rem;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  background-color: white;
  color: #495057;
  font-size: 0.9rem;
  appearance: none;
  transition: all 0.3s;
}

.form-select:focus {
  border-color: #d63384;
  box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.2);
  outline: none;
}

.icon {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  color: #6c757d;
}

.input-wrapper .icon {
  left: 1rem;
}

.select-wrapper .icon {
  right: 1rem;
  pointer-events: none;
}

.button-group {
  display: flex;
  gap: 0.75rem;
}

.btn-filter {
  background-color: #d63384;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-filter:hover {
  background-color: #339af0;
  transform: translateY(-1px);
}

.btn-reset {
  background-color: #f1f3f5;
  color: #495057;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-reset:hover {
  background-color: #e9ecef;
  transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
  .filter-container {
    flex-direction: column;
  }
  
  .search-group, .filter-group, .button-group {
    width: 100%;
  }
  
  .button-group {
    justify-content: flex-end;
  }
}
</style>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">sponsors table</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom complet</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Entreprise</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Budget</th>

                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date envoi</th>
                      <th class="text-secondary opacity-7">Actions</th>
                      <th class="text-secondary opacity-7">Actions</th> 

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($listSponsors as $sponsor): ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img src="data:image/jpeg;base64,<?= base64_encode($sponsor['image']) ?>" class="avatar avatar-sm me-3" alt="sponsor image">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"><?= htmlspecialchars($sponsor['nom_complet']) ?></h6>
                              <p class="text-xs text-secondary mb-0"><?= htmlspecialchars($sponsor['contact_email']) ?></p>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($sponsor['entreprise']) ?></p>
                          <p class="text-xs text-secondary mb-0"><?= htmlspecialchars($sponsor['secteur']) ?></p>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <?php
                            $statut = $sponsor['statut'];
                            $class = ($statut == 'Validé') ? 'bg-success' : (($statut == 'Rejeté') ? 'bg-danger' : 'bg-secondary');
                          ?>
                          <span class="badge badge-sm <?= $class ?>"><?= $statut ?></span>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold"><?= $sponsor['budget'] ?></span>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold"><?= $sponsor['date_envoi'] ?></span>
                        </td>
                        <td class="align-middle">
                          <?php if ($sponsor['statut'] === 'En attente'): ?>
                            <form method="POST" action="traitement_sponsor.php" style="display:inline;">
                              <input type="hidden" name="id_sponsor" value="<?= $sponsor['id_sponsor'] ?>">
                              <input type="hidden" name="action" value="accepter">
                              <button type="submit" class="btn btn-sm btn-outline-success">✅ Accepter</button>
                            </form>
                            <form method="POST" action="traitement_sponsor.php" style="display:inline;">
                              <input type="hidden" name="id_sponsor" value="<?= $sponsor['id_sponsor'] ?>">
                              <input type="hidden" name="action" value="rejeter">
                              <button type="submit" class="btn btn-sm btn-outline-danger">❌ Refuser</button>
                            </form>
                          <?php else: ?>
                            <span class="text-muted text-xs">Aucune action</span>
                          <?php endif; ?>
                          <a href="updatesposors.php?id=<?= $sponsor['id_sponsor'] ?>" class="btn btn-sm btn-primary">✏️ Modifier</a>
                          <a href="deletesp.php?id=<?= $sponsor['id_sponsor'] ?>" class="btn btn-sm btn-danger">🗑 Supprimer</a>
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
$totalPagesSponsors = ceil($totalSponsors / $limit);
$currentPageSponsor = isset($_GET['pageSponsor']) ? (int)$_GET['pageSponsor'] : 1;

echo '<div class="pagination">';
for ($i = 1; $i <= $totalPagesSponsors; $i++) {
    $activeClass = ($i == $currentPageSponsor) ? 'active' : '';
    echo "<a class='$activeClass' href='?pageSponsor=$i&searchSponsor=" . urlencode($searchSponsor) . "&statut=" . urlencode($statutFilter) . "&sortSponsor=" . urlencode($sortSponsor) . "'>$i</a> ";
}
echo '</div>';
?>

          </div>
        </div>
      </div>
      <div class="row">
        
      <form method="GET" class="filter-form">
  <div class="filter-container">
    <!-- Filtrage par type de contrat -->
    <div class="filter-group">
      <select name="type_contrat" class="form-select">
        <option value="">Tous les types</option>
        <option value="Exclusif" <?php if (isset($_GET['type_contrat']) && $_GET['type_contrat'] == 'Exclusif') echo 'selected'; ?>>Exclusif</option>
        <option value="Non-exclusif" <?php if (isset($_GET['type_contrat']) && $_GET['type_contrat'] == 'Non-exclusif') echo 'selected'; ?>>Non-exclusif</option>
        <option value="Saison" <?php if (isset($_GET['type_contrat']) && $_GET['type_contrat'] == 'Saison') echo 'selected'; ?>>Saison</option>
        <option value="Événementiel" <?php if (isset($_GET['type_contrat']) && $_GET['type_contrat'] == 'Événementiel') echo 'selected'; ?>>Événementiel</option>
      </select>
    </div>

    <!-- Tri par date -->
    <div class="filter-group">
      <select name="sortContrat" class="form-select">
        <option value="ASC" <?php if (isset($_GET['sortContrat']) && $_GET['sortContrat'] == 'ASC') echo 'selected'; ?>>Plus ancien</option>
        <option value="DESC" <?php if (isset($_GET['sortContrat']) && $_GET['sortContrat'] == 'DESC') echo 'selected'; ?>>Plus récent</option>
      </select>
    </div>

    <!-- Boutons de soumission -->
    <div class="button-group">
      <button type="submit" class="btn-filter">
        <i class="fas fa-search"></i> Filtrer
      </button>
      <a href="?pageContrat=1" class="btn-reset">
        <i class="fas fa-undo"></i> Réinitialiser
      </a>
    </div>
  </div>
</form>

<style>
.filter-form {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  margin-bottom: 2rem;
}

.filter-container {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  align-items: center;
}

.filter-group {
  flex: 1;
  min-width: 200px;
}

.form-select {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  background-color: white;
  color: #495057;
  font-size: 0.9rem;
  transition: all 0.3s;
}

.form-select:focus {
  border-color: #d63384;
  box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.2);
  outline: none;
}

.button-group {
  display: flex;
  gap: 0.75rem;
}

.btn-filter {
  background-color: #d63384;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-filter:hover {
  background-color: #339af0;
  transform: translateY(-1px);
}

.btn-reset {
  background-color: #f1f3f5;
  color: #495057;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-reset:hover {
  background-color: #e9ecef;
  transform: translateY(-1px);
}

/* Icônes Font Awesome */
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css");

/* Responsive */
@media (max-width: 768px) {
  .filter-container {
    flex-direction: column;
  }
  
  .filter-group, .button-group {
    width: 100%;
  }
  
  .button-group {
    justify-content: flex-end;
  }
}
</style>
        <div class="col-12">
        

          <div class="card my-4">



            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">contrat contrat</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
<table class="table align-items-center justify-content-center mb-0">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Contrat</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sponsor</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Montant</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Signature</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Fin</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type Contrat</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
        </tr>
    </thead>
    <tbody>
    
<?php foreach ($listContrats as $contrat): 
    // Récupérer les informations du sponsor
    $sponsor = $sponsorC->recupererSponsor($contrat['id_sponsor']); 

    // Vérifier si le contrat est expiré
    $dateFin = new DateTime($contrat['date_fin']);
    $dateFin->setTime(0, 0, 0);
    $today = new DateTime();
    $today->setTime(0, 0, 0);
    
    // Définir $isExpiredOrToday avant de l'utiliser
    $isExpiredOrToday = ($dateFin <= $today);
    
    // Vérifier si le contrat est expiré ET que le numéro de téléphone existe
    if ($isExpiredOrToday && !empty($sponsor['tel'])) {
        // ... votre code d'envoi de SMS ...
    }
?>
    <tr <?= $isExpiredOrToday ? 'class="bg-warning bg-opacity-10"' : '' ?>>
    <td>
                <p class="text-sm font-weight-bold mb-0"><?= htmlspecialchars($contrat['id_contrat']) ?></p>
            </td>
            <td>
                <p class="text-sm font-weight-bold mb-0"><?= htmlspecialchars($sponsor['nom_complet']) ?></p>
            </td>
            <td>
                <p class="text-sm font-weight-bold mb-0"><?= htmlspecialchars($contrat['montant']) ?> TND</p>
            </td>
            <td>
                <span class="text-xs font-weight-bold"><?= htmlspecialchars($contrat['date_signature']) ?></span>
            </td>
            <td>
        <p class="text-sm mb-0">
            <?= htmlspecialchars($contrat['date_fin']) ?>
            <?php if ($isExpiredOrToday): ?>
                <span class="badge bg-gradient-warning ms-2">
                    <?= ($dateFin->format('Y-m-d') === $today->format('Y-m-d')) ? "Expire aujourd'hui!" : "Déjà expiré!" ?>
                </span>
            <?php endif; ?>
        </p>
    </td>
            <td>
                <p class="text-sm mb-0"><?= htmlspecialchars($contrat['type_contrat']) ?></p>
            </td>
            <td class="align-middle">
                <a href="modifierContrat.php?id=<?= $contrat['id_contrat'] ?>" class="btn btn-sm btn-primary m-1">Modifier</a>
                <a href="supprimerContrat.php?id=<?= $contrat['id_contrat'] ?>" class="btn btn-sm btn-danger m-1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')">Supprimer</a>
            </td>
        </tr>
    </tbody>
    <?php endforeach; ?>
</table>
<div class="d-flex justify-content-end mt-3" style="width: 100%;">
    <a href="ajouterContrat.php" class="btn btn-success w-100" style="height: 100%;">
        <i class="fas fa-plus me-1"></i> Ajouter Contrat
    </a>
</div>

<script>
// Afficher une alerte si un contrat expire aujourd'hui
window.onload = function() {
    const expiringContracts = document.querySelectorAll('tr.bg-warning');
    if (expiringContracts.length > 0) {
        setTimeout(() => {
            alert('Attention: ' + expiringContracts.length + ' contrat(s) expire(nt) aujourd\'hui!');
        }, 500);
    }
};
</script>
              </div>
              <?php
$totalPagesContrats = ceil($totalContrats / $limit);
$currentPageContrat = isset($_GET['pageContrat']) ? (int)$_GET['pageContrat'] : 1;

echo '<div class="pagination">';
for ($i = 1; $i <= $totalPagesContrats; $i++) {
    $activeClass = ($i == $currentPageContrat) ? 'active' : '';
    echo "<a class='$activeClass' href='?pageContrat=$i&searchContrat=" . urlencode($searchContrat) . "&sortContrat=" . urlencode($sortContrat) . "'>$i</a> ";
}
echo '</div>';
?>

            </div>
          </div>
        </div>

        <div class="container-fluid py-2">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Statistique des types de contrat</h6>
          </div>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
          <div style="width: 300px; height: 300px;">
            <canvas id="typeContratChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('typeContratChart').getContext('2d');
  const typeContratChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: <?= json_encode($labels); ?>,
      datasets: [{
        label: 'Nombre de contrats',
        data: <?= json_encode($counts); ?>,
        backgroundColor: [
          '#4e73df',
          '#1cc88a',
          '#36b9cc',
          '#f6c23e',
          '#e74a3b',
          '#858796'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Répartition des types de contrat'
        }
      }
    }
  });
</script>

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