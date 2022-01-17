<?php
/* * *****************************************************************************************************************************************
 * File Name: sievestackselectbysite.php
 * Project: Silicore
 * Description: This script will receive a site id and a sieve stack ID
 * It will then echo an HTML select element showing options for sieve stacks with that site.
 * If the sieve stack ID is not null and is one of the options, then that option will default as selected.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/01/2017|mnutsch|KACE:17717 - Initial creation
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains functions related to QC<?php
require_once('../../Includes/Security/database.php');

$db = new Database();

$siteID = NULL;
$sieveStackID = NULL;
$sieveStackObjectArray = NULL;
$objectCounter = 0;
$sieveStackObject = NULL;

//read the input value from REST
if(isset($_GET['siteID'])) //used to filter the list during the MySQL query
{
  $siteID = test_input($_GET['siteID']);
}

if(isset($_GET['sieveStackID'])) //used to filter the list during the MySQL query
{
  $sieveStackID = test_input($_GET['sieveStackID']);
}

//get the specific location details as an array
if(strlen($siteID)!=0)
{
  $sieveStackObjectArray = getSieveStacksBySiteID($siteID); 
}

echo('<select class="form-control" id="sieveStackId" name="sieveStackId" onChange="getSieves()">');
echo('<option value=""></option>');

$query = 'sp_gb_qc_SieveStackGetByID("' . $sieveStackID . '")';
$stackObject = json_decode($db->get($query));

if($stackObject[0]->is_active == 0) {
    echo "<option value='" . $stackObject[0]->id . "' selected='selected'>" . $stackObject[0]->description . "</option>";
    if(count($sieveStackObjectArray) > 0)
    {
        foreach ($sieveStackObjectArray as $sieveStackObject)
        {
          echo "<option value='" . $sieveStackObject->vars["id"] . "'>" . $sieveStackObject->vars["description"] . "</option>";
          $objectCounter++;
        }
    }
    else
    {
        //There are no Locations listed for the selected Site.
    }
} else {
    if(count($sieveStackObjectArray) > 0)
    {
        foreach ($sieveStackObjectArray as $sieveStackObject)
        {
            if($sieveStackObject->vars["id"] == $sieveStackID)
            {
                echo "<option value='" . $sieveStackObject->vars["id"] . "' selected='selected'>" . $sieveStackObject->vars["description"] . "</option>";
            }
            else
            {
                echo "<option value='" . $sieveStackObject->vars["id"] . "'>" . $sieveStackObject->vars["description"] . "</option>";
            }

            $objectCounter++;
        }
    }
    else
    {
        //There are no Locations listed for the selected Site.
    }
}



echo('</select>');
echo('<br/></div>');

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
