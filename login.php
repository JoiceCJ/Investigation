<?php
$login = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'assets/dbconnect.php';
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num =mysqli_num_rows($result);
    
    if($num == 1){
        while($row=mysqli_fetch_assoc($result)){
            if (password_verify($password, $row['password'])){
                $login = true;
                session_start();    
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php"); 
            }
            else{
                $showError = "Invalid Credentials";
                }
        }
    }    
    else{
        $showError ="Invalid Credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require 'assets/_navbar.php'?>
    <?php
    if($login){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($showError){
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div> ';
        }
        ?>
    <div class="container col-md-3">
        <h1 class="text-center my-4">Welcome!</h1>
        <h1 class="text-center my-4">Log In</h1>
        <form action="/sample/login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Email address</label>
                <input type="text" maxlength="20" class="form-control" id="username" name="username" placeholder="Enter your email here..." aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="60" class="form-control" id="password" name="password" placeholder="Enter your password here...">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Log In</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>