<?php
session_start();
require_once"config/db-connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $lastname=trim($_POST['lastname']);
    $email=trim($_POST['email']);

    if(empty($lastname)){
        $_SESSION['error']= "Enter phone number";
        header('Location: login.php');
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error']= "Invalid Email";
        header('Location: login.php');
        exit();
    }

    $sql= "SELECT * FROM customers WHERE last_name=? AND email=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$lastname,$email]);
    $customer=$stmt->fetch (PDO::FETCH_ASSOC);

    if($customer){
        $_SESSION['customer_id']= $customer['id'];
        header('Location: myrentals.php');
        exit();
    }else{
        $_SESSION['error']= "Incorrect last name or email";
        header('Location: login.php');
        exit();
     }

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 mb-5">
     <h3 class = "text-center"> Customer Login </h3>
     <form action="" method="POST">
      <input type = "text" class= "form-control mb-3" name="lastname" required placeholder="Enter your last name">
      <input type = "email" class= "form-control mb-3" name="email" required placeholder="Enter your email address">
      <button class="btn btn-primary"> Log In</button>
     </form>

    </div>


    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>