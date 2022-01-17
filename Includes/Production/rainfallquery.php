<?php
/* * *****************************************************************************************************************************************
 * File Name: rainfallquery.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/24/2018|__USER__|KACE:xxxxx - Initial creation
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
$rowDate = filter_input(INPUT_POST, 'row_date');
$seconds = abs(strtotime($endDate) - (strtotime($startDate)));
$days = floor($seconds / 86400) + 1;

$rainfallArry = RainfallArryGet($startDate, $days);
$rainfallTotal= array_sum($rainfallArry);


$rainfallJsonArry = ['rainfall' => $rainfallTotal, 'row_date' => $rowDate];
$rainJSON = json_encode($rainfallJsonArry);
echo($rainJSON);

function RainfallArryGet($startDate, $days)
        
  {
  for ($i = 0; $i < $days; $i++)
    {
    $date = date('Y-m-d ', strtotime($startDate . "+" . $i . "day"));
    $rainSumSql = "CALL sp_gb_plc_RainfallDayGet('" . $date . "')";
    //echo $rainSumSql;
    $rainfallResults = mysqli_query(dbmysqli(), $rainSumSql);
    while ($rainfallResult = $rainfallResults->fetch_assoc())
      {
      if ($rainfallResult['rainfall'] == '' || $rainfallResult['rainfall'] == null)
        {
        $rainArry[] = 0;
        } else
        {
        $rainArry[] = $rainfallResult['rainfall'];
        }
//              echo("Weight{$i}: " . $rainArry[$i] . "<br>");
      }
    }
  return $rainArry;
  }

//========================================================================================== END PHP
?>

