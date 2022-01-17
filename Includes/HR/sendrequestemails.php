<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/24/2018
 * Time: 9:58 AM
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
$employee_name = test_input($employeeObj['first_name'] . ' ' . $employeeObj['last_name']);
$first_name = test_input($employeeObj['first_name']);
$last_name = test_input($employeeObj['last_name']);
$requested_asset = test_input($employeeObj['request']);
$id = test_input($employeeObj['id']);
$last_id_read = $database->get('sp_AssetRequestMaxId');
$last_id = json_decode($last_id_read);
$manager_read = $database->get("sp_hr_EmailByNameGet('" . $manager_name . "');");
$manager_info = null;
$manager_info = json_decode($manager_read);
$manager_email = $manager_info[0]->email;
$dev_team_email = 'devteam@vprop.com';
$help_desk_email = 'help@vistasand.com';
$uniform_email = 'mine_uniforms@vprop.com';
$fuel_card_email = 'mine_fuelcard@vprop.com';
$credit_card_email = 'mine_ccrequest@vprop.com';
if(isset($employeeObj['expedite'])){
    $expedite = $employeeObj['expedite'];
    if($expedite == 1){
        $asset_insert = $database->get('sp_it_auto_asset_request("' . $id . '","' . $first_name . '","' . $last_name . '","' . $requested_asset . '","' . $_SESSION['user_id'] . '");');
        $assetObj = json_decode($asset_insert);
        $last_insert_id = $assetObj[0]->id;
        $asset_approve = $database->insert('sp_asset_request_respond("1", "' . $_SESSION['user_id'] . '","' . $last_insert_id . '");');
    }
}
if($requested_asset !== 'Email' || $requested_asset !== 'Silicore') {
    $email_subject = $requested_asset . ' needed - ' . $employee_name;
    $email_body = $employee_name . ' needs a ' . $requested_asset . '</br> Manager: ' . $manager_name;
    if ($requested_asset != null) {
        if ($requested_asset == 'Cell Phone') {
            $asset_email_subject = 'Asset Request';
            $asset_email_result = SendPHPMail($help_desk_email, $email_subject, $email_body, "");//email help@vistasand.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Laptop') {
            $asset_email_result = SendPHPMail($help_desk_email, $email_subject, $email_body, "");//email help@vistasand.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Desktop') {
            $asset_email_result = SendPHPMail($help_desk_email, $email_subject, $email_body, "");//email help@vistasand.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Tablet') {
            $asset_email_result = SendPHPMail($help_desk_email, $email_subject, $email_body, "");//email help@vistasand.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Two Way Radio') {
            $asset_email_result = SendPHPMail($help_desk_email, $email_subject, $email_body, "");//email help@vistasand.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Uniform') {
            $asset_email_subject = 'Uniform Request';
            $asset_email_result = SendPHPMail($uniform_email, $asset_email_subject, $email_body, "");//email mine_uniforms@vprop.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Credit Card') {
            $asset_email_subject = 'Credit Card Request';
            $asset_email_result = SendPHPMail($credit_card_email, $asset_email_subject, $email_body, ""); //email mine_ccrequest@vprop.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Fuel Card') {
            $asset_email_subject = 'Fuel Card Request';
            $asset_email_result = SendPHPMail($fuel_card_email, $asset_email_subject, $email_body, "");//email mine_fuelcard@vprop.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        } elseif ($requested_asset == 'Business Card') {
            $asset_email_subject = 'Business Card Request';
            $asset_email_result = SendPHPMail($help_desk_email, $asset_email_subject, $email_body, ""); //email help@vistasand.com
            $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
            echo json_encode($response_array);
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}