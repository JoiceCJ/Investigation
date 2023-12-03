<?php
$showError = false;
$showAlert = false;
// connecting to db
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'assets/dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];   

    // to check whether the username exist or not//
    $existSql = "SELECT * FROM `users` WHERE username ='$username'";
    $result = mysqli_query($conn, $existSql); 
    $numExistRows = mysqli_num_rows($result); 
    //if numexistrows greater than 0 then there exist a  username//
    if($numExistRows >0){
        $showError = "Username already taken";
    }
    else{
        // checking if pass and confirm password is same
        if($password == $cpassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `password`, `date`) VALUES ('$username', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your account has been created. You can Log In now.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        }
            else{
                $showError = "Passwords do not match";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<?php require 'assets/_navbar.php'?>
    <h1 class="text-center my-4">Sign Up</h1>
    <div class="container col-md-3 my-4">
        <form action="/sample/signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Email address</label>
                <input type="text" maxlength="30" class="form-control" id="username" name="username" placeholder="Enter your email here..." aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="60" class="form-control" id="password" name="password" placeholder="Enter your password here...">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" maxlength="60" class="form-control" id="cpassword" name="cpassword">
                <div id="emailHelp" class="form-text">Enter the same password again</div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Sign Up</button>
            </div>
        </form>
    </div>
</body>
</html>