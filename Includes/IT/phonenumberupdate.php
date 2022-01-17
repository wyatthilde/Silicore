<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/9/2018
 * Time: 9:43 AM
 */

include('../../Includes/Security/database.php');

$database = new Database();

$phoneObj = NULL;

$phoneString = file_get_contents('php://input');

$phoneObj = json_decode($phoneString, true);

$id = test_input($phoneObj['id']);

$phone_number = test_input($phoneObj['phone_number']);

$user_id = test_input($phoneObj['user_id']);

$phone_number_update = $database->insert('sp_it_PhoneNumberUpdate("' . $id . '","' . $phone_number . '","' . $user_id . '");');

echo $phone_number_update;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}