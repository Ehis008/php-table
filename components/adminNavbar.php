 <?php

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../admins/login.php");
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

<style>
    .nav-link i, .btn i {
        margin-right: 0.5rem; /* Space between icon and text */
        font-size: 1.1rem; /* Slightly larger icons */
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="../index.php"><i class="bi bi-car-front"></i> DriveLite Rentals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="bi bi-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage-cars.php"><i class="bi bi-car-front"></i> Manage Cars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage-rentals.php"><i class="bi bi-calendar-check"></i> Manage Rentals</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['admin_id'])): ?>
                <span class="navbar-text me-3"><i class="bi bi-person"></i> Admin</span>
                <a href="../logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
            <?php else: ?>
                <a href="/admin/login.php" class="btn btn-primary"><i class="bi bi-person"></i> Admin Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

    
    <script src="../assests/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>