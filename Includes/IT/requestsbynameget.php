<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/24/2018
 * Time: 3:29 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$employeesObj = NULL;
$employeesString= file_get_contents('php://input');
$employeesObj = json_decode($employeesString, true);

$employee_name = test_input($employeesObj['first_name']) . ' ' . test_input($employeesObj['last_name']);

$requests_read = $database->get('sp_it_RequestsByNameGet("' . $employee_name . '")');

echo $requests_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}