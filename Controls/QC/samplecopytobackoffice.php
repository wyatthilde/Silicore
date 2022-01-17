<?php
/* * *****************************************************************************************************************************************
 * File Name: samplecopytobackoffice.php
 * Project: Silicore
 * Description: This file contains functions for transferring Quality Control Samples from Silicore to Back Office.
 * Notes: This code should be called when a sample group is created in Silicore; or when a sample is edited in Silicore.
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/26/2017|mnutsch|KACE:17366 - Initial creation
 * 07/31/2017|mnutsch|KACE:17756 - Modified the SQL query for inserting records in Back Office.
 * 08/08/2017|mnutsch|KACE:17803 - I commented out the sendErrorMessage function calls due to info missing from the Back Office DB. See KACE # 17878.
 * 08/16/2017|mnutsch|KACE:17957 - Updated saving of ranges to Back Office when saving an edit.
 * 08/16/2017|mnutsch|KACE:17957 - Added code to handle blank fields.
 * 08/22/2017|mnutsch|KACE:17957 - Added getBackOfficeSampleById() function to look for sample in Back Office.
 * 10/20/2017|mnutsch|KACE:19205 - Added code to set Sampler, Operator, and Labtech to "unknown" if no value was received.
 * 
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

//include other files
require_once('../../Includes/Security/dbaccess.php'); //contains database connection info
require_once('../../Includes/security.php'); //contains functions for accessing Silicore user info
require_once('../../Includes/emailfunctions.php'); //contains functions sending error message emails


/*
 //TEST USAGE of the insert process
 
 //declare the variables to use
  $sampleId = NULL;
  $testTypeId = NULL;
  $compositeTypeId = NULL;
  $siteId = NULL;
  $plantId = NULL;
  $locationId = NULL;
  $dt = NULL;
  $date = NULL;
  $dateShort = NULL;
  $dtShort = NULL;
  $time = NULL;
  $groupTime = NULL;
  $labTech = NULL;
  $sampler = NULL;
  $operator = NULL;
  $userId = NULL;

  $operatorObject = NULL;
  $operatorName = NULL;
  $samplerObject = NULL;
  $samplerName = NULL;
  $labTechObject = NULL;
  $labTechName = NULL;

  $backOfficeUserID = NULL;

  //debug - set the values to test the script
  $sampleId = "999999";
  $testTypeId = 2;
  $compositeTypeId = 1;
  $siteId = 10;
  $plantId = 3;
  $locationId = 69;
  $dt = "2017-01-01 01:02:03";
  $date = "2017-01-01";
  $dateShort = "20170101";
  $dtShort = "201701010102";
  $time = "01:02:03";
  $groupTime = "01:00:00";
  $labTech = 14;
  $sampler = 14;
  $operator = 14;
  $userId = 14;

  insertSampleIntoBackOffice($sampleId, $testTypeId, $compositeTypeId, $siteId, $plantId, $locationId, $dt, $date, $dateShort, $dtShort, $time, $groupTime, $labTech, $sampler, $operator, $userId);
*/

