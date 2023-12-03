<?php
require 'assets/sessionCheck.php';
$error_message = "";
include 'assets/dbconnect.php';

//initializing
if (!isset($id)) {
    $id = '';
}
$id= $bankList = $fileNo = $address = $detailsOf  = $allottedToWhom = $district = $noOfProperties = $toAllotted = $sendOnDate = $dateToBe = $moneyReceived = ''; 
$editing = false;

//for fetching the existing form data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];  
    $entryId = $id;
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM `bank` WHERE `no` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    //assigning fetched data
        if ($row) {
            $editing = true;
            //assigning data
            $bankList = $row['bankList'];
            $fileNo = $row['fileNo'];
            $address = $row['address'];
            $detailsOf = $row['detailsOf'];
            $allottedToWhom = $row['allottedToWhom'];
            $district = $row['district'];
            $noOfProperties = $row['noOfProperties'];
            $toAllotted = $row['toAllotted'];
            $sendOnDate = $row['sendOnDate'];
            $dateToBe = $row['dateToBe'];
            $moneyReceived = $row['moneyReceived'];       
            
            echo '
            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                You are editing existing data.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> No data found for the provided ID.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
   }else {
    echo "Error executing SQL: " . mysqli_error($conn); // Check for SQL errors
}
}
//form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bankList = mysqli_real_escape_string($conn, $_POST["bankList"]);
    $fileNo = mysqli_real_escape_string($conn, $_POST["fileNo"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $detailsOf = mysqli_real_escape_string($conn, $_POST["detailsOf"]);
    $allottedToWhom = mysqli_real_escape_string($conn, $_POST["allottedToWhom"]);
    $district = mysqli_real_escape_string($conn, $_POST["district"]);
    $noOfProperties = mysqli_real_escape_string($conn, $_POST["noOfProperties"]);
    $toAllotted = mysqli_real_escape_string($conn, $_POST["toAllotted"]);
    $sendOnDate = mysqli_real_escape_string($conn, $_POST["sendOnDate"]);
    $dateToBe = mysqli_real_escape_string($conn, $_POST["dateToBe"]);
    $moneyReceived = mysqli_real_escape_string($conn, $_POST["moneyReceived"]);

    if ($editing) {
        $sql = "UPDATE `bank` SET `bankList` = '$bankList', `fileNo` = '$fileNo', `address` = '$address', `detailsOf` = '$detailsOf', `allottedToWhom` = '$allottedToWhom', `district` = '$district', `noOfProperties` = '$noOfProperties', `toAllotted` = '$toAllotted', `sendOnDate` = '$sendOnDate', `dateToBe` ='$dateToBe', `moneyReceived` = '$moneyReceived' WHERE `no` = '$id'";
    } else {
        $sql = "INSERT INTO `bank` (`bankList`, `fileNo`, `address`, `detailsOf`, `allottedToWhom`, `district`, `noOfProperties`, `toAllotted`, `sendOnDate`, `dateToBe`, `moneyReceived`) VALUES ('$bankList', '$fileNo', '$address', '$detailsOf', '$allottedToWhom', '$district', '$noOfProperties', '$toAllotted','$sendOnDate','$dateToBe', '$moneyReceived')";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Successful update or insertion
        
        $id = $bankList = $fileNo = $address = $detailsOf = $allottedToWhom  = $district = $noOfProperties = $toAllotted = $sendOnDate = $dateToBe = $moneyReceived = '';
        ob_clean();
        echo '
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
            Your data has been updated.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        header("refresh:3;url=welcome.php");
        exit;
    } else {
        // Error handling
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error occurred:</strong> ' . $error_message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        $redirectTo = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
</head>
<script>
  $(function() {
    $("#datepicker1, #datepicker2").datepicker(); //datepicker for both inputs
  });
</script>
<body>
    <?php require 'assets/_navbar.php'?>
    <h1 class="text-center my-4">Add Bank Details</h1>
    <div class="container col-md-3 my-4">
        <form action="<?php echo ($editing) ? '/sample/bank.php?id=' . $id : '/sample/bank.php'; ?>" method="post">
        <input type="hidden" name="entry_id" value="<?php echo $id; ?>">    
        <label class="fw-bold" for="bankList" name="bankList">Bank Name</label>
            <div class="mb-3">
                <label class="visually-hidden" for="autoSizingSelect">Preference</label>
                <select class="form-control" id="autoSizingSelect" name="bankList">
                    <option selected>Choose...</option>
                    <option value="Punjab National Bank" <?php if ($bankList === 'punjabNationalBank') echo 'selected'; ?>>Punjab National Bank</option>
                    <option value="SBI" <?php if ($bankList === 'sbi') echo 'selected'; ?>>SBI</option>
                    <option value="3" <?php if ($bankList === '3') echo 'selected'; ?>>Three</option>
                </select>
            </div>
            <div class="mb-3 fw-bold">
                <label for="fileNo">File Number</label>
                <input type="text" class="form-control" id="fileNo" name="fileNo" placeholder="Enter File number" required value="<?php echo $fileNo; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter the address" required value="<?php echo $address; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="detailsOf">Details of Property Pledged</label>
                <input type="text" class="form-control" id="detailsOf" name="detailsOf" placeholder="Type here" required value="<?php echo $detailsOf; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="allottedToWhom">Allotted to Whom</label>
                <input type="text" class="form-control" id="allottedToWhom" name="allottedToWhom" placeholder="Type here" required value="<?php echo $allottedToWhom; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="district" name="district">District</label>
                <select class="form-control" id="districtSelect" name="district">
                    <option selected>Choose...</option>
                    <option value="Trivandrum"<?php if ($district === 'Trivandrum') echo 'selected'; ?>>Trivandrum</option>
                    <option value="Kollam"<?php if ($district === 'Kollam') echo 'selected'; ?>>Kollam</option>
                    <option value="Pathanamthitta"<?php if ($district === 'Pathanamthitta') echo 'selected'; ?>>Pathanamthitta</option>
                    <option value="Alappuzha"<?php if ($district === 'Alappuzha') echo 'selected'; ?>>Alappuzha</option>
                    <option value="Kottayam"<?php if ($district === 'Kottayam') echo 'selected'; ?>>Kottayam</option>
                    <option value="Idukki"<?php if ($district === 'Idukki') echo 'selected'; ?>>Idukki</option>
                    <option value="Ernakulam"<?php if ($district === 'Ernakulam') echo 'selected'; ?>>Ernakulam</option>
                    <option value="Thrissur"<?php if ($district === 'Thrissur') echo 'selected'; ?>>Thrissur</option>
                    <option value="Palakkad"<?php if ($district === 'Palakkad') echo 'selected'; ?>>Palakkad</option>
                    <option value="Malappuram"<?php if ($district === 'Malappuram') echo 'selected'; ?>>Malappuram</option>
                    <option value="Kozhikode"<?php if ($district === 'Kozhikode') echo 'selected'; ?>>Kozhikode</option>
                    <option value="Wayanad"<?php if ($district === 'Wayanad') echo 'selected'; ?>>Wayanad</option>
                    <option value="Kannur"<?php if ($district === 'Kannur') echo 'selected'; ?>>Kannur</option>
                    <option value="Kasaragod"<?php if ($district === 'Kasaragod') echo 'selected'; ?>>Kasaragod</option>
                </select>
            </div>
            <div class="mb-3 fw-bold">
                <label for="noOfProperties">No Of Properties</label>
                <input type="text" class="form-control" id="noOfProperties" name="noOfProperties" placeholder="Enter here" required value="<?php echo $noOfProperties; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="toAllotted">To Allotted</label>
                <input type="text" class="form-control" id="toAllotted" name="toAllotted" placeholder="Enter here" required value="<?php echo $toAllotted; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="sendOnDate">Send On Date</label>
                <input type="date" class="form-control" id="sendOnDate" name="sendOnDate" placeholder="Select date" required value="<?php echo $sendOnDate ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="dateToBe">Date To Be Completed</label>
                <input type="date" class="form-control" id="dateToBe" name="dateToBe" placeholder="Select date" required value="<?php echo $dateToBe ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="money">Money Received</label>
                <input type="text" class="form-control" id="moneyReceived" name="moneyReceived" placeholder="Enter amount" required value="<?php echo $moneyReceived ?>">
            </div>
            <div class="text-center fw-bold">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>