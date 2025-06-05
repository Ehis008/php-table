<?php
session_start();
require_once "../config/db-connect.php";

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Display error and user input
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$user_input = $_SESSION['user_input'] ?? [];
unset($_SESSION['error']);
unset($_SESSION['success']);
unset($_SESSION['user_input']);

// Fetch all cars
$sql = "SELECT id, make, model, daily_rate, status, image FROM cars";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars - DriveLite Rentals</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin-manage-cars.css">
</head>
<body>
    <?php require_once "../components/adminNavbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>Manage Cars</h1>
            <p class="lead">Add, edit, or delete cars in the fleet.</p>
        </div>
    </section>

    <!-- Add Car Form -->
    <section class="py-5">
        <div class="container">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Add New Car</h5>
                    <form action="manage-cars.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="make" class="form-label">Make</label>
                                <input type="text" id="make" name="make" class="form-control" required
                                       placeholder="Enter car make"
                                       value="<?php echo isset($user_input['make']) ? htmlspecialchars($user_input['make']) : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" id="model" name="model" class="form-control" required
                                       placeholder="Enter car model"
                                       value="<?php echo isset($user_input['model']) ? htmlspecialchars($user_input['model']) : ''; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="daily_rate" class="form-label">Daily Rate ($)</label>
                                <input type="number" id="daily_rate" name="daily_rate" class="form-control" required
                                       placeholder="Enter daily rate"
                                       value="<?php echo isset($user_input['daily_rate']) ? htmlspecialchars($user_input['daily_rate']) : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Car Image</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" name="add_car" class="btn btn-primary">Add Car</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cars Table -->
            <?php if (empty($cars)): ?>
                <p class="text-center">No cars found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
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
                                    <td>
                                        <?php if ($car['image']): ?>
                                            <img src="../carimages/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>" class="img-fluid" style="max-height: 50px;">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
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
                                        <a href="manage-cars.php?edit=<?php echo $car['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                            <button type="submit" name="delete_car" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to delete this car?');">Delete</button>
                                        </form>
                                        <?php if ($car['status'] === 'available'): ?>
                                            <a href="cars.php?id=<?php echo $car['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                        <?php else: ?>
                                            <button class="btn btn-disabled btn-sm" disabled>Unavailable</button>
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

    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
