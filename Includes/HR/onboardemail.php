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
$manager_name = $employeeObj['manager_name'];
$employee_name = $employeeObj['first_name'] . ' ' . $employeeObj['last_name'];
$requested_asset = $employeeObj['request'];

$asset_request_insert = $database->insert("sp_asset_request('" . $employeeObj['first_name'] . "','" . $employeeObj['last_name'] . "','" . $employeeObj['request'] . "','" . $_SESSION['user_id'] . "')");
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
$url = $_SERVER["HTTP_HOST"];

if ($url == 'localhost') {
    $url = $url . '/silicore/';
}

//<editor-fold desc="approved string">
$approve_string = $url . '/Includes/HR/emailresponse.php?' . base64_encode('id=' . $last_id[0]->id . '&is_approved=1&name=' . $employee_name . '&type=' . $requested_asset . '&requestor=' . $requestor . '&email=' . $manager_email);
//</editor-fold>
//<editor-fold desc="deny string">
$deny_string = $url . '/Includes/HR/emailresponse.php?' . base64_encode('id=' . $last_id[0]->id . '&is_approved=0&name=' . $employee_name . '&type=' . $requested_asset . '&requestor=' . $requestor . '&email=' . $manager_email);
//</editor-fold>
//<editor-fold desc="big and ugly email template">
$email_body = ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn\'t be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

	<!-- Web Font / @font-face : BEGIN -->
	<!-- NOTE: If web fonts are not required, lines 9 - 26 can be safely removed. -->
	
	<!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
	<!--[if mso]>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>
	<![endif]-->
	
	<!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
	<!--[if !mso]><!-->
		<!-- insert web font reference, eg: <link href=\'https://fonts.googleapis.com/css?family=Roboto:400,700\' rel=\'stylesheet\' type=\'text/css\'> -->
	<!--<![endif]-->

	<!-- Web Font / @font-face : END -->
	
	<!-- CSS Reset -->
    <style type="text/css">

		/* What it does: Remove spaces around the email design added by some email clients. */
		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
	        margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        
        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        
        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
                
        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            Margin: 0 auto !important;
        }
        table table table {
            table-layout: auto; 
        }
        
        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }
        
        /* What it does: A work-around for iOS meddling in triggered links. */
        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }
      
    </style>
    
    <!-- Progressive Enhancements -->
    <style>
        
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 480px) {

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid,
            .fluid-centered {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                Margin-left: auto !important;
                Margin-right: auto !important;
            }
            /* And center justify these ones. */
            .fluid-centered {
                Margin-left: auto !important;
                Margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }
        
            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                Margin-left: auto !important;
                Margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
                
        }

    </style>

</head>
<body width="100%" bgcolor="#343a40" style="Margin: 0;">
    <center style="width: 100%; background: #222222;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
            (Optional) This text will appear in the inbox preview, but not the email body.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!--    
            Set the email width. Defined in two places:
            1. max-width for all clients except Desktop Windows Outlook, allowing the email to squish on narrow but never go wider than 680px.
            2. MSO tags for Desktop Windows Outlook enforce a 680px width.
        -->
        <div style="max-width: 680px; margin: auto;">
            <!--[if (gte mso 9)|(IE)]>
            <table cellspacing="0" cellpadding="0" border="0" width="680" align="center">
            <tr>
            <td>
            <![endif]-->

            <!-- Email Header : BEGIN -->
            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
	            <tr>
					<td style="padding: 20px 0; text-align: center">
						<img src="http://silicore-dev.vistasand.com/Images/vprop-logo-large-no-bg.png" >
					</td>
	            </tr>
            </table>
            <!-- Email Header : END -->
            
            <!-- Email Body : BEGIN -->
            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 680px;">
                
                <!-- Hero Image, Flush : BEGIN -->

                <!-- Hero Image, Flush : END -->

                <!-- 1 Column Text + Button : BEGIN -->
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td style="padding: 40px; text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">
									' . $employee_name . ' is requesting the following asset: <b>' . $requested_asset . '</b>
									<br><br>
									<!-- Button : Begin -->
									<table cellspacing="0" cellpadding="0" border="0" align="center" style="Margin: auto">
										<tr>
											<td style="border-radius: 3px; background: #78D64B; text-align: center;" class="button-td">
	                                            <a href="' . $approve_string . '" style="background: #78D64B; border: 15px solid #78D64B; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
				                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Approve</span>&nbsp;&nbsp;&nbsp;&nbsp;
				                                </a>
											</td>
                                          <td>
                                            &nbsp;
                                          </td>
                                          <td style="border-radius: 3px; background: #dc3545; text-align: center;" class="button-td">
	                                            <a href="' . $deny_string . '" style="background:#dc3545; border: 15px solid #dc3545; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
				                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Deny</span>&nbsp;&nbsp;&nbsp;&nbsp;
				                                </a>
											</td>
										</tr>
									</table>
									<!-- Button : END -->
								</td>
							</tr>
                        </table>
                    </td>
                </tr>
			</table>
            <!-- Email Body : END -->
          
            <!-- Email Footer : BEGIN -->
            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
                <tr>
                                    <td style="color:#ced4da; text-align:center">For any questions regarding this request please contact help@vistasand.com</td>
                </tr>
            </table>
            <!-- Email Footer : END -->

            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </div>
    </center>
</body>
</html>
');
//</editor-fold>
if ($requested_asset != null) {
    if($requested_asset == 'Phone'){
        $asset_email_subject = 'Asset Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email help@vistasand.com
        $response_array = array('response' => $asset_email_result, 'email' => $manager_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Laptop'){
        $asset_email_subject = 'Asset Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email help@vistasand.com
        $response_array = array('response' => $asset_email_result, 'email' => $manager_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Desktop'){
        $asset_email_subject = 'Asset Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email help@vistasand.com
        $response_array = array('response' => $asset_email_result, 'email' => $manager_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Tablet'){
        $asset_email_subject = 'Asset Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email help@vistasand.com
        $response_array = array('response' => $asset_email_result, 'email' => $manager_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Radio'){
        $asset_email_subject = 'Asset Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email help@vistasand.com
        $response_array = array('response' => $asset_email_result, 'email' => $manager_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Uniform'){
        $asset_email_subject = 'Uniform Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email mine_uniforms@vprop.com
        $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Credit Card'){
        $asset_email_subject = 'Credit Card Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, ""); //email mine_ccrequest@vprop.com
        $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Fuel Card'){
        $asset_email_subject = 'Fuel Card Request';
        $asset_email_result = SendPHPMail($manager_email, $asset_email_subject, $email_body, "");//email mine_fuelcard@vprop.com
        $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
        echo json_encode($response_array);
    }
    elseif($requested_asset == 'Business Card'){
        $asset_email_subject = 'Business Card Request';
        $asset_email_result = SendPHPMail($help_desk_email, $asset_email_subject, $email_body, ""); //email help@vistasand.com
        $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
        echo json_encode($response_array);
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}