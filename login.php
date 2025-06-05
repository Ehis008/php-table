<?php
session_start();
require_once "config/db-connect.php";

// Display error
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);

    if (empty($lastname)) {
        $_SESSION['error'] = "Last name is required.";
        header('Location: login.php');
        exit();
    }

    if (empty($email)) {
        $_SESSION['error'] = "Email is required.";
        header('Location: login.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header('Location: login.php');
        exit();
    }

    $sql = "SELECT * FROM customers WHERE last_name = ? AND email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lastname, $email]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        $_SESSION['error'] = "Incorrect last name or email.";
        header('Location: login.php');
        exit();
    }

    $_SESSION['customer_id'] = $customer['id'];
    header('Location: myrentals.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - DriveLite Rentals</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <?php require_once "components/navbar.php"; ?>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>Customer Login</h1>
            <p class="lead">Access your rental history.</p>
        </div>
    </section>

    <!-- Login Form -->
    <section class="py-5">
        <div class="container">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Login</h5>
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" id="lastname" class="form-control" name="lastname" required placeholder="Enter your last name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" class="form-control" name="email" required placeholder="Enter your email address">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Log In</button>
                                </div>
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