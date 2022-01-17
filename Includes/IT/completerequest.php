<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/31/2018
 * Time: 3:44 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$requestObj = NULL;

$requestString = file_get_contents('php://input');

$requestObj = json_decode($requestString, true);

$id = test_input($requestObj['id']);

$kace = test_input($requestObj['kace']);

$user_id = test_input($requestObj['user_id']);

$inventory_id = test_input($requestObj['inventory_id']);

$employee_id = test_input($requestObj['employee_id']);

$complete_insert = $database->insert('sp_it_CompleteRequest("' . $id . '","' . $inventory_id . '","' . $kace . '","' . $user_id . '","' . $employee_id . '");');

print_r($complete_insert);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}