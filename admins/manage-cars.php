<?php
session_start();
require_once "../config/db-connect.php";

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admins/login.php");
    exit;
}

// Initialize variables
$error = null;
$success = $_SESSION['success'] ?? null;
$user_input = $_POST ?? [];
unset($_SESSION['success']);

// Handle delete car
if (isset($_POST['delete_car']) && isset($_POST['car_id'])) {
    $car_id = (int)$_POST['car_id'];

    // Fetch image filename
    $sql = "SELECT image FROM cars WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete from database
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executed = $stmt->execute([$car_id]);

    if ($executed) {
        // Delete image file if exists
        if ($car && $car['image']) {
            $image_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'CarRentalApp' . DIRECTORY_SEPARATOR . 'carimages' . DIRECTORY_SEPARATOR . $car['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        $_SESSION['success'] = "Car deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete car.";
    }
    header("Location: ../admins/manage-cars.php");
    exit;
}

// Handle form submission (add car)
if (isset($_POST['add_car'])) {
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $daily_rate = trim($_POST['daily_rate']);
    $image = $_FILES['image'] ?? null;

    // Validate inputs
    if (empty($make)) {
        $error = "Make is required.";
    }
    if (empty($model)) {
        $error = $error ?: "Model is required.";
    }
    if (empty($daily_rate) || !is_numeric($daily_rate) || $daily_rate <= 0) {
        $error = $error ?: "Valid daily rate is required.";
    }

    // Handle image upload if no errors
    $image_name = null;
    if (!$error && $image && $image['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'CarRentalApp' . DIRECTORY_SEPARATOR . 'carimages' . DIRECTORY_SEPARATOR;

        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true);
        }

        // Check directory permissions
        if (!is_writable($upload_dir)) {
            $error = "carimages directory is not writable.";
        }

        // Validate image
        if (!$error && !in_array($image['type'], $allowed_types)) {
            $error = "Only JPEG, PNG, or GIF images are allowed.";
        }
        if (!$error && $image['size'] > $max_size) {
            $error = "Image size must be less than 5MB.";
        }

        // Move uploaded file
        if (!$error) {
            $image_ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $image_ext;
            $image_path = $upload_dir . $image_name;
            if (!move_uploaded_file($image['tmp_name'], $image_path)) {
                $error = "Failed to upload image.";
            }
        }
    }

    // Insert into database if no errors
    if (!$error) {
        $sql = "INSERT INTO cars (make, model, daily_rate, status, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $status = 'available';
        $executed = $stmt->execute([$make, $model, $daily_rate, $status, $image_name]);

        if ($executed) {
            $_SESSION['success'] = "Car added successfully.";
            header("Location: ../admins/manage-cars.php");
            exit;
        } else {
            $error = "Failed to add car.";
        }
    }
}

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
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin-manage-cars.css">
</head>
<body>
    <?php require_once "../components/adminNavbar.php"; ?>

    <main>
        <!-- Header Section -->
        <section class="header-section">
            <div class="container text-white">
                <h1>Manage Cars</h1>
                <p class="lead">Add or Delete Cars In The Fleet.</p>
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
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
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
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                                <button type="submit" name="delete_car" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to delete this car?');">Delete</button>
                                            </form>
                                            <?php if ($car['status'] === 'available'): ?>
                                                <a href="../cars.php?id=<?php echo $car['id']; ?>" class="btn btn-primary btn-sm">View</a>
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
    </main>

    <?php require_once "../components/footer.php"; ?>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>