<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_scorecard.php
 * Project: Silicore
 * Description:
 * Notes:
 * ============================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * ============================================================================================
 * 08/10/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//=========================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');

error_reporting(E_ERROR);

$userId = $_SESSION['user_id'];
$yesterday = date("Y-m-d", strtotime("-1 days"));
//echo $yesterday;
if ($yesterday == date("Y-m-d", strtotime("last day of last month"))) {
    $firstDayOfMonth = date("Y-m-d", strtotime("first day of last month"));
    $numOfDaysMonth = date("t", mktime(0, 0, 0, date("n") - 1));
    //echo $numOfDaysMonth;
} else {
    $firstDayOfMonth = date("Y-m-01");
    $numOfDaysMonth = date('t');
}
$seconds = abs(strtotime($yesterday) - (strtotime($firstDayOfMonth)));
$days = floor($seconds / 86400) + 1;


$netRotarySetting = "";


try {
    $settingsSQL = "CALL sp_gb_plc_ScorecardSettingsGet(" . $userId . ",'" . $firstDayOfMonth . "')";
    $settingsResults = mysqli_query(dbmysqli(), $settingsSQL);

    while ($settingsResult = mysqli_fetch_assoc($settingsResults)) {
        $grossRotarySetting = $settingsResult['rotary_gross_setting'];
        $netRotarySetting = $settingsResult['rotary_net_setting'];
        $outputRotarySetting = $settingsResult['rotary_output_setting'];

        $gross100TSetting = $settingsResult['carrier100_gross_setting'];
        $net100TSetting = $settingsResult['carrier100_net_setting'];
        $output100TSetting = $settingsResult['carrier100_output_setting'];

        $gross200TSetting = $settingsResult['carrier200_gross_setting'];
        $net200TSetting = $settingsResult['carrier200_net_setting'];
        $output200TSetting = $settingsResult['carrier200_output_setting'];
    }
} catch (Exception $e) {
    echo("Error: " . __LINE__ . " " . $e);
}


$gbRotaryBeltFeedId = 18;
$gbRotaryBeltOutputId = 20;
$gbRotaryPlantLocationID = 6;
$gbRotarySampleFeedLocationId = 50;


$gb100TBeltFeedId = 28;
$gb100TBeltOutputId = 0;//no scale for 100T outputId at this time 8/10/2018
$gb100TPlantLocationID = 5;
$gb100TSampleFeedLocationId = 24;

$gb200TBeltFeedId = 22;
$gb200TBeltOutputId = 24;
$gb200TPlantLocationID = 8;
$gb200TSampleFeedLocationId = 102;

//10 Minute Record Sums
$gbRotaryFeedSumArry = PlantMonthSums($gbRotaryBeltFeedId, $firstDayOfMonth, $days);
$gbRotaryOutputSumArry = PlantMonthSums($gbRotaryBeltOutputId, $firstDayOfMonth, $days);

$gb100TFeedSumArry = PlantMonthSums($gb100TBeltFeedId, $firstDayOfMonth, $days);


$gb200TFeedSumArry = PlantMonthSums($gb200TBeltFeedId, $firstDayOfMonth, $days);
$gb200TOutputSumArry = PlantMonthSums($gb200TBeltOutputId, $firstDayOfMonth, $days);

//100t has no reliable output scale, so it's input is weighed against the ratio of the 200t carrier input and output
$gb100TOutputSumArry = Carrier100Estimate($gb100TFeedSumArry, $gb200TFeedSumArry, $gb200TOutputSumArry);
//print_r($gb100TFeedSumArry);

//get moisture
$gbRotaryMoistureArry = PlantMonthMoisture($gbRotarySampleFeedLocationId, $firstDayOfMonth, $days);
$gb100TMoistureArry = PlantMonthMoisture($gb100TSampleFeedLocationId, $firstDayOfMonth, $days);
$gb200TMoistureArry = PlantMonthMoisture($gb200TSampleFeedLocationId, $firstDayOfMonth, $days);

//weighted moisture
$gbRotaryMoistureAvg = WeightedAvgMoisture($gbRotaryMoistureArry, $gbRotaryFeedSumArry);
$gb100TMoistureAvg = WeightedAvgMoisture($gb100TMoistureArry, $gb100TFeedSumArry);
$gb200TMoistureAvg = WeightedAvgMoisture($gb200TMoistureArry, $gb200TFeedSumArry);

//net tons
$netWeightRotaryArry = NetTons($gbRotaryMoistureArry, $gbRotaryFeedSumArry);
$netWeight100TArry = NetTons($gb100TMoistureArry, $gb100TFeedSumArry);
$netWeight200TArry = NetTons($gb200TMoistureArry, $gb200TFeedSumArry);

//gross MTD tons 
$mtdRotaryGross = array_sum($gbRotaryFeedSumArry);
$mtd100TGross = array_sum($gb100TFeedSumArry);
$mtd200TGross = array_sum($gb200TFeedSumArry);
$mtdConsGross = $mtdRotaryGross + $mtd100TGross + $mtd200TGross;
//net MTD tons
$mtdRotaryNet = round(array_sum($netWeightRotaryArry));
$mtd100TNet = round(array_sum($netWeight100TArry));
$mtd200TNet = round(array_sum($netWeight200TArry));
$mtdConsNet = $mtdRotaryNet + $mtd100TNet + $mtd200TNet;
//output MTD Tons
$mtdRotaryOutput = array_sum($gbRotaryOutputSumArry);
$mtd100TOutput = array_sum($gb100TOutputSumArry);
$mtd200TOutput = array_sum($gb200TOutputSumArry);
$mtdConsOutput = $mtdRotaryOutput + $mtd100TOutput + $mtd200TOutput;

//last day 
$lastRotaryGross = end($gbRotaryFeedSumArry);
$last100TGross = end($gb100TFeedSumArry);
$last200TGross = end($gb200TFeedSumArry);

$lastRotaryNet = round(end($netWeightRotaryArry), 0);
$last100TNet = round(end($netWeight100TArry), 0);
$last200TNet = round(end($netWeight200TArry), 0);

$lastRotaryOutput = end($gbRotaryOutputSumArry);
$last100TOutput = end($gb100TOutputSumArry);
$last200TOutput = end($gb200TOutputSumArry);

$trendingRotaryGross = round(($mtdRotaryGross / $days) * $numOfDaysMonth, 0);
$trending100TGross = round(($mtd100TGross / $days) * $numOfDaysMonth, 0);
$trending200TGross = round(($mtd200TGross / $days) * $numOfDaysMonth, 0);

$trendingRotaryNet = round(($mtdRotaryNet / $days) * $numOfDaysMonth, 0);
$trending100TNet = round(($mtd100TNet / $days) * $numOfDaysMonth, 0);
$trending200TNet = round(($mtd200TNet / $days) * $numOfDaysMonth, 0);

$trendingRotaryOutput = round(($mtdRotaryOutput / $days) * $numOfDaysMonth, 0);
$trending100TOutput = round(($mtd100TOutput / $days) * $numOfDaysMonth, 0);
$trending200TOutput = round(($mtd200TOutput / $days) * $numOfDaysMonth, 0);
//
//if($lastRotaryNet != 0)
//  {
//    $lastRotaryRecovery = sprintf("%.2f%%", ($lastRotaryOutput/$lastRotaryNet) * 100);
//  }
//else
//  {
//    $lastRotaryRecovery = sprintf("%.2f%%", ($lastRotaryOutput*($mtdRotaryNet/$mtdRotaryGross)) * 100);
//  }

$lastRotaryRecovery = PercentRecovery($lastRotaryGross, $lastRotaryOutput, $mtdRotaryGross, $mtdRotaryOutput);
$last100TRecovery = PercentRecovery($last100TGross, $last100TOutput, $mtd100TGross, $mtd100TOutput);
$last200TRecovery = PercentRecovery($last200TGross, $last200TOutput, $mtd200TGross, $mtd200TOutput);

$mtdRotaryRecovery = sprintf("%.2f%%", ($mtdRotaryOutput / $mtdRotaryGross) * 100);
$mtd100TRecovery = sprintf("%.2f%%", ($mtd100TOutput / $mtd100TGross) * 100);
$mtd200TRecovery = sprintf("%.2f%%", ($mtd200TOutput / $mtd200TGross) * 100);

$lastRotaryMoisture = sprintf("%.2f%%", (end($gbRotaryMoistureArry)) * 100);
$last100TMoisture = sprintf("%.2f%%", (end($gb100TMoistureArry)) * 100);
$last200TMoisture = sprintf("%.2f%%", (end($gb200TMoistureArry)) * 100);

$mtdRotaryMoisture = sprintf("%.2f%%", ($gbRotaryMoistureAvg) * 100);
$mtd100TMoisture = sprintf("%.2f%%", ($gb100TMoistureAvg) * 100);
$mtd200TMoisture = sprintf("%.2f%%", ($gb200TMoistureAvg) * 100);


$lastConsolidatedGross = $lastRotaryGross + $last100TGross + $last200TGross;
$lastConsolidatedNet = $lastRotaryNet + $last100TNet + $last200TNet;
$lastConsolidatedOutput = $lastRotaryOutput + $last100TOutput + $last200TOutput;

$mtdConsolidatedGross = $mtdRotaryGross + $mtd100TGross + $mtd200TGross;
$mtdConsolidatedNet = $mtdRotaryNet + $mtd100TNet + $mtd200TNet;
$mtdConsolidatedOutput = $mtdRotaryOutput + $mtd100TOutput + $mtd200TOutput;


$lastConsolidatedRecovery = PercentRecovery($lastConsolidatedGross, $lastConsolidatedOutput, $mtdConsolidatedGross, $mtdConsolidatedOutput);
$mtdConsolidatedRecovery = sprintf("%.2f%%", (($mtdConsolidatedOutput) / ($mtdConsolidatedGross)) * 100);

//downtime
$dtRotaryArry = PlantDownTimes($gbRotaryPlantLocationID, $firstDayOfMonth, $days);
$dt100TArry = PlantDownTimes($gb100TPlantLocationID, $firstDayOfMonth, $days);
$dt200TArry = PlantDownTimes($gb200TPlantLocationID, $firstDayOfMonth, $days);

//scheduled downtime
$schdtRotaryArry = PlantSchDownTimes($gbRotaryPlantLocationID, $firstDayOfMonth, $days);
$schdt100TArry = PlantSchDownTimes($gb100TPlantLocationID, $firstDayOfMonth, $days);
$schdt200TArry = PlantSchDownTimes($gb200TPlantLocationID, $firstDayOfMonth, $days);

//idletime
$itRotaryArry = PlantIdleTimes($gbRotaryPlantLocationID, $firstDayOfMonth, $days);
$it100TArry = PlantIdleTimes($gb100TPlantLocationID, $firstDayOfMonth, $days);
$it200TArry = PlantIdleTimes($gb200TPlantLocationID, $firstDayOfMonth, $days);

//uptime
$uptimeRotaryArry = PlantUpTimes($gbRotaryPlantLocationID, $firstDayOfMonth, $dtRotaryArry, $schdtRotaryArry, $itRotaryArry, $days);
$uptime100TArry = PlantUpTimes($gb100TPlantLocationID, $firstDayOfMonth, $dt100TArry, $schdt100TArry, $it100TArry, $days);
$uptime200TArry = PlantUpTimes($gb200TPlantLocationID, $firstDayOfMonth, $dt200TArry, $schdt200TArry, $it200TArry, $days);

//times for last day of month/yesterday
$lastRotaryUptime = end($uptimeRotaryArry);
$lastRotaryDowntime = end($dtRotaryArry);
$lastRotarySchDowntime = end($schdtRotaryArry);
$lastRotaryIdletime = end($itRotaryArry);

$last100TUptime = end($uptime100TArry);
$last100TDowntime = end($dt100TArry);
$last100TSchDowntime = end($schdt100TArry);
$last100TIdletime = end($it100TArry);

$last200TUptime = end($uptime200TArry);
$last200TDowntime = end($dt200TArry);
$last200TSchDowntime = end($schdt200TArry);
$last200TIdletime = end($it200TArry);

$lastConsUptime = $lastRotaryUptime + $last100TUptime + $last200TUptime;
$lastConsDowntime = $lastRotaryDowntime + $last100TDowntime + $last200TDowntime;
$lastConsSchDowntime = $lastRotarySchDowntime + $last100TSchDowntime + $last200TSchDowntime;
$lastConsIdletime = $lastRotaryIdletime + $last100TIdletime + $last200TIdletime;

//MTD times
$mtdRotaryUptime = array_sum($uptimeRotaryArry);
$mtdRotaryDowntime = array_sum($dtRotaryArry);
$mtdRotarySchDowntime = array_sum($schdtRotaryArry);
$mtdRotaryIdletime = array_sum($itRotaryArry);

$mtd100TUptime = array_sum($uptime100TArry);
$mtd100TDowntime = array_sum($dt100TArry);
$mtd100TSchDowntime = array_sum($schdt100TArry);
$mtd100TIdletime = array_sum($it100TArry);

$mtd200TUptime = array_sum($uptime200TArry);
$mtd200TDowntime = array_sum($dt200TArry);
$mtd200TSchDowntime = array_sum($schdt200TArry);
$mtd200TIdletime = array_sum($it200TArry);

$mtdConsUptime = $mtdRotaryUptime + $mtd100TUptime + $mtd200TUptime;
$mtdConsDowntime = $mtdRotaryDowntime + $mtd100TDowntime + $mtd200TDowntime;
$mtdConsSchDowntime = $mtdRotarySchDowntime + $mtd100TSchDowntime + $mtd200TSchDowntime;
$mtdConsIdletime = $mtdRotaryIdletime + $mtd100TIdletime + $mtd200TIdletime;


