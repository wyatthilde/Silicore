<?php

/* * *****************************************************************************
 * File Name: samplerepeat.php
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-26-2017
 * Description: This script will read a sample and then create a copy in the database.
 * Notes: 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

//Set Debugging Options
$debugging = 1; //set this to 1 to see debugging output

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
require_once('../../Includes/qcfunctions.php'); //contains QC database query functions

$sampleObject = NULL;

//get the user ID
$userId = NULL;
if(isset($_GET['userId']))
{
  $userId = test_input($_GET['userId']);
}

$t=time(); //variable used for obtaining the current time
$date = date("Y-m-d", strtotime($dt));
$time = date("H:i", strtotime($dt));

$dateShort = substr(date("Ymd", strtotime($dt)), 0, 8); //shorten the date to an 8 digit integer
$dtShort = substr(date("YmdHi", strtotime($dt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins

//group the times recorded together based on when the measurements are performed
if ($time >= "23:15" || $time < "02:15") 
{ 
  $groupTime = "00:00:00";
} elseif ($time < "05:15") 
{
  $groupTime = "03:00:00";
} elseif ($time < "08:15") 
{
  $groupTime = "06:00:00";
} elseif ($time < "11:15") 
{
  $groupTime = "09:00:00";
} elseif ($time < "14:15") 
{
  $groupTime = "12:00:00";
} elseif ($time < "17:15") 
{
  $groupTime = "15:00:00";
} elseif ($time < "20:15") 
{
  $groupTime = "18:00:00";
} else 
{
  $groupTime = "21:00:00";
}

//get the sample ID
if(isset($_GET['sampleId']));
{
  $sampleId = test_input($_GET['sampleId']);

  if(strlen($sampleId > 0))
  {
    //read the sample record
    $sampleObject = getSampleById($sampleId);
    
    $argTestTypeId = "6";
    $argCompositeTypeId = $sampleObject->vars["compositeType"];
    $argSiteId = $sampleObject->vars["siteId"];
    $argPlantId = $sampleObject->vars["plantId"];
    $argLocationId = $sampleObject->vars["location"];
    $argDt = $sampleObject->vars["dt"];
    $argDate = $sampleObject->vars["date"];
    $argDateShort = $dateShort;
    $argDtShort = $dtShort;
    $argTime = $sampleObject->vars["time"];
    $argGroupTime = $groupTime;
    $labTech = $sampleObject->vars["labTech"];
    $sampler = $sampleObject->vars["sampler"];
    $operator = $sampleObject->vars["operator"];
    $argUserId = $userId;
      
    $repeatSampleId = NULL;
    
    //insert a duplicate sample record into the samples table
    $repeatSampleId = insertSample($argTestTypeId, $argCompositeTypeId, $argSiteId, $argPlantId, $argLocationId, $argDt, $argDate, $argDateShort, $argDtShort, $argTime, $argGroupTime, $labTech, $sampler, $operator, $argUserId);
    
    //insert a row into the qcfunctions table with both sample ID's.
    insertRepeatabiltySamplePair($sampleId, $repeatSampleId);
  }
}
//redirect the user to the Samples page
header('Location: ../../Controls/QC/samples.php');

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

