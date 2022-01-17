<?php
/* * *****************************************************************************************************************************************
 * File Name: mysqlphpsproc.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/06/2017|kkuehn|KACE:17639 - Initial creation
 * 07/19/2017|nolliff|17603 - Changed file name to myqlphpsproc was sprocexample
 * 07/20/2017|kkuehn|17639 - Added functionality to display how to use the databaseConnectionInfo() wrapper to access the database creds.
 * 
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

/*
try
{
  $dbconn = connectToMySQLSecurity(); // Connect to database

  $sqlTestDepts = $dbconn->query("CALL sp_TestDepartments();");
    //or throw_exception("Error while trying to connect to the database: " . mysqli_error($mysqliConn);

  $rowCount = 1;
  while($row = $sqlTestDepts->fetch_assoc())
  {
    echo("Row " . $rowCount . " ID: " . $row['id'] . "<br />");
    echo("Row " . $rowCount . " Name: " . $row['name'] . "<br />");
    echo("Row " . $rowCount . " Description: " . $row['description'] . "<br /><br />");
    $rowCount++;
  }

  disconnectFromMySQL($dbconn);
}
catch (Exception $e)
{
  echo("Error while trying to get departments: " . $e);
}
 * 
 */

// Testing sqlsrv_connect() to vistasql1 (MS SQL)

//$servName = "192.168.97.19";

$dbc = databaseConnectionInfo();
// echo((var_dump($dbcreds)) . "<br /><br />");
/*
$servName = "vistasql1";
$connOptions = array
(
  "Database" => "SilicorePLC",
  "Uid" => "SilicoreSiteUser",
  "PWD" => "Vista1!"
);
*/

/* This doesn't work, sqlsrv_connect requires the host to be a string and the connection options to be an array
$dbconn = sqlsrv_connect
(
  $dbcreds['silicoreplc_dbhost'], 
  $dbcreds['silicoreplc_dbname'],
  $dbcreds['silicoreplc_dbuser'],
  $dbcreds['silicoreplc_pwd']
);
*/

$connarray = array
(
  "Database" => $dbc['silicoreplc_dbname'],
  "Uid" => $dbc['silicoreplc_dbuser'],
  "PWD" => $dbc['silicoreplc_pwd']
);
$dbconn = sqlsrv_connect($dbc['silicoreplc_dbhost'],$connarray);

if($dbconn)
{
  echo("Successful sqlsrv_connect connection to VistaSQL1<br /><br />");
}

// Close the connection
sqlsrv_close($dbconn);

// Testing PDO connection to vistasql1 (MS SQL)

// $dbconnPDO = new PDO("sqlsrv:Server=vistasql1;Database=SilicorePLC","SilicoreSiteUser","Vista1!");
$dbconnPDO = new PDO
(
  "sqlsrv:Server=" . $dbc['silicoreplc_dbhost'] . ";Database=" . $dbc['silicoreplc_dbname'],
  $dbc['silicoreplc_dbuser'],
  $dbc['silicoreplc_pwd']
);
if($dbconnPDO)
{
  echo("Successful PDO connection to VistaSQL1<br /><br />");
}
// Close the connection
$dbconnPDO = null;



/*  
  $databaseAccess['silicore_dbname'] = $silicore_dbname;
  $databaseAccess['silicore_username'] = $silicore_username;
  $databaseAccess['silicore_pwd'] = $silicore_pwd;
  $databaseAccess['silicore_hostname'] = $silicore_hostname;
*/
// Testing mysqli connection to silicore_site
// $mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);

$dbconn = new mysqli
(
  $dbc['silicore_hostname'],
  $dbc['silicore_username'],
  $dbc['silicore_pwd'],
  $dbc['silicore_dbname']
);

if($dbconn)
{
  echo("Successful constants-config connection to silicore_site<br /><br />");
}

// Close the connection
mysqli_close($dbconn);

//echo(phpinfo());
//========================================================================================== END PHP
?>

<!-- HTML -->
