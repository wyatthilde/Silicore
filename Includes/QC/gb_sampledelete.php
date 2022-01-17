<?php
/* * *****************************************************************************
 * File Name: sampledelete.php
 * Project: Silicore
 * Author: mnutsch
 * Date Created: 5-17-2017
 * Description: 
 * Notes: 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

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

//get the sample ID
if(isset($_GET['sampleId']));
{
  $sampleId = test_input($_GET['sampleId']);

  if(strlen($sampleId > 0))
  {
    //delete the sample
    $result = deleteSample($sampleId);
  }
}
//redirect the user to the Samples page
header('Location: ../../Controls/QC/gb_samples.php');

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

//====================================================================== END PHP
?>

<!-- HTML -->



