<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/30/2018
 * Time: 11:06 AM
 */

include('../../Includes/Security/database.php');

$database = new Database();

$inventoryObj = NULL;
$inventoryString = file_get_contents('php://input');
$inventoryObj = json_decode($inventoryString, true);

$type = test_input($inventoryObj['type']);
$description = test_input($inventoryObj['description']);
$part_number = test_input($inventoryObj['part_number']);
$user_id = test_input($inventoryObj['user_id']);
$make = test_input($inventoryObj['make']);
$purchase_price = test_input($inventoryObj['purchase_price']);

echo $purchase_price;

if ($purchase_price == ""){
    $inventory_read = $database->get('sp_it_InventoryInsert("' . $type . '","' . $make . '","' . $description . '","' . $part_number . '", NULL,"' . $user_id . '");');
} else {
    echo $inventory_read = $database->get('sp_it_InventoryInsert("' . $type . '","' . $make . '","' . $description . '","' . $part_number . '","' . $purchase_price . '","' . $user_id . '");');
}

$inventory_read_decode = json_decode($inventory_read);

echo $inventory_read_decode;

$inventory_id = $inventory_read_decode[0]->id;

echo $inventory_id;

if(isset($inventoryObj['phone_number'])){
    $phone_number = $inventoryObj['phone_number'];
    $inventory_read = $database->insert('sp_it_PhoneNumberInsert("' . $inventory_id . '","' . $phone_number . '","' . $user_id . '");');
    print_r($inventory_read);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}