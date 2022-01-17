<?php
/*********************************************************************************************************************************************
 * File Name: emailfunctions.php
 * Project: Silicore
 * Description: This file contains the functions for sending e-mails.
 * Notes: 
 * ==========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * ==========================================================================================================================================
 * 06/20/2017|mnutsch|KACE:(create global email functionality) - Initial creation
 * 06/28/2017|kkuehn|KACE:17276 - Enhanced and fleshed out the SendPHPMail() function, overall code cleanup, organization. Updated to latest
 *                                page-level DocBlock convention. Updated project name
 * 07/27/2017|mnutsch|KACE:N/A Updated email address for new user requests.
 * 08/14/2017|mnutsch|KACE:xxxxx - Made server name dynamic.
 * 08/15/2017|mnutsch|KACE:xxxxx - Removed additional recipients from password reset emails.
 * 08/17/2017|mnutsch|KACE:xxxxx - Added the server name to the error message email function.
 * 08/30/2017|mnutsch|KACE:18407 - Changed the subject line of an email.
 * 09/08/2017|mnutsch|KACE:18592 - Added a variable to the subject line of emails.
 * 09/27/2017|kkuehn|KACE:10499 - Added variables for global email settings
 * 10/11/2017|mnutsch|KACE:19045 - Updated text for external sample email notifications.
 * 10/23/2017|mnutsch|KACE:19217 - Added username to error message emails.
 * 10/24/2017|mnutsch|KACE:19217 - Fixed a warning message.
 * 11/30/2017|mnutsch|KACE:18968 - Created the function sendQCSampleCompletionNotification().
 * 12/05/2017|mnutsch|KACE:18968 - Edited the function sendQCSampleCompletionNotification().
 * 12/28/2017|mnutsch|KACE:19861 - I edited the function sendQCSampleCompletionNotification() to make the recipient email addresses site specific.
 * 01/04/2018|mnutsch|KACE:20158 - I edited the function sendQCSampleCompletionNotification() to respond to the updated description for the West Texas site.
 * 
 ********************************************************************************************************************************************/

//==================================================================== BEGIN PHP

require_once('/var/www/configuration/email-system.php'); // contains credentials for the system generated email account
require_once('PHPMailer/PHPMailerAutoload.php'); // functions for connecting to the email server
require_once('pagevariables.php'); // contains server info variables

// Set Debugging Options
$debugging = 0; // set this to 1 to see debugging output

// display information if we are in debugging mode
if($debugging)
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  $currentTime = time(); // variable used for obtaining the current time
  echo("The current Linux user is: " . (exec('whoami')) . "<br />");
  echo("<strong>Debugging Enabled - emailfunctions.php</strong><br/>");  
  echo("Start time: " . (date("Y-m-d H:i:s",$currentTime)) . "<br />");
  echo("The email server is: " . SYS_EMAIL_SERVER . "<br/>");
  echo("The email port is: " . SYS_EMAIL_PORT . "<br/>");
  echo("The email user is: " . SYS_EMAIL_USER . "<br/>");

}

/************************************************************************************************
 * Name: SendPHPMail()
 * Description: Generic email function that acts as a wrapper for PHPMailer and
 *              fetches account information from the configurataion file constants.
 *              This function can be used on any page in the site that includes the 
 *              MASTER template.
 * Incoming parameters:
 *   1) (string, required) address list [CSV for multiples]
 *   2) (string, required) subject
 *   3) (string, required) body
 *   4) (string, positional-optional) page source [Use global variables ("/$PageDept/$PageName")]
 *   5) (boolean, positional-optional) debug mode switch, defaulted to 'on'
 *   6) (boolean, optional) force text-only switch, defaulted to 'off'
 * Notes: The optional parameters are positional-optional, i.e., to set option 6, 4 and 5 also 
 *        need to be set.
 *        In PHPMailer, use one of the following body properties, depending on HTML or Text-only:
 *          $[PHPMailer]->Body {HTML enabled string)
 *          $[PHPMailer]->AltBody (Text-only string)
 *        The function returns the value 1 if successful and 0 on failure.
 ************************************************************************************************/
