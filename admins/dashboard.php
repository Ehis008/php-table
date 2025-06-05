<?php
session_start();
require_once "../config/db-connect.php";

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


$sql_cars = "SELECT COUNT(*) AS total_cars FROM cars";
$stmt_cars = $pdo->prepare($sql_cars);
$stmt_cars->execute();
$total_cars = $stmt_cars->fetch(PDO::FETCH_ASSOC)['total_cars'];

$sql_total_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$stmt_customers = $pdo->prepare($sql_total_customers);
$stmt_customers->execute();
$total_customers = $stmt_customers->fetch(PDO::FETCH_ASSOC)['total_customers'];

$sql_available = "SELECT COUNT(*) AS total_available FROM cars WHERE status = 'available'";
$stmt_available = $pdo->prepare($sql_available);
$stmt_available->execute();
$total_available = $stmt_available->fetch(PDO::FETCH_ASSOC)['total_available'];



$sql_rentals = "SELECT COUNT(*) AS active_rentals FROM rental WHERE rental_status = 'active'";
$stmt_rentals = $pdo->prepare($sql_rentals);
$stmt_rentals->execute();
$active_rentals = $stmt_rentals->fetch(PDO::FETCH_ASSOC)['active_rentals'];

$sql_earnings = "SELECT SUM(total_cost) AS total_earnings FROM rental";
$stmt_earnings = $pdo->prepare($sql_earnings);
$stmt_earnings->execute();
$total_earnings = $stmt_earnings->fetch(PDO::FETCH_ASSOC)['total_earnings'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DriveLite Rentals</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
</head>
<body>
    <?php require_once "../components/adminNavbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1 class="text-white"><?php echo "Welcome ". $_SESSION['admin_username'];?></h1>
            <p class="lead">Manage your car rental business efficiently.</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Cars</h5>
                            <p class="display-4"><?php echo $total_cars; ?></p>
                            <a href="manage-cars.php" class="btn btn-primary">Manage Cars</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Active Rentals</h5>
                            <p class="display-4"><?php echo $active_rentals; ?></p>
                            <a href="manage-rentals.php" class="btn btn-primary">Manage Rentals</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Earnings</h5>
                            <p class="display-4">$<?php echo number_format($total_earnings, 2); ?></p>
                            <a href="manage-rentals.php" class="btn btn-primary">View Earnings</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Customers</h5>
                            <p class="display-4"><?php echo $total_customers; ?></p>
                          <button  class="btn btn-primary">Total Customers></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Available Cars</h5>
                            <p class="display-4"><?php echo $total_available; ?></p>
                          <button  class="btn btn-primary">Total Customers></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php require_once "../components/footer.php"; ?>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
