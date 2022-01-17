<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_updatelocation.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2018|zthale|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */

require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');

//======================================================================================== BEGIN PHP

// Connect to MySQL database.
 function connectToMySQLQC()
{
  $errorMessage = "Page: QC functionality - connectToMySQLQC() - "; 
  
  global $PageName;
  global $FullPath;
  
  try
  {
	$mySQLConnection = 0; // Used to track if the database is connected.
	
	$mysql_dbname = SANDBOX_DB_DBNAME001; //sandbox
	$mysql_username = SANDBOX_DB_USER;
	$mysql_pw = SANDBOX_DB_PWD;
	$mysql_hostname = SANDBOX_DB_HOST;
	  
	// Create connection
	$mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);
	  
	// Check connection
	if ($mySQLConnection->connect_error) 
	{
	  $errorMessage = $errorMessage . "Error connecting to the MySQL database";
          $errorMessage = $errorMessage . " \nPageName == " . $PageName . " \nFullPath == " . $FullPath;
          
	  sendErrorMessage($debugging, $errorMessage); // Requires emailfunctions.php
	  if($debugging == 1)
	  {
	    echo $errorMessage;
	  }
	  //echo "Error connecting to MySQL: <br>" . $mySQLConnection->error;
	  
	  return 0;
	}
	else
	{
	  return $mySQLConnection;
	}
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the MySQL database";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
    return 0;
  }
}

// Disconnect from MySQL database.
function disconnectFromMySQLQC($mySQLConnection)
{
  $errorMessage = "Page: QC functionality"; 
  try
  {	
    $mySQLConnection->close();
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error disconnecting to the MySQL database.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
}

 $mySQLConnection = connectToMySQLQC(); // Connect to the database.
 
 $id = $_GET['locationID'];
//echo "ID: " . $id . ", ";

$order = $_GET['orderTextbox'];
//echo "Order: " . $order . ", ";

$main_site_id = $_GET['siteSelect'];
//echo "Site: " . $main_site_id . ", ";

$main_plant_id = $_GET['plantSelect'];
//echo "Plant: " . $main_plant_id . ", ";

$description = trim($mySQLConnection->real_escape_string($_GET['description']));
$description = htmlspecialchars($description);
//echo "Description: " . $description . ", ";

$is_split_sample_only = $_GET['splitSampleOnlySelect'];
//echo "Split Only: " . $is_split_sample_only . ", ";

$isActive = $_GET['isActiveSelect'];
//echo "Is Active: " . $isActive . ", ";
  
$sql = "CALL sp_wt_qc_LocationsUpdate($id, '$description', $main_site_id, $main_plant_id, $is_split_sample_only, $order, $isActive, $user_id);"; // Updates edited location from wt_qc_locations table.

$result = $mySQLConnection->query($sql);
    
disconnectFromMySQLQC($mySQLConnection); // Disconnect from the database.

echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/wt_managelocations.php\";</script>"; // Using JS, because output is already sent in header.php...

//========================================================================================== END PHP
?>

<!-- HTML -->