function SendPHPMail($argEmailAddresses, $argSubject, $argBody, $argSource = "", $argDebugging = 0, $argTextOnly = 0)
{  
  global $SiteBuildType;
  global $TestEmailTo;
  
  $mail = new PHPMailer(true);  // create PHPMailer object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $mail->SMTPAuth = true;  // authentication enabled
  //$mail->SMTPSecure = 'tls';
  // get/set account information from the configuration file constants
  $mail->Host = SYS_EMAIL_SERVER;
  $mail->Port = SYS_EMAIL_PORT;
  $mail->Username = SYS_EMAIL_USER; 
  $mail->Password = SYS_EMAIL_PWD;      
  $mail->From = SYS_EMAIL_USER;
  // format the sender information
  $mail->FromName = 'Silicore System';    
  $mail->AddReplyTo(SYS_EMAIL_USER, 'Silicore System');

  // parse the CSV address string into an array
  $recipientArray = explode(',',$argEmailAddresses);
  
  if($argDebugging == 1)
  {
    // If in debug mode, intercept the outgoing email(s) and send to devteam@vistasand.com only, with all parameters displayed in the body. 
    $mail->AddAddress($TestEmailTo);
    
    $mail->Subject = "Debugging: " . $argSubject . " - " . $argSource . " - " . $SiteBuildType;
    
    $bodyString = "=== Email Parameters =========================================================================<br />";
    for($i=0; $i < count($recipientArray); $i++)
    {
      $bodyString .= "Address " . ($i+1) . ": " . $recipientArray[$i] . "<br />";
    }
    $bodyString .= "<br />
      Subject: " . $argSubject . "<br />
      Body:<br />" . $argBody . "<br /><br />
      Source: " . $argSource . "<br />
      Debugging: " . ($argDebugging ? "Yes" : "No") . "<br />
      Text Only: " . ($argTextOnly ? "Yes" : "No") . "<br />";
    
    $argSource = ($argSource == "" ? "/Includes/emailfunctions.php:SendPHPMail()" : $argSource);
  }
  else
  { 
    // add the email address(es)
    for($i=0; $i < count($recipientArray); $i++)
    {
      $mail->AddAddress($recipientArray[$i]);
    }
    $mail->Subject = $argSubject; 
    $bodyString = $argBody;
  }
  
  // set whether or not this is an HTML email, add appropriate Body string
  if($argTextOnly == 1)
  {
    $mail->IsHTML(false);
    $mail->AltBody = $bodyString; // Text-only email body
  }
  else
  {
    $mail->IsHTML(true);
    $mail->Body = $bodyString; // HTML-enabled email body
  }
  
  // format the function status return
  //send the message, check for errors
  //if (!$mail->send()) {
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
  //} else {
   // if ($argDebugging) {
    //  echo 'Message sent!';
    //}

 // }


 
}

/*******************************************************************************
 * Name: sendPasswordReset($argDebugging, $argEmailAddress, $argToken)
 * Description: This function sends an email with a link to reset a password.
 * The first argument should be sent as "0", unless debugging code.
 * The second argument should be a string containing the user's e-mail address.
 * The third argument should be a string containing the password reset token.
 * The function returns the value 1 if successful and 0 if it is a failure.
 *******************************************************************************/
function sendPasswordReset($argDebugging, $argEmailAddress, $argToken)
{	
  global $SiteBuildType;
  $ServerName = filter_input(INPUT_SERVER, 'SERVER_NAME',FILTER_SANITIZE_STRING);
  
  $to = $argEmailAddress; // main email recipient
  $subject = 'Password Reset - ' . $SiteBuildType;
  $body = 'Hello,\n\n You requested that your password be reset. \n\n To reset your password, click on this link or copy and paste it into your web browser.' . 
          '<a href="http://' . $ServerName . '/Controls/General/main.php?tokenid=' . $argToken . 
          '">http://' . $ServerName . '/Controls/General/main.php?tokenid=' . $argToken . '</a>'; 

  $mail = new PHPMailer();  // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true;  // authentication enabled
  $mail->SMTPSecure = 'tls'; // secure transfer enabled 

  $mail->Host = SYS_EMAIL_SERVER;
  $mail->Port = SYS_EMAIL_PORT;
  $mail->Username = SYS_EMAIL_USER; 
  $mail->Password = SYS_EMAIL_PWD;      
  $mail->From = SYS_EMAIL_USER;
  $mail->FromName = 'Silicore System';    
  $mail->AddReplyTo(SYS_EMAIL_USER, 'Silicore System');
  $mail->Subject = $subject;
  $mail->AltBody = $body;
  $mail->Body = $body;
  $mail->AddAddress($to);

  if(!$mail->Send())
  {
    if($argDebugging)
    {
      echo("Something went wrong and a message was not sent, but you won't see this anyway.<br/ >");
      echo("Mailer Error: " . $mail->ErrorInfo);
    }
    return 0;
  }
  else
  {
    if($argDebugging)
    {
      //echo("The error message e-mail was sent successfully!");
    }  
    return 1;
  } 
}

