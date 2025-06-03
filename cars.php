<?php
    require_once"config/db-connect.php";
    session_start();
    

    
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
    <?php require"components/navbar.php";?>
    <div class = "mt-5 mb-5 container">
        <h1 class = "text-center text-primary"> <?php echo "Car Rental" ?></h1>
        <div class = "alert alert-primary  mb-5 mt-5 text-center fst-italic"><h1> <?php echo "Rent A Car Here" ?></h1><br><p class = "fw-bold"> Get the best car deals </p>
    
        </div>
        <table class = "table table-sm table-bordered shadow-lg">
            <th class = "text-primary" >Id</th>
            <th class = "text-primary">Make</th>
            <th class = "text-primary">Model</th>
            <th class = "text-primary">Daily Rate</th>
            <th class = "text-primary">Status</th>
            <th class = "text-primary">Actions</th>
            
           
            <tbody>
                <tr><?php foreach($cars as $car){?>
                    
                    <td class= "fst-italic"><?= $car['id'];  ?></td>
                    <td class= "fst-italic"><?= $car['make']; ?></td>
                    <td class= "fst-italic"><?= $car['model']; ?></td>
                    <td class= "fst-italic">$<?= $car['daily_rate']; ?></td>
                    <td><?php if ($car['status']==='available'){?>
                        <button class= "btn btn-primary"> Available</button>

                        <?php }else{?>
                            <button class= "btn btn-warning"> Rented</button>
                          <?php }?>
                        </td>
                    <td><?php if ($car['status']==='available'){?>
                        <a href ="car.php?id=<?=$car['id'];?>" class = "btn btn-sm btn-primary">View Car</a><?php }else{?>
                            <button class= "btn btn-warning">Unavailable </button>
                          <?php }?>
                        </td>

                    
                    
                </tr>
                <?php } ?>
                

            </tbody>

        </table>
       
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>