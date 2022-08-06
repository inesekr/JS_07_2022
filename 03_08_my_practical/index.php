<?php
include("functions.php");
$err = "";
$con = connectToDB($err);

if ($err === "")
    $records = selectRecords($con);
else echo $err;

if (isset($_POST["insertFromCSVFileName"]))
    insertRecordsFromCSVFile($_POST["insertFromCSVFileName"], $con);

if (isset($_POST["insertFromJSONFileName"]))
    insertRecordsFromJSONFile($_POST["insertFromJSONFileName"], $con);

if (isset($_POST["insertFromXMLFileName"]))
    insertRecordsFromXMLFile($_POST["insertFromXMLFileName"], $con);



if (isset($_POST["xmlFilePath"]))
    saveRecordsToXMLFile($_POST["xmlFilePath"], $records);

if ($err === "")
    $records = selectRecords($con);
else
    echo $err;


if (isset($_POST["csvFilePath"]))
    saveRecordsToCSVFile($_POST["csvFilePath"], $con);

$records = selectRecords($con);

if (isset($_POST["jsonFilePath"]))
    saveRecordsToJSONFile($_POST["jsonFilePath"], $records);

$records = selectRecords($con);

?>

<head>
    <?php include("header.php") ?>
</head>

<body>
    <h2>Get data from SQL database to CSV, JSON and XML files.
        And push data FROM CSV, JSON or XML files to SQL database.</h2>


    <div class="container">

        <form action="" method="POST">
            <input type="file" name="insertFromCSVFileName">
            <button class="btn btn-primary">Migrate data from CSV file</button>
        </form>

        <form method="POST">
            <input value=".csv" name="csvFilePath">
            <button class="btn btn-primary">Save to CSV</button>
        </form>


        <form action="" method="POST">
            <input type="file" name="insertFromJSONFileName">
            <button class="btn btn-primary">Migrate data from JSON file</button>
        </form>

        <form method="POST">
            <input value=".json" name="jsonFilePath">
            <button class="btn btn-primary">Save to JSON</button>
        </form>

        <form method="POST">
            <input type="file" name="insertFromXMLFileName">
            <button class="btn btn-primary">Migrate data from XML file</button>
        </form>

        <form method="POST">
            <input value=".xml" name="xmlFilePath">
            <button class="btn btn-primary">Save to XML</button>
        </form>


    </div>
</body>