
<?php
//gndede added a line to avoid the page from spitting errors - 04/27/2018.
ob_start();
/* * *****************************************************************************
 * File Name: sign_in.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Mar 7, 2017
 * Edited 3-16-2017
 * Description: This signs the user into the system
 * Notes: 
 * **************************************************************************** */

//include other files
include_once('../../Includes/security.php'); //functions for interacting with the user table
include_once('../../Includes/webanalyticshelper.php'); //function for posting PHP with CURL

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

if($debugging == 1)
{
  echo "<br/>";
  echo "The user_id is: " . $user_id;
  echo "<br/>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if($debugging == 1)
  {
    echo "The form was submitted.<br/>";
  }
  
  //get values from the web form
  //sanitize the user input
  $username_input = test_input($_POST["user_name"]);
  $password_input = test_input($_POST["password"]);
  $remember_me_input = test_input($_POST["remember_me"]);

  if($debugging == 1)
  {
    echo "The username input was: " . $username_input . "<br/>";
    echo "The password input was: " . $password_input . "<br/>";
    echo "The remember me input was: " . $remember_me_input . "<br/>";
  }
  
  //check the database for the username
  //$mySQLConn = connectToMySQL(); //connect to mysql, requires security.php
  
  if($debugging == 1)
  {
    echo "Querying Database for the username..";
  }
  $singleUserObject = getUserByName($username_input); //output details on a user, requires security.php
  
  if($debugging == 1)
  {
    echoUserData($singleUserObject); //requires security.php
  }
	
  //check the password
  $hashedPassword = $singleUserObject->vars["password"];
  if($debugging == 1)
  {
    echo "This user's hashed password, read from the database is:<br/>";
    echo $hashedPassword;
    echo "<br/>";
  }
  
  //check the password
  if($debugging == 1)
  {
    echo "Comparing to password input: " . $password_input . "<br/>";
  }
  $isPasswordCorrect = password_verify($password_input, $hashedPassword);
  //echo "The value of is password correct is " . $isPasswordCorrect . "<br/>";
  
  //check if the user is flagged "is active" in the database
  $is_active = $singleUserObject->vars["is_active"];

  //interpret the response
  if(($isPasswordCorrect == 1) && ($is_active == 1))  //if authorized, 
  {
    if($debugging == 1)
    {
      echo "The password is correct! :)<br/>";
    }
    
    //then set the session variables
    $user_id = $singleUserObject->vars["id"];
    $_SESSION["user_id"] = $user_id;
    
    if($debugging == 1)
    {
      echo "<br/>";
      echo "The user_id is: " . $user_id;
      echo "<br/>";
	  
	  echo "The remember_me_input = " . $remember_me_input . "<br/>";
    }

    //update the last_logged field in the database for this user   
    $date = new DateTime();
    $singleUserObject->vars["last_logged"] = $date->format("Y-m-d H:i:s");
    $singleUserObject->vars["password_token_expiration"] = $date->format("Y-m-d H:i:s");
    //echo "the datetime is " . $singleUserObject->vars["password_token_expiration"];
    $updateResult = updateUser($singleUserObject);
    //echo "update result is " . $updateResult;
    
    //if the user checked Remember Me, then set a cookie to keep them logged in
    if($remember_me_input == "on")
    {
      //cookie functionality based on example at: http://www.voidtricks.com/add-remember-me-php/

      //set the user ID cookie
      $cookie_name = "user_id";
      $cookie_value = $user_id;
      //expiriry time. 86400 = 1 day (86400*30 = 1 month)
      $expiry = time() + (86400 * 30);
      //sets the cookie variable
      setcookie($cookie_name, $cookie_value, $expiry);
      //check that the cookie was set
      if($debugging == 1)
      {
        echo "<br/>User Cookie = " . $_COOKIE['user_id'];
      }

      //set the password cookie
      $cookie_name = "password_hash";
      $cookie_value = $hashedPassword;
      //expiriry time. 86400 = 1 day (86400*30 = 1 month)
      $expiry = time() + (86400 * 30);
      //sets the cookie variable
      setcookie($cookie_name, $cookie_value, $expiry);
      //check that the cookie was set
      if($debugging == 1)
      {
        echo "<br/>Password Cookie = " . $_COOKIE['password_hash'];
      }

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
      "action_name" => "Reset_a_user_password",
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
    
	//if password reset is required, then redirect the user to the password reset page
	if($singleUserObject->vars["require_password_reset"] == "1")
	{
          //set the session variable
          $_SESSION["signin_password_reset"] = true;
          
          //send the user back to the main page
	  header('Location: ../../Controls/General/main.php'); //header to home page
	}
	else //else redirect the user to the home page
	{
          header('Location: ../../Controls/General/main.php'); //header to home page
	}
  }
  else if($is_active != 1) //if not authorized due to inactive account 
  {
    $_SESSION["signin_error_message"] = "This user account is disabled. Please contact your system administrator.<br/>";//then display an message to the user
    $_SESSION["signin_wrong_username"] = $username_input;
    $_SESSION["signin_wrong_password"] = $password_input;
    header('Location: ../../Controls/General/main.php'); //header to home page    
  }
  
  else //if not authorized due to wrong username or password
  {
    $_SESSION["signin_error_message"] = "That username and password combination is wrong. Please check the info and try again.<br/>";//then display an message to the user
    $_SESSION["signin_wrong_username"] = $username_input;
    $_SESSION["signin_wrong_password"] = $password_input;
    header('Location: ../../Controls/General/main.php'); //header to home page
  }
      
}
else //if nothing was entered
{
  if($debugging == 1)
  {
    echo "The form was not submitted<br/>";
  }
  
  $_SESSION["signin_error_message"] = "User Input was not received. Please try again."; //then display an message to the user
  $_SESSION["signin_wrong_username"] = "";
  $_SESSION["signin_wrong_password"] = "";
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
	
?>