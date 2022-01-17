<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_managelocations.php
 * Project: Silicore
 * Description: Allows users to manage locations. Users may add, view, and edit locations.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2018|zthale|KACE:24315 - Initial creation
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

// Returns an array of locations.
function getLocations()
{
  $errorMessage = "function getLocations(): "; 
  $arrayOfLocations = NULL;
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
    $mySQLConnection = connectToMySQLQC(); // Connect to the database.
  
    $sql = "CALL sp_tl_qc_LocationsNamesGet();"; // Stored procedure method, which gets current locations to display in table.
    $result =  $mySQLConnection->query($sql);
  
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $arrayOfLocations[$outputCount]->vars["id"] = $row['id'];
      $arrayOfLocations[$outputCount]->vars["sort_order"] = $row['sort_order'];
      $arrayOfLocations[$outputCount]->vars["site_id"] = $row["site_id"];
      $arrayOfLocations[$outputCount]->vars["site"] = $row['site'];
      $arrayOfLocations[$outputCount]->vars["plant_id"] = $row["plant_id"];
      $arrayOfLocations[$outputCount]->vars["plant"] = $row['name'];
      $arrayOfLocations[$outputCount]->vars["description"] = $row['description'];
      $arrayOfLocations[$outputCount]->vars["split"] = $row['is_split_sample_only'];
      $arrayOfLocations[$outputCount]->vars["active_status"] = $row['is_active'];
      
      $outputCount++;
    }
    
    // Disconnect from database.
    disconnectFromMySQLQC($mySQLConnection);
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error querying MySQL for a list of locations.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $arrayOfLocations;
}
//========================================================================================== END PHP
?>

<!DOCTYPE html>
<html>
	<head>
		<!--<title>tl_managelocations.php</title>-->
    
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>
          // This script sorts the dataTable for locationsData in descending order, based off of the sort order column.
          $(document).ready(function() {
              $('#locationsData').DataTable( {
                  "order": [[ 1, "desc" ]]
              } );
          } );
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
    <h1>Manage Locations (Tolar)</h1><br /><br />
    
    <div class="container">
		<form action="addlocation.php" method="GET">
      <!-- Form is adaptable to browser resizing, and each field is required before submission. -->
			<div class="form-group">
        <label for="siteSelect"><strong>Site:</strong></label>
				<select class="form-control" name="siteSelect" id="siteSelect" readonly>
					<?php
                        $siteObjectArray = getSites();
 
                        foreach ($siteObjectArray as $siteObject) 
                        {
                           if($siteObject->vars["id"] == 50) // If the row's ID corresponds to "Tolar" (ID: 50).
                            {
                                echo '<option value="' . $siteObject->vars['id'] .'">' . $siteObject->vars['description'] . '</option>';
                            } 
                        }
					?>
				</select>
			</div>
		
			<div class="form-group">
        <label for="plantSelect"><strong>Plant:</strong></label>
				<select class="form-control" name="plantSelect" id="plantSelect" required>
					 <option value="">Select...</option>
           <?php
                        $plantObjectArray = getPlants();
 
                        foreach ($plantObjectArray as $plantObject) 
                        {
                           if($plantObject->vars["site"] == 50) // If the row's ID corresponds to "Tolar" (ID: 50).
                            {
                                echo '<option value="' . $plantObject->vars['id'] .'">' . $plantObject->vars['name'] . '</option>';
                            } 
                        }
					?>
				</select>
			</div>
			
      <div class="form-group">
      <label for="descriptionTextbox"><strong>Description:</strong></label>
				<input type="text" class="form-control" id="descriptionTextbox" name="description" placeholder="Enter description here..." maxlength="255" required>
    </div>
      
      <div class="form-group">
        <label for="splitSampleOnlySelect"><strong>Split Sample Only:</strong></label>
          <select class="form-control" name="splitSampleOnlySelect" id="splitSampleOnlySelect" required>
            <option value="">Select...</option>
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select>
      </div><br />
      
      <div class="form-group">
       <button type="submit" id="addNewButton" class="btn btn-success btn-block">Add Location</button>
      </div>
		</form>
    <br /><br /><br />
    
              <table class="table table-sm table-striped table-hover dt-responsive" id="locationsData" style="width:100%;">       
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Site</th>
                        <th>Plant</th>
                        <th>Description</th>
                        <th>Split Only</th>
                        <th>Active</th>
                        <th>Edit</th>
                      </tr>
                    </thead>

                    <tbody>
                               
                              <!-- Populates dataTable with current locations. -->
                              <?php
                                  $locationObjectArray = getLocations();

                                  foreach ($locationObjectArray as $locationObject) 
                                  {
                                    echo '<tr><td>' . $locationObject->vars['id'] . '</td>';
                                    echo '<td>' . $locationObject->vars['sort_order'] . '</td>';
                                    echo '<td>' . $locationObject->vars['site'] . '</td>';
                                    echo '<td>' . $locationObject->vars['plant'] . '</td>';
                                    echo '<td>' . $locationObject->vars['description'] . '</td>';

                                    // If split sample is 0, display the text "No" to user instead.
                                    if($locationObject->vars['split'] == 0)
                                    {
                                      echo '<td>No</td>';
                                     }
                                     // If split sample is 1, display the text "Yes" to user instead.
                                     else if($locationObject->vars['split'] == 1)
                                     {
                                      echo '<td>Yes</td>';
                                      }
                                      
                                    // If sample active status is 0, display the text "No" to user instead.
                                    if($locationObject->vars['active_status'] == 0)
                                    {
                                      echo '<td>No</td>';
                                     }
                                     // If split sample active status is 1, display the text "Yes" to user instead.
                                     else if($locationObject->vars['active_status'] == 1)
                                     {
                                      echo '<td>Yes</td>';
                                      }
                                      
                                       // Create a URL to edit this location.
                                      $editURL = "../../Controls/QC/editlocation.php?locationID=" . urlencode($locationObject->vars['id']) . "&locationOrder=" . urlencode($locationObject->vars['sort_order']) . "&locationSiteID=" . urlencode($locationObject->vars['site_id']) . "&locationSite=" . urlencode($locationObject->vars['site']) . "&locationPlantID=" . urlencode($locationObject->vars['plant_id']) . "&locationPlant=" . urlencode($locationObject->vars['plant']) . "&locationDescription=" . urlencode($locationObject->vars['description']) . "&locationActive=" . urlencode($locationObject->vars['active_status']) . "&locationSplit=" . urlencode($locationObject->vars['split']);     

                                      echo "<td><a href='" . $editURL . "'><!--Edit--><i class='fa fa-edit' style='font-size:20px;color:green'></i></a></td></tr>";
                                  }
                              ?>

                    </tbody>

                    <tfoot>
                    </tfoot>         
              </table>
  </div>
	</body>
</html>