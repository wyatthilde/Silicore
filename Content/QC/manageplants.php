<?php
/* * *****************************************************************************************************************************************
 * File Name: manageplants.php
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
  
    $sql = "CALL sp_adm_PlantsNamesGet();"; // Stored procedure method, which gets current plants to display in table.
    $result =  $mySQLConnection->query($sql);
  
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $arrayOfPlants[$outputCount]->vars["id"] = $row['id'];
      $arrayOfPlants[$outputCount]->vars["sort_order"] = $row['sort_order'];
      $arrayOfPlants[$outputCount]->vars["site_id"] = $row["site_id"];
      $arrayOfPlants[$outputCount]->vars["site"] = $row['site'];
      $arrayOfPlants[$outputCount]->vars["plant"] = $row['plant'];
      $arrayOfPlants[$outputCount]->vars["is_active"] = $row['is_active'];
      
      $outputCount++;
    }
    
    // Disconnect from database.
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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>
          // This script sorts the dataTable for plantsData in descending order, based off of the sort order column.
          $(document).ready(function() {
              $('#plantsData').DataTable( {
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
        <h1>Manage Plants</h1><br /><br />

        <div class="container">
            <form action="addplant.php" method="GET">
                  <!-- Form is adaptable to browser resizing, and each field is required before submission. -->
                <div class="form-group">
                  <label for="siteSelect"><strong>Site:</strong></label>
                        <select class="form-control" name="siteSelect" id="siteSelect" required>
                            <option value="">Select...</option>
                            <?php
                                    $siteObjectArray = getSites();

                                    foreach ($siteObjectArray as $siteObject) 
                                    {
                                        echo '<option value="' . $siteObject->vars['id'] .'">' . $siteObject->vars['description'] . '</option>';
                                    }
                            ?>
                        </select>
                </div>

                <div class="form-group">
                    <label for="plantTextbox"><strong>Plant:</strong></label>
                        <input type="text" class="form-control" id="plantTextbox" name="plantTextbox" placeholder="Enter plant title here..." maxlength="255" required>
                </div>
                <br />

                <div class="form-group">
                    <button type="submit" id="addNewButton" class="btn btn-success btn-block">Add Plant</button>
                </div>
            </form>
            <br />
            <br />
            <br />

            <table class="table table-sm table-striped table-hover dt-responsive" id="plantsData" style="width:100%;">       
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Site</th>
                        <th>Plant</th>
                        <th>Active</th>
                        <th>Edit</th>
                    </tr>
                </thead>

                <tbody>

                    <!-- Populates dataTable with current plants. -->
                    <?php
                        $plantObjectArray = getPlants();

                        foreach ($plantObjectArray as $plantObject) 
                        {
                            echo '<tr><td>' . $plantObject->vars['id'] . '</td>';
                            echo '<td>' . $plantObject->vars['sort_order'] . '</td>';
                            echo '<td>' . $plantObject->vars['site'] . '</td>';
                            echo '<td>' . $plantObject->vars['plant'] . '</td>';

                            // If sample active status is 0, display the text "No" to user instead.
                            if($plantObject->vars['is_active'] == 0)
                            {
                                echo '<td>No</td>';
                            }
                            // If split sample active status is 1, display the text "Yes" to user instead.
                            else if($plantObject->vars['is_active'] == 1)
                            {
                                echo '<td>Yes</td>';
                            }

                            // Create a URL to edit this sample location.
                            $editURL = "../../Controls/QC/editplant.php?plantID=" . urlencode($plantObject->vars['id']) . "&plantOrder=" . urlencode($plantObject->vars['sort_order']) . "&siteID=" . urlencode($plantObject->vars['site_id']) . "&plantSite=" . urlencode($plantObject->vars['site']) . "&plantName=" . urlencode($plantObject->vars['plant']) . "&plantActive=" . urlencode($plantObject->vars['is_active']);     

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