<?php
/* * *****************************************************************************************************************************************
 * File Name: plantdashboard.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17512 - Initial creation
 * 03/05/2016|nolliff|KACE:17512 - added gas and gas table
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
require_once('../../Includes/Production/gb_plc_tagGlobal.php');



//check to see if the start and end date have been set, if not the default is a 2 day range
if (isset($_POST['start-date']) && !empty($_POST['start-date']))
  {
  $startDate = filter_input(INPUT_POST, 'start-date');
  } else
  {
  $startDate = date("Y-m-d", strtotime("-3 days"));
  }

if (isset($_POST['end-date']) && !empty($_POST['end-date']))
  {
  $endDate = filter_input(INPUT_POST, 'end-date');
  } else
  {
  $endDate = date("Y-m-d", strtotime('-1 day'));
  }

$userId = $_SESSION['user_id'];

try
  {
  $settingsSQL = "CALL sp_gb_plc_DashboardSettingsGet(" . $userId . ")";
  $settingsResults = mysqli_query(dbmysqli(), $settingsSQL);
  if(mysqli_num_rows($settingsResults)!= 0)
    {
      while ($settingsResult = mysqli_fetch_assoc($settingsResults))
        {
        $settingsArry = json_decode($settingsResult['settings_json'], true);
       } 
    }
  else
    {
      $settingsArry=['settings' => 
          [
            "wp1_feed_tons" => 1000,
            "wp1_feed_pls70" => 20,
            "wp1_feed_mns70pls140" => 55,
            "wp1_feed_mns140" => 25,
            "wp1_coarse_tons" => 1000,
            "wp1_coarse_pls70" => 89,
            "wp1_coarse_mns70pls140" => 10,
            "wp1_coarse_mns140" => 1,
            "wp1_fine_tons" => 1000,
            "wp1_fine_pls70" => 20,
            "wp1_fine_mns70pls140" => 70,
            "wp1_fine_mns140" => 10,
            "wp2_feed_tons" => 1000,
            "wp2_feed_pls70" => 15,
            "wp2_feed_mns70pls140" => 55,
            "wp2_feed_mns140" => 30,
            "wp2_coarse_tons" => 1000,
            "wp2_coarse_pls70" => 90,
            "wp2_coarse_mns70pls140" => 8,
            "wp2_coarse_mns140" => 2,
            "wp2_fine_tons" => 1000,
            "wp2_fine_pls70" => 18,
            "wp2_fine_mns70pls140" => 67,
            "wp2_fine_mns140" => 15,
            "rotary_feed_tons" => 1000,
            "rotary_feed_pls70" => 1000,
            "rotary_feed_mns70pls140" => 1000,
            "rotary_feed_mns140" => 1,
            "rotary_output_tons" => 1000,
            "rotary_output_pls70" => 1,
            "rotary_output_mns70pls140" => 1,
            "rotary_output_mns140" => 1,
            "carrier100_feed_tons" => 1000,
            "carrier100_feed_pls70" => 1,
            "carrier100_feed_mns70pls140" => 1,
            "carrier100_feed_mns140" => 1,
            "carrier100_output_tons" => 1000,
            "carrier100_output_pls70" => 1,
            "carrier100_output_mns70pls140" => 1,
            "carrier100_output_mns140" => 1,
            "carrier200_feed_tons" => 1000,
            "carrier200_feed_pls70" => 1,
            "carrier200_feed_mns70pls140" => 1,
            "carrier200_feed_mns140" => 1,
            "carrier200_output_tons" => 1000,
            "carrier200_output_pls70" => 1,
            "carrier200_output_mns70pls140" => 1,
            "carrier200_output_mns140" => 1
          ]
        ];
    }
     
  } catch (Exception $e)
  {
  echo("Error: " . __LINE__ . " " . $e);
  }
?>
<?php
//Wet Plants
$wetPlant2SampleFeedId = 127;
$wetPlant2SampleCoarseId = 3;
$wetPlant2SampleFineId = 4;

$wetPlant2ConveyorFeedId = 4;
$wetPlant2ConveyorCoarseId = 12;
$wetPlant2ConveyorFineId = 16;

$wetPlant1SampleFeedId = 128;//
$wetPlant1SampleCoarseId = 22;//
$wetPlant1SampleFineId = 21;//

$wetPlant1ConveyorFeedId = 8;
$wetPlant1ConveyorCoarseId = 2;
$wetPlant1ConveyorFineId = 3;

$wetPlant1ShiftId = 1;
$wetPlant2ShiftId = 1;
//Dry Plants
$rotarySampleFeedId = 49;
$rotarySampleOutputId = 50;

$rotaryConveyorFeedId = 18;
$rotaryConveyorOutputId = 26;
$rotaryGasFlowId = 35;

$carrier100TSampleFeedId = 24;//
$carrier100TSampleOutputId = 11;//

$carrier100TConveyorFeedId = 28;
$carrier100TConveyorOutputId = 75;
$carrier100TGasFlowId = 34;

$carrier200TSampleFeedId = 103;//
$carrier200TSampleOutputId = 102;//

$carrier200TConveyorFeedId = 22;
$carrier200TConveyorOutputId = 24;
$carrier200TGasFlowId = 36;

$carrier100TShiftId = 5;
$carrier200TShiftId = 8;
$rotaryShiftId = 6;

/*
 * END PLANT ID VARIABLES
 */

// <editor-fold defaultstate="collapsed" desc=" Rotary ">
try
  {

  //runtime for period
  $rotaryShiftSQL = "CALL sp_gb_plc_ShiftSummaryByDateGet"
          . "(" . $rotaryShiftId . ",'" . $startDate . "','" . $endDate . "')";

  //shift times
  $rotaryShiftTimes = mysqli_query(dbmysqli(), $rotaryShiftSQL);
  } catch (Exception $e)
  {
  echo("Error: " . __LINE__ . " " . $e);
  }

//finds shift times for period
while ($rotaryShiftTime = $rotaryShiftTimes->fetch_assoc())
  {
  $rotaryDuration = $rotaryShiftTime['duration_minutes'];
  $rotaryUptime = $rotaryShiftTime['uptime'];
  $rotaryDowntime = $rotaryShiftTime['downtime'];
  $rotaryIdletime = $rotaryShiftTime['idletime'];
  $rotarySchDowntime= $rotaryShiftTime['schdowntime'];
  }

if ($rotaryDuration == 0)
  {

  $rotaryDowntimePercent = "<span class=\"alert-danger\">Data not found.</span>";
  $rotaryIdletimePercent = "<span class=\"alert-danger\">Data not found.</span>";
  $rotaryUptimePercent = "<span class=\"alert-danger\">Data not found.</span>";
  $rotarySchDowntimePercent ="<span class=\"alert-danger\">Data not found.</span>";
  } else
  {
  $rotaryDowntimePercent = sprintf("%.2f%%", ($rotaryDowntime / $rotaryDuration) * 100);
  $rotarySchDowntimePercent = sprintf("%.2f%%", ($rotarySchDowntime / $rotaryDuration) * 100);
  $rotaryIdletimePercent = sprintf("%.2f%%", ($rotaryIdletime / $rotaryDuration) * 100);
  $rotaryUptimePercent = sprintf("%.2f%%", ($rotaryUptime / $rotaryDuration) * 100);
  }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc=" 100T Carrier ">
try
  {

  //runtime for period
  $carrier100TShiftSQL = "CALL sp_gb_plc_ShiftSummaryByDateGet"
          . "(" . $carrier100TShiftId . ",'" . $startDate . "','" . $endDate . "')";

  //shift times
  $carrier100TShiftTimes = mysqli_query(dbmysqli(), $carrier100TShiftSQL);
  } catch (Exception $e)
  {
  echo("Error: " . __LINE__ . " " . $e);
  }

//statistics assigned for carrier100T course, fine and feed for the period specified

while ($carrier100TShiftTime = $carrier100TShiftTimes->fetch_assoc())
  {
  $carrier100TDuration = $carrier100TShiftTime['duration_minutes'];
  $carrier100TUptime = $carrier100TShiftTime['uptime'];
  $carrier100TDowntime = $carrier100TShiftTime['downtime'];
  $carrier100TIdletime = $carrier100TShiftTime['idletime'];
  $carrier100TSchDowntime= $carrier100TShiftTime['schdowntime'];
  }




