<?php
include("book.php");

$filename = json_decode(file_get_contents('php://input'));
$filename = 'files\\' . $filename;
$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
// echo json_encode($fileExtension);

switch ($fileExtension) {
    case "json":
        echo Book::getBooksFromJSON($filename);
        break;
    case "xml":
        echo Book::getBooksFromXML($filename);
        break;
    case "csv":
        echo Book::getBooksFromCSV($filename);
        break;
}