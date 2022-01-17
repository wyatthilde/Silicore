<?php

 /* * *****************************************************************************************************************************************
 * File Name: gb_sievesget.php
 * Project: Silicore
 * Description: This file returns the list of Sieves.
 * Notes: This gets called by sampleedit.php
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * ?/?/2017|mnutsch|KACE:xxxxx - Initial creation
 * 06/30/2017|mnutsch|KACE:xxxxx - Continued development.
 * 07/18/2017|mnutsch|KACE:17366 - Updated rounding of values.
 * 07/21/2017|mnutsch|KACE:17366 - Added an additional Sieve range calculation.
 * 07/25/2017|mnutsch|KACE:17366 - Corrected warnings during debugging.
 * 08/11/2017|mnutsch|KACE:17916 - Numerous updates.
 * 08/25/2017|mnutsch|KACE:17957 - Modified start weights to read from most recent start weight instead of from the sample.
 * 08/30/2017|mnutsch|KACE:17957 - Updated Delta weight row to hide or display dynamically based on if the sieve stack is a camsizer.
 * 09/14/2017|mnutsch|KACE:17959 - Fixed an error message which appeared when no Sieve Stack was selected.
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 11/02/2017|mnutsch|KACE:19025 - Added a call to the changeBlankSieveRangesToNA function.
 * 01/25/2018|mnutsch|KACE:20305 - Added the Near Size field.
 * 
 * **************************************************************************************************************************************** */
 
//==================================================================== BEGIN PHP
//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains database connection info
require_once('../../Includes/Security/database.php'); //contains database connection info

error_reporting(E_ERROR ^ E_WARNING);
//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode

if($debugging == 1)
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled - gb_sievesget.php</strong><br/>";  
}
//read the input values from the form
$stackId = test_input($_GET['stackId']);
$sampleId = test_input($_GET['sampleId']);

$database = new Database();
$is_complete_read = $database->get('sp_gb_qc_IsCompleteSampleGet("' . $sampleId . '");');
$is_complete_obj = json_decode($is_complete_read);
$is_complete = $is_complete_obj[0]->is_complete;

//get the sample details
if(strlen($sampleId)!=0)
{
  $sampleObject = getSampleById($sampleId);

  //decode the start weights and put them in an array
  $startWeightsArray = decodeWeights($sampleObject->vars['startWeightsRaw']);

  //decode the end weights and put them in an array
  $endWeightsArray = decodeWeights($sampleObject->vars['endWeightsRaw']);

  //decode the final weights and put them in an array
  $finalWeightsArray = decodeWeights($sampleObject->vars['finalWeightsRaw']);

  $AverageValues30Days = NULL;
  $AverageValues30Days = get30DayPercentAverages($sampleObject->vars['location']);

  $StandardDeviationValues30Days = NULL;
  $StandardDeviationValues30Days = get30DayPercentStandardDeviations($sampleObject->vars['location']);

}

//find out if the sieve stack is a camsizer or not
$thisSieveStackObject = NULL;
//echo "Sieve Stack ID is " . $stackId . "<br/>";
$thisSieveStackObject = getSieveStackById($stackId);
//echo "Sieve Stack is Camsizer? " . $thisSieveStackObject->vars["is_camsizer"] . "<br/>";

//This hidden input is used to make the value accessible to javascript in sampleedit.php
if($thisSieveStackObject != NULL)
{
  echo('<input type="hidden" id="isCamsizer" name="isCamsizer" value="' . $thisSieveStackObject->vars["is_camsizer"] . '"/>');
}
else
{
  echo('<input type="hidden" id="isCamsizer" name="isCamsizer" value="0"/>');
}
  
?>
<table class="table table-striped table-bordered table-responsive-xl">

<?php

echo "<thead class='table-header-vprop-blue-medium'><td>Screen Size</td><td>Start Weight</td><td>End Weight</td><td>Camsizer/Final Weight</td><td>Percent Final</td><td>30 Day Avg</td><td>30 Day Std</td></th></thead>";

$ObjectArray = getSievesByID($stackId); //get a list of site options
$objectCounter = 1;
$totalFinalWeight = 0;
$totalEndWeight = 0;
$totalStartWeight = 0;
$totalPercentFinal = "";

