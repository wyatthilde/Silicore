<?php
/* * *****************************************************************************************************************************************
 * File Name: plantdashboard_tl.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/22/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
error_reporting(E_ERROR | E_PARSE);

//check to see if the start and end date have been set, if not the default is a 1 month range
if (isset($_POST['start-date']) && !empty($_POST['start-date']))
  {
    $startDate = filter_input(INPUT_POST, 'start-date');
  }
else
  {
    $startDate = date("Y-m-d", strtotime("-1 months"));
  }
  
if (isset($_POST['end-date']) && !empty($_POST['end-date']))
  {
    $endDate = filter_input(INPUT_POST, 'end-date');
  }
else
  {
    $endDate = date("Y-m-d" , strtotime('-1 day'));
  }
  
//checks if operator has been set, if not sets the variable to a % so the query returns all operators
if (isset($_POST['operator-select']) && !empty($_POST['operator-select']))
  {
    $operator = filter_input(INPUT_POST, 'operator-select');
  }
else
  {
    $operator = "%";
  }
 
//returns all unique conveyor tags into sql object
try
  {
    $conveyorTagsSQL = "CALL sp_tl_plc_ConveyorTagsGet()";
    $conveyorTagsResults = mysqli_query(dbmysqli(),$conveyorTagsSQL);
  }
catch(Exception $e)
  {
    echo("Error: " .  __LINE__ . " " .$e);
  }
  
//returns all unique operators into sql object
try
 {
   $operatorsSQL = "CALL sp_tl_plc_OperatorsGet()";
   $operatorResults = mysqli_query(dbmysqli(),$operatorsSQL);
 }
catch(Exception $e)
 {
   echo("Error: " .  __LINE__ . " " .$e);
 }
 
/*
 editor-fold defaultstate="collapsed" desc=" Plant IDs ">
/*
 * PLANT ID VARIABLES
 */


//Wet Plants 

$wetPlantSampleFeedId = 2;
$wetPlantSampleOutputId = 8;

$wetPlantConveyorFeedId = 9;
$wetPlantConveyorOutputId = 12;

$wetPlantShiftId = 1;
//Dry Plants
$rotarySampleStackerId = 13;
$rotarySampleHopperId = 14;
$rotarySampleOutputId = 17;

$rotaryConveyorStackerId = 1;
$rotaryConveyorHopperId = 12;
$rotaryConveyorOutputId = 2;
$rotaryShiftId = 2;
//$rotaryGasFlowId = 36;

/*
 * END PLANT ID VARIABLES
 */

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Wet Plant 1 ">
 /*
  START WET PLANT 1
 */
 try
  {


  /*
   * finds average for the period of time given
    */

  //qc avg for period
  $wetPlantSampleFeedSQL = "CALL sp_tl_plc_SamplesByLocationGet"
          . "('" . $startDate . "','" . $endDate . "'," . $wetPlantSampleFeedId . ")";

  $wetPlantSampleOutputSQL = "CALL sp_tl_plc_SamplesByLocationGet"
          . "('" . $startDate . "','" . $endDate . "'," . $wetPlantSampleOutputId . ")";


  //tonnage avg for period
  $wetPlantConveyorFeedSQL = "CALL sp_tl_plc_10MinuteRecordsGet"
          . "(" . $wetPlantConveyorFeedId . ",'" . $startDate . "','" . $endDate . "')";

  $wetPlantConveyorOutputSQL = "CALL sp_tl_plc_10MinuteRecordsGet"
          . "(" . $wetPlantConveyorOutputId . ",'" . $startDate . "','" . $endDate . "')";


  //shift times for period
    $wetPlantShiftSQL = "CALL sp_tl_plc_ShiftSummaryByDateGet"
          . "(" . $wetPlantShiftId . ",'" . $startDate . "','" . $endDate . "')";
//echo($wetPlantShiftSQL);
  /*
   * finds the overall average to compare it to the period average
    */


  //qc sample avg
  $wetPlantSampleFeedAvgSQL = "CALL sp_tl_plc_SamplesOverallAvgGet(" . $wetPlantSampleFeedId . ")";
  $wetPlantSampleOutputAvgSQL = "CALL sp_tl_plc_SamplesOverallAvgGet(" . $wetPlantSampleOutputId . ")";


  //tonnage avg
  $wetPlantConveyorFeedAvgSQL = "CALL sp_tl_plc_10MinuteRecordsAverageGet(" . $wetPlantConveyorFeedId . ")";
  $wetPlantConveyorOutputAvgSQL = "CALL sp_tl_plc_10MinuteRecordsAverageGet(" . $wetPlantConveyorOutputId . ")";

  //qc samples
  $wetPlantSampleFeedResults = mysqli_query(dbmysqli(), $wetPlantSampleFeedSQL);
  $wetPlantSampleOutputResults = mysqli_query(dbmysqli(), $wetPlantSampleOutputSQL);


  $wetPlantSampleFeedAvgResults = mysqli_query(dbmysqli(), $wetPlantSampleFeedAvgSQL);
  $wetPlantSampleOutputAvgResults = mysqli_query(dbmysqli(), $wetPlantSampleOutputAvgSQL);

  
  //tonnage
  $wetPlantConveyorFeedResults = mysqli_query(dbmysqli(), $wetPlantConveyorFeedSQL);
  $wetPlantConveyorOutputResults = mysqli_query(dbmysqli(), $wetPlantConveyorOutputSQL);

  $wetPlantConveyorFeedAvgResults = mysqli_query(dbmysqli(), $wetPlantConveyorFeedAvgSQL);
  $wetPlantConveyorOutputAvgResults = mysqli_query(dbmysqli(), $wetPlantConveyorOutputAvgSQL);
  
    
  //shift times
  $wetPlantShiftTimes = mysqli_query(dbmysqli(), $wetPlantShiftSQL);
  
 }  catch (Exception $e)
  {
  echo("Error: " . __LINE__ . " " . $e);
  }