if ($carrier100TDuration == 0)
  {
  $carrier100TUptimePercent = '<span class="alert-danger">Data not found.</span>';
  $carrier100TDowntimePercent = '<span class="alert-danger">Data not found.</span>';
  $carrier100TSchDowntimePercent ='<span class="alert-danger">Data not found.</span>';
  $carrier100TIdletimePercent = '<span class="alert-danger">Data not found.</span>';
  } else
  {
  $carrier100TUptimePercent = sprintf("%.2f%%", ($carrier100TUptime / $carrier100TDuration) * 100);
  $carrier100TSchDowntimePercent = sprintf("%.2f%%", ($carrier100TSchDowntime / $carrier100TDuration) * 100);
  $carrier100TDowntimePercent = sprintf("%.2f%%", ($carrier100TDowntime / $carrier100TDuration) * 100);
  $carrier100TIdletimePercent = sprintf("%.2f%%", ($carrier100TIdletime / $carrier100TDuration) * 100);
  }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc=" 200T Carrier ">
try
  {




  //runtime for period
  $carrier200TShiftSQL = "CALL sp_gb_plc_ShiftSummaryByDateGet"
          . "(" . $carrier200TShiftId . ",'" . $startDate . "','" . $endDate . "')";


  //shift times
  $carrier200TShiftTimes = mysqli_query(dbmysqli(), $carrier200TShiftSQL);
  } catch (Exception $e)
  {
  echo("Error: " . __LINE__ . " " . $e);
  }

while ($carrier200TShiftTime = $carrier200TShiftTimes->fetch_assoc())
  {
  $carrier200TDuration = $carrier200TShiftTime['duration_minutes'];
  $carrier200TUptime = $carrier200TShiftTime['uptime'];
  $carrier200TDowntime = $carrier200TShiftTime['downtime'];
  $carrier200TIdletime = $carrier200TShiftTime['idletime'];
  $carrier200TSchDowntime= $carrier200TShiftTime['schdowntime'];
  }




if ($carrier200TDuration == 0)
  {
  $carrier200TUptimePercent = '<span class="alert-danger">Data not found.</span>';
  $carrier200TDowntimePercent = '<span class="alert-danger">Data not found.</span>';
  $carrier200TSchDowntimePercent ='<span class="alert-danger">Data not found.</span>';
  $carrier200TIdletimePercent = '<span class="alert-danger">Data not found.</span>';
  } else
  {
  $carrier200TUptimePercent = sprintf("%.2f%%", ($carrier200TUptime / $carrier200TDuration) * 100);
  $carrier200TSchDowntimePercent = sprintf("%.2f%%", ($carrier200TSchDowntime / $carrier200TDuration) * 100);
  $carrier200TDowntimePercent = sprintf("%.2f%%", ($carrier200TDowntime / $carrier200TDuration) * 100);
  $carrier200TIdletimePercent = sprintf("%.2f%%", ($carrier200TIdletime / $carrier200TDuration) * 100);
  }

// </editor-fold>
// </editor-fold>
//========================================================================================== END PHP
?>


<style>
  .dataTables_wrapper .dt-buttons {
    float: right;
    margin-top: .5%;
  }

  .buttons-excel {
    background-color: #78D64B;
    color: white;;
  }

  .card-header {
    background-color: white;
  }

  .card {
    background-color: white;
    padding: 1%;
    margin-bottom: 1%;
  }

  .card-footer {
    background-color: white;
  }
  
  .card-display-header 
  {
      cursor: pointer
  }
  
  .hidden
  {
    display:none !important;
  }
</style>

<!--<editor-fold desc="Resources">-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"
defer="defer"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" defer="defer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" defer="defer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" defer="defer"></script>
<!--</editor-fold>-->
<style>

/*    .chart-canvas
    {
      display:none;
    }*/
