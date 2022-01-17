<?php
/* * *****************************************************************************************************************************************
 * File Name: plc_plant_thresholds.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/22/2018|nolliff|KACE:16485 - Initial creation
 * 07/16/2018|nolliff|KACE:xxxxx - renamed to plc_plant_thresholds.php
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/emailfunctions.php');

$debugging = 0; //set this to 1 to see debugging output

$time=time(); //variable used for obtaining the current time
$errorMessage = ""; //used in error message emails
$userID = $_SESSION['user_id'];
//display information if we are in debugging mode

if($debugging)
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled - qcfunctions.php</strong><br/>";  
    echo "Start time: ";
    echo(date("Y-m-d H:i:s",$t));
    echo "<br/>";
}

try
  {
    $allTagGetSQL = "CALL sp_plc_TagsAllGet()";
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
      (    
        $dbc['silicore_hostname'],
        $dbc['silicore_username'],
        $dbc['silicore_pwd'],
        $dbc['silicore_dbname']
      );
    $allTagResults = $dbconn->query($allTagGetSQL);

    mysqli_close($dbconn);
  }
catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the MySQL database";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    exit("Stopping PHP execution");
  }
  
//  try
//  {
//    $allTagGetSQL = "CALL sp_tl_plc_tagsGet()";
//    $dbc = databaseConnectionInfo();
//    $dbconn = new mysqli
//      (    
//        $dbc['silicore_hostname'],
//        $dbc['silicore_username'],
//        $dbc['silicore_pwd'],
//        $dbc['silicore_dbname']
//      );
//    $tlTagResults = $dbconn->query($allTagGetSQL);
//    mysqli_close($dbconn);
//  }
//catch (Exception $e)
//  {
//    $errorMessage = $errorMessage . "Error connecting to the MySQL database";
//    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
//    exit("Stopping PHP execution");
//  }
  
  
function siteSwitch($site)
  {
  $site = strtoupper($site);
  switch ($site)
    {
    case 'GRANBURY':
      return 'gb';
    case 'TOLAR':
      return 'tl';
    case 'WEST TEXAS':
      return 'wt';
    default:
      break;
    }
  }

//========================================================================================== END PHP
?>

<!--<script>
$( document ).ready(function() {
    REinit();
    
});

  function REinit()
  {
    $("#thresholdTable").tablesorter();
  }
  
</script>-->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
<!-- HTML -->

<h2>Plant Alert Thresholds</h2>
<div class="container" style="max-width:75%">
<form class="form-row">
<div class="form-group col-lg-2">
<label for="siteLocations">Select Site: </label>
<select class="form-control" id="siteSelect">
  <option></option>
  <option>Granbury</option>
  <option>Tolar</option>
</select>
  </div>
    <div class="form-group col-lg-8"></div>
  <div class="form-group col-lg-2">
<label for="tableSearch">Search: </label>
<input class="form-control" id="tableSearch" type="text">
  </div>
</form>
  <table id='thresholdTable' class='table table-striped table-bordered'>
    <thead style="background-color:#4c7ad0; color: white;">
      <tr>
        <th>ID</th>
        <th>Site</th>
        <th>Device</th>
        <th>Tag</th>
        <th>PLC Tag</th>
        <th>Classification</th>
        <th>Units</th>
        <th>Threshold</th>
        <th>Alert On</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        while ($tag = $allTagResults->fetch_assoc())
        {
          
          $thresholdId = '';
          $alertOn = 0;
          $thresholdValue = 'N/A';
          $siteCode = siteSwitch($tag['site']);

          try
            {
              $thresholdSQL = "CALL sp_gb_plc_userThresholdGet(" . $tag['id'] . "," . $userID . ")";
              //echo $thresholdSQL;
              $dbconn = new mysqli(    $dbc['silicore_hostname'],    $dbc['silicore_username'],    $dbc['silicore_pwd'],    $dbc['silicore_dbname']);
              $thresholdRes = $dbconn->query($thresholdSQL);
              mysqli_close($dbconn);
            }
          catch (Exception $e)
            {
              $errorMessage = $errorMessage . "Error connecting to the MySQL database";
              sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
            }
          while($threshold = $thresholdRes->fetch_assoc())
            {
              $thresholdId = $threshold['id'];
              $alertOn = $threshold['send_alert'];
              $thresholdValue = $threshold['threshold'];
            }
            
            
          echo
          ("        
            <tr>
              <td>{$tag['id']}</td> 
              <td>{$tag['site']}</td>
              <td>{$tag['ui_label']}</td>
              <td>{$tag['tag']}</td>
              <td>{$tag['address']}</td>
              <td>{$tag['classification']}</td>
              <td>{$tag['units']}</td>
              <td>{$thresholdValue}</td>
              <td>
                <input type='checkbox' ".($alertOn == 1 ? "checked" : '')." disabled>
                <input type='hidden' name='alertOn' value='{$alertOn}'>
              </td>
              <td>
                <form action='../../Controls/Production/plc_edit_threshold.php' method='post'>
                  <input type='hidden' name='threshold_id' value='{$thresholdId}'>
                  <input type='hidden' name='tag_id' value='{$tag['id']}'>
                  <input type='hidden' name='site' value='{$siteCode}'>
                  <input type='submit' value='Edit'>
                </form>
              </td>
            </tr>
          ");
        }
      ?>
      
    </tbody>
  </table>
</div>

<script>
$(document).ready(function() {
    var table = $('#thresholdTable').DataTable( {
        dom:            "rt",
        scrollY:        "600px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        searching:      true
      })
$('#siteSelect').on('change',function(){
var selectedValue = $(this).val();
table.search(selectedValue).draw();
});
$('#tableSearch').on('keyup',function(){
var searchValue = $(this).val();
table.search(searchValue).draw();
}); 
});

</script>




