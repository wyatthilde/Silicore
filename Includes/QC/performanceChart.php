<?php
/* * *****************************************************************************************************************************************
 * File Name: performanceChart.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/19/2018|ktaylor|KACE:xxxxx - Initial creation
 * 
 * **************************************************************************************************************************************** */
error_reporting(0);

if (isset($_POST['performanceChart']) && isset($_POST['plant'])) {
        
    $plant=($_POST['plant']);

    $techName=($_POST['techName']);
 
    $testCount=($_POST['testCount']);
 
    $aveDuration=($_POST['aveDuration']);
 
    $retestCount=($_POST['retestCount']);
 
    $miscCount=($_POST['miscCount']);
 
    $calibrationCount=($_POST['calibrationCount']);
    
    $repeatabilityCount=($_POST['repeatabilityCount']);
    
    $resampleCount=($_POST['resampleCount']);
 }
 

$jsonArray =
 array (
 0 =>
 array (
   'label' => '[' . $techName. '], ' .'Tests',
   'value' => $testCount,
 ),
 1 =>
 array (
   'label' => 'Avg Hrs (Tests)',
   'value' => $aveDuration,
 ),
 2 =>
 array (
   'label' => 'Retests',
   'value' => $retestCount,
 ),
 3 =>
 array (
   'label' => 'Misc Tests',
   'value' => $miscCount,
 ),
 4 =>
 array (
   'label' => 'Calibration Tests',
   'value' => $calibrationCount,
 ),
 5 =>
 array (
   'label' => 'Repeatability Tests',
   'value' => $repeatabilityCount,
 ),
 6 =>
 array (
   'label' => 'Resample Tests',
   'value' => $resampleCount,
 ),

);

$jsonEncodeData = json_encode($jsonArray);
$filename = '../../Includes/QC/performanceChartData.json';
$handle = fopen($filename, 'w');
fwrite($handle, $jsonEncodeData);
fclose($handle);


 
 header("Location: ../../Controls/QC/gb_performance.php");

 
 ?>