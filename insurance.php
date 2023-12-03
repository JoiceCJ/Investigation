<?php
require 'assets/sessionCheck.php';
$error_message = "";
include 'assets/dbconnect.php';

//initializing
if (!isset($id)) {
    $id = '';
}
$id = $companyName = $caseNo = $toWhomAllotted = $dateOfAllotment = $dateOfAllotmentTo = $invCompletedOn = $returnAfterInv = $status = $moneyReceived = '';
$editing = false;

//for fetching the existing form data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $entryId = $id;
    $sql = "SELECT * FROM `insurance` WHERE `no` = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    //assigning fetched data
    if ($row) {
        $editing = true;
        //assigning data
        $companyName = $row['companyName'];
        $caseNo = $row['caseNo'];
        $toWhomAllotted = $row['toWhomAllotted'];
        $dateOfAllotment = $row['dateOfAllotment'];
        $dateOfAllotmentTo = $row['dateOfAllotmentTo'];
        $invCompletedOn = $row['invCompletedOn']; 
        $returnAfterInv = $row['returnAfterInv'];
        $status = $row["status"];
        $moneyReceived = $row['moneyReceived'];

        echo '
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">You are editing existing data.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> No data found for the provided ID.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyName = mysqli_real_escape_string($conn, $_POST["companyName"]);
    $caseNo = mysqli_real_escape_string($conn, $_POST["caseNo"]);
    $toWhomAllotted = mysqli_real_escape_string($conn, $_POST["toWhomAllotted"]);
    $dateOfAllotment = mysqli_real_escape_string($conn, $_POST["dateOfAllotment"]);
    $dateOfAllotmentTo = mysqli_real_escape_string($conn, $_POST["dateOfAllotmentTo"]);
    $invCompletedOn = mysqli_real_escape_string($conn, $_POST["invCompletedOn"]);
    $returnAfterInv = mysqli_real_escape_string($conn, $_POST["returnAfterInv"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);
    $moneyReceived = mysqli_real_escape_string($conn, $_POST["moneyReceived"]);

    if ($editing) {
        $sql = "UPDATE `insurance` SET `companyName` = '$companyName', `caseNo` = '$caseNo', `toWhomAllotted` = '$toWhomAllotted', `dateOfAllotment` = '$dateOfAllotment', `dateOfAllotmentTo` = '$dateOfAllotmentTo', `invCompletedOn` = '$invCompletedOn', `returnAfterInv` = '$returnAfterInv', `status` = '$status', `moneyReceived` = '$moneyReceived' WHERE `no` = '$id'";
    } else {
        $sql = "INSERT INTO `insurance` (`companyName`, `caseNo`, `toWhomAllotted`, `dateOfAllotment`,`dateOfAllotmentTo`, `invCompletedOn`, `returnAfterInv`, `status`, `moneyReceived`) VALUES ('$companyName', '$caseNo', '$toWhomAllotted', '$dateOfAllotment', '$dateOfAllotmentTo', '$invCompletedOn', '$returnAfterInv', '$status', '$moneyReceived')";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Successful update or insertion
        
        $id = $companyName = $caseNo = $toWhomAllotted = $dateOfAllotment = $dateOfAllotmentTo  = $invCompletedOn = $returnAfterInv = $status = $moneyReceived = '';
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
    <title>Insurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require 'assets/_navbar.php' ?>
    <h1 class="text-center my-4">Add Insurance Details</h1>
    <div class="container col-md-3 my-4">
    <form action="<?php echo ($editing) ? '/sample/insurance.php?id=' . $id : '/sample/insurance.php'; ?>" method="post">
            <input type="hidden" name="entry_id" value="<?php echo $id; ?>">
            <label class="fw-bold" for="companyName" name="companyName">Company Name</label>
            <div class="mb-3">
                <label class="visually-hidden" for="autoSizingSelect">Preference</label>
                <select class="form-control" id="autoSizingSelect" name="companyName">
                    <option selected>Choose...</option>
                    <option value="Reliance" <?php if ($companyName === 'Reliance') echo 'selected'; ?>>Reliance</option>
                    <option value="2" <?php if ($companyName === '2') echo 'selected'; ?>>Two</option>
                    <option value="3" <?php if ($companyName === '3') echo 'selected'; ?>>Three</option>
                </select>
            </div>
            <div class="mb-3 fw-bold">
                <label for="caseNo">Case Number</label>
                <input type="text" class="form-control" id="caseNo" name="caseNo" placeholder="Enter Case number" required value="<?php echo $caseNo; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="toWhomAllotted">To Whom Allotted to</label>
                <input type="text" class="form-control" id="toWhomAllotted" name="toWhomAllotted" placeholder="Enter the company name" required value="<?php echo $toWhomAllotted; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="dateOfAllotment">Date of Allotment</label>
                <input type="date" class="form-control" id="dateOfAllotment" name="dateOfAllotment" placeholder="Select date" required value="<?php echo $dateOfAllotment; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="dateOfAllotmentTo">Date of Allotment to</label>
                <input type="date" class="form-control" id="dateOfAllotmentTo" name="dateOfAllotmentTo" placeholder="Select date" required value="<?php echo $dateOfAllotmentTo; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="invCompletedOn">Investigation Completed On</label>
                <input type="date" class="form-control " id="invCompletedOn" name="invCompletedOn" placeholder="Select date" required value="<?php echo $invCompletedOn; ?>">
            </div>
            <div class="mb-3 fw-bold">
                <label for="returnAfterInv">Return After Investigation</label>
                <input type="date" class="form-control" id="returnAfterInv" name="returnAfterInv" placeholder="Select date" required value="<?php echo $returnAfterInv; ?>">
            </div>
            <label class="fw-bold" for="status" name="status">Status</label>
            <div class="mb-3">
                <label class="visually-hidden" for="autoSizingSelect">Preference</label>
                <select class="form-control" id="autoSizingSelect" name="status">
                    <option selected>Choose...</option>
                    <option value="Pending" <?php if ($status === 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Finished" <?php if ($status === 'Finished') echo 'selected'; ?>>Finished</option>
                </select>
            </div>
            <div class="mb-3 fw-bold">
                <label for="moneyReceived">Money Received</label>
                <input type="text" class="form-control" id="moneyReceived" name="moneyReceived" placeholder="Enter amount" required value="<?php echo $moneyReceived; ?>">
            </div>
            <div class="text-center fw-bold">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
    <?php
    // Display error message if there's an issue with the database query
    if (!empty($error_message)) {
        echo "<p>Error: $error_message</p>";
    }
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>