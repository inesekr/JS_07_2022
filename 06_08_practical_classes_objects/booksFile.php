<?php
include("utils.php");
include("book.php");
include("header.php");
$err = "";
$con = Utilities::connectToDB($err);
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
            <div class="row">
                <div class="col">
                    Title
                </div>
                <div class="col">
                    Author
                </div>
                <div class="col">
                    Pages
                </div>
            </div>
        </b>
        <?php foreach ($books as $book) :
            echo ($book->getBookRow());
        endforeach; ?>
        <form method="POST">
            <input value=".xml" name="xmlFilePath">
            <button class="btn">Save to XML</button>
        </form>
        <form method="POST">
            <input value=".json" name="jsonFilePath">
            <button class="btn">Save to JSON</button>
        </form>
        <form method="POST">
            <input value=".csv" name="csvFilePath">
            <button class="btn">Save to CSV</button>
        </form>
    </div>
</body>