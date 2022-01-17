<?php
/* * *****************************************************************************************************************************************
 * File Name: devAdminFunctions.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/10/2018|nolliff|KACE:xxxxx - Initial creation
 * 01/10/2018|nolliff|KACE:xxxxx - Added inital functions for db connections and string manipulation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
function dbmysqli()
{
  try
    {
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
    (
      $dbc['silicore_hostname'],
      $dbc['silicore_username'],
      $dbc['silicore_pwd'],
      $dbc['silicore_dbname']
    );
    return $dbconn;
    
    mysqli_close($dbconn);
    }
  catch (Exception $e)
  {
    $_SESSION['sample_error'] = "Error while trying to get data" . $e;   
  }
}


//========================================================================================== END PHP
?>

<!-- HTML -->