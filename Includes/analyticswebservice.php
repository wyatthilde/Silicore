<?php

/* * *****************************************************************************
 * File Name: analyticsWebService.php
 * Project: WebAnalytics
 * Description: This web service will receive communications about traffic and 
 * log them in the database.
 * Notes: 
 * 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/15/2017|mnutsch|KACE:xxxxx - Initial creation.
 * 08/24/2017|nolliff|KACE:18251 - Changed functions to reflect code conventions
 * 01/22/2018|mnutsch|KACE:18518 - Cleaned up code: replaced index usage with 
 * assoc array usage; added stored procedures.
 * 01/23/2018|mnutsch|KACE:18518 - Added stored procedures.
 * 01/24/2018|mnutsch|KACE:18518 - Added stored procedures.
 * 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

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


//include other files
require_once('/var/www/configuration/db-mysql-sandbox.php'); //contains database connection info

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //web post was received
  $returnValue = "success";
  
  //get values from the web call and sanitize them.
  
  //get the token ID and check that it is valid
  if(isset($_POST["token_id"]))
  {
    $token_id = test_input($_POST["token_id"]);
    if($debugging == 1)
    {
      echo("The token_id is " . $token_id . "<br/>");
    }
    
    //read the website id based on the token
    $websiteID = getWebsiteID($token_id);
    if($debugging == 1)
    {
      echo("The website id is " . $websiteID . "<br/>");
    }
    
    //if the token ID is valid
    if($websiteID != 0)
    {
      //get the event type, so we know where to insert data
      if(isset($_POST["event_type"]))
      {
        $event_type = test_input($_POST["event_type"]);
        if($debugging == 1)
        {
          echo("The type is " . $event_type . "<br/>");
        }

        if($event_type == "page_load")
        {

          //get REST variables
          if(isset($_POST["page_url"])) //string
          {
            $page_url = test_input($_POST["page_url"]);
            if($debugging == 1)
            {
              echo("The page_url is " . $page_url . "<br/>");
            }
          }
          if(isset($_POST["page_values"])) //object containing unknown number of multiple values
          {
            $page_values = $_POST["page_values"];
            if($debugging == 1)
            {
              echo("The page_values is " . $page_values . "<br/>");
            }
          }

          //insert into the main_analytics_actions table  
          $newEntryID = logPageLoad($page_url, $websiteID);
          if($debugging == 1)
          {
            echo("The database ID of the the action entry logged is " . $newEntryID . "<br/>");
          }
          
          //$decoded_action_values = json_decode($test, true);
          $decoded_page_values = json_decode((string)$page_values, true);
          
          //loop through page values
          foreach ($decoded_page_values as $key => $value) 
          {
            //echo($key . ": " . $value . "<br/>");
            
            //insert into the main_analytics_page_values table
            logPageValue($newEntryID, $key, $value);
          }
        }

        if($event_type == "custom_action")
        {
          //get REST variables
          if(isset($_POST["action_name"])) //string
          {
            $action_name = test_input($_POST["action_name"]);
            if($debugging == 1)
            {
              echo("The action_name is " . $action_name . "<br/>");
            }
          }
          if(isset($_POST["action_values"])) //object containing unknown number of multiple values
          {
            $action_values = $_POST["action_values"]; //running test_input() on this value would break the json decode
            if($debugging == 1)
            {
              echo("The action_values is " . $action_values . "<br/>");
            }
          }

          //insert into the main_analytics_actions table
          $newEntryID = logAction($action_name, $websiteID);
          if($debugging == 1)
          {
            echo("The database ID of the the action entry logged is " . $newEntryID . "<br/>");
          }
          
          //$decoded_action_values = json_decode($test, true);
          $decoded_action_values = json_decode((string)$action_values, true);
          
          //loop through action values
          foreach ($decoded_action_values as $key => $value) 
          {
            //echo($key . ": " . $value . "<br/>");
            
            //insert into the main_analytics_action_values table
            logActionValue($newEntryID, $key, $value);
          }

          
        }

      } //event type is set
      else
      {
        $returnValue = "failure";
      }
    } //website id was found
    else
    {
      $returnValue = "failure";
    }
  } // token id is set
  else
  {
    $returnValue = "failure";
  }
  
  //return a success message
  echo($returnValue);
} //web post is received
else
{
  //web post was not received
  $returnValue = "failure";
  
  //return a failure message
  echo($returnValue);
}


/***************************************
* Name: function test_input($data) 
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
***************************************/
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/*******************************************************************************
* Function Name: connectToMySQL_Analytics()
* Description: 
* This function will: 
* Connect to MySQL.
* The connection information should be stored as constants, defined in an included file.
* The connection will be stored in a global variable called $GLOBALS['conn'];
* The function will return 1 if the connection was made and 0 if not.
*******************************************************************************/
function connectToMySQL_Analytics()
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
      $errorMessage = $errorMessage . "Error connecting to the MySQL database.";
      if($debugging == 1)
      {
        echo($errorMessage);
      }

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
    }
    return 0;
  }
}

