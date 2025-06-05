```php
<?php 
session_start();
require_once "../config/db-connect.php";

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Handle add car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_car'])) {
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $year = trim($_POST['year']);
    $daily_rate = trim($_POST['daily_rate']);
    $image = $_FILES['image']['name'];

    if (empty($make)) {
        $_SESSION['error'] = "Make is required.";
        header("Location: manage-cars.php");
        exit();
    }
    if (empty($model)) {
        $_SESSION['error'] = "Model is required.";
        header("Location: manage-cars.php");
        exit();
    }
    if (empty($year)) {
        $_SESSION['error'] = "Year is required.";
        header("Location: manage-cars.php");
        exit();
    }
    if (!is_numeric($year) || $year < 1900 || $year > date('Y')) {
        $_SESSION['error'] = "Year must be between 1900 and " . date('Y') . ".";
        header("Location: manage-cars.php");
        exit();
    }
    if (empty($daily_rate)) {
        $_SESSION['error'] = "Daily rate is required.";
        header("Location: manage-cars.php");
        exit();
    }
    if (!is_numeric($daily_rate) || $daily_rate <= 0) {
        $_SESSION['error'] = "Daily rate must be a positive number.";
        header("Location: manage-cars.php");
        exit();
    }
    if (empty($image)) {
        $_SESSION['error'] = "Image is required.";
        header("Location: manage-cars.php");
        exit();
    }

    $target_dir = "../../carimages/";
    $target_file = $target_dir . basename($image);
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $_SESSION['error'] = "Failed to upload image.";
        header("Location: manage-cars.php");
        exit();
    }

    $sql = "INSERT INTO cars (make, model, year, daily_rate, status, image) VALUES (?, ?, ?, ?, 'available', ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$make, $model, $year, $daily_rate, $image]);
    $_SESSION['success'] = "Car added successfully.";
    header("Location: manage-cars.php");
    exit();
}

// Handle delete car
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "SELECT image FROM cars WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$delete_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($car) {
        $image_path = "../../carimages/" . $car['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $sql = "DELETE FROM cars WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$delete_id]);
        $_SESSION['success'] = "Car deleted successfully.";
    } else {
        $_SESSION['error'] = "Car not found.";
    }
    header("Location: manage-cars.php");
    exit();
}

// Fetch cars
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
            <p class="lead">Add, view, or delete cars.</p>
        </div>
    </section>

    <!-- Add Car Form -->
    <section class="py-5">
        <div class="container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add New Car</h5>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="make" class="form-label">Make</label>
                                    <input type="text" id="make" name="make" class="form-control" required placeholder="Enter car make">
                                </div>
                                <div class="mb-3">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" id="model" name="model" class="form-control" required placeholder="Enter car model">
                                </div>
                                <div class="mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" id="year" name="year" class="form-control" required placeholder="Enter year">
                                </div>
                                <div class="mb-3">
                                    <label for="daily_rate" class="form-label">Daily Rate</label>
                                    <input type="number" id="daily_rate" name="daily_rate" class="form-control" required placeholder="Enter daily rate" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Car Image</label>
                                    <input type="file" id="image" name="image" class="form-control" required accept="image/*">
                                </div>
                                <button type="submit" name="add_car" class="btn btn-primary">Add Car</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Car List</h5>
                            <?php if (empty($cars)): ?>
                                <p class="text-center">No cars found.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover">
                                        <thead>
                                            <tr>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Year</th>
                                                <th>Daily Rate</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cars as $car): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($car['make']); ?></td>
                                                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                                                    <td><?php echo htmlspecialchars($car['year']); ?></td>
                                                    <td>$<?php echo number_format($car['daily_rate'], 2); ?></td>
                                                    <td>
                                                        <?php echo $car['status'] === 'available' ? '<span class="badge bg-primary">Available</span>' : '<span class="badge bg-warning">Rented</span>'; ?>
                                                    </td>
                                                    <td>
                                                        <a href="?delete_id=<?php echo $car['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
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

    <?php require_once "../components/footer.php"; ?>

    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```