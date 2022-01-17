<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/1/2018
 * Time: 10:59 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$requestObj = NULL;

$requestString = file_get_contents('php://input');

$requestObj = json_decode($requestString, true);

$type = test_input($requestObj['type']);

$devices_read = $database->get('sp_it_SerialsByTypeGet("' . $type . '");');

echo $devices_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}