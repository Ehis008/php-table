<?php
    // $cars=[
    //         ["id"=> 1,
    //         "make"=> "Toyota",
    //         "model"=> "corolla",
    //         "year"=> 2003,
    //         "daily_rate"=> 30,
    //         "status"=> "available",
            
    //         ],
    //         [
    //         "id"=> 2,            "make"=> "Nissan",
    //         "model"=> "3 series",
    //         "year"=> 2022,
    //         "daily_rate"=> 50,
    //         "status"=> "available"
            
    //         ],
    //         [
    //         "id"=> 3,
    //         "make"=> "Honda",
    //         "model"=> "Accord",
    //         "year"=> 2006,
    //         "daily_rate"=> 35,
    //         "status"=> "pending",
            
    //         ],
    //         [
    //         "id"=> 4,
    //         "make"=> "Toyota",
    //         "model"=> "civic",
    //         "year"=> "2009",
    //         "daily_rate"=> 30, 
    //         "status"=> "pending",
            
    //         ],
    //     [
    //         "id"=> 5,
    //         "make"=> "Peugeout",
    //         "model"=> 504,
    //         "year"=> 2005,
    //         "daily_rate"=> 20,
    //         "status"=> "available",
            
    //     ],
    //     [
    //         "id"=> 6,
    //         "make"=> "Ford",
    //         "model"=> "Mustang",
    //         "year"=> 2023,
    //         "daily_rate"=> 60,
    //         "status"=> "available",
            
    //     ]
    // ];
    require_once"config/db-connect.php";
    

     if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
         header("Location:cars.php");
         exit();
     }
    if($_GET['id'] > 1000){
         header("Location:cars.php");
         exit();
     };
     $selectedCar= $_GET['id'];

    
 //$selectedCar= reset($selectedCar);

    if (!$selectedCar){
        header("Location:cars.php");
        exit();

    };
    $sql= "SELECT * FROM cars WHERE id=$selectedCar";
    $stmt= $pdo->prepare($sql);
    $stmt-> execute();
    $selectedCar=$stmt-> fetch(PDO::FETCH_ASSOC);



    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h1 class = 'text-center text-primary mb-5'> Selected Car</h1>
        <div class = 'card alert alert-primary fw-bold'>
            <p><strong class= 'fst-italic text-primary'> Make: </strong><?= $selectedCar['make'];?></p>
            <p><strong class= 'fst-italic text-primary'> Model: </strong><?= $selectedCar['model']; ?></p>
            <p><strong class= 'fst-italic text-primary'> Daily Rate: </strong>$<?= $selectedCar['daily_rate']; ?></p>
            <p><strong class= 'fst-italic text-primary'> Status: </strong><?= $selectedCar['status']; ?></p>
        </div>
        <a href = 'cars.php' class = 'btn btn-sm btn-primary'>Back to Home </a>

        
        
        

    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>


   
    
</body>
</html>



