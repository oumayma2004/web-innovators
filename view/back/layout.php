<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/assets/css/material-dashboard.css">
  <link rel="stylesheet" href="/assets/css/nucleo-icons.css">
</head>
<body class="g-sidenav-show bg-gray-200">
  <!-- Sidebar -->
  <?php include 'partials/sidebar.php'; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <?php include 'partials/navbar.php'; ?>

    <!-- Page content -->
    <div class="container-fluid py-4">
      <?php if (isset($content)) include $content; ?>
    </div>

    <!-- Footer -->
    <?php include 'partials/footer.php'; ?>
  </main>

  <!-- Scripts -->
  <script src="/assets/js/core/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/material-dashboard.min.js"></script>
</body>
</html>
