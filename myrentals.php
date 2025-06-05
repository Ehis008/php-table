<?php 
session_start();
require_once "config/db-connect.php";

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

$sql = "SELECT * FROM customers WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT rental.rental_date, rental.return_date, rental.rental_status, rental.total_cost,
               cars.make, cars.model, cars.daily_rate, cars.image 
        FROM rental 
        JOIN cars ON rental.car_id = cars.id 
        WHERE rental.customer_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rentals - DriveLite Rentals</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/myrentals.css">
</head>
<body>
    <?php require_once "components/navbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>My Rentals</h1>
            <p class="lead">View your rental history.</p>
        </div>
    </section>

    <!-- Customer Info and Rentals -->
    <section class="py-5">
        <div class="container">
            <div class="text-end mb-3">
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Customer Information</h5>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rental History</h5>
                            <?php if (empty($rentals)): ?>
                                <p class="text-center">No rentals found.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover">
                                        <thead>
                                            <tr>
                                                <th>Car</th>
                                                <th>Daily Rate</th>
                                                <th>Rental Date</th>
                                                <th>Return Date</th>
                                                <th>Total Cost</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rentals as $rental): ?>
                                                <tr>
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "components/footer.php"; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
