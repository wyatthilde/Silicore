<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/18/2018
 * Time: 12:17 PM
 */
include_once('../../Includes/Security/database.php');
include_once('../../Includes/emailfunctions.php');
$database = new Database();

$obj = NULL;

$string= file_get_contents('php://input');

$obj = json_decode($string, true);

$id = test_input($obj['id']);

$read = $database->insert('sp_hr_EmployeeInactivateUpdate("' . $id . '")');

$employee_read = $database->get('sp_it_EmployeeByIdGet("'.$id.'");');

$employeeObj = json_decode($employee_read);

$name = $employeeObj[0]->first_name . ' ' . $employeeObj[0]->last_name;

$assets_read = $database->get('sp_it_NonReturnedAssignedAssetsByEmployeeIdGet("'.$id.'");');

$assetsObj = json_decode($assets_read);

$arr = (array)$assetsObj;

$assets = array();

if(!$arr) {
    foreach($assetsObj as $item) {
        $assets[] = $item->type;
    }
}

$account_email_subject = 'Termination - '.$name.' - Accounts';
$account_email_body = $name.' has been terminated. Please deactivate Silicore, Active Directory and email accounts.';

$accounts_email = SendPHPMail('devteam@vprop.com', $account_email_subject, $account_email_body,"");

$assets_email_subject = 'Termination - '.$name.' - Assets';
$assets_email_body = $name.' has been terminated. Please collect the following items: '.implode(",",$assets);
if(!empty($assets)){
    $assets_email = SendPHPMail('devteam@vprop.com', $assets_email_subject, $assets_email_body,"");
} else {
    $assets_email = 1;
}


echo json_encode(array('read' => $read, 'accounts_email' => $accounts_email, 'assets_email' => $assets_email));

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
