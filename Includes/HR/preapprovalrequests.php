<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/23/2018
 * Time: 9:38 AM
 */
include('../../Includes/Security/database.php');
include('../../Includes/emailfunctions.php');
$database = new Database();
//gets original request's submitter's name
$requestor_read = $database->get('sp_adm_UserGet("' . $_SESSION['user_id'] . '");');
$requestor_data = json_decode($requestor_read);
$requestor = $requestor_data[0]->first_name . ' ' . $requestor_data[0]->last_name;
//gets employee's manager so we can send the email to the right person. Also we get what the request is.
$employeeObj = NULL;
$employeeString = file_get_contents('php://input');
$employeeObj = json_decode($employeeString, true);
$manager_name = test_input($employeeObj['manager_name']);
$first_name = test_input($employeeObj['first_name']);
$last_name = test_input($employeeObj['last_name']);
$requested_asset = test_input($employeeObj['request']);
$id = test_input($employeeObj['id']);
$silicore = test_input($employeeObj['silicore']);
$email = test_input($employeeObj['email']);
$last_id_read = $database->get('sp_AssetRequestMaxId');
$last_id = json_decode($last_id_read);
$manager_read = $database->get("sp_hr_EmailByNameGet('" . $manager_name . "');");
$manager_info = null;
$manager_info = json_decode($manager_read);
$manager_email = $manager_info[0]->email;
$asset_insert = $database->insert('sp_asset_request("' . $id . '","' . $first_name . '","' . $last_name . '","' . $requested_asset . '","' . $_SESSION['user_id'] . '");');
echo json_encode($asset_insert);
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}