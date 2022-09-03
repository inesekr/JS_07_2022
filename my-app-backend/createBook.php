<?php
include("book.php");
$booksInput = json_decode(file_get_contents('php://input'));
$booksInput->id = 0;
// echo json_encode($book); 
$bookObj = Book::convertFromJSONToBook($booksInput);
Book::createBook($bookObj);
echo json_encode("The book is created succesfully");