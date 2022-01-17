<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/20/2018
 * Time: 2:03 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$employeeObj = NULL;
$employeeString= file_get_contents('php://input');
$employeeObj = json_decode($employeeString, true);

$id = test_input($employeeObj['id']);
$paycom_id = test_input($employeeObj['paycom_id']);

$result = $database->insert('sp_hr_PaycomUpdate("' . $id . '","' . $paycom_id . '");');

echo $result;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}