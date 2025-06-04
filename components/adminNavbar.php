 <?php

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../admin/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Admin-Navbar</title>
 <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" href="manage-cars.php">Manage Cars</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-rentals.php">Manage Rentals</a>
      </li>
    </ul>
    <form method="post" class="d-flex">
      <button type="submit" name="logout" class="btn btn-outline-light">Logout</button>
    </form>
  </div>
</nav>

    
    <script src="../assests/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>