/*******************************************************************************
* Function Name: disconnectFromMySQL_Analytics()
* Description: 
* This function will: 
* Disconnect from MySQL.
*******************************************************************************/
function disconnectFromMySQL_Analytics($mySQLConnection)
{
  try
  {	
    $mySQLConnection->close();
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error disconnecting from the MySQL database.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo($errorMessage);
    }
  }
}

/*******************************************************************************
* Function Name: logAction($argName, $argWebsiteID)
* Description: 
* This function will: 
* accept two strings as arguments
* insert the info into the main_analytics_actions database table
* return the database ID of the newly created entry.
*******************************************************************************/
function logAction($argName, $argWebsiteID)
{
  try
  {	
  
    $mySQLConnectionLocal = connectToMySQL_Analytics(); //connect to the database
  
    $sql = "CALL sp_analytics_LogAction('" . $argName . "'," . $argWebsiteID . ", @insert_id);";
    //$sql2 = "SELECT @insert_id AS id;"; //select the last insert ID 
    $sql2 = "CALL sp_analytics_MaxActionIDGet();";
  
    $result = mysqli_query($mySQLConnectionLocal,$sql); //insert the record
    
    //get the new database row ID
    $result2 = $mySQLConnectionLocal->query($sql2); //query for the last insert ID
    $row2 = mysqli_fetch_array($result2);
    $returnValue = $row2["id"];
    
    //check status
    if ($returnValue == 0) 
    {
      $errorMessage = $errorMessage . "Error creating a record.";
      //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      if($debugging == 1)
      {
        echo $errorMessage;
            echo "Error: " . $sql . "<br>" . $mySQLConnectionLocal->error;
      }
      $result = 0;
    }       
      
    disconnectFromMySQL_Analytics($mySQLConnectionLocal);
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error creating a record.";
    if($debugging == 1)
    {
      echo($errorMessage);
    }
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: logPageLoad($argURL, $argWebsiteID)
* Description: 
* This function will: 
* accept two strings as arguments
* insert the info into the main_analytics_page_load database table
* return the database ID of the newly created entry.
*******************************************************************************/
function logPageLoad($argURL, $argWebsiteID)
{
  try
  {	
    $mySQLConnectionLocal = connectToMySQL_Analytics(); //connect to the database
  
    $sql = "CALL sp_analytics_LogPageLoad('" . $argURL . "'," . $argWebsiteID . ",@insert_id);";
    //$sql2 = "SELECT @insert_id AS id;"; //select the last insert ID 
    $sql2 = "CALL sp_analytics_MaxPageIDGet();";
  
    $result = mysqli_query($mySQLConnectionLocal,$sql); //insert the record
    
    //get the new database row ID
    $result2 = $mySQLConnectionLocal->query($sql2); //query for the last insert ID
    $row2 = mysqli_fetch_array($result2);
    $returnValue = $row2["id"];
    
    //check status
    if ($returnValue == 0) 
    {
      $errorMessage = $errorMessage . "Error creating a record.";
      //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      if($debugging == 1)
      {
        echo $errorMessage;
            echo "Error: " . $sql . "<br>" . $mySQLConnectionLocal->error;
      }
      $result = 0;
    }       
  
    disconnectFromMySQL_Analytics($mySQLConnectionLocal);
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error creating a record.";
    if($debugging == 1)
    {
      echo($errorMessage);
    }
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: getWebsiteID($argToken)
* Description: 
* This function will: 
* The first parameter should be an string containing the token id.
* The function returns an integer containing the website id found.
* If no website id is found, then the value 0 is returned
*******************************************************************************/
function getWebsiteID($argToken)
{
  $returnValue = 0;
  
  try
  {

    $mySQLConnectionLocal = connectToMySQL_Analytics(); //connect to the database
  
    $table_name = "main_users";
  
    $sql = "CALL sp_analytics_GetWebsiteID('" . $argToken . "');";
    $result =  $mySQLConnectionLocal->query($sql); //direct SQL method
 
    while($row = $result->fetch_array())
    {
      $returnValue = $row['id'];
    }
  
    disconnectFromMySQL_Analytics($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = "Error verifying a website token id.";
    if($debugging == 1)
    {
      echo($errorMessage);
    }
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: logActionValue($argActionID, $argLabel, $argValue)
* Description: 
* This function will: 
* accept one integer and two strings as arguments
* insert the info into the main_analytics_action_values database table
* return the database ID of the newly created entry.
*******************************************************************************/
function logActionValue($argActionID, $argLabel, $argValue)
{
  $returnValue = 0;
  try
  {	
  
    $mySQLConnectionLocal = connectToMySQL_Analytics(); //connect to the database
  
    $sql = "CALL sp_analytics_LogActionValue(" . $argActionID . ",'" . $argLabel . "','" . $argValue . "', @insert_id);";
    //$sql2 = "SELECT @insert_id AS id;"; //select the last insert ID 
    $sql2 = "CALL sp_analytics_MaxActionValueIDGet();";
  
    $result = mysqli_query($mySQLConnectionLocal,$sql); //insert the record
    
    //get the new database row ID
    $result2 = $mySQLConnectionLocal->query($sql2); //query for the last insert ID
    $row2 = mysqli_fetch_array($result2);
    $returnValue = $row2["id"];
    
    //check status
    if ($returnValue == 0) 
    {
      $errorMessage = $errorMessage . "Error creating a record.";
      //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      if($debugging == 1)
      {
        echo $errorMessage;
            echo "Error: " . $sql . "<br>" . $mySQLConnectionLocal->error;
      }
      $result = 0;
    }       
  
    disconnectFromMySQL_Analytics($mySQLConnectionLocal);
  }
  catch (Exception $e)
  {
    $errorMessage = "Error creating a record.";
    echo($errorMessage);

  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: logPageValue($argPageID, $argLabel, $argValue)
* Description: 
* This function will: 
* accept one integer and two strings as arguments
* insert the info into the main_analytics_page_values database table
* return the database ID of the newly created entry.
*******************************************************************************/
function logPageValue($argPageID, $argLabel, $argValue)
{
  $returnValue = 0;
  try
  {	
  
    $mySQLConnectionLocal = connectToMySQL_Analytics(); //connect to the database
  
    $sql = "CALL sp_analytics_LogPageValue(" . $argPageID . ",'" . $argLabel . "','" . $argValue . "',@insert_id);";
    //$sql2 = "SELECT @insert_id AS id;"; //select the last insert ID 
    $sql2 = "CALL sp_analytics_MaxPageValueIDGet();";
  
    $result = mysqli_query($mySQLConnectionLocal,$sql); //insert the record
    
    //get the new database row ID
    $result2 = $mySQLConnectionLocal->query($sql2); //query for the last insert ID
    $row2 = mysqli_fetch_array($result2);
    $returnValue = $row2["id"];
    
    //check status
    if ($returnValue == 0) 
    {
      $errorMessage = $errorMessage . "Error creating a record.";
      //sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      if($debugging == 1)
      {
        echo $errorMessage;
            echo "Error: " . $sql . "<br>" . $mySQLConnectionLocal->error;
      }
      $result = 0;
    }       
  
    disconnectFromMySQL_Analytics($mySQLConnectionLocal);
  }
  catch (Exception $e)
  {
    $errorMessage = "Error creating a record.";
    if($debugging == 1)
    {
      echo($errorMessage);
    }
  }
  
  return $returnValue;
}

//====================================================================== END PHP
?>