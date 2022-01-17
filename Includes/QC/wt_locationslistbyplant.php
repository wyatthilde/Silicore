<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_locationslistbyplant.php
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

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains functions related to QC

$locationId = NULL;
$plantId = NULL;
$locationObjectArray  = NULL;
$objectCounter = 0;
$locationObject = NULL;

//read the input values from the form
if(isset($_GET['locationId'])) //used if there should be an option already selected
{
  $locationId = test_input($_GET['locationId']);
}
if(isset($_GET['plantId'])) //used to filter the list during the MySQL query
{
  $plantId = test_input($_GET['plantId']);
}

//get the location details as an array
if(strlen($plantId)!=0)
{
  $locationObjectArray = getLocationsByPlant($plantId);
}

if(count($locationObjectArray) > 0)
{
  foreach ($locationObjectArray as $locationObject) 
  {
    echo($locationObject->vars["id"] . ",");

    $objectCounter++;
  }
}
else
{
  //There are no Locations listed for the selected Site.
}

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
