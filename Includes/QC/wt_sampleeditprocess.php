<?php

/* * *****************************************************************************************************************************************
 * File Name: wt_sampleeditprocess.php
 * Project: Silicore
 * Description: This script will save edits to a QC sample.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 0?/0?/2017|mnutsch|KACE:? - Initial creation
 * 06/28/2017|mnutsch|KACE:17366 - Updated
 * 07/10/2017|mnutsch|KACE:17366 - Added saving the edit time to the database.
 * 07/11/2017|mnutsch|KACE:17366 - Added saving the Plant Settings data.
 * 07/17/2017|mnutsch|KACE:17366 - Added saving the Core Sample data.
 * 07/17/2017|mnutsch|KACE:17366 - Updated handling of data formats.
 * 07/27/2017|mnutsch|KACE:17366 - Added code to update the Back Office database.
 * 08/04/2017|mnutsch|KACE:17803 - Add REST variable to redirect after processing.
 * 08/06/2017|mnutsch:KACE:17803 - Added functionality for processing additional sieve fields.
 * 08/08/2017|mnutsch|KACE:17803 - Adding functionality for updating PLC values for groups of samples.
 * 08/16/2017|mnutsch|KACE:17957 - Added code to handle blank fields.
 * 08/17/2017|mnutsch|KACE:17957 - Fixed a bug where samples where not saving. 
 * 08/18/2017|mnutsch|KACE:17957 - Added a REST parameter to the header function call on edit success.
 * 08/22/2017|mnutsch|KACE:17957 - Added code to check if a sample is in Back Office and insert or update the sample appropriately.
 * 08/24/2017|mnutsch|KACE:17957 - Updated the call to insertFinalPercentages() to include sieve values 11-18.
 * 08/30/2017|mnutsch|KACE:xxxxx - Fixed 2 formatting errors which prevented samples from saving.
 * 09/14/2017|mnutsch|KACE:17957 - Updated file location and name references.
 * 10/26/2017|mnutsch|KACE:19255 - Disabled saving of samples to the Back Office database.
 * 11/02/2017|mnutsch|KACE:19025 - Added code to handle sieve range values set to "NA".
 * 11/15/2017|mnutsch|KACE:18470 - Added handling for the field isCOA.
 * 11/29/2017|mnutsch|KACE:19500 - Hardcoded the REST variable void=A for redirects to samples.php.
 * 12/05/2017|mnutsch|KACE:18968 - Added code for completion message.
 * 01/19/2018|mnutsch|KACE:20439 - Disabled the sample completion message.
 * 01/19/2018|mnutsch|KACE:20458 - Reenabled the sample completion message.
 * 01/26/2018|mnutsch|KACE:20305 - Added the Near Size field.
 * 01/30/2018|mnutsch|KACE:18968 - Rewrote the sample completion functionality.
 * 02/14/2018|mnutsch|KACE:20409 - Fixed a bug related to empty fields.
 * 02/19/2018|mnutsch|KACE:21266 - Fixed a bug related to saving K Values.
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//debug setting
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
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains database connection info

//require_once('../../Controls/QC/samplecopytobackoffice.php'); //contains database connection info - disabled on 10-26-2017 per KACE # 19255.

require_once('../../Includes/Security/database.php');
$db = new Database();
//initialize variables
$percentFinal1 = 0;
$percentFinal2 = 0;
$percentFinal3 = 0;
$percentFinal4 = 0;
$percentFinal5 = 0;
$percentFinal6 = 0;
$percentFinal7 = 0;
$percentFinal8 = 0;
$percentFinal9 = 0;
$percentFinal10 = 0;
$percentFinal11 = 0;
$percentFinal12 = 0;
$percentFinal13 = 0;
$percentFinal14 = 0;
$percentFinal15 = 0;
$percentFinal16 = 0;
$percentFinal17 = 0;
$percentFinal18 = 0;

$result = 0; //sample update - Silicore
$result2 = 0; //temporary value storing status from updating sieve weights
$result3 = 0; //result from inserting final percentages
$resultBackOffice = 0; //sample update - Back Office - DEV NOTE: Remove this after the Back Office system is retired.

$sampleGroupObjectArray = NULL; //used when updating PLC data for groups of samples

$isCOA = 0; //value of the isCOA checkbox.

$nearSize = 0; //value of the near size range calculation

//read the values from the form
$userId = test_input($_POST['userId']); //used for tracking the user in the database
$sampleId = test_input($_POST['sampleId']); //used for editing an existing sample
$testTypeId = test_input($_POST['testTypeId']);
$compositeTypeId = test_input($_POST['compositeTypeId']);

if (strlen(test_input($_POST['sieveStackId']) > 0)) 
{
  $sieveStackId = test_input($_POST['sieveStackId']);
} 
else 
{
  $sieveStackId = "0";
}

if(strlen($_POST['locationId']) > 0) 
{
  $locationId = $_POST['locationId'];
}
else 
{
  $locationId = "0";
}

if(isset($_POST['specificLocationId']))
{
  if(strlen($_POST['specificLocationId']) > 0) 
  {
    $specificLocationId = $_POST['specificLocationId'];
  }
  else 
  {
    $specificLocationId = "0";
  }
}
else 
{
  $specificLocationId = "0";
}

$siteId = test_input($_POST['siteId']);
$plantId = test_input($_POST['plantId']);

if(isset($_POST['dt']))
{
  if(strlen($_POST['dt']) > 0) 
  {
    $dt = test_input($_POST['dt']); //the date and time of the sample
  }
  else 
  {
    $date = new DateTime();
    $dt = $date->format('Y-m-d H:i:s');
  }
}
else
{
  $date = new DateTime();
  $dt = $date->format('Y-m-d H:i:s'); 
}

$date = date("Y-m-d", strtotime($dt));
$time = date("H:i", strtotime($dt));

$dateShort = substr(date("Ymd", strtotime($dt)), 0, 8); //shorten the date to an 8 digit integer
$dtShort = substr(date("YmdHi", strtotime($dt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins

if (strlen(test_input($_POST['drillholeNo'])) > 0) 
{
  $drillholeNo = test_input($_POST['drillholeNo']);
} 
else 
{
  $drillholeNo = "";
}

if (strlen(test_input($_POST['description'])) > 0) 
{
  $description = test_input($_POST['description']);
} 
else 
{
  $description = "";
}

$sampler = test_input($_POST['sampler']);
$labTech = test_input($_POST['labTech']);
$operator = test_input($_POST['operator']);

if (strlen(test_input($_POST['beginningWetWeight']) > 0)) 
{
  $beginningWetWeight = test_input($_POST['beginningWetWeight']);
} 
else 
{
  $beginningWetWeight = "0";
}

if (strlen(test_input($_POST['preWashDryWeight']) > 0)) 
{
  $preWashDryWeight = test_input($_POST['preWashDryWeight']);
} 
else 
{
  $preWashDryWeight = "0";
}

if (strlen(test_input($_POST['splitSampleWeight']) > 0)) 
{
  $splitSampleWeight = test_input($_POST['splitSampleWeight']);
} 
else 
{
  $splitSampleWeight = "0";
}

if (strlen(test_input($_POST['postWashDryWeight']) > 0)) 
{
  $postWashDryWeight = test_input($_POST['postWashDryWeight']);
} 
else 
{
  $postWashDryWeight = "0";
}


if (strlen(test_input($_POST['moistureRate'])) > 0) 
{
  $moistureRate = test_input($_POST['moistureRate']);
  $moistureRate = rtrim($moistureRate,'%'); //remove the % sign from the end of the input if it is there.
  $moistureRate = $moistureRate / 100; //convert the value back into a decimal
  $moistureRate = round($moistureRate, 4); //round the value to fit in the database
}
else 
{
  $moistureRate = "0";
}

$notes = htmlentities(trim($_POST['notes']), ENT_QUOTES );


$turbidity = round(test_input($_POST['turbidity']));

if (strlen(test_input($_POST['kValue'])) > 0) 
{
  $kValue = test_input($_POST['kValue']);
}
else 
{
  $kValue = "0";
}

$kPan1 = 0;
$kPan2 = 0;
$kPan3 = 0;

$kPan1Array = NULL;
if(isset($_POST['kPan1']))
{
  $kPan1Array = $_POST['kPan1'];
  $kPan1ArrayCount = count($kPan1Array);
  for ($i=0; $i < $kPan1ArrayCount; $i++)
  {    
    $kPanObject = NULL;
    $kPanValue = 0;
    
    //check if this already exists in the k_value_records table 
    $kPanObject = getKValueRecord($sampleId, ($i + 1), "kPan1"); //assumes that the values start at 4 and are sequential, which was true when this was written    
    
    if($kPan1Array[$i] != "")
    {
      $kPanValue = $kPan1Array[$i];
      $kPan1 = $kPan1Array[$i];
    }
    
    //if not, then insert the value
    if($kPanObject == NULL)
    {      
      insertKValueRecord($sampleId, ($i + 1), "kPan1", $kPanValue);
    }
    else //else update the value
    {
      updateKValueRecord($sampleId, ($i + 1), "kPan1", $kPanValue);
    }
  }
}

$kPan2Array = NULL;
if(isset($_POST['kPan2']))
{
  $kPan2Array = $_POST['kPan2'];
  $kPan2ArrayCount = count($kPan2Array);
  for ($i=0; $i < $kPan2ArrayCount; $i++)
  {    
    $kPanObject = NULL;
    $kPanValue = 0;
  
    //check if this already exists in the k_value_records table 
    $kPanObject = getKValueRecord($sampleId, ($i + 1), "kPan2"); //assumes that the values start at 4 and are sequential, which was true when this was written
    
    if($kPan2Array[$i] != "")
    {
      $kPanValue = $kPan2Array[$i];
      $kPan2 = $kPan2Array[$i];
    }
    
    //if not, then insert the value
    if($kPanObject == NULL)
    {
      insertKValueRecord($sampleId, ($i + 1), "kPan2", $kPanValue);
    }
    else //else update the value
    {
      updateKValueRecord($sampleId, ($i + 1), "kPan2", $kPanValue);
    }
  }
}

$kPan3Array = NULL;
if(isset($_POST['kPan3']))
{
  $kPan3Array = $_POST['kPan3'];
  $kPan3ArrayCount = count($kPan1Array);
  for ($i=0; $i < $kPan3ArrayCount; $i++)
  {    
    $kPanObject = NULL;
    $kPanValue = 0;
    
    if($kPan3Array[$i] != "")
    {
      $kPanValue = $kPan3Array[$i];
      $kPan3 = $kPan3Array[$i];
    }
    
    //check if this already exists in the k_value_records table 
    $kPanObject = getKValueRecord($sampleId, ($i + 1), "kPan3"); //assumes that the values start at 4 and are sequential, which was true when this was written
    //
    //if not, then insert the value
    if($kPanObject == NULL)
    {
      insertKValueRecord($sampleId, ($i + 1), "kPan3", $kPanValue);
    }
    else //else update the value
    {
      updateKValueRecord($sampleId, ($i + 1), "kPan3", $kPanValue);
    }
  }
}

$roundness = setValue(test_input($_POST['roundness']));
$sphericity = setValue(test_input($_POST['sphericity']));
$siltHeight = setValue(test_input($_POST['siltHeight']));
$sandHeight = setValue(test_input($_POST['sandHeight']));
$siltPercent = setValue(test_input($_POST['siltPercent']));

if(isset($_POST['startWeight1']) > 0) { $startWeight1 = setValue(test_input($_POST['startWeight1'])); } else { $startWeight1 = 0; } 
if(isset($_POST['startWeight2']) > 0) { $startWeight2 = setValue(test_input($_POST['startWeight2'])); } else { $startWeight2 = 0; } 
if(isset($_POST['startWeight3']) > 0) { $startWeight3 = setValue(test_input($_POST['startWeight3'])); } else { $startWeight3 = 0; } 
if(isset($_POST['startWeight4']) > 0) { $startWeight4 = setValue(test_input($_POST['startWeight4'])); } else { $startWeight4 = 0; } 
if(isset($_POST['startWeight5']) > 0) { $startWeight5 = setValue(test_input($_POST['startWeight5'])); } else { $startWeight5 = 0; } 
if(isset($_POST['startWeight6']) > 0) { $startWeight6 = setValue(test_input($_POST['startWeight6'])); } else { $startWeight6 = 0; } 
if(isset($_POST['startWeight7']) > 0) { $startWeight7 = setValue(test_input($_POST['startWeight7'])); } else { $startWeight7 = 0; } 
if(isset($_POST['startWeight8']) > 0) { $startWeight8 = setValue(test_input($_POST['startWeight8'])); } else { $startWeight8 = 0; } 
if(isset($_POST['startWeight9']) > 0) { $startWeight9 = setValue(test_input($_POST['startWeight9'])); } else { $startWeight9 = 0; } 
if(isset($_POST['startWeight10']) > 0) { $startWeight10 = setValue(test_input($_POST['startWeight10'])); } else { $startWeight10 = 0; } 
if(isset($_POST['startWeight11']) > 0) { $startWeight11 = setValue(test_input($_POST['startWeight11'])); } else { $startWeight11 = 0; } 
if(isset($_POST['startWeight12']) > 0) { $startWeight12 = setValue(test_input($_POST['startWeight12'])); } else { $startWeight12 = 0; } 
if(isset($_POST['startWeight13']) > 0) { $startWeight13 = setValue(test_input($_POST['startWeight13'])); } else { $startWeight13 = 0; } 
if(isset($_POST['startWeight14']) > 0) { $startWeight14 = setValue(test_input($_POST['startWeight14'])); } else { $startWeight14 = 0; } 
if(isset($_POST['startWeight15']) > 0) { $startWeight15 = setValue(test_input($_POST['startWeight15'])); } else { $startWeight15 = 0; } 
if(isset($_POST['startWeight16']) > 0) { $startWeight16 = setValue(test_input($_POST['startWeight16'])); } else { $startWeight16 = 0; } 
if(isset($_POST['startWeight17']) > 0) { $startWeight17 = setValue(test_input($_POST['startWeight17'])); } else { $startWeight17 = 0; } 
if(isset($_POST['startWeight18']) > 0) { $startWeight18 = setValue(test_input($_POST['startWeight18'])); } else { $startWeight18 = 0; } 


//round the start weight values
$startWeight1 = round($startWeight1, 4);
$startWeight2 = round($startWeight2, 4);
$startWeight3 = round($startWeight3, 4);
$startWeight4 = round($startWeight4, 4);
$startWeight5 = round($startWeight5, 4);
$startWeight6 = round($startWeight6, 4);
$startWeight7 = round($startWeight7, 4);
$startWeight8 = round($startWeight8, 4);
$startWeight9 = round($startWeight9, 4);
$startWeight10 = round($startWeight10, 4);
$startWeight11 = round($startWeight11, 4);
$startWeight12 = round($startWeight12, 4);
$startWeight13 = round($startWeight13, 4);
$startWeight14 = round($startWeight14, 4);
$startWeight15 = round($startWeight15, 4);
$startWeight16 = round($startWeight16, 4);
$startWeight17 = round($startWeight17, 4);
$startWeight18 = round($startWeight18, 4);

//get the end weight values
if(isset($_POST['endWeight1']) > 0) { $endWeight1 = setValue(test_input($_POST['endWeight1'])); } else { $endWeight1 = 0; }
if(isset($_POST['endWeight2']) > 0) { $endWeight2 = setValue(test_input($_POST['endWeight2'])); } else { $endWeight2 = 0; }
if(isset($_POST['endWeight3']) > 0) { $endWeight3 = setValue(test_input($_POST['endWeight3'])); } else { $endWeight3 = 0; }
if(isset($_POST['endWeight4']) > 0) { $endWeight4 = setValue(test_input($_POST['endWeight4'])); } else { $endWeight4 = 0; }
if(isset($_POST['endWeight5']) > 0) { $endWeight5 = setValue(test_input($_POST['endWeight5'])); } else { $endWeight5 = 0; }
if(isset($_POST['endWeight6']) > 0) { $endWeight6 = setValue(test_input($_POST['endWeight6'])); } else { $endWeight6 = 0; }
if(isset($_POST['endWeight7']) > 0) { $endWeight7 = setValue(test_input($_POST['endWeight7'])); } else { $endWeight7 = 0; }
if(isset($_POST['endWeight8']) > 0) { $endWeight8 = setValue(test_input($_POST['endWeight8'])); } else { $endWeight8 = 0; }
if(isset($_POST['endWeight9']) > 0) { $endWeight9 = setValue(test_input($_POST['endWeight9'])); } else { $endWeight9 = 0; }
if(isset($_POST['endWeight10']) > 0) { $endWeight10 = setValue(test_input($_POST['endWeight10'])); } else { $endWeight10 = 0; }
if(isset($_POST['endWeight11']) > 0) { $endWeight11 = setValue(test_input($_POST['endWeight11'])); } else { $endWeight11 = 0; }
if(isset($_POST['endWeight12']) > 0) { $endWeight12 = setValue(test_input($_POST['endWeight12'])); } else { $endWeight12 = 0; }
if(isset($_POST['endWeight13']) > 0) { $endWeight13 = setValue(test_input($_POST['endWeight13'])); } else { $endWeight13 = 0; }
if(isset($_POST['endWeight14']) > 0) { $endWeight14 = setValue(test_input($_POST['endWeight14'])); } else { $endWeight14 = 0; }
if(isset($_POST['endWeight15']) > 0) { $endWeight15 = setValue(test_input($_POST['endWeight15'])); } else { $endWeight15 = 0; }
if(isset($_POST['endWeight16']) > 0) { $endWeight16 = setValue(test_input($_POST['endWeight16'])); } else { $endWeight16 = 0; }
if(isset($_POST['endWeight17']) > 0) { $endWeight17 = setValue(test_input($_POST['endWeight17'])); } else { $endWeight17 = 0; }
if(isset($_POST['endWeight18']) > 0) { $endWeight18 = setValue(test_input($_POST['endWeight18'])); } else { $endWeight18 = 0; }

//round the end weight values
$endWeight1 = round($endWeight1, 4);
$endWeight2 = round($endWeight2, 4);
$endWeight3 = round($endWeight3, 4);
$endWeight4 = round($endWeight4, 4);
$endWeight5 = round($endWeight5, 4);
$endWeight6 = round($endWeight6, 4);
$endWeight7 = round($endWeight7, 4);
$endWeight8 = round($endWeight8, 4);
$endWeight9 = round($endWeight9, 4);
$endWeight10 = round($endWeight10, 4);
$endWeight11 = round($endWeight11, 4);
$endWeight12 = round($endWeight12, 4);
$endWeight13 = round($endWeight13, 4);
$endWeight14 = round($endWeight14, 4);
$endWeight15 = round($endWeight15, 4);
$endWeight16 = round($endWeight16, 4);
$endWeight17 = round($endWeight17, 4);
$endWeight18 = round($endWeight18, 4);

//get the final weight values
if(isset($_POST['finalWeight1']) > 0) { $finalWeight1 = setValue(test_input($_POST['finalWeight1'])); } else { $finalWeight1 = 0; }
if(isset($_POST['finalWeight2']) > 0) { $finalWeight2 = setValue(test_input($_POST['finalWeight2'])); } else { $finalWeight2 = 0; }
if(isset($_POST['finalWeight3']) > 0) { $finalWeight3 = setValue(test_input($_POST['finalWeight3'])); } else { $finalWeight3 = 0; }
if(isset($_POST['finalWeight4']) > 0) { $finalWeight4 = setValue(test_input($_POST['finalWeight4'])); } else { $finalWeight4 = 0; }
if(isset($_POST['finalWeight5']) > 0) { $finalWeight5 = setValue(test_input($_POST['finalWeight5'])); } else { $finalWeight5 = 0; }
if(isset($_POST['finalWeight6']) > 0) { $finalWeight6 = setValue(test_input($_POST['finalWeight6'])); } else { $finalWeight6 = 0; }
if(isset($_POST['finalWeight7']) > 0) { $finalWeight7 = setValue(test_input($_POST['finalWeight7'])); } else { $finalWeight7 = 0; }
if(isset($_POST['finalWeight8']) > 0) { $finalWeight8 = setValue(test_input($_POST['finalWeight8'])); } else { $finalWeight8 = 0; }
if(isset($_POST['finalWeight9']) > 0) { $finalWeight9 = setValue(test_input($_POST['finalWeight9'])); } else { $finalWeight9 = 0; }
if(isset($_POST['finalWeight10']) > 0) { $finalWeight10 = setValue(test_input($_POST['finalWeight10'])); } else { $finalWeight10 = 0; }
if(isset($_POST['finalWeight11']) > 0) { $finalWeight11 = setValue(test_input($_POST['finalWeight11'])); } else { $finalWeight11 = 0; }
if(isset($_POST['finalWeight12']) > 0) { $finalWeight12 = setValue(test_input($_POST['finalWeight12'])); } else { $finalWeight12 = 0; }
if(isset($_POST['finalWeight13']) > 0) { $finalWeight13 = setValue(test_input($_POST['finalWeight13'])); } else { $finalWeight13 = 0; }
if(isset($_POST['finalWeight14']) > 0) { $finalWeight14 = setValue(test_input($_POST['finalWeight14'])); } else { $finalWeight14 = 0; }
if(isset($_POST['finalWeight15']) > 0) { $finalWeight15 = setValue(test_input($_POST['finalWeight15'])); } else { $finalWeight15 = 0; }
if(isset($_POST['finalWeight16']) > 0) { $finalWeight16 = setValue(test_input($_POST['finalWeight16'])); } else { $finalWeight16 = 0; }
if(isset($_POST['finalWeight17']) > 0) { $finalWeight17 = setValue(test_input($_POST['finalWeight17'])); } else { $finalWeight17 = 0; }
if(isset($_POST['finalWeight18']) > 0) { $finalWeight18 = setValue(test_input($_POST['finalWeight18'])); } else { $finalWeight18 = 0; }

if(isset($_POST['screenSize1']) > 0) { $screenSize1 = setValue(test_input($_POST['screenSize1'])); } else { $screenSize1 = 0; }
if(isset($_POST['screenSize2']) > 0) { $screenSize2 = setValue(test_input($_POST['screenSize2'])); } else { $screenSize2 = 0; }
if(isset($_POST['screenSize3']) > 0) { $screenSize3 = setValue(test_input($_POST['screenSize3'])); } else { $screenSize3 = 0; }
if(isset($_POST['screenSize4']) > 0) { $screenSize4 = setValue(test_input($_POST['screenSize4'])); } else { $screenSize4 = 0; }
if(isset($_POST['screenSize5']) > 0) { $screenSize5 = setValue(test_input($_POST['screenSize5'])); } else { $screenSize5 = 0; }
if(isset($_POST['screenSize6']) > 0) { $screenSize6 = setValue(test_input($_POST['screenSize6'])); } else { $screenSize6 = 0; }
if(isset($_POST['screenSize7']) > 0) { $screenSize7 = setValue(test_input($_POST['screenSize7'])); } else { $screenSize7 = 0; }
if(isset($_POST['screenSize8']) > 0) { $screenSize8 = setValue(test_input($_POST['screenSize8'])); } else { $screenSize8 = 0; }
if(isset($_POST['screenSize9']) > 0) { $screenSize9 = setValue(test_input($_POST['screenSize9'])); } else { $screenSize9 = 0; }
if(isset($_POST['screenSize10']) > 0) { $screenSize10 = setValue(test_input($_POST['screenSize10'])); } else { $screenSize10 = 0; }
if(isset($_POST['screenSize11']) > 0) { $screenSize11 = setValue(test_input($_POST['screenSize11'])); } else { $screenSize11 = 0; }
if(isset($_POST['screenSize12']) > 0) { $screenSize12 = setValue(test_input($_POST['screenSize12'])); } else { $screenSize12 = 0; }
if(isset($_POST['screenSize13']) > 0) { $screenSize13 = setValue(test_input($_POST['screenSize13'])); } else { $screenSize13 = 0; }
if(isset($_POST['screenSize14']) > 0) { $screenSize14 = setValue(test_input($_POST['screenSize14'])); } else { $screenSize14 = 0; }
if(isset($_POST['screenSize15']) > 0) { $screenSize15 = setValue(test_input($_POST['screenSize15'])); } else { $screenSize15 = 0; }
if(isset($_POST['screenSize16']) > 0) { $screenSize16 = setValue(test_input($_POST['screenSize16'])); } else { $screenSize16 = 0; }
if(isset($_POST['screenSize17']) > 0) { $screenSize17 = setValue(test_input($_POST['screenSize17'])); } else { $screenSize17 = 0; }
if(isset($_POST['screenSize18']) > 0) { $screenSize18 = setValue(test_input($_POST['screenSize18'])); } else { $screenSize18 = 0; }

//plus 70
if(isset($_POST['plus70']) > 0)
{
  $plus70 = setValue(test_input($_POST['plus70']));
  if($plus70 == "NA")
  {
    $plus70 = "0%";
  }
}
else
{
  $plus70 = 0;
}
$plus70 = $plus70 / 100; //convert back from a percent to a decimal


//plus 50
if(isset($_POST['plus50']) > 0)
{
  $plus50 = setValue(test_input($_POST['plus50']));
  if($plus50 == "NA")
  {
    $plus50 = "0%";
  }
}
else
{
  $plus50 = 0;
}
$plus50 = $plus50 / 100; //convert back from a percent to a decimal

//plus 40
if(isset($_POST['plus40']) > 0)
{
  $plus40 = setValue(test_input($_POST['plus40']));
  if($plus40 == "NA")
  {
    $plus40 = "0%";
  }
}
else
{
  $plus40 = 0;
}
$plus40 = $plus40 / 100; //convert back from a percent to a decimal

//minus fifty plus one forty
if(isset($_POST['neg50Plus140']) > 0)
{
  $neg50Plus140 = setValue(test_input($_POST['neg50Plus140']));
  if($neg50Plus140 == "NA")
  {
    $neg50Plus140 = "0%";
  }
}
else
{
  $neg50Plus140 = 0;
}
$neg50Plus140 = $neg50Plus140 / 100; //convert back from a percent to a decimal

//minus 60 plus 70
if(isset($_POST['neg60Plus70']) > 0)
{
    $neg60Plus70 = setValue(test_input($_POST['neg60Plus70']));
    if($neg60Plus70 == "NA")
    {
        $neg60Plus70 = "0%";
    }
}
else
{
    $neg60Plus70 = 0;
}
$neg60Plus70 = $neg60Plus70 / 100; //convert back from a percent to a decimal

//minus 140 plus 325
if(isset($_POST['neg140Plus325']) > 0)
{
    $neg140Plus325 = setValue(test_input($_POST['neg140Plus325']));
    if($neg140Plus325 == "NA")
    {
        $neg140Plus325 = "0%";
    }
}
else
{
    $neg140Plus325 = 0;
}
$neg140Plus325 = $neg140Plus325 / 100; //convert back from a percent to a decimal

//minus_40_plus_70
if(isset($_POST['neg40Plus70']) > 0)
{
  $neg40Plus70 = setValue(test_input($_POST['neg40Plus70']));
  if($neg40Plus70 == "NA")
  {
    $neg40Plus70 = "0%";
  }
}
else
{
  $neg40Plus70 = 0;
}
$neg40Plus70 = $neg40Plus70 / 100; //convert back from a percent to a decimal

//minus_70
if(isset($_POST['minus70']) > 0)
{
  $neg70 = setValue(test_input($_POST['minus70']));
  if($neg70 == "NA")
  {
    $neg70 = "0%";
  }
}
else
{
  $neg70 = 0;
}

$neg70 = $neg70 / 100; //convert back from a percent to a decimal

//minus_70_plus_140
if(isset($_POST['neg70Plus140']) > 0)
{
  $neg70Plus140 = setValue(test_input($_POST['neg70Plus140']));
  if($neg70Plus140 == "NA")
  {
    $neg70Plus140 = "0%";
  }
}
else
{
  $neg70Plus140 = 0;
}
$neg70Plus140 = $neg70Plus140 / 100; //convert back from a percent to a decimal

//plus_140
//DEV NOTE: This field is not in the Sample Edit requirements. However it appeared on the Back Office QC Overview page.

//minus_140
if(isset($_POST['neg140']) > 0)
{
  $neg140 = setValue(test_input($_POST['neg140']));
  if($neg140 == "NA")
  {
    $neg140 = "0%";
  }
}
else
{
  $neg140 = 0;
}

$neg140 = $neg140 / 100; //convert back from a percent to a decimal

//nearSize
if(isset($_POST['nearSize']) > 0)
{
  $nearSize = setValue(test_input($_POST['nearSize']));
  if($nearSize == "NA")
  {
    $nearSize = "0%";
  }
}
else
{
  $nearSize = 0;
}
$nearSize = $nearSize / 100; //convert back from a percent to a decimal

$totalFinalWeight = "0";
if(isset($_POST['totalFinalWeight']))
{
  if(strlen($_POST['totalFinalWeight']) > 0) 
  {
    $totalFinalWeight = setValue($_POST['totalFinalWeight']);
  } 
}
//if there is something entered in Start Weight, then calculate Final Weight, rather than read it directly
//Explanation: Start Weight is only entered directly if the Sieve Stack is not a camsizer.
//Final Weight is only entered directly if the Sieve Stack is a camsizer.
if($startWeight1)
{
  $finalWeight1 = $endWeight1 - $startWeight1;
}

if($startWeight2)
{
  $finalWeight2 = $endWeight2 - $startWeight2;
}

if($startWeight3)
{
  $finalWeight3 = $endWeight3 - $startWeight3;
}

if($startWeight4)
{
  $finalWeight4 = $endWeight4 - $startWeight4;
}

if($startWeight5)
{
  $finalWeight5 = $endWeight5 - $startWeight5;
}

if($startWeight6)
{
  $finalWeight6 = $endWeight6 - $startWeight6;
}

if($startWeight7)
{
  $finalWeight7 = $endWeight7 - $startWeight7;
}

if($startWeight8)
{
  $finalWeight8 = $endWeight8 - $startWeight8;
}

if($startWeight9)
{
  $finalWeight9 = $endWeight9 - $startWeight9;
}

if($startWeight10)
{
  $finalWeight10 = $endWeight10 - $startWeight10;
}

if($startWeight11)
{
  $finalWeight11 = $endWeight11 - $startWeight11;
}

if($startWeight12)
{
  $finalWeight12 = $endWeight12 - $startWeight12;
}

if($startWeight13)
{
  $finalWeight13 = $endWeight13 - $startWeight13;
}

if($startWeight14)
{
  $finalWeight14 = $endWeight14 - $startWeight14;
}

if($startWeight15)
{
  $finalWeight15 = $endWeight15 - $startWeight15;
}

if($startWeight16)
{
  $finalWeight16 = $endWeight16 - $startWeight16;
}

if($startWeight17)
{
  $finalWeight17 = $endWeight17 - $startWeight17;
}

if($startWeight18)
{
  $finalWeight18 = $endWeight18 - $startWeight18;
}

//round the final weight values
$finalWeight1 = round($finalWeight1, 4);
$finalWeight2 = round($finalWeight2, 4);
$finalWeight3 = round($finalWeight3, 4);
$finalWeight4 = round($finalWeight4, 4);
$finalWeight5 = round($finalWeight5, 4);
$finalWeight6 = round($finalWeight6, 4);
$finalWeight7 = round($finalWeight7, 4);
$finalWeight8 = round($finalWeight8, 4);
$finalWeight9 = round($finalWeight9, 4);
$finalWeight10 = round($finalWeight10, 4);
$finalWeight11 = round($finalWeight11, 4);
$finalWeight12 = round($finalWeight12, 4);
$finalWeight13 = round($finalWeight13, 4);
$finalWeight14 = round($finalWeight14, 4);
$finalWeight15 = round($finalWeight15, 4);
$finalWeight16 = round($finalWeight16, 4);
$finalWeight17 = round($finalWeight17, 4);
$finalWeight18 = round($finalWeight18, 4);

if(isset($_POST['percentFinal1']))
{
  $percentFinal1 = test_input($_POST['percentFinal1']) / 100;
}

if(isset($_POST['percentFinal2']))
{
  $percentFinal2 = test_input($_POST['percentFinal2']) / 100;
}

if(isset($_POST['percentFinal3']))
{
  $percentFinal3 = test_input($_POST['percentFinal3']) / 100;
}

if(isset($_POST['percentFinal4']))
{
  $percentFinal4 = test_input($_POST['percentFinal4']) / 100;
}

if(isset($_POST['percentFinal5']))
{
  $percentFinal5 = test_input($_POST['percentFinal5']) / 100;
}

if(isset($_POST['percentFinal6']))
{
  $percentFinal6 = test_input($_POST['percentFinal6']) / 100;
}

if(isset($_POST['percentFinal7']))
{
  $percentFinal7 = test_input($_POST['percentFinal7']) / 100;
}

if(isset($_POST['percentFinal8']))
{
  $percentFinal8 = test_input($_POST['percentFinal8']) / 100;
}

if(isset($_POST['percentFinal9']))
{
  $percentFinal9 = test_input($_POST['percentFinal9']) / 100;
}

if(isset($_POST['percentFinal10']))
{
  $percentFinal10 = test_input($_POST['percentFinal10']) / 100;
}

if(isset($_POST['percentFinal11']))
{
  $percentFinal11 = test_input($_POST['percentFinal11']) / 100;
}

if(isset($_POST['percentFinal12']))
{
  $percentFinal12 = test_input($_POST['percentFinal12']) / 100;
}

if(isset($_POST['percentFinal13']))
{
  $percentFinal13 = test_input($_POST['percentFinal13']) / 100;
}

if(isset($_POST['percentFinal14']))
{
  $percentFinal14 = test_input($_POST['percentFinal14']) / 100;
}

if(isset($_POST['percentFinal15']))
{
  $percentFinal15 = test_input($_POST['percentFinal15']) / 100;
}

if(isset($_POST['percentFinal16']))
{
  $percentFinal16 = test_input($_POST['percentFinal16']) / 100;
}

if(isset($_POST['percentFinal17']))
{
  $percentFinal17 = test_input($_POST['percentFinal17']) / 100;
}

if(isset($_POST['percentFinal18']))
{
  $percentFinal18 = test_input($_POST['percentFinal18']) / 100;
}

$groupTime = $time;

if (strlen(test_input($_POST['depthFrom'])) > 0) 
{
  $depthFrom = test_input($_POST['depthFrom']);
}
else 
{
  $depthFrom = "0";
}

if (strlen(test_input($_POST['depthTo'])) > 0) 
{
  $depthTo = test_input($_POST['depthTo']);
}
else 
{
  $depthTo = "0";
}

if (strlen(test_input($_POST['percentLost'])) > 0) 
{
  $percentLost = test_input($_POST['percentLost']);
  
  //remove the percent sign if present
  $percentLost = str_replace("%","",$percentLost);

  //convert to a fraction
  $percentLost = $percentLost / 100;

  //round to 4 decimals
  $percentLost = round($percentLost, 4);
}
else 
{
  $percentLost = "0";
}


if (strlen(test_input($_POST['oversizeWeight'])) > 0) 
{
  $oversizeWeight = test_input($_POST['oversizeWeight']);
}
else 
{
  $oversizeWeight = "0";
}

if (strlen(test_input($_POST['oversizePercent'])) > 0) 
{
  $oversizePercent = test_input($_POST['oversizePercent']);
  
  if($oversizePercent == "Infinity%")
  {
    $oversizePercent = "0";
  }
  else 
  {
    //remove the percent sign if present
    $oversizePercent = str_replace("%","",$oversizePercent);

    //convert to a fraction
    $oversizePercent = $oversizePercent / 100;

    //round to 4 decimals
    $oversizePercent = round($oversizePercent, 4);
  }
}
else 
{
  $oversizePercent = "0";
}
if($oversizePercent < 0)
{
  $oversizePercent = 0;
}

if(isset($_POST['isCOA']))
{
  if (strlen(test_input($_POST['isCOA'])) > 0) 
  {
    $isCOA = test_input($_POST['isCOA']);
  }
  else 
  {
    $isCOA = "0";
  }
}
else
{
  $isCOA = "0";
}

//output the values for development testing
if($debugging)
{
  echo "finished reading form input";

  //echo "sampleID = " . $sampleId . "<br/>";
  //echo "sampleCountSwitch = " . $sampleCountSwitch . "<br/>";
  echo "siteId = " . $siteId . "<br/>";
  echo "plantId = " . $plantId . "<br/>";
  echo "dt = " . $dt . "<br/>";
  echo "testTypeId = " . $testTypeId . "<br/>";
  echo "compositeTypeId = " . $compositeTypeId . "<br/>";
  echo "sieveStackId = " . $sieveStackId . "<br/>";
  echo "locationId = " . $locationId . "<br/>";
  echo "specificLocationId = " . $specificLocationId . "<br/>";
  echo "date = " . $date . "<br/>";
  echo "time = " . $time . "<br/>";
  echo "dateShort = " . $dateShort . "<br/>";
  echo "dtShort = " . $dtShort . "<br/>";
  echo "drillholeNo = " . $drillholeNo . "<br/>";
  echo "description = " . $description . "<br/>";
  echo "sampler = " . $sampler . "<br/>";
  echo "labTech = " . $labTech . "<br/>";
  echo "operator = " . $operator . "<br/>";
  echo "beginningWetWeight = " . $beginningWetWeight . "<br/>";
  echo "preWashDryWeight = " . $preWashDryWeight . "<br/>";
  echo "postWashDryWeight = " . $postWashDryWeight . "<br/>";
  echo "splitSampleWeight = " . $splitSampleWeight . "<br/>";
  echo "moistureRate = " . $moistureRate . "<br/>";
  echo "notes = " . $notes . "<br/>";
  echo "turbidity = " . $turbidity . "<br/>";
  echo "kValue = " . $kValue . "<br/>";
  echo "kPan1 = " . $kPan1 . "<br/>";
  echo "kPan2 = " . $kPan2 . "<br/>";
  echo "kPan3 = " . $kPan3 . "<br/>";
  echo "roundness = " . $roundness . "<br/>";
  echo "sphericity = " . $sphericity . "<br/>";

  echo "startWeight1 =" . $startWeight1 . "<br/>";
  echo "startWeight2 =" . $startWeight2 . "<br/>";
  echo "startWeight3 =" . $startWeight3 . "<br/>";
  echo "startWeight4 =" . $startWeight4 . "<br/>";
  echo "startWeight5 =" . $startWeight5 . "<br/>";
  echo "startWeight6 =" . $startWeight6 . "<br/>";
  echo "startWeight7 =" . $startWeight7 . "<br/>";
  echo "startWeight8 =" . $startWeight8 . "<br/>";
  echo "startWeight9 =" . $startWeight9 . "<br/>";
  echo "startWeight10 =" . $startWeight10 . "<br/>";
  echo "startWeight11 =" . $startWeight11 . "<br/>";
  echo "startWeight12 =" . $startWeight12 . "<br/>";
  echo "startWeight13 =" . $startWeight13 . "<br/>";
  echo "startWeight14 =" . $startWeight14 . "<br/>";
  echo "startWeight15 =" . $startWeight15 . "<br/>";
  echo "startWeight16 =" . $startWeight16 . "<br/>";
  echo "startWeight17 =" . $startWeight17 . "<br/>";
  echo "startWeight18 =" . $startWeight18 . "<br/>";

  echo "endWeight1 =" . $endWeight1 . "<br/>";
  echo "endWeight2 =" . $endWeight2 . "<br/>";
  echo "endWeight3 =" . $endWeight3 . "<br/>";
  echo "endWeight4 =" . $endWeight4 . "<br/>";
  echo "endWeight5 =" . $endWeight5 . "<br/>";
  echo "endWeight6 =" . $endWeight6 . "<br/>";
  echo "endWeight7 =" . $endWeight7 . "<br/>";
  echo "endWeight8 =" . $endWeight8 . "<br/>";
  echo "endWeight9 =" . $endWeight9 . "<br/>";
  echo "endWeight10 =" . $endWeight10 . "<br/>";
  echo "endWeight11 =" . $endWeight11 . "<br/>";
  echo "endWeight12 =" . $endWeight12 . "<br/>";
  echo "endWeight13 =" . $endWeight13 . "<br/>";
  echo "endWeight14 =" . $endWeight14 . "<br/>";
  echo "endWeight15 =" . $endWeight15 . "<br/>";
  echo "endWeight16 =" . $endWeight16 . "<br/>";
  echo "endWeight17 =" . $endWeight17 . "<br/>";
  echo "endWeight18 =" . $endWeight18 . "<br/>";

  echo "finalWeight1 =" . $finalWeight1 . "<br/>";
  echo "finalWeight2 =" . $finalWeight2 . "<br/>";
  echo "finalWeight3 =" . $finalWeight3 . "<br/>";
  echo "finalWeight4 =" . $finalWeight4 . "<br/>";
  echo "finalWeight5 =" . $finalWeight5 . "<br/>";
  echo "finalWeight6 =" . $finalWeight6 . "<br/>";
  echo "finalWeight7 =" . $finalWeight7 . "<br/>";
  echo "finalWeight8 =" . $finalWeight8 . "<br/>";
  echo "finalWeight9 =" . $finalWeight9 . "<br/>";
  echo "finalWeight10 =" . $finalWeight10 . "<br/>";
  echo "finalWeight11 =" . $finalWeight11 . "<br/>";
  echo "finalWeight12 =" . $finalWeight12 . "<br/>";
  echo "finalWeight13 =" . $finalWeight13 . "<br/>";
  echo "finalWeight14 =" . $finalWeight14 . "<br/>";
  echo "finalWeight15 =" . $finalWeight15 . "<br/>";
  echo "finalWeight16 =" . $finalWeight16 . "<br/>";
  echo "finalWeight17 =" . $finalWeight17 . "<br/>";
  echo "finalWeight18 =" . $finalWeight18 . "<br/>";
    
  echo "totalFinalWeight =" . $totalFinalWeight . "<br/>";

  echo "percentFinal1 =" . $percentFinal1 . "<br/>";
  echo "percentFinal2 =" . $percentFinal2 . "<br/>";
  echo "percentFinal3 =" . $percentFinal3 . "<br/>";
  echo "percentFinal4 =" . $percentFinal4 . "<br/>";
  echo "percentFinal5 =" . $percentFinal5 . "<br/>";
  echo "percentFinal6 =" . $percentFinal6 . "<br/>";
  echo "percentFinal7 =" . $percentFinal7 . "<br/>";
  echo "percentFinal8 =" . $percentFinal8 . "<br/>";
  echo "percentFinal9 =" . $percentFinal9 . "<br/>";
  echo "percentFinal10 =" . $percentFinal10 . "<br/>";
  echo "percentFinal11 =" . $percentFinal11 . "<br/>";
  echo "percentFinal12 =" . $percentFinal12 . "<br/>";
  echo "percentFinal13 =" . $percentFinal13 . "<br/>";
  echo "percentFinal14 =" . $percentFinal14 . "<br/>";
  echo "percentFinal15 =" . $percentFinal15 . "<br/>";
  echo "percentFinal16 =" . $percentFinal16 . "<br/>";
  echo "percentFinal17 =" . $percentFinal17 . "<br/>";
  echo "percentFinal18 =" . $percentFinal18 . "<br/>";

  echo "groupTime = " . $groupTime . "<br/>";
  
  echo "depthFrom = " . $depthFrom . "<br/>";
  echo "depthTo = " . $depthTo . "<br/>";
  //echo "slimes = " . $slimes . "<br/>";
  echo "oversizeWeight = " . $oversizeWeight . "<br/>";
  echo "oversizePercent = " . $oversizePercent . "<br/>";
}

//put the values in a sample object
$sampleObject->vars['userId'] = $userId;
$sampleObject->vars['id'] = $sampleId;
$sampleObject->vars['siteId'] = $siteId;
$sampleObject->vars['plantId'] = $plantId;
$sampleObject->vars['dt'] = $dt;
$sampleObject->vars['testTypeId'] = $testTypeId;
$sampleObject->vars['compositeTypeId'] = $compositeTypeId;
$sampleObject->vars['sieveStackId'] = $sieveStackId;
$sampleObject->vars['locationId'] = $locationId;
$sampleObject->vars['specificLocationId'] = $specificLocationId;
$sampleObject->vars['date'] = $date;
$sampleObject->vars['time'] = $time;
$sampleObject->vars['dateShort'] = $dateShort;
$sampleObject->vars['dtShort'] = $dtShort;

$sampleObject->vars['drillholeNo'] = $drillholeNo;
$sampleObject->vars['depthFrom'] = $depthFrom;
$sampleObject->vars['depthTo'] = $depthTo;
$sampleObject->vars['slimes'] = $percentLost;
$sampleObject->vars['oversizeWeight'] = $oversizeWeight;
$sampleObject->vars['oversizePercent'] = $oversizePercent;

$sampleObject->vars['description'] = $description;
$sampleObject->vars['sampler'] = $sampler;
$currentSample = json_decode($db->get('sp_wt_qc_SampleGetByID("' . $sampleId . '");'));

if($currentSample[0]->is_complete == 1) {
    $sampleObject->vars['labTech'] = $currentSample[0]->lab_tech;
} else {
    $sampleObject->vars['labTech'] = $_SESSION['user_id'];
}

$sampleObject->vars['operator'] = $operator;
//starting_weight
$sampleObject->vars['beginningWetWeight'] = $beginningWetWeight;
$sampleObject->vars['preWashDryWeight'] = $preWashDryWeight;
//ending_weight
$sampleObject->vars['postWashDryWeight'] = $postWashDryWeight;
$sampleObject->vars['splitSampleWeight'] = $splitSampleWeight;
$sampleObject->vars['moistureRate'] = $moistureRate;
$sampleObject->vars['notes'] = $notes;
$sampleObject->vars['turbidity'] = $turbidity;
$sampleObject->vars['kValue'] = $kValue;
$sampleObject->vars['kPan1'] = $kPan1;
$sampleObject->vars['kPan2'] = $kPan2;
$sampleObject->vars['kPan3'] = $kPan3;
$sampleObject->vars['roundness'] = $roundness;
$sampleObject->vars['sphericity'] = $sphericity;
$sampleObject->vars['siltPercent'] = $siltPercent;
$sampleObject->vars['siltHeight'] = $siltHeight;
$sampleObject->vars['sandHeight'] = $sandHeight;

$sampleObject->vars['groupTime'] = $groupTime;

//screen sizes
$sampleObject->vars['screenSize1'] = $screenSize1; 
$sampleObject->vars['screenSize2'] = $screenSize2;
$sampleObject->vars['screenSize3'] = $screenSize3;
$sampleObject->vars['screenSize4'] = $screenSize4;
$sampleObject->vars['screenSize5'] = $screenSize5;
$sampleObject->vars['screenSize6'] = $screenSize6;
$sampleObject->vars['screenSize7'] = $screenSize7;
$sampleObject->vars['screenSize8'] = $screenSize8;
$sampleObject->vars['screenSize9'] = $screenSize9;
$sampleObject->vars['screenSize10'] = $screenSize10;
$sampleObject->vars['screenSize11'] = $screenSize11;
$sampleObject->vars['screenSize12'] = $screenSize12;
$sampleObject->vars['screenSize13'] = $screenSize13;
$sampleObject->vars['screenSize14'] = $screenSize14;
$sampleObject->vars['screenSize15'] = $screenSize15;
$sampleObject->vars['screenSize16'] = $screenSize16;
$sampleObject->vars['screenSize17'] = $screenSize17;
$sampleObject->vars['screenSize18'] = $screenSize18;

//set up weight objects to encode and store the starting weights
$weightsObject = NULL;
$weightsObject->vars['weightValue1'] = $startWeight1; 
$weightsObject->vars['weightValue2'] = $startWeight2;
$weightsObject->vars['weightValue3'] = $startWeight3;
$weightsObject->vars['weightValue4'] = $startWeight4;
$weightsObject->vars['weightValue5'] = $startWeight5;
$weightsObject->vars['weightValue6'] = $startWeight6;
$weightsObject->vars['weightValue7'] = $startWeight7;
$weightsObject->vars['weightValue8'] = $startWeight8;
$weightsObject->vars['weightValue9'] = $startWeight9;
$weightsObject->vars['weightValue10'] = $startWeight10;
$weightsObject->vars['weightValue11'] = $startWeight11; 
$weightsObject->vars['weightValue12'] = $startWeight12; 
$weightsObject->vars['weightValue13'] = $startWeight13; 
$weightsObject->vars['weightValue14'] = $startWeight14; 
$weightsObject->vars['weightValue15'] = $startWeight15; 
$weightsObject->vars['weightValue16'] = $startWeight16; 
$weightsObject->vars['weightValue17'] = $startWeight17; 
$weightsObject->vars['weightValue18'] = $startWeight18; 

//screen sizes
$weightsObject->vars['screenSize1'] = $screenSize1; 
$weightsObject->vars['screenSize2'] = $screenSize2;
$weightsObject->vars['screenSize3'] = $screenSize3;
$weightsObject->vars['screenSize4'] = $screenSize4;
$weightsObject->vars['screenSize5'] = $screenSize5;
$weightsObject->vars['screenSize6'] = $screenSize6;
$weightsObject->vars['screenSize7'] = $screenSize7;
$weightsObject->vars['screenSize8'] = $screenSize8;
$weightsObject->vars['screenSize9'] = $screenSize9;
$weightsObject->vars['screenSize10'] = $screenSize10;
$weightsObject->vars['screenSize11'] = $screenSize11; 
$weightsObject->vars['screenSize12'] = $screenSize12; 
$weightsObject->vars['screenSize13'] = $screenSize13; 
$weightsObject->vars['screenSize14'] = $screenSize14; 
$weightsObject->vars['screenSize15'] = $screenSize15; 
$weightsObject->vars['screenSize16'] = $screenSize16; 
$weightsObject->vars['screenSize17'] = $screenSize17; 
$weightsObject->vars['screenSize18'] = $screenSize18; 

$sampleObject->vars['startWeights'] = encodeWeights($weightsObject);

//set up weight objects to encode and store the ending weights
$weightsObject = NULL;
$weightsObject->vars['weightValue1'] = $endWeight1;
$weightsObject->vars['weightValue2'] = $endWeight2;
$weightsObject->vars['weightValue3'] = $endWeight3;
$weightsObject->vars['weightValue4'] = $endWeight4;
$weightsObject->vars['weightValue5'] = $endWeight5;
$weightsObject->vars['weightValue6'] = $endWeight6;
$weightsObject->vars['weightValue7'] = $endWeight7;
$weightsObject->vars['weightValue8'] = $endWeight8;
$weightsObject->vars['weightValue9'] = $endWeight9;
$weightsObject->vars['weightValue10'] = $endWeight10;
$weightsObject->vars['weightValue11'] = $endWeight11;
$weightsObject->vars['weightValue12'] = $endWeight12;
$weightsObject->vars['weightValue13'] = $endWeight13;
$weightsObject->vars['weightValue14'] = $endWeight14;
$weightsObject->vars['weightValue15'] = $endWeight15;
$weightsObject->vars['weightValue16'] = $endWeight16;
$weightsObject->vars['weightValue17'] = $endWeight17;
$weightsObject->vars['weightValue18'] = $endWeight18;

//screen sizes
$weightsObject->vars['screenSize1'] = $screenSize1; 
$weightsObject->vars['screenSize2'] = $screenSize2;
$weightsObject->vars['screenSize3'] = $screenSize3;
$weightsObject->vars['screenSize4'] = $screenSize4;
$weightsObject->vars['screenSize5'] = $screenSize5;
$weightsObject->vars['screenSize6'] = $screenSize6;
$weightsObject->vars['screenSize7'] = $screenSize7;
$weightsObject->vars['screenSize8'] = $screenSize8;
$weightsObject->vars['screenSize9'] = $screenSize9;
$weightsObject->vars['screenSize10'] = $screenSize10;
$weightsObject->vars['screenSize11'] = $screenSize11; 
$weightsObject->vars['screenSize12'] = $screenSize12; 
$weightsObject->vars['screenSize13'] = $screenSize13; 
$weightsObject->vars['screenSize14'] = $screenSize14; 
$weightsObject->vars['screenSize15'] = $screenSize15; 
$weightsObject->vars['screenSize16'] = $screenSize16; 
$weightsObject->vars['screenSize17'] = $screenSize17; 
$weightsObject->vars['screenSize18'] = $screenSize18; 

$sampleObject->vars['endWeights'] = encodeWeights($weightsObject);

//set up weight objects to encode and store the final weights
$weightsObject = NULL;
$weightsObject->vars['weightValue1'] = $finalWeight1; 
$weightsObject->vars['weightValue2'] = $finalWeight2;
$weightsObject->vars['weightValue3'] = $finalWeight3;
$weightsObject->vars['weightValue4'] = $finalWeight4;
$weightsObject->vars['weightValue5'] = $finalWeight5;
$weightsObject->vars['weightValue6'] = $finalWeight6;
$weightsObject->vars['weightValue7'] = $finalWeight7;
$weightsObject->vars['weightValue8'] = $finalWeight8;
$weightsObject->vars['weightValue9'] = $finalWeight9;
$weightsObject->vars['weightValue10'] = $finalWeight10;
$weightsObject->vars['weightValue11'] = $finalWeight11; 
$weightsObject->vars['weightValue12'] = $finalWeight12; 
$weightsObject->vars['weightValue13'] = $finalWeight13; 
$weightsObject->vars['weightValue14'] = $finalWeight14; 
$weightsObject->vars['weightValue15'] = $finalWeight15; 
$weightsObject->vars['weightValue16'] = $finalWeight16; 
$weightsObject->vars['weightValue17'] = $finalWeight17; 
$weightsObject->vars['weightValue18'] = $finalWeight18; 

//screen sizes
$weightsObject->vars['screenSize1'] = $screenSize1; 
$weightsObject->vars['screenSize2'] = $screenSize2;
$weightsObject->vars['screenSize3'] = $screenSize3;
$weightsObject->vars['screenSize4'] = $screenSize4;
$weightsObject->vars['screenSize5'] = $screenSize5;
$weightsObject->vars['screenSize6'] = $screenSize6;
$weightsObject->vars['screenSize7'] = $screenSize7;
$weightsObject->vars['screenSize8'] = $screenSize8;
$weightsObject->vars['screenSize9'] = $screenSize9;
$weightsObject->vars['screenSize10'] = $screenSize10;
$weightsObject->vars['screenSize11'] = $screenSize11; 
$weightsObject->vars['screenSize12'] = $screenSize12; 
$weightsObject->vars['screenSize13'] = $screenSize13; 
$weightsObject->vars['screenSize14'] = $screenSize14; 
$weightsObject->vars['screenSize15'] = $screenSize15; 
$weightsObject->vars['screenSize16'] = $screenSize16; 
$weightsObject->vars['screenSize17'] = $screenSize17; 
$weightsObject->vars['screenSize18'] = $screenSize18; 

$sampleObject->vars['finalWeights'] = encodeWeights($weightsObject);

$sampleObject->vars['totalFinalWeight'] = $totalFinalWeight; //this is the sum of the final weights, as read from the web form

//sieve_1_value .. sieve_10_value //percentages
$sampleObject->vars['sieve_1_value'] = $percentFinal1;
$sampleObject->vars['sieve_2_value'] = $percentFinal2;
$sampleObject->vars['sieve_3_value'] = $percentFinal3;
$sampleObject->vars['sieve_4_value'] = $percentFinal4;
$sampleObject->vars['sieve_5_value'] = $percentFinal5;
$sampleObject->vars['sieve_6_value'] = $percentFinal6;
$sampleObject->vars['sieve_7_value'] = $percentFinal7;
$sampleObject->vars['sieve_8_value'] = $percentFinal8;
$sampleObject->vars['sieve_9_value'] = $percentFinal9;
$sampleObject->vars['sieve_10_value'] = $percentFinal10;
$sampleObject->vars['sieve_11_value'] = $percentFinal11;
$sampleObject->vars['sieve_12_value'] = $percentFinal12;
$sampleObject->vars['sieve_13_value'] = $percentFinal13;
$sampleObject->vars['sieve_14_value'] = $percentFinal14;
$sampleObject->vars['sieve_15_value'] = $percentFinal15;
$sampleObject->vars['sieve_16_value'] = $percentFinal16;
$sampleObject->vars['sieve_17_value'] = $percentFinal17;
$sampleObject->vars['sieve_18_value'] = $percentFinal18;

//sieve_1_cumulative .. //DEV NOTE: It is unclear what this field is intended to be in the Back Office database structure
//sieve_1_cumulative_passing .. //DEV NOTE: It is unclear what this field is intended to be in the Back Office database structure

//plus 70
$sampleObject->vars['plus70'] = $plus70;

//plus 50
$sampleObject->vars['plus50'] = $plus50;

//plus 40
$sampleObject->vars['plus40'] = $plus40;

//minus_50_plus_140
$sampleObject->vars['neg50Plus140'] = $neg50Plus140;

//minus_40_plus_70
$sampleObject->vars['neg40Plus70'] = $neg40Plus70;

//minus_70
$sampleObject->vars['neg70'] = $neg70;

//minus_60_plus_70
$sampleObject->vars['neg60Plus70'] = $neg60Plus70;

//minus_140_plus_325
$sampleObject->vars['neg140Plus325'] = $neg140Plus325;

//minus_70_plus_140
$sampleObject->vars['neg70Plus140'] = $neg70Plus140;

//plus_140
//DEV NOTE: This field is not in the Sample Edit requirements. However it appeared on the Back Office QC Overview page.

//minus_140
$sampleObject->vars['neg140'] = $neg140;

//near_size
$sampleObject->vars['nearSize'] = $nearSize;

//check if the sample is complete, update the finish_dt field if so
$currentDateTime = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y"))); //today's date time for the database


$sampleObject->vars['isCOA'] = $isCOA;

if(checkIfSampleIsComplete($sampleId) == 1)
{
    $query = 'sp_wt_qc_SampleFinishDtCheck("' . $sampleId . '");';
    $finishDtResult = json_decode($db->get($query))[0]->finish_dt;
    if($finishDtResult == null) {
        $sampleObject->vars['finishDateTime'] = $currentDateTime;
    } else {
        $sampleObject->vars['finishDateTime'] = $currentSample[0]->finish_dt;
    }
}
else
{
    $sampleObject->vars['finishDateTime'] = '';
}

//update the sample in the database
$result = updateSample($sampleObject);
$resultSample = json_decode($db->get('sp_wt_qc_SampleGetByID("' . $sampleId . '");'));

if(checkIfSampleIsComplete($sampleId) == 1) {
    $checkQuery = 'sp_wt_qc_SampleFinishDtCheck("' . $sampleId . '");';
    $finishDtResult = json_decode($db->get($checkQuery))[0]->finish_dt;

    if ($finishDtResult == null || $finishDtResult == '') {
        $updateQuery = 'sp_wt_qc_SampleFinishDtUpdate("' . $sampleId . '");';
        $db->insert($updateQuery);
    }
}

if($resultSample[0]->is_complete == 1) {
    $db->insert('sp_wt_qc_sample_repeat_unlock("' . $sampleId . '");');
}
/****************************************************************/

