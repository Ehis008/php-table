<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="index.php">DriveLite Rentals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cars.php">Rent a Car</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="terms.php">Terms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admins/login.php">Admin</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['customer_id'])): ?>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary-light">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
