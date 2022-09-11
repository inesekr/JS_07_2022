<?php

include("utils.php");

$con = connectToDB();

echo json_encode((object)array("usergroups" => getUserGroups($con)));