<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/10/2018
 * Time: 11:44 AM
 */
include('../../Includes/Security/database.php');
include('../../Includes/emailfunctions.php');

$database = new Database();

$employeeObj = NULL;

$employeeString = file_get_contents('php://input');

$employeeObj = json_decode($employeeString, true);

$id = test_input($employeeObj['id']);

$name = test_input($employeeObj['first_name']) . ' ' . test_input($employeeObj['last_name']);

$accounts_read = $database->get('sp_hr_AccountRequestsByIdGet("' . $id . '");');

$account_items = count(json_decode($accounts_read));

$user_id = test_input($employeeObj['user_id']);
if($account_items > 1) {
$account_object = json_decode($accounts_read);
    foreach($account_object as $item) {
        $account_type = $item->type;
        $account_model = $item->model;
        if ($account_type == 'Silicore') {
            $silicore_request_subject = 'Silicore Account';
            $silicore_request_string = null;
            $silicore_account_body = $name . ' needs a silicore account. Model after ' . $account_model . '.';
            SendPHPMail('help@vprop.com', $silicore_request_subject, $silicore_account_body, ""); //email devteam@vprop.com
        }
        if ($account_type == 'Email') {
            $email_request_subject = 'Email Account';
            $email_account_body = $name . ' needs an email account. Model after ' . $account_model . '.';
            SendPHPMail('help@vprop.com', $email_request_subject, $email_account_body, "");//email help@vistasand.com
        }
    }
}

$database->insert("sp_hr_ApproveEmployeeById('" . $id . "','" . $user_id . "');");

$database->insert('sp_hr_ApproveAssetRequestByEmployeeId("1","' . $user_id . '","' . $id . '");');

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}