<?php
/* * *****************************************************************************************************************************************
 * File Name: kpidashboard.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/13/2017|kkuehn|KACE:17504 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
require_once('../../Includes/Production/gb_plc_tagGlobal.php');

$mobile = $_SESSION['user_agent'];

$userId = $_SESSION['user_id'];

// <editor-fold defaultstate="collapsed" desc=" Granbury ">
//Wet Plants
$gbNewWetPlantConveyorFeedId = 4;
$gbNewWetPlantConveyorCoarseId = 12;
$gbNewWetPlantConveyorFineId = 16;

$gbOldWetPlantConveyorFeedId = 8;
$gbOldWetPlantConveyorCoarseId = 2;
$gbOldWetPlantConveyorFineId = 3;

$gbNewWetPlantTPHFeedId = 5;
$gbNewWetPlantTPHCoarseId = 13;
$gbNewWetPlantTPHFineId = 17;

$gbOldWetPlantTPHFeedId = 9;
$gbOldWetPlantTPHCoarseId = 72;
$gbOldWetPlantTPHFineId = 73;


//Dry Plants

$gbRotaryConveyorFeedId = 18;
$gbRotaryConveyorOutputId = 26;
$gbRotaryGasFlowId = 30;

$gbCarrier100TConveyorFeedId = 28;
$gbCarrier100TConveyorOutputId = 0;
$gbCarrier100TGasFlowId = 29;

$gbCarrier200TConveyorFeedId = 22;
$gbCarrier200TConveyorOutputId = 24;
$gbCarrier200TGasFlowId = 32;


$gbRotaryTPHFeedId = 19;
$gbRotaryTPHOutputId = 27;

$gbCarrier100TTPHFeedId = 28;
$gbCarrier100TTPHOutputId = 0;

$gbCarrier200TTPHFeedId = 23;
$gbCarrier200TTPHOutputId = 25;

//<editor-fold defaultstate="collapsed" desc=" Default Settings ">
$gbNewWetPlantConveyorFeedDefSettings = array
    (
    'maxGauge' => 1200,
    'warningLimit' => 800,
    'actionLimit' => 400
  );
$gbNewWetPlantConveyorFineDefSettings = array
    (
    'maxGauge' => 800,
    'warningLimit' => 600,
    'actionLimit' => 300
  );
$gbNewWetPlantConveyorCoarseDefSettings = array
    (
    'maxGauge' => 400,
    'warningLimit' => 600,
    'actionLimit' => 300
  );

$gbOldWetPlantConveyorFeedDefSettings = array
    (
    'maxGauge' => 600,
    'warningLimit' => 600,
    'actionLimit' => 300
  );
$gbOldWetPlantConveyorFineDefSettings = array
    (
    'maxGauge' => 600,
    'warningLimit' => 600,
    'actionLimit' => 300
  );
$gbOldWetPlantConveyorCoarseDefSettings = array
    (
    'maxGauge' => 200,
    'warningLimit' => 600,
    'actionLimit' => 300
  );

$gbCarrier100TPlantConveyorFeedDefSettings = array
    (
    'maxGauge' => 200,
    'warningLimit' => 300,
    'actionLimit' => 150
  );
$gbCarrier100TPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 200,
    'warningLimit' => 300,
    'actionLimit' => 150
  );

$gbCarrier200TPlantConveyorFeedDefSettings = array
    (
    'maxGauge' => 300,
    'warningLimit' => 300,
    'actionLimit' => 150
  );
$gbCarrier200TPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 300,
    'warningLimit' => 300,
    'actionLimit' => 150
  );

$gbRotaryPlantConveyorFeedDefSettings = array
    (
    'maxGauge' => 300,
    'warningLimit' => 300,
    'actionLimit' => 150
  );
$gbRotaryPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 600,
    'warningLimit' => 300,
    'actionLimit' => 150
  );

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Get user Settings ">

$gbNewWetPlantConveyorFeedSettings = getSettings($userId, $gbNewWetPlantConveyorFeedId, $gbNewWetPlantConveyorFeedDefSettings, 'gb');
$gbNewWetPlantConveyorFineSettings = getSettings($userId, $gbNewWetPlantConveyorFineId, $gbNewWetPlantConveyorFineDefSettings, 'gb');
$gbNewWetPlantConveyorCoarseSettings = getSettings($userId, $gbNewWetPlantConveyorCoarseId, $gbNewWetPlantConveyorCoarseDefSettings, 'gb');

$gbOldWetPlantConveyorFeedSettings = getSettings($userId, $gbOldWetPlantConveyorFeedId, $gbOldWetPlantConveyorFeedDefSettings, 'gb');
$gbOldWetPlantConveyorFineSettings = getSettings($userId, $gbOldWetPlantConveyorFineId, $gbOldWetPlantConveyorFineDefSettings, 'gb');
$gbOldWetPlantConveyorCoarseSettings = getSettings($userId, $gbOldWetPlantConveyorCoarseId, $gbOldWetPlantConveyorCoarseDefSettings, 'gb');

$gbCarrier100TPlantConveyorFeedSettings = getSettings($userId, $gbCarrier100TConveyorFeedId, $gbCarrier100TPlantConveyorFeedDefSettings, 'gb');
$gbCarrier100TPlantConveyorOutputSettings = getSettings($userId, $gbCarrier100TConveyorOutputId, $gbCarrier100TPlantConveyorOutputDefSettings, 'gb');

$gbCarrier200TPlantConveyorFeedSettings = getSettings($userId, $gbCarrier200TConveyorFeedId, $gbCarrier200TPlantConveyorFeedDefSettings, 'gb');
$gbCarrier200TPlantConveyorOutputSettings = getSettings($userId, $gbCarrier200TConveyorOutputId, $gbCarrier200TPlantConveyorOutputDefSettings, 'gb');

$gbRotaryPlantConveyorFeedSettings = getSettings($userId, $gbRotaryConveyorFeedId, $gbRotaryPlantConveyorFeedDefSettings, 'gb');
$gbRotaryPlantConveyorOutputSettings = getSettings($userId, $gbRotaryConveyorOutputId, $gbRotaryPlantConveyorOutputDefSettings, 'gb');

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tons Per Hour ">
$gbNewWetPlantFeedTPH = TonsPerHour($gbNewWetPlantTPHFeedId, 'gb');
$gbNewWetPlantCoarseTPH = TonsPerHour($gbNewWetPlantTPHCoarseId, 'gb');
$gbNewWetPlantFineTPH = TonsPerHour($gbNewWetPlantTPHFineId, 'gb');

$gbOldWetPlantFeedTPH = TonsPerHour($gbOldWetPlantTPHFeedId, 'gb');
$gbOldWetPlantCoarseTPH = TonsPerHour($gbOldWetPlantTPHCoarseId, 'gb');
$gbOldWetPlantFineTPH = TonsPerHour($gbOldWetPlantTPHFineId, 'gb');

$gbRotaryFeedTPH = TonsPerHour($gbRotaryTPHFeedId, 'gb');
$gbRotaryOutputTPH = TonsPerHour($gbRotaryTPHOutputId, 'gb');
$gbRotaryGasPerHour = TonsPerHour($gbRotaryGasFlowId, 'gb');

$gbCarrier100TFeedTPH = TonsPerHour($gbCarrier100TTPHFeedId, 'gb');
//$gbCarrier100TOutputTPH = TonsPerHour($gbCarrier100TTPHOutputId);
$gbCarrier100TGasPerHour = TonsPerHour($gbCarrier100TGasFlowId, 'gb');

$gbCarrier200TFeedTPH = TonsPerHour($gbCarrier200TTPHFeedId, 'gb');

$gbCarrier200TOutputTPH = TonsPerHour($gbCarrier200TTPHOutputId, 'gb');
//echo $gbCarrier200TOutputTPH;
$gbCarrier200TGasPerHour = TonsPerHour($gbCarrier200TGasFlowId, 'gb');
//echo($oldWetPlantFeedTPH);
//used to predict the output, 100T has no output scale
if ($gbCarrier200TFeedTPH > 0)
  {
  $outputRatioTPH = $gbCarrier200TOutputTPH / $gbCarrier200TFeedTPH;
  }  else
  {
  $outputRatioTPH = .99;
  }
$gbCarrier100TOutputTPH = round($outputRatioTPH * $gbCarrier100TFeedTPH, 0);

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Shift Totals ">
$gbNewWetPlantFeedShiftTotal = ShiftTotal($gbNewWetPlantConveyorFeedId, 'gb');
$gbNewWetPlantCoarseShiftTotal = ShiftTotal($gbNewWetPlantConveyorCoarseId, 'gb');
$gbNewWetPlantFineShiftTotal = ShiftTotal($gbNewWetPlantConveyorFineId, 'gb');

$gbOldWetPlantFeedShiftTotal = ShiftTotal($gbOldWetPlantConveyorFeedId, 'gb');
$gbOldWetPlantCoarseShiftTotal = ShiftTotal($gbOldWetPlantConveyorCoarseId, 'gb');
$gbOldWetPlantFineShiftTotal = ShiftTotal($gbOldWetPlantConveyorFineId, 'gb');

$gbRotaryFeedShiftTotal = ShiftTotal($gbRotaryConveyorFeedId, 'gb');
$gbRotaryOutputShiftTotal = ShiftTotal($gbRotaryConveyorOutputId, 'gb');
$gbRotaryGasTotal = ShiftTotal($gbRotaryGasFlowId, 'gb');

$gbCarrier100TFeedShiftTotal = ShiftTotal($gbCarrier100TConveyorFeedId, 'gb');
//$gbCarrier100TOutputShiftTotal = ShiftTotal($gbCarrier100TConveyorOutputId);
$gbCarrier100TGasTotal = ShiftTotal($gbCarrier100TGasFlowId, 'gb');

$gbCarrier200TFeedShiftTotal = round(ShiftTotal($gbCarrier200TConveyorFeedId, 'gb'),0);
$gbCarrier200TOutputShiftTotal = round(ShiftTotal($gbCarrier200TConveyorOutputId, 'gb'),0);
$gbCarrier200TGasTotal = ShiftTotal($gbCarrier200TGasFlowId, 'gb');

if ($gbCarrier200TFeedShiftTotal != 0)
  {
  $gbOutputRatioShiftTotal = $gbCarrier200TOutputShiftTotal / $gbCarrier200TFeedShiftTotal;
  }   else
  {
  $gbOutputRatioShiftTotal = .90;
  }
$gbCarrier100TOutputShiftTotal = round($gbOutputRatioShiftTotal * $gbCarrier100TFeedShiftTotal, 0);

// </editor-fold>

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tolar ">
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
    'maxGauge' => 800,
    'warningLimit' => 135,
    'actionLimit' => 65
  );
$tlWetPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 600,
    'warningLimit' => 135,
    'actionLimit' => 65
  );


$tlRotaryPlantConveyorStackerDefSettings = array
    (
    'maxGauge' => 300,
    'warningLimit' => 135,
    'actionLimit' => 65
  );
$tlRotaryPlantConveyorHopperDefSettings = array
    (
    'maxGauge' => 300,
    'warningLimit' => 135,
    'actionLimit' => 65
  );
$tlRotaryPlantConveyorOutputDefSettings = array
    (
    'maxGauge' => 300,
    'warningLimit' => 135,
    'actionLimit' => 65
  );

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Get user Settings ">

$tlWetPlantConveyorFeedSettings = getSettings($userId, $tlWetPlantConveyorFeedId, $tlWetPlantConveyorFeedDefSettings,'tl');
$tlWetPlantConveyorOutputSettings = getSettings($userId, $tlWetPlantConveyorOutputId, $tlWetPlantConveyorOutputDefSettings,'tl');

$tlRotaryPlantConveyorStackerSettings = getSettings($userId, $tlRotaryConveyorStackerId, $tlRotaryPlantConveyorStackerDefSettings,'tl');
$tlRotaryPlantConveyorHopperSettings = getSettings($userId, $tlRotaryConveyorHopperId, $tlRotaryPlantConveyorHopperDefSettings,'tl');
$tlRotaryPlantConveyorOutputSettings = getSettings($userId, $tlRotaryConveyorOutputId, $tlRotaryPlantConveyorOutputDefSettings,'tl');


// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Tons Per Hour ">
$tlWetPlantFeedTPH = TonsPerHour($tlWetPlantTPHFeedId,'tl');
$tlWetPlantOutputTPH = TonsPerHour($tlWetPlantTPHOutputId,'tl');

$tlRotaryStackerTPH = TonsPerHour($tlRotaryTPHStackerId,'tl');
$tlRotaryHopperTPH = TonsPerHour($tlRotaryTPHHopperId,'tl');
$tlRotaryOutputTPH = TonsPerHour($tlRotaryTPHOutputId,'tl');

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Shift Totals ">
$tlWetPlantFeedShiftTotal = ShiftTotal($tlWetPlantConveyorFeedId,'tl');
$tlWetPlantOutputShiftTotal = ShiftTotal($tlWetPlantConveyorOutputId,'tl');

$tlRotaryStackerShiftTotal = ShiftTotal($tlRotaryConveyorStackerId,'tl');
$tlRotaryHopperShiftTotal = ShiftTotal($tlRotaryConveyorHopperId,'tl');
$tlRotaryOutputShiftTotal = ShiftTotal($tlRotaryConveyorOutputId,'tl');

// </editor-fold>

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Functions ">
function getSettings($userId, $tagId, $settings, $site)
  {
  $settingsSql = "CALL sp_" . $site . "_plc_UserThresholdGet(" . $tagId . "," . $userId . ")";
  $settingsResults = mysqli_query(dbmysqli(), $settingsSql);
  if (mysqli_num_rows($settingsResults) === 0)
    {
    return $settings;
  }     else

    {
    while ($settingRes = $settingsResults->fetch_assoc())
      {
      if ($settingRes['gauge_max'] != '' && $settingRes['gauge_max'] != null)
        {
        $settings['maxGauge'] = $settingRes['gauge_max'];
        }

      if ($settingRes['gauge_action_limit'] != '' && $settingRes['gauge_action_limit'] != null)
        {
        $settings['actionLimit'] = $settingRes['gauge_action_limit'];
        }

      if ($settingRes['gauge_warning_limit'] != '' && $settingRes['gauge_warning_limit'] != null)
        {
        $settings['warningLimit'] = $settingRes['gauge_warning_limit'];
        }

      return $settings;
      }
    }
  }

function TonsPerHour($beltId, $site)
  {
  $latestValuesSql = "CALL sp_" . $site . "_plc_10minuteMaxIdByTagGet(" . $beltId . ")";
  //echo($latestValuesSql);
  $latestValuesResults = mysqli_query(dbmysqli(), $latestValuesSql);
  $tonsPerHour = 0;
  while ($latestValuesResult = $latestValuesResults->fetch_assoc())
    {
    if ($beltId === 28)
      {
      $tonsPerHour = round(($latestValuesResult['Current Value'] - $latestValuesResult['Previous Value']) * 6, 0);
      }         else
      {
      $tonsPerHour = round($latestValuesResult['Current Value'], 0);
      }
    
        
      }
  //echo($tonsPerHour . "<br>");
  return $tonsPerHour;
  }

function ShiftTotal($beltId, $site)
  {


  $latestValuesSql = "CALL sp_" . $site . "_plc_10minuteMaxIdByTagGet(" . $beltId . ")";
  //echo($latestValuesSql);
  $latestValuesResults = mysqli_query(dbmysqli(), $latestValuesSql);
  $shiftTotal = 0;
  while ($latestValuesResult = $latestValuesResults->fetch_assoc())
    {
    $shiftTotal = $latestValuesResult['Current Value'];
          }
  //echo($tonsPerHour . "<br>");
  return $shiftTotal;
  }

// </editor-fold>

  
//========================================================================================== END PHP
?>


<script src="../../Includes/gaugeSVG/javascript/gaugeSVG.js"></script>
<script src="../../Includes/gauge.min.js"></script>



<script>
      window.onload = function(){

    var gbnwpfeedmax = <?php  echo $gbNewWetPlantConveyorFeedSettings['maxGauge']; ?>;
    var gbnwpfeedopts = {
      angle: 0, // The span of the  gauge arc
      lineWidth: 0.3, // The  line thickness
      radiusScale: 1, // Relative  radius
      pointer: {
        length: 0.6, // Relative to gauge radius
        strokeWidth: 0.035, // The thickness
        color: '#000000' // Fill color
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [0, gbnwpfeedmax*.75 , gbnwpfeedmax*.5, gbnwpfeedmax*.25, gbnwpfeedmax],  // Print labels at these values
        color: "#000000",  // Label text color
        fractionDigits: 0  // Numerical precision. 0=round off.
      },
      limitMax: false,     // If false, max value increases automatically if value > maxValue
      limitMin: false,     // If true, the min  value of the gauge will be fixed
      colorStart: '#A2BCED',   // Gauge colors
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     // High resolution support
      
    };
    var gbnwpfeedtarget = document.getElementById('gbnwpfeed'); // your canvas element
    var gbnwpfeed = new Gauge(gbnwpfeedtarget).setOptions(gbnwpfeedopts); // create gauge
    gbnwpfeed.maxValue = gbnwpfeedmax; // set  max gauge value
    gbnwpfeed.setMinValue(0);  // Prefer setter over gauge.minValue = 0
    gbnwpfeed.animationSpeed = 42; // set animation speed (32 is default value)
    gbnwpfeed.set(<?php echo $gbNewWetPlantFeedTPH; ?>); // set actual value

    var gbnwp4070max = <?php  echo $gbNewWetPlantConveyorCoarseSettings['maxGauge']; ?>;
    var gbnwp4070opts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gbnwp4070max, gbnwp4070max*.75, gbnwp4070max*.5, gbnwp4070max*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gbnwp4070target = document.getElementById('gbnwp4070'); 
    var gbnwp4070 = new Gauge(gbnwp4070target).setOptions(gbnwp4070opts); 
    gbnwp4070.maxValue = gbnwp4070max; 
    gbnwp4070.setMinValue(0);  
    gbnwp4070.animationSpeed = 42; 
    gbnwp4070.set(<?php echo $gbNewWetPlantCoarseTPH; ?>); 
    
    var gbnwp100meshmax = <?php  echo $gbNewWetPlantConveyorFineSettings['maxGauge']; ?>;
    var gbnwp100meshopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gbnwp100meshmax, gbnwp100meshmax*.75, gbnwp100meshmax*.5, gbnwp100meshmax*.25, 0], 
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gbnwp100meshtarget = document.getElementById('gbnwp100mesh'); 
    var gbnwp100mesh = new Gauge(gbnwp100meshtarget).setOptions(gbnwp100meshopts); 
    gbnwp100mesh.maxValue = gbnwp100meshmax; 
    gbnwp100mesh.setMinValue(0);  
    gbnwp100mesh.animationSpeed = 42; 
    gbnwp100mesh.set(<?php echo $gbNewWetPlantFineTPH; ?>); 
     
    var gbowpfeedmax = <?php  echo $gbOldWetPlantConveyorFeedSettings['maxGauge']; ?>;
    var gbowpfeedopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [0, gbowpfeedmax*.75 , gbowpfeedmax*.5, gbowpfeedmax*.25, gbowpfeedmax],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     
      
    };
    var gbowpfeedtarget = document.getElementById('gbowpfeed'); 
    var gbowpfeed = new Gauge(gbowpfeedtarget).setOptions(gbowpfeedopts); 
    gbowpfeed.maxValue = gbowpfeedmax; 
    gbowpfeed.setMinValue(0);  
    gbowpfeed.animationSpeed = 42; 
    gbowpfeed.set(<?php echo $gbOldWetPlantFeedTPH; ?>); 

    var gbowp4070max = <?php  echo $gbOldWetPlantConveyorCoarseSettings['maxGauge']; ?>;
    var gbowp4070opts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gbowp4070max, gbowp4070max*.75, gbowp4070max*.5, gbowp4070max*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gbowp4070target = document.getElementById('gbowp4070'); 
    var gbowp4070 = new Gauge(gbowp4070target).setOptions(gbowp4070opts); 
    gbowp4070.maxValue = gbowp4070max; 
    gbowp4070.setMinValue(0);  
    gbowp4070.animationSpeed = 42; 
    gbowp4070.set(<?php echo $gbOldWetPlantCoarseTPH; ?>); 
    
    var gbowp100meshmax = <?php  echo $gbOldWetPlantConveyorFineSettings['maxGauge']; ?>;
    var gbowp100meshopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gbowp100meshmax, gbowp100meshmax*.75, gbowp100meshmax*.5, gbowp100meshmax*.25, 0], 
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gbowp100meshtarget = document.getElementById('gbowp100mesh'); 
    var gbowp100mesh = new Gauge(gbowp100meshtarget).setOptions(gbowp100meshopts); 
    gbowp100mesh.maxValue = gbowp100meshmax; 
    gbowp100mesh.setMinValue(0);  
    gbowp100mesh.animationSpeed = 42; 
    gbowp100mesh.set(<?php echo $gbOldWetPlantFineTPH; ?>); 
        
    var gb100tfeedmax = <?php  echo $gbCarrier100TPlantConveyorFeedSettings['maxGauge']; ?>;
    var gb100tfeedopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gb100tfeedmax, gb100tfeedmax*.75, gb100tfeedmax*.5, gb100tfeedmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gb100tfeedtarget = document.getElementById('gb100tfeed'); 
    var gb100tfeed = new Gauge(gb100tfeedtarget).setOptions(gb100tfeedopts); 
    gb100tfeed.maxValue = gb100tfeedmax; 
    gb100tfeed.setMinValue(0);  
    gb100tfeed.animationSpeed = 42; 
    gb100tfeed.set(<?php echo $gbCarrier100TFeedTPH; ?>);    
    
    var gb100toutputmax = <?php  echo $gbCarrier100TPlantConveyorOutputSettings['maxGauge']; ?>;
    var gb100toutputopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gb100toutputmax, gb100toutputmax*.75, gb100toutputmax*.5, gb100toutputmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gb100toutputtarget = document.getElementById('gb100toutput'); 
    var gb100toutput = new Gauge(gb100toutputtarget).setOptions(gb100toutputopts); 
    gb100toutput.maxValue = gb100toutputmax; 
    gb100toutput.setMinValue(0);  
    gb100toutput.animationSpeed = 42; 
    gb100toutput.set(<?php echo $gbCarrier100TOutputTPH; ?>);    
    
    var gb200tfeedmax = <?php  echo $gbCarrier200TPlantConveyorFeedSettings['maxGauge']; ?>;
    var gb200tfeedopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gb200tfeedmax, gb200tfeedmax*.75, gb200tfeedmax*.5, gb200tfeedmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gb200tfeedtarget = document.getElementById('gb200tfeed'); 
    var gb200tfeed = new Gauge(gb200tfeedtarget).setOptions(gb200tfeedopts); 
    gb200tfeed.maxValue = gb200tfeedmax; 
    gb200tfeed.setMinValue(0);  
    gb200tfeed.animationSpeed = 42; 
    gb200tfeed.set(<?php echo $gbCarrier200TFeedTPH; ?>);    
    
    var gb200toutputmax = <?php  echo $gbCarrier200TPlantConveyorOutputSettings['maxGauge']; ?>;
    var gb200toutputopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gb200toutputmax, gb200toutputmax*.75, gb200toutputmax*.5, gb200toutputmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gb200toutputtarget = document.getElementById('gb200toutput'); 
    var gb200toutput = new Gauge(gb200toutputtarget).setOptions(gb200toutputopts); 
    gb200toutput.maxValue = gb200toutputmax; 
    gb200toutput.setMinValue(0);  
    gb200toutput.animationSpeed = 42; 
    gb200toutput.set(<?php echo $gbCarrier200TOutputTPH; ?>);   
    
    
    var gbrotaryfeedmax = <?php  echo $gbRotaryPlantConveyorFeedSettings['maxGauge']; ?>;
    var gbrotaryfeedopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gbrotaryfeedmax, gbrotaryfeedmax*.75, gbrotaryfeedmax*.5, gbrotaryfeedmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gbrotaryfeedtarget = document.getElementById('gbrotaryfeed'); 
    var gbrotaryfeed = new Gauge(gbrotaryfeedtarget).setOptions(gbrotaryfeedopts); 
    gbrotaryfeed.maxValue = gbrotaryfeedmax; 
    gbrotaryfeed.setMinValue(0);  
    gbrotaryfeed.animationSpeed = 42; 
    gbrotaryfeed.set(<?php echo $gbRotaryFeedTPH; ?>);    
    
    var gbrotaryoutputmax = <?php  echo $gbRotaryPlantConveyorOutputSettings['maxGauge']; ?>;
    var gbrotaryoutputopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [gbrotaryoutputmax, gbrotaryoutputmax*.75, gbrotaryoutputmax*.5, gbrotaryoutputmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var gbrotaryoutputtarget = document.getElementById('gbrotaryoutput'); 
    var gbrotaryoutput = new Gauge(gbrotaryoutputtarget).setOptions(gbrotaryoutputopts); 
    gbrotaryoutput.maxValue = gbrotaryoutputmax; 
    gbrotaryoutput.setMinValue(0);  
    gbrotaryoutput.animationSpeed = 42; 
    gbrotaryoutput.set(<?php echo $gbRotaryOutputTPH; ?>);   

    //tolar gauges
    var tlwetplantfeedmax = <?php  echo $tlWetPlantConveyorFeedSettings['maxGauge']; ?>;
    var tlwpfeedopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [tlwetplantfeedmax, tlwetplantfeedmax*.75, tlwetplantfeedmax*.5, tlwetplantfeedmax*.25, 0], 
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     
      
    };
    var tlwpfeedtarget = document.getElementById('tlwpfeed'); 
    var tlwpfeed = new Gauge(tlwpfeedtarget).setOptions(tlwpfeedopts); 
    tlwpfeed.maxValue = tlwetplantfeedmax; 
    tlwpfeed.setMinValue(0);  
    tlwpfeed.animationSpeed = 42; 
    tlwpfeed.set(<?php echo $tlWetPlantFeedTPH; ?>); 

    var tlwetplantoutputmax = <?php  echo $tlWetPlantConveyorOutputSettings['maxGauge']; ?>;
    var tlwpoutputopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [tlwetplantoutputmax, tlwetplantoutputmax*.75, tlwetplantoutputmax*.5, tlwetplantoutputmax*.25, 0], 
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var tlwpoutputtarget = document.getElementById('tlwpoutput'); 
    var tlwpoutput = new Gauge(tlwpoutputtarget).setOptions(tlwpoutputopts); 
    tlwpoutput.maxValue = tlwetplantoutputmax; 
    tlwpoutput.setMinValue(0);  
    tlwpoutput.animationSpeed = 42; 
    tlwpoutput.set(<?php echo $tlWetPlantOutputTPH; ?>); 
    
    
    var tlrotarystackermax = <?php  echo $tlRotaryPlantConveyorStackerSettings['maxGauge']; ?>;
    var tlrotarystackeropts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [tlrotarystackermax, tlrotarystackermax*.75, tlrotarystackermax*.5, tlrotarystackermax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var tlrotarystackertarget = document.getElementById('tlrotarystacker'); 
    var tlrotarystacker = new Gauge(tlrotarystackertarget).setOptions(tlrotarystackeropts); 
    tlrotarystacker.maxValue = tlrotarystackermax; 
    tlrotarystacker.setMinValue(0);  
    tlrotarystacker.animationSpeed = 42; 
    tlrotarystacker.set(<?php echo $tlRotaryStackerTPH; ?>);   
    
    var tlrotaryhoppermax = <?php  echo $tlRotaryPlantConveyorHopperSettings['maxGauge']; ?>;
    var tlrotaryhopperopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [tlrotaryhoppermax, tlrotaryhoppermax*.75, tlrotaryhoppermax*.5, tlrotaryhoppermax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var tlrotaryhoppertarget = document.getElementById('tlrotaryhopper'); 
    var tlrotaryhopper = new Gauge(tlrotaryhoppertarget).setOptions(tlrotaryhopperopts); 
    tlrotaryhopper.maxValue = tlrotaryhoppermax; 
    tlrotaryhopper.setMinValue(0);  
    tlrotaryhopper.animationSpeed = 42; 
    tlrotaryhopper.set(<?php echo $tlRotaryHopperTPH; ?>); 
    
    var tlrotaryoutputmax = <?php  echo $tlRotaryPlantConveyorOutputSettings['maxGauge']; ?>;
    var tlrotaryoutputopts = {
      angle: 0, 
      lineWidth: 0.3, 
      radiusScale: 1, 
      pointer: {
        length: 0.6, 
        strokeWidth: 0.035, 
        color: '#000000' 
      },
      staticLabels: {
        font: "10px sans-serif",  
        labels: [tlrotaryoutputmax, tlrotaryoutputmax*.75, tlrotaryoutputmax*.5, tlrotaryoutputmax*.25, 0],  
        color: "#000000",  
        fractionDigits: 0  
      },
      limitMax: false,     
      limitMin: false,     
      colorStart: '#A2BCED',   
      colorStop: '#A2BCED',    
      strokeColor: '#E0E0E0',  
      generateGradient: true,
      highDpiSupport: true,     

    };
    var tlrotaryoutputtarget = document.getElementById('tlrotaryoutput'); 
    var tlrotaryoutput = new Gauge(tlrotaryoutputtarget).setOptions(tlrotaryoutputopts); 
    tlrotaryoutput.maxValue = tlrotaryoutputmax; 
    tlrotaryoutput.setMinValue(0);  
    tlrotaryoutput.animationSpeed = 42; 
    tlrotaryoutput.set(<?php echo $tlRotaryOutputTPH; ?>); 
               
    document.getElementById('tolar').classList.remove('active');
         
      };
      
    </script>
<!--<meta http-equiv="refresh" content="600" >-->

<div>
  <ul class="nav nav-tabs" id="siteTabs" role="tablist">
    <li class="nav-tab-item">
      <a id="gb-tab" class="nav-link active" data-toggle="tab" role="tab"  href="#granbury" aria-selected="true">Granbury</a>
    </li>
    <li class="nav-tab-item">
      <a id="tl-tab" class="nav-link" data-toggle="tab" role="tab" href="#tolar" aria-selected="false">Tolar</a>
    </li>
    <li class="nav-tab-item">
      <a id="wt-tab" class="nav-link" data-toggle="tab" role="tab"  href="#west_texas" aria-selected="false">West Texas</a>
    </li>
    <li class="nav-tab-item">
      <a id="ok-tab" class="nav-link" data-toggle="tab" role="tab" href="#oklahoma" aria-selected="false">Oklahoma</a>
    </li>
  </ul>
</div>

<div class="tab-content" id="gb-tab-content">
  <div id="granbury" class="tab-pane fade show active">
    <h3>Granbury</h3>
    <div class="card card-table">
      <div class="card-body">
        <div class='table-responsive-sm'>
          <table class="table table-sm table-striped table-bordered table-hover nowrap">
            <thead class="th-vprop-blue-medium">
              <tr>
                <th colspan="100%">Shift Totals</th>
              </tr>
              <tr>
                <th>OWP Feed</th>
                <th>OWP 40/70 Mesh</th>
                <th>OWP 100 Mesh</th>
                <th>NWP Feed</th>
                <th>NWP 40/70 Mesh</th>
                <th>NWP 100 Mesh</th>
                <th>100T Feed</th>
                <th>100T Output</th>
                <th>200T Feed</th>
                <th>200T Output</th>
                <th>Rotary Feed</th>
                <th>Rotary Output</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                echo("   <td>{$gbOldWetPlantFeedShiftTotal}</td>"
                . "<td>{$gbOldWetPlantCoarseShiftTotal}</td>"
                . "<td>{$gbOldWetPlantFineShiftTotal}</td>"
                . "<td>{$gbNewWetPlantFeedShiftTotal}</td>"
                . "<td>{$gbNewWetPlantCoarseShiftTotal}</td>"
                . "<td>{$gbNewWetPlantFineShiftTotal}</td>"
                . "<td>{$gbCarrier100TFeedShiftTotal}</td>"
                . "<td>{$gbCarrier100TOutputShiftTotal}</td>"
                . "<td>{$gbCarrier200TFeedShiftTotal}</td>"
                . "<td>{$gbCarrier200TOutputShiftTotal}</td>"
                . "<td>{$gbRotaryFeedShiftTotal}</td>"
                . "<td>{$gbRotaryOutputShiftTotal}</td>");
                ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <br>
    <div class='row d-flex justify-content-around'>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class='card-title'>New Wet Plant Feed</h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbnwpfeed"></canvas>
          <P class='gauge-number'><?php echo $gbNewWetPlantFeedTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">New Wet 40/70 Mesh</h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbnwp4070"></canvas>
          <P class='gauge-number'><?php echo $gbNewWetPlantCoarseTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">New Wet 100 Mesh</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbnwp100mesh"></canvas>
          <P class='gauge-number'><?php echo $gbNewWetPlantFineTPH; ?></P>
        </div>
      </div>
    </div>
    <div class='row d-flex justify-content-around'>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class='card-title'>Old Wet Plant Feed</h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbowpfeed"></canvas>
          <P class='gauge-number'><?php echo $gbOldWetPlantFeedTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Old Wet 40/70 Mesh</h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbowp4070"></canvas>
          <P class='gauge-number'><?php echo $gbOldWetPlantCoarseTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Old Wet 100 Mesh</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbowp100mesh"></canvas>
          <P class='gauge-number'><?php echo $gbOldWetPlantFineTPH; ?></P>
        </div>
      </div>
    </div>
    <div class='row d-flex justify-content-around'>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">100 Ton Feed</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gb100tfeed"></canvas>
          <P class='gauge-number'><?php echo $gbCarrier100TFeedTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">100 Ton Output</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gb100toutput"></canvas>
          <P class='gauge-number'><?php echo $gbCarrier100TOutputTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Rotary Feed</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbrotaryfeed"></canvas>
          <P class='gauge-number'><?php echo $gbRotaryFeedTPH; ?></P>
        </div>
      </div>
    </div>
    <div class='row d-flex justify-content-around'>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">200 Ton Feed</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gb200tfeed"></canvas>
          <P class='gauge-number'><?php echo $gbCarrier200TFeedTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">200 Ton Output</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gb200toutput"></canvas>
          <P class='gauge-number'><?php echo $gbCarrier200TOutputTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Rotary Output</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="gbrotaryoutput"></canvas>
          <P class='gauge-number'><?php echo $gbRotaryOutputTPH; ?></P>
        </div>
      </div>
    </div>
  </div>

  <div id="tolar" class="tab-pane fade in active">
    <h3>Tolar</h3>


    <div class="card card-table">
      <div class="card-body">
        <div class='table-responsive-sm'>
          <table class="table table-sm table-striped table-bordered table-hover nowrap">
            <thead class="th-vprop-blue-medium">


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
      </div>
    </div>
    <br>
    <div class='row justify-content-around'>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Rotary Stacker Feed</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="tlrotarystacker"></canvas>
          <P class='gauge-number'><?php echo $tlRotaryStackerTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Rotary Hopper Feed</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="tlrotaryhopper"></canvas>
          <P class='gauge-number'><?php echo $tlRotaryHopperTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Rotary Output</div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="tlrotaryoutput"></canvas>
          <P class='gauge-number'><?php echo $tlRotaryOutputTPH; ?></P>
        </div>
      </div>
    </div>

    <div class='row justify-content-around'>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class='card-title'>Wet Plant Feed</h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="tlwpfeed"></canvas>
          <P class='gauge-number'><?php echo $tlWetPlantFeedTPH; ?></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5 placeholder' >
        <div class="card-header"><h4 class="card-title"></h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id=""></canvas>
          <P class='gauge-number'></P>
        </div>
      </div>
      <div class='card ml-5 mr-5 mb-5' >
        <div class="card-header"><h4 class="card-title">Wet Plant Output</h4></div>
        <div class="card-body" >
          <canvas  class='card-gauge' id="tlwpoutput"></canvas>
          <P class='gauge-number'><?php echo $tlWetPlantOutputTPH; ?></P>
        </div>
      </div>
    </div>
  </div>


  <div id="west_texas" class="tab-pane fade">
    <h3>West Texas</h3>
    <p>West Texas Gauges</p>
    <p>Coming Soon</p>
  </div>
  <div id="oklahoma" class="tab-pane fade">
    <h3>Oklahoma</h3>
    <p>Oklahoma Gauges</p>
    <p>Coming Early 2019</p>
  </div>
</div>

 
<style>      
.svg-container
{
 width:260px; height:200px;
  display: inline-block;
  margin: 1em;
  margin-left: 10%;
  padding:0;
}

.card-gauge
{
    width: 100%;
    height: auto;
}

.gauge-number
{
  text-align: center;
  font-size: 1.5vw; 

}
.card-title
{
  font-size: 1.5vw; 
}
.card-columns
{
  column-count: 1;
}
.card 
{
  width:20%;
}
.card-table
{
  width:100% !important;
}
.placeholder
{
  visibility: hidden;
}
</style>


