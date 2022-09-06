<?php

namespace App\Controllers;

use mysqli;

class Model
{
    public static function connectToDB(): mysqli
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $databasename = "js_07_2022";

        $con = new mysqli($hostname, $username, $password, $databasename);

        return $con;
    }
}