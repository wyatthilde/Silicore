<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/27/2018
 * Time: 4:45 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$employeeObj = NULL;
$employeeString= file_get_contents('php://input');
$employeeObj = json_decode($employeeString, true);

$id = test_input($employeeObj['id']);
$first_name = test_input($employeeObj['first_name']);
$last_name = test_input($employeeObj['last_name']);
$paycom_id = test_input($employeeObj['paycom_id']);
$job_title_id = test_input($employeeObj['job_title_id']);
$dept_id = test_input($employeeObj['department_id']);
$manager_id = test_input($employeeObj['manager_id']);
$site_id = test_input($employeeObj['site_id']);
$is_active = test_input($employeeObj['is_active']);
$user_id = test_input($employeeObj['user_id']);

$update_employee_result = $database->insert('sp_hr_EmployeeUpdate("' . $id . '","' . $last_name . '","' . $first_name . '","' . $paycom_id . '","' . $dept_id . '","' . $job_title_id . '","' . $manager_id . '","'  . $user_id . '","' . $is_active . '");');

$result_array = array("response" => $update_employee_result);
echo json_encode($result_array);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}