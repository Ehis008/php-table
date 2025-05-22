<?php
  session_start();
  $first_name= $_SESSION["first_name"];
  $last_name= $_SESSION["last_name"];
  $email= $_SESSION["phone"];
  $phone= $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class = " container mt-5 mb-5">
        <div class= "alert alert-primary text-center">
            <h1 class = "text-primary"> View User</h1>
            <p> View Users Details Here</p>
        </div> 
        <div class="card shadow-lg text-primary fst-italic ">
            <p><strong>First name:</strong> <?= $first_name ?></p>
            <p><strong>Last name:</strong> <?= $last_name ?></p>
            <p><strong>Email Address:</strong> <?= $email ?></p>
            <p><strong>Phone Number:</strong> <?= $phone ?></p>
        
        </div>   
            
    </div>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>  
</body>
</html>