<?php
/* * *****************************************************************************************************************************************
 * File Name: addlocation.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/10/2018|zthale|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */

require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/QC/gb_qcfunctions.php');

//======================================================================================== BEGIN PHP



$mySQLConnection = connectToMySQLQC(); // Connect to the database.

$name = trim($mySQLConnection->real_escape_string($_GET['name']));
$name = htmlspecialchars($name);
$main_site_id = $_GET['siteSelect'];
$location_id = $_GET['locationSelect'];
if($main_site_id == 10)
{
    $sql = "CALL sp_gb_qc_LocationDetailsInsert('$location_id', '$name',  '$user_id');"; // Inserts new location into gb_qc_locations table.

    $result = $mySQLConnection->query($sql);
    disconnectFromMySQLQC($mySQLConnection); // Disconnect from database.
    echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/gb_managespecificlocations.php\";</script>"; // Using JS, because output is already sent in header.php...
}
elseif($main_site_id == 50)
{
    $sql = "CALL sp_tl_qc_LocationDetailsInsert('$location_id', '$name',  '$user_id');"; // Inserts new location into gb_qc_locations table.

    $result = $mySQLConnection->query($sql);
    disconnectFromMySQLQC($mySQLConnection); // Disconnect from database.
   echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/tl_managespecificlocations.php\";</script>"; // Using JS, because output is already sent in header.php...
}
elseif($main_site_id == 60)
{
    $sql = "CALL sp_wt_qc_LocationDetailsInsert('$location_id', '$name',  '$user_id');"; // Inserts new location into gb_qc_locations table.

    $result = $mySQLConnection->query($sql);
    disconnectFromMySQLQC($mySQLConnection); // Disconnect from database.
    echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/wt_managespecificlocations.php\";</script>"; // Using JS, because output is already sent in header.php...
}
else
    {
        echo "Error adding specific location.";
    }

//========================================================================================== END PHP
?>

