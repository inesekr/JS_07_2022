<?php

class Book
{
    private string $title, $author, $pages;



    public function getBook(): array
    {

        return [
            "title" => $this->title,
            "author" => $this->author,
            "pages" => $this->pages
        ];
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

    public function __construct($title, $author, $pages)
    {
        $this->title = $title;
        $this->author = $author;
        $this->pages = $pages;
    }

    public static function selectBooks(mysqli $con, int $id = null): array
    {
        if ($id === null || $id === 0)
            $query = "SELECT * FROM books";
        else
            $query = "SELECT * FROM books WHERE id = $id";
        $result = $con->query($query);
        $books = [];
        while ($entry = $result->fetch_assoc()) :
            $book = new Book($entry["title"], $entry["author"], $entry["pages"]);
            array_push($books, $book);
        endwhile;
        return $books;
    }

    public static function convertBooksToTextArray(array $books): array
    {
        $booksArr = [];
        foreach ($books as $bookObj)
            array_push($booksArr, $bookObj->getBooks());
        return $booksArr;
    }

    public function createBook(mysqli $con)
    {
        $prepStatement = $con->prepare("INSERT INTO books (title, author, pages) VALUES (?,?,?)");
        $prepStatement->bind_param("sss", $this->title, $this->author, $this->pages);
        $prepStatement->execute();
    }


    public static function insertBooksFromJSONFile(string $filename, mysqli $con)
    {
        $filecontent = file_get_contents($filename);
        $booksArr = json_decode($filecontent);
        foreach ($booksArr->books as $book) :
            Book::createBook($con, Book::convertFromJSONToBook($book));
        endforeach;
    }

    public static function convertFromJSONToBook($book): Book
    {
        return new Book($book->title, $book->author, $book->pages);
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
}