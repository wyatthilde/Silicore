<?php
/* * *****************************************************************************************************************************************
 * File Name: tceqquery.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/20/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
//error_reporting(0);
//$startDate ='2018-05-01';
//$endDate = '2018-05-31';

$startDate = filter_input(INPUT_POST, 'start_date');
$endDate = filter_input(INPUT_POST, 'end_date');

$seconds = abs(strtotime($endDate) - (strtotime($startDate)));
$days = floor($seconds / 86400) + 1;

$conveyorId = filter_input(INPUT_POST, 'conveyor_id');
$locationId = filter_input(INPUT_POST, 'location_id');
$plantId = filter_input(INPUT_POST, 'plant_id');
$jsonRowName = filter_input(INPUT_POST, 'json_row');
$rowDate = filter_input(INPUT_POST, 'row_date');


//echo 
//"<br>" . $startDate .
//        "<br>" . $endDate .
//        "<br>" . $conveyorId .
//        "<br>" . $locationId .
//$conveyorId = 8;
//$locationId = 50;



$tonsArry = PlantMonthSums($conveyorId, $startDate, $days);

$moistureArry = PlantMonthMoisture($locationId, $startDate, $days);
$downtimeArry = PlantDownTimes($plantId, $startDate, $days);
$schDowntimeArry = PlantSchDownTimes($plantId, $startDate, $days);
$idletimeArry = PlantIdleTimes($plantId, $startDate, $days);
$uptimeArry = PlantUpTimes($plantId, $startDate, $downtimeArry, $schDowntimeArry, $idletimeArry, $days);

$tonsSum = array_sum($tonsArry);
$uptimeSum = array_sum($uptimeArry);
$weightedMoisture = sprintf("%.2f%%", (WeightedAvgSample($moistureArry, $tonsArry) * 100) );
$drytons = round($tonsSum * WeightedAvgSample($moistureArry, $tonsArry),2);
//print_r($downtimeArry);
//Tonnage

$tonsPerHour = round($tonsSum / $uptimeSum,2);



$tceqArry = ['tons' => array_sum($tonsArry), 'moisture_rate' => $weightedMoisture, 'tph' => $tonsPerHour, 'uptime_hours' => $uptimeSum, 'row_date' => $rowDate];
$tceqJSON = json_encode($tceqArry);
echo($tceqJSON);

function WeightedAvgSample($sampleArry, $tonsArray)
{
  if(array_sum($tonsArray) != 0)
    for ($i = 0; $i < count($tonsArray); $i++) {
        $weightedSample[] = ($tonsArray[$i] / array_sum($tonsArray)) * $sampleArry[$i];
    }
    else
      {
        $weightedSample[]=0;
      }
      
    return array_sum($weightedSample);
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

function ReplaceZeroWithAverage($arry)
  {
//  print_r($arry);
    $zeroCount = 0;
    $count = count($arry);
    //gets number of array items that are less than or equal to zero
    for ($i = 0; $i < $count; $i++)
    {
      if($arry[$i] == 0)
        {
          $zeroCount += 1;
        }
    }
    
    $nonZeroCount = $count - $zeroCount;  
//    echo '<br>' .$zeroCount;
    
    if($nonZeroCount != 0)
      {
      $arryAvg = array_sum($arry) / $nonZeroCount;
       //replaces all zeros with average
       for ($i = 0; $i < $count; $i++)
        {
        if ($arry[$i] <= 0) 
          {            
            $arry[$i] =$arryAvg;
          }
      
    }
    
      }
      return $arry;
  }
  
function PercentToDecimal($pct)
  {
    $dec = str_replace('%', '', $pct) / 100;
    return $dec;
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
//        echo $plantTimeSql;
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
  
//========================================================================================== END PHP
?>
