<?php
 	require_once('../../Includes/security.php');
	require_once ('../../silicore/Includes/Security/dbaccess.php');
    require_once('../../Includes/Production/productionfunctions.php');

   //fetch table rows from mysql db
   $sql = "CALL sp_gb_plc_rainfallGet";
   echo $sql;
   $result = dbmysqli()->query($sql); 

   //create an array
   $emparray = array();
   while($row =mysqli_fetch_assoc($result))
   {
       $emparray[] = $row;
   }

    //Convert PHP Array to JSON String
   echo json_encode($emparray);
    
    
    //OR write to json file
   $fp = fopen('../../Includes/JSON/gb_weatherdata.json', 'w');
   fwrite($fp, json_encode($emparray));
   fclose($fp);
?>