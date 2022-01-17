<?php
/* * *****************************************************************************************************************************************
 * File Name: plantsselectbysite.php
 * Project: Silicore
 * Description: This file will load a dynamic list of html select options for Plants based on Site ID.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/13/2017|mnutsch|KACE:17366 - Initial creation
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 09/29/2017|mnutsch|KACE:17957 - Added a JavaScript function call.
 * 
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains functions related to QC

$siteId = NULL;
$plantId = NULL;
$plantObjectArray  = NULL;
$objectCounter = 0;
$plantObject = "";

//read the input values from the form
if(isset($_GET['siteId'])) //used to filter the list during the MySQL query
{
    $siteId = test_input($_GET['siteId']);
}
if(isset($_GET['plantId'])) //used if there should be an option already selected
{
    $plantId = test_input($_GET['plantId']);
}

//get the plant details as an array
if(strlen($siteId)!=0)
{
    $plantObjectArray = getPlantsBySite($siteId);
}

echo('<label for="plantId">Plant:</label>');
echo('<select name="plantId" id="plantId" class="form-control" required onchange="loadLocationSelect(); clearSampleLocationCheckboxes();">');
echo('<option value=""></option>');

if(count($plantObjectArray) > 0)
{
    foreach ($plantObjectArray as $plantObject)
    {
        if($plantObject->vars["id"] == $plantId)
        {
            echo "<option value='" . $plantObject->vars["id"] . "' selected='selected'>" . $plantObject->vars["description"] . "</option>";
        }
        else
        {
            echo "<option value='" . $plantObject->vars["id"] . "'>" . $plantObject->vars["description"] . "</option>";
        }

        $objectCounter++;
    }
}
else
{
    //There are no Plants listed for the selected Site.
}

echo('</select>');


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