if ($lastRotaryUptime + $lastRotaryDowntime + $lastRotaryIdletime + $lastRotarySchDowntime != 0) {
    $uptimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryUptime / ($lastRotaryUptime + $lastRotaryDowntime + $lastRotaryIdletime + $lastRotarySchDowntime)) * 100);

    $downtimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryDowntime / ($lastRotaryUptime + $lastRotaryDowntime + $lastRotaryIdletime + $lastRotarySchDowntime)) * 100);
    $schdowntimeRotaryPercent = sprintf("%.2f%%", ($lastRotarySchDowntime / ($lastRotaryUptime + $lastRotaryDowntime + $lastRotaryIdletime + $lastRotarySchDowntime)) * 100);
    $idletimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryIdletime / ($lastRotaryUptime + $lastRotaryDowntime + $lastRotaryIdletime + $lastRotarySchDowntime)) * 100);

    $delaytimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryIdletime + $lastRotaryDowntime + $lastRotarySchDowntime) / ($lastRotaryUptime + $lastRotaryDowntime + $lastRotaryIdletime + $lastRotarySchDowntime) * 100);
} else {
    $uptimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryUptime / (($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotaryIdletime + $mtdRotarySchDowntime) / $days)) * 100);
    $downtimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryDowntime / (($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotaryIdletime + $mtdRotarySchDowntime) / $days)) * 100);
    $schdowntimeRotaryPercent = sprintf("%.2f%%", ($lastRotarySchDowntime / (($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotaryIdletime + $mtdRotarySchDowntime) / $days)) * 100);
    $idletimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryIdletime / (($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotaryIdletime + $mtdRotarySchDowntime) / $days)) * 100);

    $delaytimeRotaryPercent = sprintf("%.2f%%", ($lastRotaryIdletime + $lastRotaryDowntime + $lastRotarySchDowntime) / (($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotaryIdletime + $mtdRotarySchDowntime) / $days) * 100);
}

if ($last100TUptime + $last100TDowntime + $last100TIdletime + $last100TSchDowntime != 0) {
    $uptime100TPercent = sprintf("%.2f%%", ($last100TUptime / ($last100TUptime + $last100TDowntime + $last100TIdletime + $last100TSchDowntime)) * 100);

    $downtime100TPercent = sprintf("%.2f%%", ($last100TDowntime / ($last100TUptime + $last100TDowntime + $last100TIdletime + $last100TSchDowntime)) * 100);
    $schdowntime100TPercent = sprintf("%.2f%%", ($last100TSchDowntime / ($last100TUptime + $last100TDowntime + $last100TIdletime + $last100TSchDowntime)) * 100);
    $idletime100TPercent = sprintf("%.2f%%", ($last100TIdletime / ($last100TUptime + $last100TDowntime + $last100TIdletime + $last100TSchDowntime)) * 100);

    $delaytime100TPercent = sprintf("%.2f%%", ($last100TIdletime + $last100TDowntime + $last100TSchDowntime) / ($last100TUptime + $last100TDowntime + $last100TIdletime + $last100TSchDowntime) * 100);
} else {
    $uptime100TPercent = sprintf("%.2f%%", ($last100TUptime / (($mtd100TUptime + $mtd100TDowntime + $mtd100TIdletime + $mtd100TSchDowntime) / $days)) * 100);
    $downtime100TPercent = sprintf("%.2f%%", ($last100TDowntime / (($mtd100TUptime + $mtd100TDowntime + $mtd100TIdletime + $mtd100TSchDowntime) / $days)) * 100);
    $schdowntime100TPercent = sprintf("%.2f%%", ($last100TSchDowntime / (($mtd100TUptime + $mtd100TDowntime + $mtd100TIdletime + $mtd100TSchDowntime) / $days)) * 100);
    $idletime100TPercent = sprintf("%.2f%%", ($last100TIdletime / (($mtd100TUptime + $mtd100TDowntime + $mtd100TIdletime + $mtd100TSchDowntime) / $days)) * 100);

    $delaytime100TPercent = sprintf("%.2f%%", ($last100TIdletime + $last100TDowntime + $last100TSchDowntime) / (($mtd100TUptime + $mtd100TDowntime + $mtd100TIdletime + $mtd100TSchDowntime) / $days) * 100);
}

if ($last200TUptime + $last200TDowntime + $last200TIdletime + $last200TSchDowntime != 0) {
    $uptime200TPercent = sprintf("%.2f%%", ($last200TUptime / ($last200TUptime + $last200TDowntime + $last200TIdletime + $last200TSchDowntime)) * 100);

    $downtime200TPercent = sprintf("%.2f%%", ($last200TDowntime / ($last200TUptime + $last200TDowntime + $last200TIdletime + $last200TSchDowntime)) * 100);
    $schdowntime200TPercent = sprintf("%.2f%%", ($last200TSchDowntime / ($last200TUptime + $last200TDowntime + $last200TIdletime + $last200TSchDowntime)) * 100);
    $idletime200TPercent = sprintf("%.2f%%", ($last200TIdletime / ($last200TUptime + $last200TDowntime + $last200TIdletime + $last200TSchDowntime)) * 100);

    $delaytime200TPercent = sprintf("%.2f%%", ($last200TIdletime + $last200TDowntime + $last200TSchDowntime) / ($last200TUptime + $last200TDowntime + $last200TIdletime + $last200TSchDowntime) * 100);
} else {
    $uptime200TPercent = sprintf("%.2f%%", ($last200TUptime / (($mtd200TUptime + $mtd200TDowntime + $mtd200TIdletime + $mtd200TSchDowntime) / $days)) * 100);
    $downtime200TPercent = sprintf("%.2f%%", ($last200TDowntime / (($mtd200TUptime + $mtd200TDowntime + $mtd200TIdletime + $mtd200TSchDowntime) / $days)) * 100);
    $schdowntime200TPercent = sprintf("%.2f%%", ($last200TSchDowntime / (($mtd200TUptime + $mtd200TDowntime + $mtd200TIdletime + $mtd200TSchDowntime) / $days)) * 100);
    $idletime200TPercent = sprintf("%.2f%%", ($last200TIdletime / (($mtd200TUptime + $mtd200TDowntime + $mtd200TIdletime + $mtd200TSchDowntime) / $days)) * 100);

    $delaytime200TPercent = sprintf("%.2f%%", ($last200TIdletime + $last200TDowntime + $last200TSchDowntime) / (($mtd200TUptime + $mtd200TDowntime + $mtd200TIdletime + $mtd200TSchDowntime) / $days) * 100);
}

if ($lastConsUptime + $lastConsDowntime + $lastConsIdletime + $lastConsSchDowntime != 0) {
    $uptimeConsPercent = sprintf("%.2f%%", ($lastConsUptime / ($lastConsUptime + $lastConsDowntime + $lastConsIdletime + $lastConsSchDowntime)) * 100);

    $downtimeConsPercent = sprintf("%.2f%%", ($lastConsDowntime / ($lastConsUptime + $lastConsDowntime + $lastConsIdletime + $lastConsSchDowntime)) * 100);
    $schdowntimeConsPercent = sprintf("%.2f%%", ($lastConsSchDowntime / ($lastConsUptime + $lastConsDowntime + $lastConsIdletime + $lastConsSchDowntime)) * 100);
    $idletimeConsPercent = sprintf("%.2f%%", ($lastConsIdletime / ($lastConsUptime + $lastConsDowntime + $lastConsIdletime + $lastConsSchDowntime)) * 100);

    $delaytimeConsPercent = sprintf("%.2f%%", ($lastConsIdletime + $lastConsDowntime + $lastConsSchDowntime) / ($lastConsUptime + $lastConsDowntime + $lastConsIdletime + $lastConsSchDowntime) * 100);
} else {
    $uptimeConsPercent = sprintf("%.2f%%", ($lastConsUptime / (($mtdConsUptime + $mtdConsDowntime + $mtdConsIdletime + $mtdConsSchDowntime) / $days)) * 100);
    $downtimeConsPercent = sprintf("%.2f%%", ($lastConsDowntime / (($mtdConsUptime + $mtdConsDowntime + $mtdConsIdletime + $mtdConsSchDowntime) / $days)) * 100);
    $schdowntimeConsPercent = sprintf("%.2f%%", ($lastConsSchDowntime / (($mtdConsUptime + $mtdConsDowntime + $mtdConsIdletime + $mtdConsSchDowntime) / $days)) * 100);
    $idletimeConsPercent = sprintf("%.2f%%", ($lastConsIdletime / (($mtdConsUptime + $mtdConsDowntime + $mtdConsIdletime + $mtdConsSchDowntime) / $days)) * 100);

    $delaytimeConsPercent = sprintf("%.2f%%", ($lastConsIdletime + $lastConsDowntime + $lastConsSchDowntime) / (($mtdConsUptime + $mtdConsDowntime + $mtdConsIdletime + $mtdConsSchDowntime) / $days) * 100);
}

$mtdUptimeRotaryPercent = sprintf("%.2f%%", ($mtdRotaryUptime / ($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotarySchDowntime + $mtdRotaryIdletime)) * 100);
$mtdDowntimeRotaryPercent = sprintf("%.2f%%", ($mtdRotaryDowntime / ($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotarySchDowntime + $mtdRotaryIdletime)) * 100);
$mtdSchDowntimeRotaryPercent = sprintf("%.2f%%", ($mtdRotarySchDowntime / ($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotarySchDowntime + $mtdRotaryIdletime)) * 100);
$mtdIdletimeRotaryPercent = sprintf("%.2f%%", ($mtdRotaryIdletime / ($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotarySchDowntime + $mtdRotaryIdletime)) * 100);
$mtdDelaytimeRotaryPercent = sprintf("%.2f%%", (($mtdRotaryDowntime + $mtdRotarySchDowntime + $mtdRotaryIdletime) / ($mtdRotaryUptime + $mtdRotaryDowntime + $mtdRotarySchDowntime + $mtdRotaryIdletime)) * 100);

$mtdUptime100TPercent = sprintf("%.2f%%", ($mtd100TUptime / ($mtd100TUptime + $mtd100TDowntime + $mtd100TSchDowntime + $mtd100TIdletime)) * 100);
$mtdDowntime100TPercent = sprintf("%.2f%%", ($mtd100TDowntime / ($mtd100TUptime + $mtd100TDowntime + $mtd100TSchDowntime + $mtd100TIdletime)) * 100);
$mtdSchDowntime100TPercent = sprintf("%.2f%%", ($mtd100TSchDowntime / ($mtd100TUptime + $mtd100TDowntime + $mtd100TSchDowntime + $mtd100TIdletime)) * 100);
$mtdIdletime100TPercent = sprintf("%.2f%%", ($mtd100TIdletime / ($mtd100TUptime + $mtd100TDowntime + $mtd100TSchDowntime + $mtd100TIdletime)) * 100);
$mtdDelaytime100TPercent = sprintf("%.2f%%", (($mtd100TDowntime + $mtd100TSchDowntime + $mtd100TIdletime) / ($mtd100TUptime + $mtd100TDowntime + $mtd100TSchDowntime + $mtd100TIdletime)) * 100);

$mtdUptime200TPercent = sprintf("%.2f%%", ($mtd200TUptime / ($mtd200TUptime + $mtd200TDowntime + $mtd200TSchDowntime + $mtd200TIdletime)) * 100);
$mtdDowntime200TPercent = sprintf("%.2f%%", ($mtd200TDowntime / ($mtd200TUptime + $mtd200TDowntime + $mtd200TSchDowntime + $mtd200TIdletime)) * 100);
$mtdSchDowntime200TPercent = sprintf("%.2f%%", ($mtd200TSchDowntime / ($mtd200TUptime + $mtd200TDowntime + $mtd200TSchDowntime + $mtd200TIdletime)) * 100);
$mtdIdletime200TPercent = sprintf("%.2f%%", ($mtd200TIdletime / ($mtd200TUptime + $mtd200TDowntime + $mtd200TSchDowntime + $mtd200TIdletime)) * 100);
$mtdDelaytime200TPercent = sprintf("%.2f%%", (($mtd200TDowntime + $mtd200TSchDowntime + $mtd200TIdletime) / ($mtd200TUptime + $mtd200TDowntime + $mtd200TSchDowntime + $mtd200TIdletime)) * 100);

$mtdUptimeConsPercent = sprintf("%.2f%%", ($mtdConsUptime / ($mtdConsUptime + $mtdConsDowntime + $mtdConsSchDowntime + $mtdConsIdletime)) * 100);
$mtdDowntimeConsPercent = sprintf("%.2f%%", ($mtdConsDowntime / ($mtdConsUptime + $mtdConsDowntime + $mtdConsSchDowntime + $mtdConsIdletime)) * 100);
$mtdSchDowntimeConsPercent = sprintf("%.2f%%", ($mtdConsSchDowntime / ($mtdConsUptime + $mtdConsDowntime + $mtdConsSchDowntime + $mtdConsIdletime)) * 100);
$mtdIdletimeConsPercent = sprintf("%.2f%%", ($mtdConsIdletime / ($mtdConsUptime + $mtdConsDowntime + $mtdConsSchDowntime + $mtdConsIdletime)) * 100);
$mtdDelaytimeConsPercent = sprintf("%.2f%%", (($mtdConsDowntime + $mtdConsSchDowntime + $mtdConsIdletime) / ($mtdConsUptime + $mtdConsDowntime + $mtdConsSchDowntime + $mtdConsIdletime)) * 100);

if ($lastRotaryUptime != 0) {
    $grossRotaryTPH = round($lastRotaryGross / $lastRotaryUptime, 1);
    $netRotaryTPH = round($lastRotaryNet / $lastRotaryUptime, 1);
    $outputRotaryTPH = round($lastRotaryOutput / $lastRotaryUptime, 1);
} else {
    $grossRotaryTPH = round($lastRotaryGross / ($mtdRotaryUptime / $days), 1);
    $netRotaryTPH = round($lastRotaryNet / ($mtdRotaryUptime / $days), 1);
    $outputRotaryTPH = round($lastRotaryOutput / ($mtdRotaryUptime / $days), 1);
}

