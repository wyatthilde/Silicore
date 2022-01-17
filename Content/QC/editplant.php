<?php
/* * *****************************************************************************************************************************************
 * File Name: editplant.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/20/2018|zthale|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */

require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');

//======================================================================================== BEGIN PHP

$plantID = $_GET['plantID'];
//echo "plantID: " . $plantID . "<br>";

$plantOrder = $_GET['plantOrder'];
//echo "Plant Order: " . $plantOrder . "<br>";

$plantSiteID = $_GET['siteID'];
//echo "Plant Site ID: " . $plantSiteID . "<br>";

$plantSite = $_GET['plantSite'];
//echo "Plant Site: " . $plantSite . "<br>";

$plantName = $_GET['plantName'];
//echo "Plant Name: " . $plantName . "<br>";

$plantActive = $_GET['plantActive'];
//echo "Plant Active: " . $plantActive . "<br>";



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

// Returns an array of sites.
function getSites()
{
  $errorMessage = "function getSites(): "; 
  $arrayOfSites = NULL;
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
    $mySQLConnection = connectToMySQLQC(); // Connect to the database.
  
    $result = $mySQLConnection->query("CALL sp_GetSites();"); // Stored procedure method to get sites.
    
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $arrayOfSites[$outputCount]->vars["id"] = $row['id'];
      $arrayOfSites[$outputCount]->vars["description"] = $row['description'];
      $arrayOfSites[$outputCount]->vars["is_vista_site"] = $row['is_vista_site'];
      $arrayOfSites[$outputCount]->vars["is_qc_samples_site"] = $row['is_qc_samples_site'];
      $arrayOfSites[$outputCount]->vars["local_network"] = $row['local_network'];
      $arrayOfSites[$outputCount]->vars["sort_order"] = $row['sort_order'];
      $arrayOfSites[$outputCount]->vars["is_active"] = $row['is_active'];
      
      $outputCount++;
    }
    
    // Disconnect from database.
    disconnectFromMySQLQC($mySQLConnection);
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error querying MySQL for a list of sites.";
    sendErrorMessage($debugging, $errorMessage); // Requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $arrayOfSites;
}

//========================================================================================== END PHP
?>

<!DOCTYPE html>
<html>
	<head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>
          // This script sorts the dataTable for samplePlants in descending order, based off of the sort order column.
          $(document).ready(function() {
              $('#samplePlants').DataTable( {
                  "order": [[ 1, "desc" ]]
              } );
           });
        </script>

        <!-- dataTable files -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
        <!-- Page styles -->
        <link href="../../Content/QC/datastyles.css" rel="stylesheet">
       <!-- Styles the edit button -->
        <link href="../../Includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
        <h1>Edit Plant</h1><br /><br />

        <div class="container">
            <form action="updateplant.php" method="GET">
                  <!-- Form is adaptable to browser resizing, and each field is required before submission. -->
                    <div class='form-group'>
                      <label for="plantID"><strong>ID:</strong> </label>
                        <?php
                         echo '<input type="number" class="form-control" id="plantID" name="plantID" value="' . $plantID .'" readonly>';
                        ?>
                  </div>
                  
                <div class="form-group">
                    <label for="orderTextbox"><strong>Order:</strong></label>
                    <?php
                        echo '<input type="number" class="form-control" id="orderTextbox" name="orderTextbox" value="' . $plantOrder .'" max="99999" required>';
                    ?>
                </div>
                  
                <div class="form-group">
                  <label for="siteSelect"><strong>Site:</strong></label>
                        <select class="form-control" name="siteSelect" id="siteSelect" required>
                            <option value="">Select...</option>
                                        <?php
                                    $siteObjectArray = getSites();

                                    foreach ($siteObjectArray as $siteObject) 
                                    {
                                      // Make the site the user wants to edit selected if match is found.
                                      if($siteObject->vars['id'] == $plantSiteID)
                                        {
                                          echo '<option selected value="' . $siteObject->vars['id'] .'">' . $siteObject->vars['description'] . '</option>';
                                        }
                                        else
                                          {
                                           echo '<option value="' . $siteObject->vars['id'] .'">' . $siteObject->vars['description'] . '</option>';
                                          }
                                    }
                      ?>
                        </select>
                </div>

                <div class="form-group">
                    <label for="plantTextbox"><strong>Plant:</strong></label>
                    <?php
                        echo '<input type="text" class="form-control" id="plantTextbox" name="plantTextbox" placeholder="Enter plant title here..." value="' . $plantName .'" maxlength="255" required>';
                    ?>
                </div>
                
                   <div class="form-group">
                    <label for="isActiveSelect"><strong>Active:</strong></label>
                      <select class="form-control" name="isActiveSelect" id="isActiveSelect" required>
                        <?php
                                // If sample active status is 0, display the text "No" to user instead and make field selected.
                                if($plantActive == 0)
                                  {
                                      echo '<option selected value="0">No</option>';
                                  }
                                 else
                                    {
                                      echo '<option value="0">No</option>';
                                    }
                                
                                 // If sample active status is 1, display the text "Yes" to user instead and make field selected..
                                 if($plantActive == 1)
                                  {
                                      echo '<option selected value="1">Yes</option>';
                                  }
                                 else
                                    {
                                      echo '<option value="1">Yes</option>';
                                    }
                        ?>

                      </select>
                  </div><br />

                <div class="form-group">
                    <button type="submit" id="addNewButton" class="btn btn-success btn-block">Submit Changes</button>
                </div>
            </form>
            <br />
            <br />
            <br />
        </div>
	</body>
</html>