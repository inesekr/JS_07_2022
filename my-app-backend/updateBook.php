<?php
include("book.php");
$booksInput = json_decode(file_get_contents('php://input'));

$books = [];

foreach ($booksInput as $bookInput) :

    // echo json_encode($book); 
    $bookObj = Book::convertFromJSONToBook($bookInput);
    array_push($books, $bookObj);
endforeach;
Book::updateBooks($books);
echo json_encode("The books are succesfully updated");