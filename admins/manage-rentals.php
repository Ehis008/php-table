<?php
session_start();
require_once "../config/db-connect.php";

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Handle "Mark as Returned"
if (isset($_POST['mark_returned'])) {
    $rental_id = $_POST['rental_id'];
    $car_id = $_POST['car_id'];

    $updateRental = $pdo->prepare("UPDATE rental SET rental_status = 'returned' WHERE id = ?");
    $updateRental->execute([$rental_id]);

    $updateCar = $pdo->prepare("UPDATE cars SET status = 'available' WHERE id = ?");
    $updateCar->execute([$car_id]);

    $_SESSION['success'] = "Rental marked as returned.";
    header("Location: manage-rentals.php");
    exit();
}

// Get total earnings
$sql_earnings = "SELECT SUM(total_cost) AS total_earnings FROM rental";
$stmt_earnings = $pdo->prepare($sql_earnings);
$stmt_earnings->execute();
$total_earnings = $stmt_earnings->fetch(PDO::FETCH_ASSOC)['total_earnings'] ?? 0;

// Fetch rentals
$sql = "SELECT 
    rental.id AS rental_id,
    customers.first_name,
    customers.email,
    cars.make,
    cars.model,
    rental.rental_date,
    rental.return_date,
    rental.total_cost,
    rental.rental_status,
    rental.car_id
    FROM rental
    JOIN customers ON rental.customer_id = customers.id
    JOIN cars ON rental.car_id = cars.id
    ORDER BY rental.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rentals - DriveLite Rentals</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin-manage-rentals.css">
</head>
<body>
    <?php require_once "../components/adminNavbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>Manage Rentals</h1>
            <p class="lead">View and update rental statuses.</p>
        </div>
    </section>

    <!-- Rentals Table -->
    <section class="py-5">
        <div class="container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Earnings</h5>
                    <p class="display-6 fw-bold">$<?php echo number_format($total_earnings, 2); ?></p>
                </div>
            </div>
            <?php if (empty($rentals)): ?>
                <p class="text-center">No rentals found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Car</th>
                                <th>Rental Date</th>
                                <th>Return Date</th>
                                <th>Total Cost</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rentals as $rental): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($rental['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['email']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['make'] . ' ' . $rental['model']); ?></td>
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
                                    <td>
                                        <?php if ($rental['rental_status'] !== 'returned'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="rental_id" value="<?php echo $rental['rental_id']; ?>">
                                                <input type="hidden" name="car_id" value="<?php echo $rental['car_id']; ?>">
                                                <button type="submit" name="mark_returned" class="btn btn-sm btn-success">Mark as Returned</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">Returned</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php require_once "../components/footer.php"; ?>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
