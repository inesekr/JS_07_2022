<?php

function getBooksFromXML(string $filename): string
{
    $content = "";
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($filename);

    $books = $xmlDoc->documentElement->getElementsByTagName("book"); //root element
    foreach ($books as $book) :
        $content .= "<div class='row'>";
        $title =  $book->getElementsByTagName("title")->item(0)->nodeValue;
        $author = $book->getElementsByTagName("author")->item(0)->nodeValue;
        $pages = $book->getElementsByTagName("pages")->item(0)->nodeValue;
        $content .= "<div class='col'>" . $title .  "</div>";
        $content .= "<div class='col'>" . $author .  "</div>";
        $content .= "<div class='col'>" . $pages .  "</div>";
        $content .= "</div>";
    endforeach;
    return $content;
}

// function insertBooksFromXMLFile(string $filename)
// {
//     $err = "";
//     $con = connectToDB($err);
//     if ($err !== "")
//         exit();
//     $xmlDoc = new DOMDocument();
//     $xmlDoc->load($filename);

//     $books = $xmlDoc->documentElement->getElementsByTagName("book"); //root element
//     foreach ($books as $book) :
//         $title =  $book->getElementsByTagName("title")->item(0)->nodeValue;
//         $author = $book->getElementsByTagName("author")->item(0)->nodeValue;
//         $pages = $book->getElementsByTagName("pages")->item(0)->nodeValue;
//         createBook($con, $title, $author, $pages);
//     endforeach;
// }

function connectToDB(string &$err = null)
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databasename = "js_07_2022";

    $con = new mysqli($hostname, $username, $password, $databasename);
    if ($con->connect_error) {
        $err = $con->connect_error;
    }
    // $err = "We have the error";

    return $con;
}

// function insertBooksFromCSVFile(string $filename)
// {
//     $file = fopen($filename, "r");
//     if ($file == false) {
//         exit();
//     }

//     $err = "";
//     $con = connectToDB($err);
//     if ($err !== "")
//         exit();

//     //We skip the header line
//     $csvContentLineArr = fgetcsv($file, filesize($filename), ";");

//     while ($csvContentLineArr = fgetcsv($file, filesize($filename), ";")) :

//         $title = $csvContentLineArr[0];
//         $author = $csvContentLineArr[1];
//         $pages = $csvContentLineArr[2];

//         createBook($con, $title, $author, $pages);
//     endwhile;
// }

function saveBooksToJSONFile(string $filename, mysqli_result $books)
{
    $booksArr = array();
    while ($entry = $books->fetch_assoc()) :
        $bookArr = array(
            "title" => $entry["title"],
            "author" => $entry["author"],
            "pages" => $entry["pages"]
        );
        array_push($booksArr, $bookArr); //push $recordArr to $recordsArr
    endwhile;
    // mb_convert_encoding($filename, 'HTML-ENTITIES', "UTF-8");
    $json = json_encode(array("books" => $booksArr), JSON_PRETTY_PRINT);
    // $json = json_encode(array("records" => $recordsArr), JSON_PRETTY_PRINT);

    file_put_contents($filename, $json);
}

function saveBooksToXMLFile(string $filename, mysqli_result $books)
{
    $xmlDoc = new DOMDocument();
    $xmlDoc->encoding = "UTF-8";
    $xmlDoc->formatOutput = true;
    $booksElement = $xmlDoc->createElement("books");
    while ($entry = $books->fetch_assoc()) :
        $bookElement = $xmlDoc->createElement("book");

        $titleElement = $xmlDoc->createElement("title", $entry["title"]);
        $bookElement->appendChild($titleElement);

        $authorElement = $xmlDoc->createElement("author", $entry["author"]);
        $bookElement->appendChild($authorElement);

        $pagesElement = $xmlDoc->createElement("pages", $entry["pages"]);
        $bookElement->appendChild($pagesElement);

        $booksElement->appendChild($bookElement);
    endwhile;
    $xmlDoc->appendChild($booksElement);
    $xmlDoc->save($filename);
}

// function saveBooksToCSVFile(string $filename, mysqli $con)
// {
//     $filecontent = "";
//     $headerline = "Title;Author;Pages";
//     $filecontent = $headerline;
//     $records = selectBooks($con);
//     while ($entry = $books->fetch_assoc()) :
//         $filecontent .= "\n"; ///Line break 
//         $title = $entry["title"];
//         $author = $entry["author"];
//         $pages = $entry["pages"];
//         $line = $title . ";" . $author . ";" . $pages;
//         $filecontent .= $line;
//     endwhile;

//     $file = fopen($filename, "w");
//     fwrite($file, $filecontent);
//     fclose($file);
// }

// function insertBooksFromJSONFile(string $filename, mysqli $con)
// {
//     $filecontent = file_get_contents($filename);
//     $booksObj = json_decode($filecontent);
//     foreach ($booksObj->books as $book) :
//         createBook($con, $book->title, $book->author, $book->pages);
//     endforeach;
// }






// function updateBook(
//     mysqli $con,
//     int $id,
//     string $title,
//     string $author,
//     string $pages
// ) {
//     $query = "UPDATE books SET title='$title', author='$author', pages = '$pages' WHERE id=$id";
//     $con->query($query);
// }


// function createBook(
//     mysqli $con,
//     string $title,
//     string $author,
//     string $pages
// ) {
//     $prepStament = $con->prepare("INSERT INTO books (title,author,pages) VALUES
//     (?,?,?)");
//     $prepStament->bind_param("sss", $title, $author, $pages);
//     $prepStament->execute();
// }


// function selectBooks(mysqli $con, int $id = null): mysqli_result
// {
//     if ($id === null || $id === 0)
//         $query = "SELECT * FROM books";
//     else
//         $query = "SELECT * FROM books WHERE id = $id";
//     return $con->query($query);
// }