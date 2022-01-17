<?php

/* * *****************************************************************************************************************************************
 * File Name: securityforgotpassword.php
 * Project: Silicore
 * Description: Processes a forgotten password request.
 * Notes: This script will set a password reset token and then send an e-mail to the user.
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/16/2017|mnutsch|KACE:xxxxx - Initial creation
 * 12/07/2017|mnutsch|KACE:19845 - Added code to fix a password reset issue.
 * 
 * **************************************************************************************************************************************** */ 
 
//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
{
  echo "The current Linux user is: ";
  echo exec('whoami');
  echo "<br/>";
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled</strong><br/>";  
  echo "Start time: ";
  echo(date("Y-m-d H:i:s",$t));
  echo "<br/>";
}

// Start the session
session_start();

$user_id = ""; //so pagevariables.php doesn't display a warning
$_SESSION["user_id"] = ""; //so pagevariables.php doesn't display a warning

//include other files
include_once('../../Includes/security.php'); //functions for interacting with the user table
include_once('../../Includes/pagevariables.php'); //contains the function for signing into the database
include_once('../../Includes/emailfunctions.php'); //contains the function for sending an email
include_once('../../Includes/webanalyticshelper.php'); //function for posting PHP with CURL

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //get values from the web form and sanitize them
  if(isset($_POST["email_address_input"]))
  {
    $email_address = test_input($_POST["email_address_input"]);
  }
  
  if($debugging == 1)
  {
	echo "Email address is " . $email_address . "<br/>";
  }
  //connect to database
  //$mySQLConn = connectToMySQL(); //connect to mysql, requires security.php
  
  if($debugging == 1)
  {  
    echo "connected to database<br/>";
  }
  //find user ID by email
  $localUserObject = getUserByEmail($email_address);

  //log this action in the web analtics
  //create the page_values to send
	$a = array();
	//this is empty, because we are not passing any special values to Web Analytics
	$jsonStr = json_encode($a);
  //custom action
  $data = array(
    "token_id" => "987654321",
    "event_type" => "custom_action",
    "action_name" => "Processed_request_for_password_reset",
    "action_values" => $jsonStr
  );
  $surl = '../../Includes/analyticswebservice.php';
  try 
  {
    post_to_url($surl, $data);
  }
  catch (Exception $e) 
  {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
  
  //if user ID found
  if($localUserObject)
  {
    if($debugging == 1)
    {
      echo "user object was read<br/>";
    }
    //set security token and token expiration date
    $date = new DateTime('tomorrow');
    $token = md5($localUserObject->vars["id"] . $date->format('Y-m-d H:i:s'));
        $email_address = $localUserObject->vars["email"];

    if($debugging == 1)
    {
      echo "date is " . $date->format('Y-m-d H:i:s') . "<br/>";
      echo "token is " . $token . "<br/>";
    }
    $localUserObject->vars["password_reset_token"] = $token;
    $localUserObject->vars["password_token_expiration"] = $date->format('Y-m-d H:i:s');
    $localUserObject->vars["require_password_reset"] = 1;

    $updateResult = updateUser($localUserObject);

    if($debugging == 1)
    {
      echo "update result =  " . $updateResult . "<br/>";
    }

    //send email with password reset link
    sendPasswordReset($debugging, $email_address, $token);

    //disconnect from the database
    //disconnectFromMySQL($mySQLConn);

    unset($_SESSION["user_id"]);

    //return success message
    //echo "An email will be sent with a link to reset your password.";
    $_SESSION["password_reset_message"] = "An email was just sent to you. Follow the instructions in the email to reset your password.";
    header('Location: ../../Controls/General/main.php'); //send the user to the home page where a modal window will appear
  }
  else 
  {

    //disconnect from the database
    //disconnectFromMySQL($mySQLConn);

    unset($_SESSION["user_id"]);

    //return error message
    //echo "An email will be sent with a link to reset your password."; //This is intentionally the same message as the success
    $_SESSION["password_reset_message"] = "An email was just sent to you. Follow the instructions in the email to reset your password.";
    header('Location: ../../Controls/General/main.php'); //send the user to the home page where a modal window will appear
  }

  
}
 
/***************************************
* Name: function test_input($data) 
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
***************************************/
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 
 
?>