<?php
  require_once '../config.php';
  require_once '../Controller/eventController.php';

  $db=config::getConnexion();
  $controller = new EventController($db);
  $events = $controller->showDashboard();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" width="200px" type="image/png" href="../assets/logo-removebg-preview.png">
  <title>
    Dashboard 
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
        <img src="../assets/logo-removebg-preview.png" class="navbar-brand-img" width="95px" alt="main_logo">
        
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/events_by_season.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Stat</span>
          </a>
        </li>
        <li class="nav-item">
  <a class="nav-link active text-white" href="../pages/tables.php" style="background-color: #f06292;">
    <i class="material-symbols-rounded opacity-5">table_view</i>
    <span class="nav-link-text ms-1">Tab_event</span>
  </a>
</li>

        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/tab_reservation.php">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Reservation</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Reclamation</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">Sponsors</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Packs</span>
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
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="" class="nav-link text-body font-weight-bold px-0">
                <i class="material-symbols-rounded">account_circle</i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <div class="bg-custom-pink shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
  <h6 class="text-white text-capitalize m-0">Events table</h6>
  <form action="../view/add_event.php" method="GET" class="m-0">
    <input type="hidden" name="id" value="<?= htmlspecialchars($event['id_event']) ?>">
    <button type="submit" class="btn btn-light btn-sm">Add Event</button>
  </form>
</div>


                
              <table class="authors-table table table-bordered">
    <tr>
        <th>ID</th><th>Nom</th><th>Lieu</th><th>Date début</th><th>Date fin</th><th>Prix</th><th>nombre totale</th><th>État</th><th>Catégorie</th><th>Description</th><th>Image</th><th colspan="2">Action</th>
    </tr>
    <?php foreach ($events as $event): ?>
    <tr>
        <td><?= htmlspecialchars($event['id_event']) ?></td>
        <td><?= htmlspecialchars($event['nom_e']) ?></td>
        <td><?= htmlspecialchars($event['lieu_e']) ?></td>
        <td><?= htmlspecialchars($event['date_de_e']) ?></td>
        <td><?= htmlspecialchars($event['date_f_e']) ?></td>
        <td><?= htmlspecialchars($event['prix_e']) ?> TND</td>
        <td><?= htmlspecialchars($event['nbr_e']) ?> </td>
        <td><?= htmlspecialchars($event['etat_e']) ?></td>
        <td><?= htmlspecialchars($event['category_e']) ?></td>
        <td><?= htmlspecialchars($event['desc_e']) ?></td>
        <td>
            <?php if (!empty($event['image']) && file_exists('../uploads/' . $event['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" alt="Event Image" width="100" style="border-radius: 8px; object-fit: cover;">
            <?php else: ?>
                <span>No Image</span>
            <?php endif; ?>
        </td>
        <td>
            <form action="../view/editEvent.php" method="GET">
                <input type="hidden" name="id" value="<?= htmlspecialchars($event['id_event']) ?>">
                <button type="submit">Edit</button>
            </form>
        </td>

        

        <td>
        <button class="delete-btn" data-id="<?php echo $event['id_event']; ?>">Delete</button>
        </td>
    </tr>
<?php endforeach; ?>


</table>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Select all delete buttons
      const deleteButtons = document.querySelectorAll('.delete-btn');

      // Add click event listeners to each delete button
      deleteButtons.forEach(button => {
          button.addEventListener('click', function(e) {
              const eventId = this.getAttribute('data-id');

              // Confirm deletion
              if (confirm("Are you sure you want to delete this event?")) {
                  // Send AJAX request to delete the event
                  const xhr = new XMLHttpRequest();
                  xhr.open('POST', '../view/deleteEvent.php', true);
                  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                  xhr.onreadystatechange = function() {
                      if (xhr.readyState === 4 && xhr.status === 200) {
                          const response = xhr.responseText;
                          if (response === 'success') {
                              alert('Event deleted successfully!');
                              // Optionally, remove the event row from the table
                              document.querySelector(`button[data-id="${eventId}"]`).closest('tr').remove();
                          } else {
                              alert('Event deleted successfully!');
                          }
                      }
                  };
                  xhr.send('id_event=' + eventId);
              }
          });
      });
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
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Mayma</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Mayma</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
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
  <style>
  .head_table {
    background: linear-gradient(60deg, #ffc0cb);
    border-radius: 12px;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .authors-table {
    width: 100%;
    background-color: #fff0f5;
    border: 1px solid #f8bbd0;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 20px;
  }

  .authors-table th, .authors-table td {
    padding: 6px;
    font-size: 13px;
    vertical-align: middle;
    white-space: nowrap; /* Empêche le retour à la ligne */
    text-align:center;
  }

  .authors-table img {
    max-width: 60px;
    height: 50px;
    border-radius: 5px;
    object-fit: cover;
  }
  .authors-table th {
    background-color: #f06292;
    color:white;
    text-align:center;
  }

  .authors-table tr:nth-child(even) td {
    background-color: #ffe6f0;
  }
  .bg-custom-pink {
  background-color: #f06292;
}



  .btn-light.btn-sm {
    background-color: white;
            color: #f06292;
            border: 1px solid #f06292;
  }

  .btn-light.btn-sm:hover {
    background-color: white;
            color: #f06292;
            border: 1px solid #f06292;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            background-color: #f06292;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
  }

  button {
    background-color: #ec407a;
    color: white;
    border: none;
    padding: 5px 10px;
    margin: 2px 0;
    border-radius: 6px;
    cursor: pointer;
  }

  button:hover {
    background-color: #d81b60;
  }
  .bg-gradient-pink {
  background: linear-gradient(60deg, #ec407a, #f48fb1);
}

</style>

</body>

</html>