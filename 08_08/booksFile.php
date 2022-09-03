<?php
include("utils.php");
include("book.php");
include("booksTab.php");
$err = "";
$con = Utilities::connectToDb($err);
$books;
if ($err === "")
    $books = book::selectBooks($con);
else
    echo $err;

if (isset($_POST["insertFromJSFileName"]))
    book::insertBooksFromJSONFile($_POST["insertFromJSFileName"], $con);

// if (isset($_POST["insertFromXMLFileName"]))
//     insertCustomersFromFile($_POST["insertFromXMLFileName"], $con);

// if (isset($_POST["insertFromCSVFileName"]))
//     insertCustomersFromFile($_POST["insertFromCSVFileName"], $con);

// if (isset($_POST["xmlFilePath"]))
//     saveCustomersToXML($_POST["xmlFilePath"], $customers);

// if ($err === "")
//     $customers = selectCustomers($con);
// else
//     echo $err;

if (isset($_POST["jsonFilePath"]))
    book::saveBooksToJSON($_POST["jsonFilePath"], book::convertBooksArrToJSON($books));

// if (isset($_POST["csvFilePath"]))
//     saveCustomersToCSVFile($_POST["csvFilePath"]);


// $customers = selectCustomers($con);

$booksTable = new booksTab();
$booksTable->addHeader(["Title", "Author", "Pages"]);
$booksTable->generateElements(
    Book::convertBooksToTextArray($books)
);
$booksTable = $booksTable->finishTable();
?>


<head>
    <?php include("header.php") ?>
</head>

<body>
    <div class="container">
        <form method="POST">
            <input type="file" name="insertFromJSFileName">
            <button class="btn btn-primary">Insert from JSON file</button>
        </form>
        <form method="POST">
            <input type="file" name="insertFromXMLFileName">
            <button class="btn btn-primary">Insert from XML file</button>
        </form>
        <form method="POST">
            <input type="file" name="insertFromCSVFileName">
            <button class="btn btn-primary">Insert from CSV file</button>
        </form>
        <b>
            <?= $booksTable ?>

        </b>

        <form method="POST">
            <input value=".xml" name="xmlFilePath">
            <button class="btn btn-primary">Save to XML</button>
        </form>
        <form method="POST">
            <input value=".json" name="jsonFilePath">
            <button class="btn btn-primary">Save to JSON</button>
        </form>
        <form method="POST">
            <input value=".csv" name="csvFilePath">
            <button class="btn btn-primary">Save to CSV</button>
        </form>
    </div>
</body>