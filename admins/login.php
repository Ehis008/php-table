<?php
require_once "../config/db-connect.php";

session_start();

$username = $_POST['username'];
$email_address = $_POST['email_address'];


$_SESSION['username'] = $username;
$_SESSION['email_address'] = $email_address;
if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)){
    echo "invalid email";
}
$sql = "SELECT * FROM admins";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach ($admins as $admin) {
    if ($admin['username'] === $username && $admin['email'] === $email_address) {
        header("Location:dashboard.php");    
    }else{
        $_SESSION['error']="Username or Email does not match";


    }    
}    
    
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
    <div class ="mb-5 mt-5 container">
        <h1 class = "text-center text-primary"> Admin</h1>
        <form action="" method ="POST">
            <input type= "text"  value = "<?=$_SESSION['username']?>"class="form-control mb-3" placeholder= "Enter your name" name = "username" required>
            <input type= "email" value = "<?=$_SESSION['email_address']?>" class="form-control mb-3" placeholder= "Enter your email" name = "email_address" required>
            <button type = "submit" class ="btn btn-primary"> Log in</button>
        </form> 
         <div class = "alert alert-danger mt-3">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='text-danger'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }?>
          </div>  
               
    </div>
        
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>