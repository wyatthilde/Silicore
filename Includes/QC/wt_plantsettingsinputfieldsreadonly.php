<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_plantsettingsinputfieldsreadonly.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/04/2018|mnutsch|KACE:20158 - Initial creation
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains functions related to QC

$plantId = NULL;
$sampleId = 0;
$plcArray = NULL;
$objectCounter = 0;
$tagObject = "";

//read the input values from the form
if(isset($_GET['plantId']))
{
  $plantId = test_input($_GET['plantId']);
}
if(isset($_GET['sampleId']))
{
  $sampleId = test_input($_GET['sampleId']);
}

//get the sample details
if(strlen($plantId)!=0)
{
  $plcArray = getPLCTagsByPlantID($plantId);
}

if(count($plcArray) > 0)
{
  foreach ($plcArray as $plcObject) 
  {
    //check for a value in the database
    $tagObject = "";
    $tagObject = getPlantSettingsDataByTagAndSampleId($plcObject->vars["id"], $sampleId);
    
    echo('<div class="form-group">');
    echo('<label for="plc' . $objectCounter . '" class="plant_settings_label">' . $plcObject->vars["device"] . ':</label>');
    if($tagObject != NULL)
    {
      echo('<input type="text" id="plc' . $objectCounter . '" name="plc[]" value="' . $tagObject->vars['value'] . '" disabled />');
    }
    else
    {
      echo('<input type="text" id="plc' . $objectCounter . '" name="plc[]" value="" disabled />');
    }
    echo($plcObject->vars["units"]);
    echo('<br/>');
    echo('</div>');
    $objectCounter++;
  }
}
else
{
  echo("There are no PLC devices listed for the selected Plant.");
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
 
//====================================================================== END PHP

?>