/*******************************************************************************
* Function Name: insertSampleIntoBackOffice()
* Description: 
* This function will: 
* Take numerous values as parameters.
* Create a record in the database table gb_qc_samples.
* Return a value to confirm success.
*******************************************************************************/
function insertSampleIntoBackOffice($sampleId, $testTypeId, $compositeTypeId, $siteId, $plantId, $locationId, $dt, $date, $dateShort, $dtShort, $time, $groupTime, $labTech, $sampler, $operator, $userId)
{
  $errorMessage = "samplecopytobackoffice.php - insertSampleIntoBackOffice() ";  
  $returnValue = 0;
  
  try
  {
 
    //translate lab tech from a Silicore ID to a text string
    if((isset($labtech)) && ($labtech != ""))
    {
      $labTechObject = getUser($labTech); //requires security.php
      $labTechName = $labTechObject->vars['display_name'];
    }
    else
    {
      $labTechName = "unknown";
    }

    //translate sampler from a Silicore ID to a text string
    if((isset($sampler)) && ($sampler != ""))
    {
      $samplerObject = getUser($sampler); //requires security.php
      $samplerName = $samplerObject->vars['display_name'];
    }
    else
    {
      $samplerName = "unknown";
    }

    //translate operator from a Silicore ID to a text string
    if((isset($operator)) && ($operator != ""))
    {
      $operatorObject = getUser($operator); //requires security.php
     $operatorName = $operatorObject->vars['display_name'];
    }
    else
    {
      $operatorName = "unknown";
    }

    //translate userId from a Silicore user to a BackOffice user
    $backOfficeUserID = 0;
    $backOfficeUserID = getBackOfficeUserBySilicoreID($userId); //requires security.php
    
    $currentDateTime = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y"))); //today's date time for the database
/*
    //debug - show us the values received
    echo("DEBUG: sampleId = " . $sampleId . "<br/>");
    echo("DEBUG: testTypeId = " . $testTypeId . "<br/>");
    echo("DEBUG: compositeTypeId = " . $compositeTypeId . "<br/>");
    echo("DEBUG: siteId = " . $siteId . "<br/>");
    echo("DEBUG: plantId = " . $plantId . "<br/>");
    echo("DEBUG: locationId = " . $locationId . "<br/>");
    echo("DEBUG: dt = " . $dt . "<br/>");
    echo("DEBUG: date = " . $date . "<br/>");
    echo("DEBUG: dateShort = " . $dateShort . "<br/>");
    echo("DEBUG: dtShort = " . $dtShort . "<br/>");
    echo("DEBUG: time = " . $time . "<br/>");
    echo("DEBUG: groupTime = " . $groupTime . "<br/>");
    echo("DEBUG: labTechName = " . $labTechName . "<br/>");
    echo("DEBUG: samplerName = " . $samplerName . "<br/>");
    echo("DEBUG: operatorName = " . $operatorName . "<br/>");
    echo("DEBUG: backOfficeUserID = " . $backOfficeUserID . "<br/>");

    echo("DEBUG: currentDateTime = " . $currentDateTime . "<br/>");
*/
    //connect to the Back Office database
    $backOfficeDatabaseConnection = connectToBackOfficeMySQL();
    //echo("DEBUG: backOfficeDatabaseConnection = " . var_dump($backOfficeDatabaseConnection) . "<br/>");

    //insert the sample into the Back Office database
    //TABLE NAME IS prod_qc_samples
    $sql = "INSERT INTO prod_qc_samples (id, create_dt, create_user_id, test_type_id, composite_type_id, site_id, plant_id, location_id, dt, date, date_short, dt_short, time, group_time, shift_date, lab_tech, sampler, operator, shift, is_removed) VALUES ('" . $sampleId . "', '" . $currentDateTime . "', $backOfficeUserID, $testTypeId, $compositeTypeId, $siteId, $plantId, $locationId, '" . $dt . "', '" . $date . "', $dateShort, $dtShort, '" . $time . "', '" . $groupTime . "', '" . $date . "', '" . $labTechName . "', '" . $samplerName . "', '" . $operatorName . "', '', '0')"; //direct SQL method

    //echo "DEBUG: Back Office SQL = " . $sql . "<br/>";
    
    //direct SQL method to check status
    if ($backOfficeDatabaseConnection->query($sql) === TRUE) 
    {
      $returnValue = mysqli_insert_id($backOfficeDatabaseConnection);
      //echo("DEBUG: record inserted successfully.<br/>");
    } 
    else 
    {
      $errorMessage = $errorMessage . "Error inserting a sample into the BACK OFFICE database.";
      //echo "DEBUG: " . $errorMessage;
      //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      
      $result = 0;
    }

    //close the connection to the Back Office database
    disconnectFromBackOfficeMySQL($backOfficeDatabaseConnection);
    
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error inserting a sample into BACK OFFICE MySQL.";
    //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      $error = $e->getMessage();
      echo $error;
    }
    
    $returnValue = 0;
  }
  
  return $returnValue;
}


