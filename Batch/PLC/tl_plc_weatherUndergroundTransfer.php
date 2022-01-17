<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_plc_weatherUndergroundTransfer.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/16/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
require_once('../../Includes/Production/productionfunctions.php');
require_once('../../Includes/emailfunctions.php');

//var_dump(dbMySQL());
error_reporting(E_ALL);
ini_set('display_errors', 1);
try
{
  $weatherQuery = "CALL sp_tl_plc_RainfallMaxDateGet()";
  
  $latestWeatherDateResult = dbmysqli()->query($weatherQuery);
  

  
//  if(!$latestWeatherDateResult)
//    {
//      throw new Exception(mysqli_error($dbcSiteName));
//    }
 } 
  catch (Exception $ex) 
 {
  echo(("Exception: " . $catchError . "<br /><br />Error message: " . $ex->getMessage() . "<br /><br />"));
  exit("Stopping PHP execution");
 }
 
 while($latestDateResult = mysqli_fetch_assoc($latestWeatherDateResult))
   {
       $latestDate = new DateTime($latestDateResult["max(date)"]);
       $latestDate->modify('+1 day');
       $urlDate = $latestDate->format("Ymd");
       echo $urlDate;
	}
echo $urlDate . "<br>'";
  if($latestDate == "" or $latestDate == null)
    {
      //$urlDate = "0101";
    }

while($urlDate < date('Ymd'))
  {

    echo $urlDate . "<br>";
    $jsonUrl = "http://api.wunderground.com/api/a4157e124fae52d8/history_{$urlDate}/q/pws:KTXTOLAR5.json";
    //$jsonUrl = "../../Includes/KTXGRANB34.json";
    $json_string = file_get_contents($jsonUrl);
    $parsed_json = json_decode($json_string,true);
    $weatherArry = $parsed_json['history']['dailysummary'][0];
    $rainfall = $weatherArry['precipi'];
    $wind = $weatherArry['meanwindspdi'];
    $high_temp = $weatherArry['maxtempi'];;
    $low_temp = $weatherArry['mintempi'];


    if($rainfall == '' || $rainfall == null)
      {
          $jsonUrl = "http://api.wunderground.com/api/a4157e124fae52d8/history_{$urlDate}/q/TX/Tolar.json";
          //$jsonUrl = "../../Includes/KTXGRANB34.json";
          $json_string = file_get_contents($jsonUrl);
     
          $parsed_json = json_decode($json_string,true);
          $weatherArry = $parsed_json['history']['dailysummary'][0];
          $rainfall = $weatherArry['precipi'];
          $wind = $weatherArry['meanwindspdi'];
          $high_temp = $weatherArry['maxtempi'];;
          $low_temp = $weatherArry['mintempi'];
      }
      
    echo $jsonUrl;
    echo "Current rainfall is: $rainfall \n";
    echo "Current high temp is: $high_temp \n";
    echo "Current low temp is: $low_temp \n";
   try
  {
     $insertDate = $latestDate -> format('Y-m-d');
    $weatherInsertQuery = "CALL sp_tl_plc_RainfallInsert('" . $insertDate . "'," . $rainfall . "," . $wind . "," . $high_temp . "," . $low_temp . ")";
    echo "<br>" . $weatherInsertQuery . "<br>";

    $weatherInsertQueryResult = dbmysqli()->query($weatherInsertQuery);


   } 
    catch (Exception $ex) 
   {
    echo(("Exception: " . $catchError . "<br /><br />Error message: " . $ex->getMessage() . "<br /><br />"));
    exit("Stopping PHP execution");
   }
    $latestDate->modify('+1 day');
    $urlDate = $latestDate->format("Ymd");
    $i++;
  }
 


//========================================================================================== END PHP
?>

<!-- HTML -->