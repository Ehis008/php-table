<?php
session_start();
require_once "config/db-connect.php";

// Display error and user input
$error = $_SESSION['error'] ?? null;
$user_input = $_SESSION['user_input'] ?? [];
unset($_SESSION['error']);
unset($_SESSION['user_input']);

// Validate car ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: cars.php");
    exit();
}
if( $_GET['id']<= 0 || $_GET['id'] > 1000){
    header("Location: cars.php");
    exit();

} 

$car_id = $_GET['id'];

// Fetch car details
$sql = "SELECT id, make, model, daily_rate, status, image FROM cars WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if car not found or rented
if (!$car || $car['status'] === 'rented') {
    header("Location: cars.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?> - DriveLite Rentals</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/car.css">
</head>
<body>
    <?php require_once "components/navbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>Rent <?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h1>
        </div>
    </section>

    <!-- Car Details and Form -->
    <section class="py-5">
        <div class="container">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img src="carimages/<?php echo htmlspecialchars($car['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h5>
                            <p><strong>Daily Rate:</strong> $<?php echo number_format($car['daily_rate'], 2); ?></p>
                            <p><strong>Status:</strong> <span class="badge bg-primary"><?php echo htmlspecialchars($car['status']); ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rental Form</h5>
                            <form action="processess/hire-process.php" method="POST">
                                <input type="hidden" name="daily_rate" value="<?php echo htmlspecialchars($car['daily_rate']); ?>">
                                <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
                                <div class="mb-3">
                                    <label for="return_date" class="form-label">Return Date</label>
                                    <input type="date" id="return_date" name="return_date" class="form-control" required
                                           value="<?php echo isset($user_input['return_date']) ? htmlspecialchars($user_input['return_date']) : ''; ?>"
                                           min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" required
                                           placeholder="Enter your first name"
                                           value="<?php echo isset($user_input['first_name']) ? htmlspecialchars($user_input['first_name']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" required
                                           placeholder="Enter your last name"
                                           value="<?php echo isset($user_input['last_name']) ? htmlspecialchars($user_input['last_name']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required
                                           placeholder="Enter your email"
                                           value="<?php echo isset($user_input['email']) ? htmlspecialchars($user_input['email']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" required
                                           placeholder="Enter your phone"
                                           value="<?php echo isset($user_input['phone']) ? htmlspecialchars($user_input['phone']) : ''; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Hire Car</button>
                                <a href="cars.php" class="btn btn-secondary ms-2">Back to Cars</a>
                            </form>
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