//statistics assigned for wet plant 1 course, fine and feed for the period specified 
while ($wetPlantSampleFeedRes = $wetPlantSampleFeedResults->fetch_assoc())
  {
  $wetPlantSampleFeedMoisture = round($wetPlantSampleFeedRes['AVG(s.moisture_rate)'],4);
  $wetPlantSampleFeedPlus70 = round($wetPlantSampleFeedRes['AVG(s.plus_70)'],4);
  $wetPlantSampleFeedMinus40Plus70 = round($wetPlantSampleFeedRes['AVG(s.minus_40_plus_70)'],4);
  $wetPlantSampleFeedMinus70 = round($wetPlantSampleFeedRes['AVG(s.minus_70)'],4);
  $wetPlantSampleFeedMinus70Plus140 = round($wetPlantSampleFeedRes['AVG(s.minus_70_plus_140)'],4);
  $wetPlantSampleFeedPlus140 = round($wetPlantSampleFeedRes['AVG(s.plus_140)'],4);
  $wetPlantSampleFeedMinus140 = round($wetPlantSampleFeedRes['AVG(s.minus_140)'],4);
  }

while ($wetPlantSampleOutputRes = $wetPlantSampleOutputResults->fetch_assoc())
  {
  $wetPlantSampleOutputMoisture = round($wetPlantSampleOutputRes['AVG(s.moisture_rate)'],4);
  $wetPlantSampleOutputPlus70 = round($wetPlantSampleOutputRes['AVG(s.plus_70)'],4);
  $wetPlantSampleOutputMinus40Plus70 = round($wetPlantSampleOutputRes['AVG(s.minus_40_plus_70)'],4);
  $wetPlantSampleOutputMinus70 = round($wetPlantSampleOutputRes['AVG(s.minus_70)'],4);
  $wetPlantSampleOutputMinus70Plus140 = round($wetPlantSampleOutputRes['AVG(s.minus_70_plus_140)'],4);
  $wetPlantSampleOutputPlus140 = round($wetPlantSampleOutputRes['AVG(s.plus_140)'],4);
  $wetPlantSampleOutputMinus140 = round($wetPlantSampleOutputRes['AVG(s.minus_140)'],4);
  }




//finds the overall average for wet plant 1 course, fine and feed, no date ranged is used so
while ($wetPlantSampleFeedAvgRes = $wetPlantSampleFeedAvgResults->fetch_assoc())
  {
  $wetPlantSampleFeedAvgMoisture = round($wetPlantSampleFeedAvgRes['AVG(moisture_rate)'],4);
  $wetPlantSampleFeedAvgPlus70 = round($wetPlantSampleFeedAvgRes['AVG(plus_70)'],4);
  $wetPlantSampleFeedAvgMinus40Plus70 = round($wetPlantSampleFeedAvgRes['AVG(minus_40_plus_70)'],4);
  $wetPlantSampleFeedAvgMinus70 = round($wetPlantSampleFeedAvgRes['AVG(minus_70)'],4);
  $wetPlantSampleFeedAvgMinus70Plus140 = round($wetPlantSampleFeedAvgRes['AVG(minus_70_plus_140)'],4);
  $wetPlantSampleFeedAvgPlus140 = round($wetPlantSampleFeedAvgRes['AVG(plus_140)'],4);
  $wetPlantSampleFeedAvgMinus140 = round($wetPlantSampleFeedAvgRes['AVG(minus_140)'],4);
  }

while ($wetPlantSampleOutputAvgRes = $wetPlantSampleOutputAvgResults->fetch_assoc())
  {
  $wetPlantSampleOutputAvgMoisture = round($wetPlantSampleOutputAvgRes['AVG(moisture_rate)'],4);
  $wetPlantSampleOutputAvgPlus70 = round($wetPlantSampleOutputAvgRes['AVG(plus_70)'],4);
  $wetPlantSampleOutputAvgMinus40Plus70 = round($wetPlantSampleOutputAvgRes['AVG(minus_40_plus_70)'],4);
  $wetPlantSampleOutputAvgMinus70 = round($wetPlantSampleOutputAvgRes['AVG(minus_70)'],4);
  $wetPlantSampleOutputAvgMinus70Plus140 = round($wetPlantSampleOutputAvgRes['AVG(minus_70_plus_140)'],4);
  $wetPlantSampleOutputAvgPlus140 = round($wetPlantSampleOutputAvgRes['AVG(plus_140)'],4);
  $wetPlantSampleOutputAvgMinus140 = round($wetPlantSampleOutputAvgRes['AVG(minus_140)'],4);
  }


//finds tonnage for the period
while ($wetPlantConveyorFeedRes = $wetPlantConveyorFeedResults->fetch_assoc())
  {
  $wetPlantConveyorFeed = round($wetPlantConveyorFeedRes['AvgValue'],2);
  }
while ($wetPlantConveyorOutputRes = $wetPlantConveyorOutputResults->fetch_assoc())
  {
  $wetPlantConveyorOutput = round($wetPlantConveyorOutputRes['AvgValue'],2);
  }
  
//finds overall average for the period
while ($wetPlantConveyorFeedAvgRes = $wetPlantConveyorFeedAvgResults->fetch_assoc())
  {
  $wetPlantConveyorFeedAvg = round($wetPlantConveyorFeedAvgRes['AvgValue'],2);
  }
while ($wetPlantConveyorOutputAvgRes = $wetPlantConveyorOutputAvgResults->fetch_assoc())
  {
  $wetPlantConveyorOutputAvg = round($wetPlantConveyorOutputAvgRes['AvgValue'],2);
  }
  
//finds shift times for period
while($wetPlantShiftTime = $wetPlantShiftTimes->fetch_assoc())
  {
    $wetPlantDuration = $wetPlantShiftTime['duration_minutes'];
    $wetPlantUptime = $wetPlantShiftTime['uptime'];
    $wetPlantDowntime = $wetPlantShiftTime['downtime'];
    $wetPlantIdletime = $wetPlantShiftTime['idletime'];
  }

//Calculating overall average and period differences
// <editor-fold defaultstate="collapsed" desc="Calculations for wet plant 1">
  
