<?php

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

    return $con;
}

function getUserGroups(mysqli $con): array
{
    $prepStatement = $con->prepare("SELECT * FROM usergroups");
    $prepStatement->execute();
    $result = $prepStatement->get_result();
    // echo var_dump($result->fetch_assoc());  for testing
    $usergroupsArr = [];
    while ($entry = $result->fetch_assoc()) {
        $userGroupEntry = (object) array("id" => $entry["id"], "text" => $entry["name"]);
        array_push($usergroupsArr, $userGroupEntry);
    }
    return $usergroupsArr;
}