//var_dump($ObjectArray);
if($ObjectArray != NULL)
{
    foreach ($ObjectArray as $Object)
    {
      //if final weight is missing, then calculate it from the start and end weights
      if(isset($finalWeightsArray[$objectCounter - 1]))
      {
        if(strlen($finalWeightsArray[$objectCounter - 1]) == 0)
        {
          $finalWeightsArray[$objectCounter - 1] = $endWeightsArray[$objectCounter - 1] - $startWeightsArray[$objectCounter - 1];
          $finalWeightsArray[$objectCounter - 1] = round($finalWeightsArray[$objectCounter - 1],2);
        }
      }

      //find the appropriate start weight to use
      if(isset($startWeightsArray[$objectCounter - 1]))
      {
        //DEV NOTE: KACE # 17957, QC asked that we use the most recent start weights for that sieve rather than the value saved with the sample

          if($startWeightsArray[$objectCounter - 1] == 0)
          {
            $startWeight = $Object->vars["startWeight"];
          }
          else
          {
              if($is_complete == 0){
                  $startWeight = $Object->vars["startWeight"];
              } else {
                  $startWeight = $startWeightsArray[$objectCounter - 1];
              }
          }
        //$startWeight = $Object->vars["startWeight"];
      }

      if(isset($finalWeightsArray[$objectCounter - 1]))
      {
        $totalFinalWeight = $totalFinalWeight + $finalWeightsArray[$objectCounter - 1];
      }
      else
      {
        $totalFinalWeight = 0;
      }
      if(isset($endWeightsArray[$objectCounter - 1]))
      {
        $totalEndWeight = $totalEndWeight + $endWeightsArray[$objectCounter - 1];
      }
      else
      {
        $totalEndWeight = 0;
      }
      $totalStartWeight = $totalStartWeight + $startWeight;

      //echo "DEBUG: objectCounter = " . $objectCounter . "<br/>";
      //echo "DEBUG: description = " . $Object->vars["description"] . "<br/>";
      //echo "DEBUG: startWeight = " . $startWeight . "<br/>";

      //Read the array value into a temporary value to prevent error messages
      //endWeightsArray
      if(array_key_exists(($objectCounter - 1), $endWeightsArray))
      { 
        //echo "DEBUG: endWeight = " . $endWeightsArray[$objectCounter - 1] . "<br>"; 
        $tempEndWeight = $endWeightsArray[$objectCounter - 1];
      }
      else
      {
        $tempEndWeight = 0;
      }  

      //Read the array value into a temporary value to prevent error messages
      //finalWeightsArray
      if(array_key_exists(($objectCounter - 1), $finalWeightsArray))
      { 
        //echo "DEBUG: final weight = " . $finalWeightsArray[$objectCounter - 1] . "<br/>";
        $tempFinalWeight = $finalWeightsArray[$objectCounter - 1];
      }
      else
      {
        $tempFinalWeight = 0;
      }

      //Read the array value into a temporary value to prevent error messages
      //$AverageValues30Days[$objectCounter - 1]
      if(array_key_exists(($objectCounter - 1), $AverageValues30Days))
      { 
        //echo "DEBUG: final weight = " . $AverageValues30Days[$objectCounter - 1] . "<br/>";
        $tempAverageValue = $AverageValues30Days[$objectCounter - 1];
      }
      else
      {
        $tempAverageValue = 0;
      }

      //Read the array value into a temporary value to prevent error messages
      //$StandardDeviationValues30Days[$objectCounter - 1]
      if($StandardDeviationValues30Days != NULL)
      {
        if(array_key_exists(($objectCounter - 1), $StandardDeviationValues30Days))
        { 
          //echo "DEBUG: final weight = " . $StandardDeviationValues30Days[$objectCounter - 1] . "<br/>";
          $tempStandardDeviationValue = $StandardDeviationValues30Days[$objectCounter - 1];
        }
        else
        {
          $tempStandardDeviationValue = 0;
        }
      }
      else
      {
        $tempStandardDeviationValue = 0;
      }

      //format the values for output
      $tempStandardDeviationValue = round($tempStandardDeviationValue,2);
      $startWeight = round($startWeight,2);
      $tempEndWeight = round($tempEndWeight,2);
      $tempFinalWeight = round($tempFinalWeight,2);
      $tempAverageValue = (round($tempAverageValue,4) * 100);

      if($thisSieveStackObject->vars["is_camsizer"] == 1)
      {
        echo '
<tr>
<td>
    <input type="text" class="form-control" name="screenSize' . $objectCounter . '" id="' . ('screenSize' . $objectCounter) . '" value="' . $Object->vars["description"] . '" autocomplete="off" readonly>
</td>
<td>
    <input type="number" class="form-control" step="0.0001" max="9999999" id="startWeight' . $objectCounter . '" name="startWeight' . $objectCounter . '" value="' . $startWeight . '" disabled>
</td>
<td>
    <input type="number" class="form-control" step="0.0001" max="9999999" id="endWeight' . $objectCounter . '" name="endWeight' . $objectCounter . '" value="' . $tempEndWeight . '" disabled>
</td>
<td>
    <input type="number"  class="form-control sieveRequired" step="0.0001" max="9999999" id="finalWeight' . $objectCounter . '" name="finalWeight' . $objectCounter . '" value="' . $tempFinalWeight . '" onchange="calculateTotalFinalWeight(); calculateRates(); changeBlankSieveRangesToNA();">
</td>
<td>
    <input type="text" class="form-control" id="percentFinal' . $objectCounter . '" name="percentFinal' . $objectCounter . '" readonly></td>
<td>' . $tempAverageValue . '%</td>
<td>' . $tempStandardDeviationValue . '</td>
</tr>';
      }
      else
      {
        echo '
<tr>
<td>
<input type="text" class="form-control" name="screenSize' . $objectCounter . '" id="' . ('screenSize' . $objectCounter) . '"value="' . $Object->vars["description"] . '" autocomplete="off" readonly>
</td>
<td>
<input type="number" class="form-control sieveRequired" step="0.0001" max="9999999" id="startWeight' . $objectCounter . '" name="startWeight' . $objectCounter . '" value="' . $startWeight . '"  onchange="calculateFinalWeight(\'' . $objectCounter . '\'); calculateRates(); changeBlankSieveRangesToNA();">
</td>
<td>
<input type="number" class="form-control sieveRequired" step="0.0001" max="9999999" id="endWeight' . $objectCounter . '" name="endWeight' . $objectCounter . '" value="' . $tempEndWeight . '"  onchange="calculateFinalWeight(\'' . $objectCounter . '\'); calculateRates(); changeBlankSieveRangesToNA();">
</td>
<td>
<input type="number" class="form-control" step="0.0001" max="9999999" id="finalWeight' . $objectCounter . '" name="finalWeight' . $objectCounter . '" value="' . $tempFinalWeight . '" readonly>
</td>
<td>
<input type="text" class="form-control" id="percentFinal' . $objectCounter . '" name="percentFinal' . $objectCounter . '" readonly>
</td>
<td>' . $tempAverageValue . '%
</td>
<td>' . $tempStandardDeviationValue . '</td>
</tr>';
      }
      $objectCounter = $objectCounter + 1;
    }
}

