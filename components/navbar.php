<style>
    .nav-link i, .btn i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="/index.php"><i class="bi bi-car-front"></i> DriveLite Rentals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="bi bi-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cars.php"><i class="bi bi-car-front"></i> Rent a Car</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="terms.php"><i class="bi bi-file-text"></i> Terms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admins/login.php"><i class="bi bi-person"></i></i> Admin</a>
                </li>
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="myrentals.php"><i class="bi bi-calendar-check"></i> My Rentals</a>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (isset($_SESSION['customer_id'])): ?>
                <span class="navbar-text me-3"><i class="bi bi-person"></i> Customer</span>
                <a href="logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary"><i class="bi bi-person"></i> Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>