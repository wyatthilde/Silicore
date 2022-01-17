<?php
/* * *****************************************************************************************************************************************
 * File Name: specificlocationsselectbylocation.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/13/2017|mnutsch|KACE:17366 - Initial creation
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 *
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains functions related to QC

$locationId = NULL;
$specificLocationId = NULL;
$specificLocationObjectArray  = NULL;
$objectCounter = 0;
$specificLocationObject = NULL;

//read the input values from the form
if(isset($_GET['locationId'])) //used to filter the list during the MySQL query
{
    $locationId = test_input($_GET['locationId']);
}
if(isset($_GET['specificLocationId'])) //used if there should be an option already selected
{
    $specificLocationId = test_input($_GET['specificLocationId']);
}

//get the specific location details as an array
if(strlen($locationId)!=0)
{
    $specificLocationObjectArray = getSpecificLocationsByLocation($locationId);
}



echo('<select id="specificLocationId" class="form-control" name="specificLocationId" disabled>');
echo('<option value=""></option>');

if(count($specificLocationObjectArray) > 0)
{
    foreach ($specificLocationObjectArray as $specificLocationObject)
    {
        if($specificLocationObject->vars["id"] == $specificLocationId)
        {
            echo "<option value='" . $specificLocationObject->vars["id"] . "' selected='selected'>" . $specificLocationObject->vars["description"] . "</option>";
        }
        else
        {
            echo "<option value='" . $specificLocationObject->vars["id"] . "'>" . $specificLocationObject->vars["description"] . "</option>";
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
