<?php
/* * *****************************************************************************************************************************************
 * File Name: tceqreport.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17422 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/gb_plc_tagGlobal.php');

if (isset($_POST['start-date']) && !empty($_POST['start-date']))
  {
    $startDate = strtotime(filter_input(INPUT_POST, 'start-date', "first day of this month"));
  }
else
  {
    $startDate = date("Y-m-d", strtotime("first day of this month", strtotime("-1 years")));
  }
  
if (isset($_POST['end-date']) && !empty($_POST['end-date']))
  {
    $endDate = filter_input(INPUT_POST, 'end-date');
  }
else
  {
    $endDate = date("Y-m-d", strtotime('last day of previous month'));
  }
   
// <editor-fold defaultstate="collapsed" desc=" PlantIDs ">
$ASSUMED_RATE = .07;
  
$wetPlant2SampleFeedId = 127;
$wetPlant2SampleCoarseId = 3;
$wetPlant2SampleFineId = 4;

$wetPlant2ConveyorFeedId = 4;
$wetPlant2ConveyorCoarseId = 12;
$wetPlant2ConveyorFineId = 16;

$wetPlant2LocationId = 1;

$wetPlant1SampleFeedId = 128;
$wetPlant1SampleCoarseId = 22;
$wetPlant1SampleFineId = 23;

$wetPlant1ConveyorFeedId = 8;
$wetPlant1ConveyorCoarseId = 2;
$wetPlant1ConveyorFineId = 3;

$wetPlant1LocationId = 1;

//Dry Plants
$rotarySampleFeedId = 49;
$rotarySampleOutputId = 50;

$rotaryConveyorFeedId = 18;
$rotaryConveyorOutputId = 26;

$rotaryLocationId = 6;

$carrier100TSampleFeedId = 24;
$carrier100TSampleOutputId = 55;

$carrier100TConveyorFeedId = 28;
$carrier100TConveyorOutputId = 0;

$carrier100TLocationId = 5;

$carrier200TSampleFeedId = 103;
$carrier200TSampleOutputId = 102;

$carrier200TConveyorFeedId = 22;
$carrier200TConveyorOutputId = 24;

$carrier200TLocationId = 8;
// </editor-fold>

$monthArr = monthGet($startDate);
$monthNameArr = monthNames($monthArr); 

$wetPlant1Sums = PlantMonthSums($wetPlant1ConveyorFeedId, $monthArr);  
$wetPlant2Sums = PlantMonthSums($wetPlant2ConveyorFeedId, $monthArr);  
$rotarySums = PlantMonthSums($rotaryConveyorFeedId, $monthArr);  
$carrier100TSums = PlantMonthSums($carrier100TConveyorFeedId, $monthArr);  
$carrier200TSums = PlantMonthSums($carrier200TConveyorFeedId, $monthArr); 

$wetPlant1Moisture = PlantMonthMoisture($wetPlant1SampleFeedId, $monthArr);  
$wetPlant2Moisture = PlantMonthMoisture($wetPlant2SampleFeedId, $monthArr);  
$rotaryMoisture = PlantMonthMoisture($rotarySampleFeedId, $monthArr);  
$carrier100TMoisture = PlantMonthMoisture($carrier100TSampleFeedId, $monthArr);  
$carrier200TMoisture = PlantMonthMoisture($carrier200TSampleFeedId, $monthArr); 

$wetPlant1Times = PlantMonthTimes($wetPlant1LocationId, $monthArr);  
$wetPlant2Times = PlantMonthTimes($wetPlant2LocationId, $monthArr);  
$rotaryTimes = PlantMonthTimes($rotaryLocationId, $monthArr);  
$carrier100TTimes = PlantMonthTimes($carrier100TLocationId, $monthArr);  
$carrier200TTimes = PlantMonthTimes($carrier200TLocationId, $monthArr); 

$text = implode(",", $wetPlant1Sums);



//echo($text . "<br>");

  function MonthGet($date)
    {
    $dateArry = array();
    for($i=0; $i<12; $i++)
      {
        $monthNumber = "+" . $i . "months";
        $dateArry[] = date('Y-m-d', strtotime($monthNumber, strtotime($date, strtotime('first day of this month'))));
      }
    return $dateArry;  
  }
  
  function MonthNames($monthArr)
    {
    $monthNameArry = array();
    for($i=0; $i<12; $i++)
    {
      $monthNameArry[] = Datetime::createFromFormat('Y-m-d',  $monthArr[$i])->format('F Y');
    }
    return $monthNameArry;
  }
  
  function PlantMonthSums($FeedId, $monthArr)
    {
    $monthSumArry = array();
    for($i=0; $i<12; $i++)
    {
      $plantSumSql = "CALL sp_gb_plc_10minuteMonthSumGet(". $FeedId . ",'" . $monthArr[$i] . "')";
      //  echo $plantSumSql;
      $sumResults = mysqli_query(dbmysqli(), $plantSumSql);
      while($sumResult = $sumResults->fetch_assoc())
        {
          $monthSumArry[] = $sumResult['sum(value)'];
        }
    }
    return $monthSumArry;
  }
  
  function PlantMonthMoisture($locationId, $monthArr)
    {
        $monthMoistureArry = array();
        for($i=0; $i<12; $i++)
        {
          $plantMoistureSql = "CALL sp_gb_plc_MoistureMonthAvgGet(". $locationId . ",'" . $monthArr[$i] . "')";
          $mositureResults = mysqli_query(dbmysqli(), $plantMoistureSql);
          while($moistureResult = $mositureResults->fetch_assoc())
            {
              $monthMoistureArry[] = $moistureResult['avg(moisture_rate)'];
            }
        }
        return $monthMoistureArry;
    }
    
  function PlantMonthTimes($locationId, $monthArr)
    {
        $monthTimeArry = array();
        for($i=0; $i<12; $i++)
        {
          $plantTimeSql = "CALL sp_gb_plc_ShiftTimesSumGet(". $locationId . ",'" . $monthArr[$i] . "')";
          //echo $plantTimeSql;
          $timeResults = mysqli_query(dbmysqli(), $plantTimeSql);
          if($timeResults)
            {
              while($timeResult = $timeResults->fetch_assoc())
                {
                  if($timeResult['uptime'] != '' && $timeResult['uptime'] != null)
                    {
                      $monthTimeArry[] =round(($timeResult['uptime'])/60,2); 
                    }
                  else
                    {
                      $monthTimeArry[] = 0;
                    }
                }
            }
            else
              {
                $monthTimeArry=array(0,0,0,0,0,0,0,0,0,0,0,0);
              }
        }
        return $monthTimeArry;
    }
//========================================================================================== END PHP
?>

<!-- HTML -->
<script>
    $(function() 
  {   
   $("#start-date").datetimepicker({ timepicker: false, format: 'Y-m-d' });
   $("#end-date").datetimepicker({ timepicker: false, format: 'Y-m-d' });
  });
</script>

<h1>TCEQ Production Report</h1>
<div class="prod-datepicker">
  <form action='tceqreport.php' method='post' >
    <input type="text" id="start-date" value='<?php echo($startDate) ?>'>
    <strong>to</strong>
    <input type="text" id="end-date" value='<?php echo($endDate) ?>'> 
    <input type="submit" value="Submit">
  </form>
</div>

<table style="width:95%">
  <tr>
    <td style="padding-right:100px">
      <div class="prodtable">
        <table style="width:100%;">
          <thead>
            <tr>
              <th colspan="5">Wet Plant #1</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime(hours)</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
          <tbody>
<?php
  $hourSum = array_sum($wetPlant1Times);
  $tonsSum = 0;
  $tonsPerHourTotal = 0;
  for($i=0; $i<12; $i++)
    {
      if($wetPlant1Moisture[$i] === 0 || $wetPlant1Moisture[$i] == "" )
        {
          $moisturePercent = sprintf("%.2f%%", ($ASSUMED_RATE) * 100);
          $dryPercent = 1 - $ASSUMED_RATE;
        }
      else
        {
          $moisturePercent = sprintf("%.2f%%", ($wetPlant1Moisture[$i]) * 100);
          $dryPercent = 1 - $wetPlant1Moisture[$i];
        }
        
      $dryTons = round($wetPlant1Sums[$i] * $dryPercent,2);
      $tonsSum = $tonsSum + $dryTons;
              
      if($wetPlant1Times[$i] > 0)
        {
          $tonsPerHour = round($dryTons / $wetPlant1Times[$i],2);
          $tonsPerHourTotal = $tonsPerHourTotal + $tonsPerHour;
        }
      else
        {
          $tonsPerHour = 'N/A';
        }
      echo("<tr>
            <td>{$monthNameArr[$i]}</td>
            <td>{$moisturePercent}</td>
            <td>{$dryTons}</td>
            <td>{$wetPlant1Times[$i]}</td>
            <td>{$tonsPerHour}</td>
           </tr>");
    }
    echo("            
      <tr>
        <td colspan='5' style='background:#fff!important;'>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td>&nbsp;</td>
        <td><strong>{$tonsSum}</strong></td>
        <td><strong>{$hourSum}</strong></td>       
        <td><strong>{$tonsPerHourTotal}</strong></td>
      </tr> ")
?>

          </tbody>
          <tfoot>
            <tr>
              <td style="text-color"><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
    <td>
      <div class="prodtable">
        <table style="width: 100%">
          <thead>
            <tr>
              <th colspan="5">Wet Plant #2</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime(hours)</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
<?php
  $hourSum = array_sum($wetPlant2Times);
  $tonsSum = 0;
  $tonsPerHourTotal = 0;
  for($i=0; $i<12; $i++)
    {
      if($wetPlant2Moisture[$i] === 0 || $wetPlant2Moisture[$i] == "" )
        {
          $moisturePercent = sprintf("%.2f%%", ($ASSUMED_RATE) * 100);
          $dryPercent = 1 - $ASSUMED_RATE;
        }
      else
        {
          $moisturePercent = sprintf("%.2f%%", ($wetPlant2Moisture[$i]) * 100);
          $dryPercent = 1 - $wetPlant2Moisture[$i];
        }
        
      $dryTons = round($wetPlant2Sums[$i] * $dryPercent, 2 );
      $tonsSum = $tonsSum + $dryTons;
              
      if($wetPlant2Times[$i] > 0)
        {
          $tonsPerHour = round($dryTons / $wetPlant2Times[$i],2);
          $tonsPerHourTotal = $tonsPerHourTotal + $tonsPerHour;
        }
      else
        {
          $tonsPerHour = 'N/A';
        }
      echo("<tr>
            <td>{$monthNameArr[$i]}</td>
            <td>{$moisturePercent}</td>
            <td>{$dryTons}</td>
            <td>{$wetPlant2Times[$i]}</td>
            <td>{$tonsPerHour}</td>
           </tr>");
    }
    echo("            
      <tr>
        <td colspan='5' style='background:#fff!important;'>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td>&nbsp;</td>
        <td><strong>{$tonsSum}</strong></td>
        <td><strong>{$hourSum}</strong></td>       
        <td><strong>{$tonsPerHourTotal}</strong></td>
      </tr> ")
?>
          </tbody>
          <tfoot>
            <tr>
              <td><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</strong</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
    
  </tr>
</table>

<br>

<table style="width:95%">
  <tr>
    <td style="padding-right:100px">
      <div class="prodtable">
        <table style="width:100%;">
          <thead>
            <tr>
              <th colspan="5">Dry Plant 100T</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime(hours)</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
          <tbody>
<?php
  $hourSum = array_sum($carrier100TTimes);
  $tonsSum = 0;
  $tonsPerHourTotal = 0;
  for($i=0; $i<12; $i++)
    {
      if($carrier100TMoisture[$i] === 0 || $carrier100TMoisture[$i] == "" )
        {
          $moisturePercent = sprintf("%.2f%%", ($ASSUMED_RATE) * 100);
          $dryPercent = 1 - $ASSUMED_RATE;
        }
      else
        {
          $moisturePercent = sprintf("%.2f%%", ($carrier100TMoisture[$i]) * 100);
          $dryPercent = 1 - $carrier100TMoisture[$i];
        }
        
      $dryTons = round($carrier100TSums[$i] * $dryPercent, 2 );
      $tonsSum = $tonsSum + $dryTons;
              
      if($carrier100TTimes[$i] > 0)
        {
          $tonsPerHour = round($dryTons / $carrier100TTimes[$i],2);
          $tonsPerHourTotal = $tonsPerHourTotal + $tonsPerHour;
        }
      else
        {
          $tonsPerHour = 'N/A';
        }
      echo("<tr>
            <td>{$monthNameArr[$i]}</td>
            <td>{$moisturePercent}</td>
            <td>{$dryTons}</td>
            <td>{$carrier100TTimes[$i]}</td>
            <td>{$tonsPerHour}</td>
           </tr>");
    }
    echo("            
      <tr>
        <td colspan='5' style='background:#fff!important;'>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td>&nbsp;</td>
        <td><strong>{$tonsSum}</strong></td>
        <td><strong>{$hourSum}</strong></td>       
        <td><strong>{$tonsPerHourTotal}</strong></td>
      </tr> ")
?>

          </tbody>
          <tfoot>
            <tr>
              <td style="text-color"><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
    <td>
      <div class="prodtable">
        <table style="width: 100%">
          <thead>
            <tr>
              <th colspan="5">Dry Plant 200T</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime(hours)</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
<?php
  $hourSum = array_sum($carrier200TTimes);
  $tonsSum = 0;
  $tonsPerHourTotal = 0;
  for($i=0; $i<12; $i++)
    {
      if($carrier200TMoisture[$i] === 0 || $carrier200TMoisture[$i] == "" )
        {
          $moisturePercent = sprintf("%.2f%%", ($ASSUMED_RATE) * 100);
          $dryPercent = 1 - $ASSUMED_RATE;
        }
      else
        {
          $moisturePercent = sprintf("%.2f%%", ($carrier200TMoisture[$i]) * 100);
          $dryPercent = 1 - $carrier200TMoisture[$i];
        }
        
      $dryTons = round($carrier200TSums[$i] * $dryPercent, 2 );
      $tonsSum = $tonsSum + $dryTons;
              
      if($carrier200TTimes[$i] > 0)
        {
          $tonsPerHour = round($dryTons / $carrier200TTimes[$i],2);
          $tonsPerHourTotal = $tonsPerHourTotal + $tonsPerHour;
        }
      else
        {
          $tonsPerHour = 'N/A';
        }
      echo("<tr>
            <td>{$monthNameArr[$i]}</td>
            <td>{$moisturePercent}</td>
            <td>{$dryTons}</td>
            <td>{$carrier200TTimes[$i]}</td>
            <td>{$tonsPerHour}</td>
           </tr>");
    }
    echo("            
      <tr>
        <td colspan='5' style='background:#fff!important;'>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td>&nbsp;</td>
        <td><strong>{$tonsSum}</strong></td>
        <td><strong>{$hourSum}</strong></td>       
        <td><strong>{$tonsPerHourTotal}</strong></td>
      </tr> ")
?>
          </tbody>
          <tfoot>
            <tr>
              <td><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</strong</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
  </tr>
</table>

<br>

<table style="width:95%">
  <tr>
    <td style="padding-right:100px">
      <div class="prodtable">
        <table style="width:50%;">
          <thead>
            <tr>
              <th colspan="5">Rotary</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime(hours)</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
          <tbody>
<?php
  $hourSum = array_sum($rotaryTimes);
  $tonsSum = 0;
  $tonsPerHourTotal = 0;
  for($i=0; $i<12; $i++)
    {
      if($rotaryMoisture[$i] === 0 || $rotaryMoisture[$i] == "" )
        {
          $moisturePercent = sprintf("%.2f%%", ($ASSUMED_RATE) * 100);
          $dryPercent = 1 - $ASSUMED_RATE;
        }
      else
        {
          $moisturePercent = sprintf("%.2f%%", ($rotaryMoisture[$i]) * 100);
          $dryPercent = 1 - $rotaryMoisture[$i];
        }
        
      $dryTons = round($rotarySums[$i] * $dryPercent, 2 );
      $tonsSum = $tonsSum + $dryTons;
              
      if($rotaryTimes[$i] > 0)
        {
          $tonsPerHour = round($dryTons / $rotaryTimes[$i],2);
          $tonsPerHourTotal = $tonsPerHourTotal + $tonsPerHour;
        }
      else
        {
          $tonsPerHour = 'N/A';
        }
      echo("<tr>
            <td>{$monthNameArr[$i]}</td>
            <td>{$moisturePercent}</td>
            <td>{$dryTons}</td>
            <td>{$rotaryTimes[$i]}</td>
            <td>{$tonsPerHour}</td>
           </tr>");
    }
    echo("            
      <tr>
        <td colspan='5' style='background:#fff!important;'>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td>&nbsp;</td>
        <td><strong>{$tonsSum}</strong></td>
        <td><strong>{$hourSum}</strong></td>       
        <td><strong>{$tonsPerHourTotal}</strong></td>
      </tr> ")
?>

          </tbody>
          <tfoot>
            <tr>
              <td style="text-color"><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
   </tr>
</table>