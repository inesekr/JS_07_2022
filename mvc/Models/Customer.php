<?php

// use Customer as GlobalCustomer;

namespace App\Models;

require_once("Person.php");

use App\Controllers\Model;
use DOMDocument;
use mysqli;
use stdClass;



class Customer extends Person
{
    protected string $phone, $email;
    protected int $id;
    protected mysqli $con;

    public function __construct($firstname, $lastname, $phone, $email, $id = 0)
    {
        parent::__construct($firstname, $lastname);
        $this->phone = $phone;
        $this->email = $email;
        $this->id = $id;
        $this->con = Model::connectToDB();
    }

    public function getCustomer(): array
    {
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "phone" => $this->phone,
            "email" => $this->email
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function selectCustomers(mysqli $con = null, int $id = null): array
    {
        if ($con === null) :
            $con = Model::connectToDB();
        endif;

        if ($id === null || $id === 0)
            $query = "SELECT * FROM customer";
        else
            $query = "SELECT * FROM customer WHERE id = $id";

        $result = $con->query($query);
        $customers = [];

        while ($entry = $result->fetch_assoc()) :
            $customer = new Customer(
                $entry["firstname"],
                $entry["lastname"],
                $entry["phone"],
                $entry["email"],
                $entry["id"]
            );
            array_push($customers, $customer);
        endwhile;

        return $customers;
    }

    public static function convertCustomersToTextArray(array $customers): array
    {
        $customersArray = [];
        foreach ($customers as $customerObj)
            array_push($customersArray, $customerObj->getCustomer());
        return $customersArray;
    }

    public static function createCustomer(Customer $customer, mysqli $con = null)
    {
        if ($con === null) :
            $con = Model::connectToDB();
        endif;

        $prepStament = $con->prepare("INSERT INTO customer (firstname,lastname,email,phone) VALUES
        (?,?,?,?)");
        $prepStament->bind_param(
            "ssss",
            $customer->firstname,
            $customer->lastname,
            $customer->email,
            $customer->phone
        );
        $prepStament->execute();
    }

    public static function updateCustomers(array $customers, mysqli $con = null)
    {
        if ($con === null) :
            $con = Model::connectToDB();
        endif;

        foreach ($customers as $customer) {
            $customer->updateCustomer($con);
        }
    }

    public function updateCustomer(mysqli $con = null)
    {
        $prepStament = $con->prepare("UPDATE customer SET firstname=?,
        lastname=?,email=?, 
        phone=? WHERE id=?");
        $prepStament->bind_param(
            "sssss",
            $this->firstname,
            $this->lastname,
            $this->email,
            $this->phone,
            $this->id
        );
        $prepStament->execute();
    }

    public static function createCustomers(array $customers, mysqli $con = null)
    {
        if ($con === null)
            $con = Model::connectToDB();
        foreach ($customers as $customer) :
            Customer::createCustomer(
                $customer,
                $con
            );
        endforeach;
    }

    public static function insertFromJSONFile(string $filename, mysqli $con)
    {
        $filecontent = file_get_contents($filename);
        $customersObj = json_decode($filecontent);
        foreach ($customersObj->customers as $customer) :
            Customer::createCustomer(

                Customer::convertFromJSONToCustomer($customer),
                $con
            );
        endforeach;
    }

    public static function convertFromJSONToCustomer($customer): Customer
    {
        return new Customer(
            $customer->firstname,
            $customer->lastname,
            $customer->phone,
            $customer->email,
            $customer->id
        );
    }

    public function convertToJSON()
    {
        $customer = new stdClass();
        $customer->firstname = $this->firstname;
        $customer->lastname = $this->lastname;
        $customer->phone = $this->phone;
        $customer->email = $this->email;
        return $customer;
    }

    public static function convertCustomerArrToJSON(array $customers): array
    {
        $customersJSON = [];
        foreach ($customers as $customer)
            array_push($customersJSON, $customer->convertToJSON());

        return $customersJSON;
    }

    public static function saveCustomersJSON(string $filename, array $customers)
    {
        $json = json_encode(array("customers" => $customers), JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
    }


    public static function getCustomersFromJSON(string $filename): string
    {
        $filecontent = file_get_contents($filename);
        return $filecontent;
    }

    public static function getCustomersFromXML(string $filename): string
    {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($filename);

        $customersArr = [];
        $customers = $xmlDoc->documentElement->getElementsByTagName("customer"); //root element
        foreach ($customers as $customer) :
            $firstname =  $customer->getElementsByTagName("firstname")->item(0)->nodeValue;
            $lastname = $customer->getElementsByTagName("lastname")->item(0)->nodeValue;
            $phone = $customer->getElementsByTagName("phone")->item(0)->nodeValue;
            $email = $customer->getElementsByTagName("email")->item(0)->nodeValue;
            $customerObj = new Customer($firstname, $lastname, $phone, $email);
            array_push($customersArr, $customerObj);
        endforeach;
        return json_encode(array("customers"
        => Customer::convertCustomerArrToJSON($customersArr)));
    }

    public static function getCustomersFromCSV(string $filename): string
    {
        $customersArr = [];
        $file = fopen($filename, "r");
        if ($file == false) {
            exit();
        }

        //We skip the heder line
        $csvContentLineArr = fgetcsv($file, filesize($filename), ";");

        while ($csvContentLineArr = fgetcsv($file, filesize($filename), ";")) :
            $firstname = $csvContentLineArr[0];
            $lastname = $csvContentLineArr[1];
            $email = $csvContentLineArr[2];
            $phone = $csvContentLineArr[3];
            $customerObj = new Customer($firstname, $lastname, $phone, $email);
            array_push($customersArr, $customerObj);
        endwhile;
        return json_encode(array("customers"
        => Customer::convertCustomerArrToJSON($customersArr)));
    }
}