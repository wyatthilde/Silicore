<?php

/* * *****************************************************************************************************************************************
 * File Name: adminfunctions.php
 * Project: Silicore
 * Description: This file contains functions for interacting with and updating the database tables. 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 04/10/2017|mnutsch|KACE:xxxxx - File created.
 * 07/28/2017|mnutsch|KACE:17573 - Removed references to an old database name from the SQL queries.
 * 08/24/2017|nolliff|KACE:18251 - Changed functions to reflect code conventions
 * 01/24/2018|mnutsch|KACE:18518 - Added new stored procedures.
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging)
{
    echo("The current Linux user is: ");
    echo(exec('whoami'));
    echo("<br/>");
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo("<strong>Debugging Enabled</strong><br/>");  
    echo("Start time: ");
    echo(date("Y-m-d H:i:s",$t));
    echo("<br/>");
}

/*******************************************************************************
* Function Name: connectToMySQLAdmin()
* Description: 
* This function will: 
* Connect to MySQL.
* The connection information should be stored as constants, defined in an included file.
* The connection will be stored in a global variable called $GLOBALS['conn'];
* The function will return 1 if the connection was made and 0 if not.
*******************************************************************************/
function connectToMySQLAdmin()
{
  try
  {
    $mySQLConnection = 0; //used to track if the database is connected.

    $mysql_dbname = SANDBOX_DB_DBNAME001; //sandbox
    $mysql_username = SANDBOX_DB_USER;
    $mysql_pw = SANDBOX_DB_PWD;
    $mysql_hostname = SANDBOX_DB_HOST;

    // Create connection
    $mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);

    // Check connection
    if ($mySQLConnection->connect_error) 
    {
      $errorMessage = "Error connecting to the MySQL database.";
      sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      if($debugging == 1)
      {
        echo($errorMessage);
      }
      //echo("Error connecting to MySQL: <br>" . $mySQLConnection->error;

      return 0;
    }
    else
    {
      return $mySQLConnection;
    }
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the MySQL database.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
    echo($errorMessage);
      //$error = $e->getMessage();
      //echo $error;
    }
    return 0;
  }
}

/*******************************************************************************
* Function Name: disconnectFromMySQLAdmin()
* Description: 
* This function will: 
* Disconnect from MySQL.
*******************************************************************************/
function disconnectFromMySQLAdmin($mySQLConnection)
{
  try
  {	
    $mySQLConnection->close();
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error disconnecting to the MySQL database.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {

      echo($errorMessage);

      //$error = $e->getMessage();
      //echo $error;
    }
  }
}

/*******************************************************************************
* Function Name: getPageHelp()
* Description: 
* This function will: 
* Returns an array of objects containing the page help data.
*******************************************************************************/
function getPageHelp()
{
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLAdmin(); //connect to the database
  
    //$sql = 'SELECT * FROM main_page_help;'; //direct SQL method
    $sql = 'CALL sp_gen_PageHelpGet();';

    $result =  $mySQLConnectionLocal->query($sql);

    $outputCount = 0;
    while($row = $result->fetch_array())
    {
      $testObjects[$outputCount]->vars["id"] = $row[0];
      $testObjects[$outputCount]->vars["page"] = $row[1];
      $testObjects[$outputCount]->vars["department"] = $row[2];
      $testObjects[$outputCount]->vars["text"] = $row[3];

      $outputCount++;
      $returnValue = 1;
    }

    disconnectFromMySQLAdmin($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = "Error getting info on all page help info.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo($errorMessage);
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $testObjects;
}

/*******************************************************************************
* Function Name: getPageHelpByID($pageHelpID)
* Description: 
* This function will: 
* The first paramater should be an integer containing the pageHelpID.
* The function returns a single object containing the data retrieved.
*******************************************************************************/
function getPageHelpByID($pageHelpID)
{
  
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {

    $mySQLConnectionLocal = connectToMySQLAdmin(); //connect to the database
  
    //$sql = "SELECT * FROM main_page_help WHERE id = '$pageHelpID' LIMIT 1"; //direct SQL method
    $sql = "CALL sp_gen_PageHelpGetByID(" . $pageHelpID . ");";
    
    $result =  $mySQLConnectionLocal->query($sql); 
  
    while($row = $result->fetch_array())
    {
      $testObject->vars["id"] = $row[0];
      $testObject->vars["page"] = $row[1];
      $testObject->vars["department"] = $row[2];
      $testObject->vars["text"] = $row[3];
    }
  
    disconnectFromMySQLAdmin($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error getting page help info by id.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {

      echo($errorMessage);
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: updatePageHelp($pageHelpID, $helpText)
* Author: Matt Nutsch
* Date: 4-10-2017
* Description: 
* This function will: 
* The first parameter should be a PageHelpID as an integer.
* The second parameter should be a string with the text to update in the database.
* The function returns 1 if successful and 0 if not successful
*******************************************************************************/
function updatePageHelp($pageHelpID, $helpText)
{
  $returnValue = 0;

  try
  {
    $mySQLConnectionLocal = connectToMySQLAdmin(); //connect to the database

    $t=time(); //variable used for obtaining the current time
  
    //echo("updateUserPassword called<br/>";
  
    //hash the password
    $password = password_hash($unhashedPassword, PASSWORD_DEFAULT);
  
    //create the SQL command to update the database
    $sql = "CALL sp_gen_PageHelpUpdate(" . $pageHelpID . ",'" . $helpText . "');";
 
    //perform the SQL command
    $result =  $mySQLConnectionLocal->query($sql); 

  
    if($result)
    {
      //echo("Success! record updated<br/>"); //output for debug
      $returnValue = 1;
    }
     else
    {
      //echo("Error in database update.<br/>"); //output for debug
      $returnValue = 0;
    }
  
    disconnectFromMySQLAdmin($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error updating page help text.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo($errorMessage);
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $returnValue;
  
}

/*******************************************************************************
* Function Name: getPageNavInfoByID($pageID)
* Description: 
* This function will: 
* The first paramater should be an integer containing the ID of the page in the ui-nav-left-links table.
* The function returns a single object containing the data retrieved.
*******************************************************************************/
function getPageNavInfoByID($pageID)
{
  
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {

    $mySQLConnectionLocal = connectToMySQLAdmin(); //connect to the database
  
    //$sql = "SELECT * FROM ui_nav_left_links LEFT JOIN sandbox.main_departments ON sandbox.ui_nav_left_links.main_department_id = sandbox.main_departments.id WHERE sandbox.ui_nav_left_links.id = '$pageID' LIMIT 1;"; //direct SQL method
    $sql = "CALL sp_gen_PageNavInfoGetByID(" . $pageID . ");";
    
    $result =  $mySQLConnectionLocal->query($sql); 
  
    while($row = $result->fetch_array())
    {
      $testObject->vars["id"] = $row[0];
      $testObject->vars["page"] = $row[5];
      $testObject->vars["department"] = $row[15];
    }
  
    disconnectFromMySQLAdmin($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error getting page help info by id.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {

      echo($errorMessage);
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $testObject;
}

//====================================================================== END PHP
?>