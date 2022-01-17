<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_weatherUndergroundGraph.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/16/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

try
  {
    $weatherQuery = "CALL sp_gb_plc_RainfallAllGet()";

    $weatherQueryResult = dbMySQL()->query($weatherQuery);
    
    var_dump($weatherQueryResult);
    
    mysqli_close(dbMySQL());
    
  } catch (Exception $ex) 
  {
    echo(("Exception: " . $catchError . "<br /><br />Error message: " . $ex->getMessage() . "<br /><br />"));
    exit("Stopping PHP execution");
  }
  
    $data = array();
    
    foreach($weatherQueryResult as $row)
      {
        $data[] = $row;
      }
      
      var_dump($data);
  
      print json_encode($data);

function dbMySQL()
  {
  /*
 * Connect to MYSQL DB and retrieve latest ID 
 */
$dbc = databaseConnectionInfo();
$connectString = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );
  
    return $connectString; 
  }

//========================================================================================== END PHP
?>

<!-- HTML -->
<!DOCTYPE html>
<html>
  <head>
     <title>WeatherUnderground Data Graph</title>
     
     <style type='text/css'>
            #chart-container
            {
              width: 640px;
              height: auto;
            }
     </style>
  </head>
  
  <body>
    <div id ="chart-container">
      <canvas id="mycanvas"></canvas>
    </div>
    
    <script type='text/javascript' src='../../Includes/jquery.js'></script>
    <script type='text/javascript' src='../../Includes/chart.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type='text/javascript' src='../../Includes/weatherUndergroundGraphApp.js'></script>
    
  </body>
  
</html>