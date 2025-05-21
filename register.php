<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <h1 class= "text-center">Register Here</h1>
    <div class="container mt-5 mb-5">
        <form action= "processess/register-process" method= "post">
            <input type= "text" name= "first_name" placeholder="Enter your first name" class= "form-select mb-3"> 
            <input type= "text" name= "last_name" placeholder="Enter your last name" class= "form-select mb-3"> 
            <input type= "email" name= "email" placeholder="Enter your email" class= "form-select mb-3"> 
            <input type= "tel" name= "phone" placeholder="Enter your phone" class= "form-select mb-3">
            <button class ="btn btn-sm btn-success" type= "submit">Submit</button> 
        </form>
    </div>

    

  


    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

