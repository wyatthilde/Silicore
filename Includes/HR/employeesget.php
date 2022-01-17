<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/21/2018
 * Time: 11:14 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$employee_read = $database->get("sp_hr_EmployeesGet");

echo $employee_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}