if ($last100TUptime != 0) {
    $gross100TTPH = round($last100TGross / $last100TUptime, 1);
    $net100TTPH = round($last100TNet / $last100TUptime, 1);
    $output100TTPH = round($last100TOutput / $last100TUptime, 1);
} else {
    $gross100TTPH = round($last100TGross / ($mtd100TUptime / $days), 1);
    $net100TTPH = round($last100TNet / ($mtd100TUptime / $days), 1);
    $output100TTPH = round($last100TOutput / ($mtd100TUptime / $days), 1);
}

if ($last200TUptime != 0) {
    $gross200TTPH = round($last200TGross / $last200TUptime, 1);
    $net200TTPH = round($last200TNet / $last200TUptime, 1);
    $output200TTPH = round($last200TOutput / $last200TUptime, 1);
} else {
    $gross200TTPH = round($last200TGross / ($mtd200TUptime / $days), 1);
    $net200TTPH = round($last200TNet / ($mtd200TUptime / $days), 1);
    $output200TTPH = round($last200TOutput / ($mtd200TUptime / $days), 1);
}

$mtdRotaryGrossTPH = round($mtdRotaryGross / $mtdRotaryUptime, 1);
$mtdRotaryNetTPH = round($mtdRotaryNet / $mtdRotaryUptime, 1);
$mtdRotaryOutputTPH = round($mtdRotaryOutput / $mtdRotaryUptime, 1);

$mtd100TGrossTPH = round($mtd100TGross / $mtd100TUptime, 1);
$mtd100TNetTPH = round($mtd100TNet / $mtd100TUptime, 1);
$mtd100TOutputTPH = round($mtd100TOutput / $mtd100TUptime, 1);

$mtd200TGrossTPH = round($mtd200TGross / $mtd200TUptime, 1);
$mtd200TNetTPH = round($mtd200TNet / $mtd200TUptime, 1);
$mtd200TOutputTPH = round($mtd200TOutput / $mtd200TUptime, 1);

$mtdConsGrossTPH = round($mtdConsGross / $mtdConsUptime, 1);
$mtdConsNetTPH = round($mtdConsNet / $mtdConsUptime, 1);
$mtdConsOutputTPH = round($mtdConsOutput / $mtdConsUptime, 1);

$maxIndex = array_search(max($gbRotaryOutputSumArry), $gbRotaryOutputSumArry);

if ($netRotarySetting == "" || $netRotarySetting == null) {
    $grossRotarySetting = round($gbRotaryFeedSumArry[$maxIndex], 0);
    $netRotarySetting = round($netWeightRotaryArry[$maxIndex], 0);
    $outputRotarySetting = round($gbRotaryOutputSumArry[$maxIndex], 0);

    $gross100TSetting = round($gb100TFeedSumArry[$maxIndex], 0);
    $net100TSetting = round($netWeight100TArry[$maxIndex], 0);
    $output100TSetting = round($gb100TOutputSumArry[$maxIndex], 0);

    $gross200TSetting = round($gb200TFeedSumArry[$maxIndex], 0);
    $net200TSetting = round($netWeight200TArry[$maxIndex], 0);
    $output200TSetting = round($gb200TOutputSumArry[$maxIndex], 0);
}

$maxRotaryGrossTph = round($grossRotarySetting / $uptimeRotaryArry[$maxIndex], 2);
$max100TGrossTph = round($gross100TSetting / $uptime100TArry[$maxIndex], 2);
$max200TGrossTph = round($gross200TSetting / $uptime200TArry[$maxIndex], 2);


function PlantMonthSums($FeedId, $startDate, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d ', strtotime($startDate . " +" . $i . " day"));
        $plantSumSql = "CALL sp_gb_plc_10MinuteDailyTotal(" . $FeedId . ",'" . $date . "')";
        //echo $plantSumSql;
        $sumResults = mysqli_query(dbmysqli(), $plantSumSql);
        while ($sumResult = $sumResults->fetch_assoc()) {
            if ($sumResult['sum(value)'] == '' || $sumResult['sum(value)'] == null) {
                $daySumArry[] = 0;
            } else {
                $daySumArry[] = $sumResult['sum(value)'];
            }
//              echo("Weight{$i}: " . $daySumArry[$i] . "<br>");
        }

    }
    return $daySumArry;
}

function PlantMonthMoisture($locationId, $startDate, $count)
{
    $arraytotal = 0;
    $nonzerocount = 0;
    for ($i = 0; $i < $count; $i++) {

        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));

        $plantMoistureSql = "CALL sp_gb_plc_MoistureDayAvgGet(" . $locationId . ",'" . $date . "')";
        // echo "<br>" .$plantMoistureSql . "<br>";
        $mositureResults = mysqli_query(dbmysqli(), $plantMoistureSql);
        while ($moistureResult = $mositureResults->fetch_assoc()) {
            If ($moistureResult['avg(moisture_rate)'] == "" || $moistureResult['avg(moisture_rate)'] == null || $moistureResult['avg(moisture_rate)'] == 0) {
                $dayMoistureArry[] = 0;
            } else {
                $dayMoistureArry[] = $moistureResult['avg(moisture_rate)'];
                $arraytotal = $arraytotal + $moistureResult['avg(moisture_rate)'];
                $nonzerocount = $nonzerocount + 1;
            }
            //              echo("Rate{$i}: " . $dayMoistureArry[$i] . "<br>");
        }
//print_r($dayMoistureArry);
    }
    for ($i = 0; $i < $count; $i++) {
        if ($dayMoistureArry[$i] <= 0 && $nonzerocount != 0) {
            $dayMoistureArry[$i] = $arraytotal / $nonzerocount;
        } else {
            $dayMoistureArry[$i] = .055;
        }
    }
    return $dayMoistureArry;
}

function WeightedAvgMoisture($moistureArry, $dayArray)
{
    for ($i = 0; $i < count($dayArray); $i++) {
        $weightedMoisture[] = ($dayArray[$i] / array_sum($dayArray)) * $moistureArry[$i];
    }
    return array_sum($weightedMoisture);
}

function NetTons($moistureArry, $dayArray)
{
    for ($i = 0; $i < count($dayArray); $i++) {
        $netTons[] = $dayArray[$i] * (1 - $moistureArry[$i]);
    }
    return $netTons;
}

function PlantUpTimes($locationId, $startDate, $downtime, $schdowntime, $idletime, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantTimeSql = "CALL sp_gb_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
        // echo $plantTimeSql;
        $timeResults = mysqli_query(dbmysqli(), $plantTimeSql);

        while ($timeResult = $timeResults->fetch_assoc()) {
            if ($timeResult['uptime'] != '' && $timeResult['uptime'] != null) {
                $dayTimeUpArry[] = round(($timeResult['uptime']) / 60, 2);
                if ($dayTimeUpArry[$i] > 24.5) {
                    $dayTimeUpArry[$i] = 24.5 - $downtime[$i] - $schdowntime[$i] - $idletime[$i];
                }
            } else {
                $dayTimeUpArry[] = 24 - $downtime[$i] - $schdowntime[$i] - $idletime[$i];
            }
            // echo $dayTimeUpArry[$i] . "<br>";
        }
    }

    return $dayTimeUpArry;
}

function PlantSchDownTimes($locationId, $startDate, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantTimeSql = "CALL sp_gb_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
        //echo $plantTimeSql;
        $timeResults = mysqli_query(dbmysqli(), $plantTimeSql);

        while ($timeResult = $timeResults->fetch_assoc()) {
            if ($timeResult['schdowntime'] != '' && $timeResult['schdowntime'] != null) {
                $dayTimeDownArry[] = round(($timeResult['schdowntime']) / 60, 2);
            } else {
                $dayTimeDownArry[] = 0;
            }
            //echo($dayTimeDownArry[$i] . " <br>");
        }
    }

    return $dayTimeDownArry;
}

function PlantDownTimes($locationId, $startDate, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantTimeSql = "CALL sp_gb_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
        //echo $plantTimeSql;
        $timeResults = mysqli_query(dbmysqli(), $plantTimeSql);

        while ($timeResult = $timeResults->fetch_assoc()) {
            if ($timeResult['downtime'] != '' && $timeResult['downtime'] != null) {
                $dayTimeDownArry[] = round(($timeResult['downtime']) / 60, 2);
            } else {
                $dayTimeDownArry[] = 0;
            }
            //echo($dayTimeDownArry[$i] . " <br>");
        }
    }

    return $dayTimeDownArry;
}

function PlantIdleTimes($locationId, $startDate, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantTimeSql = "CALL sp_gb_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
        //echo $plantTimeSql;
        $timeResults = mysqli_query(dbmysqli(), $plantTimeSql);

        while ($timeResult = $timeResults->fetch_assoc()) {
            if ($timeResult['idletime'] != '' && $timeResult['idletime'] != null) {
                $dayTimeIdleArry[] = round(($timeResult['idletime']) / 60, 2);
            } else {
                $dayTimeIdleArry[] = 0;
            }
            //echo($dayTimeIdleArry[$i] . " <br>");
        }
    }

    return $dayTimeIdleArry;
}

function PercentRecovery($gross, $output, $grossTend, $outputTrend)
{
    if ($gross != 0) {
        $lastRecovery = sprintf("%.2f%%", ($output / $gross) * 100);
    } else {
        $lastRecovery = sprintf("%.2f%%", ($output * ($outputTrend / $grossTend)) * 100);
    }
    return ($lastRecovery);
}

function Carrier100Estimate($feedCarrier, $feedarry, $outputarry)
{
    for ($i = 0; $i < count($feedarry); $i++) {
        //Echo("test");
        if ($feedarry[$i] != 0 && $outputarry[$i] != 0) {
            $outputCarrierArry[] = round($feedCarrier[$i] * ($outputarry[$i] / $feedarry[$i]), 0);
            //echo $outputCarrierArry[$i] . "<br>";
        } else {
            $outputSum = array_sum($outputarry);
            $feedSum = array_sum($feedarry);
            $outputCarrierArry[] = round($feedCarrier[$i] * ($outputSum / $feedSum), 0);
            //echo $outputCarrierArry[$i] . "<br>";
        }
    }
    return $outputCarrierArry;
}

//============================================================ END PHP
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<style>
    input {
        width: 80%;
    }

    .card {
        margin-bottom: .5%;
    }

    .content-header {
        display: inline-block;
        margin-right: 50px;
        cursor: pointer

    }
</style>