/*******************************************************************************
* Function Name: updateBackOfficeSample($sampleObject)
* Description: 
* This function will: 
* Accept an object containing sample info as an argument.
* Update the sample in the Back Office database.
* The sample will be identified based on the sample id.
*******************************************************************************/
function updateBackOfficeSample($sampleObject)
{
  $errorMessage = "samplecopytobackoffice.php - updateBackOfficeSample() ";
  
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {
    $currentDateTime = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y"))); //today's date time for the database

    $mySQLConnectionLocal = connectToBackOfficeMySQL(); //connect to the database
  
    $userId = $sampleObject->vars["userId"];
    $id = $sampleObject->vars["id"];
    $siteId = $sampleObject->vars['siteId'];
    $plantId = $sampleObject->vars['plantId'];
    $dt = $sampleObject->vars['dt'];
    $testTypeId = $sampleObject->vars['testTypeId'];
    $compositeTypeId = $sampleObject->vars['compositeTypeId'];
    $sieveStackId = $sampleObject->vars['sieveStackId'];
    $locationId = $sampleObject->vars['locationId'];
    $specificLocationId = $sampleObject->vars['specificLocationId'];
    $date = $sampleObject->vars['date'];
    $time = $sampleObject->vars['time'];
    $dateShort = $sampleObject->vars['dateShort'];
    $dtShort = $sampleObject->vars['dtShort'];
    
    $drillholeNo = $sampleObject->vars['drillholeNo'];
    $depthFrom = $sampleObject->vars['depthFrom'];
    $depthTo = $sampleObject->vars['depthTo'];
    $slimes = $sampleObject->vars['slimes'];
    $oversizeWeight = $sampleObject->vars['oversizeWeight'];
    $oversizePercent = $sampleObject->vars['oversizePercent'];
    
    $description = $sampleObject->vars['description'];
    $sampler = $sampleObject->vars['sampler'];
    $labTech = $sampleObject->vars['labTech'];
    $operator = $sampleObject->vars['operator'];
    $beginningWetWeight = $sampleObject->vars['beginningWetWeight'];
    $preWashDryWeight = $sampleObject->vars['preWashDryWeight'];
    $postWashDryWeight = $sampleObject->vars['postWashDryWeight'];
    $splitSampleWeight = $sampleObject->vars['splitSampleWeight'];
    $moistureRate = $sampleObject->vars['moistureRate'];
    $notes = $sampleObject->vars['notes'];
    $turbidity = $sampleObject->vars['turbidity'];
    $kValue = $sampleObject->vars['kValue'];
    $kPan1 = $sampleObject->vars['kPan1'];
    $kPan2 = $sampleObject->vars['kPan2'];
    $kPan3 = $sampleObject->vars['kPan3'];
    $roundness = $sampleObject->vars['roundness'];
    $sphericity = $sampleObject->vars['sphericity'];
    $groupTime = $sampleObject->vars['groupTime'];
    $startWeights = $sampleObject->vars['startWeights'];
    $endWeights = $sampleObject->vars['endWeights'];
    //dev note: it is unclear where the final weigths were intended to be stored in the database.
    //We are making the assumption that finalWeights and sieves_raw are the same thing.
    $finalWeights = $sampleObject->vars['finalWeights']; 
    $totalFinalWeight = $sampleObject->vars['totalFinalWeight']; //this is a sum of the final sieve weights

    //sieve_1_value ..
    $percentFinal1 = $sampleObject->vars['sieve_1_value'];
    $percentFinal2 = $sampleObject->vars['sieve_2_value'];
    $percentFinal3 = $sampleObject->vars['sieve_3_value'];
    $percentFinal4 = $sampleObject->vars['sieve_4_value'];
    $percentFinal5 = $sampleObject->vars['sieve_5_value'];
    $percentFinal6 = $sampleObject->vars['sieve_6_value'];
    $percentFinal7 = $sampleObject->vars['sieve_7_value'];
    $percentFinal8 = $sampleObject->vars['sieve_8_value'];
    $percentFinal9 = $sampleObject->vars['sieve_9_value'];
    $percentFinal10 = $sampleObject->vars['sieve_10_value'];
    
    //sieve_1_desc ..
    $screenSize1 = $sampleObject->vars['screenSize1']; 
    $screenSize2 = $sampleObject->vars['screenSize2'];
    $screenSize3 = $sampleObject->vars['screenSize3'];
    $screenSize4 = $sampleObject->vars['screenSize4'];
    $screenSize5 = $sampleObject->vars['screenSize5'];
    $screenSize6 = $sampleObject->vars['screenSize6'];
    $screenSize7 = $sampleObject->vars['screenSize7'];
    $screenSize8 = $sampleObject->vars['screenSize8'];
    $screenSize9 = $sampleObject->vars['screenSize9'];
    $screenSize10 = $sampleObject->vars['screenSize10']; //this value is always "PAN"
    
    //plus 70
    $plusSeventy = $sampleObject->vars['plusSeventy'];

    //minus_40_plus_70
    $negFortyPlusSeventy = $sampleObject->vars['negFortyPlusSeventy'];

    //minus_70
    $negSeventy = $sampleObject->vars['negSeventy'];

    //minus_70_plus_140
    $negSeventyPlusOneForty = $sampleObject->vars['negSeventyPlusOneForty'];

    //plus_140
    //DEV NOTE: This field is not in the Sample Edit requirements. However it appeared on the Back Office QC Overview page.

    //minus_140
    $negOneForty = $sampleObject->vars['negOneForty'];
    
    //finish_dt 
    $finishDatetime = $sampleObject->vars['finishDatetime'];
    
    //echo "DEBUG: finishDatetime = " . $finishDatetime . "<br/>";
    
    //calculate duration and duration_minutes
    $duration = "";
    $duration_minutes = "";
    if($finishDatetime != "")
    {
      $dt_time = strtotime($dt);
      $finishDatetime_time = strtotime($finishDatetime);
      $duration = round((abs($finishDatetime_time - $dt_time) / 3600),2); //hours    
      $duration_minutes = round((abs($finishDatetime_time - $dt_time) / 60),2); //minutes
      
      //prevent overflow situations where the user might not finish a sample for a really long time
      if($duration > 999)
      {
        $duration = 999;
      }
      if($duration_minutes > 999)
      {
        $duration_minutes = 999;
      }
      
    }
    else
    {
      $duration = "";
      $duration_minutes = "";
    }
  
    //echo "DEBUG: finishDatetime = " . $finishDatetime . "<br/>";
    //echo "DEBUG: duration = " . $duration . "<br/>";
    //echo "DEBUG: duration_minutes = " . $duration_minutes . "<br/>";
    
    //direct SQL method
    if($finishDatetime == "") //necessary to solve a bug involving saving a null value 
    {
      $finishDatetime = "null";
    }
    else
    {
      $finishDatetime = "'" . $finishDatetime . "'";
    }
    
    if($duration == "") //necessary to solve a bug involving saving a null value 
    {
      $duration = "null";
    }
    else
    {
      $duration = "'" . $duration . "'";
    }
    
    if($duration_minutes == "") //necessary to solve a bug involving saving a null value
    {
      $duration_minutes = "null";
    }
    else
    {
      $duration_minutes = "'" . $duration_minutes . "'";
    }
    
    //translate lab tech from a Silicore ID to a text string
    if(($labTech == NULL) || ($labTech == ""))
    {
      $labTechName = "unknown";      
    }
    else
    {
      $labTechObject = getUser($labTech); //requires security.php
      $labTechName = $labTechObject->vars['display_name'];
    }
    
    //translate sampler from a Silicore ID to a text string
    if(($sampler == NULL) || ($sampler == ""))
    {
      $samplerName = "unknown";
    }
    else
    {
      $samplerObject = getUser($sampler); //requires security.php
      $samplerName = $samplerObject->vars['display_name'];
    }

    //translate operator from a Silicore ID to a text string
    if(($operator == NULL) || ($operator == ""))
    {
      $operatorName = "unknown";
    }
    else
    {
      $operatorObject = getUser($operator); //requires security.php
      $operatorName = $operatorObject->vars['display_name'];
    }

    //translate userId from a Silicore user to a BackOffice user
    $backOfficeUserID = 0;
    if(($userId == NULL) || ($userId == ""))
    {
      $backOfficeUserID = 0;
    }
    else
    {
      $backOfficeUserID = getBackOfficeUserBySilicoreID($userId); //requires security.php
    }
    
    $sql = "UPDATE prod_qc_samples SET `edit_dt` = '$currentDateTime', `edit_user_id` = '$backOfficeUserID', `site_id` = '$siteId', `plant_id` = '$plantId', `dt` = '$dt', `test_type_id` = '$testTypeId', `composite_type_id` = '$compositeTypeId', `sieve_method_id` = '$sieveStackId', `location_id` = '$locationId', `specific_location_id` = '$specificLocationId', `date` = '$date', `time` = '$time', `date_short` = '$dateShort', `dt_short` = '$dtShort', `oversize_percent` = '$oversizePercent', `oversize_weight` = '$oversizeWeight', `slimes_percent` = '$slimes', `depth_to` = '$depthTo', `depth_from` = '$depthFrom', `drillhole_no` = '$drillholeNo', `description` = '$description', `sampler` = '$samplerName', `lab_tech` = '$labTechName', `operator` = '$operatorName', `beginning_wet_weight` = '$beginningWetWeight', `prewash_dry_weight` = '$preWashDryWeight', `postwash_dry_weight` = '$postWashDryWeight', `split_sample_weight` = '$splitSampleWeight', `moisture_rate` = '$moistureRate', `notes` = '$notes', `turbidity` = '$turbidity', `k_value` = '$kValue', `k_pan_1` = '$kPan1', `k_pan_2` = '$kPan2', `k_pan_3` = '$kPan3', `roundness` = '$roundness', `sphericity` = '$sphericity', `group_time` = '$groupTime', `start_weights_raw` = '$startWeights', `end_weights_raw` = '$endWeights', `sieves_raw` = '$finalWeights', `sieves_total` = '$totalFinalWeight', `sieve_1_value` = '$percentFinal1', `sieve_2_value` = '$percentFinal2', `sieve_3_value` = '$percentFinal3', `sieve_4_value` = '$percentFinal4', `sieve_5_value` = '$percentFinal5', `sieve_6_value` = '$percentFinal6', `sieve_7_value` = '$percentFinal7', `sieve_8_value` = '$percentFinal8', `sieve_9_value` = '$percentFinal9', `sieve_10_value` = '$percentFinal10', `sieve_1_desc` = '$screenSize1', `sieve_2_desc` = '$screenSize2', `sieve_3_desc` = '$screenSize3', `sieve_4_desc` = '$screenSize4', `sieve_5_desc` = '$screenSize5', `sieve_6_desc` = '$screenSize6', `sieve_7_desc` = '$screenSize7', `sieve_8_desc` = '$screenSize8', `sieve_9_desc` = '$screenSize9', `sieve_10_desc` = '$screenSize10', `plus_70` = '$plusSeventy', `minus_40_plus_70` = '$negFortyPlusSeventy', `minus_70` = '$negSeventy', `minus_70_plus_140` = '$negSeventyPlusOneForty', `minus_140` = '$negOneForty', `finish_dt` = $finishDatetime, `duration` = $duration, `duration_minutes` = $duration_minutes WHERE `id` = '$id';";
    
    //echo "DEBUG: SQL = " . $sql . "<br/>";
        
    if($mySQLConnectionLocal->query($sql) === TRUE) //direct SQL method
    {
      //echo "Record updated successfully<br/>";
      $returnValue = 1;
    } 
    else 
    {
      echo "Error updating record: " . $mySQLConnectionLocal->error . "<br/>";
      $returnValue = 0;
    }
    
    disconnectFromBackOfficeMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error updating a Back Office sample. ";
    $errorMessage = $errorMessage . "SQL = " . $sql . " ";
    //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;

      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $returnValue;
}


/*******************************************************************************
* Function Name: connectToBackOfficeMySQL()
* Description: 
* This function will: 
* Connect to MySQL.
* The connection information should be stored as constants, defined in an included file.
* The connection will be stored in a global variable called $GLOBALS['conn'];
* The function will return the connection object if the connection was made and 0 if not.
*******************************************************************************/
function connectToBackOfficeMySQL()
{
  $errorMessage = "Page: samplecopytobackoffice.php"; 
  
  //echo "DEBUG: databaseConnectionInfo = ";
  //echo var_dump(databaseConnectionInfo());  
  
  try
  {
	$mySQLConnection = 0; //used to track if the database is connected.
	
	$mysql_dbname = BACKOFFICE_DB_DBNAME; 
	$mysql_username = BACKOFFICE_DB_USER;
	$mysql_pw = BACKOFFICE_DB_PWD;
	$mysql_hostname = BACKOFFICE_DB_HOST;
	  
	// Create connection
	$mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);
	  
	// Check connection
	if ($mySQLConnection->connect_error) 
	{
	  $errorMessage = $errorMessage . "Error connecting to the Back Office MySQL database.";
	  sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	  if($debugging == 1)
	  {
	    echo $errorMessage;
	  }
	  //echo "Error connecting to MySQL: <br>" . $mySQLConnection->error;
	  
	  return 0;
	}
	else
	{
	  return $mySQLConnection;
	}
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the Back Office MySQL database.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
    return 0;
  }
}

