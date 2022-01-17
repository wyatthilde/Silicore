<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/20/2018
 * Time: 5:56 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();



$deptObj = NULL;
$deptString= file_get_contents('php://input');
$deptObj = json_decode($deptString, true);

$dept_id = test_input($deptObj['department_id']);

$departments_read = $database->get("sp_hr_ManagersGetByDept(" . $dept_id . ");");

echo $departments_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

