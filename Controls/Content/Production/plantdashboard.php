<?php
/* * *****************************************************************************************************************************************
 * File Name: plantdashboard.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17512 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');

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
    $endDate = date("Y-m-d");
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
    $conveyorTagsSQL = "CALL sp_gb_plc_ConveyorTagsGet()";
    $conveyorTagsResults = mysqli_query(dbmysqli(),$conveyorTagsSQL);
  }
catch(Exception $e)
  {
    echo("Error: " .  __LINE__ . " " .$e);
  }
  
//returns all unique operators into sql object
try
 {
   $operatorsSQL = "CALL sp_gb_plc_OperatorsGet()";
   $operatorResults = mysqli_query(dbmysqli(),$operatorsSQL);
 }
catch(Exception $e)
 {
   echo("Error: " .  __LINE__ . " " .$e);
 }
 
 //returns various statistics for QC samples moisture rate, +70, etc. into sql object
 try
 {
    $wetPlant2FeedID = 2;
    $wetPlant2CoarseID = 3;
    $wetPlant2FineID = 4;
    
    //finds average for the period of time given
    $wetPlant2FeedSQL = "CALL sp_gb_plc_SamplesByLocationGet"
            . "('" . $startDate . "','" . $endDate . "'," . $wetPlant2FeedID . ")";
    $wetPlant2CoarseSQL = "CALL sp_gb_plc_SamplesByLocationGet"
            . "('" . $startDate . "','" . $endDate . "'," . $wetPlant2CoarseID . ")";
    $wetPlant2FeedSQL = "CALL sp_gb_plc_SamplesByLocationGet"
            . "('" . $startDate . "','" . $endDate . "'," . $wetPlant2FineID . ")";
    

    
    //finds the overall average so as to compare it to the period average
    $wetPlant2FeedAvgSQL = "CALL sp_gb_plc_SamplesOverallAvgGet(" . $wetPlant2FeedID . ")";
    $wetPlant2CoarseAvgSQL = "CALL sp_gb_plc_SamplesOverallAvgGet(" . $wetPlant2CoarseID . ")";
    $wetPlant2FineAvgSQL = "CALL sp_gb_plc_SamplesOverallAvgGet(" . $wetPlant2FineID . ")";
    
    $wetPlant2FeedResults = mysqli_query(dbmysqli(),$wetPlant2FeedSQL);
    $wetPlant2CoarseResults = mysqli_query(dbmysqli(),$wetPlant2CoarseSQL);
    $wetPlant2FineResults = mysqli_query(dbmysqli(),$wetPlant2FeedSQL);
    
    $wetPlant2FeedAvgResults = mysqli_query(dbmysqli(),$wetPlant2FeedAvgSQL);
    $wetPlant2CoarseAvgResults = mysqli_query(dbmysqli(),$wetPlant2CoarseAvgSQL);
    $wetPlant2FineAvgResults = mysqli_query(dbmysqli(),$wetPlant2FeedAvgSQL);
 }
 catch(Exception $e)
 {
   echo("Error: " .  __LINE__ . " " .$e);
 }
 
//statistics assigned for wet plant 2 course, fine and feed for the period specified 
while($wetPlant2FeedRes = $wetPlant2FeedResults->fetch_assoc())
  {
    $wetPlant2FeedMoisture = $wetPlant2FeedRes['AVG(s.moisture_rate)'];
    $wetPlant2FeedPlus70 = $wetPlant2FeedRes['AVG(s.plus_70)'];
    $wetPlant2FeedMinus40Plus70 = $wetPlant2FeedRes['AVG(s.minus_40_plus_70)'];
    $wetPlant2FeedMinus70 = $wetPlant2FeedRes['AVG(s.minus_70)'];
    $wetPlant2FeedMinus70Plus140 = $wetPlant2FeedRes['AVG(s.minus_70_plus_140)'];
    $wetPlant2FeedPlus140 = $wetPlant2FeedRes['AVG(s.plus_140)'];
    $wetPlant2FeedMinus140 = $wetPlant2FeedRes['AVG(s.minus_140)'];
  }
  
while($wetPlant2CoarseRes = $wetPlant2CoarseResults->fetch_assoc())
  {
    $wetPlant2CoarseMoisture = $wetPlant2CoarseRes['AVG(s.moisture_rate)'];
    $wetPlant2CoarsePlus70 = $wetPlant2CoarseRes['AVG(s.plus_70)'];
    $wetPlant2CoarseMinus40Plus70 = $wetPlant2CoarseRes['AVG(s.minus_40_plus_70)'];
    $wetPlant2CoarseMinus70 = $wetPlant2CoarseRes['AVG(s.minus_70)'];
    $wetPlant2CoarseMinus70Plus140 = $wetPlant2CoarseRes['AVG(s.minus_70_plus_140)'];
    $wetPlant2CoarsePlus140 = $wetPlant2CoarseRes['AVG(s.plus_140)'];
    $wetPlant2CoarseMinus140 = $wetPlant2FeedRes['AVG(s.minus_140)'];
  }

while($wetPlant2FineRes = $wetPlant2FineResults->fetch_assoc())
  {
    $wetPlant2FineMoisture = $wetPlant2FineRes['AVG(s.moisture_rate)'];
    $wetPlant2FinePlus70 = $wetPlant2FineRes['AVG(s.plus_70)'];
    $wetPlant2FineMinus40Plus70 = $wetPlant2FineRes['AVG(s.minus_40_plus_70)'];
    $wetPlant2FineMinus70 = $wetPlant2FineRes['AVG(s.minus_70)'];
    $wetPlant2FineMinus70Plus140 = $wetPlant2FineRes['AVG(s.minus_70_plus_140)'];
    $wetPlant2FinePlus140 = $wetPlant2FineRes['AVG(s.plus_140)'];
    $wetPlant2FineMinus140 = $wetPlant2FineRes['AVG(s.minus_140)'];
  }  

  
//finds the overall average for wet plant 2 course, fine and feed, no date ranged is used so
while($wetPlant2FeedAvgRes = $wetPlant2FeedAvgResults->fetch_assoc())
  {
    $wetPlant2FeedAvgMoisture = $wetPlant2FeedAvgRes['AVG(moisture_rate)'];
    $wetPlant2FeedAvgPlus70 = $wetPlant2FeedAvgRes['AVG(plus_70)'];
    $wetPlant2FeedAvgMinus40Plus70 = $wetPlant2FeedAvgRes['AVG(minus_40_plus_70)'];
    $wetPlant2FeedAvgMinus70 = $wetPlant2FeedAvgRes['AVG(minus_70)'];
    $wetPlant2FeedAvgMinus70Plus140 = $wetPlant2FeedAvgRes['AVG(minus_70_plus_140)'];
    $wetPlant2FeedAvgPlus140 = $wetPlant2FeedAvgRes['AVG(plus_140)'];
    $wetPlant2FeedAvgMinus140 = $wetPlant2FeedAvgRes['AVG(minus_140)'];
  }  
  
while($wetPlant2CoarseAvgRes = $wetPlant2CoarseAvgResults->fetch_assoc())
  {
    $wetPlant2CoarseAvgMoisture = $wetPlant2CoarseAvgRes['AVG(moisture_rate)'];
    $wetPlant2CoarseAvgPlus70 = $wetPlant2CoarseAvgRes['AVG(plus_70)'];
    $wetPlant2CoarseAvgMinus40Plus70 = $wetPlant2CoarseAvgRes['AVG(minus_40_plus_70)'];
    $wetPlant2CoarseAvgMinus70 = $wetPlant2CoarseAvgRes['AVG(minus_70)'];
    $wetPlant2CoarseAvgMinus70Plus140 = $wetPlant2CoarseAvgRes['AVG(minus_70_plus_140)'];
    $wetPlant2CoarseAvgPlus140 = $wetPlant2CoarseAvgRes['AVG(plus_140)'];
    $wetPlant2CoarseAvgMinus140 = $wetPlant2CoarseAvgRes['AVG(minus_140)'];
  } 
  
while($wetPlant2FineAvgRes = $wetPlant2FineAvgResults->fetch_assoc())
  {
    $wetPlant2FineAvgMoisture = $wetPlant2FineAvgRes['AVG(moisture_rate)'];
    $wetPlant2FineAvgPlus70 = $wetPlant2FineAvgRes['AVG(plus_70)'];
    $wetPlant2FineAvgMinus40Plus70 = $wetPlant2FineAvgRes['AVG(minus_40_plus_70)'];
    $wetPlant2FineAvgMinus70 = $wetPlant2FineAvgRes['AVG(minus_70)'];
    $wetPlant2FineAvgMinus70Plus140 = $wetPlant2FineAvgRes['AVG(minus_70_plus_140)'];
    $wetPlant2FineAvgPlus140 = $wetPlant2FineAvgRes['AVG(plus_140)'];
    $wetPlant2FineAvgMinus140 = $wetPlant2FineAvgRes['AVG(minus_140)'];
  } 
 
//Calculating overall average and period differences
$wetPlant2FeedMoistureDiff = $wetPlant2FeedMoisture - $wetPlant2FeedAvgMoisture;
$wetPlant2FeedPlus70Diff = $wetPlant2FeedPlus70 - $wetPlant2FeedAvgPlus70;
$wetPlant2FeedMinus40Plus70Diff = $wetPlant2FeedMinus40Plus70 - $wetPlant2FeedAvgMinus40Plus70;
$wetPlant2FeedMinus70Diff = $wetPlant2FeedMinus70 - $wetPlant2FeedAvgMinus70;
$wetPlant2FeedMinus70Plus140Diff = $wetPlant2FeedMinus70Plus140 - $wetPlant2FeedAvgMinus70Plus140;
$wetPlant2FeedPlus140Diff = $wetPlant2FeedPlus140 - $wetPlant2FeedAvgPlus140;
$wetPlant2FeedMinus140Diff = $wetPlant2FeedMinus140 - $wetPlant2FeedAvgMinus140;

$wetPlant2CoarseMoistureDiff = $wetPlant2CoarseMoisture - $wetPlant2CoarseAvgMoisture;
$wetPlant2CoarsePlus70Diff = $wetPlant2CoarsePlus70 - $wetPlant2CoarseAvgPlus70;
$wetPlant2CoarseMinus40Plus70Diff = $wetPlant2CoarseMinus40Plus70 - $wetPlant2CoarseAvgMinus40Plus70;
$wetPlant2CoarseMinus70Diff = $wetPlant2CoarseMinus70 - $wetPlant2CoarseAvgMinus70;
$wetPlant2CoarseMinus70Plus140Diff = $wetPlant2CoarseMinus70Plus140 - $wetPlant2CoarseAvgMinus70Plus140;
$wetPlant2CoarsePlus140Diff = $wetPlant2CoarsePlus140 - $wetPlant2CoarseAvgPlus140;
$wetPlant2CoarseMinus140Diff = $wetPlant2CoarseMinus140 - $wetPlant2CoarseAvgMinus140;

$wetPlant2FineMoistureDiff = $wetPlant2FineMoisture - $wetPlant2FineAvgMoisture;
$wetPlant2FinePlus70Diff = $wetPlant2FinePlus70 - $wetPlant2FineAvgPlus70;
$wetPlant2FineMinus40Plus70Diff = $wetPlant2FineMinus40Plus70 - $wetPlant2FineAvgMinus40Plus70;
$wetPlant2FineMinus70Diff = $wetPlant2FineMinus70 - $wetPlant2FineAvgMinus70;
$wetPlant2FineMinus70Plus140Diff = $wetPlant2FineMinus70Plus140 - $wetPlant2FineAvgMinus70Plus140;
$wetPlant2FinePlus1140Diff = $wetPlant2FinePlus140 - $wetPlant2FineAvgPlus140;
$wetPlant2FineMinus140Diff = $wetPlant2FineMinus140 - $wetPlant2FineAvgMinus140;

$totalTons = 0;
$totalAvg = 0;
$totalAvgPerDay = 0;
$totalAvgPerHour = 0;

//========================================================================================== END PHP
?>


<!-- HTML -->
<h1>Plant Dashboard</h1>
<div  class="prod-datepicker">
  <form action='plantdashboard.php' method='post' >
    <input type='text' id='start-date' name='start-date' value="<?php echo $startDate; ?>">
    <strong>to</strong>
    <input type="text" name='end-date' id='end-date' value="<?php echo $endDate; ?>"> 
    <br>
    <select style="width:15%" name="operator-select">
      <option value=""></option>
      <?php 
        while($operatorRes = mysqli_fetch_assoc($operatorResults))
          {
            $operatorSel = $operatorRes['operator'];
            if($operatorSel == $operator)
              {
                echo ("<option selected='selected' value='{$operatorSel}'>{$operatorSel}</option>");
              }
            else
              {
                echo ("<option value='{$operatorSel}'>{$operatorSel}</option>");
              }
          }
      ?>
    </select>
    <input type="submit" value="Submit">
  </form>
</div>

<div id='hiddenTable'class='prodtable'>  
  <table>
    <thead>
      <tr>
        <th colspan="100%">Wet Plant 2</th>
      </tr>
      <tr>
        <th>&nbsp;</th>
        <th colspan="4">Tons</th>
        <th Colspan="3">Rate (Tons / Hour)</th>
        <th colspan="4">Grade (Actual)</th>
        <th colspan="4">Grade (Average)</th>
        <th colspan="4">Grade (Δ)</th>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php 
          echo (
                    "<td>{$wetPlant2FeedMoisture}</td>"
                  . "<td>{$wetPlant2FeedPlus70}</td>"
                  . "<td>{$wetPlant2FeedMinus70Plus140}</td>"
                  . "<td>{$wetPlant2FeedMinus140}</td>"
                  . "<td>{$wetPlant2FeedAvgMoisture}</td>"
                  . "<td>{$wetPlant2FeedAvgPlus70}</td>"
                  . "<td>{$wetPlant2FeedAvgMinus70Plus140}</td>"
                  . "<td>{$wetPlant2FeedAvgMinus140}</td>"
                  . "<td>{$wetPlant2FeedMoistureDiff}</td>"
                  . "<td>{$wetPlant2FeedPlus70Diff}</td>"
                  . "<td>{$wetPlant2FeedMinus70Plus140Diff}</td>"
                  . "<td>{$wetPlant2FeedMinus140Diff}</td>"
                );
        ?>
      </tr>
      <tr>
        <td>Coarse</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php 
          echo (
                    "<td>{$wetPlant2CoarseMoisture}</td>"
                  . "<td>{$wetPlant2CoarsePlus70}</td>"
                  . "<td>{$wetPlant2CoarseMinus70Plus140}</td>"
                  . "<td>{$wetPlant2CoarseMinus140}</td>"
                  . "<td>{$wetPlant2CoarseAvgMoisture}</td>"
                  . "<td>{$wetPlant2CoarseAvgPlus70}</td>"
                  . "<td>{$wetPlant2CoarseAvgMinus70Plus140}</td>"
                  . "<td>{$wetPlant2CoarseAvgMinus140}</td>"
                  . "<td>{$wetPlant2CoarseMoistureDiff}</td>"
                  . "<td>{$wetPlant2CoarsePlus70Diff}</td>"
                  . "<td>{$wetPlant2CoarseMinus70Plus140Diff}</td>"
                  . "<td>{$wetPlant2CoarseMinus140Diff}</td>"
                );
        ?>
      </tr>
      <tr>
        <td>Fine</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php 
          echo (
                    "<td>{$wetPlant2FineMoisture}</td>"
                  . "<td>{$wetPlant2FinePlus70}</td>"
                  . "<td>{$wetPlant2FineMinus70Plus140}</td>"
                  . "<td>{$wetPlant2FineMinus140}</td>"
                  . "<td>{$wetPlant2FineAvgMoisture}</td>"
                  . "<td>{$wetPlant2FineAvgPlus70}</td>"
                  . "<td>{$wetPlant2FineAvgMinus70Plus140}</td>"
                  . "<td>{$wetPlant2FineAvgMinus140}</td>"
                  . "<td>{$wetPlant2FineMoistureDiff}</td>"
                  . "<td>{$wetPlant2FinePlus70Diff}</td>"
                  . "<td>{$wetPlant2FineMinus70Plus140Diff}</td>"
                  . "<td>{$wetPlant2FineMinus140Diff}</td>"
                );
        ?>
      </tr>
    </tbody>
  </table>
</div>

<div class='prodtable' id="carrier-table">
  <table>
    <thead>
      <tr>
        <th colspan='100%'>Conveyor Belts</th>
      </tr>
      <tr>
        <th>Belt</th>
        <th>Total Tons</th>
        <th>Average Tons/Day</th>
        <th>Average Tons/Hr</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        
        while($conveyorTagRes = mysqli_fetch_assoc($conveyorTagsResults)) 
        {
          try
            {
               $conveyorTag = $conveyorTagRes['tag']; 
               $conveyorTotalAvgSQL = "CALL sp_gb_plc_ConveyorAvgTotalGet('"
                       . $conveyorTag . "','"
                       . $startDate . "','"
                       . $endDate . "','"
                       . $operator . "')"; 
              $conveyorTotalAvgResults = mysqli_query(dbmysqli(),$conveyorTotalAvgSQL);
            }
          catch(Exception $e)
            {
              echo("Error: " .  __LINE__ . " " .$e);
            }
          while($conveyor = $conveyorTotalAvgResults->fetch_assoc())
            { 
              $days = $conveyor['Days'];
              if($days<=0){$days =1;}
       
              $tons = $conveyor['TotalTons'];
              $avgPerDay = $tons/($days*2);//days*2 due to shift totals.
              $avgPerHour = $avgPerDay/48;
              
              $avgPerDayRound = round($avgPerDay,2);
              $avgPerHourRound = round($avgPerHour,2);
              
              $totalTons += $tons;
              $totalAvgPerDay += $avgPerDay;
              $totalAvgPerHour += $avgPerHour;
              
              $totalAvgPerDayRound = round($totalAvgPerDay,2);
              $totalAvgPerHourRound = round($totalAvgPerHour,2);
              
                echo
                  ("
                    <tr>
                    <td>{$conveyor['tag']}</td>
                    <td>{$tons}</td>
                    <td>{$avgPerDayRound}</td>
                    <td>{$avgPerHourRound}</td>
                    </tr>
                  ");
              }
            }
        echo("
            <tr>
            <td>TOTAL</td>
            <td>{$totalTons}</td>
            <td>{$totalAvgPerDayRound}</td>
            <td>{$totalAvgPerHourRound}</td>
            </tr>"); 
      ?>
    </tbody>
  </table>
</div>

<button style="width:10%" id="carrierExport"> Export Conveyor Data </button>

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