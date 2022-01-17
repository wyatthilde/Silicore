<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_performance.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 05/05/2017|mnutsch|KACE:xxxxx - Initial creation
 * 07/03/2017|mnutsch|KACE:17366 - Page content added
 * 07/05/2017|mnutsch|KACE:17366 - Continued development
 * 07/06/2017|mnutsch|KACE:17366 - Continued development
 * 07/10/2017|mnutsch|KACE:17366 - Continued development
 * 07/26/2017|mnutsch|KACE:17366 - Fixed bugs in chart functionality.
 * 08/11/2017|kkuehn|KACE:17915 - Changed hardcoded CSS color settings, code clean up
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 09/25/2017|mnutsch|KACE:17957 - Added individual contributor view.
 * 10/11/2017|mnutsch|KACE:19058 - Corrected an error caused by repeatability samples with not Sieve Stack.
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains qc database functions
require_once('../../Includes/security.php'); //contains user database functions

//used in downloading the Cycles table
$cyclesDownloadArray = NULL;
$cyclesDownloadArray[0] = "Plant,Lab Tech,Test,Avg Hrs (Tests),Retests,Misc Tests,Calibration Tests,Repeatability Tests";
$cyclesDownloadCount = 1;

//used in downloading the Repeatability table
$repeatabilityDownloadArray = NULL;
$repeatabilityDownloadArray[0] = "Lab Tech,Date/Time,Location,Sieve Stack,+70,30,40,45,50,60,70,80,100,120,140,200,PAN";
$repeatabilityDownloadCount = 1;

//used in filtering by date
$oneMonthPrior = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m")-1, date("d"), date("Y")));
$oneYearInTheFuture = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")+1));
$today = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")));
$startDate = "";
$endDate = "";

//used for storing data read from the database
$cyclesArray = NULL;
$repeatabilityArray = NULL;

//used in calculating Repeatability Averages
$total30 = 0;
$total40 = 0;
$total45 = 0;
$total50 = 0;
$total60 = 0;
$total70 = 0;
$total80 = 0;
$total100 = 0;
$total120 = 0;
$total140 = 0;
$total200 = 0;
$totalPAN = 0;
$totalPlus70 = 0;

//used in calculating Repeatability Averages
$countOfItems30 = 0;
$countOfItems40 = 0;
$countOfItems45 = 0;
$countOfItems50 = 0;
$countOfItems60 = 0;
$countOfItems70 = 0;
$countOfItems80 = 0;
$countOfItems100 = 0;
$countOfItems120 = 0;
$countOfItems140 = 0;
$countOfItems200 = 0;
$countOfItemsPAN = 0;
$countOfItemsPlus70 = 0;

//used in calculating Repeatability Averages
$average30 = 0;
$average40 = 0;
$average45 = 0;
$average50 = 0;
$average60 = 0;
$average70 = 0;
$average80 = 0;
$average100 = 0;
$average120 = 0;
$average140 = 0;
$average200 = 0;
$averagePAN = 0;
$averagePlus70 = 0;

//used in formatting data for the graphs
$sampleDate = NULL;
$sampleYear = NULL;
$sampleMonth = NULL;
$sampleDay = NULL;

$previousDate = NULL;
$arrayOfDatesObjects = NULL;
$countOfDateObjects = -1;

//read the REST variables
if(isset($_GET['startDate']) && strlen($_GET['startDate']) > 1)
{
  $startDate = urldecode(test_input($_GET['startDate']));
}
else
{
  $startDate = $oneMonthPrior;
}

if(isset($_GET['endDate']) && strlen($_GET['endDate']) > 1)
{
  $endDate = urldecode(test_input($_GET['endDate']));
}
else
{
  $endDate = $today;
}

$startYear = substr($startDate, 0, 4);
$startMonth = substr($startDate, 5, 2);
$startDay = substr($startDate, 8, 2);

$endYear = substr($endDate, 0, 4);
$endMonth = substr($endDate, 5, 2);
$endDay = substr($endDate, 8, 2);
/*
echo "DEBUG: startDate = " . $startDate . "<br/>";
echo "DEBUG: startYear = " . $startYear . "<br/>";
echo "DEBUG: startMonth = " . $startMonth . "<br/>";
echo "DEBUG: startDay = " . $startDay . "<br/>";

echo "DEBUG: endDate = " . $endDate . "<br/>";
echo "DEBUG: endYear = " . $endYear . "<br/>";
echo "DEBUG: endMonth = " . $endMonth . "<br/>";
echo "DEBUG: endDay = " . $endDay . "<br/>";
*/

