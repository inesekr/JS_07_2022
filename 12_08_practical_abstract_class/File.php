<?php

include("utils.php");


$err = "";
$con = Utilities::connectToDB($err);
$books;
if ($err === "")
    $books = book::selectBooks($con);
else
    echo $err;



abstract class File
{
    abstract public function getDataFromDB();

    abstract public function migrateDataToDB();
}