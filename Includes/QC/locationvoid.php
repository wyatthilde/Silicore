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


$id = filter_input(INPUT_GET,'locationID',FILTER_SANITIZE_NUMBER_INT);
//echo "Location ID: " . $locationID . "<br>";

$order = filter_input(INPUT_GET,'locationOrder',FILTER_SANITIZE_NUMBER_INT);
//echo "Location Order: " . $locationOrder . "<br>";

$main_site_id = filter_input(INPUT_GET,'locationSiteID',FILTER_SANITIZE_NUMBER_INT);
//echo "Location Site ID: " . $locationSiteID . "<br>";

$locationSite = filter_input(INPUT_GET,'locationSite',FILTER_SANITIZE_STRING);
//echo "Location Site: " . $locationSite . "<br>";

$main_plant_id = filter_input(INPUT_GET,'locationPlantID',FILTER_SANITIZE_NUMBER_INT);
//echo "Location Site ID: " . $locationPlantID . "<br>";

$locationPlant = filter_input(INPUT_GET,'locationPlant',FILTER_SANITIZE_STRING);
//echo "Location Plant: " . $locationPlant . "<br>";

$description = filter_input(INPUT_GET,'locationDescription',FILTER_SANITIZE_STRING);
//echo "Location Description: " . $locationDescription . "<br>";

$is_split_sample_only = filter_input(INPUT_GET,'locationSplit',FILTER_SANITIZE_NUMBER_INT);
//echo "Location Split: " . $locationSplit . "<br>";

$isActive = filter_input(INPUT_GET,'locationActive',FILTER_SANITIZE_NUMBER_INT);
//echo "Location Active: " . $locationActive . "<br>";

$user_id = $_SESSION['user_id'];

$site = filter_input(INPUT_GET,'siteCode',FILTER_SANITIZE_STRING);

$mySQLConnection = connectToMySQLQC();
 $sql = "CALL sp_". $site ."_qc_LocationsUpdate($id, '$description', $main_site_id, $main_plant_id, $is_split_sample_only, $order, $isActive, $user_id);"; // Updates edited location from gb_qc_locations table.
echo $sql;
$mySQLConnection->query($sql);

echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/". $site."_managelocations_1.php\";</script>";
//========================================================================================== END PHP
?>

<!-- HTML -->