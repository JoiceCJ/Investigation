<?php
require 'assets/sessionCheck.php';
$greeting = "Good Morning!";
$currentTime = date("a");

if ($currentTime == 'am') {
    $greeting = "Good morning!";
} elseif ($currentTime == 'pm') {
    $greeting = "Good afternoon!";
} else {
    $greeting = "Good evening!";
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $greeting . ' ' .  $_SESSION['username'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <?php require 'assets/_navbar.php' ?>
    <div class="container my-4">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading text-center">Welcome - <?php echo $greeting . ' ' . $_SESSION['username'] ?></h4>
            <p class="text-center">Welcome to IAgency. You are logged in as <?php echo $_SESSION['username'] ?></p>
            <hr>
            <p class="mb-0"></p>
        </div>
    </div>
    <h1 class="text-center my-4">Add New Data</h1>
    <div class="button">
        <div class="text-center btn-lg">
            <a href="insurance.php" class="btn btn-success">Go to Insurance Page</a>
            <a href="bank.php" class="btn btn-success">Go to Bank Page</a>
        </div>
    </div>    
    <h1 class="text-center my-4">Edit Data</h1>
    <div class="button">
        <div class="text-center btn-lg">
            <a href="/sample/viewInsEntries.php?id=1" class="btn btn-success">Edit Insurance Page</a>
            <a href="/sample/viewBankEntries.php?id=1" class="btn btn-success">Edit Bank Page</a>
        </div>
    </div>    
</body>

</html>