/*******************************************************************************
 * Name: sendNewUserMessage($argDebugging, $argUserObject, $argNewRecordID)
 * Description: This function sends an email to admin when a user account is requested.
 * The first argument should be sent as "0", unless debugging code.
 * The second argument should be the user object.
 * The third argument should be the ID of the new user.
 * The function returns the value 1 if successful and 0 if it is a failure.
 *******************************************************************************/
function sendNewUserMessage($argDebugging, $argUserObject, $argNewRecordID)
{	
  global $SiteBuildType;
  $to = "development@vistasand.com"; // main email recipient 

  $subject = 'Silicore: New User Request - ' . $argUserObject->vars["first_name"] . ' ' . $argUserObject->vars["last_name"] . " - " . $SiteBuildType;
  $body = 'Hello,<br/><br/> A new user request was received.'
    . '<br/><br/>'
    . 'Please complete the settings for user ID #: ' . $argUserObject->vars["id"] . 
    '<br/><br/>' . 
    'Information received:' . 
    'First Name: ' . $argUserObject->vars["first_name"] . '<br/>' . 
    'Last Name: ' . $argUserObject->vars["last_name"] . '<br/>' . 
    'Email Address: ' . $argUserObject->vars["email"] . '<br/>' . 
    'Company: ' . $argUserObject->vars["company"] . '<br/>' . 
    'Department: ' . $argUserObject->vars["department"] .
    '<br/><br/>' .
    'Changes should be made in the table main_users and main_user_permissions, before communicating with the user.'; 

  $mail = new PHPMailer();  // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true;  // authentication enabled
  $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail

  $mail->Host = SYS_EMAIL_SERVER;
  $mail->Port = SYS_EMAIL_PORT;
  $mail->Username = SYS_EMAIL_USER; 
  $mail->Password = SYS_EMAIL_PWD;      
  $mail->From = SYS_EMAIL_USER;
  $mail->FromName = 'Silicore System';    
  $mail->AddReplyTo(SYS_EMAIL_USER, 'Silicore System');
  $mail->Subject = $subject;
  $mail->AltBody = $body;
  $mail->Body = $body;
  $mail->AddAddress($to);

  if(!$mail->Send())
  {
    if($argDebugging)
    {
      echo("Something went wrong and a message was not sent, but you won't see this anyway.<br/ >");
      echo("Mailer Error: " . $mail->ErrorInfo);
    }
    return 0;
  }
  else
  {
    if($argDebugging)
    {
      echo("The error message e-mail was sent successfully!"); 
    }  
    return 1;
  }
}

/*******************************************************************************
 * Name: sendErrorMessage($argDebugging, $argErrorMessage)
 * Description: This function sends an email to development when a website error occurs.
 * The first argument should be sent as "0", unless debugging code.
 * The second argument should be a string containing the error message.
 * The function returns the value 1 if successful and 0 if it is a failure.
 *******************************************************************************/
function sendErrorMessage($argDebugging, $argErrorMessage)
{
  global $SiteBuildType;
  $ServerName = filter_input(INPUT_SERVER, 'SERVER_NAME',FILTER_SANITIZE_STRING);

  $to = "devteam@vprop.com"; // main email recipient
  
  //get the username and include it in the email
  // Start the session if not already started
  if (session_status() == PHP_SESSION_NONE) 
  {
    session_start();
  }
  if(isset($_SESSION["username"]))
  {
    $username = $_SESSION["username"];
  }
  else
  {
    $username = "unknown";
  }

  $subject = 'Silicore: Error Message - ' . $SiteBuildType;
  $body = 'Hello,\n\n An error occured in the Silicore application.'
    . '\n\n'
    . 'The error message is: ' . $argErrorMessage . '.'
    . '\n\n'
    . "The server name is: " . $ServerName
    . '\n\n'
    . "The username is: " . $username;

  $mail = new PHPMailer();  // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPDebug = $argDebugging;  // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true;  // authentication enabled
  $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail

  $mail->Host = SYS_EMAIL_SERVER;
  $mail->Port = SYS_EMAIL_PORT;
  $mail->Username = SYS_EMAIL_USER; 
  $mail->Password = SYS_EMAIL_PWD;      
  $mail->From = SYS_EMAIL_USER;
  $mail->FromName = 'Silicore System';    
  $mail->AddReplyTo(SYS_EMAIL_USER, 'Silicore System');
  $mail->Subject = $subject;
  $mail->AltBody = $body;
  $mail->Body = $body;
  $mail->AddAddress($to);

  if(!$mail->Send())
  {
    if($argDebugging)
    {
      echo("Something went wrong and a message was not sent, but you won't see this anyway.<br/ >");
      echo("Mailer Error: " . $mail->ErrorInfo);
    }
    return 0;
  }
  else
  {
    if($argDebugging)
    {
      echo("The error message e-mail was sent successfully!"); 
    }  
    return 1;
  }
}

