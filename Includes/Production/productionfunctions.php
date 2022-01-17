<?php
/* * *****************************************************************************************************************************************
 * File Name: productionfunctions.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/12/2017|nolliff|KACE:xxxxx - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');

function mssqldb()
{
  try
  {
    $dbcreds = databaseConnectionInfo();
    $connarray = array
      (
        "Database" => $dbcreds['silicoreplc_dbname'],
        "Uid" => $dbcreds['silicoreplc_dbuser'],
        "PWD" => $dbcreds['silicoreplc_pwd']
      );
    $mssqlcon = sqlsrv_connect($dbcreds['silicoreplc_dbhost'],$connarray);
    return $mssqlcon;
  }
  catch (Exception $e)
  {
    echo("Error while trying to get data" . $e);   
  }

}

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
    
    }
  catch (Exception $e)
  {
    $_SESSION['sample_error'] = "Error while trying to get data" . $e;   
  }
}
//========================================================================================== END PHP
?>
