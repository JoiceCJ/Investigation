<?php
require 'assets/sessionCheck.php';
$error_message = "";
include 'assets/dbconnect.php';

// Fetch entries from the database
$sql = "SELECT * FROM `insurance`";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Insurance Entries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require 'assets/_navbar.php' ?>
    <div class="container my-4">
        <h1 class="text-center mb-4">Insurance Entries</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Case No</th>
                    <th>To Whom Allotted</th>
                    <th>Date Of Allotment</th>
                    <th>Date Of Allotment To</th>
                    <th>Inestigation Completed On</th>
                    <th>Status</th>
                    <th>Money Received</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['companyName'] . "</td>";
                    echo "<td>" . $row['caseNo'] . "</td>";
                    echo "<td>" . $row['toWhomAllotted'] . "</td>";
                    echo "<td>" . $row['dateOfAllotment'] . "</td>";
                    echo "<td>" . $row['dateOfAllotmentTo'] . "</td>";
                    echo "<td>" . $row['invCompletedOn'] . "</td>";
                    echo '<td style="background-color: ' . (($row['status'] == "Finished") ? "#00FF00" : (($row['status'] == "Pending") ? "#FFA500" : "#FF0000")) . '">' . $row['status'] . '</td>';
                    echo "<td>" ."Rs. ". $row['moneyReceived'] . "</td>";
                    echo "<td><a href='insurance.php?id=" . $row['no'] . "'class='btn btn-success'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