//check if the signed in user is a labtech
$labTechArray = NULL;
$labTechArray = getLabTechs();
$userIsLabTech = 0;
for($i = 0; $i < count($labTechArray); $i++)
{
  //echo($labTechArray[$i]->vars['id'] . ". " . $labTechArray[$i]->vars['display_name'] . "<br/>");
  if($user_id == $labTechArray[$i]->vars['id'])
  {
    //echo("DEBUG: User is a labtech!<br/>");
    $userIsLabTech = 1;
  }
}

//if a REST variable with the labTech is set
if(isset($_GET['labTech']) && strlen($_GET['labTech']) > 0)
{
  $labTech = urldecode(test_input($_GET['labTech']));
  
  //read the data for the cycles table
  $cyclesArray = performanceCyclesGetByLabTech($startDate, $endDate, $labTech);
  
  //read the data for the repeatability table
  $repeatabilityArray = getRepeatabiltySamplePairsByLabTech($startDate, $endDate, $labTech);
  
  //read the data for the charts
  $samplesArray = getCompletedSamplesInDateRangeByLabTech($startDate, $endDate, $labTech);
}
else
{
  //if the user is a lab tech and their permission level is less than 3, then only show that user's info
  if(($userIsLabTech == 1) && ($userPermissionsArray['vista']['granbury']['qc'] < 3))
  {
    //read the data for the cycles table
    $cyclesArray = performanceCyclesGetByLabTech($startDate, $endDate, $user_id);

    //read the data for the repeatability table
    $repeatabilityArray = getRepeatabiltySamplePairsByLabTech($startDate, $endDate, $user_id);

    //read the data for the charts
    $samplesArray = getCompletedSamplesInDateRangeByLabTech($startDate, $endDate, $user_id);    
  }
  else
  {
    //read the data for the cycles table
    $cyclesArray = performanceCyclesGet($startDate, $endDate);

    //read the data for the repeatability table
    $repeatabilityArray = getRepeatabiltySamplePairs($startDate, $endDate);

    //read the data for the charts
    $samplesArray = getCompletedSamplesInDateRange($startDate, $endDate);
  }
}

?>

<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css"> 
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>

<script type="text/javascript" src="../../Includes/googleCharts/loader.js"></script> <!-- Google column charts -->

<div id="qc_groups" class="tabcontent">

<h3>QC Performance</h3>

<h4>Filters</h4>

<div class="form-group">
  <label for="start_date_filter">Start Date:</label>
  <input type="text" id="start_date_filter" name="start_date_filter" value="<?php echo($startDate); ?>" onchange="reloadPage();"/>
</div>
<br/>

<div class="form-group">
  <label for="end_date_filter">End Date:</label> 
  <input type="text" id="end_date_filter" name="end_date_filter" value="<?php echo($endDate); ?>" onchange="reloadPage();"/>
</div>
<br/>

<div class="form-group">
  <label for="lab_tech_filter">Lab Tech:</label>
  <select id="lab_tech_filter" name="lab_tech_filter" onchange="reloadPage();" required>
  <option value=""></option>
  <?php
  $userObjectArray = getLabTechs(); //get a list of users, requires security.php
  foreach ($userObjectArray as $userObject) 
  {
    if($labTech == $userObject->vars["id"])
    { 
      echo("<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>"); 
    }      
    else 
    { 
      if(($user_id != $userObject->vars["id"]) && ($userPermissionsArray['vista']['granbury']['qc'] < 3))
      {
        //do nothing
      }
      else
      {
        //display this option
        echo("<option value='" . $userObject->vars["id"] . "' >" . $userObject->vars["display_name"] . "</option>"); 
      }
    }       
  
  }
  ?>
  </select>
</div>
<br/>

<hr>
<h4>Cycles</h4>

