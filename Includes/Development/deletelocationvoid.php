<?php
/* * *****************************************************************************************************************************************
 * File Name: deletelocationvoid.php
 * Project: smashbox
 * Description: file that calls the sproc to do the deleltion for deleletelocation.php
 * Notes:
 * =========================================================================================================================================
 * Change Log ([08/06/2018]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/06/2018|ktaylor|KACE:24650 - Initial creation
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
	  
	// Create connection.
	$mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);
	  
	// Check connection.
	if ($mySQLConnection->connect_error) 
	{
	  $errorMessage = $errorMessage . "Error connecting to the MySQL database";
          $errorMessage = $errorMessage . " \nPageName == " . $PageName . " \nFullPath == " . $FullPath;
          
	  sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
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
    sendErrorMessage($debugging, $errorMessage); // Requires emailfunctions.php
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
    sendErrorMessage($debugging, $errorMessage); // Requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
}

//======================================================================================== BEGIN PHP

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
{
  echo "The current Linux user is: ";
  echo exec('whoami');
  echo "<br/>";
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled</strong><br/>";  
  echo "Start time: ";
  echo(date("Y-m-d H:i:s",$t));
  echo "<br/>";
}

 

if(isset($_GET['locationID']) && ($_GET['Site'] == 'Granbury'))
{
  $id=$_GET['locationID'];
  $mySQLConnection = connectToMySQLQC(); // Connect to the database.
  $sql = "CALL sp_gb_qc_LocationsDelete($id)";
  $result = $mySQLConnection->query($sql); // Stored procedure method to get sites.
}
if(isset($_GET['locationID']) && ($_GET['Site'] == 'Tolar'))
{
  $id=$_GET['locationID'];
  $mySQLConnection = connectToMySQLQC(); // Connect to the database.
  $sql = "CALL sp_tl_qc_LocationsDelete($id)";
  $result = $mySQLConnection->query($sql); // Stored procedure method to get sites.
}
if(isset($_GET['locationID']) && ($_GET['Site'] == 'West Texas'))
{
  $id=$_GET['locationID'];
  $mySQLConnection = connectToMySQLQC(); // Connect to the database.
  $sql = "CALL sp_wt_qc_LocationsDelete($id)";
  $result = $mySQLConnection->query($sql); // Stored procedure method to get sites.
}




//redirect the user to the Development delete location page
header('Location: ../../Controls/Development/deletelocation.php');

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