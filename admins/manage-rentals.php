<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    
</body>
</html><?php
session_start();
require_once "../config/db-connect.php";

// Protect page - allow only logged-in admins
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
     
    $sql= "SELECT 
    rental.id AS rental_id,
    customers.first_name,
    customers.last_name,
    customers.email,
    cars.make,
    cars.model,
    rental.rental_date,
    rental.return_date,
    rental.total_cost,
    rental.rental_status,
    rental.car_id
    FROM rental
    JOIN customers ON rental.customer_id = customers.id
    JOIN cars ON rental.car_id = cars.id
    ORDER BY rental.id DESC";
    $stmt= $pdo->prepare($sql);
    $stmt-> execute();
    $rentals =$stmt-> fetchALL(PDO::FETCH_ASSOC);
   // print_r($rentals_manage);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <table class="table table-sm mt-4 mb-4 ">

        <th>Customer Name</th>
        <th>Email</th>
        <th>Car Name</th>
        <th>Rental Date</th>
        <th>Return Date</th>
        <th>Total Cost</th>
        <th>Status</th>
        <th>Action</th>

         <tr> <?php foreach($rentals as $rental){?>

        <td class= "fst-italic"><?= $rental['first_name'].' '.$rental['last_name'];?></td>
        <td class= "fst-italic"><?= $rental['email'];?></td>
        <td class= "fst-italic"><?= $rental['make'].' '.$rental['model'];?></td>
        <td class= "fst-italic"><?= $rental['rental_date'];?></td>
        <td class= "fst-italic"><?= $rental['return_date'];?></td>
        <td class= "fst-italic"><?= $rental['total_cost'];?></td>
        <td><?php
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
        <td>
            <?php
            if($status==="")
            
            ?>
        </td>
        
    </tr>
     <?php } ?>
      </table>

    <form method="post">
        <input type="hidden" name="rental_id" value="<?= $rental['rental_id'] ?>">
        <input type="hidden" name="car_id" value="<?= $rental['car_id'] ?>">
        <button type="submit" name="mark_returned">Mark as Returned</button>
    </form>



    </div>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>