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

function createUser(string $uname, string $password, string $role, mysqli $con)
{
    $prepStatement = $con->prepare("INSERT INTO users (username, `password`, `role`) VALUES
     (?,?,?)");
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $prepStatement->bind_param("sss", $uname, $passwordHash, $role);
    $prepStatement->execute();
}

function userExists(string $uname, mysqli $con): bool
{
    $prepStatement = $con->prepare("SELECT COUNT(1) as 'count' FROM users WHERE username = ? ");
    $prepStatement->bind_param("s", $uname);
    $prepStatement->execute();
    $result = $prepStatement->get_result();
    // echo var_dump($result->fetch_assoc());  for testing
    $count = intval($result->fetch_assoc()["count"]);
    if ($count === 1)
        return true;
    else
        return false;
}

$newUser = json_decode(file_get_contents('php://input'));

$con = connectToDB();

if (userExists($newUser->username, $con)) {
    $response = (object) array("userCreated" => false, "username" => $newUser->username, "error" => "Username is already taken");
} else {
    createUser($newUser->username, $newUser->password, $newUser->role, $con);

    $response = (object) array("userCreated" => true, "username" => $newUser->username, "error" => "");
}

echo json_encode($response);