<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_AnalogDataHourlyTotalsGetAll.php
 * Project: Silicore
 * Description: Hourly batch script that will read PLC production totals and send email alerts to appropriate parties on threshold crossing.
 * Notes: This data is logged by Top Server into MSSQL (SilicorePLC.PLC_AnalogTagHourlyTotals). This PHP script will use a MSSQL sproc named
 *        'sp_plc_AnalogTagHourlyTotalsGetAll' to ETL this data into our MySQL (silicore_site.gb_plc_analog_tag_hourly_totals) for use in
 *        reporting by both the Silicore site and the batch scripts.
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/09/2017|kkuehn|KACE:16842 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

//echo("into the batch script");

require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

// Get the data set from MSSQL into assoc array

$dbc = databaseConnectionInfo();

$connarray = array
(
  "Database" => $dbc['silicoreplc_dbname'],
  "Uid" => $dbc['silicoreplc_dbuser'],
  "PWD" => $dbc['silicoreplc_pwd']
);
$dbconn = sqlsrv_connect($dbc['silicoreplc_dbhost'],$connarray);

$query = 'EXEC sp_plc_AnalogTagHourlyTotalsGetAll';
$tagvalues = sqlsrv_query($dbconn, $query);

/*
if($dbconn)
{
  $msg = "Successful sqlsrv_connect connection to VistaSQL1<br /><br />";
}
*/
$rowcount = 0;
$msg = 
"<table border='1' cellpadding='2' cellspacing='0'>" . 
  "<tr>" . 
    "<th>Tag ID</th>" .
    "<th>Tag Value</th>" .
    "<th>Tag Time</th>" .
    "<th>Accurate?</th>" .
  "</tr>";
while ($tagrows = sqlsrv_fetch_array($tagvalues))
{
  //$msg .= ($rowcount) . " Row...<br />";
  
  $msg .= 
  "<tr>" .
    "<td>" . $tagrows['Name'] . "</td>" .
    "<td>" . $tagrows['Value'] . "</td>" .
    "<td>" . $tagrows['Timestamp']->format('Y-m-d H:i:s') . "</td>" .
    "<td>"; $qual = ($tagrows['Quality'] == 192) ? "Yes" : "No"; $msg .= $qual . "</td>" .
  "</tr>";  
  $rowcount++;
}
$msg .= "</table>";
$msg .= "<br /><br />There were a total of " . ($rowcount + 1) . " rows.";

// Close the connection
sqlsrv_close($dbconn);

// Insert the data into the MySQL table

SendPHPMail("kkuehn@vistasand.com", "Hourly batch email subject", $msg,"Hourly Batch Script",0,0);

//========================================================================================== END PHP
?>