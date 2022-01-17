<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_thresholdadd.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/04/2018|mnutsch|KACE:20158 - Initial creation
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
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains QC database query functions

$allValuesPresent = 1;

if(isset($_GET['screenNew']) && strlen($_GET['screenNew']) > 0)
{
  //read the ID from REST
  $thresholdScreen = urldecode(test_input($_GET['screenNew']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['locationNew']) && strlen($_GET['locationNew']) > 0)
{
  //read the ID from REST
  $thresholdLocation = urldecode(test_input($_GET['locationNew']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['lowThresholdNew']) && strlen($_GET['lowThresholdNew']) > 0)
{
  //read the ID from REST
  $thresholdLow = urldecode(test_input($_GET['lowThresholdNew']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['highThresholdNew']) && strlen($_GET['highThresholdNew']) > 0)
{
  //read the ID from REST
  $thresholdHigh = urldecode(test_input($_GET['highThresholdNew']));
}
else
{
  $allValuesPresent = 0;
}

//if all of the inputs were received then, proceed
if($allValuesPresent == 1)
{
  $result = "";
  $result = insertQCThreshold($thresholdScreen, $thresholdLocation, $thresholdLow, $thresholdHigh, 1);
}

//redirect the user to the QC Threshold Maintenance page
header('Location: ../../Controls/QC/wt_thresholdmaint.php');

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