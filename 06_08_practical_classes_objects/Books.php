<?php

include("connection.php");
// class Books
// {
//     private string $title = "";
//     private string $author = "";
//     private string $pages = "";

//     // private Book $book;

//     public function __construct(string $title, string $author, string $pages)
//     {
//         $this->title = $title;
//         $this->author = $author;
//         $this->pages = $pages;
//     }

//     public static function getBooksFromDB(): array
//     {
//         $books = [];

$query = "SELECT * FROM books";
$result = $con->query($query);

// $result = mysql_query($query, $con);

// while ($result->fetch_assoc()) {
//     $book = new Book(
//         $title = $result["title"],
//         $author = $result["author"],
//         $pages = $result["pages"],
//     );
//     array_push($books, $book);
// }
// return $books;

while ($row = mysql_fetch_assoc($result)) {
    echo "title : {$row['title']} <br>" .
        "author : {$row['author']} <br>" .
        "pages : {$row['pages']} <br>";
}
echo "Fetched data succesfully\n";
mysql_close($con);
    

    //     public function displayHtml(): string
    //     {
    //         $htmlRow = "";
    //         $htmlRow .= "<tr>
    // <td>" . $this->title . "</td>
    // <td>" . $this->author . "</td>
    // <td>" . $this->pages . "</td>
    //     </tr>";
    //         return $htmlRow;
    //     }

    // $book = new Books;
    // var_dump($book);
    // echo $book->title;