//process the Plant Settings (PLC) fields
if(isset($_POST['plc']))
{
  //get the data
  $plantSettingValueArray = $_POST['plc'];
  
  //get an array of all of the samples with the same Plant and Datetime
  
  $sampleGroupObjectArray = getSamplesByPlantAndDatetimeIncludeVoided($plantId, $dt);
  //echo "DEBUG: sampleGroupObjectArray count = " . count($sampleGroupObjectArray) . "<br/>";
  
  //read the Plant Settings devices for this Plant, so we know which tags to update in the database.
  $plcArray = getPLCTagsByPlantID($plantId);
  
  if(count($plcArray) > 0)
  {
    $objectCounter = 0;
    //for each device
    foreach ($plcArray as $plcObject)
    {
      if($plantSettingValueArray[$objectCounter] != "") //make sure that the value from the web form is not empty
      {
        
        for($i = 0; $i < (count($sampleGroupObjectArray)); $i++)
        {
            //check for a PLC snapshot value in the database
            $tagObject = "";
            $tagObject = getPlantSettingsDataByTagAndSampleId($plcObject->vars["id"], $sampleGroupObjectArray[$i]->vars['id']);
            
            
            if($tagObject != NULL) //if there is already a snapshot value in the database for this tag and sample combination
            {
              //update the value
              updatePlantSettingsRecord($tagObject->vars['id'], $plantSettingValueArray[$objectCounter]);
            }
            else
            {
              //insert the value
              insertPlantSettingsRecord($sampleGroupObjectArray[$i]->vars['id'], $plcArray[$objectCounter]->vars['id'], $plantSettingValueArray[$objectCounter]);
            }
        }
      }
      $objectCounter++;
    }
  }
  
}

