<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/19/2018
 * Time: 9:09 AM
 */

include_once('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;

$string= file_get_contents('php://input');

$obj = json_decode($string, true);

$id = test_input($obj['id']);

$read = $database->get('sp_hr_ReturnedAssetsByEmployeeIdGet("' . $id . '")');

echo $read;


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