$wetPlantSampleFeedMoistureDiff = sprintf("%.2f%%",($wetPlantSampleFeedMoisture - $wetPlantSampleFeedAvgMoisture));
$wetPlantSampleFeedPlus70Diff = sprintf("%.2f%%",($wetPlantSampleFeedPlus70 - $wetPlantSampleFeedAvgPlus70));
$wetPlantSampleFeedMinus40Plus70Diff = sprintf("%.2f%%",$wetPlantSampleFeedMinus40Plus70 - $wetPlantSampleFeedAvgMinus40Plus70);
$wetPlantSampleFeedMinus70Diff = sprintf("%.2f%%",$wetPlantSampleFeedMinus70 - $wetPlantSampleFeedAvgMinus70);
$wetPlantSampleFeedMinus70Plus140Diff = sprintf("%.2f%%",$wetPlantSampleFeedMinus70Plus140 - $wetPlantSampleFeedAvgMinus70Plus140);
$wetPlantSampleFeedPlus140Diff = sprintf("%.2f%%",$wetPlantSampleFeedPlus140 - $wetPlantSampleFeedAvgPlus140);
$wetPlantSampleFeedMinus140Diff = sprintf("%.2f%%",$wetPlantSampleFeedMinus140 - $wetPlantSampleFeedAvgMinus140);

$wetPlantSampleOutputMoistureDiff = sprintf("%.2f%%",($wetPlantSampleOutputMoisture - $wetPlantSampleOutputAvgMoisture));
$wetPlantSampleOutputPlus70Diff = sprintf("%.2f%%",$wetPlantSampleOutputPlus70 - $wetPlantSampleOutputAvgPlus70);
$wetPlantSampleOutputMinus40Plus70Diff = sprintf("%.2f%%",$wetPlantSampleOutputMinus40Plus70 - $wetPlantSampleOutputAvgMinus40Plus70);
$wetPlantSampleOutputMinus70Diff = sprintf("%.2f%%",$wetPlantSampleOutputMinus70 - $wetPlantSampleOutputAvgMinus70);
$wetPlantSampleOutputMinus70Plus140Diff = sprintf("%.2f%%",$wetPlantSampleOutputMinus70Plus140 - $wetPlantSampleOutputAvgMinus70Plus140);
$wetPlantSampleOutputPlus1140Diff = sprintf("%.2f%%",$wetPlantSampleOutputPlus140 - $wetPlantSampleOutputAvgPlus140);
$wetPlantSampleOutputMinus140Diff = sprintf("%.2f%%",$wetPlantSampleOutputMinus140 - $wetPlantSampleOutputAvgMinus140);

$wetPlantConveyorFeedDaily = round($wetPlantConveyorFeed * 2, 2);
$wetPlantConveyorFeedDailyAvg = round($wetPlantConveyorFeedAvg * 2 ,2);
$wetPlantConveyorFeedDiff = round(($wetPlantConveyorFeed - $wetPlantConveyorFeedAvg) * 2, 2);
$wetPlantConveyorFeedPercentage = sprintf("%.2f%%", ($wetPlantConveyorFeed / max($wetPlantConveyorFeedAvg,1)) * 100);
$wetPlantConveyorFeedRate = round($wetPlantConveyorFeed / 12, 2);
$wetPlantConveyorFeedRateAvg = round($wetPlantConveyorFeedAvg / 12, 2);
$wetPlantConveyorFeedRateDiff = round($wetPlantConveyorFeedRate - $wetPlantConveyorFeedRateAvg,2);

$wetPlantConveyorOutputDaily = round($wetPlantConveyorOutput * 2, 2);
$wetPlantConveyorOutputDailyAvg = round($wetPlantConveyorOutputAvg * 2 ,2);
$wetPlantConveyorOutputDiff = round(($wetPlantConveyorOutput - $wetPlantConveyorOutputAvg) * 2, 2);
$wetPlantConveyorOutputPercentage = sprintf("%.2f%%", ($wetPlantConveyorOutput / max($wetPlantConveyorOutputAvg,1)) * 100);
$wetPlantConveyorOutputRate = round($wetPlantConveyorOutput / 12, 2);
$wetPlantConveyorOutputRateAvg = round($wetPlantConveyorOutputAvg / 12, 2);
$wetPlantConveyorOutputRateDiff = round($wetPlantConveyorOutputRate - $wetPlantConveyorOutputRateAvg,2);

$wetPlantUptimePercent = sprintf("%.2f%%", (min($wetPlantUptime / $wetPlantDuration, .9999)) * 100);
$wetPlantDowntimePercent = sprintf("%.2f%%", (min($wetPlantDowntime / $wetPlantDuration, .9999)) * 100);
$wetPlantIdletimePercent = sprintf("%.2f%%", (min($wetPlantIdletime / $wetPlantDuration, .9999)) * 100);
// </editor-fold>

