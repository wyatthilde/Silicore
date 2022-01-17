<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_sievestackaddprocess.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/04/2018|mnutsch|KACE:20158 - Initial creation
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

$validationMessage = ""; //text string explaining any validation errors.
$isValidationError = 0; //boolean to tell us if there is a problem

//checkIfEmpty($argValue, $argName)
//check if the value is an empty string
//set the validation message
//return 1 if validation fails.
function checkIfEmpty($argValue, $argName)
{
  //echo "argValue is " . $argValue . "<br/>";
  //echo "argName is " . $argName . "<br/>";
  if($argValue == "")
  {
    $validationMessage = $argName . " must be entered.";
    echo "Validation message is " . $validationMessage . "<br/>";
    return 1;
  }
  else if(strlen($argValue) == 0)
  {
    $validationMessage = $argName . " must be entered.";
    echo "Validation message is " . $validationMessage . "<br/>";
    return 1;
  }
  else
  {
    return 0;
  }
}

// begin the session
session_start();

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains database connection info

//read the input values from the form
$stackdescription = test_input($_POST['stackdescription']);
$siteid = test_input($_POST['siteid']);
$numberofsieves = test_input($_POST['numberofsieves']);
$screensize1 = test_input($_POST['screensize1']);
$startweight1 = test_input($_POST['startweight1']);
$screensize2 = test_input($_POST['screensize2']);
$startweight2 = test_input($_POST['startweight2']);
$screensize3 = test_input($_POST['screensize3']);
$startweight3 = test_input($_POST['startweight3']);
$screensize4 = test_input($_POST['screensize4']);
$startweight4 = test_input($_POST['startweight4']);
$screensize5 = test_input($_POST['screensize5']);
$startweight5 = test_input($_POST['startweight5']);
$screensize6 = test_input($_POST['screensize6']);
$startweight6 = test_input($_POST['startweight6']);
$screensize7 = test_input($_POST['screensize7']);
$startweight7 = test_input($_POST['startweight7']);
$screensize8 = test_input($_POST['screensize8']);
$startweight8 = test_input($_POST['startweight8']);
$screensize9 = test_input($_POST['screensize9']);
$startweight9 = test_input($_POST['startweight9']);
$screensize10 = test_input($_POST['screensize10']);
$startweight10 = test_input($_POST['startweight10']);

$userId = 0; //dev note: replace this with the correct user id
$iscamsizer = 0; //dev note: replace this with the correct value

if($debugging == 1)
{
	
  echo "finished reading form input.<br/><br/>";

  echo "stackdescription = " . $stackdescription . "<br/>";
	echo "siteid = " . $siteid . "<br/>";
  echo "numberofsieves = " . $numberofsieves . "<br/>";
  echo "screensizes" . "<br/>";
  echo $screensize1 . "<br/>";
  echo $screensize2 . "<br/>";
  echo $screensize3 . "<br/>";
  echo $screensize4 . "<br/>";
  echo $screensize5 . "<br/>";
  echo $screensize6 . "<br/>";
  echo $screensize7 . "<br/>";
  echo $screensize8 . "<br/>";
  echo $screensize9 . "<br/>";
  echo $screensize10 . "<br/>";
  echo "starting weights" . "<br/>";
  echo $startweight1 . "<br/>";
  echo $startweight2 . "<br/>";
  echo $startweight3 . "<br/>";
  echo $startweight4 . "<br/>";
  echo $startweight5 . "<br/>";
  echo $startweight6 . "<br/>";
  echo $startweight7 . "<br/>";
  echo $startweight8 . "<br/>";
  echo $startweight9 . "<br/>";
  echo $startweight10 . "<br/>";
  echo "User id = " . $userid . "<br/>";
  echo "Is Camsizer = " . $iscamsizer . "<br/>";
}

$result = insertNewSieveStack($debugging, $stackdescription, $siteid, $numberofsieves, $iscamsizer, $screensize1, $startweight1, $screensize2, $startweight2, $screensize3, $startweight3, $screensize4, $startweight4, $screensize5, $startweight5, $screensize6, $startweight6, $screensize7, $startweight7, $screensize8, $startweight8, $screensize9, $startweight9, $screensize10, $startweight10, $userId);

if($debugging)
{
  echo "Finished adding QC sieve stack and sieves group.";
}	
 
//redirect the user to the Sieve Tracking page
header('Location: ../../Controls/QC/wt_sievetracking.php');

/***************************************
* Name: function test_input($data) 
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
****************************************/
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 
 
?>