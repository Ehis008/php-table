<?php 
session_start();
$first_name=$_POST["first_name"];
$last_name=$_POST["last_name"];
$phone=$_POST["phone"];
$email=$_POST["email"];


$_SESSION["first_name"]=$first_name;
$_SESSION["last_name"]=$last_name;
$_SESSION["phone"]=$phone;
$_SESSION["email"]=$email;

if(empty ($first_name || $last_name)){
        header("Location:../register.php");
        exit();
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
     header("Location:../register.php");
        exit();
    
}elseif(!ctype_digit($phone)){
    header("Location:../register.php");
}else{
    header("Location:../dashboard.php");
};
?>