$splitWeight = $sampleObject->vars['splitSampleWeight'];
$deltaWeight = $totalFinalWeight - $splitWeight;

?>

<tr/><td>Totals</td><td></td><td></td><td><input type="text" id="totalFinalWeight" class="form-control" name="totalFinalWeight" value="<?php echo $totalFinalWeight; ?>" readonly></td><td></td><td></td><td></td></th>
<tr/><td>Split Weight</td><td></td><td></td><td><input type="text" class="form-control" id="splitWeightSieve" name="splitWeightSieve" value="<?php echo $splitWeight; ?>" readonly></td></td><td></td><td></td><td></td></th>
<?php
if(isset($thisSieveStackObject->vars["is_camsizer"]))
{
  if($thisSieveStackObject->vars["is_camsizer"] != 1)
  {
    echo('<tr><td>&Delta;</td><td></td><td></td><td><input type="text" class="form-control" id="deltaWeight" name="deltaWeight" value="' . $deltaWeight. '" readonly></td></td><td></td><td></td><td></td></th>');
  }
}
?>
</table>
<style>

</style>
    <div class="form-row">
        <div class="form-group col-lg-1"></div>
        <div class="form-group col-lg-1">
            <label for="plus10">+10 (OS):</label>
            <input class="form-control" type="text" id="plus10" name="plus10" readonly>
        </div>
        <div class="form-group col-lg-1">
            <label for="plus40">-10 +40:</label>
            <input class="form-control" type="text" id="plus40" name="plus40" readonly>
        </div>
        <div class="form-group col-lg-1">
            <label for="neg40Plus70">-40 +70:</label>
            <input class="form-control" type="text" id="neg40Plus70" name="neg40Plus70" readonly>
        </div>
        <div class="form-group col-lg-1">
            <label for="neg60Plus70">-60 +70:</label>
            <input class="form-control" type="text" id="neg60Plus70" name="neg60Plus70" readonly>
        </div>
        <div class="form-group col-lg-1">
            <label for="neg70Plus140">-70 +140:</label>
            <input class="form-control" type="text" id="neg70Plus140" name="neg70Plus140" readonly>
    </div>
        <div class="form-group col-lg-1">
            <label for="neg50Plus140">-50 +140:</label>
            <input class="form-control" type="text" id="neg50Plus140" name="neg50Plus140" readonly>
        </div>
        <div class="form-group col-lg-1">
            <label for="nearSize">Near Size:</label>
            <input class="form-control" type="text" id="nearSize" name="nearSize" readonly>
            </div>
        <div class="form-group col-lg-1">
            <label for="neg140Plus325">-140 +325:</label>
            <input class="form-control" type="text" id="neg140Plus325" name="neg140Plus325" readonly>
        </div>

        <div class="form-group col-lg-1">
            <label for="neg140">-140:</label>
            <input class="form-control" type="text" id="neg140" name="neg140" readonly>
        </div>
        <div class="form-group col-lg-1"></div>

        </div>





    
<!-- This hidden input is used to make the value accessible to javascript in sampleedit.php -->
<input type="hidden" id="sieveCount" name="sieveCount" value="<?php echo $objectCounter; ?>"/>

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
 
//====================================================================== END PHP

?>