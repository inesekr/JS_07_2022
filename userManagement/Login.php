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

function checkExist($uname, $password, string &$role): bool
{
    $con = connectToDB();
    $prepStatement = $con->prepare("SELECT `password`, `role` FROM users WHERE username = ? ");
    $prepStatement->bind_param("s", $uname);
    $prepStatement->execute();
    $result = $prepStatement->get_result();
    if (mysqli_num_rows($result) == 0) {
        return false;
    }
    $resultValues = $result->fetch_assoc();
    $passwordDB = $resultValues["password"];
    if (password_verify($password, $passwordDB)) {
        $role = $resultValues["role"];
        return true;
    } else
        return false;
}

$newUser = json_decode(file_get_contents('php://input'));

$role = "";
$userExist = checkExist($newUser->username, $newUser->password, $role);

$response = (object) array("userexist" => $userExist, "role" => $role);

echo json_encode($response);