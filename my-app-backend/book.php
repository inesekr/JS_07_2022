<?php


use Book as GlobalBook;

include("utils.php");

class Book
{
    protected string $title, $author, $pages;
    protected int $id;
    protected mysqli $con;

    public function __construct($title, $author, $pages, $id = 0)
    {
        $this->title = $title;
        $this->author = $author;
        $this->pages = $pages;
        $this->id = $id;
        $this->con = connectToDB();
    }

    public function getBook(): array
    {

        return [
            "id" => $this->id,
            "title" => $this->title,
            "author" => $this->author,
            "pages" => $this->pages
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getPages(): string
    {
        return $this->pages;
    }



    public static function selectBooks(mysqli $con = null, int $id = null): array
    {
        if ($con === null) :
            $con = connectToDB();
        endif;
        if ($id === null || $id === 0)
            $query = "SELECT * FROM books";
        else
            $query = "SELECT * FROM books WHERE id = $id";
        $result = $con->query($query);
        $books = [];
        while ($entry = $result->fetch_assoc()) :
            $book = new Book($entry["title"], $entry["author"], $entry["pages"], $entry["id"]);
            array_push($books, $book);
        endwhile;
        return $books;
    }


    public static function convertBooksToTextArray(array $books): array
    {
        $booksArr = [];
        foreach ($books as $bookObj)
            array_push($booksArr, $bookObj->getBook());
        return $booksArr;
    }

    public static function createBook(Book $book, mysqli $con = null)
    {
        if ($con === null) :
            $con = connectToDB();
        endif;

        $prepStatement = $con->prepare("INSERT INTO books (title, author, pages) VALUES (?,?,?)");
        $prepStatement->bind_param("sss", $book->title, $book->author, $book->pages);
        $prepStatement->execute();
    }

    public static function updateBooks(array $books, mysqli $con = null)
    {
        if ($con === null) :
            $con = connectToDB();
        endif;

        foreach ($books as $book) {
            $book->updateBook($con);
        }
    }

    public function updateBook(mysqli $con = null)
    {
        $prepStatement = $con->prepare("UPDATE books SET title=?,
        author=?,
        pages=? WHERE id=?");
        $prepStatement->bind_param(
            "ssss",
            $this->title,
            $this->author,
            $this->pages,
            $this->id
        );
        $prepStatement->execute();
    }

    public static function createBooks(array $books, mysqli $con = null)
    {
        if ($con === null)
            $con = connectToDB();
        foreach ($books as $book) :
            Book::createBook(
                $book,
                $con
            );
        endforeach;
    }

    // public function updateBooks(array $books, mysqli $con = null)
    // {
    // }

    // public static function updateBook(Book $book, mysqli $con = null)
    // {
    // }

    public static function insertBooksFromJSONFile(string $filename, mysqli $con)
    {
        $filecontent = file_get_contents($filename);
        $booksObj = json_decode($filecontent);
        foreach ($booksObj->books as $book) :
            Book::createBook($con, Book::convertFromJSONToBook($book));
        endforeach;
    }

    public static function convertFromJSONToBook($book): Book
    {
        return new Book($book->title, $book->author, $book->pages, $book->id);
    }

    public function convertToJSON()
    {
        $book = new stdClass();

        $book->title = $this->title;
        $book->author = $this->author;
        $book->pages = $this->pages;
        return $book;
    }

    public static function convertBooksArrToJSON(array $books): array
    {
        $booksJSON = [];
        foreach ($books as $book)
            array_push($booksJSON, $book->convertToJSON());
        return $booksJSON;
    }

    public static function saveBooksToJSON(string $filename, array $books)
    {
        $json = json_encode(array("books" => $books), JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
    }

    public static function generateBooksTableHTML($books): string
    {
        $booksTable =
            "<b>
            <div class='row'>
                <div class='col'>
                    Title
                </div>
                <div class='col'>
                    Author
                </div>
                <div class='col'>
                    Pages
                </div>
            </div>
        </b>";
        foreach ($books as $book) :
            $booksTable .= $book->getBookRow();
        endforeach;
        return $booksTable;
    }

    public function getBookRow()
    {
        return "<div class='row'>
    <div class='col'>" . $this->title .
            "</div>
    <div class='col'>" . $this->author .
            "</div>
    <div class='col'>" . $this->pages .
            "</div>
</div>";
    }

    public static function getBooksFromJSON(string $filename): string
    {
        $filecontent = file_get_contents($filename);
        // $booksObj = json_decode($filecontent);
        return $filecontent;
    }

    public static function getBooksFromXML(string $filename): string
    {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($filename);
        $booksArr = [];

        $books = $xmlDoc->documentElement->getElementsByTagName("book"); //root element
        foreach ($books as $book) :
            $title =  $book->getElementsByTagName("title")->item(0)->nodeValue;
            $author = $book->getElementsByTagName("author")->item(0)->nodeValue;
            $pages = $book->getElementsByTagName("pages")->item(0)->nodeValue;
            // createBook($con, $title, $author, $pages);
            $bookObj = new Book($title, $author, $pages);
            array_push($booksArr, $bookObj);
        endforeach;

        return json_encode(array("books" => Book::convertBooksArrToJSON($booksArr)));
    }

    public static function getBooksFromCSV(string $filename): string
    {
        $booksArr = [];
        // $filename = 'files\\' . $filename;
        $file = fopen($filename, "r");
        if ($file == false) {
            exit();
        }

        // $err = "";
        // $con = connectToDB($err);
        // if ($err !== "")
        //     exit();

        //We skip the header line
        $csvContentLineArr = fgetcsv($file, filesize($filename), ";");

        while ($csvContentLineArr = fgetcsv($file, filesize($filename), ";")) :

            $title = $csvContentLineArr[0];
            $author = $csvContentLineArr[1];
            $pages = $csvContentLineArr[2];
            $bookObj = new Book($title, $author, $pages);
            array_push($booksArr, $bookObj);

        endwhile;
        return json_encode(array("books" => Book::convertBooksArrToJSON($booksArr)));
    }
}