<div class="container-fluid">
    <h3>Granbury Scorecard</h3>
    <!--<div class="card-columns">-->
    <div class="card">
        <div class="card-header">
            <h4>Target Settings</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-success" style="display:none" id="msg"></div>
            <div class="alert alert-danger" style="display:none" id="failuremsg"></div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label>Rotary Gross:</label>
                    <input class="form-control setting" type="number" id="grossRotaryTargetSetting" required value="<?php echo $grossRotarySetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>Rotary Net:</label>
                    <input class="form-control setting" type="number" id="netRotaryTargetSetting" required value="<?php echo $netRotarySetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>Rotary Output:</label>
                    <input class="form-control setting" type="number" id="outputRotaryTargetSetting" required value="<?php echo $outputRotarySetting ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label>100T Gross:</label>
                    <input class="form-control setting" type="number" id="gross100TTargetSetting" required value="<?php echo $gross100TSetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>100T Net:</label>
                    <input class="form-control setting" type="number" id="net100TTargetSetting" required value="<?php echo $net100TSetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>100T Output:</label>
                    <input class="form-control setting" type="number" id="output100TTargetSetting" required value="<?php echo $output100TSetting ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label>200T Gross:</label>
                    <input class="form-control setting" type="number" id="gross200TTargetSetting" required value="<?php echo $gross200TSetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>200T Net:</label>
                    <input class="form-control setting" type="number" id="net200TTargetSetting" required value="<?php echo $net200TSetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>200T Output:</label>
                    <input class="form-control setting" type="number" id="output200TTargetSetting" required value="<?php echo $output200TSetting ?>">
                </div>
            </div>
        </div>
        <div class='card-footer'>
            <button type="button" class="btn btn-vprop-green float-right" onclick="saveSetting()" value="Save Settings" style="float:right;">Save Settings</button>
        </div>
    </div>
    <h3>
        <div id='header-container'>

            <div id='cons-header' class='content-header vprop-blue-text'>
                Consolidated Dry Plant
                <div style='display:none' id='arrow-up'>&#9650;</div>
                <div style='display:inline-block' id='arrow-down'>&#9660;</div>
            </div>
            <div id='rotary-header' class='content-header vprop-blue-text'>
                Rotary
                <div style='display:none' id='arrow-up-rot'>&#9650;</div>
                <div style='display:inline-block' id='arrow-down-rot'>&#9660;</div>
            </div>

            <div id='carrier100-header' class='content-header vprop-blue-text'>
                100T Carrier
                <div style='display:none' id='arrow-up-100t'>&#9650;</div>
                <div style='display:inline-block' id='arrow-down-100t'>&#9660;</div>
            </div>
            <div id='carrier200-header' class='content-header vprop-blue-text'>
                200T Carrier
                <div style='display:none' id='arrow-up-200t'>&#9650;</div>
                <div style='display:inline-block' id='arrow-down-200t'>&#9660;</div>
            </div>
            <div id='time-header' class='content-header vprop-blue-text'>
                Times
                <div style='display:none' id='arrow-up-time'>&#9650;</div>
                <div style='display:inline-block' id='arrow-down-time'>&#9660;</div>
            </div>
        </div>
    </h3>
    <div id="cons-data" style="display:none">
        <div class="card">
            <div class="card-header">
                <h4>Consolidated Dry Plant</h4>
            </div>
            <div class="card-body">
                <div class='table-responsive-sm'>
                    <table id='consolidatedTable' class="table table-xl table-striped table-bordered table-hover nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:20%">Volume (Tons)</th>
                            <th style="width:20%"><?php echo $yesterday; ?></th>
                            <th style="width:20%">MTD</th>
                            <th style="width:20%">Trending</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed</td>
                            <td><?php echo $lastRotaryGross + $last100TGross + $last200TGross; ?></td>
                            <td><?php echo $mtdRotaryGross + $mtd100TGross + $mtd200TGross; ?></td>
                            <td><?php echo $trendingRotaryGross + $trending100TGross + $trending200TGross; ?></td>
                        </tr>
                        <tr>
                            <td>Net Feed</td>
                            <td><?php echo $lastRotaryNet + $last100TNet + $last200TNet; ?></td>
                            <td><?php echo $mtdRotaryNet + $mtd100TNet + $mtd200TNet; ?></td>
                            <td><?php echo $trendingRotaryNet + $trending100TNet + $trending200TNet; ?></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $lastRotaryOutput + $last100TOutput + $last200TOutput; ?></td>
                            <td><?php echo $mtdRotaryOutput + $mtd100TOutput + $mtd200TOutput; ?></td>
                            <td><?php echo $trendingRotaryOutput + $trending100TOutput + $trending200TOutput; ?></td>
                        </tr>
                        <tr>
                            <td>Recovery %</td>
                            <td><?php echo $lastConsolidatedRecovery; ?></td>
                            <td><?php echo $mtdConsolidatedRecovery; ?></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="consolidated-table-card-footer">

            </div>
        </div>
        <div class="card">
            <div class="card-header">
            <h4>Consolidated Plant Targets</h4>
            </div>
            <div class="card-body">
                <div class='table-responsive-sm'>
                    <table id="targetConsTable" class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th></th>
                            <th>Target</th>
                            <th>MTD</th>
                            <th>Trending</th>
                            <th>MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross</td>
                            <td><input class="form-control" id="grossConsTarget" type="number" disabled></td>
                            <td><input class="form-control" id="grossMtdConsTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossTrendConsTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossPercentConsTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Net</td>
                            <td><input class="form-control" id="netConsTarget" type="number" disabled></td>
                            <td><input class="form-control" id="netMtdConsTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netTrendConsTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netPercentConsTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><input class="form-control" id="outputConsTarget" type="number" disabled></td>
                            <td><input class="form-control" id="outputMtdConsTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputTrendConsTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputPercentConsTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Recovery</td>
                            <td><input class="form-control" id="recoveryConsLast" type="text" disabled></td>
                            <td><input class="form-control" id="recoveryConsMtd" type="text" disabled></td>
                            <td><input class="form-control" id="recoveryConsMonth" type="text" disabled></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="cons-footer">

            </div>
        </div>
        <div class="card">
            <div class="card-header">
            <h4>Consolidated Tonnage Per Hour</h4>
            </div>
            <div class="card-body">
                <div class='table-responsive-sm'>
                    <table id='tphConsTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:14%">Run Rate</th>
                            <th style="width:14%"><?php echo $yesterday; ?></th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed TPH</td>
                            <td><?php echo $grossRotaryTPH + $gross100TTPH + $gross100TTPH; ?></td>
                            <td><?php echo $mtdRotaryGrossTPH + $mtd100TGrossTPH + $mtd200TGrossTPH; ?></td>
                            <td><input class="form-control" id="grossConsTph" disabled></td>
                            <td><input class="form-control" id="grossConsTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Net Feed TPH</td>
                            <td><?php echo $netRotaryTPH + $net100TTPH + $net100TTPH; ?></td>
                            <td><?php echo $mtdRotaryNetTPH + $mtd100TNetTPH + $mtd200TNetTPH; ?></td>
                            <td><input class="form-control" id="netConsTph" disabled></td>
                            <td><input class="form-control" id="netConsTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $outputRotaryTPH + $output100TTPH + $output100TTPH; ?></td>
                            <td><?php echo $mtdRotaryOutputTPH + $mtd100TGrossTPH + $mtd200TGrossTPH; ?></td>
                            <td><input class="form-control" id="outputConsTph" disabled></td>
                            <td><input class="form-control" id="outputConsTphPercent" disabled></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="tph-cons-table-card-footer">

            </div>
        </div>
    </div>
    <div id="rotary-data" style="display:none">
        <div class="card">
            <div class="card-header">
            <h4>Rotary</h4>
            </div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id='rotaryTable' class="table table-xl table-striped table-bordered table-hover nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:20%">Volume (Tons)</th>
                            <th style="width:20%"><?php echo $yesterday; ?></th>
                            <th style="width:20%">MTD</th>
                            <th style="width:20%">Trending</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed</td>
                            <td><?php echo $lastRotaryGross; ?></td>
                            <td><?php echo $mtdRotaryGross; ?></td>
                            <td><?php echo $trendingRotaryGross; ?></td>
                        </tr>
                        <tr>
                            <td>Net Feed</td>
                            <td><?php echo $lastRotaryNet; ?></td>
                            <td><?php echo $mtdRotaryNet; ?></td>
                            <td><?php echo $trendingRotaryNet; ?></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $lastRotaryOutput; ?></td>
                            <td><?php echo $mtdRotaryOutput; ?></td>
                            <td><?php echo $trendingRotaryOutput; ?></td>
                        </tr>
                        <tr>
                            <td>Recovery %</td>
                            <td><?php echo $lastRotaryRecovery; ?></td>
                            <td><?php echo $mtdRotaryRecovery; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Avg Moisture %</td>
                            <td><?php echo $lastRotaryMoisture; ?></td>
                            <td><?php echo $mtdRotaryMoisture; ?></td>
                            <td></td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="card-footer" id="rotary-table-card-footer"></div>
        </div>

        <div class="card">
            <div class="card-header"><h4>Rotary Targets</h4></div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id="targetRotaryTable" class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                        </tr>
                        <tr>
                            <th style="width:14%"></th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Trending</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross</td>
                            <td><input class="form-control" id="grossRotaryTarget" type="number" disabled></td>
                            <td><input class="form-control" id="grossMtdRotaryTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossTrendRotaryTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossPercentRotaryTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Net</td>
                            <td><input class="form-control" id="netRotaryTarget" type="number" disabled></td>
                            <td><input class="form-control" id="netMtdRotaryTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netTrendRotaryTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netPercentRotaryTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><input class="form-control" id="outputRotaryTarget" type="number" disabled></td>
                            <td><input class="form-control" id="outputMtdRotaryTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputTrendRotaryTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputPercentRotaryTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Recovery</td>
                            <td><input class="form-control" id="recoveryRotaryLast" type="text" disabled></td>
                            <td><input class="form-control" id="recoveryRotaryMtd" type="text" disabled></td>
                            <td><input class="form-control" id="recoveryRotaryMonth" type="text" disabled></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="target-rotary-table-card-footer"></div>
        </div>

        <div class="card">
            <div class="card-header">
            <h4>Rotary Tonnage Per Hour</h4>
            </div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id='tphRotaryTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:14%">Run Rate</th>
                            <th style="width:14%"><?php echo $yesterday; ?></th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed TPH</td>
                            <td><?php echo $grossRotaryTPH; ?></td>
                            <td><?php echo $mtdRotaryGrossTPH; ?></td>
                            <td><input class="form-control" id="grossRotaryTph" disabled></td>
                            <td><input class="form-control" id="grossRotaryTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Net Feed TPH</td>
                            <td><?php echo $netRotaryTPH; ?></td>
                            <td><?php echo $mtdRotaryNetTPH; ?></td>
                            <td><input class="form-control" id="netRotaryTph" disabled></td>
                            <td><input class="form-control" id="netRotaryTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $outputRotaryTPH; ?></td>
                            <td><?php echo $mtdRotaryOutputTPH; ?></td>
                            <td><input class="form-control" id="outputRotaryTph" disabled></td>
                            <td><input class="form-control" id="outputRotaryTphPercent" disabled></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="tph-rotary-table-card-footer"></div>
        </div>
        <h4 id='rotary-header-table' class="vprop-blue-text">
            Rotary Table
            <div style='display:none' id='arrow-up-rot-tbl'>&#9650;</div>
            <div style='display:inline-block' id='arrow-down-rot-tbl'>&#9660;</div>
        </h4>

        <div id="rotary-table" class="table-responsive-sm" style="display:none">
            <div class="card">
                <table class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th colspan="100%">Daily Breakdown</th>
                    </tr>
                    <tr>
                        <th style='width:11.1%'>Date</th>
                        <th style='width:11.1%'>Gross Feed</th>
                        <th style='width:11.1%'>Net Feed</th>
                        <th style='width:11.1%'>Net to Silo</th>
                        <th style='width:11.1%'>Average Moisture</th>
                        <th style='width:11.1%'>Run Hrs*</th>
                        <th style='width:11.1%'>Scheduled Delay</th>
                        <th style='width:11.1%'>Unscheduled Delay</th>
                        <th style='width:11.1%'>Idle Delay</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($gbRotaryFeedSumArry); $i++) {
                        $date = date('Y-m-d ', strtotime($firstDayOfMonth . " +" . $i . " day"));
                        $moisture = sprintf("%.2f%%", ($gbRotaryMoistureArry[$i]) * 100);
                        $ntWeight = round($netWeightRotaryArry[$i], 0);
                        echo("<tr>"
                            . "<td>{$date}</td>"
                            . "<td>{$gbRotaryFeedSumArry[$i]}</td>"
                            . "<td>{$ntWeight}</td>"
                            . "<td>{$gbRotaryOutputSumArry[$i]}</td>"
                            . "<td>{$moisture}</td>"
                            . "<td>{$uptimeRotaryArry[$i]}</td>"
                            . "<td>{$schdtRotaryArry[$i]}</td>"
                            . "<td>{$dtRotaryArry[$i]}</td>"
                            . "<td>{$itRotaryArry[$i]}</td>"
                            . "</tr>");
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="carrier100-data" style="display:none">
        <div class="card">
            <div class="card-header">
            <h4>100T Carrier</h4>
            </div>
            <div class="card-body">
                <div class='table-responsive-sm'>
                    <table id='carrier100tTable' class="table table-xl table-striped table-bordered table-hover nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:20%">Volume (Tons)</th>
                            <th style="width:20%"><?php echo $yesterday; ?></th>
                            <th style="width:20%">MTD</th>
                            <th style="width:20%">Trending</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed</td>
                            <td><?php echo $last100TGross; ?></td>
                            <td><?php echo $mtd100TGross; ?></td>
                            <td><?php echo $trending100TGross; ?></td>
                        </tr>
                        <tr>
                            <td>Net Feed</td>
                            <td><?php echo $last100TNet; ?></td>
                            <td><?php echo $mtd100TNet; ?></td>
                            <td><?php echo $trending100TNet; ?></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $last100TOutput; ?></td>
                            <td><?php echo $mtd100TOutput; ?></td>
                            <td><?php echo $trending100TOutput; ?></td>
                        </tr>
                        <tr>
                            <td>Recovery %</td>
                            <td><?php echo $last100TRecovery; ?></td>
                            <td><?php echo $mtd100TRecovery; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Avg Moisture %</td>
                            <td><?php echo $last100TMoisture; ?></td>
                            <td><?php echo $mtd100TMoisture; ?></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="carrier-100t-table-card-footer">
            </div>
        </div>
        <div class="card">
            <div class="card-header">
            <h4>100T Targets</h4>
            </div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id="target100TTable" class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                        </tr>
                        <tr>
                            <th style="width:14%"></th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Trending</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross</td>
                            <td><input class="form-control" id="gross100TTarget" type="number" disabled></td>
                            <td><input class="form-control" id="grossMtd100TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossTrend100TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossPercent100TTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Net</td>
                            <td><input class="form-control" id="net100TTarget" type="number" disabled></td>
                            <td><input class="form-control" id="netMtd100TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netTrend100TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netPercent100TTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><input class="form-control" id="output100TTarget" type="number" disabled></td>
                            <td><input class="form-control" id="outputMtd100TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputTrend100TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputPercent100TTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Recovery</td>
                            <td><input class="form-control" id="recovery100TLast" type="text" disabled></td>
                            <td><input class="form-control" id="recovery100TMtd" type="text" disabled></td>
                            <td><input class="form-control" id="recovery100TMonth" type="text" disabled></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="target-100T-table-card-footer">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
            <h4>100T Tonnage Per Hour</h4>
            </div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id='tph100TTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:14%">Run Rate</th>
                            <th style="width:14%"><?php echo $yesterday; ?></th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed TPH</td>
                            <td><?php echo $gross100TTPH; ?></td>
                            <td><?php echo $mtd100TGrossTPH; ?></td>
                            <td><input class="form-control" id="gross100TTph" disabled></td>
                            <td><input class="form-control" id="gross100TTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Net Feed TPH</td>
                            <td><?php echo $net100TTPH; ?></td>
                            <td><?php echo $mtd100TNetTPH; ?></td>
                            <td><input class="form-control" id="net100TTph" disabled></td>
                            <td><input class="form-control" id="net100TTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $output100TTPH; ?></td>
                            <td><?php echo $mtd100TOutputTPH; ?></td>
                            <td><input class="form-control" id="output100TTph" disabled></td>
                            <td><input class="form-control" id="output100TTphPercent" disabled></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="tph-100T-table-card-footer"></div>
        </div>


        <h4 id='carrier100-header-table' class="vprop-blue-text">
            100T Carrier Table
            <div style='display:none' id='arrow-up-100t-tbl'>&#9650;</div>
            <div style='display:inline-block' id='arrow-down-100t-tbl'>&#9660;</div>
        </h4>

        <div  class="table-responsive-sm" style="display:none">
            <div class="card">
                <table id="carrier100-table" class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th colspan="100%">Daily Breakdown</th>
                    </tr>
                    <tr>
                        <th style='width:11.1%'>Date</th>
                        <th style='width:11.1%'>Gross Feed</th>
                        <th style='width:11.1%'>Net Feed</th>
                        <th style='width:11.1%'>Net to Silo</th>
                        <th style='width:11.1%'>Average Moisture</th>
                        <th style='width:11.1%'>Run Hrs*</th>
                        <th style='width:11.1%'>Scheduled Delay</th>
                        <th style='width:11.1%'>Unscheduled Delay</th>
                        <th style='width:11.1%'>Idle Delay</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($gb100TFeedSumArry); $i++) {
                        $date = date('Y-m-d ', strtotime($firstDayOfMonth . " +" . $i . " day"));
                        $moisture = sprintf("%.2f%%", ($gb100TMoistureArry[$i]) * 100);
                        $ntWeight = round($netWeight100TArry[$i], 0);
                        echo("<tr>"
                            . "<td>{$date}</td>"
                            . "<td>{$gb100TFeedSumArry[$i]}</td>"
                            . "<td>{$ntWeight}</td>"
                            . "<td>{$gb100TOutputSumArry[$i]}</td>"
                            . "<td>{$moisture}</td>"
                            . "<td>{$uptime100TArry[$i]}</td>"
                            . "<td>{$schdt100TArry[$i]}</td>"
                            . "<td>{$dt100TArry[$i]}</td>"
                            . "<td>{$it100TArry[$i]}</td>"
                            . "</tr>");
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="carrier200-data" style="display:none">
        <div class="card">
            <div class="card-header">
            <h4>200T Carrier</h4>
            </div>
            <div class="card-body">
                <div class='table-responsive-sm'>
                    <table  id='carrier200tTable' class="table table-xl table-striped table-bordered table-hover nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:20%">Volume (Tons)</th>
                            <th style="width:20%"><?php echo $yesterday; ?></th>
                            <th style="width:20%">MTD</th>
                            <th style="width:20%">Trending</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed</td>
                            <td><?php echo $last200TGross; ?></td>
                            <td><?php echo $mtd200TGross; ?></td>
                            <td><?php echo $trending200TGross; ?></td>
                        </tr>
                        <tr>
                            <td>Net Feed</td>
                            <td><?php echo $last200TNet; ?></td>
                            <td><?php echo $mtd200TNet; ?></td>
                            <td><?php echo $trending200TNet; ?></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $last200TOutput; ?></td>
                            <td><?php echo $mtd200TOutput; ?></td>
                            <td><?php echo $trending200TOutput; ?></td>
                        </tr>
                        <tr>
                            <td>Recovery %</td>
                            <td><?php echo $last200TRecovery; ?></td>
                            <td><?php echo $mtd200TRecovery; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Avg Moisture %</td>
                            <td><?php echo $last200TMoisture; ?></td>
                            <td><?php echo $mtd200TMoisture; ?></td>
                            <td></td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="card-footer" id="carrier-200t-table-card-footer"></div>
        </div>
        <div class="card">
            <div class="card-header">
            <h4>200T Targets</h4>
            </div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id="target200TTable" class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                        </tr>
                        <tr>
                            <th style="width:14%"></th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Trending</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross</td>
                            <td><input class="form-control" id="gross200TTarget" type="number" disabled></td>
                            <td><input class="form-control" id="grossMtd200TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossTrend200TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="grossPercent200TTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Net</td>
                            <td><input class="form-control" id="net200TTarget" type="number" disabled></td>
                            <td><input class="form-control" id="netMtd200TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netTrend200TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="netPercent200TTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><input class="form-control" id="output200TTarget" type="number" disabled></td>
                            <td><input class="form-control" id="outputMtd200TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputTrend200TTarget" type="text" disabled></td>
                            <td><input class="form-control" id="outputPercent200TTarget" type="text" disabled></td>
                        </tr>
                        <tr>
                            <td>Recovery</td>
                            <td><input class="form-control" id="recovery200TLast" type="text" disabled></td>
                            <td><input class="form-control" id="recovery200TMtd" type="text" disabled></td>
                            <td><input class="form-control" id="recovery200TMonth" type="text" disabled></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="target-200T-table-card-footer"></div>
        </div>
        <div class="card">
            <div class="card-header">
            <h4>200T Tonnage Per Hour</h4>
            </div>
            <div class="card-body">
                <div  class='table-responsive-sm'>
                    <table id='tph200TTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th style="width:14%">Run Rate</th>
                            <th style="width:14%"><?php echo $yesterday; ?></th>
                            <th style="width:14%">MTD</th>
                            <th style="width:14%">Target</th>
                            <th style="width:14%">MTD % of Target</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Gross Feed TPH</td>
                            <td><?php echo $gross200TTPH; ?></td>
                            <td><?php echo $mtd200TGrossTPH; ?></td>
                            <td><input class="form-control" id="gross200TTph" disabled></td>
                            <td><input class="form-control" id="gross200TTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Net Feed TPH</td>
                            <td><?php echo $net200TTPH; ?></td>
                            <td><?php echo $mtd200TNetTPH; ?></td>
                            <td><input class="form-control" id="net200TTph" disabled></td>
                            <td><input class="form-control" id="net200TTphPercent" disabled></td>
                        </tr>
                        <tr>
                            <td>Tons To Silo</td>
                            <td><?php echo $output200TTPH; ?></td>
                            <td><?php echo $mtd200TOutputTPH; ?></td>
                            <td><input class="form-control" id="output200TTph" disabled></td>
                            <td><input class="form-control" id="output200TTphPercent" disabled></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="tph-200T-table-card-footer"></div>
        </div>

        <h4 id='carrier200-header-table' class="vprop-blue-text">
            200T Carrier Table
            <div style='display:none' id='arrow-up-200t-tbl'>&#9650;</div>
            <div style='display:inline-block' id='arrow-down-200t-tbl'>&#9660;</div>
        </h4>
        <div id="carrier200-table" class="table-responsive-sm" style="display:none">
            <div class="card">
                <table class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th colspan="100%">Daily Breakdown</th>
                    </tr>
                    <tr>
                        <th style='width:11.1%'>Date</th>
                        <th style='width:11.1%'>Gross Feed</th>
                        <th style='width:11.1%'>Net Feed</th>
                        <th style='width:11.1%'>Net to Silo</th>
                        <th style='width:11.1%'>Average Moisture</th>
                        <th style='width:11.1%'>Run Hrs*</th>
                        <th style='width:11.1%'>Scheduled Delay</th>
                        <th style='width:11.1%'>Unscheduled Delay</th>
                        <th style='width:11.1%'>Idle Delay</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($gb200TFeedSumArry); $i++) {
                        $date = date('Y-m-d ', strtotime($firstDayOfMonth . " +" . $i . " day"));
                        $moisture = sprintf("%.2f%%", ($gb200TMoistureArry[$i]) * 200);
                        $ntWeight = round($netWeight200TArry[$i], 0);
                        echo("<tr>"
                            . "<td>{$date}</td>"
                            . "<td>{$gb200TFeedSumArry[$i]}</td>"
                            . "<td>{$ntWeight}</td>"
                            . "<td>{$gb200TOutputSumArry[$i]}</td>"
                            . "<td>{$moisture}</td>"
                            . "<td>{$uptime200TArry[$i]}</td>"
                            . "<td>{$schdt200TArry[$i]}</td>"
                            . "<td>{$dt200TArry[$i]}</td>"
                            . "<td>{$it200TArry[$i]}</td>"
                            . "</tr>");
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="time-data" style="display:none">
        <div class="card">
            <div class="card-header">
            <h4>Times</h4>
            </div>
            <div class="card-body">
                <divclass='table-responsive-sm'>
                    <table id='timeHoursTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                        <thead class="th-vprop-blue-medium">
                        <tr>
                            <th></th>
                            <th>Rotary</th>
                            <th><?php echo $yesterday; ?></th>
                            <th>MTD</th>
                            <th>100T Carrier</th>
                            <th><?php echo $yesterday; ?></th>
                            <th>MTD</th>
                            <th>200T Carrier</th>
                            <th><?php echo $yesterday; ?></th>
                            <th>MTD</th>
                            <th>Total</th>
                            <th><?php echo $yesterday; ?></th>
                            <th>MTD</th>
                        </tr>
                        <tbody>
                        <tr>
                            <td>Run Hours</td>
                            <td></td>
                            <td><?php echo $lastRotaryUptime; ?></td>
                            <td><?php echo $mtdRotaryUptime; ?></td>
                            <td></td>
                            <td><?php echo $last100TUptime; ?></td>
                            <td><?php echo $mtd100TUptime; ?></td>
                            <td></td>
                            <td><?php echo $last200TUptime; ?></td>
                            <td><?php echo $mtd200TUptime; ?></td>
                            <td></td>
                            <td><?php echo $lastRotaryUptime + $last100TUptime + $last200TUptime; ?></td>
                            <td><?php echo $mtdRotaryUptime + $mtd100TUptime + $mtd200TUptime; ?></td>
                        </tr>
                        <tr>
                            <td>Unscheduled Delay Hours</td>
                            <td></td>
                            <td><?php echo $lastRotaryDowntime + $lastRotaryIdletime; ?></td>
                            <td><?php echo $mtdRotaryDowntime + $mtdRotaryIdletime; ?></td>
                            <td></td>
                            <td><?php echo $last100TDowntime + $last100TIdletime; ?></td>
                            <td><?php echo $mtd100TDowntime + $mtd100TIdletime; ?></td>
                            <td></td>
                            <td><?php echo $last200TDowntime + $last200TIdletime; ?></td>
                            <td><?php echo $mtd200TDowntime + $mtd200TIdletime; ?></td>
                            <td></td>
                            <td><?php echo $lastRotaryDowntime + $lastRotaryIdletime + $last100TDowntime + $last100TIdletime + $last200TDowntime + $last200TIdletime; ?></td>
                            <td><?php echo $mtdRotaryDowntime + $mtdRotaryIdletime + $mtd100TDowntime + $mtd100TIdletime + $mtd200TDowntime + $mtd200TIdletime; ?></td>
                        </tr>
                        <tr>
                            <td>Scheduled Delay Hours</td>
                            <td></td>
                            <td><?php echo $lastRotarySchDowntime; ?></td>
                            <td><?php echo $mtdRotarySchDowntime; ?></td>
                            <td></td>
                            <td><?php echo $last100TSchDowntime; ?></td>
                            <td><?php echo $mtd100TSchDowntime; ?></td>
                            <td></td>
                            <td><?php echo $last200TSchDowntime; ?></td>
                            <td><?php echo $mtd200TSchDowntime; ?></td>
                            <td></td>
                            <td><?php echo $lastRotarySchDowntime + $last100TSchDowntime + $last200TSchDowntime; ?></td>
                            <td><?php echo $mtdRotarySchDowntime + $mtd100TSchDowntime + $mtd200TSchDowntime; ?></td>
                        </tr>
                        <tr>
                            <td>Total Hours</td>
                            <td></td>
                            <td><?php echo $lastRotaryUptime + $lastRotarySchDowntime + $lastRotaryDowntime + $lastRotaryIdletime; ?></td>
                            <td><?php echo $mtdRotaryUptime + $mtdRotarySchDowntime + $mtdRotaryDowntime + $mtdRotaryIdletime; ?></td>
                            <td></td>
                            <td><?php echo $last100TUptime + $last100TSchDowntime + $last100TDowntime + $last100TIdletime; ?></td>
                            <td><?php echo $mtd100TUptime + $mtd100TSchDowntime + $mtd100TDowntime + $mtd100TIdletime; ?></td>
                            <td></td>
                            <td><?php echo $last200TUptime + $last200TSchDowntime + $last200TDowntime + $last200TIdletime; ?></td>
                            <td><?php echo $mtd200TUptime + $mtd200TSchDowntime + $mtd200TDowntime + $mtd200TIdletime; ?></td>
                            <td></td>
                            <td>
                                <?php
                                echo
                                    $lastRotaryUptime + $lastRotarySchDowntime + $lastRotaryDowntime + $lastRotaryIdletime +
                                    $last100TUptime + $last100TSchDowntime + $last100TDowntime + $last100TIdletime +
                                    $last200TUptime + $last200TSchDowntime + $last200TDowntime + $last200TIdletime;
                                ?>
                            </td>
                            <td>
                                <?php
                                echo
                                    $mtdRotaryUptime + $mtdRotarySchDowntime + $mtdRotaryDowntime + $mtdRotaryIdletime +
                                    $mtd100TUptime + $mtd100TSchDowntime + $mtd100TDowntime + $mtd100TIdletime +
                                    $mtd200TUptime + $mtd200TSchDowntime + $mtd200TDowntime + $mtd200TIdletime;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Uptime Percent</td>
                            <td></td>
                            <td><?php echo $uptimeRotaryPercent; ?></td>
                            <td><?php echo $mtdUptimeRotaryPercent; ?></td>
                            <td></td>
                            <td><?php echo $uptime100TPercent; ?></td>
                            <td><?php echo $mtdUptime100TPercent; ?></td>
                            <td></td>
                            <td><?php echo $uptime200TPercent; ?></td>
                            <td><?php echo $mtdUptime200TPercent; ?></td>
                            <td></td>
                            <td><?php echo $uptimeConsPercent; ?></td>
                            <td><?php echo $mtdUptimeConsPercent; ?></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer" id="time-hours-table-card-footer"></div>
        </div>
    </div>
</div><!-- container closer-->
<script>
    $(document).ready(function () {
        //<editor-fold desc="">
        $('.dt-buttons').removeClass('btn-group').addClass('float-right');
        $('.buttons-excel').removeClass('btn-secondary').addClass('btn-vprop-green');

        $("#grossRotaryTarget").val($('#grossRotaryTargetSetting').val());
        $("#netRotaryTarget").val($('#netRotaryTargetSetting').val());
        $("#outputRotaryTarget").val($('#outputRotaryTargetSetting').val());

        $("#gross100TTarget").val($('#gross100TTargetSetting').val());
        $("#net100TTarget").val($('#net100TTargetSetting').val());
        $("#output100TTarget").val($('#output100TTargetSetting').val());

        $("#gross200TTarget").val($('#gross200TTargetSetting').val());
        $("#net200TTarget").val($('#net200TTargetSetting').val());
        $("#output200TTarget").val($('#output200TTargetSetting').val());

        var grossTargetRotary = $("#grossRotaryTarget").val();
        var netTargetRotary = $("#netRotaryTarget").val();
        var outputTargetRotary = $("#outputRotaryTarget").val();

        var grossTarget100T = $("#gross100TTarget").val();
        var netTarget100T = $("#net100TTarget").val();
        var outputTarget100T = $("#output100TTarget").val();

        var grossTarget200T = $("#gross200TTarget").val();
        var netTarget200T = $("#net200TTarget").val();
        var outputTarget200T = $("#output200TTarget").val();

        var grossTargetCons = parseInt(grossTargetRotary) + parseInt(grossTarget100T) + parseInt(grossTarget200T);
        var netTargetCons = parseInt(netTargetRotary) + parseInt(netTarget100T) + parseInt(netTarget200T);
        var outputTargetCons = parseInt(outputTargetRotary) + parseInt(outputTarget100T) + parseInt(outputTarget200T);

        $("#grossConsTarget").val(grossTargetCons);
        $("#netConsTarget").val(netTargetCons);
        $("#outputConsTarget").val(outputTargetCons);

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>);

        var grossMtdRotary = grossTargetRotary * days;
        var netMtdRotary = netTargetRotary * days;
        var outputMtdRotary = outputTargetRotary * days;

        var grossMtd100T = grossTarget100T * days;
        var netMtd100T = netTarget100T * days;
        var outputMtd100T = outputTarget100T * days;

        var grossMtd200T = grossTarget200T * days;
        var netMtd200T = netTarget200T * days;
        var outputMtd200T = outputTarget200T * days;

        var grossMtdCons = grossTargetCons * days;
        var netMtdCons = netTargetCons * days;
        var outputMtdCons = outputTargetCons * days;

        var grossTrendRotary = grossTargetRotary * daysInMonth;
        var netTrendRotary = netTargetRotary * daysInMonth;
        var outputTrendRotary = outputTargetRotary * daysInMonth;

        var grossTrend100T = grossTarget100T * daysInMonth;
        var netTrend100T = netTarget100T * daysInMonth;
        var outputTrend100T = outputTarget100T * daysInMonth;

        var grossTrend200T = grossTarget200T * daysInMonth;
        var netTrend200T = netTarget200T * daysInMonth;
        var outputTrend200T = outputTarget200T * daysInMonth;

        var grossTrendCons = grossTargetCons * daysInMonth;
        var netTrendCons = netTargetCons * daysInMonth;
        var outputTrendCons = outputTargetCons * daysInMonth;


        var percentRotaryGross = ((<?php echo $mtdRotaryGross; ?>/grossMtdRotary) * 100).toFixed(2) + '%';
        var percentRotaryNet = ((<?php echo $mtdRotaryNet; ?>/netMtdRotary) * 100).toFixed(2) + '%';
        var percentRotaryOutput = ((<?php echo $mtdRotaryOutput; ?>/outputMtdRotary) * 100).toFixed(2) + '%';

        var percent100TGross = ((<?php echo $mtd100TGross; ?>/grossMtd100T) * 100).toFixed(2) + '%';
        var percent100TNet = ((<?php echo $mtd100TNet; ?>/netMtd100T) * 100).toFixed(2) + '%';
        var percent100TOutput = ((<?php echo $mtd100TOutput; ?>/outputMtd100T) * 100).toFixed(2) + '%';

        var percent200TGross = ((<?php echo $mtd200TGross; ?>/grossMtd200T) * 100).toFixed(2) + '%';
        var percent200TNet = ((<?php echo $mtd200TNet; ?>/netMtd200T) * 100).toFixed(2) + '%';
        var percent200TOutput = ((<?php echo $mtd200TOutput; ?>/outputMtd200T) * 100).toFixed(2) + '%';

        var percentConsGross = ((<?php echo $mtdRotaryGross + $mtd100TGross + $mtd200TGross; ?>/grossTrendCons) * 100).toFixed(2) + '%';
        var percentConsNet = ((<?php echo $mtdRotaryNet + $mtd100TNet + $mtd200TNet; ?>/netTrendCons) * 100).toFixed(2) + '%';
        var percentConsOutput = ((<?php echo $mtdRotaryOutput + $mtd100TOutput + $mtd200TOutput; ?>/outputTrendCons) * 100).toFixed(2) + '%';

        var recoveryPercentRotary = ((outputTargetRotary / grossTargetRotary) * 100).toFixed(2) + '%';
        var recoveryPercent100T = ((outputTarget100T / grossTarget100T) * 100).toFixed(2) + '%';
        var recoveryPercent200T = ((outputTarget200T / grossTarget200T) * 100).toFixed(2) + '%';
        var recoveryPercentCons = ((outputTargetCons / grossTargetCons) * 100).toFixed(2) + '%';

        var targetRotaryGrossTPH = (grossMtdRotary /<?php echo($mtdRotaryUptime)?>).toFixed(2);
        var targetRotaryNetTPH = (netMtdRotary /<?php echo($mtdRotaryUptime)?>).toFixed(2);
        var targetRotaryOutputTPH = (outputMtdRotary /<?php echo($mtdRotaryUptime)?>).toFixed(2);

        var target100TGrossTPH = (grossMtd100T /<?php echo($mtd100TUptime)?>).toFixed(2);
        var target100TNetTPH = (netMtd100T /<?php echo($mtd100TUptime)?>).toFixed(2);
        var target100TOutputTPH = (outputMtd100T /<?php echo($mtd100TUptime)?>).toFixed(2);

        var target200TGrossTPH = (grossMtd200T /<?php echo($mtd200TUptime)?>).toFixed(2);
        var target200TNetTPH = (netMtd200T /<?php echo($mtd200TUptime)?>).toFixed(2);
        var target200TOutputTPH = (outputMtd200T /<?php echo($mtd200TUptime)?>).toFixed(2);

        var targetConsGrossTPH = (parseInt(targetRotaryGrossTPH) + parseInt(target100TGrossTPH) + parseInt(target200TGrossTPH)).toFixed(2);
        var targetConsNetTPH = (parseInt(targetRotaryNetTPH) + parseInt(target100TNetTPH) + parseInt(target200TNetTPH)).toFixed(2);
        var targetConsOutputTPH = (parseInt(targetRotaryOutputTPH) + parseInt(target100TOutputTPH) + parseInt(target200TOutputTPH)).toFixed(2);

        var targetRotaryGrossTPHPercent = (((<?php echo $mtdRotaryGrossTPH ?> -targetRotaryGrossTPH) / targetRotaryGrossTPH) * 100).toFixed(2) + '%';
        var targetRotaryNetTPHPercent = (((<?php echo $mtdRotaryNetTPH ?> -targetRotaryNetTPH) / targetRotaryNetTPH) * 100).toFixed(2) + '%';
        var targetRotaryOutputTPHPercent = (((<?php echo $mtdRotaryOutputTPH ?> -targetRotaryOutputTPH) / targetRotaryOutputTPH) * 100).toFixed(2) + '%';

        var target100TGrossTPHPercent = (((<?php echo $mtd100TGrossTPH ?> -target100TGrossTPH) / target100TGrossTPH) * 100).toFixed(2) + '%';
        var target100TNetTPHPercent = (((<?php echo $mtd100TNetTPH ?> -target100TNetTPH) / target100TNetTPH) * 100).toFixed(2) + '%';
        var target100TOutputTPHPercent = (((<?php echo $mtd100TOutputTPH ?> -target100TOutputTPH) / target100TOutputTPH) * 100).toFixed(2) + '%';

        var target200TGrossTPHPercent = (((<?php echo $mtd200TGrossTPH ?> -target200TGrossTPH) / target200TGrossTPH) * 100).toFixed(2) + '%';
        var target200TNetTPHPercent = (((<?php echo $mtd200TNetTPH ?> -target200TNetTPH) / target200TNetTPH) * 100).toFixed(2) + '%';
        var target200TOutputTPHPercent = (((<?php echo $mtd200TOutputTPH ?> -target200TOutputTPH) / target200TOutputTPH) * 100).toFixed(2) + '%';

        var targetConsGrossTPHPercent = (((<?php echo $mtdConsGrossTPH ?> -targetConsGrossTPH) / targetConsGrossTPH) * 100).toFixed(2) + '%';
        var targetConsNetTPHPercent = (((<?php echo $mtdConsNetTPH ?> -targetConsNetTPH) / targetConsNetTPH) * 100).toFixed(2) + '%';
        var targetConsOutputTPHPercent = (((<?php echo $mtdConsOutputTPH ?> -targetConsOutputTPH) / targetConsOutputTPH) * 100).toFixed(2) + '%';


        $("#grossMtdRotaryTarget").val(grossMtdRotary);
        $('#grossTrendRotaryTarget').val(grossTrendRotary);
        $('#grossPercentRotaryTarget').val(percentRotaryGross);

        $("#netMtdRotaryTarget").val(netMtdRotary);
        $('#netTrendRotaryTarget').val(netTrendRotary);
        $('#netPercentRotaryTarget').val(percentRotaryNet);

        $("#outputMtdRotaryTarget").val(outputMtdRotary);
        $('#outputTrendRotaryTarget').val(outputTrendRotary);
        $('#outputPercentRotaryTarget').val(percentRotaryOutput);

        $("#grossMtd100TTarget").val(grossMtd100T);
        $('#grossTrend100TTarget').val(grossTrend100T);
        $('#grossPercent100TTarget').val(percent100TGross);

        $("#netMtd100TTarget").val(netMtd100T);
        $('#netTrend100TTarget').val(netTrend100T);
        $('#netPercent100TTarget').val(percent100TNet);

        $("#outputMtd100TTarget").val(outputMtd100T);
        $('#outputTrend100TTarget').val(outputTrend100T);
        $('#outputPercent100TTarget').val(percent100TOutput);

        $("#grossMtd200TTarget").val(grossMtd200T);
        $('#grossTrend200TTarget').val(grossTrend200T);
        $('#grossPercent200TTarget').val(percent200TGross);

        $("#netMtd200TTarget").val(netMtd200T);
        $('#netTrend200TTarget').val(netTrend200T);
        $('#netPercent200TTarget').val(percent200TNet);

        $("#outputMtd200TTarget").val(outputMtd200T);
        $('#outputTrend200TTarget').val(outputTrend200T);
        $('#outputPercent200TTarget').val(percent200TOutput);

        $("#grossMtdConsTarget").val(grossMtdCons);
        $('#grossTrendConsTarget').val(grossTrendCons);
        $('#grossPercentConsTarget').val(percentConsGross);

        $("#netMtdConsTarget").val(netMtdCons);
        $('#netTrendConsTarget').val(netTrendCons);
        $('#netPercentConsTarget').val(percentConsNet);

        $("#outputMtdConsTarget").val(outputMtdCons);
        $('#outputTrendConsTarget').val(outputTrendCons);
        $('#outputPercentConsTarget').val(percentConsOutput);

        $("#recoveryRotaryLast").val(recoveryPercentRotary);
        $("#recoveryRotaryMtd").val(recoveryPercentRotary);
        $("#recoveryRotaryMonth").val(recoveryPercentRotary);

        $("#recovery100TLast").val(recoveryPercent100T);
        $("#recovery100TMtd").val(recoveryPercent100T);
        $("#recovery100TMonth").val(recoveryPercent100T);

        $("#recovery200TLast").val(recoveryPercent200T);
        $("#recovery200TMtd").val(recoveryPercent200T);
        $("#recovery200TMonth").val(recoveryPercent200T);

        $("#recoveryConsLast").val(recoveryPercentCons);
        $("#recoveryConsMtd").val(recoveryPercentCons);
        $("#recoveryConsMonth").val(recoveryPercentCons);

        $('#grossRotaryTph').val(targetRotaryGrossTPH);
        $('#netRotaryTph').val(targetRotaryNetTPH);
        $('#outputRotaryTph').val(targetRotaryOutputTPH);

        $('#gross100TTph').val(target100TGrossTPH);
        $('#net100TTph').val(target100TNetTPH);
        $('#output100TTph').val(target100TOutputTPH);

        $('#gross200TTph').val(target200TGrossTPH);
        $('#net200TTph').val(target200TNetTPH);
        $('#output200TTph').val(target200TOutputTPH);

        $('#grossConsTph').val(targetConsGrossTPH);
        $('#netConsTph').val(targetConsNetTPH);
        $('#outputConsTph').val(targetConsOutputTPH);

        $('#grossRotaryTphPercent').val(targetRotaryGrossTPHPercent);
        $('#netRotaryTphPercent').val(targetRotaryNetTPHPercent);
        $('#outputRotaryTphPercent').val(targetRotaryOutputTPHPercent);

        $('#gross100TTphPercent').val(target100TGrossTPHPercent);
        $('#net100TTphPercent').val(target100TNetTPHPercent);
        $('#output100TTphPercent').val(target100TOutputTPHPercent);

        $('#gross200TTphPercent').val(target200TGrossTPHPercent);
        $('#net200TTphPercent').val(target200TNetTPHPercent);
        $('#output200TTphPercent').val(target200TOutputTPHPercent);

        $('#grossConsTphPercent').val(targetConsGrossTPHPercent);
        $('#netConsTphPercent').val(targetConsNetTPHPercent);
        $('#outputConsTphPercent').val(targetConsOutputTPHPercent);
        //</editor-fold>
    });

    $('#grossRotaryTargetSetting').on('input', function () {
        var grossTargetRotary = $("#grossRotaryTargetSetting").val();
        var outputTargetRotary = $("#outputRotaryTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var grossMtdTargetRotary = grossTargetRotary * days;
        var grossTrendTargetRotary = grossTargetRotary * daysInMonth;

        var percentRotaryGross = ((<?php echo $mtdRotaryGross; ?>/grossMtdTargetRotary) * 100).toFixed(2) + '%';
        var percentRecoveryRotary = ((outputTargetRotary / grossTargetRotary) * 100).toFixed(2) + '%';

        $('#grossRotaryTarget').val(grossTargetRotary);
        $('#grossMtdRotaryTarget').val(grossMtdTargetRotary);
        $('#grossTrendRotaryTarget').val(grossTrendTargetRotary);
        $('#grossPercentRotaryTarget').val(percentRotaryGross);

        $('#recoveryRotaryLast').val(percentRecoveryRotary);
        $('#recoveryRotaryMtd').val(percentRecoveryRotary);
        $('#recoveryRotaryMonth').val(percentRecoveryRotary);
    });

    $('#netRotaryTargetSetting').on('input', function () {
        var netTargetRotary = $("#netRotaryTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var netMtdTargetRotary = netTargetRotary * days;
        var netTrendTargetRotary = netTargetRotary * daysInMonth;

        var percentRotaryNet = ((<?php echo $mtdRotaryNet; ?>/netMtdTargetRotary) * 100).toFixed(2) + '%';


        $('#netRotaryTarget').val(netTargetRotary);
        $('#netMtdRotaryTarget').val(netMtdTargetRotary);
        $('#netTrendRotaryTarget').val(netTrendTargetRotary);
        $('#netPercentRotaryTarget').val(percentRotaryNet);

    });

    $('#outputRotaryTargetSetting').on('input', function () {
        var grossTargetRotary = $("#grossRotaryTargetSetting").val();
        var outputTargetRotary = $("#outputRotaryTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var outputMtdTargetRotary = outputTargetRotary * days;
        var outputTrendTargetRotary = outputTargetRotary * daysInMonth;

        var percentRotaryOutput = ((<?php echo $mtdRotaryOutput; ?>/outputMtdTargetRotary) * 100).toFixed(2) + '%';
        var percentRecoveryRotary = ((outputTargetRotary / grossTargetRotary) * 100).toFixed(2) + '%';

        $('#outputRotaryTarget').val(outputTargetRotary);
        $('#outputMtdRotaryTarget').val(outputMtdTargetRotary);
        $('#outputTrendRotaryTarget').val(outputTrendTargetRotary);
        $('#outputPercentRotaryTarget').val(percentRotaryOutput);

        $('#recoveryRotaryLast').val(percentRecoveryRotary);
        $('#recoveryRotaryMtd').val(percentRecoveryRotary);
        $('#recoveryRotaryMonth').val(percentRecoveryRotary);
    });

    $('#gross100TTargetSetting').on('input', function () {
        var grossTarget100T = $("#gross100TTargetSetting").val();
        var outputTarget100T = $("#output100TTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var grossMtdTarget100T = grossTarget100T * days;
        var grossTrendTarget100T = grossTarget100T * daysInMonth;

        var percent100TGross = ((<?php echo $mtd100TGross; ?>/grossMtdTarget100T) * 100).toFixed(2) + '%';
        var percentRecovery100T = ((outputTarget100T / grossTarget100T) * 100).toFixed(2) + '%';

        $('#gross100TTarget').val(grossTarget100T);
        $('#grossMtd100TTarget').val(grossMtdTarget100T);
        $('#grossTrend100TTarget').val(grossTrendTarget100T);
        $('#grossPercent100TTarget').val(percent100TGross);

        $('#recovery100TLast').val(percentRecovery100T);
        $('#recovery100TMtd').val(percentRecovery100T);
        $('#recovery100TMonth').val(percentRecovery100T);
    });

    $('#net100TTargetSetting').on('input', function () {
        var netTarget100T = $("#net100TTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var netMtdTarget100T = netTarget100T * days;
        var netTrendTarget100T = netTarget100T * daysInMonth;

        var percent100TNet = ((<?php echo $mtd100TNet; ?>/netMtdTarget100T) * 100).toFixed(2) + '%';


        $('#net100TTarget').val(netTarget100T);
        $('#netMtd100TTarget').val(netMtdTarget100T);
        $('#netTrend100TTarget').val(netTrendTarget100T);
        $('#netPercent100TTarget').val(percent100TNet);

    });

    $('#output100TTargetSetting').on('input', function () {
        var grossTarget100T = $("#gross100TTargetSetting").val();
        var outputTarget100T = $("#output100TTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var outputMtdTarget100T = outputTarget100T * days;
        var outputTrendTarget100T = outputTarget100T * daysInMonth;

        var percent100TOutput = ((<?php echo $mtd100TOutput; ?>/outputMtdTarget100T) * 100).toFixed(2) + '%';
        var percentRecovery100T = ((outputTarget100T / grossTarget100T) * 100).toFixed(2) + '%';

        $('#output100TTarget').val(outputTarget100T);
        $('#outputMtd100TTarget').val(outputMtdTarget100T);
        $('#outputTrend100TTarget').val(outputTrendTarget100T);
        $('#outputPercent100TTarget').val(percent100TOutput);

        $('#recovery100TLast').val(percentRecovery100T);
        $('#recovery100TMtd').val(percentRecovery100T);
        $('#recovery100TMonth').val(percentRecovery100T);
    });

    $('#gross200TTargetSetting').on('input', function () {
        var grossTarget200T = $("#gross200TTargetSetting").val();
        var outputTarget200T = $("#output200TTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var grossMtdTarget200T = grossTarget200T * days;
        var grossTrendTarget200T = grossTarget200T * daysInMonth;

        var percent200TGross = ((<?php echo $mtd200TGross; ?>/grossMtdTarget200T) * 100).toFixed(2) + '%';
        var percentRecovery200T = ((outputTarget200T / grossTarget200T) * 100).toFixed(2) + '%';

        $('#gross200TTarget').val(grossTarget200T);
        $('#grossMtd200TTarget').val(grossMtdTarget200T);
        $('#grossTrend200TTarget').val(grossTrendTarget200T);
        $('#grossPercent200TTarget').val(percent200TGross);

        $('#recovery200TLast').val(percentRecovery200T);
        $('#recovery200TMtd').val(percentRecovery200T);
        $('#recovery200TMonth').val(percentRecovery200T);
    });

    $('#net200TTargetSetting').on('input', function () {
        var netTarget200T = $("#net200TTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var netMtdTarget200T = netTarget200T * days;
        var netTrendTarget200T = netTarget200T * daysInMonth;

        var percent200TNet = ((<?php echo $mtd200TNet; ?>/netMtdTarget200T) * 100).toFixed(2) + '%';


        $('#net200TTarget').val(netTarget200T);
        $('#netMtd200TTarget').val(netMtdTarget200T);
        $('#netTrend200TTarget').val(netTrendTarget200T);
        $('#netPercent200TTarget').val(percent200TNet);

    });

    $('#output200TTargetSetting').on('input', function () {
        var grossTarget200T = $("#gross200TTargetSetting").val();
        var outputTarget200T = $("#output200TTargetSetting").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var outputMtdTarget200T = outputTarget200T * days;
        var outputTrendTarget200T = outputTarget200T * daysInMonth;

        var percent200TOutput = ((<?php echo $mtd200TOutput; ?>/outputMtdTarget200T) * 100).toFixed(2) + '%';
        var percentRecovery200T = ((outputTarget200T / grossTarget200T) * 100).toFixed(2) + '%';

        $('#output200TTarget').val(outputTarget200T);
        $('#outputMtd200TTarget').val(outputMtdTarget200T);
        $('#outputTrend200TTarget').val(outputTrendTarget200T);
        $('#outputPercent200TTarget').val(percent200TOutput);

        $('#recovery200TLast').val(percentRecovery200T);
        $('#recovery200TMtd').val(percentRecovery200T);
        $('#recovery200TMonth').val(percentRecovery200T);
    });

    $('.setting').on('input', function () {

        $("#grossRotaryTarget").val($('#grossRotaryTargetSetting').val());
        $("#netRotaryTarget").val($('#netRotaryTargetSetting').val());
        $("#outputRotaryTarget").val($('#outputRotaryTargetSetting').val());

        $("#gross100TTarget").val($('#gross100TTargetSetting').val());
        $("#net100TTarget").val($('#net100TTargetSetting').val());
        $("#output100TTarget").val($('#output100TTargetSetting').val());

        $("#gross200TTarget").val($('#gross200TTargetSetting').val());
        $("#net200TTarget").val($('#net200TTargetSetting').val());
        $("#output200TTarget").val($('#output200TTargetSetting').val());

        var grossTargetRotary = $("#grossRotaryTarget").val();
        var netTargetRotary = $("#netRotaryTarget").val();
        var outputTargetRotary = $("#outputRotaryTarget").val();

        var grossTarget100T = $("#gross100TTarget").val();
        var netTarget100T = $("#net100TTarget").val();
        var outputTarget100T = $("#output100TTarget").val();

        var grossTarget200T = $("#gross200TTarget").val();
        var netTarget200T = $("#net200TTarget").val();
        var outputTarget200T = $("#output200TTarget").val();

        var grossTargetCons = parseInt(grossTargetRotary) + parseInt(grossTarget100T) + parseInt(grossTarget200T);
        var netTargetCons = parseInt(netTargetRotary) + parseInt(netTarget100T) + parseInt(netTarget200T);
        var outputTargetCons = parseInt(outputTargetRotary) + parseInt(outputTarget100T) + parseInt(outputTarget200T);

        $("#grossConsTarget").val(grossTargetCons);
        $("#netConsTarget").val(netTargetCons);
        $("#outputConsTarget").val(outputTargetCons);

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>);

        var grossMtdRotary = grossTargetRotary * days;
        var netMtdRotary = netTargetRotary * days;
        var outputMtdRotary = outputTargetRotary * days;

        var grossMtd100T = grossTarget100T * days;
        var netMtd100T = netTarget100T * days;
        var outputMtd100T = outputTarget100T * days;

        var grossMtd200T = grossTarget200T * days;
        var netMtd200T = netTarget200T * days;
        var outputMtd200T = outputTarget200T * days;

        var grossMtdCons = grossTargetCons * days;
        var netMtdCons = netTargetCons * days;
        var outputMtdCons = outputTargetCons * days;

        var grossTrendRotary = grossTargetRotary * daysInMonth;
        var netTrendRotary = netTargetRotary * daysInMonth;
        var outputTrendRotary = outputTargetRotary * daysInMonth;

        var grossTrend100T = grossTarget100T * daysInMonth;
        var netTrend100T = netTarget100T * daysInMonth;
        var outputTrend100T = outputTarget100T * daysInMonth;

        var grossTrend200T = grossTarget200T * daysInMonth;
        var netTrend200T = netTarget200T * daysInMonth;
        var outputTrend200T = outputTarget200T * daysInMonth;

        var grossTrendCons = grossTargetCons * daysInMonth;
        var netTrendCons = netTargetCons * daysInMonth;
        var outputTrendCons = outputTargetCons * daysInMonth;


        var percentRotaryGross = ((<?php echo $mtdRotaryGross; ?>/grossMtdRotary) * 100).toFixed(2) + '%';
        var percentRotaryNet = ((<?php echo $mtdRotaryNet; ?>/netMtdRotary) * 100).toFixed(2) + '%';
        var percentRotaryOutput = ((<?php echo $mtdRotaryOutput; ?>/outputMtdRotary) * 100).toFixed(2) + '%';

        var percent100TGross = ((<?php echo $mtd100TGross; ?>/grossMtd100T) * 100).toFixed(2) + '%';
        var percent100TNet = ((<?php echo $mtd100TNet; ?>/netMtd100T) * 100).toFixed(2) + '%';
        var percent100TOutput = ((<?php echo $mtd100TOutput; ?>/outputMtd100T) * 100).toFixed(2) + '%';

        var percent200TGross = ((<?php echo $mtd200TGross; ?>/grossMtd200T) * 100).toFixed(2) + '%';
        var percent200TNet = ((<?php echo $mtd200TNet; ?>/netMtd200T) * 100).toFixed(2) + '%';
        var percent200TOutput = ((<?php echo $mtd200TOutput; ?>/outputMtd200T) * 100).toFixed(2) + '%';

        var percentConsGross = ((<?php echo $mtdRotaryGross + $mtd100TGross + $mtd200TGross; ?>/grossTrendCons) * 100).toFixed(2) + '%';
        var percentConsNet = ((<?php echo $mtdRotaryNet + $mtd100TNet + $mtd200TNet; ?>/netTrendCons) * 100).toFixed(2) + '%';
        var percentConsOutput = ((<?php echo $mtdRotaryOutput + $mtd100TOutput + $mtd200TOutput; ?>/outputTrendCons) * 100).toFixed(2) + '%';

        var recoveryPercentRotary = ((outputTargetRotary / grossTargetRotary) * 100).toFixed(2) + '%';
        var recoveryPercent100T = ((outputTarget100T / grossTarget100T) * 100).toFixed(2) + '%';
        var recoveryPercent200T = ((outputTarget200T / grossTarget200T) * 100).toFixed(2) + '%';
        var recoveryPercentCons = ((outputTargetCons / grossTargetCons) * 100).toFixed(2) + '%';

        var targetRotaryGrossTPH = (grossMtdRotary /<?php echo($mtdRotaryUptime) ?>).toFixed(2);
        var targetRotaryNetTPH = (netMtdRotary /<?php echo($mtdRotaryUptime) ?>).toFixed(2);
        var targetRotaryOutputTPH = (outputMtdRotary /<?php echo($mtdRotaryUptime) ?>).toFixed(2);

        var target100TGrossTPH = (grossMtd100T /<?php echo($mtd100TUptime) ?>).toFixed(2);
        var target100TNetTPH = (netMtd100T /<?php echo($mtd100TUptime) ?>).toFixed(2);
        var target100TOutputTPH = (outputMtd100T /<?php echo($mtd100TUptime) ?>).toFixed(2);

        var target200TGrossTPH = (grossMtd200T /<?php echo($mtd200TUptime) ?>).toFixed(2);
        var target200TNetTPH = (netMtd200T /<?php echo($mtd200TUptime) ?>).toFixed(2);
        var target200TOutputTPH = (outputMtd200T /<?php echo($mtd200TUptime) ?>).toFixed(2);

        var targetConsGrossTPH = (parseInt(targetRotaryGrossTPH) + parseInt(target100TGrossTPH) + parseInt(target200TGrossTPH)).toFixed(2);
        var targetConsNetTPH = (parseInt(targetRotaryNetTPH) + parseInt(target100TNetTPH) + parseInt(target200TNetTPH)).toFixed(2);
        var targetConsOutputTPH = (parseInt(targetRotaryOutputTPH) + parseInt(target100TOutputTPH) + parseInt(target200TOutputTPH)).toFixed(2);

        var targetRotaryGrossTPHPercent = (((<?php echo $mtdRotaryGrossTPH ?> -targetRotaryGrossTPH) / targetRotaryGrossTPH) * 100).toFixed(2) + '%';
        var targetRotaryNetTPHPercent = (((<?php echo $mtdRotaryNetTPH ?> -targetRotaryNetTPH) / targetRotaryNetTPH) * 100).toFixed(2) + '%';
        var targetRotaryOutputTPHPercent = (((<?php echo $mtdRotaryOutputTPH ?> -targetRotaryOutputTPH) / targetRotaryOutputTPH) * 100).toFixed(2) + '%';

        var target100TGrossTPHPercent = (((<?php echo $mtd100TGrossTPH ?> -target100TGrossTPH) / target100TGrossTPH) * 100).toFixed(2) + '%';
        var target100TNetTPHPercent = (((<?php echo $mtd100TNetTPH ?> -target100TNetTPH) / target100TNetTPH) * 100).toFixed(2) + '%';
        var target100TOutputTPHPercent = (((<?php echo $mtd100TOutputTPH ?> -target100TOutputTPH) / target100TOutputTPH) * 100).toFixed(2) + '%';

        var target200TGrossTPHPercent = (((<?php echo $mtd200TGrossTPH ?> -target200TGrossTPH) / target200TGrossTPH) * 100).toFixed(2) + '%';
        var target200TNetTPHPercent = (((<?php echo $mtd200TNetTPH ?> -target200TNetTPH) / target200TNetTPH) * 100).toFixed(2) + '%';
        var target200TOutputTPHPercent = (((<?php echo $mtd200TOutputTPH ?> -target200TOutputTPH) / target200TOutputTPH) * 100).toFixed(2) + '%';

        var targetConsGrossTPHPercent = (((<?php echo $mtdConsGrossTPH ?> -targetConsGrossTPH) / targetConsGrossTPH) * 100).toFixed(2) + '%';
        var targetConsNetTPHPercent = (((<?php echo $mtdConsNetTPH ?> -targetConsNetTPH) / targetConsNetTPH) * 100).toFixed(2) + '%';
        var targetConsOutputTPHPercent = (((<?php echo $mtdConsOutputTPH ?> -targetConsOutputTPH) / targetConsOutputTPH) * 100).toFixed(2) + '%';


        $("#grossMtdRotaryTarget").val(grossMtdRotary);
        $('#grossTrendRotaryTarget').val(grossTrendRotary);
        $('#grossPercentRotaryTarget').val(percentRotaryGross);

        $("#netMtdRotaryTarget").val(netMtdRotary);
        $('#netTrendRotaryTarget').val(netTrendRotary);
        $('#netPercentRotaryTarget').val(percentRotaryNet);

        $("#outputMtdRotaryTarget").val(outputMtdRotary);
        $('#outputTrendRotaryTarget').val(outputTrendRotary);
        $('#outputPercentRotaryTarget').val(percentRotaryOutput);

        $("#grossMtd100TTarget").val(grossMtd100T);
        $('#grossTrend100TTarget').val(grossTrend100T);
        $('#grossPercent100TTarget').val(percent100TGross);

        $("#netMtd100TTarget").val(netMtd100T);
        $('#netTrend100TTarget').val(netTrend100T);
        $('#netPercent100TTarget').val(percent100TNet);

        $("#outputMtd100TTarget").val(outputMtd100T);
        $('#outputTrend100TTarget').val(outputTrend100T);
        $('#outputPercent100TTarget').val(percent100TOutput);

        $("#grossMtd200TTarget").val(grossMtd200T);
        $('#grossTrend200TTarget').val(grossTrend200T);
        $('#grossPercent200TTarget').val(percent200TGross);

        $("#netMtd200TTarget").val(netMtd200T);
        $('#netTrend200TTarget').val(netTrend200T);
        $('#netPercent200TTarget').val(percent200TNet);

        $("#outputMtd200TTarget").val(outputMtd200T);
        $('#outputTrend200TTarget').val(outputTrend200T);
        $('#outputPercent200TTarget').val(percent200TOutput);

        $("#grossMtdConsTarget").val(grossMtdCons);
        $('#grossTrendConsTarget').val(grossTrendCons);
        $('#grossPercentConsTarget').val(percentConsGross);

        $("#netMtdConsTarget").val(netMtdCons);
        $('#netTrendConsTarget').val(netTrendCons);
        $('#netPercentConsTarget').val(percentConsNet);

        $("#outputMtdConsTarget").val(outputMtdCons);
        $('#outputTrendConsTarget').val(outputTrendCons);
        $('#outputPercentConsTarget').val(percentConsOutput);

        $("#recoveryRotaryLast").val(recoveryPercentRotary);
        $("#recoveryRotaryMtd").val(recoveryPercentRotary);
        $("#recoveryRotaryMonth").val(recoveryPercentRotary);

        $("#recovery100TLast").val(recoveryPercent100T);
        $("#recovery100TMtd").val(recoveryPercent100T);
        $("#recovery100TMonth").val(recoveryPercent100T);

        $("#recovery200TLast").val(recoveryPercent200T);
        $("#recovery200TMtd").val(recoveryPercent200T);
        $("#recovery200TMonth").val(recoveryPercent200T);

        $("#recoveryConsLast").val(recoveryPercentCons);
        $("#recoveryConsMtd").val(recoveryPercentCons);
        $("#recoveryConsMonth").val(recoveryPercentCons);

        $('#grossRotaryTph').val(targetRotaryGrossTPH);
        $('#netRotaryTph').val(targetRotaryNetTPH);
        $('#outputRotaryTph').val(targetRotaryOutputTPH);

        $('#gross100TTph').val(target100TGrossTPH);
        $('#net100TTph').val(target100TNetTPH);
        $('#output100TTph').val(target100TOutputTPH);

        $('#gross200TTph').val(target200TGrossTPH);
        $('#net200TTph').val(target200TNetTPH);
        $('#output200TTph').val(target200TOutputTPH);

        $('#grossConsTph').val(targetConsGrossTPH);
        $('#netConsTph').val(targetConsNetTPH);
        $('#outputConsTph').val(targetConsOutputTPH);

        $('#grossRotaryTphPercent').val(targetRotaryGrossTPHPercent);
        $('#netRotaryTphPercent').val(targetRotaryNetTPHPercent);
        $('#outputRotaryTphPercent').val(targetRotaryOutputTPHPercent);

        $('#gross100TTphPercent').val(target100TGrossTPHPercent);
        $('#net100TTphPercent').val(target100TNetTPHPercent);
        $('#output100TTphPercent').val(target100TOutputTPHPercent);

        $('#gross200TTphPercent').val(target200TGrossTPHPercent);
        $('#net200TTphPercent').val(target200TNetTPHPercent);
        $('#output200TTphPercent').val(target200TOutputTPHPercent);

        $('#grossConsTphPercent').val(targetConsGrossTPHPercent);
        $('#netConsTphPercent').val(targetConsNetTPHPercent);
        $('#outputConsTphPercent').val(targetConsOutputTPHPercent);
    });


    $('#cons-header').on('click', function () {
        $('#arrow-up').toggleClass('display-inline-block ');
        $('#arrow-down').toggle();
        $('#cons-data').slideToggle();
        $('html, body').animate( 'slow');

    });

    $('#rotary-header').on('click', function () {
        $('#arrow-up-rot').toggleClass('display-inline-block ');
        $('#arrow-down-rot').toggle();
        $('#rotary-data').slideToggle();
        $('html, body').animate( 'slow');

    });

    $('#rotary-header-table').on('click', function () {
        $('#arrow-up-rot-tbl').toggleClass('display-inline-block ');
        $('#arrow-down-rot-tbl').toggle();
        $('#rotary-table').slideToggle();
        $('html, body').animate( 'slow');

    });

    $('#carrier100-header').on('click', function () {
        $('#arrow-up-100t').toggleClass('display-inline-block ');
        $('#arrow-down-100t').toggle();
        $('#carrier100-data').slideToggle();
        $('html, body').animate( 'slow');
    });

    $('#carrier100-header-table').on('click', function () {
        $('#arrow-up-100t-tbl').toggleClass('display-inline-block ');
        $('#arrow-down-100t-tbl').toggle();
        $('#carrier100-table').slideToggle();
        $('html, body').animate( 'slow');

    });

    $('#carrier200-header').on('click', function () {
        $('#arrow-up-200t').toggleClass('display-inline-block ');
        $('#arrow-down-200t').toggle();
        $('#carrier200-data').slideToggle();
        $('html, body').animate( 'slow');

    });

    $('#carrier200-header-table').on('click', function () {
        $('#arrow-up-200t-tbl').toggleClass('display-inline-block ');
        $('#arrow-down-200t-tbl').toggle();
        $('#carrier200-table').slideToggle();
        $('html, body').animate( 'slow');

    });

    $('#time-header').on('click', function () {
        $('#arrow-up-time').toggleClass('display-inline-block ');
        $('#arrow-down-time').toggle();
        $('#time-data').slideToggle();
        $('html, body').animate( 'slow');

    });

    var consTable = $('#consolidatedTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    consTable.buttons().containers().appendTo('#consolidated-table-card-footer');

    var targetConsTable = $('#targetConsTable').DataTable({
            dom: 'rtB',
            ordering: false,
            buttons:
                [
                    {extend: 'copy'}, {extend:'excel'}
                ]
        });
    targetConsTable.buttons().containers().appendTo('#cons-footer');

    var tphConsTable = $('#tphConsTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    tphConsTable.buttons().containers().appendTo('#tph-cons-table-card-footer');

    var rotaryTable = $('#rotaryTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    rotaryTable.buttons().containers().appendTo('#rotary-table-card-footer');

    var tphRotaryTable = $('#tphRotaryTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    tphRotaryTable.buttons().containers().appendTo('#tph-rotary-table-card-footer');

    var targetRotaryTable = $('#targetRotaryTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    targetRotaryTable.buttons().containers().appendTo('#target-rotary-table-card-footer');


    var carrier100tTable = $('#carrier100tTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    carrier100tTable.buttons().containers().appendTo('#carrier-100t-table-card-footer');

    var target100TTable = $('#target100TTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    target100TTable.buttons().containers().appendTo('#target-100T-table-card-footer');

    var tph100TTable = $('#tph100TTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    tph100TTable.buttons().containers().appendTo('#tph-100T-table-card-footer');

    var carrier200tTable = $('#carrier200tTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    carrier200tTable.buttons().containers().appendTo('#carrier-200t-table-card-footer');

    var target200TTable = $('#target200TTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    target200TTable.buttons().containers().appendTo('#target-200T-table-card-footer');

    var tph200TTable = $('#tph200TTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    tph200TTable.buttons().containers().appendTo('#tph-200T-table-card-footer');

    var timeHoursTable = $('#timeHoursTable').DataTable({
        dom: 'rtB',
        ordering: false,
        buttons:
            [
                {extend: 'copy'}, {extend:'excel'}
            ]
    });
    timeHoursTable.buttons().containers().appendTo('#time-hours-table-card-footer');

    function saveSetting() {
        var grossRotarySetting = $("#grossRotaryTargetSetting").val();
        var netRotarySetting = $("#netRotaryTargetSetting").val();
        var outputRotarySetting = $("#outputRotaryTargetSetting").val();

        var gross100TSetting = $("#gross100TTargetSetting").val();
        var net100TSetting = $("#net100TTargetSetting").val();
        var output100TSetting = $("#output100TTargetSetting").val();

        var gross200TSetting = $("#gross200TTargetSetting").val();
        var net200TSetting = $("#net200TTargetSetting").val();
        var output200TSetting = $("#output200TTargetSetting").val();

        var firstDayOfMonth = "<?php echo($firstDayOfMonth)?>";
        var site = "gb";

        if (grossRotarySetting == 0 || grossRotarySetting == "") {
            $('#failuremsg').html("Target for Rotary Gross cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (netRotarySetting == 0 || netRotarySetting == "") {
            $('#failuremsg').html("Target for Rotary Net cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (outputRotarySetting == 0 || outputRotarySetting == "") {
            $('#failuremsg').html("Target for Rotary Output cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (gross100TSetting == 0 || gross100TSetting == "") {
            $('#failuremsg').html("Target for 100T Gross cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (net100TSetting == 0 || net100TSetting == "") {
            $('#failuremsg').html("Target for 100T Net cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (output100TSetting == 0 || output100TSetting == "") {
            $('#failuremsg').html("Target for 100T Output cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (gross200TSetting == 0 || gross200TSetting == "") {
            $('#failuremsg').html("Target for 200T Gross cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (net200TSetting == 0 || net200TSetting == "") {
            $('#failuremsg').html("Target for 200T Net cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }

        if (output200TSetting == 0 || output200TSetting == "") {
            $('#failuremsg').html("Target for 200T Output cannot be 0 or blank").fadeIn('slow') //also show a success message
            $('#failuremsg').delay(5000).fadeOut('slow');
            return;
        }
        //alert( firstDayOfMonth

        $.ajax
        ({
            url: '../../Includes/Production/scorecardsettinginsert.php',
            type: 'POST',
            data:
                {
                    start_date: firstDayOfMonth,
                    rotary_gross_setting: grossRotarySetting,
                    rotary_net_setting: netRotarySetting,
                    rotary_output_setting: outputRotarySetting,
                    carrier100_gross_setting: gross100TSetting,
                    carrier100_net_setting: net100TSetting,
                    carrier100_output_setting: output100TSetting,
                    carrier200_gross_setting: gross200TSetting,
                    carrier200_net_setting: net200TSetting,
                    carrier200_output_setting: output200TSetting,
                    site: site
                },
            success: function (response) {
                // $('#msg').html(data).fadeIn('slow');
                $('#msg').html("Saved settings successfully").fadeIn('slow') //also show a success message
                $('#msg').delay(5000).fadeOut('slow');
                console.log(response)
            }
        });
    };
</script>
<!-- HTML -->