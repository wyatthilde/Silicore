
<?php
/* * *****************************************************************************************************************************************
 * File Name: plantsettingsinputfields.php
 * Project: Silicore
 * Description: This file will load a dynamic list of form input fields related to PLC devices.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/11/2017|mnutsch|KACE:17366 - Initial creation
 * 08/02/2017|mnutsch|KACE:17366 - Modified a function call.
 * 08/02/2017|mnutsch|KACE:17957 - Added HTML5 input validation to Plant Settings fields.
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 10/11/2017|mnutsch|KACE:17986 - Updated CSS for Plant Settings fields.
 *
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains functions related to QC

$plantId = NULL;
$sampleId = 0;
$plcArray = NULL;
$objectCounter = 0;
$divCounter = 0;
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



        if($tagObject != NULL)
        {
            echo('<div class="form-group col-lg-4">');
            echo('<label for="plc' . $objectCounter . '" class="plant_settings_label">' . $plcObject->vars["device"] . ':</label>');
            echo('<div class="input-group">');
            echo('<input type="number" class="form-control" step="0.0001" max="99999" id="plc' . $objectCounter . '" name="plc[]" value="' . $tagObject->vars['value'] . '" / disabled>');
            echo('<div class="input-group-append"><span class="input-group-text">' . $plcObject->vars["units"] . '</span></div>');
            echo('</div>');
            echo('</div>');
        }
        else
        {
            if($divCounter !== 4)
            {
                echo('<div class="form-group col-lg-4">');
                echo('<label for="plc' . $objectCounter . '" class="plant_settings_label">' . $plcObject->vars["device"] . ':</label>');
                echo('<div class="input-group">');
                echo('<input type="number" class="form-control" step="0.0001" max="99999" id="plc' . $objectCounter . '" name="plc[]" value="" / disabled>');
                echo('<div class="input-group-append"><span class="input-group-text">' . $plcObject->vars["units"] . '</span></div>');
                echo('</div>');
                echo('</div>');
            }
            else
            {

                echo('<div class="form-group col-lg-4">');
                echo('<label for="plc' . $objectCounter . '" class="plant_settings_label">' . $plcObject->vars["device"] . ':</label>');
                echo('<div class="input-group">');
                echo('<input type="number" class="form-control" step="0.0001" max="99999" id="plc' . $objectCounter . '" name="plc[]" value="" / disabled>');
                echo('<div class="input-group-append"><span class="input-group-text">' . $plcObject->vars["units"] . '</span></div>');
                echo('</div>');
                echo('</div>');

            }

        }



        $objectCounter++;
        $divCounter++;
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