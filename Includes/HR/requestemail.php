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
$requestor_read = $database->get('sp_adm_UserGet("' . $_SESSION['user_id'] . '");');
$requestor_data = json_decode($requestor_read);
$requestor = $requestor_data[0]->first_name . ' ' . $requestor_data[0]->last_name;
$employeeObj = NULL;
$employeeString= file_get_contents('php://input');
$employeeObj = json_decode($employeeString, true);
$manager_name= $employeeObj['manager_name'];
$employee_name = $employeeObj['first_name'] . ' ' . $employeeObj['last_name'];
$requested_device = $employeeObj['request'];
$asset_request_insert = $database->insert("sp_asset_request('" . $employeeObj['first_name'] . "','" . $employeeObj['last_name'] . "','" . $employeeObj['request'] . "','"  . $_SESSION['user_id'] . "')");
$last_id_read = $database->get('sp_AssetRequestMaxId');
$last_id = json_decode($last_id_read);
$manager_read = $database->get("sp_hr_EmailByNameGet('" . $manager_name .  "');");
$manager_info = null;
$manager_info = json_decode($manager_read);
$manager_email = $manager_info[0]->email;

$url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
echo $url;
$approve_string = $url . '/Includes/HR/emailresponse.php?' . base64_encode('id=' . $last_id[0]->id .  '&is_approved=1&name=' . $employee_name . '&type=' . $requested_device . '&requestor=' . $requestor . '&email=' . $manager_email);
$deny_string = $url . '/Includes/HR/emailresponse.php?' . base64_encode('id=' .  $last_id[0]->id . '&is_approved=0&name=' . $employee_name . '&type=' . $requested_device . '&requestor=' . $requestor . '&email=' . $manager_email);

$asset_email_subject = 'Asset Request';
//<editor-fold desc="$asset_email_body">
$asset_email_body = 'This email is intended for ' . $manager_name . '.</br> 
Employee ' . $employee_name . ' is requesting the following asset: ' . $requested_device . '<br/><br/><br/><table><tr><td><div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="' . $approve_string . '" style="height:40px;v-text-anchor:middle;width:115px;" arcsize="8%" stroke="f" fill="t">
    <v:fill type="tile" src=""https://imgur.com/5BIp9d0.gif"" color="#78D64B" />
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">Approve</center>
  </v:roundrect>
<![endif]--></a></div></td><td><div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="' . $deny_string . '" style="height:40px;v-text-anchor:middle;width:115px;" arcsize="8%" stroke="f" fill="t">
    <v:fill type="tile" src=""https://imgur.com/5BIp9d0.gif"" color="#d9534f" />
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">Deny</center>
  </v:roundrect>
<![endif]--></a></td></tr></table></div>';
//</editor-fold>
$asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $asset_email_body,"");
$response_array = array(
    'response' => $asset_email_result,
    'email' => $manager_email
);

echo json_encode($response_array);
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}