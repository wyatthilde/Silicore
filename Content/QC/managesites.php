<?php
/* * *****************************************************************************************************************************************
 * File Name: managesites.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/25/2018|zthale|KACE:xxxxx - Initial creation
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

//========================================================================================== END PHP
?>

<!DOCTYPE html>
<html>
	<head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>
          // This script sorts the dataTable for sitesData in descending order, based off of the sort order column.
          $(document).ready(function() {
              $('#sitesData').DataTable( {
                  "order": [[ 0, "desc" ]]
              } );
           });
        </script>

        <!-- dataTable files -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
        <!-- Page styles -->
        <link href="../../Content/QC/datastyles.css" rel="stylesheet">
	</head>
	
	<body>
        <h1>Manage Sites</h1><br /><br />

        <div class="container">
            <form action="addsite.php" method="GET">
                  <!-- Form is adaptable to browser resizing, and each field is required before submission. -->
                <div class="form-group">
                    <label for="siteTextbox"><strong>Site:</strong></label>
                        <input type="text" class="form-control" id="siteTextbox" name="siteTextbox" placeholder="Enter site title here..." maxlength="255" required>
                </div>
                <br />

                <div class="form-group">
                    <button type="submit" id="addNewButton" class="btn btn-success btn-block">Add Site</button>
                </div>
            </form>
            <br />
            <br />
            <br />

            <table class="table table-sm table-striped table-hover dt-responsive" id="sitesData" style="width:100%;">       
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Site</th>
                    </tr>
                </thead>

                <tbody>

                    <!-- Populates dataTable with current sites. -->
                    <?php
                        $siteObjectArray = getSites();

                        foreach ($siteObjectArray as $siteObject) 
                        {
                            echo '<tr><td>' . $siteObject->vars['id'] . '</td>';
                            echo '<td>' . $siteObject->vars['description'] . '</td></tr>';
                        }
                    ?>
                </tbody>

                <tfoot>
                </tfoot>         
            </table>
        </div>
	</body>
</html>