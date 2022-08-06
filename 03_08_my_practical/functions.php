<?php
function connectToDB(string &$err)
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

function createRecord(
    mysqli $con,
    string $title,
    string $author,
    string $pages
) {
    $prepStament = $con->prepare("INSERT INTO books (title,author,pages) VALUES
    (?,?,?)");
    $prepStament->bind_param("sss", $title, $author, $pages);
    $prepStament->execute();
}


function insertRecordsFromCSVFile(string $filename)
{
    $file = fopen($filename, "r");
    if ($file == false) {
        exit();
    }

    $err = "";
    $con = connectToDB($err);
    if ($err !== "")
        exit();

    //We skip the header line
    $csvContentLineArr = fgetcsv($file, filesize($filename), ";");

    while ($csvContentLineArr = fgetcsv($file, filesize($filename), ";")) :

        $title = $csvContentLineArr[0];
        $author = $csvContentLineArr[1];
        $pages = $csvContentLineArr[2];

        createRecord($con, $title, $author, $pages);
    endwhile;
}

function selectRecords(mysqli $con, int $id = null): mysqli_result
{
    if ($id === null || $id === 0)
        $query = "SELECT * FROM books";
    else
        $query = "SELECT * FROM books WHERE id = $id";
    return $con->query($query);
}


function saveRecordsToCSVFile(string $filename, mysqli $con)
{
    $filecontent = "";
    $headerline = "Title;Author;Pages";
    $filecontent = $headerline;
    $records = selectRecords($con);
    while ($entry = $records->fetch_assoc()) :
        $filecontent .= "\n"; ///Line break 
        $title = $entry["title"];
        $author = $entry["author"];
        $pages = $entry["pages"];
        $line = $title . ";" . $author . ";" . $pages;
        $filecontent .= $line;
    endwhile;

    $file = fopen($filename, "w");
    fwrite($file, $filecontent);
    fclose($file);
}



function saveRecordsToJSONFile(string $filename, mysqli_result $records)
{
    $recordsArr = array();
    while ($entry = $records->fetch_assoc()) :
        $recordArr = array(
            "title" => $entry["title"],
            "author" => $entry["author"],
            "pages" => $entry["pages"]
        );
        array_push($recordsArr, $recordArr); //push $recordArr to $recordsArr
    endwhile;
    $json = json_encode(array("records" => $recordsArr), JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

function insertRecordsFromJSONFile(string $filename, mysqli $con)
{
    $filecontent = file_get_contents($filename);
    $recordsArr = json_decode($filecontent);
    foreach ($recordsArr->records as $record) :
        createRecord($con, $record->title, $record->author, $record->pages);
    endforeach;
}

function insertRecordsFromXMLFile(string $filename)
{
    $err = "";
    $con = connectToDB($err);
    if ($err !== "")
        exit();
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($filename);

    $records = $xmlDoc->documentElement->getElementsByTagName("record"); //root element
    foreach ($records as $record) :
        $title =  $record->getElementsByTagName("title")->item(0)->nodeValue;
        $author = $record->getElementsByTagName("author")->item(0)->nodeValue;
        $pages = $record->getElementsByTagName("pages")->item(0)->nodeValue;
        createRecord($con, $title, $author, $pages);
    endforeach;
}

function saveRecordsToXMLFile(string $filename, mysqli_result $records)
{
    $xmlDoc = new DOMDocument();
    $xmlDoc->encoding = "UTF-8";
    $xmlDoc->formatOutput = true;
    $recordsElement = $xmlDoc->createElement("records");
    while ($entry = $records->fetch_assoc()) :
        $recordElement = $xmlDoc->createElement("record");

        $titleElement = $xmlDoc->createElement("title", $entry["title"]);
        $recordElement->appendChild($titleElement);

        $authorElement = $xmlDoc->createElement("author", $entry["author"]);
        $recordElement->appendChild($authorElement);

        $pagesElement = $xmlDoc->createElement("pages", $entry["pages"]);
        $recordElement->appendChild($pagesElement);

        $recordsElement->appendChild($recordElement);
    endwhile;
    $xmlDoc->appendChild($recordsElement);
    $xmlDoc->save($filename);
}