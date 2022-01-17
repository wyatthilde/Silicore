<?php
/* * *****************************************************************************************************************************************
 * File Name: locationsvoid.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/03/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once ('gb_qcfunctions.php');


$locationID = filter_input(INPUT_GET,'locationID',FILTER_SANITIZE_NUMBER_INT);
echo "Location ID: " . $locationID . "<br>";

$locationOrder = filter_input(INPUT_GET,'locationOrder');
//echo "Location Order: " . $locationOrder . "<br>";

$locationSiteID = filter_input(INPUT_GET,'locationSiteID');
//echo "Location Site ID: " . $locationSiteID . "<br>";

$locationSite = filter_input(INPUT_GET,'locationSite');
//echo "Location Site: " . $locationSite . "<br>";

$locationPlantID = filter_input(INPUT_GET,'locationPlantID');
//echo "Location Site ID: " . $locationPlantID . "<br>";

$locationPlant = filter_input(INPUT_GET,'locationPlant');
//echo "Location Plant: " . $locationPlant . "<br>";

$locationDescription = filter_input(INPUT_GET,'locationDescription');
//echo "Location Description: " . $locationDescription . "<br>";

$locationSplit = filter_input(INPUT_GET,'locationSplit');
//echo "Location Split: " . $locationSplit . "<br>";

$locationActive = filter_input(INPUT_GET,'locationActive');
//echo "Location Active: " . $locationActive . "<br>";


$mySQLConnection = connectToMySQLQC();

//========================================================================================== END PHP
?>

<!-- HTML -->