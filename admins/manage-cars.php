<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
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
};

    $sql= "SELECT * FROM cars";
    $stmt= $pdo->prepare($sql);
    $stmt-> execute();
    $cars=$stmt-> fetchALL(PDO::FETCH_ASSOC);


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

        <th>Make</th>
        <th>Model</th>
        <th>Year</th>
        <th>Daily Rate</th>
        <th>Staus</th>

    <tr> <?php foreach($cars as $car){?>

        <td class= "fst-italic"><?= $car['id'];  ?></td>
        <td class= "fst-italic"><?= $car['make']; ?></td>
        <td class= "fst-italic"><?= $car['model']; ?></td>
        <td class= "fst-italic">$<?= $car['daily_rate']; ?></td>
        <td class= "fst-italic"><?= $car['status']; ?></td>
    </tr>

     <?php } ?>
        </table>


    </div>
     <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>