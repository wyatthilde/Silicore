<?php
/* * *****************************************************************************************************************************************
 * File Name: locationsselectbyplant.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/13/2017|mnutsch|KACE:17366 - Initial creation
 * 08/03/2017|mnutsch|KACE:17803 - Updated core sample filtering options.
 * 08/11/2017|mnutsch|KACE:17916 - Numerous updates.
 * 08/18/2017|mnutsch|KACE:17957 - Added read only Sample Locatoin and Date/Time fields at the top of the page.
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 *
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/tl_qcfunctions.php'); //contains functions related to QC

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



echo('<select id="locationId" name="locationId" class="form-control" disabled>');
echo('<option value=""></option>');

if(count($locationObjectArray) > 0)
{
    foreach ($locationObjectArray as $locationObject)
    {
        //echo($locationObject->vars["id"] . ",");

        if($locationObject->vars["id"] == $locationId)
        {
            echo "<option value='" . $locationObject->vars["id"] . "' selected='selected'>" . $locationObject->vars["description"] . "</option>";
        }
        else
        {
            echo "<option value='" . $locationObject->vars["id"] . "'>" . $locationObject->vars["description"] . "</option>";
        }

        $objectCounter++;
    }
}
else
{
    //There are no Locations listed for the selected Site.
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