/*******************************************************************************
* Function Name: disconnectFromBackOfficeMySQL()
* Description: 
* This function will: 
* Disconnect from MySQL.
*******************************************************************************/
function disconnectFromBackOfficeMySQL($mySQLConnection)
{
  $errorMessage = "Page: samplecopytobackoffice.php"; 
  try
  {	
    $mySQLConnection->close();
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error disconnecting from the Back Office MySQL database.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
}


/*******************************************************************************
* Function Name: getBackOfficeSampleById($argId)
* Description: 
* This function will: 
* Take an ID # as a parameter.
* Return an object containing the sample information.
*******************************************************************************/
function getBackOfficeSampleById($argId)
{
  $errorMessage = "qcfunctions.php - getBackOfficeSampleById() "; 
  $sampleObject = NULL;
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
    $mySQLConnectionLocal = connectToBackOfficeMySQL(); //connect to the database
    
    $sql = "SELECT * FROM prod_qc_samples WHERE id = $argId LIMIT 1"; //direct SQL method
    $result =  $mySQLConnectionLocal->query($sql); //direct SQL method
    
    //echo "DEBUG: SQL = " . $sql . "<br/>";
    
    while($row = $result->fetch_array())
    {
      $sampleObject->vars["id"] = $row[0];//sample no
      $sampleObject->vars["description"] = $row[1];//description
      $sampleObject->vars["testType"] = $row[3];//test type
      $sampleObject->vars["compositeType"] = $row[4];
      $sampleObject->vars["sieveMethod"] = $row[5];// Sieve Stack - FKA Sieve Method
      $sampleObject->vars["siteId"] = $row[6];//site
      $sampleObject->vars["plantId"] = $row[7];//plant
      $sampleObject->vars["location"] = $row[8];
      $sampleObject->vars["specificLocation"] = $row[9];
      $sampleObject->vars["date"] = $row[10];
      $sampleObject->vars["time"] = $row[12];
      $sampleObject->vars["finish_dt"] = $row[15];
      $sampleObject->vars["dt"] = $row[18];
      $sampleObject->vars["shift"] = $row[21];
      $sampleObject->vars["labTech"] = $row[23];
      $sampleObject->vars["sampler"] = $row[22];
      $sampleObject->vars["operator"] = $row[24];
      $sampleObject->vars["notes"] = $row[43];
      $sampleObject->vars["labTech"] = $row[23];//lab tech
      $sampleObject->vars["sampler"] = $row[22];//sampler
      $sampleObject->vars["operator"] = $row[24];//operator
      $sampleObject->vars["drillholeNo"] = $row[31];//drillhole no
      $sampleObject->vars["depthFrom"] = $row[32];
      $sampleObject->vars["depthTo"] = $row[33];
      $sampleObject->vars["beginningWetWeight"] = $row[34];//beg wet weight
      $sampleObject->vars["preWashDryWeight"] = $row[35];//pre-wash dry weight
      $sampleObject->vars["postWashDryWeight"] = $row[36];//post-wash dry weight
      $sampleObject->vars["oversizeWeight"] = $row[37];
      $sampleObject->vars["splitSampleWeight"] = $row[38];//split sample weight
      $sampleObject->vars["splitSampleWeightDelta"] = $row[39];
      $sampleObject->vars["oversizePercent"] = $row[40];
      $sampleObject->vars["slimesPercent"] = $row[41];//slimes percent
      $sampleObject->vars["moistureRate"] = $row[30];//moisture rate
      $sampleObject->vars["turbidity"] = $row[45];//turbidity
      $sampleObject->vars["kValue"] = $row[49];//k value
      $sampleObject->vars["pan1"] = $row[50];//pan 1
      $sampleObject->vars["pan2"] = $row[51];//pan 2
      $sampleObject->vars["pan3"] = $row[52];//pan 3
      $sampleObject->vars["roundness"] = $row[59];//roundness
      $sampleObject->vars["sphericity"] = $row[60];//sphericity
      
      $sampleObject->vars["sieve1Value"] = $row[62];//sieve values
      $sampleObject->vars["sieve2Value"] = $row[66];//sieve values
      $sampleObject->vars["sieve3Value"] = $row[70];//sieve values
      $sampleObject->vars["sieve4Value"] = $row[74];//sieve values
      $sampleObject->vars["sieve5Value"] = $row[78];//sieve values
      $sampleObject->vars["sieve6Value"] = $row[82];//sieve values
      $sampleObject->vars["sieve7Value"] = $row[86];//sieve values
      $sampleObject->vars["sieve8Value"] = $row[90];//sieve values
      $sampleObject->vars["sieve9Value"] = $row[94];//sieve values
      $sampleObject->vars["sieve10Value"] = $row[98];//sieve values
            
      $sampleObject->vars["totalFinalWeight"] = $row[101]; //sum of the final sieve weigths
      
      $sampleObject->vars["startWeightsRaw"] = $row[102];
      $sampleObject->vars["endWeightsRaw"] = $row[103];
      $sampleObject->vars["finalWeightsRaw"] = $row[104];
      
    }
    
    disconnectFromBackOfficeMySQL($mySQLConnectionLocal);
    
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error querying MySQL for a sample by ID.";
    $errorMessage = $errorMessage . "SQL = " . $sql . " ";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $sampleObject;
}

//========================================================================================== END PHP
?>

<!-- HTML -->