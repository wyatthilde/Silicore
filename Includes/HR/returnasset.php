<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/18/2018
 * Time: 4:07 PM
 */
//insert record into db (hr_returned_assets)

include_once('../../Includes/Security/database.php');
include_once('../../Includes/emailfunctions.php');

$database = new Database();

$obj = NULL;

$string= file_get_contents('php://input');

$obj = json_decode($string, true);

$id = test_input($obj['id']);

$type = test_input($obj['type']);

$user = test_input($obj['userId']);

$insert = $database->insert('sp_hr_ReturnAssetInsert("' . $id . '","' . $type . '","' . $user . '")');

echo $insert;

$employee_read = $database->get('sp_it_EmployeeByIdGet("'.$id.'");');

$employeeObj = json_decode($employee_read);

$name = $employeeObj[0]->first_name . ' ' . $employeeObj[0]->last_name;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


//email help that an asset has been returned

$email_subject = 'Asset Returned - '.$name;
$email_body = $name.' has returned a '. $type .'.';
SendPHPMail('devteam@vprop.com', $email_subject, $email_body,"");