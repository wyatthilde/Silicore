<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/28/2018
 * Time: 11:18 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();



$deptObj = NULL;
$deptString= file_get_contents('php://input');
$deptObj = json_decode($deptString, true);

$dept_id = test_input($deptObj['department_id']);

$employees_read = $database->get("sp_EmployeeByDeptAllGet(" . $dept_id . ");");

echo $employees_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
