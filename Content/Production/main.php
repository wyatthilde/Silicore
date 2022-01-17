<?php
/* * *****************************************************************************
 * File Name: main.php
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Oct 30, 2016[2:29:18 PM]
 * Description:  Main content file for the main Production page
 * Notes: 
 * **************************************************************************** */

ob_start();
//==================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');

function dbmysql()
{
  try
    {
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
    (
      $dbc['silicore_hostname'],
      $dbc['silicore_username'],
      $dbc['silicore_pwd'],
      $dbc['silicore_dbname']
    );
    return $dbconn;
    
    mysqli_close($dbconn);
    
    }
  catch (Exception $e)
  {
    echo ("Error while trying to get data" . $e);   
  }
}
  $startDate = filter_input(INPUT_POST, 'startDate');
  $endDate = filter_input(INPUT_POST, 'endDate');
  $runtimeArrayHTML[]="";
  $startError = "";
  $endError = "";
  
  if(!isset($_POST['startDate']) && !isset($_POST['endDate'])) 
    {
      $mydbconn = dbmysql();
      $query = "CALL sp_gb_plc_DataForExportGet('" . date("Y-m-d",strtotime("yesterday")) . "','" . date("Y-m-d") . "' )";
      //echo "Tag data from " . date("Y-m-d",strtotime("yesterday")) . " to " . date("Y-m-d") . " is ready for export. <br /> <br />";
      $results = $mydbconn->query($query);
    }
  else if(!empty($_POST['startDate']) && empty($_POST['endDate']))
    {           
      $endError = "End date is required.";     
    } 
  else if(empty($_POST['startDate']) && !empty($_POST['endDate']))
    {
      $startError = "Start date is required."; 
    } 
  else if(empty($_POST['startDate']) && empty($_POST['endDate']))
    {
      $startError = "Start date is required.";
      $endError = "End date is required.";
    } 
  else if(isset($_POST['startDate']) && isset($_POST['endDate']))
    {
      $mydbconn = dbmysql(); 
      $query = "CALL sp_gb_plc_DataForExportGet('" . $startDate . "','" . $endDate . "' )";
      //echo "Tag data from " . $startDate . " to " . $endDate . " is ready for export. <br /> <br />"; 
      $results = $mydbconn->query($query);    
    }
  $filename = "website_data_" . date('Ymd') . ".xls";

  //header("Content-Disposition: attachment; filename=\"$filename\"");
  //header("Content-Type: application/vnd.ms-excel");
//====================================================================== END PHP
?>

<style>
/********************************************************************************** BEGIN Float Input Styles */


/********************************************************************************** END Float Input Styles */
</style>



<html lang="en">
<div class="prod-main-header" style="background-color:ffffff; width: 100%; padding-top: 50px; position: fixed; top: 50px; left: 10.9em; padding-left: 1.5em;">
  <h1>Welcome to Production</h1><hr>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.2.1.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
  $(
    function() 
    {
      $('#startDate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
    }
  );
 $(
    function() 
    {
     $('#endDate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
    }
  );
  </script>
</head>
<body>
  <div class="prod-datepicker">
<!--    <form action="main.php" method="post" name="SubmitForm">
      <span class="error"> <?php echo $startError;?></span>
      <input name = "startDate" type="text"  id="startDate" required>
      <span class="error"> <?php echo $endError;?></span>
      <strong>to</strong>
      <input name = "endDate" type="text"  id="endDate" required>
      <input type="submit" value="Submit" id="submit"/>

   </form>-->
  </div>
</div>
<div id="dvData" class="prodtable" style="padding-top: 12em;">
  <table>
    <thead>
      <th>Shift ID</th>
      <th>Operator&emsp;&emsp;&emsp;&emsp;</th>
      <th>Plant</th>
      <th>Product&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
      <th>Value</th>
      <th>Tons Per Hour</th>
      <th>Tons Per Minute</th>
      <th>Tons Per Second</th>
      <th>Runtime</th>
      <th>Uptime</th>
      <th>Downtime</th>
      <th>Idletime</th>
      <th>Date&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
    </thead>
      <tbody>
        <?php     

//        while($result = mysqli_fetch_assoc($results))
//          {
//            $shiftID = $result['Shift ID'];
//            $operator = $result['Operator'];
//            $plant = $result['Plant'];
//            $product = $result['Product'];
//            $tons = $result['Tons'];
//            $tonsPerHour = $result['Tons Per Hour'];
//            $tonsPerMin = $result['Tons Per Minute'];
//            $tonsPerSec = $result['Tons Per Second'];
//            $runtime = $result['Runtime'];
//            $uptime = $result['Uptime'];
//            $downtime = $result['Downtime'];
//            $idletime = $result['Idletime'];
//            $createDate = $result['Date'];
//          
//            $tableRow = 
//                      "<td>" . $shiftID . "</td>"
//                    . "<td>" . $operator . "</td>"
//                    . "<td>" . $plant . "</td>"
//                    . "<td>" . $product . "</td>"
//                    . "<td>" . $tons . "</td>"
//                    . "<td>" . $tonsPerHour . "</td>"
//                    . "<td>" . $tonsPerMin . "</td>"
//                    . "<td>" . $tonsPerSec . "</td>"
//                    . "<td>" . $runtime . "</td>"
//                    . "<td>" . $uptime . "</td>"
//                    . "<td>" . $downtime . "</td>"
//                    . "<td>" . $idletime . "</td>"
//                    . "<td>" . $createDate . "</td>"
//                    ."</tr>";
//            echo $tableRow;
//          }
//          ?>
      </tbody>
  </table>

</div>
</body>

<div class="prod-footer" style="background-color: #FFFFFF; width: 100%; padding-top: 10px; padding-bottom: 10px; position: fixed; left: 100px; bottom: 0px; padding-left: 100px;">
  <div class="date-footer" style="position: left;">  <?php  echo $startDate . " to " . $endDate; ?></div>
 <button id="btnExport" value="Export" style="width: 10%;">Export</button>
</div>
<script>
 
 $("#btnExport").click(function (e) {
  window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
  e.preventDefault(); 
});

if ($(".prodtable td:not(:empty)").length == 0) {
  $(".prodtable").hide();
  $(".prod-footer").hide();


} 

window.onload = function(){
  document.forms['SubmitForm'].submit();
 };
  </script>
</body>
</html>