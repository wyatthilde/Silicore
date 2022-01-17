<?php

/* * *****************************************************************************************************************************************
 * File Name: gb_samplerepeat.php
 * Project: Silicore
 * Description: This script will read a sample and then create a copy in the database.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/11/2017|mnutsch|KACE:xxxxx - Initial creation
 * 11/21/2017|mnutsch|KACE:18470 - Added Samples page filter preservation.
 * 11/29/2017|mnutsch|KACE:19500 - Hardcoded the REST variable void=A for redirects to samples.php.
 * 
 * **************************************************************************************************************************************** */
 
//==================================================================== BEGIN PHP
ob_start();

require_once('../../Includes/Security/database.php');

$db = new Database();

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
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains QC database query functions

$sampleObject = NULL;

//get the user ID
$userId = NULL;
if(isset($_GET['userId']))
{
  $userId = test_input($_GET['userId']);
}

$dt=time(); //variable used for obtaining the current time
$date = date("Y-m-d", strtotime($dt));
$time = date("H:i", strtotime($dt));

$dateShort = substr(date("Ymd", strtotime($dt)), 0, 8); //shorten the date to an 8 digit integer
$dtShort = substr(date("YmdHi", strtotime($dt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins

//group the times recorded together based on when the measurements are performed
if ($time >= "23:15" || $time < "02:15") 
{ 
  $groupTime = "00:00:00";
} elseif ($time < "05:15") 
{
  $groupTime = "03:00:00";
} elseif ($time < "08:15") 
{
  $groupTime = "06:00:00";
} elseif ($time < "11:15") 
{
  $groupTime = "09:00:00";
} elseif ($time < "14:15") 
{
  $groupTime = "12:00:00";
} elseif ($time < "17:15") 
{
  $groupTime = "15:00:00";
} elseif ($time < "20:15") 
{
  $groupTime = "18:00:00";
} else 
{
  $groupTime = "21:00:00";
}

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
echo $locationsRESTString . '<br>';
//get the sample ID
if(isset($_GET['sampleId']));
{
  $sampleId = test_input($_GET['sampleId']);

  if(strlen($sampleId > 0))
  {
    //read the sample record
    $sampleObject = getSampleById($sampleId);
    
    $argTestTypeId = "6";
    $argCompositeTypeId = $sampleObject->vars["compositeType"];
    $argSiteId = $sampleObject->vars["siteId"];
    $argPlantId = $sampleObject->vars["plantId"];
    $argLocationId = $sampleObject->vars["location"];
    $argDt = $sampleObject->vars["dt"];
    $argDate = $sampleObject->vars["date"];
    $argDateShort = $dateShort;
    $argDtShort = $dtShort;
    $argTime = $sampleObject->vars["time"];
    $argGroupTime = $groupTime;
    $argShift = $sampleObject->vars["shift"];
    $labTech = $sampleObject->vars["labTech"];
    $sampler = $sampleObject->vars["sampler"];
    $operator = $sampleObject->vars["operator"];
    $argUserId = $userId;
      
    $repeatSampleId = NULL;
    
    //insert a duplicate sample record into the samples table
    $repeatSampleId = insertSample(
            $argTestTypeId, 
            $argCompositeTypeId, 
            $argSiteId, 
            $argPlantId, 
            $argLocationId, 
            $argDt, 
            $argDate, 
            $argDateShort, 
            $argDtShort, 
            $argTime, 
            $argGroupTime,
            $argShift,
            $labTech, 
            $sampler, 
            $operator, 
            $argUserId
            );
    
    //insert a row into the qcfunctions table with both sample ID's.
    insertRepeatabiltySamplePair($sampleId, $repeatSampleId);
    $query = 'sp_gb_qc_sample_repeat_lock("' . $userId . '","' . $sampleId . '");';
    $db->insert($query);
    $query = 'sp_gb_qc_sample_repeat_lock("' . $userId . '","' . $repeatSampleId . '");';
    $db->insert($query);

  }
}

//echo $testTypesRESTString . '<br>';
//echo $labTechsRESTString . '<br>';
//echo $sitesRESTString . '<br>';
//echo $plantsRESTString . '<br>';
//echo $specificLocationsRESTString . '<br>';
//redirect the user to the Samples page
header('Location: ../../Controls/QC/gb_samples.php?completionStatus=' . $completionStatus . '&startDate=' . $startDate . '&endDate=' . $endDate . '&startRow=' . $startRow . '&resultsPerPage=' . $resultsPerPage . '&compositeType=' . $argCompositeTypeId . '&shift=' . $argShift . '&sampler=' . $sampler . '&operator=' . $operator . '&view=' . $view . '&void=A&locationsRESTString=' . $locationsRESTString . '&testTypesRESTString=' . $testTypesRESTString . '&labTechsRESTString=' .
 $labTechsRESTString . '&sitesRESTString=' . $sitesRESTString . '&plantsRESTString=' . $plantsRESTString . '&specificLocationsRESTString=' . $specificLocationsRESTString . '&isCOA=' . $isCOA);

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

