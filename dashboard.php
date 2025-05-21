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
    <div class = " container   mt-5 mb-5">
        <h1 class = "text-center"> View User</h1>
        <p><?= $first_name ?></p>
        <p><?= $last_name ?></p>
        <p><?= $email ?></p>
        <p><?= $phone ?></p>
    </div>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>  
</body>
</html>