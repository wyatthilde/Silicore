<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_addspecificlocation.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/24/2018|ktaylor|KACE:xxxxx - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');



$mySQLConnection = connectToMySQLQC(); // Connect to the database.

$description = trim($mySQLConnection->real_escape_string($_GET['description']));
$description = htmlspecialchars($description);
//echo "Description: " . $description . ", ";
$main_site_id = $_GET['siteSelect'];
//echo "Site: " . $main_site_id . ", ";
$main_plant_id = $_GET['plantSelect'];
//echo "Plant: " . $main_plant_id . ", ";
$is_split_sample_only = $_GET['splitSampleOnlySelect'];
//echo "Split Only: " . $is_split_sample_only . ", ";

$sql = "CALL sp_tl_qc_LocationInsert('$description', $main_site_id, $main_plant_id, $is_split_sample_only, $user_id);"; // Inserts new location into gb_qc_locations table.

$result = $mySQLConnection->query($sql);

disconnectFromMySQLQC($mySQLConnection); // Disconnect from database.

echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/tl_samplelocations.php\";</script>"; // Using JS, because output is already sent in header.php...














//========================================================================================== END PHP
?>

<!-- HTML -->

