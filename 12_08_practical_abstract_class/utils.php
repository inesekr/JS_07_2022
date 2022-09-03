<?php

class Utilities
{
    public static function connectToDb(string &$err): mysqli
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
}