</style>
<div class="container-fluid" >
  <h1>Plant Dashboard</h1>
  <!--<button id="testButton">test</button>-->
  <div id='settings_header' class='card-display-header'>
    <h3>Settings          
      <div class='arrow-up' style='display:none' >&#9650;</div>
      <div class='arrow-down' style='display:inline-block' >&#9660;</div>
    </h3>
  </div>    
  <div class="card" id='settings_card' style='display:none'>
    <div class="card-header">
      <h4>Target Settings</h4>
    </div>
    <div class="card-body">
      <div class="alert alert-success" style="display:none" id="msg"></div>
      <div class="alert alert-danger" style="display:none" id="failuremsg"></div>
      <div id='wp1_settings_header' class='card-display-header'>
        <h5>Wet Plant 1 Settings          
          <div style='display:none' id='arrow-up-wp1'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-wp1'>&#9660;</div>
        </h5>      
      </div>
      <div id="wp1_settings" style="display:none">
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 Feed Tons:</label>
            <input class="form-control setting" type="number" id="wp1_feed_tons"  value="<?php echo $settingsArry['settings']['wp1_feed_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 Feed +70 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_feed_pls70"  value="<?php echo $settingsArry['settings']['wp1_feed_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 Feed -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_feed_mns70pls140"  value="<?php echo $settingsArry['settings']['wp1_feed_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 Feed -140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_feed_mns140"  value="<?php echo $settingsArry['settings']['wp1_feed_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 40/70 Tons:</label>
            <input class="form-control setting" type="number" id="wp1_coarse_tons"  value="<?php echo $settingsArry['settings']['wp1_coarse_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 40/70 +70 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_coarse_pls70"  value="<?php echo $settingsArry['settings']['wp1_coarse_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 40/70 -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_coarse_mns70pls140"  value="<?php echo $settingsArry['settings']['wp1_coarse_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 40/70 -140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_coarse_mns140"  value="<?php echo $settingsArry['settings']['wp1_coarse_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 100 Mesh Tons:</label>
            <input class="form-control setting" type="number" id="wp1_fine_tons"  value="<?php echo $settingsArry['settings']['wp1_fine_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 100 Mesh +70 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_fine_pls70"  value="<?php echo $settingsArry['settings']['wp1_fine_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 100 Mesh -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_fine_mns70pls140"  value="<?php echo $settingsArry['settings']['wp1_fine_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Wet Plant 1 100 Mesh -140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp1_fine_mns140"  value="<?php echo $settingsArry['settings']['wp1_fine_mns140'] ?>">
          </div>
        </div>
      </div>
      <div id='wp2_settings_header' class='card-display-header'>
        <h5>Wet Plant 2 Settings          
          <div style='display:none' id='arrow-up-wp2'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-wp2'>&#9660;</div>
        </h5>      
      </div>
      <div id="wp2_settings" style="display:none">
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 Feed Tons:</label>
            <input class="form-control setting" type="number" id="wp2_feed_tons"  value="<?php echo $settingsArry['settings']['wp2_feed_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 Feed +70 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_feed_pls70"  value="<?php echo $settingsArry['settings']['wp2_feed_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 Feed -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_feed_mns70pls140"  value="<?php echo $settingsArry['settings']['wp2_feed_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 Feed -140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_feed_mns140"  value="<?php echo $settingsArry['settings']['wp2_feed_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 40/70 Tons:</label>
            <input class="form-control setting" type="number" id="wp2_coarse_tons"  value="<?php echo $settingsArry['settings']['wp2_coarse_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 40/70 +70 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_coarse_pls70"  value="<?php echo $settingsArry['settings']['wp2_coarse_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 40/70 -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_coarse_mns70pls140"  value="<?php echo $settingsArry['settings']['wp2_coarse_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 40/70 -140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_coarse_mns140"  value="<?php echo $settingsArry['settings']['wp2_coarse_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 100 Mesh Tons:</label>
            <input class="form-control setting" type="number" id="wp2_fine_tons"  value="<?php echo $settingsArry['settings']['wp2_fine_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 100 Mesh +70 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_fine_pls70"  value="<?php echo $settingsArry['settings']['wp2_fine_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 100 Mesh -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_fine_mns70pls140"  value="<?php echo $settingsArry['settings']['wp2_fine_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Wet Plant 2 100 Mesh -140 Percentage:</label>
            <input class="form-control setting" type="number" id="wp2_fine_mns140"  value="<?php echo $settingsArry['settings']['wp2_fine_mns140'] ?>">
          </div>
        </div>
      </div>

      <div id='rotary_settings_header' class='card-display-header'>
        <h5>Rotary Settings          
          <div style='display:none' id='arrow-up-rotary'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-rotary'>&#9660;</div>
        </h5>      
      </div>
      <div id="rotary_settings" style="display:none">
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Rotary Feed Tons:</label>
            <input class="form-control setting" type="number" id="rotary_feed_tons" value="<?php echo $settingsArry['settings']['rotary_feed_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Rotary Feed +70 Percentage:</label>
            <input class="form-control setting" type="number" id="rotary_feed_pls70" value="<?php echo $settingsArry['settings']['rotary_feed_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Rotary Feed -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="rotary_feed_mns70pls140"  value="<?php echo $settingsArry['settings']['rotary_feed_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Rotary Feed -140 Percentage:</label>
            <input class="form-control setting" type="number" id="rotary_feed_mns140"  value="<?php echo $settingsArry['settings']['rotary_feed_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>Rotary Output Tons:</label>
            <input class="form-control setting" type="number" id="rotary_output_tons"  value="<?php echo $settingsArry['settings']['rotary_output_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Rotary Output +70 Percentage:</label>
            <input class="form-control setting" type="number" id="rotary_output_pls70"  value="<?php echo $settingsArry['settings']['rotary_output_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>Rotary Output -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="rotary_output_mns70pls140"  value="<?php echo $settingsArry['settings']['rotary_output_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>Rotary Output -140 Percentage:</label>
            <input class="form-control setting" type="number" id="rotary_output_mns140"  value="<?php echo $settingsArry['settings']['rotary_output_mns140'] ?>">
          </div>
        </div>
      </div>
      <div id='carrier200_settings_header' class='card-display-header'>
        <h5>200T Carrier Settings          
          <div style='display:none' id='arrow-up-carrier200'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-carrier200'>&#9660;</div>
        </h5>      
      </div>
      <div id="carrier200_settings" style="display:none">
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>200T Carrier Feed Tons:</label>
            <input class="form-control setting" type="number" id="carrier200_feed_tons"  value="<?php echo $settingsArry['settings']['carrier200_feed_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>200T Carrier Feed +70 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier200_feed_pls70"  value="<?php echo $settingsArry['settings']['carrier200_feed_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>200T Carrier Feed -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier200_feed_mns70pls140"  value="<?php echo $settingsArry['settings']['carrier200_feed_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>200T Carrier Feed -140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier200_feed_mns140"  value="<?php echo $settingsArry['settings']['carrier200_feed_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>200T Carrier Output Tons:</label>
            <input class="form-control setting" type="number" id="carrier200_output_tons"  value="<?php echo $settingsArry['settings']['carrier200_output_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>200T Carrier Output +70 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier200_output_pls70"  value="<?php echo $settingsArry['settings']['carrier200_output_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>200T Carrier Output -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier200_output_mns70pls140"  value="<?php echo $settingsArry['settings']['carrier200_output_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>200T Carrier Output -140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier200_output_mns140"  value="<?php echo $settingsArry['settings']['carrier200_output_mns140'] ?>">
          </div>
        </div>
      </div>

      <div id='carrier100_settings_header' class='card-display-header'>
        <h5>100T Carrier Settings          
          <div style='display:none' id='arrow-up-carrier100'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-carrier100'>&#9660;</div>
        </h5>      
      </div>
      <div id="carrier100_settings" style="display:none">
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>100T Carrier Feed Tons:</label>
            <input class="form-control setting" type="number" id="carrier100_feed_tons"  value="<?php echo $settingsArry['settings']['carrier100_feed_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>100T Carrier Feed +70 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier100_feed_pls70"  value="<?php echo $settingsArry['settings']['carrier100_feed_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>100T Carrier Feed -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier100_feed_mns70pls140"  value="<?php echo $settingsArry['settings']['carrier100_feed_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>100T Carrier Feed -140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier100_feed_mns140"  value="<?php echo $settingsArry['settings']['carrier100_feed_mns140'] ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-3">
            <label>100T Carrier Output Tons:</label>
            <input class="form-control setting" type="number" id="carrier100_output_tons"  value="<?php echo $settingsArry['settings']['carrier100_output_tons'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>100T Carrier Output +70 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier100_output_pls70"  value="<?php echo $settingsArry['settings']['carrier100_output_pls70'] ?>">
          </div>
          <div class="form-group col-sm-3">
            <label>100T Carrier Output -70 +140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier100_output_mns70pls140"  value="<?php echo $settingsArry['settings']['carrier100_output_mns70pls140'] ?>">
          </div>           
          <div class="form-group col-sm-3">
            <label>100T Carrier Output -140 Percentage:</label>
            <input class="form-control setting" type="number" id="carrier100_output_mns140"  value="<?php echo $settingsArry['settings']['carrier100_output_mns140'] ?>">
          </div>
        </div>
      </div>
    </div>

    <div class='card-footer'>
      <button type="button" class="btn btn-vprop-green float-right" onclick="saveSetting()" value="Save Settings" style="float:right;">Save Settings</button>
    </div>
  </div>
  

    <div class="form-group form-inline">
      <input type='text' class="form-control" id='start-date' name='start-date' value="<?php echo $startDate; ?>">
      to
      <input type="text" class="form-control" name='end-date' id='end-date' value="<?php echo $endDate; ?>">
      <button type="submit" class="btn btn-vprop-green" id='date-button' style="margin-left: .5%;">Submit</button>
    </div>

  <div class="row">
    <div id="wetPlant1Col" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Wet Plant 1</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">

            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap " style="width:100%" id="wetPlant1Table">
              <thead class="th-vprop-blue">
                <tr>
                  <th colspan="1" style="background-color:#003087;"></th>
                  <th colspan="4">Tons</th>
                  <th Colspan="3">Rate (Tons / Hour)</th>
                  <th colspan="4">Sample (Actual)</th>
                  <th colspan="3">Sample (Target)</th>
                  <th colspan="3">Sample (Δ)</th>
                </tr>
                <tr class="th-vprop-blue-medium">
                  <th style="background-color:#4C7AD0; color: white;">Product</th>
                  <th>Actual</th>
                  <th>Target</th>
                  <th>Δ</th>
                  <th>% Target</th>
                  <th>Actual</th>
                  <th>Target</th>
                  <th>Δ</th>
                  <th>Moisture Rate</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <canvas id="wetplant1-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
          <canvas id="wetplant1-tph-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
        </div>
        <div class="card-footer">
        </div>
      </div>
    </div>
    <div id="wetPlant2Col" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Wet Plant 2</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">

            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-xl table-bordered nowrap " style="width:100%" id="wetPlant2Table">
            <thead class="th-vprop-blue">
              <tr>
                <th style="background-color:#003087;">&nbsp;</th>
                <th colspan="4">Tons</th>
                <th Colspan="3">Rate (Tons / Hour)</th>
                <th colspan="4">Sample (Actual)</th>
                <th colspan="3">Sample (Target)</th>
                <th colspan="3">Sample (Δ)</th>
              </tr>
              <tr class="th-vprop-blue-medium">
                <th style="background-color:#4C7AD0; color: white;">Product</th>
                <th>Actual</th>
                <th>Target</th>
                <th>Δ</th>
                <th>% Target</th>
                <th>Actual</th>
                <th>Target</th>
                <th>Δ</th>
                <th>Moisture Rate</th>
                <th>+70</th>
                <th>-70 +140</th>
                <th>-140</th>
                <th>+70</th>
                <th>-70 +140</th>
                <th>-140</th>
                <th>+70</th>
                <th>-70 +140</th>
                <th>-140</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
          <canvas id="wetplant2-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
          <canvas id="wetplant2-tph-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
        <div class="card-footer">
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div id="rotaryCol" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>Rotary</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap" style="width:100%;" id="rotaryTable">
              <thead>
                <tr class="th-vprop-blue">
                  <th class="th-vprop-blue">&nbsp;</th>
                  <th colspan="4">Tons</th>
                  <th Colspan="3">Rate (Tons / Hour)</th>
                  <th colspan="4">Sample (Actual)</th>
                  <th colspan="3">Sample (Target)</th>
                  <th colspan="3">Sample (Δ)</th>
                </tr>
                <tr class="th-vprop-blue-medium">
                  <th class="th-vprop-blue-medium"></th>
                  <th>Actual</th>
                  <th>Target(Average)</th>
                  <th>Δ</th>
                  <th>% Target</th>
                  <th>Actual</th>
                  <th>Target</th>
                  <th>Δ</th>
                  <th>Moisture Rate</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <canvas id="rotary-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
          <canvas id="rotary-tph-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
        </div>
        <div class="card-footer">
          <table class="table table-xl table-bordered nowrap" id="runtimes">
            <h3>Runtimes</h3>
            <thead class="th-vprop-blue-medium">
              <tr>
                  <th style="width: 25%">Uptime</th>
                  <th style="width: 25%">Scheduled Downtime</th>
                  <th style="width: 25%">Downtime</th>
                  <th style="width: 25%">Idletime</th>
              </tr>
            </thead>
            <tbody>
              <?php
              echo(
              "<td>{$rotaryUptimePercent}</td>"
               . "<td>{$rotarySchDowntimePercent}</td>"
              . "<td>{$rotaryDowntimePercent}</td>"
              . "<td>{$rotaryIdletimePercent}</td>"
              );
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div id="200TCarrierCol" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>200T Carrier</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap" id="200TCarrierTable">
              <thead>
                <tr class="th-vprop-blue">
                  <th class="th-vprop-blue">&nbsp;</th>
                  <th colspan="4">Tons</th>
                  <th Colspan="3">Rate (Tons / Hour)</th>
                  <th colspan="4">Sample (Actual)</th>
                  <th colspan="3">Sample (Target)</th>
                  <th colspan="3">Sample (Δ)</th>
                </tr>
                <tr class="th-vprop-blue-medium">
                  <th class="th-vprop-blue-medium"></th>
                  <th>Actual</th>
                  <th>Target(Average)</th>
                  <th>Δ</th>
                  <th>% Target</th>
                  <th>Actual</th>
                  <th>Target</th>
                  <th>Δ</th>
                  <th>Moisture Rate</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <canvas id="carrier200-table-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>
        <canvas id="carrier200-tph-chart-container" class='chart-canvas' width="50%" height="10%"></canvas>

        <div class="card-footer">
          <h3>Runtimes</h3>
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap" id="dashTable">
              <thead class="th-vprop-blue-medium">
                <tr>
                  <th style="width: 25%">Uptime</th>
                  <th style="width: 25%">Scheduled Downtime</th>
                  <th style="width: 25%">Downtime</th>
                  <th style="width: 25%">Idletime</th>
                </tr>
              </thead>
              <tbody>
                <?php
                echo(
                "<td>{$carrier200TUptimePercent}</td>"
                . "<td>{$carrier200TSchDowntimePercent}</td>"
                . "<td>{$carrier200TDowntimePercent}</td>"
                . "<td>{$carrier200TIdletimePercent}</td>"
                );
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div id="100TCarrierCol" class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <h2>100T Carrier</h2>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap" id="100TCarrierTable">
              <thead>
                <tr class="th-vprop-blue">
                  <th class="th-vprop-blue">&nbsp;</th>
                  <th colspan="4">Tons</th>
                  <th Colspan="3">Rate (Tons / Hour)</th>
                  <th colspan="4">Sample (Actual)</th>
                  <th colspan="4">Sample (Target)</th>
                  <th colspan="4">Sample (Δ)</th>
                </tr>
                <tr class="th-vprop-blue-medium">
                  <th class="th-vprop-blue-medium"></th>
                  <th>Actual</th>
                  <th>Target(Average)</th>
                  <th>Δ</th>
                  <th>% Target</th>
                  <th>Actual</th>
                  <th>Target</th>
                  <th>Δ</th>
                  <th>Moisture Rate</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                  <th>+70</th>
                  <th>-70 +140</th>
                  <th>-140</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <p style="margin-top: 10px;">* Estimated from 200T output</p>
          </div>
          <canvas id="carrier100-table-chart-container" class='chart-canvas hidden' width="50%" height="10%"></canvas>
          <canvas id="carrier100-tph-chart-container" class='chart-canvas hidden' width="50%" height="10%"></canvas>
        </div>
        <div class="card-footer">
          <h3>Runtimes</h3>
          <div class="table-responsive">
            <table class="table table-xl table-bordered nowrap" id="dashTable">
              <thead>
                <tr class="th-vprop-blue-medium">
                  <th style="width: 25%">Uptime</th>
                  <th style="width: 25%">Scheduled Downtime</th>
                  <th style="width: 25%">Downtime</th>
                  <th style="width: 25%">Idletime</th>
                </tr>
              </thead>
              <tbody>
                <?php
                echo(
                "<td>{$carrier100TUptimePercent}</td>"
                . "<td>{$carrier100TSchDowntimePercent}</td>"
                . "<td>{$carrier100TDowntimePercent}</td>"
                . "<td>{$carrier100TIdletimePercent}</td>"
                );
                ?>
              </tbody>

            </table>
 
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<script>

  $(document).ready(function () {
    var wetPlant1Table = $('#wetPlant1Table').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      fixedColumns: true,
      ordering:true,
      fixedColumn: {
        leftColumns: 1
      },
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        },                    
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue wp1-button',
//            action: function(){
//                $('#wetplant1-table-chart-container').toggle();
//              }
        }
      ]
    });
    var wetPlant2Table = $('#wetPlant2Table').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      fixedColumns: true,
      ordering:true,
      fixedColumn: {
        leftColumns: 1
      },
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        },                    
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue wp2-button',

        }
      ]
    });
    var rotaryTable = $('#rotaryTable').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      fixedColumns: true,
      fixedColumn: {
        leftColumns: 1
      },
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        },                    
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue rotary-button',
        }
      ]
    });
    var carrier200TTable = $('#200TCarrierTable').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      fixedColumns: true,
      fixedColumn: {
        leftColumns: 1
      },
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
        },                    
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue carrier200-button',
        }
      ]
    });
    var carrier100TTable = $('#100TCarrierTable').DataTable({
      dom: 'rtB',
      scrollY: false,
      scrollX: true,
      autoRowSize: true,
      scrollCollapse: true,
      fixedHeader: false,
      fixedColumns: true,
      fixedColumn: {
        leftColumns: 1
      },
      buttons: [
        {
          extend: 'copy',
          className: 'btn btn-vprop-blue'
        },
        {
          extend: 'excel',
          className: 'btn btn-vprop-green'
                },                    
        {
          text: '<i class="far fa-chart-bar chart-button" style="line-height:1.41;"></i>',
          className: 'btn-vprop-blue carrier100-button',
        }
      ]
    });

    $('.dt-buttons').removeClass('btn-group');
    $('.btn').removeClass('btn-secondary');

    //RefreshAllTables();
    
     $.when($.ajax(RefreshAllTables())).then(function () {
      //RefreshCharts();
    
});
//        RefreshCharts();
    $('.wp1-button').on('click' ,function ()
      {
        $("#wetplant1-table-chart-container").toggle('slow');
        $('#wetplant1-tph-chart-container').toggle('slow');
      }
      );
    $('.wp2-button').on('click' ,function ()
      {
        $("#wetplant2-table-chart-container").toggle('slow');
        $('#wetplant2-tph-chart-container').toggle('slow');
      }
      );
    $('.rotary-button').on('click' ,function ()
      {
        $("#rotary-table-chart-container").toggle('slow');
                $("#rotary-tph-chart-container").toggle('slow');
      }
      );
    $('.carrier200-button').on('click' ,function ()
      {
        $("#carrier200-table-chart-container").toggle('slow');
                $("#carrier200-tph-chart-container").toggle('slow');
      }
      );
    $('.carrier100-button').on('click' ,function ()
      {       
        RefreshCharts()
        $("#carrier100-table-chart-container").toggleClass('hidden');
        $("#carrier100-tph-chart-container").toggleClass('hidden');
      }
      );
  });


  $('.card-display-header').on('click', function () {

    $(this).find('div').first().toggleClass('display-inline-block ');
    $(this).find('div').first().next().toggle();
    $(this).next().slideToggle();
    $('html, body').animate('slow');

  });
  
  $('.setting').change(function() {
//           alert(this.val()) 
            $(this).removeClass('required-input');
          });
          
  $( "#date-button" ).click(function() {
    RefreshAllTables();
    });
        
  function addZero(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

  function formatDate(date) {
    var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            h = addZero(d.getHours()),
            m = addZero(d.getMinutes());

    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;

    return ([day, month, year].join('-') + ' ' + [h] + [m]);
  }

  $(function () {
    $("#start-date").datetimepicker({timepicker: false, format: 'Y-m-d'});
    $("#end-date").datetimepicker({timepicker: false, format: 'Y-m-d'});
  });

  function saveSetting() {

        //Wet Plant 1 Carrier Varification
      if($('#wp1_feed_tons').val() == 0 || $('#wp1_feed_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 Tons cannot be 0 or blank").fadeIn('slow')
          $('#wp1_feed_tons').parent().parent().parent().show();
          $('#wp1_feed_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_feed_pls70').val() == 0 || $('#wp1_feed_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 +70 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_feed_pls70').parent().parent().parent().show();
          $('#wp1_feed_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_feed_mns70pls140').val() == 0 || $('#wp1_feed_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_feed_mns70pls140').parent().parent().parent().show();
          $('#wp1_feed_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_feed_mns140').val() == 0 || $('#wp1_feed_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 -140 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_feed_mns140').parent().parent().parent().show();
          $('#wp1_feed_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_coarse_tons').val() == 0 || $('#wp1_coarse_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 Tons cannot be 0 or blank").fadeIn('slow')
          $('#wp1_coarse_tons').parent().parent().parent().show();
          $('#wp1_coarse_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_coarse_pls70').val() == 0 || $('#wp1_coarse_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 +70 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_coarse_pls70').parent().parent().parent().show();
          $('#wp1_coarse_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_coarse_mns70pls140').val() == 0 || $('#wp1_coarse_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_coarse_mns70pls140').parent().parent().parent().show();
          $('#wp1_coarse_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_coarse_mns140').val() == 0 || $('#wp1_coarse_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 -140 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_coarse_mns140').parent().parent().parent().show();
          $('#wp1_coarse_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_fine_tons').val() == 0 || $('#wp1_fine_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 Tons cannot be 0 or blank").fadeIn('slow')
          $('#wp1_fine_tons').parent().parent().parent().show();
          $('#wp1_fine_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_fine_pls70').val() == 0 || $('#wp1_fine_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 +70 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_fine_pls70').parent().parent().parent().show();
          $('#wp1_fine_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_fine_mns70pls140').val() == 0 || $('#wp1_fine_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_fine_mns70pls140').parent().parent().parent().show();
          $('#wp1_fine_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp1_fine_mns140').val() == 0 || $('#wp1_fine_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 1 -140 cannot be 0 or blank").fadeIn('slow');
          $('#wp1_fine_mns140').parent().parent().parent().show();
          $('#wp1_fine_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }

      //Wet Plant 2 Carrier Varification
      if($('#wp2_feed_tons').val() == 0 || $('#wp2_feed_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 Tons cannot be 0 or blank").fadeIn('slow')
          $('#wp2_feed_tons').parent().parent().parent().show();
          $('#wp2_feed_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_feed_pls70').val() == 0 || $('#wp2_feed_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 +70 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_feed_pls70').parent().parent().parent().show();
          $('#wp2_feed_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_feed_mns70pls140').val() == 0 || $('#wp2_feed_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_feed_mns70pls140').parent().parent().parent().show();
          $('#wp2_feed_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_feed_mns140').val() == 0 || $('#wp2_feed_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 -140 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_feed_mns140').parent().parent().parent().show();
          $('#wp2_feed_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_coarse_tons').val() == 0 || $('#wp2_coarse_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 Tons cannot be 0 or blank").fadeIn('slow')
          $('#wp2_coarse_tons').parent().parent().parent().show();
          $('#wp2_coarse_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_coarse_pls70').val() == 0 || $('#wp2_coarse_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 +70 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_coarse_pls70').parent().parent().parent().show();
          $('#wp2_coarse_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_coarse_mns70pls140').val() == 0 || $('#wp2_coarse_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_coarse_mns70pls140').parent().parent().parent().show();
          $('#wp2_coarse_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_coarse_mns140').val() == 0 || $('#wp2_coarse_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 -140 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_coarse_mns140').parent().parent().parent().show();
          $('#wp2_coarse_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_fine_tons').val() == 0 || $('#wp2_fine_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 Tons cannot be 0 or blank").fadeIn('slow')
          $('#wp2_fine_tons').parent().parent().parent().show();
          $('#wp2_fine_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_fine_pls70').val() == 0 || $('#wp2_fine_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 +70 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_fine_pls70').parent().parent().parent().show();
          $('#wp2_fine_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_fine_mns70pls140').val() == 0 || $('#wp2_fine_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_fine_mns70pls140').parent().parent().parent().show();
          $('#wp2_fine_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#wp2_fine_mns140').val() == 0 || $('#wp2_fine_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Wet Plant 2 -140 cannot be 0 or blank").fadeIn('slow');
          $('#wp2_fine_mns140').parent().parent().parent().show();
          $('#wp2_fine_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }

          //Rotary Carrier Varification
      if($('#carrier100_feed_tons').val() == 0 || $('#carrier100_feed_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary Tons cannot be 0 or blank").fadeIn('slow')
          $('#carrier100_feed_tons').parent().parent().parent().show();
          $('#carrier100_feed_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_feed_pls70').val() == 0 || $('#carrier100_feed_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary +70 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_feed_pls70').parent().parent().parent().show();
          $('#carrier100_feed_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_feed_mns70pls140').val() == 0 || $('#carrier100_feed_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_feed_mns70pls140').parent().parent().parent().show();
          $('#carrier100_feed_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_feed_mns140').val() == 0 || $('#carrier100_feed_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary -140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_feed_mns140').parent().parent().parent().show();
          $('#carrier100_feed_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_tons').val() == 0 || $('#carrier100_output_tons').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary Tons cannot be 0 or blank").fadeIn('slow')
          $('#carrier100_output_tons').parent().parent().parent().show();
          $('#carrier100_output_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_pls70').val() == 0 || $('#carrier100_output_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary +70 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_output_pls70').parent().parent().parent().show();
          $('#carrier100_output_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_mns70pls140').val() == 0 || $('#carrier100_output_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_output_mns70pls140').parent().parent().parent().show();
          $('#carrier100_output_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_mns140').val() == 0 || $('#carrier100_output_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for Rotary -140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_output_mns140').parent().parent().parent().show();
          $('#carrier100_output_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }

      //100T Carrier Varification
      if($('#carrier100_feed_tons').val() == 0 || $('#carrier100_feed_tons').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier Tons cannot be 0 or blank").fadeIn('slow')
          $('#carrier100_feed_tons').parent().parent().parent().show();
          $('#carrier100_feed_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_feed_pls70').val() == 0 || $('#carrier100_feed_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier +70 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_feed_pls70').parent().parent().parent().show();
          $('#carrier100_feed_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_feed_mns70pls140').val() == 0 || $('#carrier100_feed_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_feed_mns70pls140').parent().parent().parent().show();
          $('#carrier100_feed_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_feed_mns140').val() == 0 || $('#carrier100_feed_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier -140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_feed_mns140').parent().parent().parent().show();
          $('#carrier100_feed_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_tons').val() == 0 || $('#carrier100_output_tons').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier Tons cannot be 0 or blank").fadeIn('slow')
          $('#carrier100_output_tons').parent().parent().parent().show();
          $('#carrier100_output_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_pls70').val() == 0 || $('#carrier100_output_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier +70 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_output_pls70').parent().parent().parent().show();
          $('#carrier100_output_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_mns70pls140').val() == 0 || $('#carrier100_output_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_output_mns70pls140').parent().parent().parent().show();
          $('#carrier100_output_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier100_output_mns140').val() == 0 || $('#carrier100_output_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for 100T Carrier -140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier100_output_mns140').parent().parent().parent().show();
          $('#carrier100_output_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }

      //200T Carrier Varification
      if($('#carrier200_feed_tons').val() == 0 || $('#carrier200_feed_tons').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier Tons cannot be 0 or blank").fadeIn('slow')
          $('#carrier200_feed_tons').parent().parent().parent().show();
          $('#carrier200_feed_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_feed_pls70').val() == 0 || $('#carrier200_feed_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier +70 cannot be 0 or blank").fadeIn('slow');
          $('#carrier200_feed_pls70').parent().parent().parent().show();
          $('#carrier200_feed_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_feed_mns70pls140').val() == 0 || $('#carrier200_feed_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier200_feed_mns70pls140').parent().parent().parent().show();
          $('#carrier200_feed_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_feed_mns140').val() == 0 || $('#carrier200_feed_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier -140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier200_feed_mns140').parent().parent().parent().show();
          $('#carrier200_feed_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_output_tons').val() == 0 || $('#carrier200_output_tons').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier Tons cannot be 0 or blank").fadeIn('slow')
          $('#carrier200_output_tons').parent().parent().parent().show();
          $('#carrier200_output_tons').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_output_pls70').val() == 0 || $('#carrier200_output_pls70').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier +70 cannot be 0 or blank").fadeIn('slow');
          $('#carrier200_output_pls70').parent().parent().parent().show();
          $('#carrier200_output_pls70').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_output_mns70pls140').val() == 0 || $('#carrier200_output_mns70pls140').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier -70/+140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier200_output_mns70pls140').parent().parent().parent().show();
          $('#carrier200_output_mns70pls140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }
      if($('#carrier200_output_mns140').val() == 0 || $('#carrier200_output_mns140').val() == '' )
      {
          $('#failuremsg').html("Target for 200T Carrier -140 cannot be 0 or blank").fadeIn('slow');
          $('#carrier200_output_mns140').parent().parent().parent().show();
          $('#carrier200_output_mns140').addClass('required-input');
          $('#failuremsg').delay(5000).fadeOut('slow');
          return;
      }

      var settingsArry=
          { 'settings' :   
            { 
              'wp1_feed_tons' : $('#wp1_feed_tons').val(),
              'wp1_feed_pls70' : $('#wp1_feed_pls70').val(),
              'wp1_feed_mns70pls140' : $('#wp1_feed_mns70pls140').val(),
               'wp1_feed_mns140' : $('#wp1_feed_mns140').val(),
               'wp1_coarse_tons' : $('#wp1_coarse_tons').val(),
              'wp1_coarse_pls70' : $('#wp1_coarse_pls70').val(),
              'wp1_coarse_mns70pls140' : $('#wp1_coarse_mns70pls140').val(),
              'wp1_coarse_mns140' : $('#wp1_coarse_mns140').val(),
              'wp1_fine_tons' : $('#wp1_fine_tons').val(),
              'wp1_fine_pls70' : $('#wp1_fine_pls70').val(),
              'wp1_fine_mns70pls140' : $('#wp1_fine_mns70pls140').val(),
              'wp1_fine_mns140' : $('#wp1_fine_mns140').val(),
              'wp2_feed_tons' : $('#wp2_feed_tons').val(),
              'wp2_feed_pls70' : $('#wp2_feed_pls70').val(),
              'wp2_feed_mns70pls140' : $('#wp2_feed_mns70pls140').val(),
              'wp2_feed_mns140' : $('#wp2_feed_mns140').val(),
              'wp2_coarse_tons' : $('#wp2_coarse_tons').val(),
              'wp2_coarse_pls70' : $('#wp2_coarse_pls70').val(),
              'wp2_coarse_mns70pls140' : $('#wp2_coarse_mns70pls140').val(),
              'wp2_coarse_mns140' : $('#wp2_coarse_mns140').val(),
              'wp2_fine_tons' : $('#wp2_fine_tons').val(),
              'wp2_fine_pls70' : $('#wp2_fine_pls70').val(),
              'wp2_fine_mns70pls140' : $('#wp2_fine_mns70pls140').val(),
              'wp2_fine_mns140' : $('#wp2_fine_mns140').val(),
              'rotary_feed_tons' : $('#rotary_feed_tons').val(),
              'rotary_feed_pls70' : $('#rotary_feed_pls70').val(),
              'rotary_feed_mns70pls140' : $('#rotary_feed_mns70pls140').val(),
              'rotary_feed_mns140' : $('#rotary_feed_mns140').val(),
              'rotary_output_tons' : $('#rotary_output_tons').val(),
              'rotary_output_pls70' : $('#rotary_output_pls70').val(),
              'rotary_output_mns70pls140' : $('#rotary_output_mns70pls140').val(),
              'rotary_output_mns140' : $('#rotary_output_mns140').val(),
              'carrier100_feed_tons' : $('#carrier100_feed_tons').val(),
              'carrier100_feed_pls70' : $('#carrier100_feed_pls70').val(),
              'carrier100_feed_mns70pls140' : $('#carrier100_feed_mns70pls140').val(),
              'carrier100_feed_mns140' : $('#carrier100_feed_mns140').val(),
              'carrier100_output_tons' : $('#carrier100_output_tons').val(),
              'carrier100_output_pls70' : $('#carrier100_output_pls70').val(),
              'carrier100_output_mns70pls140' : $('#carrier100_output_mns70pls140').val(),
              'carrier100_output_mns140' : $('#carrier100_output_mns140').val(),
              'carrier200_feed_tons' : $('#carrier200_feed_tons').val(),
              'carrier200_feed_pls70' : $('#carrier200_feed_pls70').val(),
              'carrier200_feed_mns70pls140' : $('#carrier200_feed_mns70pls140').val(),
              'carrier200_feed_mns140' : $('#carrier200_feed_mns140').val(),
              'carrier200_output_tons' : $('#carrier200_output_tons').val(),
              'carrier200_output_pls70' : $('#carrier200_output_pls70').val(),
              'carrier200_output_mns70pls140' : $('#carrier200_output_mns70pls140').val(),
              'carrier200_output_mns140' : $('#carrier200_output_mns140').val()
            }
          };
          console.log(settingsArry);
          var jsonString = JSON.stringify(settingsArry)
          var site = "gb";

          $.ajax
          ({
              url: '../../Includes/Production/dashboardsettinginsert.php',
              type: 'POST',
              data:
                  {
                      json_string : jsonString,
                      site: site
                  },
              success: function (response) {
                  // $('#msg').html(data).fadeIn('slow');
                  $('#msg').html("Saved settings successfully").fadeIn('slow') //also show a success message
                  $('#msg').delay(5000).fadeOut('slow');
                  RefreshAllTables();
              }
          });
        }

  function RefreshAllTables()
  {
    var startDate = $('#start-date').val();
    var endDate = $('#end-date').val();

    $('#wetPlant1Table').DataTable().clear()
    DashboardAjaxCall
      (
      $('#wetPlant1Table').DataTable(), 'wetPlant1Fine','2. Fine', startDate,endDate,<?php echo $wetPlant1ConveyorFineId;?>,<?php echo $wetPlant1SampleFineId;?>,
      $('#wp1_fine_tons').val(),$('#wp1_fine_pls70').val(),1,1,$('#wp1_fine_mns140').val(),$('#wp1_fine_mns70pls140').val(),1
      );
    DashboardAjaxCall
      (
      $('#wetPlant1Table').DataTable(),'wetPlant1Coarse','3. Coarse', startDate,endDate,<?php echo $wetPlant1ConveyorCoarseId;?>,<?php echo $wetPlant1SampleCoarseId;?>,
      $('#wp1_coarse_tons').val(),$('#wp1_coarse_pls70').val(),1,1,$('#wp1_coarse_mns140').val(),$('#wp1_coarse_mns70pls140').val(),1
      );  
    DashboardAjaxCall
      (
      $('#wetPlant1Table').DataTable(),'wetPlant1Feed','1. Feed', startDate,endDate,<?php echo $wetPlant1ConveyorFeedId;?>,<?php echo $wetPlant1SampleFeedId;?>,
      $('#wp1_feed_tons').val(),$('#wp1_feed_pls70').val(),1,1,$('#wp1_feed_mns140').val(),$('#wp1_feed_mns70pls140').val(),1
      );   

    $('#wetPlant2Table').DataTable().clear()
    DashboardAjaxCall
      (
      $('#wetPlant2Table').DataTable(),'wetPlant2Fine','2. Fine', startDate,endDate,<?php echo $wetPlant2ConveyorFineId;?>,<?php echo $wetPlant2SampleFineId;?>,
      $('#wp2_fine_tons').val(),$('#wp2_fine_pls70').val(),1,1,$('#wp2_fine_mns140').val(),$('#wp2_fine_mns70pls140').val(),1
      );
    DashboardAjaxCall
      (
      $('#wetPlant2Table').DataTable(),'wetPlant2Coarse','3. Coarse', startDate,endDate,<?php echo $wetPlant2ConveyorCoarseId;?>,<?php echo $wetPlant2SampleCoarseId;?>,
      $('#wp2_coarse_tons').val(),$('#wp2_coarse_pls70').val(),1,1,$('#wp2_coarse_mns140').val(),$('#wp2_coarse_mns70pls140').val(),1
      );  
    DashboardAjaxCall
      (
      $('#wetPlant2Table').DataTable(),'wetPlant2Feed','1. Feed', startDate,endDate,<?php echo $wetPlant2ConveyorFeedId;?>,<?php echo $wetPlant2SampleFeedId;?>,
      $('#wp2_feed_tons').val(),$('#wp2_feed_pls70').val(),1,1,$('#wp2_feed_mns140').val(),$('#wp2_feed_mns70pls140').val(),1
      );

    $('#rotaryTable').DataTable().clear()
    DashboardAjaxCall
      (
      $('#rotaryTable').DataTable(),'rotaryOutput','Output',startDate,endDate,<?php echo $rotaryConveyorOutputId;?>,<?php echo $rotarySampleOutputId;?>,
      $('#rotary_output_tons').val(),$('#rotary_output_pls70').val(),1,1,$('#rotary_output_mns140').val(),$('#rotary_output_mns70pls140').val(),1
      );  
    DashboardAjaxCall
      (
      $('#rotaryTable').DataTable(),'rotaryFeed','Feed', startDate,endDate,<?php echo $rotaryConveyorFeedId;?>,<?php echo $rotarySampleFeedId;?>,
      $('#rotary_feed_tons').val(),$('#rotary_feed_pls70').val(),1,1,$('#rotary_feed_mns140').val(),$('#rotary_feed_mns70pls140').val(),1
      );

    $('#200TCarrierTable').DataTable().clear()
    DashboardAjaxCall
      (
      $('#200TCarrierTable').DataTable(),'carrier100Output','Output', startDate,endDate,<?php echo $carrier200TConveyorOutputId;?>,<?php echo $carrier200TSampleOutputId;?>,
      $('#carrier200_output_tons').val(),$('#carrier200_output_pls70').val(),1,1,$('#carrier200_output_mns140').val(),$('#carrier200_output_mns70pls140').val(),1
      );  
    DashboardAjaxCall
      (
      $('#200TCarrierTable').DataTable(),'carrier100Feed','Feed', startDate,endDate,<?php echo $carrier200TConveyorFeedId;?>,<?php echo $carrier200TSampleFeedId;?>,
      $('#carrier200_feed_tons').val(),$('#carrier200_feed_pls70').val(),1,1,$('#carrier200_feed_mns140').val(),$('#carrier200_feed_mns70pls140').val(),1
      );

    $('#100TCarrierTable').DataTable().clear()
     $.when($.ajax(DashboardAjaxCall
      (
      $('#100TCarrierTable').DataTable(),'carrier100Feed','Feed', startDate,endDate,<?php echo $carrier100TConveyorFeedId;?>,<?php echo $carrier100TSampleFeedId;?>,
      $('#carrier100_feed_tons').val(),$('#carrier100_feed_pls70').val(),1,1,$('#carrier100_feed_mns140').val(),$('#carrier100_feed_mns70pls140').val(),1
      ))).then(function () {
    $.when($.ajax(DashboardAjax100TCall
      (
      $('#100TCarrierTable').DataTable(),'carrier100Output','Output*', startDate,endDate,<?php echo $carrier100TConveyorOutputId;?>,<?php echo $carrier100TSampleOutputId;?>,
      $('#carrier100_output_tons').val(),$('#carrier100_output_pls70').val(),1,1,$('#carrier100_output_mns140').val(),$('#carrier100_output_mns70pls140').val(),1
      ))).then(function (){
        RefreshCharts();
      });
         

});


  }
  function RefreshCharts()
  {
    var wetPlant1Data = $('#wetPlant1Table').DataTable().rows().data();
    var wetPlant1FeedActual = wetPlant1Data[0][1];
    var wetPlant1FeedTarget = wetPlant1Data[0][2];
    var wetPlant1FeedTPH = wetPlant1Data[0][5];
    var wetPlant1FeedTrgtTPH = wetPlant1Data[0][6];
    var wetPlant1FineActual = wetPlant1Data[1][1];
    var wetPlant1FineTarget = wetPlant1Data[1][2];
    var wetPlant1FineTPH = wetPlant1Data[1][5];
    var wetPlant1FineTrgtTPH = wetPlant1Data[1][6];
    var wetPlant1CoarseActual = wetPlant1Data[2][1];
    var wetPlant1CoarseTarget = wetPlant1Data[2][2];
    var wetPlant1CoarseTPH = wetPlant1Data[2][5];
    var wetPlant1CoarseTrgtTPH = wetPlant1Data[2][6];
    var wp1TonsChart = $("#wetplant1-table-chart-container");
    var wp1TphChart = $("#wetplant1-tph-chart-container");
    var wetPlant1TableChart = new Chart(wp1TonsChart, {
     type: 'bar',
   data: {
       labels: ['Feed','Feed Target', 'Fine', 'Fine Target', 'Coarse','Coarse Target'],
       datasets: [{
           data: [wetPlant1FeedActual, wetPlant1FeedTarget, wetPlant1FineActual,wetPlant1FineTarget,wetPlant1CoarseActual,wetPlant1CoarseTarget],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(255, 206, 86, 0.2)',
               'rgba(255, 206, 86, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
              'rgba(255, 206, 86, 1)',
              'rgba(255, 206, 86, 1)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Vs Target'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    var wetPlant1TPHChart = new Chart(wp1TphChart, {
     type: 'bar',
   data: {
       labels: ['Feed','Feed Target', 'Fine', 'Fine Target', 'Coarse','Coarse Target'],
       datasets: [{
           data: [wetPlant1FeedTPH, wetPlant1FeedTrgtTPH, wetPlant1FineTPH,wetPlant1FineTrgtTPH,wetPlant1CoarseTPH,wetPlant1CoarseTrgtTPH],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(255, 206, 86, 0.2)',
               'rgba(255, 206, 86, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
              'rgba(255, 206, 86, 1)',
              'rgba(255, 206, 86, 1)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Per Hour'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    
    wp1TonsChart.hide();
    wp1TphChart.hide();
    
    var wetPlant2Data = $('#wetPlant2Table').DataTable().rows().data();
    var wetPlant2FeedActual = wetPlant2Data[0][1];
    var wetPlant2FeedTarget = wetPlant2Data[0][2];
    var wetPlant2FeedTPH = wetPlant2Data[0][5];
    var wetPlant2FeedTrgtTPH = wetPlant2Data[0][6];
    var wetPlant2FineActual = wetPlant2Data[1][1];
    var wetPlant2FineTarget = wetPlant2Data[1][2];
    var wetPlant2FineTPH = wetPlant2Data[1][5];
    var wetPlant2FineTrgtTPH = wetPlant2Data[1][6];
    var wetPlant2CoarseActual = wetPlant2Data[2][1];
    var wetPlant2CoarseTarget = wetPlant2Data[2][2];
    var wetPlant2CoarseTPH = wetPlant2Data[2][5];
    var wetPlant2CoarseTrgtTPH = wetPlant2Data[2][6];
    var wp2TonsChart = $("#wetplant2-table-chart-container");
    var wp2TphChart = $("#wetplant2-tph-chart-container");
    var wetPlant2TableChart = new Chart(wp2TonsChart, {
     type: 'bar',
   data: {
       labels: ['Feed','Feed Target', 'Fine', 'Fine Target', 'Coarse','Coarse Target'],
       datasets: [{
           data: [wetPlant2FeedActual, wetPlant2FeedTarget, wetPlant2FineActual,wetPlant2FineTarget,wetPlant2CoarseActual,wetPlant2CoarseTarget],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(255, 206, 86, 0.2)',
               'rgba(255, 206, 86, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
              'rgba(255, 206, 86, 1)',
              'rgba(255, 206, 86, 1)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Vs Target'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    var wetPlant2TPHChart = new Chart(wp2TphChart, {
     type: 'bar',
   data: {
       labels: ['Feed','Feed Target', 'Fine', 'Fine Target', 'Coarse','Coarse Target'],
       datasets: [{
           data: [wetPlant2FeedTPH, wetPlant2FeedTrgtTPH, wetPlant2FineTPH,wetPlant2FineTrgtTPH,wetPlant2CoarseTPH,wetPlant2CoarseTrgtTPH],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(255, 206, 86, 0.2)',
               'rgba(255, 206, 86, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
              'rgba(255, 206, 86, 1)',
              'rgba(255, 206, 86, 1)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Per Hour'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    wp2TonsChart.hide();
    wp2TphChart.hide();
      

    var rotaryData = $('#rotaryTable').DataTable().rows().data();
    var rotaryFeedActual = rotaryData[0][1];
    var rotaryFeedTarget = rotaryData[0][2];
    var rotaryFeedTPH = rotaryData[0][5];
    var rotaryFeedTrgtTPH = rotaryData[0][6];
    var rotaryOutputActual = rotaryData[1][1];
    var rotaryOutputTarget = rotaryData[1][2];
    var rotaryOutputTPH = rotaryData[1][5];
    var rotaryOutputTrgtTPH = rotaryData[1][6];
    var rotaryChart = $("#rotary-table-chart-container");
    var rotaryTphChart = $("#rotary-tph-chart-container");
    var rotaryTableChart = new Chart(rotaryChart, {
     type: 'bar',
      data: {
       labels: ['Feed','Feed Target', 'Output', 'Output Target'],
       datasets: [{
           data: [rotaryFeedActual, rotaryFeedTarget, rotaryOutputActual,rotaryOutputTarget],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Vs Target'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    var rotaryTableChart = new Chart(rotaryTphChart, {
     type: 'bar',
      data: {
       labels: ['Feed','Feed Target', 'Output', 'Output Target'],
       datasets: [{
           data: [rotaryFeedTPH, rotaryFeedTrgtTPH, rotaryOutputTPH,rotaryOutputTrgtTPH],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Per Hour'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    rotaryChart.hide();
    rotaryTphChart.hide();

    var carrier200Data = $('#200TCarrierTable').DataTable().rows().data();
    var carrier200FeedActual = carrier200Data[0][1];
    var carrier200FeedTarget = carrier200Data[0][2];
    var carrier200FeedTPH = carrier200Data[0][5];
    var carrier200FeedTrgtTPH = carrier200Data[0][6];
    var carrier200OutputActual = carrier200Data[1][1];
    var carrier200OutputTarget = carrier200Data[1][2];
    var carrier200OutputTPH = carrier200Data[1][5];
    var carrier200OutputTrgtTPH = carrier200Data[1][6];
    var carrier200Chart = $("#carrier200-table-chart-container");
    var carrier200TphChart = $("#carrier200-tph-chart-container");
    var carrier200TableChart = new Chart(carrier200Chart, {
     type: 'bar',
      data: {
       labels: ['Feed','Feed Target', 'Output', 'Output Target'],
       datasets: [{
           data: [carrier200FeedActual, carrier200FeedTarget, carrier200OutputActual,carrier200OutputTarget],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Vs Target'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    var carrier200TableChart = new Chart(carrier200TphChart, {
     type: 'bar',
      data: {
       labels: ['Feed','Feed Target', 'Output', 'Output Target'],
       datasets: [{
           data: [carrier200FeedTPH, carrier200FeedTrgtTPH, carrier200OutputTPH,carrier200OutputTrgtTPH],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Per Hour'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    carrier200Chart.hide();
    carrier200TphChart.hide();
    
    var carrier100Data = $('#100TCarrierTable').DataTable().rows().data();
    var carrier100FeedActual = carrier100Data[0][1];
    var carrier100FeedTarget = carrier100Data[0][2];
    var carrier100FeedTPH = carrier100Data[0][5];
    var carrier100FeedTrgtTPH = carrier100Data[0][6];
    var carrier100OutputActual = carrier100Data[1][1];
    var carrier100OutputTarget = carrier100Data[1][2];
    var carrier100OutputTPH = carrier100Data[1][5];
    var carrier100OutputTrgtTPH = carrier100Data[1][6];
    var carrier100Chart = $("#carrier100-table-chart-container");
    var carrier100TphChart = $("#carrier100-tph-chart-container");
    var carrier100TableChart = new Chart(carrier100Chart, {
     type: 'bar',
      data: {
       labels: ['Feed','Feed Target', 'Output', 'Output Target'],
       datasets: [{
           data: [carrier100FeedActual, carrier100FeedTarget, carrier100OutputActual,carrier100OutputTarget],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Vs Target'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 
    var carrier100TableChart = new Chart(carrier100TphChart, {
     type: 'bar',
      data: {
       labels: ['Feed','Feed Target', 'Output', 'Output Target'],
       datasets: [{
           data: [carrier100FeedTPH, carrier100FeedTrgtTPH, carrier100OutputTPH,carrier100OutputTrgtTPH],
           backgroundColor: [
               'rgba(76, 122, 208, 0.2)',
                'rgba(76, 122, 208, 0.2)',
               'rgba(120, 214, 75, 0.2)',
               'rgba(120, 214, 75, 0.2)',
           ],
           borderColor: [
              'rgba(76, 122, 208)',
              'rgba(76, 122, 208)',
              'rgba(120, 214, 75)',
              'rgba(120, 214, 75)',
           ],
           borderWidth: 1
       }]
   },
    options: {
       legend: {
           display: false
       },
       title: {
           display: true,
           text: 'Tons Per Hour'
       },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
  }); 

    //carrier100Chart.hide();
            

  }
  function DashboardAjaxCall(table, jsonRow, rowTitle, startDate, endDate, conveyorId, locationId, tonsSetting, pls70Setting, mns70Setting, pls140Setting, mns140Setting, mns70pls140Setting, mns40pls70Setting)
    {
      $.ajax
              ({
                dataType: "html",
                type: 'POST',
                url: '../../Includes/Production/dashboardquery.php',
                data:
                        {
                          start_date: startDate,
                          end_date: endDate,
                          conveyor_id: conveyorId,
                          location_id: locationId,
                          tons_setting: tonsSetting,
                          pls70_setting: pls70Setting,
                          mns70_setting: mns70Setting,
                          pls140_setting: pls140Setting,
                          mns140_setting: mns140Setting,
                          mns70pls140_setting: mns70pls140Setting,
                          mns40pls70_setting: mns40pls70Setting,
                          json_row: jsonRow
                        },
                success: function (data)
                {
                  //alert(data);
                  //console.log(data);
                  var dsbdData = JSON.parse(data);
                  //console.log(dsbdData);
                  table.row.add([
                    rowTitle,
                    dsbdData.tons,
                    dsbdData.trgt_tons,
                    dsbdData.tons_diff,
                    dsbdData.percent_trgt_tons,
                    dsbdData.tph,
                    dsbdData.trgt_tph,
                    dsbdData.tph_diff,
                    dsbdData.moisture_rate,
                    dsbdData.pls70,
                    dsbdData.mns70pls140,
                    dsbdData.mns140,
                    dsbdData.pls70_trgt,
                    dsbdData.mns70pls140_trgt,
                    dsbdData.mns140_trgt,
                    dsbdData.pls70_diff,
                    dsbdData.mns70pls140_diff,
                    dsbdData.mns140_diff
                  ]).draw();

                }

              });
    }


  function DashboardAjax100TCall(table, jsonRow, rowTitle, startDate, endDate, conveyorId, locationId, tonsSetting, pls70Setting, mns70Setting, pls140Setting, mns140Setting, mns70pls140Setting, mns40pls70Setting)
  {
    $.ajax
            ({
              dataType: "html",
              type: 'POST',
              url: '../../Includes/Production/dashboardquery.php',
              data:
                      {
                        start_date: startDate,
                        end_date: endDate,
                        conveyor_id: conveyorId,
                        location_id: locationId,
                        tons_setting: tonsSetting,
                        pls70_setting: pls70Setting,
                        mns70_setting: mns70Setting,
                        pls140_setting: pls140Setting,
                        mns140_setting: mns140Setting,
                        mns70pls140_setting: mns70pls140Setting,
                        mns40pls70_setting: mns40pls70Setting,
                        json_row: jsonRow
                      },
              success: function (data)
              {
                //alert(data);
                //console.log(data);
                var dsbdData = JSON.parse(data);
                //console.log(dsbdData);
                var c200tData = $('#200TCarrierTable').DataTable().rows().data();
                var c100tData = $('#100TCarrierTable').DataTable().rows().data();

                var c200tFeedActual = c200tData[0][1];
                var c200tOutputActual = c200tData[1][1];
                var ratio = c200tOutputActual/c200tFeedActual;
                var c100tOutputEstimate = (ratio * c100tData[0][1]).toFixed(0);
                var tonsDelta = dsbdData.trgt_tons - c100tOutputEstimate;
                var tph = (c100tOutputEstimate / dsbdData.days /24).toFixed(2);
                var tphDelta = (dsbdData.trgt_tph - tph).toFixed(2);

                var percent = ((c100tOutputEstimate / dsbdData.trgt_tons) * 100).toFixed(2) + '%';

                table.row.add([
                  rowTitle,
                  c100tOutputEstimate,
                  dsbdData.trgt_tons,
                  tonsDelta,
                  percent,
                  tph,
                  dsbdData.trgt_tph,
                  tphDelta,
                  dsbdData.moisture_rate,
                  dsbdData.pls70,
                  dsbdData.mns70pls140,
                  dsbdData.mns140,
                  dsbdData.pls70_trgt,
                  dsbdData.mns70pls140_trgt,
                  dsbdData.mns140_trgt,
                  dsbdData.pls70_diff,
                  dsbdData.mns70pls140_diff,
                  dsbdData.mns140_diff
                ]).draw();

              }

            });
  }
</script>