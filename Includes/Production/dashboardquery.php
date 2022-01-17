<?php
/* * *****************************************************************************************************************************************
 * File Name: dashboardquery.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/11/2018|__USER__|KACE:xxxxx - Initial creation
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
$jsonRowName = filter_input(INPUT_POST, 'json_row');
$targetTonsSetting = filter_input(INPUT_POST, 'tons_setting') * $days;
//$targetMoistureSetting = filter_input(INPUT_POST, 'moisture_setting');

$targetPlus70Setting = PercentToDecimal(filter_input(INPUT_POST, 'pls70_setting'));
$targetMinus70Setting = PercentToDecimal(filter_input(INPUT_POST, 'mns70_setting'));

$targetMinus140Setting = PercentToDecimal(filter_input(INPUT_POST, 'mns140_setting'));
$targetPlus140Setting = PercentToDecimal(filter_input(INPUT_POST, 'pls140_setting'));

$targetMinus70Plus140Setting = PercentToDecimal(filter_input(INPUT_POST, 'mns70pls140_setting'));
$targetMinus40Plus70Setting = PercentToDecimal(filter_input(INPUT_POST, 'mns40pls70_setting'));
//rotary feed for testing

//echo 
//"<br>" . $startDate .
//        "<br>" . $endDate .
//        "<br>" . $conveyorId .
//        "<br>" . $locationId .
//        "<br>" . $targetTonsSetting .
//        "<br>" . $targetPlus70Setting .
//        "<br>" . $targetMinus70Setting .
//        "<br>" . $targetMinus140Setting .
//        "<br>" . $targetPlus140Setting .
//        "<br>" . $targetMinus70Plus140Setting .
//        "<br>" . $targetMinus40Plus70Setting;

//$conveyorId = 8;
//$locationId = 50;
//$targetTonsSetting =3400 * $days;
//$targetMoistureSetting = PercentToDecimal('5.2%');
//
//$targetPlus70Setting = PercentToDecimal('18%');
//$targetMinus70Setting = PercentToDecimal('80%');
//
//$targetMinus140Setting = PercentToDecimal('10%');
//$targetPlus140Setting = PercentToDecimal('1%');
//
//$targetMinus70Plus140Setting = PercentToDecimal('70%');
//$targetMinus40Plus70Setting = PercentToDecimal('20%');

$tonsArry = PlantMonthSums($conveyorId, $startDate, $days);
$moistureArry = PlantMonthMoisture($locationId, $startDate, $days);
$sampleArray = PlantMonthSample($locationId, $startDate, $days);

$plus70Arr=$sampleArray['pls70'];
$plus140Arr=$sampleArray['pls140'];
$minus70Arr=$sampleArray['mns70'];
$minus140Arr=$sampleArray['mns140'];
$minus40Plus70Arr=$sampleArray['mns40pls70'];
$minus70Plus140Arr=$sampleArray['mns70pls140'];

$tonsSum = array_sum($tonsArry);
$weightedMoisture = sprintf("%.2f%%", (WeightedAvgSample($moistureArry, $tonsArry) * 100) );
$weightedPlus70 = WeightedAvgSample($plus70Arr, $tonsArry);
$weightedPlus140 = WeightedAvgSample($plus140Arr, $tonsArry);
$weightedMinus70 = WeightedAvgSample($minus70Arr, $tonsArry);
$weightedMinus140 = WeightedAvgSample($minus140Arr, $tonsArry);
$weightedMinus70Plus140 = WeightedAvgSample($minus70Plus140Arr, $tonsArry);
$weightedMinus40Plus70 = WeightedAvgSample($minus40Plus70Arr, $tonsArry);



 //sprintf("%.2f%%", (end($gbRotaryMoistureArry)) * 100);

//print_r($minus140Arr);
//Tonnage
$tonsPercentOfTarget = sprintf("%.2f%%", ($tonsSum /$targetTonsSetting) *100) ;
$tonsDifference = $targetTonsSetting - $tonsSum;
$tonsPerHour = round($tonsSum / $days / 24,2);
$targetTonsPerHour = round($targetTonsSetting / $days / 24,2);
$tonsPerHourDiff = $tonsPerHour - $targetTonsPerHour;

$weightedPlus70Percent =  sprintf("%.2f%%",$weightedPlus70 * 100);
$targetPlus70SettingPercent = sprintf("%.2f%%",$targetPlus70Setting * 100);

$weightedMinus70Percent =  sprintf("%.2f%%",$weightedMinus70 * 100);
$targetMinus70SettingPercent = sprintf("%.2f%%",$targetMinus70Setting * 100);

$weightedPlus140Percent =  sprintf("%.2f%%",$weightedPlus140 * 100);
$targetPlus140SettingPercent = sprintf("%.2f%%",$targetPlus140Setting * 100);

$weightedMinus140Percent =  sprintf("%.2f%%",$weightedMinus140 * 100);
$targetMinus140SettingPercent = sprintf("%.2f%%",$targetMinus140Setting * 100);

$weightedMinus70Plus140Percent =  sprintf("%.2f%%",$weightedMinus70Plus140 * 100);
$targetMinus70Plus140SettingPercent = sprintf("%.2f%%",$targetMinus70Plus140Setting * 100);

$weightedMinus40Plus70Percent =  sprintf("%.2f%%",$weightedMinus40Plus70 * 100);
$targetMinus40Plus70SettingPercent = sprintf("%.2f%%",$targetMinus40Plus70Setting * 100);

//echo $weightedPlus70;
$diffPlus70 =sprintf("%.2f%%", abs((($weightedPlus70 - $targetPlus70Setting) / $targetPlus70Setting)*100));
$diffMinus70 = sprintf("%.2f%%", abs((($weightedMinus70 - $targetMinus70Setting) / $targetMinus70Setting)*100));

$diffPlus140 = sprintf("%.2f%%", abs((($weightedPlus140 - $targetPlus140Setting) / $targetPlus140Setting)*100));
$diffMinus140 = sprintf("%.2f%%", abs((($weightedMinus140 - $targetMinus140Setting) / $targetMinus140Setting)*100));

$diffMinus70Plus140 = sprintf("%.2f%%", abs((($weightedMinus70Plus140 - $targetMinus70Plus140Setting) / $targetMinus70Plus140Setting)*100));
$diffMinus40Plus70 = sprintf("%.2f%%", abs((($weightedMinus40Plus70 - $targetMinus40Plus70Setting) / $targetMinus40Plus70Setting)*100));

//echo $weightedPlus70 . " : " . $targetPlus70Setting . " : " . $diffPlus70 . "<br>";
//echo $tonsPercentOfTarget;

$dashboardArry = 
        [
          'tons' => array_sum($tonsArry), 'moisture_rate' => $weightedMoisture, 'trgt_tons' => $targetTonsSetting,
          'percent_trgt_tons' => $tonsPercentOfTarget, 'tons_diff' => $tonsDifference, 
          'tph' => $tonsPerHour, 'trgt_tph' => $targetTonsPerHour, 'tph_diff' => $tonsPerHourDiff,
          "pls70" => $weightedPlus70Percent, 'pls70_trgt' => $targetPlus70SettingPercent, 'pls70_diff' => $diffPlus70,
          "mns70" => $weightedMinus70Percent, 'mns70_trgt' => $targetMinus70SettingPercent, 'mns70_diff' => $diffMinus70,
          "pls140" => $weightedPlus140Percent, 'pls140_trgt' => $targetPlus140SettingPercent, 'pls140_diff' => $diffPlus140,
          "mns140" => $weightedMinus140Percent, 'mns140_trgt' => $targetMinus140SettingPercent, 'mns140_diff' => $diffMinus140,
          "mns70pls140" => $weightedMinus70Plus140Percent, 'mns70pls140_trgt' => $targetMinus70Plus140SettingPercent, 'mns70pls140_diff' => $diffMinus70Plus140,
          "mns40pls70" => $weightedMinus40Plus70Percent, 'mns40pls70_trgt' => $targetMinus40Plus70SettingPercent, 'mns40pls70_diff' => $diffMinus40Plus70, 
          "row_name" => $jsonRowName,'days' => $days,
        ];
$dashboardJSON = json_encode($dashboardArry);
echo($dashboardJSON);

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
function PlantMonthSample($locationId, $startDate, $count)
{

    for ($i = 0; $i < $count; $i++) {

        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));

        $plantSampleSql = "CALL sp_gb_plc_SampleDayAvgGet(" . $locationId . ",'" . $date . "')";
//         echo "<br>" .$plantSampleSql . "<br>";
        $sampleResults = mysqli_query(dbmysqli(), $plantSampleSql);
        while ($sampleResult = $sampleResults->fetch_assoc()) 
          {
            
            If ($sampleResult['AVG(s.plus_70)'] != "" && $sampleResult['AVG(s.plus_70)'] != null ) 
              {
                $plus70Arr[] = $sampleResult['AVG(s.plus_70)'];
              }
            else
              {
                $plus70Arr[] = 0;
              }
              
            If ($sampleResult['AVG(s.plus_140)'] != "" && $sampleResult['AVG(s.plus_140)'] != null ) 
              {
                $plus140Arr[] = $sampleResult['AVG(s.plus_140)'];
              }
            else
              {
                $plus140Arr[] = 0;
              }
            
              If ($sampleResult['AVG(s.minus_70)'] != "" && $sampleResult['AVG(s.minus_70)'] != null ) 
              {
                $minus70Arr[] = $sampleResult['AVG(s.minus_70)'];
              }
            else
              {
                $minus70Arr[] = 0;
              }
              
            If ($sampleResult['AVG(s.minus_140)'] != "" && $sampleResult['AVG(s.minus_140)'] != null ) 
              {
                $minus140Arr[] = $sampleResult['AVG(s.minus_140)'];
              }
            else
              {
                $minus140Arr[] = 0;
              }
              
            If ($sampleResult['AVG(s.minus_40_plus_70)'] != "" && $sampleResult['AVG(s.minus_40_plus_70)'] != null ) 
              {
                $minus40Plus70Arr[] = $sampleResult['AVG(s.minus_40_plus_70)'];
              }
            else
              {
                $minus40Plus70Arr[] = 0;
              }
              
            If ($sampleResult['AVG(s.minus_70_plus_140)'] != "" && $sampleResult['AVG(s.minus_70_plus_140)'] != null ) 
              {
                $minus70Plus140Arr[] = $sampleResult['AVG(s.minus_70_plus_140)'];
              }
            else
              {
                $minus70Plus140Arr[] = 0;
              }
        }

    }
    
    $plus70Arr = ReplaceZeroWithAverage($plus70Arr);
    $plus140Arr = ReplaceZeroWithAverage($plus140Arr);
    $minus70Arr = ReplaceZeroWithAverage($minus70Arr);
    $minus140Arr = ReplaceZeroWithAverage($minus140Arr);
    $minus40Plus70Arr = ReplaceZeroWithAverage($minus40Plus70Arr);
    $minus70Plus140Arr = ReplaceZeroWithAverage($minus70Plus140Arr);
    
    $daySampleArry = 
            [
              'pls70' => $plus70Arr,
              'pls140' => $plus140Arr,
              'mns70' => $minus70Arr,
              'mns140' => $minus140Arr, 
              'mns40pls70' => $minus40Plus70Arr,
              'mns70pls140' => $minus70Plus140Arr
            ];
    
    return $daySampleArry;
}
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
//========================================================================================== END PHP
?>
