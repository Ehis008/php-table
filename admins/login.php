<?php
require_once "../config/db-connect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email_address']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT * FROM admins WHERE username = ? AND email = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Username or Email does not match our records.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow rounded-4">
                    <div class="card-body">
                        <h3 class="text-center text-primary mb-4">Admin Login</h3>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email_address" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="../index.php" class="text-decoration-none">← Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
