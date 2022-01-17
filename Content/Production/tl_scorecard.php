<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_scorecard.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/31/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
  require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');

$userId = $_SESSION['user_id'];

$yesterday = date("Y-m-d", strtotime("-10 days"));
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

//get user settings 

$grossSetting = "";
$netSetting = "";
$outputSetting = "";

try {
    $settingsSQL = "CALL sp_tl_plc_ScorecardSettingsGet(" . $userId . ",'" . $firstDayOfMonth . "')";
    $settingsResults = mysqli_query(dbmysqli(), $settingsSQL);

    while ($settingsResult = mysqli_fetch_assoc($settingsResults)) {
        $grossSetting = $settingsResult['gross_setting'];
        $netSetting = $settingsResult['net_setting'];
        $outputSetting = $settingsResult['output_setting'];
    }
} catch (Exception $e) {
    echo("Error: " . __LINE__ . " " . $e);
}

//echo  $firstDayOfMonth . " " .$yesterday . " " . $days;

$tlRotaryFeedBeltId = 2;
$tlRotaryOutputBeltId = 5;
$tlRotaryBeltLocation = 13;

$feedSumArry = PlantMonthSums($tlRotaryFeedBeltId, $firstDayOfMonth, $days);
$outputSumArry = PlantMonthSums($tlRotaryOutputBeltId, $firstDayOfMonth, $days);

$moistureArry = PlantMonthMoisture($tlRotaryBeltLocation, $firstDayOfMonth, $days);
$weightedMoistureAvg = WeightedAvgMoisture($moistureArry, $feedSumArry);

$netWeightArry = NetTons($moistureArry, $feedSumArry);

$mtdSumGross = array_sum($feedSumArry);
$mtdSumNet = round(array_sum($netWeightArry), 0);
$mtdSumOutput = array_sum($outputSumArry);

$yesterdayGrossSum = end($feedSumArry);
$yesterdayNetSum = round(end($netWeightArry), 0);
$yesterdayOutputSum = end($outputSumArry);


$trendingTonsGross = round($mtdSumGross / $days * $numOfDaysMonth, 0);
$trendingTonsNet = round($mtdSumNet / $days * $numOfDaysMonth, 0);
$trendingTonsOutput = round($mtdSumOutput / $days * $numOfDaysMonth, 0);

if ($yesterdayNetSum != 0) {
    $yesterdayRecovery = sprintf("%.2f%%", ($yesterdayOutputSum / $yesterdayNetSum) * 100);
} else {
    $yesterdayRecovery = sprintf("%.2f%%", ($yesterdayOutputSum * ($mtdSumNet / $mtdSumGross)) * 100);
}

$mtdRecovery = sprintf("%.2f%%", ($mtdSumNet / $mtdSumGross) * 100);

$yesterdayMoisture = sprintf("%.2f%%", (end($moistureArry)) * 100);
$mtdMoisture = sprintf("%.2f%%", ($weightedMoistureAvg) * 100);


$dtArry = PlantDownTimes(2, $firstDayOfMonth, $days);
$itArry = PlantIdleTimes(2, $firstDayOfMonth, $days);
$uptimeArry = PlantUpTimes(2, $firstDayOfMonth, $dtArry, $itArry, $days);


$yesterdayUpTime = end($uptimeArry);
$yesterdayDownTime = end($dtArry);
$yesterdayIdleTime = end($itArry);

$mtdUpTime = array_sum($uptimeArry);
$mtdDownTime = array_sum($dtArry);
$mtdIdleTime = array_sum($itArry);

