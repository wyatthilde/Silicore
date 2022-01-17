<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/5/2018
 * Time: 2:59 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$actionObj = NULL;

$actionString = file_get_contents('php://input');

$actionObj = json_decode($actionString, true);

$id = test_input($actionObj['id']);

$action = test_input($actionObj['action']);

$user_id = test_input($actionObj['user_id']);
//Remove device from employee and make device available for requests
if($action == 1) {
    $employee_update = $database->insert('sp_it_EmployeeUnassignAssetUpdate("' . $id . '","' . $user_id . '");');
    print_r($employee_update);
}

//Remove device from employee and also mark as inactive so it will not be available for requests
if($action == 2) {
    $note = test_input($actionObj['note']);
    $employee_update = $database->insert('sp_it_EmployeeUnassignAndRemoveAssetUpdate("' . $id . '","' . $user_id . '","' . $note . '");');
    print_r($employee_update);
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}