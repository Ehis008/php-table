<?php
    $cars=[
            ["id"=> 1,
            "make"=> "Toyota",
            "model"=> "corolla",
            "year"=> 2003,
            "daily_rate"=> "$30",
            "status"=> "available",
            
            ],
            [
            "id"=> 2,
            "make"=> "Nissan",
            "model"=> "3 series",
            "year"=> 2022,
            "daily_rate"=> "$50",
            "status"=> "available"
            
            ],
            [
            "id"=> 3,
            "make"=> "Honda",
            "model"=> "Accord",
            "year"=> 2006,
            "daily_rate"=> "$35",
            "status"=> "pending",
            
            ],
            [
            "id"=> 4,
            "make"=> "Toyota",
            "model"=> "civic",
            "year"=> "2009",
            "daily_rate"=> "$30", 
            "status"=> "pending",
            
            ],
        [
            "id"=> 5,
            "make"=> "Peugeout",
            "model"=> 504,
            "year"=> 2005,
            "daily_rate"=> "$20",
            "status"=> "available",
            
        ],
        [
            "id"=> 6,
            "make"=> "Ford",
            "model"=> "Mustang",
            "year"=> 2023,
            "daily_rate"=> "$60",
            "status"=> "available",
            
        ]
    ];

    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        header("Location:cars.php");
        exit();
    }
    if($_GET['id'] > 1000){
        header("Location:cars.php");
        exit();
    }
    
?>