if ($yesterdayUpTime + $yesterdayDownTime + $yesterdayIdleTime != 0) {
    $upTimePercent = sprintf("%.2f%%", ($yesterdayUpTime / ($yesterdayUpTime + $yesterdayDownTime + $yesterdayIdleTime)) * 100);
    $downTimePercent = sprintf("%.2f%%", ($yesterdayDownTime / ($yesterdayUpTime + $yesterdayDownTime + $yesterdayIdleTime)) * 100);
    $idleTimePercent = sprintf("%.2f%%", ($yesterdayIdleTime / ($yesterdayUpTime + $yesterdayDownTime + $yesterdayIdleTime)) * 100);

    $delayTimePercent = sprintf("%.2f%%", ($yesterdayIdleTime + $yesterdayDownTime) / ($yesterdayUpTime + $yesterdayDownTime + $yesterdayIdleTime) * 100);
} else {
    $upTimePercent = sprintf("%.2f%%", ($yesterdayUpTime / (($mtdUpTime + $mtdDownTime + $mtdIdleTime) / $days)) * 100);
    $downTimePercent = sprintf("%.2f%%", ($yesterdayDownTime / (($mtdUpTime + $mtdDownTime + $mtdIdleTime) / $days)) * 100);
    $idleTimePercent = sprintf("%.2f%%", ($yesterdayIdleTime / (($mtdUpTime + $mtdDownTime + $mtdIdleTime) / $days)) * 100);

    $delayTimePercent = sprintf("%.2f%%", ($yesterdayIdleTime + $yesterdayDownTime) / (($mtdUpTime + $mtdDownTime + $mtdIdleTime) / $days) * 100);
}
$mtdUpTimePercent = sprintf("%.2f%%", ($mtdUpTime / ($mtdUpTime + $mtdDownTime + $mtdIdleTime)) * 100);
$mtdDownTimePercent = sprintf("%.2f%%", ($mtdDownTime / ($mtdUpTime + $mtdDownTime + $mtdIdleTime)) * 100);
$mtdIdleTimePercent = sprintf("%.2f%%", ($mtdIdleTime / ($mtdUpTime + $mtdDownTime + $mtdIdleTime)) * 100);
$mtdDelayTimePercent = sprintf("%.2f%%", ($mtdDownTime + $mtdIdleTime / ($mtdUpTime + $mtdDownTime + $mtdIdleTime)) * 100);

if ($yesterdayUpTime != 0) {
    $grossTPH = round($yesterdayGrossSum / $yesterdayUpTime, 1);
    $netTPH = round($yesterdayNetSum / $yesterdayUpTime, 1);
    $outputTPH = round($yesterdayOutputSum / $yesterdayUpTime, 1);
} else {
    $grossTPH = round($yesterdayGrossSum / ($mtdUpTime / $days), 1);
    $netTPH = round($yesterdayNetSum / ($mtdUpTime / $days), 1);
    $outputTPH = round($yesterdayOutputSum / ($mtdUpTime / $days), 1);
}


$mtdGrossTPH = round($mtdSumGross / $mtdUpTime, 1);
$mtdNetTPH = round($mtdSumNet / $mtdUpTime, 1);
$mtdOutputTPH = round($mtdSumOutput / $mtdUpTime, 1);

$maxIndex = array_search(max($outputSumArry), $outputSumArry);

if ($netSetting == '' || $netSetting == null) {


    $grossSetting = round($feedSumArry[$maxIndex], 0);
    $netSetting = round($netWeightArry[$maxIndex], 0);
    $outputSetting = round($outputSumArry[$maxIndex], 0);


}

