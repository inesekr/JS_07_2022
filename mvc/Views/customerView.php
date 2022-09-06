<?php

require_once __DIR__ . "/../header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
</head>

<body>
    <section>
        <h1>Customer</h1>
        <ul>
            <li>ID: <?= $customer->getId() ?></li>
            <li>First Name : <?= $customer->getFirstname() ?></li>
            <li>Last Name : <?= $customer->getLastname() ?></li>
            <li>Email : <?= $customer->getEmail() ?></li>
            <li>Phone : <?= $customer->getPhone() ?></li>
        </ul>
    </section>
</body>

</html>