<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_scorecardpasser.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/13/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
    
$json_string = file_get_contents("../../Includes/JSON/tl_scorecardsettings.json");
$settings_json = json_decode($json_string, true);
$settingsArry = $settings_json;

echo $settingsArry['July2018']['NetSetting'];
print_r($json_string);
//echo $netSet;
//$settingsArry['July'][0]['NetSetting'] = "3700";
   //create an array
//$emparray = array();
//   while($row =mysqli_fetch_assoc($result))
//   {
//       $emparray[] = $row;
//   }
//   echo json_encode($emparray);

 $newSettings= array( 'August2018' => array("NetSetting"=>"3700" , "SiloSetting" => "3500")) ;
 $allSettings = array_push($settingsArry, $newSettings);

         
 //print_r($newSettings);
 echo "<br>";
//array_push($settingsArry, $newSettings);
print_r($allSettings);
//
//   $fp = fopen('../JSON/tl_scorecardsettings.json', 'w');
//  fwrite($fp, json_encode(array_values($allSettings)));
//   fclose($fp);

//========================================================================================== END PHP
?>

<!-- HTML -->