/***************************************************************/

//save the starting weights to the sieves in the database
if($startWeight1 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight1, $sieveStackId, $screenSize1);
}
if($startWeight2 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight2, $sieveStackId, $screenSize2);
}
if($startWeight3 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight3, $sieveStackId, $screenSize3);
}
if($startWeight4 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight4, $sieveStackId, $screenSize4);
}
if($startWeight5 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight5, $sieveStackId, $screenSize5);
}
if($startWeight6 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight6, $sieveStackId, $screenSize6);
}
if($startWeight7 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight7, $sieveStackId, $screenSize7);
}
if($startWeight8 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight8, $sieveStackId, $screenSize8);
}
if($startWeight9 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight9, $sieveStackId, $screenSize9);
}
if($startWeight10 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight10, $sieveStackId, $screenSize10);
}
if($startWeight11 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight11, $sieveStackId, $screenSize11);
}
if($startWeight12 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight12, $sieveStackId, $screenSize12);
}
if($startWeight13 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight13, $sieveStackId, $screenSize13);
}
if($startWeight14 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight14, $sieveStackId, $screenSize14);
}
if($startWeight15 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight15, $sieveStackId, $screenSize15);
}
if($startWeight16 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight16, $sieveStackId, $screenSize16);
}
if($startWeight17 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight17, $sieveStackId, $screenSize17);
}
if($startWeight18 > 0)
{
  $result2 = updateSieveStartingWeight($startWeight18, $sieveStackId, $screenSize18);
}

