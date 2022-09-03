<?php

include("utils.php");
include("File.php");

$err = "";
$con = Utilities::connectToDb($err);
$books;
if ($err === "")
    $books = book::selectBooks($con);
else
    echo $err;

if (isset($_POST["insertFromJSFileName"]))
    book::insertBooksFromJSONFile($_POST["insertFromJSFileName"], $con);

if (isset($_POST["insertFromCSVFileName"]))
    book::insertBooksFromCSVFile($_POST["insertFromCSVFileName"], $con);


if (isset($_POST["jsonFilePath"]))
    book::saveBooksToJSON($_POST["jsonFilePath"], book::convertBooksArrToJSON($books));

if (isset($_POST["csvFilePath"]))
    book::saveBooksToCSVFile(
        $_POST["csvFilePath"],
        book::convertBooksArrToCSV($books)
    );

?>

<head>
    <?php include("header.php"); ?>
</head>

<body>
    <div class="container">

    </div>
</body>