/*
  END WET PLANT 1
 */

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Rotary ">
try
  {


  /*
   * finds average for the period of time given
   */
  //qc avg for period
  $rotarySampleStackerSQL = "CALL sp_tl_plc_SamplesByLocationGet"
          . "('" . $startDate . "','" . $endDate . "'," . $rotarySampleStackerId . ")";
  $rotarySampleHopperSQL = "CALL sp_tl_plc_SamplesByLocationGet"
          . "('" . $startDate . "','" . $endDate . "'," . $rotarySampleHopperId . ")";
  $rotarySampleOutputSQL = "CALL sp_tl_plc_SamplesByLocationGet"
          . "('" . $startDate . "','" . $endDate . "'," . $rotarySampleOutputId . ")";


  //tonnage avg for period
  $rotaryConveyorStackerSQL = "CALL sp_tl_plc_10MinuteRecordsGet"
          . "(" . $rotaryConveyorStackerId . ",'" . $startDate . "','" . $endDate . "')";
  $rotaryConveyorHopperSQL = "CALL sp_tl_plc_10MinuteRecordsGet"
          . "(" . $rotaryConveyorHopperId . ",'" . $startDate . "','" . $endDate . "')";
  $rotaryConveyorOutputSQL = "CALL sp_tl_plc_10MinuteRecordsGet"
          . "(" . $rotaryConveyorOutputId . ",'" . $startDate . "','" . $endDate . "')";
  
  //shift times for period
  $rotaryShiftSQL = "CALL sp_tl_plc_ShiftSummaryByDateGet"
          . "(" . $rotaryShiftId . ",'" . $startDate . "','" . $endDate . "')";
  
  //gas usage for period
//  $rotaryGasFlowSQL = "CALL sp_tl_plc_10MinuteRecordsGet"
//          . "(" . $rotaryGasFlowId . ",'" . $startDate . "','" . $endDate . "')";
//  $rotaryGasFlowSumSQL = "CALL sp_tl_plc_10MinuteSumGet"
//          . "(" . $rotaryGasFlowId . ",'" . $startDate . "','" . $endDate . "')";

  /*
   * finds the overall average to compare it to the period average
   */

  //qc sample avg
  $rotarySampleStackerAvgSQL = "CALL sp_tl_plc_SamplesOverallAvgGet(" . $rotarySampleStackerId . ")";
  $rotarySampleHopperAvgSQL = "CALL sp_tl_plc_SamplesOverallAvgGet(" . $rotarySampleHopperId . ")";
  $rotarySampleOutputAvgSQL = "CALL sp_tl_plc_SamplesOverallAvgGet(" . $rotarySampleOutputId . ")";



  //tonnage avg
  $rotaryConveyorStackerAvgSQL = "CALL sp_tl_plc_10MinuteRecordsAverageGet(" . $rotaryConveyorStackerId . ")";
  $rotaryConveyorHopperAvgSQL = "CALL sp_tl_plc_10MinuteRecordsAverageGet(" . $rotaryConveyorHopperId . ")";
  $rotaryConveyorOutputAvgSQL = "CALL sp_tl_plc_10MinuteRecordsAverageGet(" . $rotaryConveyorOutputId . ")";
//  $rotaryGasFlowAvgSQL = "CALL sp_tl_plc_10MinuteRecordsAverageGet(" . $rotaryGasFlowId . ")";



  //qc samples
  $rotarySampleStackerResults = mysqli_query(dbmysqli(), $rotarySampleStackerSQL);
  $rotarySampleHopperResults = mysqli_query(dbmysqli(), $rotarySampleHopperSQL);
  $rotarySampleOutputResults = mysqli_query(dbmysqli(), $rotarySampleOutputSQL);



  $rotarySampleStackerAvgResults = mysqli_query(dbmysqli(), $rotarySampleStackerAvgSQL);
  $rotarySampleHopperAvgResults = mysqli_query(dbmysqli(), $rotarySampleHopperAvgSQL);
  $rotarySampleOutputAvgResults = mysqli_query(dbmysqli(), $rotarySampleOutputAvgSQL);



  //tonnage
  $rotaryConveyorStackerResults = mysqli_query(dbmysqli(), $rotaryConveyorStackerSQL);
  $rotaryConveyorHopperResults = mysqli_query(dbmysqli(), $rotaryConveyorHopperSQL);
  $rotaryConveyorOutputResults = mysqli_query(dbmysqli(), $rotaryConveyorOutputSQL);

  $rotaryConveyorStackerAvgResults = mysqli_query(dbmysqli(), $rotaryConveyorStackerAvgSQL);
  $rotaryConveyorHopperAvgResults = mysqli_query(dbmysqli(), $rotaryConveyorHopperAvgSQL);
  $rotaryConveyorOutputAvgResults = mysqli_query(dbmysqli(), $rotaryConveyorOutputAvgSQL);
      
  //shift times
  $rotaryShiftTimes = mysqli_query(dbmysqli(), $rotaryShiftSQL);
//  echo $rotaryShiftSQL;
  //gas
//  $rotaryGasFlowResults = mysqli_query(dbmysqli(), $rotaryGasFlowSQL);
//  $rotaryGasFlowAvgResults = mysqli_query(dbmysqli(), $rotaryGasFlowAvgSQL);
//  $rotaryGasFlowSumResults = mysqli_query(dbmysqli(), $rotaryGasFlowSumSQL);
  
  
  
 } catch (Exception $e)
  {
  echo("Error: " . __LINE__ . " " . $e);
  }







//statistics assigned for rotary course, fine and feed for the period specified 
while ($rotarySampleStackerRes = $rotarySampleStackerResults->fetch_assoc())
  {
  $rotarySampleStackerMoisture = round($rotarySampleStackerRes['AVG(s.moisture_rate)'], 4);
  $rotarySampleStackerPlus70 = round($rotarySampleStackerRes['AVG(s.plus_70)'], 4);
  $rotarySampleStackerMinus40Plus70 = round($rotarySampleStackerRes['AVG(s.minus_40_plus_70)'], 4);
  $rotarySampleStackerMinus70 = round($rotarySampleStackerRes['AVG(s.minus_70)'], 4);
  $rotarySampleStackerMinus70Plus140 = round($rotarySampleStackerRes['AVG(s.minus_70_plus_140)'], 4);
  $rotarySampleStackerPlus140 = round($rotarySampleStackerRes['AVG(s.plus_140)'], 4);
  $rotarySampleStackerMinus140 = round($rotarySampleStackerRes['AVG(s.minus_140)'], 4);
  }
while ($rotarySampleHopperRes = $rotarySampleHopperResults->fetch_assoc())
  {
  $rotarySampleHopperMoisture = round($rotarySampleHopperRes['AVG(s.moisture_rate)'], 4);
  $rotarySampleHopperPlus70 = round($rotarySampleHopperRes['AVG(s.plus_70)'], 4);
  $rotarySampleHopperMinus40Plus70 = round($rotarySampleHopperRes['AVG(s.minus_40_plus_70)'], 4);
  $rotarySampleHopperMinus70 = round($rotarySampleHopperRes['AVG(s.minus_70)'], 4);
  $rotarySampleHopperMinus70Plus140 = round($rotarySampleHopperRes['AVG(s.minus_70_plus_140)'], 4);
  $rotarySampleHopperPlus140 = round($rotarySampleHopperRes['AVG(s.plus_140)'], 4);
  $rotarySampleHopperMinus140 = round($rotarySampleHopperRes['AVG(s.minus_140)'], 4);
  }
