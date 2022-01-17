<?php

/* * *****************************************************************************************************************************************
 * File Name: security.php
 * Project: Silicore
 * Description: This file processes new user account requests.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 03/28/2017|mnutsch|KACE:xxxxx - File created.
 * 07/28/2017|mnutsch|KACE:17729 - Improved process and removed bugs.
 * 08/21/2017|mnutsch|KACE:17957 - Fixed a bug where new users had a value in the separation date field.
 * 08/30/2017|mnutsch|KACE:18407 - Added Department to the new user registration object, so that it will be included in emails.
 * 09/05/2017|mnutsch|KACE:17957 - Added processing of a new field.
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//include other files
include_once('../../Includes/security.php'); //functions for interacting with the user table
include_once('../../Includes/emailfunctions.php'); //functions for sending emails
include_once('../../Includes/webanalyticshelper.php'); //function for posting PHP with CURL

//Set Debugging Options
$debugging = 1; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time
$functionResult = NULL; //variable used to check the return status of function calls
$functionResult2 = NULL; //variable used to check the return status of function calls
$functionResult3 = NULL; //variable used to check the return status of function calls
$temporaryUserName = NULL; //variable used to test out different user names
$continueLoop = true;

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

if (session_status() == PHP_SESSION_NONE) 
{
  session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if($debugging == 1)
  {
    echo "The form was submitted.<br/>";
  }
  
  //get values from the web form
  //sanitize the user input
  $first_name = test_input($_POST["first_name"]);
  $last_name = test_input($_POST["last_name"]);
  $email_address = test_input($_POST["email_address"]);
  $company = test_input($_POST["company"]);
  $department = test_input($_POST["department"]);
  $accessLevel = test_input($_POST["accessLevel"]);

  if($debugging == 1)
  {
    echo "values read: " . "<br/>" .
      $first_name . "<br/>" .
      $last_name . "<br/>" .
      $email_address . "<br/>" .
      $company . "<br/>" .
      $department . "<br/>";

    //insert the values into the database with an inactive user account
    echo "<h3>Inserting a new User Into Database</h3>";
  }
  
  //insert a user
  $username = strtolower($first_name[0] . $last_name); //first initial of first name and the last name
  $first_name = ucfirst($first_name); 
  $last_name = ucfirst($last_name);  
  $display_name = strtolower($first_name[0] . $last_name); //first initial of first name and the last name
  $email = $email_address;
  //$company = "Acme Corp"; //already defined
  $main_department_id = $department;
  $password = "12345";
  $last_logged = date("Y-m-d H:i:s");
  $start_date = date("Y-m-d");
  $separation_date = NULL;
  $is_active = "0";
  $require_password_reset = "0";
  $password_reset_token = NULL;
  $password_token_expiration = "2017-03-20 16:00:00";

  //initialization of $userObject is automatic
  
  $userObject->vars["username"] = $username;
  $userObject->vars["first_name"] = $first_name;
  $userObject->vars["last_name"] = $last_name;
  $userObject->vars["display_name"] = $display_name;
  $userObject->vars["email"] = $email;
  $userObject->vars["company"] = $company;
  $userObject->vars["main_department_id"] = $main_department_id;
  $userObject->vars["password"] = $password;
  $userObject->vars["last_logged"] = $last_logged;
  $userObject->vars["start_date"] = $start_date;
  $userObject->vars["separation_date"] = $separation_date;
  $userObject->vars["is_active"] = $is_active;
  $userObject->vars["require_password_reset"] = $require_password_reset;
  $userObject->vars["password_reset_token"] = $password_reset_token;
  $userObject->vars["password_token_expiration"] = $password_token_expiration;
  $userObject->vars["department"] = $department;
  $userObject->vars["accessLevel"] = $accessLevel;

  //check to make sure that this email address does not already exist in the user database
  $functionResult3 = getUserByEmail($userObject->vars["email"]);
  if($functionResult3 == NULL)
  {
    //check for a user by the user name
    $functionResult = getUserByName($userObject->vars["username"]);

    //if value == NULL then continue, else loop and try with a numeric value added
    $continueLoop = true;
    $i = 2; //start at 2, because 0 or 1 appended to a username might be confusing to users
    if($functionResult != NULL)
    {
      while($continueLoop == true)
      {
        $temporaryUserName = $userObject->vars["username"] . $i;
        $functionResult2 = getUserByName($temporaryUserName);
        if($debugging == 1)
        {
          echo("DEBUG: temporaryUserName = " . $temporaryUserName . "<br/>");
          echo("DEBUG: functionResult2 = ");
          echo(var_dump($functionResult2));
          echo("<br/>");
        }
        if($functionResult2 == NULL)
        {
          $userObject->vars["username"] = $temporaryUserName; //set the new user name
          $continueLoop = false; //break out of the loop  
        }
        $i++; //increment the counter
      }
    }

    $newRecordID = createUser($userObject);

    //email IT Admin to finish setting up the user
    $email_status = sendNewUserMessage($debugging, $userObject, $newRecordID); 

    //set a confirmation message to the user
    if($email_status == 1)
    {
      //email was sent
      $_SESSION["password_reset_message"] = "Thank you. Our Admin team was contacted to set up this user.";
    }
    else
    {
      //email was not sent
      $_SESSION["password_reset_message"] = "Uh oh! There was a problem setting up this user. Please contact Support.";
    }

    //log this action in the web analtics
    //create the page_values to send
    $a = array();
    //this is empty, because we are not passing any special values to Web Analytics
    $jsonStr = json_encode($a);
    //custom action
    $data = array(
      "token_id" => "987654321",
      "event_type" => "custom_action",
      "action_name" => "Processed New User Account Request web form",
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

    //return the user to the main page
    header('Location: ../../Controls/General/main.php'); //header to home page 
  } //if the email address already exists in the user database
  else 
  {
    if($debugging == 1)
    {
      echo("DEBUG: this email address already exists in the system.<br/>");
    }
    
    //set a message to the user
    $_SESSION["password_reset_message"] = "A user account already exists for this e-mail address.";
    
    //return the user to the home page
    header('Location: ../../Controls/General/main.php'); //header to home page 
  }
  
  } //if POST
  else
  {
    if($debugging == 1)
    {
      echo("DEBUG: POST variables were not received.<br/>");
    }
    
    //return the user to the home page without taking any actions

    header('Location: ../../Controls/General/main.php'); //header to home page 
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

//====================================================================== END PHP
?>