<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/18/2018
 * Time: 10:39 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();
$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);

$id = test_input($obj['id']);

$read = $database->get('sp_it_NonReturnedAssignedAssetsByEmployeeIdGet("'.$id.'");');

echo $read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}