while ($rotarySampleOutputRes = $rotarySampleOutputResults->fetch_assoc())
  {
  $rotarySampleOutputMoisture = round($rotarySampleOutputRes['AVG(s.moisture_rate)'], 4);
  $rotarySampleOutputPlus70 = round($rotarySampleOutputRes['AVG(s.plus_70)'], 4);
  $rotarySampleOutputMinus40Plus70 = round($rotarySampleOutputRes['AVG(s.minus_40_plus_70)'], 4);
  $rotarySampleOutputMinus70 = round($rotarySampleOutputRes['AVG(s.minus_70)'], 4);
  $rotarySampleOutputMinus70Plus140 = round($rotarySampleOutputRes['AVG(s.minus_70_plus_140)'], 4);
  $rotarySampleOutputPlus140 = round($rotarySampleOutputRes['AVG(s.plus_140)'], 4);
  $rotarySampleOutputMinus140 = round($rotarySampleOutputRes['AVG(s.minus_140)'], 4);//was error here
  }

//finds the overall average for the rotary QC reports
while ($rotarySampleStackerAvgRes = $rotarySampleStackerAvgResults->fetch_assoc())
  {
  $rotarySampleStackerAvgMoisture = round($rotarySampleStackerAvgRes['AVG(moisture_rate)'], 4);
  $rotarySampleStackerAvgPlus70 = round($rotarySampleStackerAvgRes['AVG(plus_70)'], 4);
  $rotarySampleStackerAvgMinus40Plus70 = round($rotarySampleStackerAvgRes['AVG(minus_40_plus_70)'], 4);
  $rotarySampleStackerAvgMinus70 = round($rotarySampleStackerAvgRes['AVG(minus_70)'], 4);
  $rotarySampleStackerAvgMinus70Plus140 = round($rotarySampleStackerAvgRes['AVG(minus_70_plus_140)'], 4);
  $rotarySampleStackerAvgPlus140 = round($rotarySampleStackerAvgRes['AVG(plus_140)'], 4);
  $rotarySampleStackerAvgMinus140 = round($rotarySampleStackerAvgRes['AVG(minus_140)'], 4);
  }  
while ($rotarySampleHopperAvgRes = $rotarySampleHopperAvgResults->fetch_assoc())
  {
  $rotarySampleHopperAvgMoisture = round($rotarySampleHopperAvgRes['AVG(moisture_rate)'], 4);
  $rotarySampleHopperAvgPlus70 = round($rotarySampleHopperAvgRes['AVG(plus_70)'], 4);
  $rotarySampleHopperAvgMinus40Plus70 = round($rotarySampleHopperAvgRes['AVG(minus_40_plus_70)'], 4);
  $rotarySampleHopperAvgMinus70 = round($rotarySampleHopperAvgRes['AVG(minus_70)'], 4);
  $rotarySampleHopperAvgMinus70Plus140 = round($rotarySampleHopperAvgRes['AVG(minus_70_plus_140)'], 4);
  $rotarySampleHopperAvgPlus140 = round($rotarySampleHopperAvgRes['AVG(plus_140)'], 4);
  $rotarySampleHopperAvgMinus140 = round($rotarySampleHopperAvgRes['AVG(minus_140)'], 4);
  }
while ($rotarySampleOutputAvgRes = $rotarySampleOutputAvgResults->fetch_assoc())
  {
  $rotarySampleOutputAvgMoisture = round($rotarySampleOutputAvgRes['AVG(moisture_rate)'], 4);
  $rotarySampleOutputAvgPlus70 = round($rotarySampleOutputAvgRes['AVG(plus_70)'], 4);
  $rotarySampleOutputAvgMinus40Plus70 = round($rotarySampleOutputAvgRes['AVG(minus_40_plus_70)'], 4);
  $rotarySampleOutputAvgMinus70 = round($rotarySampleOutputAvgRes['AVG(minus_70)'], 4);
  $rotarySampleOutputAvgMinus70Plus140 = round($rotarySampleOutputAvgRes['AVG(minus_70_plus_140)'], 4);
  $rotarySampleOutputAvgPlus140 = round($rotarySampleOutputAvgRes['AVG(plus_140)'], 4);
  $rotarySampleOutputAvgMinus140 = round($rotarySampleOutputAvgRes['AVG(minus_140)'], 4);
  }

while($rotaryShiftTime = $rotaryShiftTimes->fetch_assoc())
  {
    $rotaryDuration = $rotaryShiftTime['duration_minutes'];
    $rotaryUptime = $rotaryShiftTime['uptime'];
    $rotaryDowntime = $rotaryShiftTime['downtime'];
    $rotaryIdletime = $rotaryShiftTime['idletime'];
  }




//finds tonnage for the period
while ($rotaryConveyorStackerRes = $rotaryConveyorStackerResults->fetch_assoc())
  {
  $rotaryConveyorStacker = round($rotaryConveyorStackerRes['AvgValue'], 2);
  }
while ($rotaryConveyorHopperRes = $rotaryConveyorHopperResults->fetch_assoc())
  {
  $rotaryConveyorHopper = round($rotaryConveyorHopperRes['AvgValue'], 2);
  }
while ($rotaryConveyorOutputRes = $rotaryConveyorOutputResults->fetch_assoc())
  {
  $rotaryConveyorOutput = round($rotaryConveyorOutputRes['AvgValue'], 2);
  }

  


//finds overall average for the period
while ($rotaryConveyorStackerAvgRes = $rotaryConveyorStackerAvgResults->fetch_assoc())
  {
  $rotaryConveyorStackerAvg = round($rotaryConveyorStackerAvgRes['AvgValue'], 2);
  }
while ($rotaryConveyorHopperAvgRes = $rotaryConveyorHopperAvgResults->fetch_assoc())
  {
  $rotaryConveyorHopperAvg = round($rotaryConveyorHopperAvgRes['AvgValue'], 2);
  }
while ($rotaryConveyorOutputAvgRes = $rotaryConveyorOutputAvgResults->fetch_assoc())
  {
  $rotaryConveyorOutputAvg = round($rotaryConveyorOutputAvgRes['AvgValue'], 2);
  }



