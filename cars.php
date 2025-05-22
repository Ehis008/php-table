<?php
    // $cars=[
    //         ["id"=> 1,
    //         "make"=> "Toyota",
    //         "model"=> "corolla",
    //         "year"=> 2003,
    //         "daily_rate"=> "$30",
    //         "status"=> "available",
            
    //         ],
    //         [
    //         "id"=> 2,
    //         "make"=> "Nissan",
    //         "model"=> "3 series",
    //         "year"=> 2022,
    //         "daily_rate"=> "$50",
    //         "status"=> "available"
            
    //         ],
    //         [
    //         "id"=> 3,
    //         "make"=> "Honda",
    //         "model"=> "Accord",
    //         "year"=> 2006,
    //         "daily_rate"=> "$35",
    //         "status"=> "pending",
            
    //         ],
    //         [
    //         "id"=> 4,
    //         "make"=> "Toyota",
    //         "model"=> "civic",
    //         "year"=> "2009",
    //         "daily_rate"=> "$30", 
    //         "status"=> "pending",
            
    //         ],
    //     [
    //         "id"=> 5,
    //         "make"=> "Peugeout",
    //         "model"=> 504,
    //         "year"=> 2005,
    //         "daily_rate"=> "$20",
    //         "status"=> "available",
            
    //     ],
    //     [
    //         "id"=> 6,
    //         "make"=> "Ford",
    //         "model"=> "Mustang",
    //         "year"=> 2023,
    //         "daily_rate"=> "$60",
    //         "status"=> "available",
            
    //     ]
    // ];
    require_once"config/db-connect.php";
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
    <title>Car Rental</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class = "mt-5 mb-5 container">
        <h1 class = "text-center text-success"> <?php echo "Car Rental" ?></h1>
        <div class = "alert alert-success mb-5 mt-5 text-center fst-italic"><h1> <?php echo "Rent A Car Here" ?></h1><br><p class = "fw-bold"> Get the best car deals </p>
    
        </div>
        <table class = "table table-sm table-bordered shadow-lg">
            <th class = "text-success" >Id</th>
            <th class = "text-success">Make</th>
            <th class = "text-success">Model</th>
            <th class = "text-success">Daily Rate</th>
            <th class = "text-success">Status</th>
            <th class = "text-success">Actions</th>
           
            <tbody>
                <tr><?php foreach($cars as $car){?>
                    
                    <td class= "fst-italic"><?= $car['id'];  ?></td>
                    <td class= "fst-italic"><?= $car['make']; ?></td>
                    <td class= "fst-italic"><?= $car['model']; ?></td>
                    <td class= "fst-italic"><?= $car['daily_rate']; ?></td>
                    <td class= "fst-italic"><?= $car['status']; ?></td>
                    <td><a href ="car.php?id=<?=$car['id'];?>" class = "btn btn-sm btn-success">View</a></td>

                    
                    
                </tr>
                <?php } ?>
                

            </tbody>

        </table>
       
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>