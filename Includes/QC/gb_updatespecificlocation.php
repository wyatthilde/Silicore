<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_updatespecificlocation.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/24/2018|ktaylor|KACE:xxxxx - Initial creation
 * 
 * **************************************************************************************************************************************** */

require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/QC/gb_qcfunctions.php');

//======================================================================================== BEGIN PHP


 $mySQLConnection = connectToMySQLQC(); // Connect to the database.

$id = $_GET['specificLocationId'];
$locationId = $_GET['locationId'];
$order = $_GET['orderTextbox'];
$name = trim($mySQLConnection->real_escape_string($_GET['name']));
$name = htmlspecialchars($name);
$isActive = $_GET['isActiveSelect'];
$sql = "CALL `sp_gb_qc_LocationDetailsUpdate`($id, '$locationId', '$name', '$order', $isActive, $user_id);"; // Updates edited location from gb_qc_locations table.



$result = $mySQLConnection->query($sql);
    
disconnectFromMySQLQC($mySQLConnection); // Disconnect from the database.

echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/gb_managespecificlocations.php\";</script>"; // Using JS, because output is already sent in header.php...

//========================================================================================== END PHP
?>

<!-- HTML -->