//Calculating overall average and period differences
// <editor-fold defaultstate="collapsed" desc="Calculations for rotary">
$rotarySampleStackerMoistureDiff = round($rotarySampleStackerMoisture - $rotarySampleStackerAvgMoisture, 4);
$rotarySampleStackerPlus70Diff = round($rotarySampleStackerPlus70 - $rotarySampleStackerAvgPlus70, 4);
$rotarySampleStackerMinus40Plus70Diff = round($rotarySampleStackerMinus40Plus70 - $rotarySampleStackerAvgMinus40Plus70, 4);
$rotarySampleStackerMinus70Diff = round($rotarySampleStackerMinus70 - $rotarySampleStackerAvgMinus70, 4);
$rotarySampleStackerMinus70Plus140Diff = round($rotarySampleStackerMinus70Plus140 - $rotarySampleStackerAvgMinus70Plus140, 4);
$rotarySampleStackerPlus140Diff = round($rotarySampleStackerPlus140 - $rotarySampleStackerAvgPlus140, 4);
$rotarySampleStackerMinus140Diff = round($rotarySampleStackerMinus140 - $rotarySampleStackerAvgMinus140, 4);

$rotarySampleHopperMoistureDiff = round($rotarySampleHopperMoisture - $rotarySampleHopperAvgMoisture, 4);
$rotarySampleHopperPlus70Diff = round($rotarySampleHopperPlus70 - $rotarySampleHopperAvgPlus70, 4);
$rotarySampleHopperMinus40Plus70Diff = round($rotarySampleHopperMinus40Plus70 - $rotarySampleHopperAvgMinus40Plus70, 4);
$rotarySampleHopperMinus70Diff = round($rotarySampleHopperMinus70 - $rotarySampleHopperAvgMinus70, 4);
$rotarySampleHopperMinus70Plus140Diff = round($rotarySampleHopperMinus70Plus140 - $rotarySampleHopperAvgMinus70Plus140, 4);
$rotarySampleHopperPlus140Diff = round($rotarySampleHopperPlus140 - $rotarySampleHopperAvgPlus140, 4);
$rotarySampleHopperMinus140Diff = round($rotarySampleHopperMinus140 - $rotarySampleHopperAvgMinus140, 4);

$rotarySampleOutputMoistureDiff = round($rotarySampleOutputMoisture - $rotarySampleOutputAvgMoisture, 4);
$rotarySampleOutputPlus70Diff = round($rotarySampleOutputPlus70 - $rotarySampleOutputAvgPlus70, 4);
$rotarySampleOutputMinus40Plus70Diff = round($rotarySampleOutputMinus40Plus70 - $rotarySampleOutputAvgMinus40Plus70, 4);
$rotarySampleOutputMinus70Diff = round($rotarySampleOutputMinus70 - $rotarySampleOutputAvgMinus70, 4);
$rotarySampleOutputMinus70Plus140Diff = round($rotarySampleOutputMinus70Plus140 - $rotarySampleOutputAvgMinus70Plus140, 4);
$rotarySampleOutputPlus140Diff = round($rotarySampleOutputPlus140 - $rotarySampleOutputAvgPlus140, 4);
$rotarySampleOutputMinus140Diff = round($rotarySampleOutputMinus140 - $rotarySampleOutputAvgMinus140, 4);

$rotaryConveyorStackerDaily = round($rotaryConveyorStacker * 2, 2);
$rotaryConveyorStackerDailyAvg = round($rotaryConveyorStackerAvg * 2 ,2);
$rotaryConveyorStackerDiff = round(($rotaryConveyorStacker - $rotaryConveyorStackerAvg) * 2, 2);
$rotaryConveyorStackerPercentage = sprintf("%.2f%%", ($rotaryConveyorStacker / max($rotaryConveyorStackerAvg,1)) * 100);
$rotaryConveyorStackerRate = round($rotaryConveyorStacker / 12, 2);
$rotaryConveyorStackerRateAvg = round($rotaryConveyorStackerAvg / 12, 2);
$rotaryConveyorStackerRateDiff = round($rotaryConveyorStackerRate - $rotaryConveyorStackerRateAvg,2);

$rotaryConveyorHopperDaily = round($rotaryConveyorHopper * 2, 2);
$rotaryConveyorHopperDailyAvg = round($rotaryConveyorHopperAvg * 2 ,2);
$rotaryConveyorHopperDiff = round(($rotaryConveyorHopper - $rotaryConveyorHopperAvg) * 2, 2);
$rotaryConveyorHopperPercentage = sprintf("%.2f%%", ($rotaryConveyorHopper / max($rotaryConveyorHopperAvg,1)) * 100);
$rotaryConveyorHopperRate = round($rotaryConveyorHopper / 12, 2);
$rotaryConveyorHopperRateAvg = round($rotaryConveyorHopperAvg / 12, 2);
$rotaryConveyorHopperRateDiff = round($rotaryConveyorHopperRate - $rotaryConveyorHopperRateAvg,2);

$rotaryConveyorOutputDaily = round($rotaryConveyorOutput * 2, 2);
$rotaryConveyorOutputDailyAvg = round($rotaryConveyorOutputAvg * 2 ,2);
$rotaryConveyorOutputDiff = round(($rotaryConveyorOutput - $rotaryConveyorOutputAvg) * 2, 2);
$rotaryConveyorOutputPercentage = sprintf("%.2f%%", ($rotaryConveyorOutput / max($rotaryConveyorOutputAvg,1)) * 100);
$rotaryConveyorOutputRate = round($rotaryConveyorOutput / 12, 2);
$rotaryConveyorOutputRateAvg = round($rotaryConveyorOutputAvg / 12, 2);
$rotaryConveyorOutputRateDiff = round($rotaryConveyorOutputRate - $rotaryConveyorOutputRateAvg,2);

//$rotaryGasFlowDaily = round($rotaryGasFlow * 2, 2);
//$rotaryGasFlowDailyAvg = round($rotaryGasFlowAvg * 2, 2);
//$rotaryGasFlowTherms =  round($rotaryGasFlowDaily / 10.37, 2);
//$rotaryGasFlowInputThermsPerTon =  round($rotaryGasFlowTherms / max($rotaryConveyorFeedDaily,1), 2);
//$rotaryGasFlowOutputThermsPerTon =  round($rotaryGasFlowTherms / max($rotaryConveyorOutputDaily,1), 2);