/*******************************************************************************
 * Name: sendExternalQCSampleNotification($argDebugging, $argSite, $argSampleID)
 * Description: This function sends an email to Ryan Banning when a QC sample is 
 * entered for an external site.
 * The first argument should be sent as "0", unless debugging code.
 * The second argument should be a string containing the QC Site name.
 * The third argument should be the ID number of the sample.
 * The function returns the value 1 if successful and 0 if it is a failure.
 *******************************************************************************/
function sendExternalQCSampleNotification($argDebugging, $argSiteName, $argSampleID, $argMine)
{  
  global $SiteBuildType;
  global $QCNotifyDev;
  global $QCNotifyTest;
  global $QCNotifyProd;
  $result = 0;
  
  switch($SiteBuildType)
  {
    case "[Dev]":
      $recipient = $QCNotifyDev;
      break;
    case "[Test]":
      $recipient = $QCNotifyDev . "," . $QCNotifyTest;
      break;
    case "[Live]":
      $recipient = $QCNotifyProd;
      break;
    default:
      $recipient = $QCNotifyDev;
      break;
  }  
  
  //$recipient = $TestEmailTo; //for development/debug  <--- Remove line after build 14 is live
  //$recipient = "rbanning@vprop.com"; //for production use  <--- Remove line after build 14 is live
  
  $argBody = "Hello,<br/><br/>An external QC sample was created.<br/><br/>The mine site is <strong>" . $argMine . "</strong><br/></br>The sample site name is <strong>" . $argSiteName . "</strong>.<br/><br/>Sample ID number(s): <strong>" . $argSampleID . "</strong>.<br/><br/><br/>If you are not the appropriate contact for this message, then please contact VProp IT Development by emailing development@vprop.com.";
  $argSubject = "External QC Sample(s) Created: " . $argSiteName . " - " . $argSampleID . " - " . $SiteBuildType;
  
  if($argDebugging == 1)
  {
    echo "recipient = " . $recipient . "<br/>";
    echo "argBody = " . $argBody . "<br/>";
    echo "argSubject = " . $argSubject . "<br/>";
  }
  
  $result = SendPHPMail($recipient, $argSubject, $argBody, "", $argDebugging, 0);
  
  return $result;
}


/*******************************************************************************
 * Name: sendQCSampleCompletionNotification($argDebugging, $argSite, $argSampleID)
 * Description: This function sends an email to Production when a QC sample group 
 * is complete.
 * The first argument should be sent as "0", unless debugging code.
 * The second argument should be a string containing the QC Site name.
 * The third argument should be the ID number of the sample.
 * The function returns the value 1 if successful and 0 if it is a failure.
 *******************************************************************************/
