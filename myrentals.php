<?php 
session_start();
require_once"config/db-connect.php"; 

if (!isset($_SESSION['customer_id'])){
    header('Location:login.php');
    exit();
}
 $customer_id=$_SESSION['customer_id'];

 $sql="SELECT * FROM customers WHERE id=?";
 $stmt=$pdo->prepare($sql);
 $stmt->execute([$customer_id]);
 $customer=$stmt-> fetch(PDO:: FETCH_ASSOC);

 $sql="SELECT rental.rental_date, rental.return_date,rental.rental_status,rental.total_cost,cars.make,cars.model,cars.daily_rate FROM rental JOIN cars ON rental.car_id= cars.id WHERE rental.customer_id=?";
 $stmt=$pdo->prepare($sql);
 $stmt->execute([$customer_id]);
 $rentals=$stmt-> fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Hisory</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container py-5">
    <div class="text-end mb-3">
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
    <p><?=$customer['first_name'] ?>;</p>
    <p><?=$customer['last_name'] ?>;</p>
    <p><?=$customer['email'] ?>;</p>
    <p><?=$customer['phone'] ?>;</p>

    <table class="table table-sm">
     <thead>
      <tr>
         <th>Car Name</th>
        <th>Daily Rate</th>
        <th>Rental Date</th>
        <th>Return Date</th>
        <th>Total Cost</th>
        <th>Rental Status</th>
     </tr>
    </thead>
    <tbody>
     <?php foreach ($rentals as $rental): ?>
    <tr>
        <td><?= htmlspecialchars($rental['make'] . ' ' . $rental['model']) ?></td>
        <td><?= htmlspecialchars($rental['daily_rate']) ?></td>
        <td><?= htmlspecialchars($rental['rental_date']) ?></td>
        <td><?= htmlspecialchars($rental['return_date']) ?></td>
        <td><?= htmlspecialchars($rental['total_cost']) ?></td>
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
    
    



    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>