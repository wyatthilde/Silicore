<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/8/2018
 * Time: 3:57 PM
 */

include('../../Includes/Security/database.php');

$database = new Database();

$inventoryObj = NULL;
$inventoryString = file_get_contents('php://input');
$inventoryObj = json_decode($inventoryString, true);

$inventory_id = test_input($inventoryObj['inventory_id']);
$phone_number = test_input($inventoryObj['phone_number']);

$inventory_read = $database->insert('sp_it_PhoneNumberInsert("' . $inventory_id . '","' . $phone_number . '","' . $_SESSION['user_id'] . '");');

echo $inventory_read;



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}