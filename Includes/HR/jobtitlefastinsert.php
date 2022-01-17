<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/13/2018
 * Time: 2:12 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;
$string = file_get_contents('php://input');
$obj = json_decode($string, true);

$dept = test_input($obj['department_id']);

$position = test_input($obj['position']);

$isManagement = test_input($obj['is_management']);

$insert_result = $database->insert('sp_hr_JobTitleFastInsert("' . $dept . '","' . $position . '","' . $isManagement . '");');

echo $insert_result;


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}