<?php

/* * *****************************************************************************
 * File Name: locationcheckwetweightsfor.php
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-2-2017
 * Description: This file accepts a location ID and then 
 * returns a 1 or a 0 (true or false) to tell us if that location has wet weights.
 * Notes: This gets called by sampleedit.php
 * **************************************************************************** */

//==================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains database connection info

 //Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled</strong><br/>";  
}

//read the input values from the form
$locationId = test_input($_GET['locationId']);

//get the sample details
if(strlen($locationId)!=0)
{
  $locationObject = getLocationById($locationId);
}

echo $locationObject->vars["is_split_sample_only"];

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