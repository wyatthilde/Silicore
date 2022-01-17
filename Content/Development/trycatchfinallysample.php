<?php
/* * *****************************************************************************************************************************************
 * File Name: trycatchfinallysample.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/10/2017|whildebrandt|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');



$dbconn = dbmysql();//returns connection string
//php functions
function dbmysql()
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
    $_SESSION['sample_error'] = "Error retrieving data" . $e;   
  }
  
}

//========================================================================================== END PHP
?>

<!-- HTML -->