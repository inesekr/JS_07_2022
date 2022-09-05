<?php
include("book.php");
$booksInput = json_decode(file_get_contents('php://input'));

$books = [];

foreach ($booksInput as $bookInput) :

    // echo json_encode($book); 
    $bookInput->id = 0;
    $bookObj = Book::convertFromJSONToBook($bookInput);
    array_push($books, $bookObj);
endforeach;
Book::createBooks($books);
echo json_encode("The books are succesfully  created (added to DB?)");