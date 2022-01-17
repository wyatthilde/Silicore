<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_thresholdupdate.php
 * Project: Silicore
 * Description: This script processes a request to update a QC threshold record. 
 * It then forwards the user back to the Threshold Maintenance page.
 * Notes:
 * 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/10/2017|mnutsch|KACE:19061 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

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

//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains QC database query functions

$allValuesPresent = 1;

if(isset($_GET['thresholdID']) && strlen($_GET['thresholdID']) > 0)
{
  //read the ID from REST
  $thresholdID = urldecode(test_input($_GET['thresholdID']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdScreen']) && strlen($_GET['thresholdScreen']) > 0)
{
  //read the ID from REST
  $thresholdScreen = urldecode(test_input($_GET['thresholdScreen']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdLocation']) && strlen($_GET['thresholdLocation']) > 0)
{
  //read the ID from REST
  $thresholdLocation = urldecode(test_input($_GET['thresholdLocation']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdLow']) && strlen($_GET['thresholdLow']) > 0)
{
  //read the ID from REST
  $thresholdLow = urldecode(test_input($_GET['thresholdLow']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdHigh']) && strlen($_GET['thresholdHigh']) > 0)
{
  //read the ID from REST
  $thresholdHigh = urldecode(test_input($_GET['thresholdHigh']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdIsActive']) && strlen($_GET['thresholdIsActive']) > 0)
{
  //read the ID from REST
  $thresholdIsActive = urldecode(test_input($_GET['thresholdIsActive']));
}
else
{
  $allValuesPresent = 0;
}

//if all of the inputs were received then, proceed
if($allValuesPresent == 1)
{
  $result = "";
  $result = updateThreshold($thresholdID, $thresholdScreen, $thresholdLocation, $thresholdLow, $thresholdHigh, $thresholdIsActive);
}

//redirect the user to the QC Threshold Maintenance page
header('Location: ../../Controls/QC/gb_thresholdmaint.php');

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

//========================================================================================== END PHP
?>

<!-- HTML -->