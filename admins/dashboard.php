<?php
session_start();
require_once "../config/db-connect.php";

// Protect page - allow only logged-in admins
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Get total customers
$sql_total_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$stmt_customers = $pdo->prepare($sql_total_customers);
$stmt_customers->execute();
$result_customers = $stmt_customers->fetch(PDO::FETCH_ASSOC);
$total_customers = $result_customers['total_customers'];

// Get total cars
$sql_total_cars = "SELECT COUNT(*) AS total_cars FROM cars";
$stmt_cars = $pdo->prepare($sql_total_cars);
$stmt_cars->execute();
$result_cars = $stmt_cars->fetch(PDO::FETCH_ASSOC);
$total_cars = $result_cars['total_cars'];

// Get total rentals
$sql_total_rentals = "SELECT COUNT(*) AS total_rentals FROM rental";
$stmt_rentals = $pdo->prepare($sql_total_rentals);
$stmt_rentals->execute();
$result_rentals = $stmt_rentals->fetch(PDO::FETCH_ASSOC);
$total_rentals = $result_rentals['total_rentals'];

// Get total rented cars
$sql_rented = "SELECT COUNT(*) AS total_rented FROM cars WHERE status = 'rented'";
$stmt_rented = $pdo->prepare($sql_rented);
$stmt_rented->execute();
$result_rented = $stmt_rented->fetch(PDO::FETCH_ASSOC);
$total_rented = $result_rented['total_rented'];

// Get total available cars
$sql_available = "SELECT COUNT(*) AS total_available FROM cars WHERE status = 'available'";
$stmt_available = $pdo->prepare($sql_available);
$stmt_available->execute();
$result_available = $stmt_available->fetch(PDO::FETCH_ASSOC);
$total_available = $result_available['total_available'];

$sql = "SELECT rental.rental_date, rental.return_date, rental.rental_status, rental.total_cost,
               customers.first_name AS first_name, customers.last_name AS last_name,
               cars.make, cars.model, cars.daily_rate
        FROM rental
        JOIN customers ON rental.customer_id = customers.id
        JOIN cars ON rental.car_id = cars.id
        ORDER BY rental.rental_date DESC
        LIMIT 5";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$recent_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
  <?php 
  
  require "../components/adminNavbar.php";
  
  ?>

<div class="container mt-5">
  <h2 class="text-center text-primary mb-4">Admin Dashboard</h2>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h5 class="card-title">Total Customers</h5>
          <p class="display-6 fw-bold"><?= $total_customers ?></p>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card text-white bg-success">
        <div class="card-body">
          <h5 class="card-title">Total Cars</h5>
          <p class="display-6 fw-bold"><?= $total_cars ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-dark">
        <div class="card-body">
          <h5 class="card-title">Total Rentals</h5>
          <p class="display-6 fw-bold"><?= $total_rentals ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card text-white bg-danger">
        <div class="card-body">
          <h5 class="card-title">Total Rented Cars</h5>
          <p class="display-6 fw-bold"><?= $total_rented ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card text-white bg-info">
        <div class="card-body">
          <h5 class="card-title">Total Available Cars</h5>
          <p class="display-6 fw-bold"><?= $total_available ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5">
  <table class="table table-striped">
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Car Name</th>
            <th>Daily Rate</th>
            <th>Rental Date</th>
            <th>Return Date</th>
            <th>Total Cost</th>
            <th>Rental Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recent_rentals as $rental): ?>
        <tr>
            <td><?= htmlspecialchars($rental['first_name'].' '.$rental['last_name']) ?></td>
            <td><?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?></td>
            <td>$<?= htmlspecialchars($rental['daily_rate']) ?></td>
            <td><?= htmlspecialchars($rental['rental_date']) ?></td>
            <td><?= htmlspecialchars($rental['return_date']) ?></td>
            <td>$<?= htmlspecialchars($rental['total_cost']) ?></td>
            <td>
                <?php
                    $return_date = $rental['return_date'];
                    $status = $rental['rental_status'];
                    $today = date('Y-m-d');

                    if ($status === 'active' && $return_date <= $today) {
                        echo '<span class="text-danger">Due for return</span>';
                    } else {
                        echo htmlspecialchars($status);
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>