//save the final percentages in the database
//echo "Checking for a final percentage record in the db...<br/>";
$recordResult = getFinalPercentagesById($sampleId);
if($recordResult == 0)
{
  //echo "No final percentage records found for ID # " . $sampleId . "!<br/>";  
  //echo "Inserting a record...<br/>";
  $percentTotal = $percentFinal1 + $percentFinal2 + $percentFinal3 + $percentFinal4 + $percentFinal5 + $percentFinal6 + $percentFinal7 + $percentFinal8 + $percentFinal9 + $percentFinal10;
  
  $result3 = insertFinalPercentages($sampleId, $percentFinal1, $percentFinal2, $percentFinal3, $percentFinal4, $percentFinal5, $percentFinal6, $percentFinal7, $percentFinal8, $percentFinal9, $percentFinal10, $percentFinal11, $percentFinal12, $percentFinal13, $percentFinal14, $percentFinal15, $percentFinal16, $percentFinal17, $percentFinal18, $percentTotal);
}
else
{
  //echo "Final percentage record found!<br/>";
  
  $percentageObject->vars["sample_id"] = $sampleId;
  $percentageObject->vars["finalpercent1"] = $percentFinal1;
  $percentageObject->vars["finalpercent2"] = $percentFinal2;
  $percentageObject->vars["finalpercent3"] = $percentFinal3;
  $percentageObject->vars["finalpercent4"] = $percentFinal4;
  $percentageObject->vars["finalpercent5"] = $percentFinal5;
  $percentageObject->vars["finalpercent6"] = $percentFinal6;
  $percentageObject->vars["finalpercent7"] = $percentFinal7;
  $percentageObject->vars["finalpercent8"] = $percentFinal8;
  $percentageObject->vars["finalpercent9"] = $percentFinal9;
  $percentageObject->vars["finalpercent10"] = $percentFinal10;
  $percentageObject->vars["finalpercent11"] = $percentFinal11;
  $percentageObject->vars["finalpercent12"] = $percentFinal12;
  $percentageObject->vars["finalpercent13"] = $percentFinal13;
  $percentageObject->vars["finalpercent14"] = $percentFinal14;
  $percentageObject->vars["finalpercent15"] = $percentFinal15;
  $percentageObject->vars["finalpercent16"] = $percentFinal16;
  $percentageObject->vars["finalpercent17"] = $percentFinal17;
  $percentageObject->vars["finalpercent18"] = $percentFinal18;
  
  $percentTotal = $percentFinal1 + $percentFinal2 + $percentFinal3 + $percentFinal4 + $percentFinal5 + $percentFinal6 + $percentFinal7 + $percentFinal8 + $percentFinal9 + $percentFinal10 + $percentFinal11 + $percentFinal12 + $percentFinal13 + $percentFinal14 + $percentFinal15 + $percentFinal16 + $percentFinal17 + $percentFinal18;
  $percentageObject->vars["finalpercenttotal"] = $percentTotal;

  $result3 = updateFinalPercentages($percentageObject);
  //echo $result;

}

