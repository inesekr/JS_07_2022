<?php

include("book.php");

$books = Book::convertBooksToTextArray(Book::selectBooks());
echo json_encode($books);
