<?php
session_start();
require_once "../config/db-connect.php";

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Get total customers
$sql_total_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$stmt_customers = $pdo->prepare($sql_total_customers);
$stmt_customers->execute();
$total_customers = $stmt_customers->fetch(PDO::FETCH_ASSOC)['total_customers'];

// Get total cars
$sql_total_cars = "SELECT COUNT(*) AS total_cars FROM cars";
$stmt_cars = $pdo->prepare($sql_total_cars);
$stmt_cars->execute();
$total_cars = $stmt_cars->fetch(PDO::FETCH_ASSOC)['total_cars'];

// Get total rentals
$sql_total_rentals = "SELECT COUNT(*) AS total_rentals FROM rental";
$stmt_rentals = $pdo->prepare($sql_total_rentals);
$stmt_rentals->execute();
$total_rentals = $stmt_rentals->fetch(PDO::FETCH_ASSOC)['total_rentals'];

// Get total rented cars
$sql_rented = "SELECT COUNT(*) AS total_rented FROM cars WHERE status = 'rented'";
$stmt_rented = $pdo->prepare($sql_rented);
$stmt_rented->execute();
$total_rented = $stmt_rented->fetch(PDO::FETCH_ASSOC)['total_rented'];

// Get total available cars
$sql_available = "SELECT COUNT(*) AS total_available FROM cars WHERE status = 'available'";
$stmt_available = $pdo->prepare($sql_available);
$stmt_available->execute();
$total_available = $stmt_available->fetch(PDO::FETCH_ASSOC)['total_available'];

// Get recent rentals
$sql = "SELECT rental.rental_date, rental.return_date, rental.rental_status, rental.total_cost,
               customers.first_name, cars.make, cars.model, cars.daily_rate, cars.image
        FROM rental
        JOIN customers ON rental.customer_id = customers.id
        JOIN cars ON rental.car_id = cars.id
        ORDER BY rental.rental_date DESC
        LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$recent_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h1>Admin Dashboard</h1>
            <p class="lead">Manage your car rental business.</p>
        </div>
    </section>

    <!-- Stats Cards -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Customers</h5>
                            <p class="display-6 fw-bold"><?php echo htmlspecialchars($total_customers); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Cars</h5>
                            <p class="display-6 fw-bold"><?php echo htmlspecialchars($total_cars); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Rentals</h5>
                            <p class="display-6 fw-bold"><?php echo htmlspecialchars($total_rentals); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Rented Cars</h5>
                            <p class="display-6 fw-bold"><?php echo htmlspecialchars($total_rented); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Available Cars</h5>
                            <p class="display-6 fw-bold"><?php echo htmlspecialchars($total_available); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Rentals -->
    <section class="py-5">
        <div class="container">
            <h3 class="mb-4">Recent Rentals</h3>
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Car</th>
                            <th>Daily Rate</th>
                            <th>Rental Date</th>
                            <th>Return Date</th>
                            <th>Total Cost</th>
                            <th>Rental Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_rentals as $rental): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rental['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($rental['make'] . ' ' . $rental['model']); ?></td>
                                <td>$<?php echo number_format($rental['daily_rate'], 2); ?></td>
                                <td><?php echo htmlspecialchars($rental['rental_date']); ?></td>
                                <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                                <td>$<?php echo number_format($rental['total_cost'], 2); ?></td>
                                <td>
                                    <?php
                                    $return_date = $rental['return_date'];
                                    $status = $rental['rental_status'];
                                    $today = date('Y-m-d');
                                    if ($status === 'active' && $return_date <= $today) {
                                        echo '<span class="badge bg-danger">Due for return</span>';
                                    } else {
                                        echo '<span class="badge bg-primary">' . htmlspecialchars($status) . '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php require_once "../components/footer.php"; ?>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>