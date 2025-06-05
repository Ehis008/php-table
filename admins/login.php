
<?php
require_once "../config/db-connect.php";
session_start();

// Display error
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email_address']);

    if (empty($username)) {
        $_SESSION['error'] = "Username is required.";
        header("Location: login.php");
        exit();
    }

    if (empty($email)) {
        $_SESSION['error'] = "Email is required.";
        header("Location: login.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT * FROM admins WHERE username = ? AND email = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        $_SESSION['error'] = "Username or email does not match our records.";
        header("Location: login.php");
        exit();
    }

    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['admin_email'] = $admin['email'];
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - DriveLite Rentals</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin-login.css">
</head>
<body>

    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <h1>Admin Login</h1>
            <p class="lead">Access the admin dashboard.</p>
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
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Admin Login</h5>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email_address" class="form-label">Email Address</label>
                                    <input type="email" id="email_address" name="email_address" class="form-control" placeholder="Enter email" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Log In</button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <a href="../index.php" class="text-decoration-none text-primary">← Back to Home</a>
                            </div>
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