/***************************************************************/

//check if this is a repeatability pair and reset the user's repeatability count if so

//check if there is a pair where this sample is the Original sample
$pairObject = NULL;
$pairObject = getRepeatabiltySamplePairByOriginalSample($sampleId);
//if this sample is part of a pair
if($pairObject != NULL)
{
  //check if both samples are complete //if both samples are complete then reset the user's repeatability counter
  if((checkIfSampleIsComplete($pairObject->vars["original_sample"]) == 1) && (checkIfSampleIsComplete($pairObject->vars["repeated_sample"]) == 1))
  {
    //both samples are complete
    //reset the user's repeatability counter
    updateRepeatability($userId, 100);
  }
}

//check if there is a pair where this sample is the Repeated sample
$pairObject = NULL;
$pairObject = getRepeatabiltySamplePairByRepeatedSample($sampleId);

//if this sample is part of a pair
if($pairObject != NULL)
{
   //check if both samples are complete //if both samples are complete then reset the user's repeatability counter
  if((checkIfSampleIsComplete($pairObject->vars["original_sample"]) == 1) && (checkIfSampleIsComplete($pairObject->vars["repeated_sample"]) == 1))
  {
    //both samples are complete
    //reset the user's repeatability counter
    updateRepeatability($userId, 100);
  }
}

