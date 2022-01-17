<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_samplereversevoid.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/04/2018|mnutsch|KACE:20158 - Initial creation
 * 
 * **************************************************************************************************************************************** */

//============================================================================== BEGIN PHP

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
{
  echo "The current Linux user is: ";
  echo exec('whoami');
  echo "<br/>";
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled</strong><br/>";  
  echo "Start time: ";
  echo(date("Y-m-d H:i:s",$t));
  echo "<br/>";
}

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains QC database query functions

//check if the completion status variable was passed in the URL
if(isset($_GET['completionStatus']) && strlen($_GET['completionStatus']) > 0)
{
  $completionStatus = urldecode(test_input($_GET['completionStatus']));
}

//check if the starting date variable was passed in the URL
if(isset($_GET['startDate']) && strlen($_GET['startDate']) > 1)
{
  $startDate = urldecode(test_input($_GET['startDate']));
}
else
{
  //$startDate = $dateTwoWeeksPrior;
  $startDate = $dateYesterday;  
}

//check if the end date variable was passed in the URL
if(isset($_GET['endDate']) && strlen($_GET['endDate']) > 1)
{
  $endDate = urldecode(test_input($_GET['endDate']));
}
else
{
  $endDate = $oneYearInTheFuture;
}

//check if the starting row variable was passed in the URL
if (!isset($_GET['startRow']) or !is_numeric($_GET['startRow'])) 
{
  //we give the value of the starting row to 0 because nothing was found in URL
  $startRow = 0;  
} 
else //otherwise we take the value from the URL
{
  $startRow = (int)$_GET['startRow'];
}
//output a hidden input with this value, so that JavaScript can pick it up  
echo('<input type="hidden" id="startRow" name="startRow" value="' . $startRow . '">');

//check if the results per page variable was passed in the URL
if (!isset($_GET['resultsPerPage']) or !is_numeric($_GET['resultsPerPage'])) 
{
  $resultsPerPage = 50;
} 
else 
{
  $resultsPerPage = (int)$_GET['resultsPerPage'];
}

//composite_type_filter
if(isset($_GET['compositeType']) && strlen($_GET['compositeType']) > 0)
{
  $compositeType = urldecode(test_input($_GET['compositeType']));
}

//shift_filter
if(isset($_GET['shift']) && strlen($_GET['shift']) > 0)
{
  $shift = urldecode(test_input($_GET['shift']));
}

//sampler_filter
if(isset($_GET['sampler']) && strlen($_GET['sampler']) > 0)
{
  $sampler = urldecode(test_input($_GET['sampler']));
}

//operator_filter
if(isset($_GET['operator']) && strlen($_GET['operator']) > 0)
{
  $operator = urldecode(test_input($_GET['operator']));
}

//view_filter
if(isset($_GET['view']) && strlen($_GET['view']) > 0)
{
  $view = urldecode(test_input($_GET['view']));
}

//void_filter
if(isset($_GET['void']) && strlen($_GET['void']) > 0)
{
  $void = urldecode(test_input($_GET['void']));
}

//is_coa_filter
if(isset($_GET['isCOA']) && strlen($_GET['isCOA']) > 0)
{
  $isCOA = urldecode(test_input($_GET['isCOA']));
}

//get the location values
if(isset($_GET['locationsRESTString']) && strlen($_GET['locationsRESTString']) > 0)
{
  $locationsRESTString = urldecode(test_input($_GET['locationsRESTString']));
}

//get the test type values
if(isset($_GET['testTypesRESTString']) && strlen($_GET['testTypesRESTString']) > 0)
{
  $testTypesRESTString = urldecode(test_input($_GET['testTypesRESTString']));
}

//get the lab tech values
if(isset($_GET['labTechsRESTString']) && strlen($_GET['labTechsRESTString']) > 0)
{
  $labTechsRESTString = urldecode(test_input($_GET['labTechsRESTString']));
}

//get the site values
if(isset($_GET['sitesRESTString']) && strlen($_GET['sitesRESTString']) > 0)
{
  $sitesRESTString = urldecode(test_input($_GET['sitesRESTString']));
}

//get the plant values
if(isset($_GET['plantsRESTString']) && strlen($_GET['plantsRESTString']) > 0)
{
  $plantsRESTString = urldecode(test_input($_GET['plantsRESTString']));
}

//get the specificLocation values
if(isset($_GET['specificLocationsRESTString']) && strlen($_GET['specificLocationsRESTString']) > 0)
{
  $specificLocationsRESTString = urldecode(test_input($_GET['specificLocationsRESTString']));
}

//get the sample ID
if(isset($_GET['sampleId']));
{
  $sampleId = test_input($_GET['sampleId']);

  if(strlen($sampleId > 0))
  {
    //delete the sample
    $result = reverseSampleVoid($sampleId);
  }
}
//redirect the user to the Samples page
header('Location: ../../Controls/QC/wt_samples.php?completionStatus=' . $completionStatus . '&startDate=' . $startDate . '&endDate=' . $endDate . '&startRow=' . $startRow . '&resultsPerPage=' . $resultsPerPage . '&compositeType=' . $compositeType . '&shift=' . $shift . '&sampler=' . $sampler . '&operator=' . $operator . '&view=' . $view . '&void=A&locationsRESTString=' . $locationsRESTString . '&testTypesRESTString=' . $testTypesRESTString . '&labTechsRESTString=' . $labTechsRESTString . '&sitesRESTString=' . $sitesRESTString . '&plantsRESTString=' . $plantsRESTString . '&specificLocationsRESTString=' . $specificLocationsRESTString . '&isCOA=' . $isCOA);

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

<!-- HTML -->