$maxGrossTph = round($grossSetting / $uptimeArry[$maxIndex], 2);
//echo $weightedMoistureAvg;
function PlantMonthSums($FeedId, $startDate, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d ', strtotime($startDate . " +" . $i . " day"));
        $plantSumSql = "CALL sp_tl_plc_10MinuteDailyTotal(" . $FeedId . ",'" . $date . "')";
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
    for ($i = 0; $i < $count; $i++) {

        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantMoistureSql = "CALL sp_tl_plc_MoistureDayAvgGet(" . $locationId . ",'" . $date . "')";
//        echo $plantMoistureSql;
        $mositureResults = mysqli_query(dbmysqli(), $plantMoistureSql);
        while ($moistureResult = $mositureResults->fetch_assoc()) {
            If ($moistureResult['avg(moisture_rate)'] == "" || $moistureResult['avg(moisture_rate)'] == null || $moistureResult['avg(moisture_rate)'] == 0) {
                $dayMoistureArry[] = .07;
            } else {
                $dayMoistureArry[] = $moistureResult['avg(moisture_rate)'];
            }
//              echo("Rate{$i}: " . $dayMoistureArry[$i] . "<br>");
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

function PlantUpTimes($locationId, $startDate, $downtime, $idletime, $count)
{

    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantTimeSql = "CALL sp_tl_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
        // echo $plantTimeSql;
        $timeResults = mysqli_query(dbmysqli(), $plantTimeSql);

        while ($timeResult = $timeResults->fetch_assoc()) {
            if ($timeResult['uptime'] != '' && $timeResult['uptime'] != null) {
                $dayTimeUpArry[] = round(($timeResult['uptime']) / 60, 2);
                if ($dayTimeUpArry[$i] > 24.5) {
                    $dayTimeUpArry[$i] = 24.5 - $downtime[$i] - $idletime[$i];
                }
            } else {
                $dayTimeUpArry[] = 24 - $downtime[$i] - $idletime[$i];
            }
            // echo $dayTimeUpArry[$i] . "<br>";
        }
    }

    return $dayTimeUpArry;
}

function PlantDownTimes($locationId, $startDate, $count)
{
    for ($i = 0; $i < $count; $i++) {
        $date = date('Y-m-d', strtotime($startDate . " +" . $i . " day"));
        $plantTimeSql = "CALL sp_tl_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
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
        $plantTimeSql = "CALL sp_tl_plc_ShiftTimesDayGet(" . $locationId . ",'" . $date . " 00:00:00','" . $date . " 23:59:59')";
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>


<style>
    input {
        width: 80%;
    }

    .card {
        margin-bottom: .5%;
    }

</style>
<!-- HTML -->
<div class="container-fluid">
    <h3>Tolar Scorecard</h3>

    <!--<div class="card-columns">-->
    <div class="card">
        <div class="card-header">
            <h5>Target Settings</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label>Gross:</label>
                    <input class="form-control setting" type="number" id="grossDailyTargetSetting" required value="<?php echo $grossSetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>Net:</label>
                    <input class="form-control setting" type="number" id="netDailyTargetSetting" required value="<?php echo $netSetting ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label>Output:</label>
                    <input class="form-control setting" type="number" id="siloDailyTargetSetting" required value="<?php echo $outputSetting ?>">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-vprop-green float-right" onclick="saveSetting()" value="Save Settings">Save Settings</button>
        </div>
    </div>

    <div id="dry-table-card" class="card">
        <div class="card-header">
            <h4>Dry Plant</h4>
        </div>
        <div class="card-body">
            <div class='table-responsive-sm'>
                <table id='dryTable' class="table table-xl table-striped table-bordered table-hover nowrap">
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
                        <td><?php echo $yesterdayGrossSum; ?></td>
                        <td><?php echo $mtdSumGross; ?></td>
                        <td><?php echo $trendingTonsGross; ?></td>
                    </tr>
                    <tr>
                        <td>Net Feed</td>
                        <td><?php echo $yesterdayOutputSum; ?></td>
                        <td><?php echo $mtdSumNet; ?></td>
                        <td><?php echo $trendingTonsNet; ?></td>
                    </tr>
                    <tr>
                        <td>Tons To Silo</td>
                        <td><?php echo $yesterdayNetSum; ?></td>
                        <td><?php echo $mtdSumOutput; ?></td>
                        <td><?php echo $trendingTonsOutput; ?></td>
                    </tr>
                    <tr>
                        <td>Recovery %</td>
                        <td><?php echo $yesterdayRecovery; ?></td>
                        <td><?php echo $mtdRecovery; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Avg Moisture %</td>
                        <td><?php echo $yesterdayMoisture; ?></td>
                        <td><?php echo $mtdMoisture; ?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <canvas id="dry-table-chart-container" width="50%" height="10%"></canvas>
        </div>
        <div class="card-footer" id="dry-table-card-footer">

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Dry Plant Targets</h4>
        </div>
        <div class="card-body">
            <div class='table-responsive-sm'>
                <table id="targetTable" class="table table-xl table-striped table-hover table-bordered nowrap">
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
                        <td>Net</td>
                        <td><input class="form-control" id="dailyTarget" type="number" disabled><span style="display: none;" id="dailyTargetSpn"></span></td>
                        <td><input class="form-control" id="mtdTarget" type="text" disabled="disabled"><span style="display: none;" id="mtdTargetSpn"></span></td>
                        <td><input class="form-control" id="trendTarget" type="text" disabled="disabled"><span style="display: none;" id="trendTargetSpn"></span></td>
                        <td><input class="form-control" id="percentTarget" type="text" disabled="disabled"><span style="display: none;" id="percentTargetSpn"></span></td>
                    </tr>
                    <tr>
                        <td>Tons To Silo</td>
                        <td><input class="form-control" id="siloDailyTarget" type="number" disabled><span style="display: none;" id="siloDailyTargetSpn"></span></td>
                        <td><input class="form-control" id="siloMtdTarget" type="text" disabled="disabled"><span style="display: none;" id="siloMtdTargetSpn"></span></td>
                        <td><input class="form-control" id="siloTrendTarget" type="text" disabled="disabled"><span style="display: none;" id="siloTrendTargetSpn"></span></td>
                        <td><input class="form-control" id="siloPercentTarget" type="text" disabled="disabled"><span style="display: none;" id="siloPercentTargetSpn"></span></td>
                    </tr>
                    <tr>
                        <td>Recovery</td>
                        <td><input class="form-control" id="recoveryToday" type="text" disabled="disabled"><span style="display: none;" id="recoveryTodaySpn"></span></td>
                        <td><input class="form-control" id="recoveryMtd" type="text" disabled="disabled"><span style="display: none;" id="recoveryMtdSpn"></span></td>
                        <td><input class="form-control" id="recoveryMonth" type="text" disabled="disabled"><span style="display: none;" id="recoveryMtdSpn"></span></td>
                        <td></td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer" id="target-table-card-footer">

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Tonnage Per Hour</h4>
        </div>
        <div class="card-body">
            <div class='table-responsive-sm'>
                <table id='tphTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">

                    <tr>
                        <th>Run Rate</th>
                        <th><?php echo $yesterday; ?></th>
                        <th>MTD</th>
                        <th>Target</th>
                        <th>MTD % of Target</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Gross Feed TPH</td>
                        <td><?php echo $grossTPH; ?></td>
                        <td><?php echo $mtdGrossTPH; ?></td>
                        <td><input class="form-control" id="grossTph" disabled><span style="display: none;" id="grossTphSpn"></span></td>
                        <td><input class="form-control" id="grossTphPercent" disabled><span style="display: none;" id="grossTphPercentSpn"></span></td>
                    </tr>
                    <tr>
                        <td>Net Feed TPH</td>
                        <td><?php echo $netTPH; ?></td>
                        <td><?php echo $mtdNetTPH; ?></td>
                        <td><input class="form-control" id="netTph" disabled><span style="display: none;" id="netTphSpn"></span></td>
                        <td><input class="form-control" id="netTphPercent" disabled><span style="display: none;" id="netTphPercentSpn"></span></td>
                    </tr>
                    <tr>
                        <td>Tons To Silo</td>
                        <td><?php echo $outputTPH; ?></td>
                        <td><?php echo $mtdOutputTPH; ?></td>
                        <td><input class="form-control" id="siloTph" disabled><span style="display: none;" id="siloTphSpn"></span></td>
                        <td><input class="form-control" id="siloTphPercent" disabled><span style="display: none;" id="siloTphPercentSpn"></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer" id="tph-table-card-footer">

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Times</h4>
        </div>
        <div class="card-body">
            <div class='table-responsive-sm'>
                <table id='timeHoursTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th>Time</th>
                        <th><?php echo $yesterday; ?></th>
                        <th>MTD</th>
                    </tr>
                    <tbody>
                    <tr>
                        <td>Run Hours</td>
                        <td><?php echo $yesterdayUpTime; ?></td>
                        <td><?php echo $mtdUpTime; ?></td>
                    </tr>
                    <tr>
                        <td>Unscheduled Delay Hours</td>
                        <td><?php echo $yesterdayDownTime + $yesterdayIdleTime; ?></td>
                        <td><?php echo $mtdDownTime + $mtdIdleTime; ?></td>
                    </tr>
                    <tr>
                        <td>Total Hours</td>
                        <td><?php echo $yesterdayUpTime + $yesterdayDownTime + $yesterdayIdleTime; ?></td>
                        <td><?php echo $mtdUpTime + $mtdDownTime + $mtdIdleTime; ?></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="100%">Shifts not accurate at this time</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer" id="time-hours-table-card-footer">

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Dry Plant</h4>
        </div>
        <div class="card-body">
            <div class='table-responsive-sm'>
                <table id='timePercentTable' class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th>Time</th>
                        <th><?php echo $yesterday; ?></th>
                        <th>MTD</th>

                    </tr>
                    <tbody>
                    <tr>
                        <td>Run Hours</td>
                        <td><?php echo $upTimePercent; ?></td>
                        <td><?php echo $mtdUpTimePercent; ?></td>
                    </tr>
                    <tr>
                        <td>Unscheduled Delay Hours</td>
                        <td><?php echo $delayTimePercent; ?></td>
                        <td><?php echo $mtdDelayTimePercent; ?></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="100%">Shifts not accurate at this time</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer" id="dry-plant-table-card-footer">

        </div>
    </div>

    <div style='cursor:pointer;padding-bottom:10px' id='total-heading'>
        <h3>
            Daily Totals
            <div style='display:inline-block' id='arrow-up'>&#9650;</div>
            <div style='display:none' id='arrow-down'>&#9660;</div>
        </h3>
    </div>


    <div id="totals-card" class="card">
        <div class="card-header">
            <h3>Daily Breakdown</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="all-data" class="table table-xl table-striped table-hover table-bordered nowrap">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th>Date</th>
                        <th>Gross Feed</th>
                        <th>Net Feed</th>
                        <th>Net to Silo</th>
                        <th>Average Moisture</th>
                        <th>Run Hrs*</th>
                        <th>Unscheduled Delay*</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($feedSumArry); $i++) {
                        $date = date('Y-m-d ', strtotime($firstDayOfMonth . " +" . $i . " day"));
                        $moisture = sprintf("%.2f%%", ($moistureArry[$i]) * 100);
                        $ntWeight = round($netWeightArry[$i], 0);
                        echo("<tr>"
                            . "<td>{$date}</td>"
                            . "<td>{$feedSumArry[$i]}</td>"
                            . "<td>{$ntWeight}</td>"
                            . "<td>{$outputSumArry[$i]}</td>"
                            . "<td>{$moisture}</td>"
                            . "<td>{$uptimeArry[$i]}</td>"
                            . "<td>{$dtArry[$i]}</td>"
                            . "</tr>");
                    }

                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="100%">*Shifts not accurate at this time</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer" id="all-data-card-footer">

        </div>
    </div>

</div> <!-- Container -->
<!--</div>-->
<script>


    $(document).ready(function () {
        $('#totals-card').hide();
        $("#dailyTarget").val($('#netDailyTargetSetting').val());
        $("#siloDailyTarget").val($('#siloDailyTargetSetting').val());

        var targetVal = $("#dailyTarget").val();
        var targetValSilo = $("#siloDailyTarget").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>);

        var mtdVal = targetVal * days;
        var mtdValSilo = targetValSilo * days;

        var trendingVal = targetVal * daysInMonth;
        var trendingValSilo = targetValSilo * daysInMonth;

        var percent = ((<?php echo $mtdSumNet; ?>/mtdVal) * 100).toFixed(2) + '%';
        var percentSilo = ((<?php echo $mtdSumOutput; ?>/mtdValSilo) * 100).toFixed(2) + '%';

        var recoveryPercent = (($("#siloDailyTarget").val() / $("#dailyTarget").val()) * 100).toFixed(2) + '%';

        var targetGrossTPH = (<?php echo($maxGrossTph)?>).toFixed(2);
        var targetNetTPH = (mtdVal /<?php echo($mtdUpTime)?>).toFixed(2);
        var targetOutputTPH = (mtdValSilo /<?php echo($mtdUpTime)?>).toFixed(2);

        var targetGrossTPHPercent = (((<?php echo $mtdGrossTPH ?> -targetGrossTPH) / targetGrossTPH) * 100).toFixed(2) + '%';
        var targetNetTPHPercent = (((<?php echo $mtdNetTPH ?> -targetNetTPH) / targetNetTPH) * 100).toFixed(2) + '%';
        var targetOutputTPHPercent = (((<?php echo $mtdOutputTPH ?> -targetOutputTPH) / targetOutputTPH) * 100).toFixed(2) + '%';


        $("#mtdTarget").val(mtdVal);
        $('#trendTarget').val(trendingVal);
        $('#percentTarget').val(percent);

        $("#siloMtdTarget").val(mtdValSilo);
        $('#siloTrendTarget').val(trendingValSilo);
        $('#siloPercentTarget').val(percentSilo);

        $('#recoveryToday').val(recoveryPercent);
        $('#recoveryMtd').val(recoveryPercent);
        $('#recoveryMonth').val(recoveryPercent);

        $('#grossTph').val(targetGrossTPH);
        $('#netTph').val(targetNetTPH);
        $('#siloTph').val(targetOutputTPH);

        $('#grossTphPercent').val(targetGrossTPHPercent);
        $('#netTphPercent').val(targetNetTPHPercent);
        $('#siloTphPercent').val(targetOutputTPHPercent);
        
        
        $("#mtdTargetSpn").html(mtdVal);
        $('#trendTargetSpn').html(trendingVal);
        $('#percentTargetSpn').html(percent);

        $("#siloMtdTargetSpn").html(mtdValSilo);
        $('#siloTrendTargetSpn').html(trendingValSilo);
        $('#siloPercentTargetSpn').html(percentSilo);

        $('#recoveryTodaySpn').html(recoveryPercent);
        $('#recoveryMtdSpn').html(recoveryPercent);
        $('#recoveryMonthSpn').html(recoveryPercent);

        $('#grossTphSpn').html(targetGrossTPH);
        $('#netTphSpn').html(targetNetTPH);
        $('#siloTphSpn').html(targetOutputTPH);

        $('#grossTphPercentSpn').html(targetGrossTPHPercent);
        $('#netTphPercentSpn').html(targetNetTPHPercent);
        $('#siloTphPercentSpn').html(targetOutputTPHPercent);
        
        $("#dailyTargetSpn").html($('#netDailyTargetSetting').val());
        $("#siloDailyTargetSpn").html($('#siloDailyTargetSetting').val());

        var dryTable = $('#dryTable').DataTable({
            dom: 'rtB',
            ordering: false,
            buttons:
                [
                    {
                        extend: 'copy'
                    },
                    {
                        extend: 'excel'
                    },
                    {
                        text: '<i class="far fa-chart-bar" style="line-height:1.41;"></i>',
                        className: 'btn-vprop-blue',
                        action: function(){
                            $('#dry-table-chart-container').toggle();
                        }
                    }
                ]
        });
        dryTable.buttons().containers().appendTo('#dry-table-card-footer');
        
        var dryTableData = dryTable.rows().data();
        var grossFeedTons = dryTableData[0][1];
        var netFeedTons = dryTableData[1][1];
        var tonsToSilo = dryTableData[2][1];
        var recoveryPercent = dryTableData[3][1];
        var avgMoisture = dryTableData[4][1];
        var grossFeedMtd = dryTableData[0][2];
        var netFeedMtd = dryTableData[1][2];
        var tonsToSiloMtd = dryTableData[2][2];
        var grossFeedMtd = dryTableData[0][2];
        var grossFeedTrending = dryTableData[0][3];
        var ctx = $("#dry-table-chart-container");
        var dryTableChart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: ['Gross Feed', 'Net Feed', 'Tons To Silo'],
               datasets: [{
                   data: [grossFeedMtd, netFeedMtd, tonsToSiloMtd],
                   backgroundColor: [
                       'rgba(76, 122, 208, 0.2)',
                       'rgba(120, 214, 75, 0.2)',
                       'rgba(255, 206, 86, 0.2)',
                   ],
                   borderColor: [
                       'rgba(76, 122, 208)',
                       'rgba(120, 214, 75)',
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
                   text: 'Tons Month To Date'
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
        $('#dry-table-chart-container').hide();




        var targetTable = $('#targetTable').DataTable({
            dom: 'rtB',
            ordering: false,
            columnDefs:[
                {orderDataType: 'dom-input', targets: [1,2,3,4], type: 'string'},
            ],
            buttons:
                [
                    {extend: 'copy'}, {extend:'excel',exportOptions: {format: {
                            body: function ( data, row, column, node ) {
                                return $(data).is("input") ? $(data).val(): data;
                            }
                        }
                    }}
                ]
        });
        targetTable.buttons().containers().appendTo('#target-table-card-footer');

        var tphTable = $('#tphTable').DataTable({
            dom: 'rtB',
            ordering: false,
            buttons:
                [
                    {extend: 'copy'}, {extend: 'excel'}
                ]
        });
        tphTable.buttons().containers().appendTo('#tph-table-card-footer');

        var timeHoursTable = $('#timeHoursTable').DataTable({
            dom: 'rtB',
            ordering: false,
            buttons:
                [
                    {extend: 'copy'}, {extend: 'excel'}
                ]
        });
        timeHoursTable.buttons().containers().appendTo('#time-hours-table-card-footer');

        var timePercentTable = $('#timePercentTable').DataTable({
            dom: 'rtB',
            ordering: false,
            buttons:
                [
                    {extend: 'copy'}, {extend: 'excel'}
                ]
        });
        timePercentTable.buttons().containers().appendTo('#dry-plant-table-card-footer');

        var allDataTable = $('#all-data').DataTable({
            dom: 'rtB',
            ordering: false,
            buttons:
                [
                    {extend: 'copy'}, {extend: 'excel'}
                ]
        });
        allDataTable.buttons().containers().appendTo('#all-data-card-footer');
        $('.dt-buttons').removeClass('btn-group').addClass('float-right');
        $('.buttons-excel').removeClass('btn-secondary').addClass('btn-vprop-green');

    });


    $('.setting').on('input',function()
    {
              $('#totals-card').hide();
        $("#dailyTarget").val($('#netDailyTargetSetting').val());
        $("#siloDailyTarget").val($('#siloDailyTargetSetting').val());

        var targetVal = $("#dailyTarget").val();
        var targetValSilo = $("#siloDailyTarget").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>);

        var mtdVal = targetVal * days;
        var mtdValSilo = targetValSilo * days;

        var trendingVal = targetVal * daysInMonth;
        var trendingValSilo = targetValSilo * daysInMonth;

        var percent = ((<?php echo $mtdSumNet; ?>/mtdVal) * 100).toFixed(2) + '%';
        var percentSilo = ((<?php echo $mtdSumOutput; ?>/mtdValSilo) * 100).toFixed(2) + '%';

        var recoveryPercent = (($("#siloDailyTarget").val() / $("#dailyTarget").val()) * 100).toFixed(2) + '%';

        var targetGrossTPH = (<?php echo($maxGrossTph)?>).toFixed(2);
        var targetNetTPH = (mtdVal /<?php echo($mtdUpTime)?>).toFixed(2);
        var targetOutputTPH = (mtdValSilo /<?php echo($mtdUpTime)?>).toFixed(2);

        var targetGrossTPHPercent = (((<?php echo $mtdGrossTPH ?> -targetGrossTPH) / targetGrossTPH) * 100).toFixed(2) + '%';
        var targetNetTPHPercent = (((<?php echo $mtdNetTPH ?> -targetNetTPH) / targetNetTPH) * 100).toFixed(2) + '%';
        var targetOutputTPHPercent = (((<?php echo $mtdOutputTPH ?> -targetOutputTPH) / targetOutputTPH) * 100).toFixed(2) + '%';


        $("#mtdTarget").val(mtdVal);
        $('#trendTarget').val(trendingVal);
        $('#percentTarget').val(percent);

        $("#siloMtdTarget").val(mtdValSilo);
        $('#siloTrendTarget').val(trendingValSilo);
        $('#siloPercentTarget').val(percentSilo);

        $('#recoveryToday').val(recoveryPercent);
        $('#recoveryMtd').val(recoveryPercent);
        $('#recoveryMonth').val(recoveryPercent);

        $('#grossTph').val(targetGrossTPH);
        $('#netTph').val(targetNetTPH);
        $('#siloTph').val(targetOutputTPH);

        $('#grossTphPercent').val(targetGrossTPHPercent);
        $('#netTphPercent').val(targetNetTPHPercent);
        $('#siloTphPercent').val(targetOutputTPHPercent);
        
        
        $("#mtdTargetSpn").html(mtdVal);
        $('#trendTargetSpn').html(trendingVal);
        $('#percentTargetSpn').html(percent);

        $("#siloMtdTargetSpn").html(mtdValSilo);
        $('#siloTrendTargetSpn').html(trendingValSilo);
        $('#siloPercentTargetSpn').html(percentSilo);

        $('#recoveryTodaySpn').html(recoveryPercent);
        $('#recoveryMtdSpn').html(recoveryPercent);
        $('#recoveryMonthSpn').html(recoveryPercent);

        $('#grossTphSpn').html(targetGrossTPH);
        $('#netTphSpn').html(targetNetTPH);
        $('#siloTphSpn').html(targetOutputTPH);

        $('#grossTphPercentSpn').html(targetGrossTPHPercent);
        $('#netTphPercentSpn').html(targetNetTPHPercent);
        $('#siloTphPercentSpn').html(targetOutputTPHPercent);
        
        $("#dailyTargetSpn").html($('#netDailyTargetSetting').val());
        $("#siloDailyTargetSpn").html($('#siloDailyTargetSetting').val());
    });

    $('#netDailyTargetSetting').on('input', function () {

        $("#dailyTarget").val($("#netDailyTargetSetting").val());

        var targetVal = $("#dailyTarget").val();
        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var mtdVal = targetVal * days;
        var trendingVal = targetVal * daysInMonth;

        var percent = ((<?php echo $mtdSumNet; ?>/mtdVal) * 100).toFixed(2) + '%';
        var recoveryPercent = (($("#siloDailyTarget").val() / $("#dailyTarget").val()) * 100).toFixed(2) + '%';

        var targetNetTPH = (mtdVal /<?php echo($mtdUpTime)?>).toFixed(2);
        var targetNetTPHPercent = (((<?php echo $mtdNetTPH ?> -targetNetTPH) / targetNetTPH) * 100).toFixed(2) + '%';

        $("#mtdTarget").val(mtdVal);
        $('#trendTarget').val(trendingVal);
        $('#percentTarget').val(percent);

        $('#recoveryToday').val(recoveryPercent);
        $('#recoveryMtd').val(recoveryPercent);
        $('#recoveryMonth').val(recoveryPercent);

        $('#netTph').val(targetNetTPH);
        $('#netTphPercent').val(targetNetTPHPercent);
    });

    $('#siloDailyTargetSetting').on('input', function () {

        $("#siloDailyTarget").val($("#siloDailyTargetSetting").val());

        var targetVal = $("#siloDailyTarget").val();

        var days = parseInt(<?php echo($days); ?>);
        var daysInMonth = parseInt(<?php echo($numOfDaysMonth); ?>)

        var mtdVal = targetVal * days;
        var trendingVal = targetVal * daysInMonth;

        var percentOfTarget = ((<?php echo $mtdSumOutput; ?>/mtdVal) * 100).toFixed(2) + '%';
        var recoveryPercent = (($("#siloDailyTarget").val() / $("#dailyTarget").val()) * 100).toFixed(2) + '%';

        var targetOutputTPH = (targetVal /<?php echo($mtdUpTime)?>).toFixed(2);
        var targetOutputTPHPercent = (((<?php echo $mtdOutputTPH ?> -targetOutputTPH) / targetOutputTPH) * 100).toFixed(2) + '%';

        $("#siloMtdTarget").val(mtdVal);
        $('#siloTrendTarget').val(trendingVal);
        $('#siloPercentTarget').val(percentOfTarget);

        $('#recoveryToday').val(recoveryPercent);
        $('#recoveryMtd').val(recoveryPercent);
        $('#recoveryMonth').val(recoveryPercent);

        $('#siloTph').val(targetOutputTPH);
        $('#siloTphPercent').val(targetOutputTPHPercent);
    });

    $('#grossDailyTargetSetting').on('input', function () {

        var targetGrossSetting = $("#grossDailyTargetSetting").val();
        var targetGrossTPH = (targetGrossSetting / 24).toFixed(2);
        var mtdGrossTPH = <?php echo $mtdGrossTPH ?>;
        var targetGrossTPHPercent = (((mtdGrossTPH - targetGrossTPH) / targetGrossTPH) * 100).toFixed(2) + '%';

        $('#grossTph').val(targetGrossTPH);
        $('#grossTphPercent').val(targetGrossTPHPercent);
    });

    $('#total-heading').on('click', function () {
        $('#arrow-down').toggleClass('display-inline-block ');
        $('#arrow-up').toggle();
        $(this).next('#totals-card').slideToggle();
        $('html, body').animate({scrollTop: $(document).height()}, 'slow');

    });


    function saveSetting() {
        var targetNet = $("#netDailyTargetSetting").val();
        var targetSilo = $("#siloDailyTargetSetting").val();
        var targetGross = $("#grossDailyTargetSetting").val();
        var firstDayOfMonth = "<?php echo($firstDayOfMonth)?>";
        var site = "tl";

        if (targetNet == 0 || targetNet == "") {
            alert("Target for Net cannot be 0 or blank")
            return;
        }

        if (targetSilo == 0 || targetSilo == "") {
            alert("Target for Output cannot be 0 or blank")
            return;
        }

        if (targetGross == 0 || targetGross == "") {
            alert("Target for Gross cannot be 0 or blank")
            return;
        }
        //alert( firstDayOfMonth)
        $.ajax
        ({
            url: '../../Includes/Production/scorecardsettinginsert.php',
            type: 'POST',
            data:
                {
                    start_date: firstDayOfMonth,
                    output_setting: targetSilo,
                    net_setting: targetNet,
                    gross_setting: targetGross,
                    site: site
                },
            success: function (response) {
                alert("Success");
            }
        });

    };
</script>