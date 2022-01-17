<?php
/* * *****************************************************************************************************************************************
 * File Name: kpidashboard_tl.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/09/2018|nolliff|KACE:17504 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
require_once('../../Includes/Production/gb_plc_tagGlobal.php');

$userId = $_SESSION['user_id'];

//Wet Plants
$tlWetPlantConveyorFeedId = 12;
$tlWetPlantConveyorOutputId = 1;

$tlWetPlantTPHFeedId = 19;
$tlWetPlantTPHOutputId = 1;
//Dry Plants

$tlRotaryConveyorStackerId = 2;
$tlRotaryConveyorHopperId = 1;
$tlRotaryConveyorOutputId = 5;

$tlRotaryTPHStackerId = 21;
$tlRotaryTPHHopperId = 20;
$tlRotaryTPHOutputId = 22;

//<editor-fold defaultstate="collapsed" desc=" Default Settings ">
$tlWetPlantConveyorFeedDefSettings = array
    (
    'maxGauge' => 900,
    'warningLimit' => 600,
    'actionLimit' => 300
  );
$tlWetPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 900,
    'warningLimit' => 600,
    'actionLimit' => 300
  );


$tlRotaryPlantConveyorStackerDefSettings = array
    (
    'maxGauge' => 450,
    'warningLimit' => 300,
    'actionLimit' => 150
  );
$tlRotaryPlantConveyorHopperDefSettings = array
    (
    'maxGauge' => 450,
    'warningLimit' => 300,
    'actionLimit' => 150
  );
$tlRotaryPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 450,
    'warningLimit' => 300,
    'actionLimit' => 150
  );

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Get user Settings ">

$tlWetPlantConveyorFeedSettings = getSettings($userId, $tlWetPlantConveyorFeedId, $tlWetPlantConveyorFeedDefSettings);
$tlWetPlantConveyorOutputSettings = getSettings($userId, $tlWetPlantConveyorOutputId, $tlWetPlantConveyorOutputDefSettings);

$tlRotaryPlantConveyorStackerSettings = getSettings($userId, $tlRotaryConveyorStackerId, $tlRotaryPlantConveyorStackerDefSettings);
$tlRotaryPlantConveyorHopperSettings = getSettings($userId, $tlRotaryConveyorHopperId, $tlRotaryPlantConveyorHopperDefSettings);
$tlRotaryPlantConveyorOutputSettings = getSettings($userId, $tlRotaryConveyorOutputId, $tlRotaryPlantConveyorOutputDefSettings);


// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tons Per Hour ">
$tlWetPlantFeedTPH = TonsPerHour($tlWetPlantTPHFeedId);
$tlWetPlantOutputTPH = TonsPerHour($tlWetPlantTPHOutputId);

$tlRotaryStackerTPH = TonsPerHour($tlRotaryTPHStackerId);
$tlRotaryHopperTPH = TonsPerHour($tlRotaryTPHHopperId);
$tlRotaryOutputTPH = TonsPerHour($tlRotaryTPHOutputId);

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Shift Totals ">
$tlWetPlantFeedShiftTotal = ShiftTotal($tlWetPlantConveyorFeedId);
$tlWetPlantOutputShiftTotal = ShiftTotal($tlWetPlantConveyorOutputId);

$tlRotaryStackerShiftTotal = ShiftTotal($tlRotaryConveyorStackerId);
$tlRotaryHopperShiftTotal = ShiftTotal($tlRotaryConveyorHopperId);
$tlRotaryOutputShiftTotal = ShiftTotal($tlRotaryConveyorOutputId);
// </editor-fold>



function getSettings($userId, $tagId, $settings)
  {
    $settingsSql = "CALL sp_tl_plc_UserThresholdGet(". $tagId . "," . $userId .")";
    $settingsResults = mysqli_query(dbmysqli(), $settingsSql);
    if(mysqli_num_rows($settingsResults) === 0){return $settings;}
    else 
      {
        while($settingRes = $settingsResults->fetch_assoc())
          {
            if($settingRes['gauge_max'] != '' && $settingRes['gauge_max'] != null)
              {
                $settings['maxGauge'] = $settingRes['gauge_max'];
              }

            if($settingRes['gauge_action_limit'] != '' && $settingRes['gauge_action_limit'] != null)
              {
                $settings['actionLimit'] = $settingRes['gauge_action_limit'];
              }

            if($settingRes['gauge_warning_limit'] != '' && $settingRes['gauge_warning_limit'] != null)
              {
                $settings['warningLimit'] = $settingRes['gauge_warning_limit'];
              }

              return $settings;
          }
      }
  }
  
function TonsPerHour($beltId)
  {
    $latestValuesSql = "CALL sp_tl_plc_10minuteMaxIdByTagGet(". $beltId . ")";
//    echo($latestValuesSql . "<br>");
    $latestValuesResults = mysqli_query(dbmysqli(), $latestValuesSql);
    $tonsPerHour = 0;
    while($latestValuesResult = $latestValuesResults->fetch_assoc())
      {
           $tonsPerHour = round($latestValuesResult['Current Value'] , 0);
      }
    //echo($tonsPerHour . "<br>");
    return $tonsPerHour;
  }
  
 function ShiftTotal($beltId)
  {
    
    $latestValuesSql = "CALL sp_tl_plc_10minuteMaxIdByTagGet(". $beltId . ")";
    //echo($latestValuesSql);
    $latestValuesResults = mysqli_query(dbmysqli(), $latestValuesSql);
    $shiftTotal = 0;
    while($latestValuesResult = $latestValuesResults->fetch_assoc())
      {
        $shiftTotal = $latestValuesResult['Current Value'];

      }
    //echo($tonsPerHour . "<br>");
    return $shiftTotal;
  }
//========================================================================================== END PHP
?>

<!-- HTML -->
    

    
<script src="../../Includes/gaugeSVG/javascript/gaugeSVG.js"></script>
    <script>
      window.onload = function(){
        
        var TlWetPlantFeed = new SilicoreGauge({
          id: "tlwpfeed",
          value: .01,
          title: "Wet Plant Feed",
          label: "Tons/Hour",
          gaugeWidthScale: 1.0,
          min: 0.0,
          max: <?php echo $tlWetPlantConveyorFeedSettings['maxGauge']; ?>,
          lowerActionLimit:  <?php echo $tlWetPlantConveyorFeedSettings['actionLimit']; ?>,
          lowerWarningLimit:  <?php echo $tlWetPlantConveyorFeedSettings['warningLimit']; ?>,
          upperWarningLimit:  <?php echo $tlWetPlantConveyorFeedSettings['maxGauge']; ?>,
          upperActionLimit: -1,
          needleColor: "#000000",
          optimumRangeColor: "#78D64B",
          warningRangeColor: "#FFCC00",
          actionRangeColor: "#FF0000"
        });
        
        var TlWetPlantOutput = new SilicoreGauge({
          id: "tlwpoutput",
          value: .01,
          title: "Wet Plant Output",
          label: "Tons/Hour",
          gaugeWidthScale: 1.0,
          min: 0.0,
          max: <?php echo $tlWetPlantConveyorOutputSettings['maxGauge']; ?>,
          lowerActionLimit:  <?php echo $tlWetPlantConveyorOutputSettings['actionLimit']; ?>,
          lowerWarningLimit:  <?php echo $tlWetPlantConveyorOutputSettings['warningLimit']; ?>,
          upperWarningLimit:  <?php echo $tlWetPlantConveyorOutputSettings['maxGauge']; ?>,
          upperActionLimit: -1,
          needleColor: "#000000",
          optimumRangeColor: "#78D64B",
          warningRangeColor: "#FFCC00",
          actionRangeColor: "#FF0000"
        });
      
        var TlRotaryStacker= new SilicoreGauge({
          id: "tlrotarystacker",
          value: .01,
          title: "Rotary Stacker Feed",
          label: "Tons/Hour",
          gaugeWidthScale: 1.0,
          min: 0.0,
          max: <?php echo $tlRotaryPlantConveyorStackerSettings['maxGauge']; ?>,
          lowerActionLimit:  <?php echo $tlRotaryPlantConveyorStackerSettings['actionLimit']; ?>,
          lowerWarningLimit:  <?php echo $tlRotaryPlantConveyorStackerSettings['warningLimit']; ?>,
          upperWarningLimit:  <?php echo $tlRotaryPlantConveyorStackerSettings['maxGauge']; ?>,
          upperActionLimit: -1,
          needleColor: "#000000",
          optimumRangeColor: "#78D64B",
          warningRangeColor: "#FFCC00",
          actionRangeColor: "#FF0000"
        });
      
        var TlRotaryHopper  = new SilicoreGauge({
          id: "tlrotaryhopper",
          value: .01,
          title: "Rotary Hopper Feed",
          label: "Tons/Hour",
          gaugeWidthScale: 1.0,
          min: 0.0,
          max: <?php echo $tlRotaryPlantConveyorHopperSettings['maxGauge']; ?>,
          lowerActionLimit:  <?php echo $tlRotaryPlantConveyorHopperSettings['actionLimit']; ?>,
          lowerWarningLimit:  <?php echo $tlRotaryPlantConveyorHopperSettings['warningLimit']; ?>,
          upperWarningLimit:  <?php echo $tlRotaryPlantConveyorHopperSettings['maxGauge']; ?>,
          upperActionLimit: -1,
          needleColor: "#000000",
          optimumRangeColor: "#78D64B",
          warningRangeColor: "#FFCC00",
          actionRangeColor: "#FF0000"
        });
        
        var TlRotaryOutput  = new SilicoreGauge({
          id: "tlrotaryoutput",
          value: .01,
          title: "Rotary Output",
          label: "Tons/Hour",
          gaugeWidthScale: 1.0,
          min: 0.0,
          max: <?php echo $tlRotaryPlantConveyorOutputSettings['maxGauge']; ?>,
          lowerActionLimit:  <?php echo $tlRotaryPlantConveyorOutputSettings['actionLimit']; ?>,
          lowerWarningLimit:  <?php echo $tlRotaryPlantConveyorOutputSettings['warningLimit']; ?>,
          upperWarningLimit:  <?php echo $tlRotaryPlantConveyorOutputSettings['maxGauge']; ?>,
          upperActionLimit: -1,
          needleColor: "#000000",
          optimumRangeColor: "#78D64B",
          warningRangeColor: "#FFCC00",
          actionRangeColor: "#FF0000"
        });
         
        setInterval(function() { 
          
          TlWetPlantFeed.refresh(<?php echo($tlWetPlantFeedTPH); ?>, true);
          TlWetPlantOutput.refresh(<?php echo($tlWetPlantOutputTPH); ?>, true);
          
          TlRotaryStacker.refresh(<?php echo($tlRotaryStackerTPH); ?>, true);
          TlRotaryHopper.refresh(<?php echo($tlRotaryHopperTPH); ?>, true);
          TlRotaryOutput.refresh(<?php echo($tlRotaryOutputTPH); ?>, true);

          var elements = document.querySelectorAll('.svg-container');
          for(var i=0; i<elements.length; i++)
          {
            elements[i].style.width = 300 + "px";
            elements[i].style.height = 250 + 'px';
          }
          
          
        }, 2000);
      };
    </script>
<meta http-equiv="refresh" content="600" >
<h3>Tolar</h3>
<div class="prodtable">
  <table>
    <thead>
      <tr>
        <th colspan="100%">Shift Totals</th>
      </tr>
      <tr>
        <th>Wet Plant Feed</th>
        <th>Wet Plant Output</th>
        <th>Rotary Stacker</th>
        <th>Rotary Hopper</th>
        <th>Rotary Output</th>
      </tr>
    </thead>
    <tbody>
      <tr>
<?php
  echo(""
        . "<td>{$tlWetPlantFeedShiftTotal}</td>"
        . "<td>{$tlWetPlantOutputShiftTotal}</td>"        
        . "<td>{$tlRotaryStackerShiftTotal}</td>"
        . "<td>{$tlRotaryHopperShiftTotal}</td>"
        . "<td>{$tlRotaryOutputShiftTotal}</td>");
?>
      </tr>
    </tbody>
  </table>
</div>    
    <div class="svg-container" id="tlrotarystacker"></div>
    <div class="svg-container" id="tlrotaryhopper"></div>
    <div class="svg-container" id="tlrotaryoutput"></div>
  <br>
    <div class="svg-container" id="tlwpfeed"></div>
    <div class="svg-container" id="tlwpoutput"></div>
  <br>

                                                       
<style>      
.svg-container
{
  width:260px; height:200px;
  display: inline-block;
  margin: 1em;
  margin-left: 10%;
}
</style>
    
    