<div class='cyclesTable'>
<table>
  <thead style="font-weight:bold">
    <tr><th colspan='9' style='text-align:center; background-color: #FFFFFF; color:black;'>Cycles</th></tr>
    <tr><th>Plant</th><th>Lab Tech</th><th>Tests</th><th>Avg Hrs (Tests)</th><th>Retests</th><th>Misc Tests</th><th>Calibration Tests</th><th>Repeatability Tests</th></tr>
  </thead>
  <tbody>
   
  <?php

    $subtotalCount = 0;
    $totalCount = 0;

    $testsSubtotal = 0;
    $retestsSubtotal = 0;
    $miscTestSubtotal = 0;
    $calibrationTestsSubtotal = 0;
    $repeatabilityTestsSubtotal = 0;
    $coreSampleTestsSubtotal = 0;
    $avgHoursSubtotal = 0;
    $avgHoursSubAvg = 0;

    $testsTotal = 0;
    $retestsTotal = 0;
    $miscTestTotal = 0;
    $calibrationTestsTotal = 0;
    $repeatabilityTestsTotal = 0;
    $coreSampleTestsTotal = 0;
    $avgHoursTotal = 0;
    $avgHoursTotalAvg = 0;

    $previousPlant = 0;

    for ($i = 0; $i < count($cyclesArray); $i++) 
    {
      $userObject = getUser($cyclesArray[$i]->vars['lab_tech_id']); //get user by id, requires security.php
      $plantObject = getPlantById($cyclesArray[$i]->vars['plant_id']);

      if($cyclesArray[$i]->vars['plant_id'] != $previousPlant)
      {
        if($subtotalCount != 0)
        {
          $avgHoursSubAvg = 0;
          if($subtotalCount > 0)
          {  
            $avgHoursSubAvg = round(($avgHoursSubtotal / $subtotalCount), 2);
          }
          echo("<tr style='font-weight:bold; background-color: var(--vprop_blue_light);'>
                  <td>Subtotal</td>
                  <td></td>
                  <td>" . $testsSubtotal . "</td>
                  <td>" . $avgHoursSubAvg . "</td>
                  <td>" . $retestsSubtotal . "</td>
                  <td>" . $miscTestSubtotal . "</td>
                  <td>" . $calibrationTestsSubtotal . "</td>
                  <td>" . $repeatabilityTestsSubtotal . "</td>
                </tr>");

          $cyclesDownloadArray[$cyclesDownloadCount] = "Subtotal,," . $testsSubtotal . "," . $avgHoursSubAvg . "," . $retestsSubtotal . "," . $miscTestSubtotal . "," . $calibrationTestsSubtotal . "," . $repeatabilityTestsSubtotal;
          $cyclesDownloadCount += 1;
        }

        //reset the subtotal values
        $testsSubtotal = 0;
        $retestsSubtotal = 0;
        $miscTestSubtotal = 0;
        $calibrationTestsSubtotal = 0;
        $repeatabilityTestsSubtotal = 0;
        $coreSampleTestsSubtotal = 0;
        $avgHoursSubtotal = 0;

        $subtotalCount += 1;
        $totalCount += 1;
      }

      //increase the subtotal values
      $testsSubtotal += $cyclesArray[$i]->vars['test_count'];
      $retestsSubtotal += $cyclesArray[$i]->vars['retest_count'];
      $miscTestSubtotal += $cyclesArray[$i]->vars['misc_count'];
      $calibrationTestsSubtotal += $cyclesArray[$i]->vars['calibration_count'];
      $repeatabilityTestsSubtotal += $cyclesArray[$i]->vars['repeatability_count'];
      $avgHoursSubtotal = $avgHoursSubtotal + $cyclesArray[$i]->vars['avg_hours'];

      //increase the total values
      $testsTotal += $cyclesArray[$i]->vars['test_count'];
      $retestsTotal += $cyclesArray[$i]->vars['retest_count'];
      $miscTestTotal += $cyclesArray[$i]->vars['misc_count'];
      $calibrationTestsTotal += $cyclesArray[$i]->vars['calibration_count'];
      $repeatabilityTestsTotal += $cyclesArray[$i]->vars['repeatability_count'];
      $avgHoursTotal = $avgHoursTotal + $cyclesArray[$i]->vars['avg_hours'];

      if(isset($userObject->vars["display_name"]))
      {
        $userObjectDisplayName = $userObject->vars["display_name"];
      }
      else
      {
        $userObjectDisplayName = "";
      }
      
      //<tr><td>placeholder-plant</td><td>placeholder-lab tech</td><td>placeholder-tests</td><td>placeholder-avg hrs</td><td>placeholder-retests</td><td>placeholder-misc tests</td><td>placeholder-calibration test</td><td>placeholder-repeatability tests</td><td>placeholder-core sample tests</td></tr>
      echo("<tr>
              <td>" . $plantObject->vars["name"] . "</td>
              <td>" . $userObjectDisplayName . "</td>
              <td>" . $cyclesArray[$i]->vars['test_count'] . "</td>
              <td>" . round($cyclesArray[$i]->vars['avg_hours'],2) . "</td>
              <td>" . $cyclesArray[$i]->vars['retest_count'] . "</td>
              <td>" . $cyclesArray[$i]->vars['misc_count'] . "</td>
              <td>" . $cyclesArray[$i]->vars['calibration_count'] . "</td>
              <td>" . $cyclesArray[$i]->vars['repeatability_count'] . "</td>
            </tr>");
      
      $cyclesDownloadArray[$cyclesDownloadCount] = $plantObject->vars["name"] . "," . $userObjectDisplayName . "," . $cyclesArray[$i]->vars['test_count'] . "," . round($cyclesArray[$i]->vars['avg_hours'],2) . "," . $cyclesArray[$i]->vars['retest_count'] . "," . $cyclesArray[$i]->vars['misc_count'] . "," . $cyclesArray[$i]->vars['calibration_count'] . "," . $cyclesArray[$i]->vars['repeatability_count'];
      $cyclesDownloadCount += 1;
      
      $previousPlant = $cyclesArray[$i]->vars['plant_id'];
    } 

    //output the last subtotal row
    $avgHoursSubAvg = 0;
    if($subtotalCount > 0)
    {  
      $avgHoursSubAvg = round(($avgHoursSubtotal / $subtotalCount), 2);
    }
    echo("<tr style='font-weight:bold; background-color: var(--vprop_blue_light);'>
            <td>Subtotal</td>
            <td></td>
            <td>" . $testsSubtotal . "</td>
            <td>" . $avgHoursSubAvg . "</td>
            <td>" . $retestsSubtotal . "</td>
            <td>" . $miscTestSubtotal . "</td>
            <td>" . $calibrationTestsSubtotal . "</td>
            <td>" . $repeatabilityTestsSubtotal . "</td>
          </tr>");
    $cyclesDownloadArray[$cyclesDownloadCount] = "Subtotal,," . $testsSubtotal . "," . $avgHoursSubAvg . "," . $retestsSubtotal . "," . $miscTestSubtotal . "," . $calibrationTestsSubtotal . "," . $repeatabilityTestsSubtotal;
    $cyclesDownloadCount += 1;
        
  echo("</tbody>");
  echo("<tfoot>");
  
    //output the total row
    $avgHoursTotalAvg = 0;
    if($totalCount > 0)
    {  
      $avgHoursTotalAvg = round(($avgHoursTotal / $totalCount), 2);
    }
    echo("<tr style='font-weight:bold; background-color: var(--vprop_blue_medium); color: #FFFFFF;'>
            <td>Total</td><td></td><td>" . $testsTotal . "</td>
            <td>" . $avgHoursTotalAvg . "</td>
            <td>" . $retestsTotal . "</td>
            <td>" . $miscTestTotal . "</td>
            <td>" . $calibrationTestsTotal . "</td>
            <td>" . $repeatabilityTestsTotal . "</td>
          </tr>");
    $cyclesDownloadArray[$cyclesDownloadCount] = "Total,," . $testsTotal . "," . $avgHoursTotalAvg . "," . $retestsTotal . "," . $miscTestTotal . "," . $calibrationTestsTotal . "," . $repeatabilityTestsTotal;
    $cyclesDownloadCount += 1;
    ?>
  </tfoot>
  </tr>
</table>
</div> <!-- cyclesTable -->

<br/>

<form action="fileDownload.php" method="post">
<?php 
//echo "DEBUG: cyclesDownloadArray = " . var_Dump($cyclesDownloadArray) . "<br/>";
foreach($cyclesDownloadArray as $value)
{
  echo('<input type="hidden" name="contentStringArray[]" value="'. $value. '">');
}
?>
<input type="submit" value="Export Cycles to Excel">
</form>

<br/><br/>

<hr>
<h4>Repeatability</h4>

<div class='repeatabilityTable'>
<table>
  <thead>
    <tr><th colspan='17' style='text-align:center; background-color: #FFFFFF; color:black;'>Repeatability</th></tr>
    <tr><th>Lab Tech</th><th>Date /Time</th><th>Location</th><th>Sieve Stack</th><th>+70 &Delta;</th><th>30 &Delta;</th><th>40 &Delta;</th><th>45 &Delta;</th><th>50 &Delta;</th><th>60 &Delta;</th><th>70 &Delta;</th><th>80 &Delta;</th><th>100 &Delta;</th><th>120 &Delta;</th><th>140 &Delta;</th><th>200 &Delta;</th><th>PAN &Delta;</th></tr>
  </thead>
  <tbody>
   
  <?php
  
    for ($i = 0; $i < count($repeatabilityArray); $i++) 
    {
      $userObject = getUser($repeatabilityArray[$i]->vars['lab_tech']); //get user by id, requires security.php
      $locationObject = getLocationById($repeatabilityArray[$i]->vars['location']);
      $sieveStackObject = getSieveStackById($repeatabilityArray[$i]->vars['sieve_stack']);
      
      if(isset($sieveStackObject))
      {
        $sieveStackDescription = $sieveStackObject->vars['description'];
      }
      else
      {
        $sieveStackDescription = "";
      }
      
      echo("<tr>
              <td>" . $userObject->vars["display_name"] . "</td>
              <td>" . $repeatabilityArray[$i]->vars['datetime'] . "</td>
              <td>" . $locationObject->vars['description'] . "</td>
              <td>" . $sieveStackDescription . "</td>
              <td>" . (round($repeatabilityArray[$i]->vars['differencePlus70'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference30'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference40'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference45'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference50'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference60'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference70'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference80'],4) * 100) . "</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference100'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference120'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference140'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['difference200'],4) * 100) . "%</td>
              <td>" . (round($repeatabilityArray[$i]->vars['differencePAN'],4) * 100) . "%</td>");

      $repeatabilityDownloadArray[$repeatabilityDownloadCount] = $userObject->vars["display_name"] . "," . $repeatabilityArray[$i]->vars['datetime'] . "," . $locationObject->vars['description'] . "," . $sieveStackDescription . "," . (round($repeatabilityArray[$i]->vars['differencePlus70'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference30'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference40'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference45'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference50'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference60'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference70'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference80'],4) * 100) . "," . (round($repeatabilityArray[$i]->vars['difference100'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference120'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['difference140'],4) * 100) . "%</td><td>" . (round($repeatabilityArray[$i]->vars['difference200'],4) * 100) . "%," . (round($repeatabilityArray[$i]->vars['differencePAN'],4) * 100) . "%";
      $repeatabilityDownloadCount += 1;
    
      //increase the counts
      if($repeatabilityArray[$i]->vars['difference30'] != 0){ $countOfItems30++; }
      if($repeatabilityArray[$i]->vars['difference40'] != 0){ $countOfItems40++; }
      if($repeatabilityArray[$i]->vars['difference45'] != 0){ $countOfItems45++; }
      if($repeatabilityArray[$i]->vars['difference50'] != 0){ $countOfItems50++; }
      if($repeatabilityArray[$i]->vars['difference60'] != 0){ $countOfItems60++; }
      if($repeatabilityArray[$i]->vars['difference70'] != 0){ $countOfItems70++; }
      if($repeatabilityArray[$i]->vars['difference80'] != 0){ $countOfItems80++; }
      if($repeatabilityArray[$i]->vars['difference100'] != 0){ $countOfItems100++; }
      if($repeatabilityArray[$i]->vars['difference120'] != 0){ $countOfItems120++; }
      if($repeatabilityArray[$i]->vars['difference140'] != 0){ $countOfItems140++; }
      if($repeatabilityArray[$i]->vars['difference200'] != 0){ $countOfItems200++; }
      if($repeatabilityArray[$i]->vars['differencePAN'] != 0){ $countOfItemsPAN++; }
      if($repeatabilityArray[$i]->vars['differencePlus70'] != 0){ $countOfItemsPlus70++; }
      
      //increase the totals  
      if($repeatabilityArray[$i]->vars['difference30'] != 0){ $total30 += $repeatabilityArray[$i]->vars['difference30']; }
      if($repeatabilityArray[$i]->vars['difference40'] != 0){ $total40 += $repeatabilityArray[$i]->vars['difference40']; }
      if($repeatabilityArray[$i]->vars['difference45'] != 0){ $total45 += $repeatabilityArray[$i]->vars['difference45']; }
      if($repeatabilityArray[$i]->vars['difference50'] != 0){ $total50 += $repeatabilityArray[$i]->vars['difference50']; }
      if($repeatabilityArray[$i]->vars['difference60'] != 0){ $total60 += $repeatabilityArray[$i]->vars['difference60']; }
      if($repeatabilityArray[$i]->vars['difference70'] != 0){ $total70 += $repeatabilityArray[$i]->vars['difference70']; }
      if($repeatabilityArray[$i]->vars['difference80'] != 0){ $total80 += $repeatabilityArray[$i]->vars['difference80']; }
      if($repeatabilityArray[$i]->vars['difference100'] != 0){ $total100 += $repeatabilityArray[$i]->vars['difference100']; }
      if($repeatabilityArray[$i]->vars['difference120'] != 0){ $total120 += $repeatabilityArray[$i]->vars['difference120']; }
      if($repeatabilityArray[$i]->vars['difference140'] != 0){ $total140 += $repeatabilityArray[$i]->vars['difference140']; }
      if($repeatabilityArray[$i]->vars['difference200'] != 0){ $total200 += $repeatabilityArray[$i]->vars['difference200']; }
      if($repeatabilityArray[$i]->vars['differencePAN'] != 0){ $totalPAN += $repeatabilityArray[$i]->vars['differencePAN']; }
      if($repeatabilityArray[$i]->vars['differencePlus70'] != 0){ $totalPlus70 += $repeatabilityArray[$i]->vars['differencePlus70']; }
        
    }
  
    //calculate the new averages
    if($countOfItems30 > 0){ $average30 = $total30 / $countOfItems30; }
    if($countOfItems40 > 0){ $average40 = $total40 / $countOfItems40; }
    if($countOfItems45 > 0){ $average45 = $total45 / $countOfItems45; }
    if($countOfItems50 > 0){ $average50 = $total50 / $countOfItems50; }
    if($countOfItems60 > 0){ $average60 = $total60 / $countOfItems60; }
    if($countOfItems70 > 0){ $average70 = $total70 / $countOfItems70; }
    if($countOfItems80 > 0){ $average80 = $total80 / $countOfItems80; }
    if($countOfItems100 > 0){ $average100 = $total100 / $countOfItems100; }
    if($countOfItems120 > 0){ $average120 = $total120 / $countOfItems120; }
    if($countOfItems140 > 0){ $average140 = $total140 / $countOfItems140; }
    if($countOfItems200 > 0){ $average200 = $total200 / $countOfItems200; }
    if($countOfItemsPAN > 0){ $averagePAN = $totalPAN / $countOfItemsPAN; }
    if($countOfItemsPlus70 > 0){ $averagePlus70 = $totalPlus70 / $countOfItemsPlus70; }
    
    echo("</tbody>");
    echo("<tfooter>");

    echo("<tr>
            <td>Averages</td>
            <td colspan='3'></td>
            <td>" . (round($averagePlus70,4) * 100) . "%</td>
            <td>" . (round($average30,4) * 100) . "%</td>
            <td>" . (round($average40,4) * 100) . "%</td>
            <td>" . (round($average45,4) * 100) . "%</td>
            <td>" . (round($average50,4) * 100) . "%</td>
            <td>" . (round($average60,4) * 100) . "%</td>
            <td>" . (round($average70,4) * 100) . "%</td>
            <td>" . (round($average80,4) * 100) . "%</td>
            <td>" . (round($average100,4) * 100) . "%</td>
            <td>" . (round($average120,4) * 100) . "%</td>
            <td>" . (round($average140,4) * 100) . "%</td>
            <td>" . (round($average200,4) * 100) . "%</td>
            <td>" . (round($averagePAN,4) * 100) . "%</td>
          </tr>");
    
    $repeatabilityDownloadArray[$repeatabilityDownloadCount] = "Averages,,,," . (round($averagePlus70,4) * 100) . "%," . (round($average30,4) * 100) . "%," . (round($average40,4) * 100) . "%," . (round($average45,4) * 100) . "%," . (round($average50,4) * 100) . "%," . (round($average60,4) * 100) . "%," . (round($average70,4) * 100) . "%," . (round($average80,4) * 100) . "%," . (round($average100,4) * 100) . "%," . (round($average120,4) * 100) . "%," . (round($average140,4) * 100) . "%," . (round($average200,4) * 100) . "%," . (round($averagePAN,4) * 100) . "%";
    $repeatabilityDownloadCount += 1;
    
    echo("</tfooter>");
    echo("</tr>");
    echo("</table>");
  
  ?>
    
  
</div>  <!-- repeatabilityTable -->

<br/>

<form action="fileDownload.php" method="post">
<?php 
foreach($repeatabilityDownloadArray as $value)
{
  echo('<input type="hidden" name="contentStringArray[]" value="'. $value. '">');
}
?>
<input type="submit" value="Export Repeatability to Excel">
</form>

<br/><br/>

<hr>

<div style="width: 100%;">
  <div id="chart_div_day" style="float: left; width: 450px; height: 300px;"></div>

  <div id="chart_div_night" style="float: left; width: 450px; height: 300px;"></div>
</div>
<br/>
<div style="clear: left;">
  <hr>
  <br/>
  <input type="button" value="Refresh Page" onClick="window.location.reload()"> <br/><br/>
</div>
</div> <!-- tab content -->

<script>
//call JQuery to render the datepicker tool
$(function() 
{
  $("#start_date_filter").datetimepicker(
  {
    format: 'Y-m-d H:i',
    //dateFormat: 'yy-mm-dd',
    onSelect: function(datetext)
    {
      var d = new Date(); // for now
      
      var h = d.getHours();
      h = (h < 10) ? ("0" + h) : h ;
    
      var m = d.getMinutes();
      m = (m < 10) ? ("0" + m) : m ;
      
      var s = d.getSeconds();
      s = (s < 10) ? ("0" + s) : s ;
      
      datetext = datetext + " " + h + ":" + m + ":" + s;
      $('#start_date_filter').val(datetext);
    },
  });
  
  $("#end_date_filter").datetimepicker(
  {
    format: 'Y-m-d H:i',
    //dateFormat: 'yy-mm-dd',
    onSelect: function(datetext)
    {
      var d = new Date(); // for now
      
      var h = d.getHours();
      h = (h < 10) ? ("0" + h) : h ;
    
      var m = d.getMinutes();
      m = (m < 10) ? ("0" + m) : m ;
      
      var s = d.getSeconds();
      s = (s < 10) ? ("0" + s) : s ;
      
      datetext = datetext + " " + h + ":" + m + ":" + s;
      $('#end_date_filter').val(datetext);
    },
  });
});
</script>
<script type="text/javascript">
function reloadPage()
{
  var startDate = document.getElementById('start_date_filter').value;
  startDate = encodeURI(startDate);

  var endDate = document.getElementById('end_date_filter').value;
  endDate = encodeURI(endDate);
  
  var labTech = document.getElementById('lab_tech_filter').value;
  labTech = encodeURI(labTech);

  window.location='gb_performance.php?startDate=' + startDate + '&endDate=' + endDate + '&labTech=' + labTech;
}
</script>
<?php
  $previousDate = NULL;
  $arrayOfDatesObjects_Night = NULL;
  $countOfDateObjects = 0;
  $arrayOfDatesObjects[0]->vars['testSampleCount'] = 0;
  $arrayOfDatesObjects[0]->vars['allSampleCount'] = 0;
  $countOfDateObjects_Night = 0;
  $arrayOfDatesObjects_Night[0]->vars['testSampleCount'] = 0;
  $arrayOfDatesObjects_Night[0]->vars['allSampleCount'] = 0;
  
  $dayShiftStartTime = "06:00:00";
  $nightShiftStartTime = "18:00:00";
  
  //DEV NOTE: $samplesArray is read at the top of the page in different ways based on whether or not a lab tech is specified
    
  //loop through all samples selected in the date range to get the DAY Shift information
  $previousDate = NULL;
  $arrayOfDatesObjects = NULL;
  $countOfDateObjects = 0;
  $arrayOfDatesObjects[0]->vars['testSampleCount'] = 0;
  $arrayOfDatesObjects[0]->vars['allSampleCount'] = 0;
  //echo "DEBUG: Day Shift data<br/>";
  //echo "DEBUG: samplesArray count = " . count($samplesArray) . "<br/>";
  for ($i = 0; $i < count($samplesArray); $i++) 
  {
    //if this sample is in the day shift time range
    if(($samplesArray[$i]->vars['time'] >= $dayShiftStartTime) && ($samplesArray[$i]->vars['time'] < $nightShiftStartTime))
    {
      $sampleDate = $samplesArray[$i]->vars['date'];

      //if this is a new date then
        //add the date to the graph array
        //initialize the counts
      if($samplesArray[$i]->vars['date'] != $previousDate)
      {
        //echo "DEBUG: new date found<br/>";
        //echo "DEBUG: sampleDate = " . $sampleDate . "<br/>";
        $countOfDateObjects++; 
        $arrayOfDatesObjects[$countOfDateObjects]->vars['date'] = $samplesArray[$i]->vars['date'];
        $arrayOfDatesObjects[$countOfDateObjects]->vars['testSampleCount'] = 0;
        $arrayOfDatesObjects[$countOfDateObjects]->vars['allSampleCount'] = 0;
        //$arrayOfDatesObjects[$countOfDateObjects]->vars['testType'] = $samplesArray[$i]->vars['testType'];
        $previousDate = $sampleDate;
      }

      //echo "DEBUG: date = " . $samplesArray[$i]->vars['date'] . "; testType = " . $samplesArray[$i]->vars['testType'] . "; time = " . $samplesArray[$i]->vars['time'] . "<br/>";

      //increase the All samples count (AKA countOfDateObjects)
      $arrayOfDatesObjects[$countOfDateObjects]->vars['allSampleCount']++;

      //if the test type is Test then increase the Test samples count
      if($samplesArray[$i]->vars['testType'] == "2")
      {
        //echo "DEBUG: Test found!<br/>";
        $arrayOfDatesObjects[$countOfDateObjects]->vars['testSampleCount']++;
      }
    } //end getting the samples for the DAY Shift
  }
  
  //loop through all samples selected in the date range to get the NIGHT Shift information
  $previousDate = NULL;
  $arrayOfDatesObjects_Night = NULL;
  $countOfDateObjects_Night = 0;
  $arrayOfDatesObjects_Night[0]->vars['testSampleCount'] = 0;
  $arrayOfDatesObjects_Night[0]->vars['allSampleCount'] = 0;
  //echo "DEBUG: Night Shift data<br/>";
  for ($i = 0; $i < count($samplesArray); $i++) 
  {    
    //if this sample is in the day shift time range
    if(($samplesArray[$i]->vars['time'] >= $nightShiftStartTime) || ($samplesArray[$i]->vars['time'] < $dayShiftStartTime))
    {      
      //echo "DEBUG: This sample is in the night shift<br/>";
      
      $sampleDate = $samplesArray[$i]->vars['date'];

      //if this is a new date then
        //add the date to the graph array
        //initialize the counts
      if($samplesArray[$i]->vars['date'] != $previousDate)
      {
        //echo "DEBUG: new date found<br/>";
        //echo "DEBUG: sampleDate = " . $sampleDate . "<br/>";
        $countOfDateObjects_Night++; 
        $arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['date'] = $samplesArray[$i]->vars['date'];
        $arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['testSampleCount'] = 0;
        $arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['allSampleCount'] = 0;
        //$arrayOfDatesObjects[$countOfDateObjects]->vars['testType'] = $samplesArray[$i]->vars['testType'];
        $previousDate = $sampleDate;
      }

      //echo "DEBUG: id = " . $samplesArray[$i]->vars['id'] . "; date = " . $samplesArray[$i]->vars['date'] . "; testType = " . $samplesArray[$i]->vars['testType'] . "; time = " . $samplesArray[$i]->vars['time'] . "<br/>";

      //increase the All samples count (AKA countOfDateObjects)
      $arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['allSampleCount']++;
      //echo "DEBUG: arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['allSampleCount']; = " . $arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['allSampleCount'] . "<br/>";

      //if the test type is Test then increase the Test samples count
      if($samplesArray[$i]->vars['testType'] == "2")
      {
        //echo "DEBUG: Test found!<br/>";
        $arrayOfDatesObjects_Night[$countOfDateObjects_Night]->vars['testSampleCount']++;
      }
    } //end getting the samples for the NIGHT Shift
  }
  
?>
<script>
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() 
{
  var data = new google.visualization.DataTable();
  data.addColumn('date', 'Date of Sample');
  data.addColumn('number', 'Tests');
  data.addColumn('number', 'All');

<?php
  echo("data.addRows([");
  if(count($arrayOfDatesObjects) > 1)
  {
    for ($i = 1; $i < count($arrayOfDatesObjects); $i++) 
    {
      if(isset($arrayOfDatesObjects[$i]))
      {
        $sampleDate = $arrayOfDatesObjects[$i]->vars['date'];

        $sampleYear = substr($sampleDate, 0, 4);
        $sampleMonth = substr($sampleDate, 5, 2) - 1;
        $sampleDay = substr($sampleDate, 8, 2);
        echo("[new Date(" . $sampleYear . ", " . $sampleMonth . ", " . $sampleDay . "), " . $arrayOfDatesObjects[$i]->vars['testSampleCount'] . ", " . $arrayOfDatesObjects[$i]->vars['allSampleCount'] . "],");
      }
    }   
  }
  echo("]);");
?>
      
  var options = {
    title: 'Sample Counts - Day Shift',
    width: 450, height: 300,
    hAxis: {
      title: 'Date of Samples',

    },
    vAxis: {
      title: 'Number of Samples'
    }
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_day'));

  chart.draw(data, options);

  /********************************************************************/

  var data_night = new google.visualization.DataTable();
  data_night.addColumn('date', 'Date of Sample');
  data_night.addColumn('number', 'Tests');
  data_night.addColumn('number', 'All');

<?php
  echo("data_night.addRows([");
  if(count($arrayOfDatesObjects_Night) > 1)
  {
    for ($i = 1; $i < count($arrayOfDatesObjects_Night); $i++) 
    {
      if(isset($arrayOfDatesObjects_Night[$i]))
      {
        $sampleDate = $arrayOfDatesObjects_Night[$i]->vars['date'];

        $sampleYear = substr($sampleDate, 0, 4);
        $sampleMonth = substr($sampleDate, 5, 2) - 1;
        $sampleDay = substr($sampleDate, 8, 2);
        echo("[new Date(" . $sampleYear . ", " . $sampleMonth . ", " . $sampleDay . "), " . $arrayOfDatesObjects_Night[$i]->vars['testSampleCount'] . ", " . $arrayOfDatesObjects_Night[$i]->vars['allSampleCount'] . "],");
      }
    }
  }
  echo("]);");
?>

  var options_night = {
    title: 'Sample Counts - Night Shift',
    width: 450, height: 300,
    hAxis: {
      title: 'Date of Samples',

    },
    vAxis: {
      title: 'Number of Samples'
    }
  };

  var chart_night = new google.visualization.ColumnChart(document.getElementById('chart_div_night'));

  chart_night.draw(data_night, options_night);
    
}
</script>

<?php
/***************************************
* Name: function test_input($data) 
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
****************************************/
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!-- HTML -->






