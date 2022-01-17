<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/5/2018
 * Time: 1:58 PM
 */

include('../../Includes/Security/database.php');

$database = new Database();

$employeeObj = NULL;
$employeeString= file_get_contents('php://input');
$employeeObj = json_decode($employeeString, true);

$id = test_input($employeeObj['id']);

$name = test_input($employeeObj['first_name'] . ' ' . $employeeObj['last_name']);

$asset_requests_read = $database->get('sp_hr_AssetRequestByIdGet("' . $id . '");');

$account_requests_read = $database->get('sp_hr_AccountRequestsByIdGet("' . $id . '");');

$response = array('assets' => $asset_requests_read, 'accounts' => $account_requests_read);

echo json_encode($response);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}