/***************************************************************/

//DEV NOTE: Added this section in KACE 18968.
//check if a sample completion message should be sent and send it if so

$sampleCompletionFound = 0;
$siteObject = NULL;
$locationObject = NULL;
$sampleIDs = NULL;
$sampleObject = NULL;

$siteObject = getSiteById($siteId);
$locationObject = getLocationById($locationId);

$sampleIDs = "";

//check if the send_completion_message flag is set for this sample's location
if($locationObject->vars['send_completion_message'] == 1)
{
  if($debugging == 1)
    echo("DEBUG: This location is flagged to send emails.<br/>");
  
  //get the group ID for this sample
  $groupID = sampleGroupIDGetBySampleID($sampleId);   
  
  if($debugging == 1)
    echo("DEBUG: groupID == " . $groupID . "<br/>");
  
  if($groupID != NULL)
  {   

    //get an array of other sample IDs from the same group
    $sampleArray = sampleIDsGetByGroupID($groupID); 
      
    //iterate through each sample and check if they are complete.
    $allSamplesComplete = 1;
    for($i = 0; $i < count($sampleArray); $i++)
    {
      if($debugging == 1)
        echo("DEBUG: looking at sample # " . $sampleArray[$i] . "<br/>");
      
      //read the sample data into a temporary object.
      $sampleObject = getSampleById($sampleArray[$i]);
      
      //if the iterator sample is active (not voided)
      if($sampleObject->vars['voidStatusCode'] == 'A')
      {
        if($debugging == 1)
          echo("DEBUG: the sample is active<br/>");
        
        //if the iterator sample is not complete
        if($sampleObject->vars['isComplete'] != 1)
        {
          $allSamplesComplete = 0;
        }
        else
        {
          if($debugging == 1)
            echo("DEBUG: the sample is complete<br/>");
          
          //build a string listing the sample ID numbers for use in the email
          if($i == 0) //if this is the first ID in a list, then don't add a comma
          {
            $sampleIDs = $sampleArray[$i]; 
          }
          else
          {
            $sampleIDs = $sampleIDs . ", " . $sampleArray[$i]; //else add a comma and concatenate
          }
        }
      }
    }
    
    if($allSamplesComplete == 1)
    {
      //then generate the email message to the mailing list.
      //$emailResult = sendQCSampleCompletionNotification($debugging, $siteObject->vars['description'], $sampleIDs);
    }
  
  }   
}

/***************************************************************/

//send the user to the next page

if($result == 1)
{
    if($isCOA == 1) {
        if($userPermissionsArray['vista']['granbury']['qc'] > 3) {
            include('../../Includes/QC/coa_process.php');
        } else {
            header('Location: ../../Controls/QC/wt_samples.php?view=summary&completionStatus=Incomplete&void=A');
        }
        //header('Location: ../../Includes/QC/coa_pdf.php?sampleId=' . $sampleId . '&labtech=' . $labTech . '&weights=' . json_encode($weightsObject) . '&percentages=' . json_encode($percentageObject));
    } else {
        header('Location: ../../Controls/QC/wt_samples.php?view=summary&completionStatus=Incomplete&void=A');
    }
}
else
{
  //redirect back to the edit page
  //header('Location: ../../Controls/QC/wt_sampleedit.php?sampleId=' . $sampleId);
}

/***************************************************************/

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

/***************************************
* Name: setValue($argString)
* Description: This function looks to see if the parameter is set. 
* If so, then it returns the value.
* If not, then it returns a 0.
****************************************/
function setValue($argString)
{
  if (strlen($argString) > 0) 
  {
    return $argString;
  }
  else 
  {
    return "0";
  }
}

//====================================================================== END PHP
?>