function sendQCSampleCompletionNotification($argDebugging, $argSiteName, $argSampleID)
{  
  global $SiteBuildType;
  global $gb_ProdNotifyDev;
  global $gb_ProdNotifyTest;
  global $gb_ProdNotifyProd;
  global $tl_ProdNotifyDev;
  global $tl_ProdNotifyTest;
  global $tl_ProdNotifyProd;
  global $wt_ProdNotifyDev;
  global $wt_ProdNotifyTest;
  global $wt_ProdNotifyProd;
  $result = 0;
  
  $recipient = "";
  
  if($argSiteName == "Granbury")
  { 
    switch($SiteBuildType)
    {
      case "[Dev]":
        $recipient = $gb_ProdNotifyDev;
        break;
      case "[Test]":
        $recipient = $gb_ProdNotifyDev . "," . $ProdNotifyTest;
        break;
      case "[Live]":
        $recipient = $gb_ProdNotifyProd;
        break;
      default:
        $recipient = $gb_ProdNotifyDev;
        break;
    }  
  }
  else if($argSiteName == "Cresson")
  { 
    switch($SiteBuildType)
    {
      case "[Dev]":
        $recipient = $gb_ProdNotifyDev;
        break;
      case "[Test]":
        $recipient = $gb_ProdNotifyDev . "," . $ProdNotifyTest;
        break;
      case "[Live]":
        $recipient = $gb_ProdNotifyProd;
        break;
      default:
        $recipient = $gb_ProdNotifyDev;
        break;
    }  
  }
  else if($argSiteName == "Tolar")
  { 
    switch($SiteBuildType)
    {
      case "[Dev]":
        $recipient = $tl_ProdNotifyDev;
        break;
      case "[Test]":
        $recipient = $tl_ProdNotifyDev . "," . $tl_ProdNotifyTest;
        break;
      case "[Live]":
        $recipient = $tl_ProdNotifyProd;
        break;
      default:
        $recipient = $tl_ProdNotifyDev;
        break;
    }  
  }
  else if($argSiteName == "West Texas") //dev note: Check that this is still correct after the West Texas mine opens. See the column description in the database table main_sites.
  { 
    switch($SiteBuildType)
    {
      case "[Dev]":
        $recipient = $wt_ProdNotifyDev;
        break;
      case "[Test]":
        $recipient = $wt_ProdNotifyDev . "," . $wt_ProdNotifyTest;
        break;
      case "[Live]":
        $recipient = $wt_ProdNotifyProd;
        break;
      default:
        $recipient = $wt_ProdNotifyDev;
        break;
    }  
  }
  
  if($argDebugging == 1)
    echo("DEBUG: argSiteName == " . $argSiteName . "<br/>");
  
  $argBody = "Hello,<br/><br/>A QC sample group was completed.<br/><br/>The sample site name is <strong>" . $argSiteName . "</strong>.<br/><br/>Sample ID number(s): <strong>" . $argSampleID . "</strong>.<br/><br/><br/>If you are not the appropriate contact for this message, then please contact VProp IT Development by emailing development@vprop.com.";
  $argSubject = "QC Sample(s) Complete: " . $argSiteName . " - " . $argSampleID . " - " . $SiteBuildType;
  
  if($argDebugging == 1)
  {
    echo "recipient = " . $recipient . "<br/>";
    echo "argBody = " . $argBody . "<br/>";
    echo "argSubject = " . $argSubject . "<br/>";
  }
  
  $result = SendPHPMail($recipient, $argSubject, $argBody, "", $argDebugging, 0);
  
  return $result;
}

function SendPHPMailWithAttachment($argEmailAddresses, $argSubject, $argBody, $argAttachment = "", $argAttachmentName = "", $argSource = "", $argDebugging = 1, $argTextOnly = 0)
{
    global $SiteBuildType;
    global $TestEmailTo;

    $mail = new PHPMailer();  // create PHPMailer object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled
    // get/set account information from the configuration file constants
    $mail->Host = SYS_EMAIL_SERVER;
    $mail->Port = SYS_EMAIL_PORT;
    $mail->Username = SYS_EMAIL_USER;
    $mail->Password = SYS_EMAIL_PWD;
    $mail->From = SYS_EMAIL_USER;
    // format the sender information
    $mail->FromName = 'Silicore System';
    $mail->AddReplyTo(SYS_EMAIL_USER, 'Silicore System');

    if($argAttachment !== "") {
      $mail->addStringAttachment($argAttachment, $argAttachmentName);
    }
    // parse the CSV address string into an array
    $recipientArray = explode(',',$argEmailAddresses);

    if($argDebugging == 1)
    {
        // If in debug mode, intercept the outgoing email(s) and send to devteam@vistasand.com only, with all parameters displayed in the body.
        $mail->AddAddress($TestEmailTo);

        $mail->Subject = "Debugging: " . $argSubject . " - " . $argSource . " - " . $SiteBuildType;

        $bodyString = "=== Email Parameters =========================================================================<br />";
        for($i=0; $i < count($recipientArray); $i++)
        {
            $bodyString .= "Address " . ($i+1) . ": " . $recipientArray[$i] . "<br />";
        }
        $bodyString .= "<br />
      Subject: " . $argSubject . "<br />
      Body:<br />" . $argBody . "<br /><br />
      Source: " . $argSource . "<br />
      Debugging: " . ($argDebugging ? "Yes" : "No") . "<br />
      Text Only: " . ($argTextOnly ? "Yes" : "No") . "<br />";

        $argSource = ($argSource == "" ? "/Includes/emailfunctions.php:SendPHPMail()" : $argSource);
    }
    else
    {
        // add the email address(es)
        for($i=0; $i < count($recipientArray); $i++)
        {
            $mail->AddAddress($recipientArray[$i]);
        }
        $mail->Subject = $argSubject;
        $bodyString = $argBody;
    }

    // set whether or not this is an HTML email, add appropriate Body string
    if($argTextOnly == 1)
    {
        $mail->IsHTML(false);
        $mail->AltBody = $bodyString; // Text-only email body
    }
    else
    {
        $mail->IsHTML(true);
        $mail->Body = $bodyString; // HTML-enabled email body
    }

    // format the function status return
    if(!$mail->Send())
    {
        if($argDebugging)
        {
            //echo("Something went wrong and the message was not sent.<br/ ><br/ >Mailer Error: ") . $mail->ErrorInfo . "<br /><br />";
        }
        return 0;
    }
    else
    {
        if($argDebugging)
        {
            //echo("The e-mail was sent successfully!<br />");
        }
        return 1;
    }

}

