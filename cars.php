<?php
session_start();
require_once "config/db-connect.php";

// Display error
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

// Fetch all cars
$sql = "SELECT * FROM cars";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car - DriveLite Rentals</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/cars.css">
</head>
<body>
    <?php require_once "components/navbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>Rent a Car</h1>
            <p class="lead">Explore our fleet and find the perfect car for your journey.</p>
        </div>
    </section>

    <!-- Cars Table -->
    <section class="py-5">
        <div class="container">
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (empty($cars)): ?>
                <p class="text-center">No cars available.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Daily Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($car['id']); ?></td>
                                    <td><?php echo htmlspecialchars($car['make']); ?></td>
                                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                                    <td>$<?php echo number_format($car['daily_rate'], 2); ?></td>
                                    <td>
                                        <?php if ($car['status'] === 'available'): ?>
                                            <span class="badge bg-primary">Available</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Rented</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($car['status'] === 'available'): ?>
                                            <a href="car.php?id=<?php echo $car['id']; ?>" class="btn btn-primary btn-sm">View Car</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Unavailable</button>
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

    <?php require_once "components/footer.php"; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
