<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_editlocation.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/16/2018|zthale|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */

require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');

//======================================================================================== BEGIN PHP

$locationID = $_GET['locationID'];
//echo "Location ID: " . $locationID . "<br>";

$locationOrder = $_GET['locationOrder'];
//echo "Location Order: " . $locationOrder . "<br>";

$locationSiteID = $_GET['locationSiteID'];
//echo "Location Site ID: " . $locationSiteID . "<br>";

$locationSite = $_GET['locationSite'];
//echo "Location Site: " . $locationSite . "<br>";

$locationPlantID = $_GET['locationPlantID'];
//echo "Location Site ID: " . $locationPlantID . "<br>";

$locationPlant = $_GET['locationPlant'];
//echo "Location Plant: " . $locationPlant . "<br>";

$locationDescription = $_GET['locationDescription'];
//echo "Location Description: " . $locationDescription . "<br>";

$locationSplit = $_GET['locationSplit'];
//echo "Location Split: " . $locationSplit . "<br>";

$locationActive = $_GET['locationActive'];
//echo "Location Active: " . $locationActive . "<br>";



// Connect to MySQL database.
 function connectToMySQLQC()
{
  $errorMessage = "Page: QC functionality - connectToMySQLQC() - "; 
  
  global $PageName;
  global $FullPath;
  
  try
  {
	$mySQLConnection = 0; //used to track if the database is connected.
	
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

    // Disconnect from MySQL database.
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

// Returns an array of plants.
function getPlants()
{
  $errorMessage = "function getPlants(): "; 
  $arrayOfPlants = NULL;
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
    $mySQLConnection = connectToMySQLQC(); // Connect to the database.
  
    $sql = "CALL sp_GetPlants();"; // Stored procedure method, which returns a list of all possible location plants.
    $result =  $mySQLConnection->query($sql); 
  
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $arrayOfPlants[$outputCount]->vars["id"] = $row['id'];
      $arrayOfPlants[$outputCount]->vars["site"] = $row['main_site_id'];
      $arrayOfPlants[$outputCount]->vars["name"] = $row['name'];
      $arrayOfPlants[$outputCount]->vars["name_short"] = $row['name_short'];
      $arrayOfPlants[$outputCount]->vars["description"] = $row['description'];
      $arrayOfPlants[$outputCount]->vars["sort_order"] = $row['sort_order'];
      $arrayOfPlants[$outputCount]->vars["tceq_max_tpy"] = $row['tceq_max_tpy'];
      $arrayOfPlants[$outputCount]->vars["tceq_max_tph"] = $row['tceq_max_tph'];
      $arrayOfPlants[$outputCount]->vars["tceq_max_upy"] = $row['tceq_max_upy'];
      $arrayOfPlants[$outputCount]->vars["tceq_moisture_rate"] = $row['tceq_moisture_rate'];
      $arrayOfPlants[$outputCount]->vars["tceq_description"] = $row['tceq_description'];
      $arrayOfPlants[$outputCount]->vars["tceq_notes"] = $row['tceq_notes'];
      $arrayOfPlants[$outputCount]->vars["tceq_sort_order"] = $row['tceq_sort_order'];
      $arrayOfPlants[$outputCount]->vars["is_active"] = $row['is_active'];
      
      $outputCount++;
    }

    // Disconnect from MySQL database.
    disconnectFromMySQLQC($mySQLConnection);
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error querying MySQL for a list of plants.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $arrayOfPlants;
}

//========================================================================================== END PHP
?>

<!DOCTYPE html>
<html>
      <head>
        <link href="../../Content/QC/datastyles.css" rel="stylesheet">
      </head>

      <body>
          <h1>Edit Location</h1><br /><br />
    
                <div class="container">
                <form action="gb_updatelocation.php" method="GET">
                  <!-- Form is pre-populated with sample location user wants to edit. -->
                  <div class='form-group'>
                      <label for="locationID"><strong>ID:</strong> </label>
                        <?php
                         echo '<input type="number" class="form-control" id="locationID" name="locationID" value="' . $locationID .'" readonly>';
                        ?>
                  </div>
                  
                  <div class="form-group">
                    <label for="orderTextbox"><strong>Order:</strong></label>
                    <?php
                        echo '<input type="number" class="form-control" id="orderTextbox" name="orderTextbox" value="' . $locationOrder .'" required>';
                    ?>
                </div>
                  
                  <div class="form-group">
                    <label for="siteSelect"><strong>Site:</strong></label>
                    <select class="form-control" name="siteSelect" id="siteSelect" readonly>

                      <?php
                                    $siteObjectArray = getSites();

                                    foreach ($siteObjectArray as $siteObject) 
                                    {
                                      
                                        // Make the site the user wants to edit selected if match is found.
                                        if($siteObject->vars['id'] == $locationSiteID)
                                        {
                                            echo '<option selected value="' . $siteObject->vars['id'] .'">' . $siteObject->vars['description'] . '</option>';
                                        }
      
                                    }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="plantSelect"><strong>Plant:</strong></label>
                    <select class="form-control" name="plantSelect" id="plantSelect" required>

                    <?php
                      $plantObjectArray = getPlants();
                      
                      foreach ($plantObjectArray as $plantObject)
                        {
                           if($plantObject->vars['site'] == $locationSiteID) // If the row's ID corresponds to "Granbury" (ID: 10).
                             {
                             // Make the plant the user wants to edit selected if match is found.
                        if($plantObject->vars['id'] == $locationPlantID)
                          {
                           echo '<option selected value="' . $plantObject->vars['id'] .'">' . $plantObject->vars['name'] . '</option>';
                          }
                          else
                            {
                              echo '<option value="' . $plantObject->vars['id'] .'">' . $plantObject->vars['name'] . '</option>';
                            }
                             }
                        }
                    ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="descriptionTextbox"> <strong>Description:</strong> </label>
                    <?php
                        echo '<input type="text" class="form-control" id="descriptionTextbox" name="description"  value="' . $locationDescription .'" maxlength="255" required>';
                    ?>
                </div>

                  <div class="form-group">
                    <label for="splitSampleOnlySelect"><strong>Split Sample Only:</strong></label>
                      <select class="form-control" name="splitSampleOnlySelect" id="splitSampleOnlySelect" required>
                        <?php
                                // If split sample is 0, display the text "No" to user instead and make field selected.
                                if($locationSplit == 0)
                                  {
                                      echo '<option selected value="0">No</option>';
                                  }
                                 else
                                    {
                                      echo '<option value="0">No</option>';
                                    }
                                
                                 // If split sample is 1, display the text "Yes" to user instead and make field selected..
                                 if($locationSplit == 1)
                                  {
                                      echo '<option selected value="1">Yes</option>';
                                  }
                                 else
                                    {
                                      echo '<option value="1">Yes</option>';
                                    }
                        ?>

                      </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="isActiveSelect"><strong>Active:</strong></label>
                      <select class="form-control" name="isActiveSelect" id="isActiveSelect" required>
                        <?php
                                // If sample active status is 0, display the text "No" to user instead and make field selected.
                                if($locationActive == 0)
                                  {
                                      echo '<option selected value="0">No</option>';
                                  }
                                 else
                                    {
                                      echo '<option value="0">No</option>';
                                    }
                                
                                 // If sample active status is 1, display the text "Yes" to user instead and make field selected..
                                 if($locationActive == 1)
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
                </div>
                <br /><br /><br />
      </body>
</html>