$rotaryUptimePercent = sprintf("%.2f%%", (min($rotaryUptime / $rotaryDuration, .9999)) * 100);
$rotaryDowntimePercent = sprintf("%.2f%%", (min($rotaryDowntime / $rotaryDuration, .9999)) * 100);
$rotaryIdletimePercent = sprintf("%.2f%%", (min($rotaryIdletime / $rotaryDuration, .9999)) * 100);

// </editor-fold>

// </editor-fold>


//========================================================================================== END PHP
?>


<!-- HTML -->
<h1>Plant Dashboard</h1>
<div  class="prod-datepicker">
  <form action='plantdashboard.php' method='post' >
    <input type='text' id='start-date' name='start-date' value="<?php echo $startDate; ?>">
    <strong>to</strong>
    <input type="text" name='end-date' id='end-date' value="<?php echo $endDate; ?>"> 

    <input type="submit" value="Submit">
  </form>
</div>
<br>
<br>
<div id='wetPlantTable'class='prodtable'>  
  <table>
    <thead>
      <tr>
        <th colspan="100%">Wet Plant</th>
      </tr>
      <tr>
        <th>&nbsp;</th>
        <th colspan="4">Tons</th>
        <th Colspan="3">Rate (Tons / Hour)</th>
        <th colspan="4">Sample (Actual)</th>
        <th colspan="4">Sample (Average)</th>
        <th colspan="4">Sample (Δ)</th>
      </tr>
      <tr>
        <th>Product</th>
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
        <th>Moisture Rate(Average)</th>
        <th>+70</th>
        <th>-70 +140</th>
        <th>-140</th>
        <th>Moisture Rate</th>
        <th>+70</th>
        <th>-70 +140</th>
        <th>-140</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Feed</td>
        <?php 
          echo (
                    "<td>{$wetPlantConveyorFeedDaily}</td>"
                  . "<td>{$wetPlantConveyorFeedDailyAvg}</td>"
                  . "<td>{$wetPlantConveyorFeedDiff}</td>"
                  . "<td>{$wetPlantConveyorFeedPercentage}</td>"
                  . "<td>{$wetPlantConveyorFeedRate}</td>"
                  . "<td>{$wetPlantConveyorFeedRateAvg}</td>"
                  . "<td>{$wetPlantConveyorFeedRateDiff}</td>"
                  . "<td>{$wetPlantSampleFeedMoisture}</td>"
                  . "<td>{$wetPlantSampleFeedPlus70}</td>"
                  . "<td>{$wetPlantSampleFeedMinus70Plus140}</td>"
                  . "<td>{$wetPlantSampleFeedMinus140}</td>"
                  . "<td>{$wetPlantSampleFeedAvgMoisture}</td>"
                  . "<td>{$wetPlantSampleFeedAvgPlus70}</td>"
                  . "<td>{$wetPlantSampleFeedAvgMinus70Plus140}</td>"
                  . "<td>{$wetPlantSampleFeedAvgMinus140}</td>"
                  . "<td>{$wetPlantSampleFeedMoistureDiff}</td>"
                  . "<td>{$wetPlantSampleFeedPlus70Diff}</td>"
                  . "<td>{$wetPlantSampleFeedMinus70Plus140Diff}</td>"
                  . "<td>{$wetPlantSampleFeedMinus140Diff}</td>"
                );
        ?>
      </tr>
      <tr>
        <td>Output</td>
        <?php 
          echo (
                    "<td>{$wetPlantConveyorOutputDaily}</td>"
                  . "<td>{$wetPlantConveyorOutputDailyAvg}</td>"
                  . "<td>{$wetPlantConveyorOutputDiff}</td>"
                  . "<td>{$wetPlantConveyorOutputPercentage}</td>"
                  . "<td>{$wetPlantConveyorOutputRate}</td>"
                  . "<td>{$wetPlantConveyorOutputRateAvg}</td>"
                  . "<td>{$wetPlantConveyorOutputRateDiff}</td>"
                  . "<td>{$wetPlantSampleOutputMoisture}</td>"
                  . "<td>{$wetPlantSampleOutputPlus70}</td>"
                  . "<td>{$wetPlantSampleOutputMinus70Plus140}</td>"
                  . "<td>{$wetPlantSampleOutputMinus140}</td>"
                  . "<td>{$wetPlantSampleOutputAvgMoisture}</td>"
                  . "<td>{$wetPlantSampleOutputAvgPlus70}</td>"
                  . "<td>{$wetPlantSampleOutputAvgMinus70Plus140}</td>"
                  . "<td>{$wetPlantSampleOutputAvgMinus140}</td>"
                  . "<td>{$wetPlantSampleOutputMoistureDiff}</td>"
                  . "<td>{$wetPlantSampleOutputPlus70Diff}</td>"
                  . "<td>{$wetPlantSampleOutputMinus70Plus140Diff}</td>"
                  . "<td>{$wetPlantSampleOutputMinus140Diff}</td>"
                );
        ?>
      </tr>
    </tbody>

  </table>
</div>
<div id='wetPlantRuntimeTable'class='prodtable'>  
  <table style ='width:25%'>
    <thead>
      <tr>
        <th colspan="100%">Runtimes</th>
      </tr>
      <tr>
        <th>Uptime</th>
        <th>Downtime</th>
        <th>Idletime</th>
      </tr>
    </thead>
    <tbody>
          <?php 
            echo (
                      "<td>{$wetPlantUptimePercent}</td>"
                    . "<td>{$wetPlantDowntimePercent}</td>"
                    . "<td>{$wetPlantIdletimePercent}</td>"
                  );
          ?>
    </tbody>
    <tfoot>
      <tr >
        <td colspan="100%">Runtimes not accurate currently</td>
      </tr>
    </tfoot>
  </table>