function SendPHPMailWithImage($argEmailAddresses, $argSubject, $argBody, $argImage = "", $argImageName = "", $argSource = "", $argDebugging = 1, $argTextOnly = 0)
{
    global $SiteBuildType;
    global $TestEmailTo;

    $mail = new PHPMailer();  // create PHPMailer object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled
    // get/set account information from the configuration file constants
    $mail->Host = SYS_EMAIL_SERVER;
    $mail->Port = SYS_EMAIL_PORT;
    $mail->Username = SYS_EMAIL_USER;
    $mail->Password = SYS_EMAIL_PWD;
    $mail->From = SYS_EMAIL_USER;
    // format the sender information
    $mail->FromName = 'Silicore System';
    $mail->AddReplyTo(SYS_EMAIL_USER, 'Silicore System');

    if($argImage !== "") {
        $mail->AddEmbeddedImage($argImage, $argImageName);
    }
    // parse the CSV address string into an array
    $recipientArray = explode(',',$argEmailAddresses);

    if($argDebugging == 1)
    {
        // If in debug mode, intercept the outgoing email(s) and send to devteam@vistasand.com only, with all parameters displayed in the body.
        $mail->AddAddress($TestEmailTo);

        $mail->Subject = "Debugging: " . $argSubject . " - " . $argSource . " - " . $SiteBuildType;

        $bodyString = "=== Email Parameters =========================================================================<br />";
        for($i=0; $i < count($recipientArray); $i++)
        {
            $bodyString .= "Address " . ($i+1) . ": " . $recipientArray[$i] . "<br />";
        }
        $bodyString .= "<br />
      Subject: " . $argSubject . "<br />
      Body:<br />" . $argBody . "<br /><br />
      Source: " . $argSource . "<br />
      Debugging: " . ($argDebugging ? "Yes" : "No") . "<br />
      Text Only: " . ($argTextOnly ? "Yes" : "No") . "<br />";

        $argSource = ($argSource == "" ? "/Includes/emailfunctions.php:SendPHPMail()" : $argSource);
    }
    else
    {
        // add the email address(es)
        for($i=0; $i < count($recipientArray); $i++)
        {
            $mail->AddAddress($recipientArray[$i]);
        }
        $mail->Subject = $argSubject;
        $bodyString = $argBody;
    }

    // set whether or not this is an HTML email, add appropriate Body string
    if($argTextOnly == 1)
    {
        $mail->IsHTML(false);
        $mail->AltBody = $bodyString; // Text-only email body
    }
    else
    {
        $mail->IsHTML(true);
        $mail->Body = $bodyString; // HTML-enabled email body
    }

    // format the function status return
    if(!$mail->Send())
    {
        if($argDebugging)
        {
            //echo("Something went wrong and the message was not sent.<br/ ><br/ >Mailer Error: ") . $mail->ErrorInfo . "<br /><br />";
        }
        return 0;
    }
    else
    {
        if($argDebugging)
        {
            //echo("The e-mail was sent successfully!<br />");
        }
        return 1;
    }

}

//====================================================================== END PHP
?>
