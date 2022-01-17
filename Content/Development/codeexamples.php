<?php
/* * *****************************************************************************************************************************************
 * File Name: codeexamples.php
 * Project: Silicore
 * Description: Documenting our code syntax and conventions
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17604 - Initial creation
 * 01/24/2018|kkuekhn|KACE:xxxxx - Adding 
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

echo ("");

//========================================================================================== END PHP
?>

<!-- HTML -->
<h2>Executing a stored procedure and working with the result set while using proper error handling:</h2>
<pre>
// Get site name for HR email request body strings
$dbc = databaseConnectionInfo(); // lives in /Includes/Security/dbaccess.php
$dbcSiteName = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );
try
{
  $errGetSiteName = "There was a problem while trying to retrieve the site name using sp_hr_SiteNameGetById();";
  $sqlGetSiteName = "call sp_hr_SiteNameGetById('$SiteId')"; 
  $datSiteName = mysqli_query($dbcSiteName, $sqlGetSiteName);
  if(!$datSiteName)
  {
    throw new Exception(mysqli_error($dbcSiteName));
  }
}// end try
catch(Exception $e)
{
  echo(("Exception: " . $errGetSiteName . "&lt;br />&lt;br />Error message: " . $e->getMessage() . "&lt;br />&lt;br />"));
  exit("Stopping PHP execution");
}// end catch
try
{
  $errUseSiteName = "There was a problem while trying to process the site name dataset.";
  $arrSiteName = mysqli_fetch_assoc($datSiteName);
  $SiteName = $arrSiteName['description'];
  mysqli_close($dbcSiteName);
  throw new Exception("Oh noes!"); // Manual throw for example purpose only, removed from production code.
}// end try
catch(Exception $e)
{
  echo(("Exception: " . $errUseSiteName . "&lt;br />&lt;br />Error message: " . $e->getMessage() . "&lt;br />&lt;br />"));
  exit("Stopping PHP execution");
}// end catch
</pre>
<h3>Screenshots of the above error handling in action:</h3>
<img src="/Images/Documentation/Programming/ErrorHandlingExample001.PNG">
<br />
<img src="/Images/Documentation/Programming/ErrorHandlingExample002.PNG">