</div>
<br>
<br>
<div id='rotaryTable'class='prodtable'>  
  <table>
    <thead>
      <tr>
        <th colspan="100%">Rotary</th>
      </tr>
      <tr>
        <th>&nbsp;</th>
        <th colspan="5">Tons</th>
        <th Colspan="3">Rate (Tons / Hour)</th>
        <th colspan="4">Sample (Actual)</th>
        <th colspan="4">Sample (Average)</th>
        <th colspan="4">Sample (Δ)</th>
      </tr>
      <tr>
        <th></th>
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
        <th>Moisture Rate(Average)</th>
        <th>+70</th>
        <th>-70 +140</th>
        <th>-140</th>
        <th>Moisture Rate</th>
        <th>+70</th>
        <th>-70 +140</th>
        <th>-140</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Stacker Feed</td>
        <?php 
          echo (
                    "<td>{$rotaryConveyorHopperDaily}</td>"
                  . "<td>{$rotaryConveyorHopperDailyAvg}</td>"
                  . "<td>{$rotaryConveyorHopperDiff}</td>"
                  . "<td>{$rotaryConveyorHopperPercentage}</td>"
                  . "<td>{$rotaryConveyorHopperRate}</td>"
                  . "<td>{$rotaryConveyorHopperRateAvg}</td>"
                  . "<td>{$rotaryConveyorHopperRateDiff}</td>"
                  . "<td>{$rotarySampleHopperMoisture}</td>"
                  . "<td>{$rotarySampleHopperPlus70}</td>"
                  . "<td>{$rotarySampleHopperMinus70Plus140}</td>"
                  . "<td>{$rotarySampleHopperMinus140}</td>"
                  . "<td>{$rotarySampleHopperAvgMoisture}</td>"
                  . "<td>{$rotarySampleHopperAvgPlus70}</td>"
                  . "<td>{$rotarySampleHopperAvgMinus70Plus140}</td>"
                  . "<td>{$rotarySampleHopperAvgMinus140}</td>"
                  . "<td>{$rotarySampleHopperMoistureDiff}</td>"
                  . "<td>{$rotarySampleHopperPlus70Diff}</td>"
                  . "<td>{$rotarySampleHopperMinus70Plus140Diff}</td>"
                  . "<td>{$rotarySampleHopperMinus140Diff}</td>"
                );
        ?>
      </tr>
            <tr>
        <td>Hopper Feed</td>
        <?php 
          echo (
                    "<td>{$rotaryConveyorStackerDaily}</td>"
                  . "<td>{$rotaryConveyorStackerDailyAvg}</td>"
                  . "<td>{$rotaryConveyorStackerDiff}</td>"
                  . "<td>{$rotaryConveyorStackerPercentage}</td>"
                  . "<td>{$rotaryConveyorStackerRate}</td>"
                  . "<td>{$rotaryConveyorStackerRateAvg}</td>"
                  . "<td>{$rotaryConveyorStackerRateDiff}</td>"
                  . "<td>{$rotarySampleStackerMoisture}</td>"
                  . "<td>{$rotarySampleStackerPlus70}</td>"
                  . "<td>{$rotarySampleStackerMinus70Plus140}</td>"
                  . "<td>{$rotarySampleStackerMinus140}</td>"
                  . "<td>{$rotarySampleStackerAvgMoisture}</td>"
                  . "<td>{$rotarySampleStackerAvgPlus70}</td>"
                  . "<td>{$rotarySampleStackerAvgMinus70Plus140}</td>"
                  . "<td>{$rotarySampleStackerAvgMinus140}</td>"
                  . "<td>{$rotarySampleStackerMoistureDiff}</td>"
                  . "<td>{$rotarySampleStackerPlus70Diff}</td>"
                  . "<td>{$rotarySampleStackerMinus70Plus140Diff}</td>"
                  . "<td>{$rotarySampleStackerMinus140Diff}</td>"
                );
        ?>
      </tr>
      <tr>
        <td>Output</td>
          <?php 
            echo (
                      "<td>{$rotaryConveyorOutputDaily}</td>"
                    . "<td>{$rotaryConveyorOutputDailyAvg}</td>"
                    . "<td>{$rotaryConveyorOutputDiff}</td>"
                    . "<td>{$rotaryConveyorOutputPercentage}</td>"
                    . "<td>{$rotaryConveyorOutputRate}</td>"
                    . "<td>{$rotaryConveyorOutputRateAvg}</td>"
                    . "<td>{$rotaryConveyorOutputRateDiff}</td>"
                    . "<td>{$rotarySampleOutputMoisture}</td>"
                    . "<td>{$rotarySampleOutputPlus70}</td>"
                    . "<td>{$rotarySampleOutputMinus70Plus140}</td>"
                    . "<td>{$rotarySampleOutputMinus140}</td>"
                    . "<td>{$rotarySampleOutputAvgMoisture}</td>"
                    . "<td>{$rotarySampleOutputAvgPlus70}</td>"
                    . "<td>{$rotarySampleOutputAvgMinus70Plus140}</td>"
                    . "<td>{$rotarySampleOutputAvgMinus140}</td>"
                    . "<td>{$rotarySampleOutputMoistureDiff}</td>"
                    . "<td>{$rotarySampleOutputPlus70Diff}</td>"
                    . "<td>{$rotarySampleOutputMinus70Plus140Diff}</td>"
                    . "<td>{$rotarySampleOutputMinus140Diff}</td>"
                  );
          ?>
      <tr>
    </tbody>
  </table>
</div>
<div id='rotaryRuntimeTable'class='prodtable'>  
  <table style ='width:25%'>
    <thead>
      <tr>
        <th colspan="100%">Runtimes</th>
      </tr>
      <tr>
        <th>Uptime</th>
        <th>Downtime</th>
        <th>Idletime</th>
      </tr>
    </thead>
    <tbody>
      <?php
      echo (
      "<td>{$rotaryUptimePercent}</td>"
      . "<td>{$rotaryDowntimePercent}</td>"
      . "<td>{$rotaryIdletimePercent}</td>"
      );
      ?>
    </tbody>
    <tfoot>
      <tr >
        <td colspan="100%">Runtimes not accurate currently</td>
      </tr>
    </tfoot>
  </table>
</div>
<br>
<br>


<script>
  $("#carrierExport").click
  (
    function (e) 
      {
        window.open('data:application/vnd.ms-excel,' + $('#carrier-table').html());
        e.preventDefault();
      }
  );
  window.onload = function(){
  document.forms['SubmitForm'].submit();}
  </script>
  
<script>
  $(function() 
  {   
   $("#start-date").datepicker({ dateFormat: 'yy-mm-dd' });
   $("#end-date").datepicker({ dateFormat: 'yy-mm-dd' });
  });
</script>


<!-- HTML -->