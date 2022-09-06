<?php

namespace App\Controllers;

require_once __DIR__ . "/../Models/Customer.php";

use App\Models\Customer;

class CustomerController
{
    public function display(int $id)
    {
        $customers = Customer::selectCustomers(null, $id);
        if (count($customers) > 0)
            $customer = $customers[0];
        else
            echo "Customer not found";
        require_once __DIR__ . '/../Views/customerView.php';
    }
    public function insert(array $customer)
    {
        Customer::createCustomer(new Customer(
            $customer["firstname"],
            $customer["lastname"],
            $customer["email"],
            $customer["phone"]
        ));
    }
}