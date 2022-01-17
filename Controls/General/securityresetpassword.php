
<?php

/* * *****************************************************************************
 * File Name: securityresetpassword.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar 16, 2017
 * Description: This script resets the user's password and then redirects them to the home page.
 * Notes: 
 * **************************************************************************** */
 
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
$user_id = "";
if(isset($_SESSION["user_id"]))
{
  $user_id = $_SESSION["user_id"];
  if($debugging == 1)
  {
    echo "session ID is set<br/>";
  }
}

//include other files
include_once('../../Includes/security.php'); //functions for interacting with the user table
include_once('../../Includes/pagevariables.php'); //contains the function for signing into the database
include_once('../../Includes/webanalyticshelper.php'); //function for posting PHP with CURL

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //get values from the web form
  //sanitize the user input
  $password_input = test_input($_POST["password"]);
  $password_confirm_input = test_input($_POST["passwordConfirm"]);
  $user_id = $_SESSION["user_id"];
  
  //log this action in the web analtics
  //create the page_values to send
  //create the page_values to send
	$a = array();
	$a["UserID"] = $user_id; //requires pagevariables.php
	$a["UserIP"] = $UserIP; //requires pagevariables.php
	$jsonStr = json_encode($a);
  //custom action
  $data = array(
    "token_id" => "987654321",
    "event_type" => "custom_action",
    "action_name" => "Reset_a_password",
    "action_values" => $jsonStr
  );
  $surl = 'https://ws-test.vistasand.com/sites/sandbox/Includes/analyticswebservice.php';
  try 
  {
    post_to_url($surl, $data);
  }
  catch (Exception $e) 
  {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
  
  //check that the password inputs match
  if(($password_input == $password_confirm_input) && (isset($_SESSION["user_id"]))) //if the passwords match AND the user is signed in
  {
    //echo("The passwords match each other and the user is signed in.<br/>");

    $resultOfUpdate = 0;

    //then set the password in the database

    //connect to the database
    //$mySQLConn = connectToMySQL(); //connect to mysql, requires security.php

    //update the password value in the database
    $resultOfUpdate = updateUserPassword($user_id, $password_input);

    if($resultOfUpdate == 1)
    {
      //echo "The password reset was successful.";
      
      //unset the password reset requirement
      unset($_SESSION["signin_password_reset"]);

      //redirect the user to the main page
      header('Location: ../../Controls/General/main.php'); //header to home page 
      
    }
    else
    {
      //the password could not be updated
      //echo "The password could not be updated. Please try again later.";

      //Add an error message session variable
      $_SESSION["password_reset_error_message"] = "The password could not be updated. Please try again later.";

      //redirect the user to password change page
      header('Location: ../../Controls/General/main.php'); 
    }
  }
  else
  {
    //echo("The passwords do not match each other or the user is not signed in.<br/>");

    //add an error message session variable
    $_SESSION["password_reset_error_message"] = "The passwords do not match each other or the user is not signed in.";

    //redirect the user to the change password page
    header('Location: ../../Controls/General/main.php'); 
	
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