<?php

require("Controllers/CustomerController.php");

use App\Controllers\CustomerController;

if (count($_POST) > 0) :

    $customerController = new CustomerController();
    $customerController->insert($_POST);
    require("Views/successInsertion.php");
else :
    require("Views/customerInsertView.php");
endif;