<?php
require 'assets/sessionCheck.php';
$error_message = "";
include 'assets/dbconnect.php';

// Fetch entries from the database
$sql = "SELECT * FROM `bank`";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bank Entries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require 'assets/_navbar.php' ?>
    <div class="container my-4">
        <h1 class="text-center mb-4">Bank Entries</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Bank List</th>
                    <th>File No</th>
                    <th>Address</th>
                    <th>Details Of</th>
                    <th>Allotted To Whom</th>
                    <th>District</th>
                    <th>No Of Properties</th>
                    <th>To Allotted</th>
                    <th>Send On Date</th>
                    <th>Date To Be Completed</th>
                    <th>Days Remaining</th>
                    <th>MoneyReceived</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['bankList'] . "</td>";
                    echo "<td>" . $row['fileNo'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['detailsOf'] . "</td>";
                    echo "<td>" . $row['allottedToWhom'] . "</td>";
                    echo "<td>" . $row['district'] . "</td>";
                    echo "<td>" . $row['noOfProperties'] . "</td>";
                    echo "<td>" . $row['toAllotted'] . "</td>";
                    echo "<td>" . $row['sendOnDate'] . "</td>";
                    echo "<td>" . $row['dateToBe'] . "</td>";
                    echo "<td>" . ((strtotime($row['dateToBe']) - strtotime($row['sendOnDate']))/(60*60*24)) . " days remaining" ."</td>";
                    echo "<td>" ."Rs. ". $row['moneyReceived'] . "</td>";
                    echo "<td><a href='bank.php?id=" . $row['no'] . "'class='btn btn-success'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
