<?php

/*******************************************************************************************************************************************
 * File Name: sign_out.php
 * Project: Silicore
 * Description: This signs the user out of the system
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 03/07/2017|mnutsch|KACE:xxxxx - Initial creation
 * 09/14/2017|mnutsch|KACE:17959 - Updated clearing of cookies.
 * 
 ******************************************************************************************************************************************/

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

//debug, check the session
$user_id = "";
if(isset($_SESSION["user_id"]))
{
  $user_id = filter_var($_SESSION["user_id"], FILTER_SANITIZE_STRING);
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

//clear the cookie
//deleting cookies by setting expiration to past time
if (isset($_COOKIE['user_id'])) 
  {
    unset($_COOKIE['user_id']);
    $res = setcookie('user_id', '', time() - 3600);
}
if (isset($_COOKIE['password_hash'])) 
  {
    unset($_COOKIE['password_hash']);
    $res = setcookie('password_hash', '', time() - 3600);
}

//clear the session variables
session_unset(); 
session_destroy(); 

if($debugging == 1)
{
  echo "The user is signed out";
}

//debug, check the session
$user_id = "";
if(isset($_SESSION["user_id"]))
{
  $user_id = filter_var($_SESSION["user_id"], FILTER_SANITIZE_STRING);
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

//redirect the user to the home page
header('Location: ../../Controls/General/main.php');
?>