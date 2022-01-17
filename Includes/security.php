<?php

/* * *****************************************************************************************************************************************
 * File Name: security.php
 * Project: Silicore
 * Description: This file contains functions for interacting the the database table, main_users. 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * ??/??/2017|mnutsch|KACE:xxxxx - File created.
 * 07/3/2017|mnutsch|KACE:17279 - Corrected a bug in the user permissions checking process.
 * 07/25/2017|mnutsch|KACE:17366 - Corrected bugs.
 * 07/26/2017|mnutsch|KACE:17366 - Added a new function, getBackOfficeUserBySilicoreID().
 * 07/28/2017|mnutsch|KACE:17729 - Made minor modifications to various functions. Added the getDepartments() function.
 * 08/21/2017|mnutsch|KAEV:17957 - Fixed bug in createUser().
 * 09/27/2017|kkuehn|KACE:10499 - Moved the pagevariables include statement above the others.
 * 12/07/2017|mnutsch|KACE:19845 - Added a call to read global parameters which are now set in pagevariables.php.
 * 01/05/2018|mnutsch|KACE:20186 - Added new database fields to the object returned from the function getUser().
 * 01/22/2018|mnutsch|KACE:18518 - Cleaned up code: converted indices to associations, 
 * added a stored procedure call, and commented out a deprecated function.
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging)
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled</strong><br/>";  
    echo "Start time: ";
    echo(date("Y-m-d H:i:s",$t));
    echo "<br/>";
}

//include other files
require_once('pagevariables.php'); //contains database connection info
require_once('/var/www/configuration/db-mysql-sandbox.php'); //contains database connection info
require_once('emailfunctions.php'); //contains database connection info

/*******************************************************************************
* Function Name: connectToMySQLSecurity()
* Description: 
* This function will: 
* Connect to MySQL.
* The connection information should be stored as constants, defined in an included file.
* The connection will be stored in a global variable called $GLOBALS['conn'];
* The function will return 1 if the connection was made and 0 if not.
*******************************************************************************/
function connectToMySQLSecurity()
{
  $errorMessage = "security.php connectToMySQLSecurity() "; //requires pagevariables.php
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
	  sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	  if($debugging == 1)
	  {
	    echo $errorMessage;
	  }
	  //echo "Error connecting to MySQL: <br>" . $mySQLConnection->error;
	  
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
      echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
	return 0;
  }
}

/*******************************************************************************
* Function Name: disconnectFromMySQL()
* Description: 
* This function will: 
* Disconnect from MySQL.
*******************************************************************************/
function disconnectFromMySQL($mySQLConnection)
{
  $errorMessage = "security.php disconnectFromMySQL() "; //requires pagevariables.php
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
	  
	  echo $errorMessage;
	  
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
}

/*******************************************************************************
* Function Name: createUser($userObject)
* Description: 
* This function will: 
* accept an object containing user info as an argument
* hash the password
* insert the user info into the user database
* return the database ID of the newly created entry
*******************************************************************************/
function createUser($userObject)
{
  $errorMessage = "security.php createUser() "; //requires pagevariables.php
  
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {	
    
    $testObject = $userObject;
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $username = $testObject->vars["username"];
    $first_name = $testObject->vars["first_name"];
    $last_name = $testObject->vars["last_name"];
    $display_name = $testObject->vars["display_name"];
    $email = $testObject->vars["email"];
    $company = $testObject->vars["company"];
    $main_department_id = $testObject->vars["main_department_id"];
    $password = $testObject->vars["password"];
    $last_logged = $testObject->vars["last_logged"];
    $start_date = $testObject->vars["start_date"];
    $separation_date = $testObject->vars["separation_date"]; //dev note 8-21-2017: this is ignored and inserted as NULL
    $is_active = $testObject->vars["is_active"];
    $require_password_reset = $testObject->vars["require_password_reset"];
    $password_reset_token = $testObject->vars["password_reset_token"];
    $password_token_expiration = $testObject->vars["password_token_expiration"];
    $accessLevel = $testObject->vars["accessLevel"];
  
    $password = password_hash($password, PASSWORD_DEFAULT);
  
    //require_password_reset, password_reset_token, password_token_expiration
    
    $table_name = "main_users";
  
    //direct SQL method
    //$sql = "INSERT INTO $table_name (username, first_name, last_name, display_name, email, company, main_department_id, password, last_logged, start_date, separation_date, is_active, require_password_reset, password_reset_token, password_token_expiration, user_type_id)VALUES ('$username', '$first_name', '$last_name', '$display_name', '$email', '$company', '$main_department_id', '$password', '$last_logged', '$start_date', null, '$is_active', '$require_password_reset', '$password_reset_token', '$password_token_expiration', '$accessLevel')";
  
    //stored procedure method
    $sql ="CALL sp_UserInsert('$username', '$first_name', '$last_name', '$display_name', '$email', '$company', '$main_department_id', '$password', '$last_logged', '$start_date', null, '$is_active', '$require_password_reset', '$password_reset_token', '$password_token_expiration', '$accessLevel')";
    
    //echo "DEBUG: sql = " . $sql . "<br/>";
    
    //direct SQL method to check status
    if ($mySQLConnectionLocal->query($sql) === TRUE) 
    {
      $returnValue = mysqli_insert_id($mySQLConnectionLocal);
    } 
    else 
    {
      $errorMessage = $errorMessage . "Error creating a user.";
	  echo "DEBUG: " . $errorMessage;
	  sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	  if($debugging == 1)
	  {
	    echo $errorMessage;
	    //echo "Error: " . $sql . "<br>" . $mySQLConnectionLocal->error;
	  }
	  
    }
  
    /*
    //stored procedure method
    $result = $mySQLConnectionLocal->query("CALL sp_InsertNewUser('$username','$first_name','$last_name','$display_name','$email','$company','$main_department_id','$password','$last_logged','$start_date','$separation_date','$is_active','$require_password_reset','$password_reset_token','$password_token_expiration');"); //stored procedure method
    $returnValue = mysqli_insert_id($mySQLConnectionLocal);
    */
  
    //echo "insert result is " . $result . "<br/>";
  
    //echo "new ID is " . $returnValue . "<br/>";
  
    disconnectFromMySQL($mySQLConnectionLocal);
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error creating a user.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {

      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: updateUser($userObject)
* Description: 
* This function will: 
* Accept an object containing user info as an argument.
* Update the user in the user database.
* The user will be identified based on the user id.
* All fields other than password and separation_date are updated.
* To update passwords, use the updateUserPassword() function. 
*******************************************************************************/
function updateUser($userObject)
{
  global $PageName;
  global $PageDept;
  $errorMessage = "Page: " . $PageName . ". Department: " . $PageDept . ". "; //requires pagevariables.php
  
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $table_name = "main_users";
  
    $testObject = $userObject;
  
    $id = $testObject->vars["id"];
    $username = $testObject->vars["username"];
    $first_name = $testObject->vars["first_name"];
    $last_name = $testObject->vars["last_name"];
    $display_name = $testObject->vars["display_name"];
    $email = $testObject->vars["email"];
    $company = $testObject->vars["company"];
    $main_department_id = $testObject->vars["main_department_id"];
    //$password = $testObject->vars["password"];
    $last_logged = $testObject->vars["last_logged"];
    $start_date = $testObject->vars["start_date"];
    //$separation_date = $testObject->vars["separation_date"];
    $is_active = $testObject->vars["is_active"];
    $require_password_reset = $testObject->vars["require_password_reset"];
    $password_reset_token = $testObject->vars["password_reset_token"];
    $password_token_expiration = $testObject->vars["password_token_expiration"];
  
  
    //hash the password
    //$password = password_hash($password, PASSWORD_DEFAULT);
    
    /*
    //direct SQL method
    $sql = "UPDATE $table_name SET `username` = '$username', `first_name` = '$first_name', `last_name` = '$last_name', `display_name` = '$display_name', `email` = '$email', `company` = '$company', `main_department_id` = '$main_department_id', `last_logged` = '$last_logged', `start_date` = '$start_date', `is_active` = '$is_active', `require_password_reset` = '$require_password_reset', `password_token_expiration` = '$password_token_expiration', `password_reset_token` = '$password_reset_token' WHERE `id` = '$id';";
  
    //direct SQL method
    if ($mySQLConnectionLocal->query($sql) === TRUE) 
    {
     //echo "Record updated successfully<br/>";
      $returnValue = 1;
    } 
    else 
    {
      echo "Error updating record: " . $mySQLConnection->error . "<br/>";
      $returnValue = 0;
    }
    */
    
    //stored procedure method
    $result = $mySQLConnectionLocal->query("CALL sp_UpdateUser('$id','$username','$first_name','$last_name','$display_name','$email','$company','$main_department_id','$last_logged','$start_date','$is_active','$require_password_reset','$password_reset_token','$password_token_expiration');"); //stored procedure method
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error updating a user.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  
	  echo $errorMessage;
	  
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: deleteUser($userObject)
* Description: 
* This function will: 
* Accept an object containing user info as an argument.
* Update the user in the user database.
* The user will be identified based on the user ID.
*******************************************************************************/
function deleteUser($userObject)
{
  $errorMessage = "Page: " . $PageName . ". Department: " . $PageDept . ". "; //requires pagevariables.php
  
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $table_name = "main_users";
  
    $id = $userObject->vars["id"];

    /*
    $sql = "DELETE FROM $table_name WHERE id=$id"; //direct SQL method
    $result =  $mySQLConnectionLocal->query($sql); //direct SQL method
    //direct SQL method
    if ( $mySQLConnectionLocal->query($sql) === TRUE) 
    {
      //echo "Record deleted successfully<br/>";
      $returnValue = 1;
    } 
    else 
    {
      echo "Error deleting record: " . $conn->error . "<br/>";
    }
    */
  
    $result = $mySQLConnectionLocal->query("CALL sp_DeleteUser('$id');"); //stored procedure method
 
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error deleting a user.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: getUser($userID)
* Description: 
* This function will: 
* The first paramater should be an integer containing the userID.
* The function returns a single object containing the user data retrieved.
*******************************************************************************/
function getUser($userID)
{
  $errorMessage = "security.php getUser() "; //requires pagevariables.php
  $testObject = null;
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {

    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $table_name = "main_users";
  
    //$sql = "SELECT * FROM $table_name WHERE id = '$userID' LIMIT 1"; //direct SQL method
    //$result =  $mySQLConnection->query($sql); //direct SQL method
    
    //echo "DEBUG: getUser () sql == CALL sp_GetUser('" . $userID . "');";
    
    $result = $mySQLConnectionLocal->query("CALL sp_GetUser('$userID');"); //stored procedure method
 
    while($row = $result->fetch_assoc())
    {
      $testObject->vars["id"] = $row['id'];
      $testObject->vars["first_name"] = $row['first_name'];
      $testObject->vars["last_name"] = $row['last_name'];
      $testObject->vars["display_name"] = $row['display_name'];
      $testObject->vars["email"] = $row['email'];
      $testObject->vars["company"] = $row['company'];
      $testObject->vars["main_department_id"] = $row['main_department_id'];
      $testObject->vars["password"] = $row['password'];
      $testObject->vars["last_logged"] = $row['last_logged'];
      $testObject->vars["start_date"] = $row['start_date'];
      $testObject->vars["separation_date"] = $row['separation_date'];
      $testObject->vars["is_active"] = $row['is_active'];
      $testObject->vars["require_password_reset"] = $row['require_password_reset'];
      $testObject->vars["username"] = $row['username'];
      $testObject->vars["password_reset_token"] = $row['password_reset_token'];
      $testObject->vars["password_token_expiration"] = $row['password_token_expiration'];
//      $testObject->vars["qc_labtech"] = $row['qc_labtech'];
//      $testObject->vars["qc_sampler"] = $row['qc_sampler'];
//      $testObject->vars["qc_operator"] = $row['qc_operator'];
      $testObject->vars["user_type_id"] = $row['user_type_id'];
      $testObject->vars["manager_id"] = $row['manager_id'];
      
    }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error getting a user's info.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: getUserByName($username)
* Description: 
* The first parameter should be a string consisting of the username,
* The object received should have a variable labelled "username": $userObject->vars["id"]
* The function returns a single object containing the user data retrieved.
* The user will be identified based on the user ID.
*******************************************************************************/
function getUserByName($username)
{
  $errorMessage = "security.php getUserByName() "; //requires pagevariables.php
  $testObject = NULL;
  
  try
  {
	  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    //echo "Function: The username received was " . $username . "<br>";
  
    $table_name = "main_users";
  
    //$sql = "SELECT * FROM $table_name WHERE username = '$username' LIMIT 1"; //direct SQL method
    //$result =  $mySQLConnectionLocal->query($sql); //direct SQL method
  
    $result = $mySQLConnectionLocal->query("CALL sp_GetUserByName('$username');"); //stored procedure method
 
    while($row = $result->fetch_assoc())
    {
      $testObject->vars["id"] = $row['id'];
      $testObject->vars["first_name"] = $row['first_name'];
      $testObject->vars["last_name"] = $row['last_name'];
      $testObject->vars["display_name"] = $row['display_name'];
      $testObject->vars["email"] = $row['email'];
      $testObject->vars["company"] = $row['company'];
      $testObject->vars["main_department_id"] = $row['main_department_id'];
      $testObject->vars["password"] = $row['password'];
      $testObject->vars["last_logged"] = $row['last_logged'];
      $testObject->vars["start_date"] = $row['start_date'];
      $testObject->vars["separation_date"] = $row['separation_date'];
      $testObject->vars["is_active"] = $row['is_active'];
      $testObject->vars["require_password_reset"] = $row['require_password_reset'];
      $testObject->vars["username"] = $row['username'];
      $testObject->vars["password_reset_token"] = $row['password_reset_token'];
      $testObject->vars["password_token_expiration"] = $row['password_token_expiration'];
      $testObject->vars["qc_labtech"] = $row['qc_labtech'];
      $testObject->vars["qc_sampler"] = $row['qc_sampler'];
      $testObject->vars["qc_operator"] = $row['qc_operator'];
      $testObject->vars["user_type_id"] = $row['user_type_id'];
      $testObject->vars["manager_id"] = $row['manager_id'];
    }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error getting a user's info.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: getUserByEmail($email_address)
* Description: 
* The first parameter should be a string consisting of the email address,
* The object received should have a variable labelled "username": $userObject->vars["id"]
* The function returns a single object containing the user data retrieved.
* The user will be identified based on the user ID.
*******************************************************************************/
function getUserByEmail($email_address)
{
  $errorMessage = "security.php getUserByEmail() "; //requires pagevariables.php
  $testObject = NULL;
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    //echo "Function: The username received was " . $username . "<br>";
  
    $table_name = "main_users";
  
    //$sql = "SELECT * FROM $table_name WHERE email = '$email_address' LIMIT 1"; //direct SQL method
    //$result =  $mySQLConnectionLocal->query($sql); //direct SQL method
  
    $result = $mySQLConnectionLocal->query("CALL sp_GetUserByEmail('$email_address');"); //stored procedure method
 
    while($row = $result->fetch_assoc())
    {
      $testObject->vars["id"] = $row['id'];
      $testObject->vars["first_name"] = $row['first_name'];
      $testObject->vars["last_name"] = $row['last_name'];
      $testObject->vars["display_name"] = $row['display_name'];
      $testObject->vars["email"] = $row['email'];
      $testObject->vars["company"] = $row['company'];
      $testObject->vars["main_department_id"] = $row['main_department_id'];
      $testObject->vars["password"] = $row['password'];
      $testObject->vars["last_logged"] = $row['last_logged'];
      $testObject->vars["start_date"] = $row['start_date'];
      $testObject->vars["separation_date"] = $row['separation_date'];
      $testObject->vars["is_active"] = $row['is_active'];
      $testObject->vars["require_password_reset"] = $row['require_password_reset'];
      $testObject->vars["username"] = $row['username'];
      $testObject->vars["password_reset_token"] = $row['password_reset_token'];
      $testObject->vars["password_token_expiration"] = $row['password_token_expiration'];
      //$testObject->vars["qc_labtech"] = $row['qc_labtech'];
      //$testObject->vars["qc_sampler"] = $row['qc_sampler'];
      //$testObject->vars["qc_operator"] = $row['qc_operator'];
      $testObject->vars["user_type_id"] = $row['user_type_id'];
      $testObject->vars["manager_id"] = $row['manager_id'];      
    }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error getting a user's info.";  
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;	
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: getUsers()
* Description: 
* This function will: 
* Returns an array of objects containing the user data.
*******************************************************************************/
function getUsers()
{
  $errorMessage = "security.php getUsers() "; //requires pagevariables.php
  
  $returnValue = 0; //a value to tell us if the process was successful.
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $table_name = "main_users";
  
    $result = $mySQLConnectionLocal->query("CALL sp_GetAllUsers();"); 
  
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $testObjects[$outputCount]->vars["id"] = $row['id'];
      $testObjects[$outputCount]->vars["first_name"] = $row['first_name'];
      $testObjects[$outputCount]->vars["last_name"] = $row['last_name'];
      $testObjects[$outputCount]->vars["display_name"] = $row['display_name'];
      $testObjects[$outputCount]->vars["email"] = $row['email'];
      $testObjects[$outputCount]->vars["company"] = $row['company'];
      $testObjects[$outputCount]->vars["main_department_id"] = $row['main_department_id'];
      $testObjects[$outputCount]->vars["password"] = $row['password'];
      $testObjects[$outputCount]->vars["last_logged"] = $row['last_logged'];
      $testObjects[$outputCount]->vars["start_date"] = $row['start_date'];
      $testObjects[$outputCount]->vars["separation_date"] = $row['separation_date'];
      $testObjects[$outputCount]->vars["is_active"] = $row['is_active'];
      $testObjects[$outputCount]->vars["require_password_reset"] = $row['require_password_reset'];
      $testObjects[$outputCount]->vars["username"] = $row['username'];
      $testObjects[$outputCount]->vars["password_reset_token"] = $row['password_reset_token'];
      $testObjects[$outputCount]->vars["password_token_expiration"] = $row['password_token_expiration'];
      //$testObjects[$outputCount]->vars["qc_labtech"] = $row['qc_labtech'];
      //$testObjects[$outputCount]->vars["qc_sampler"] = $row['qc_sampler'];
      //$testObjects[$outputCount]->vars["qc_operator"] = $row['qc_operator'];
      $testObjects[$outputCount]->vars["user_type_id"] = $row['user_type_id'];
      $testObjects[$outputCount]->vars["manager_id"] = $row['manager_id'];      
 
      $outputCount++;
      $returnValue = 1;
    }

    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error getting info on all users.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
      echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $testObjects;
}

/*******************************************************************************
* Function Name: echoUserData($myUserObject)
* Description: 
* This function will: 
* Receive an object containing user information.
* Echo the user information.
*******************************************************************************/
function echoUserData($myUserObject)
{
  $errorMessage = "security.php echoUserData() "; //requires pagevariables.php
  
  try
  {
   
    echo "User ID: " . $myUserObject->vars["id"] . "<br/>";
    echo "Username: " . $myUserObject->vars["username"] . "<br/>";
    echo "First Name: " . $myUserObject->vars["first_name"] . "<br/>";
    echo "Last Name: " . $myUserObject->vars["last_name"] . "<br/>";
    echo "Display Name: " . $myUserObject->vars["display_name"] . "<br/>";
    echo "Email: " . $myUserObject->vars["email"] . "<br/>";
    echo "Company: " . $myUserObject->vars["company"] . "<br/>";
    echo "Main Department ID: " . $myUserObject->vars["main_department_id"] . "<br/>";
    //echo $myUserObject->vars["password"] . "<br/>";
    echo "Last Logged: " . $myUserObject->vars["last_logged"] . "<br/>";
    echo "User Account Created: " . $myUserObject->vars["start_date"] . "<br/>";
    //echo $myUserObject->vars["separation_date"] . "<br/>";
    //echo $myUserObject->vars["is_active"] . "<br/>";
    //echo "Password Reset Required: " . $myUserObject->vars["require_password_reset"];
    
    //echo $myUserObject->vars["password_reset_token"]; 
    //echo $myUserObject->vars["password_token_expiration"];
    echo "<br/>";
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error outputting user data.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return 0;
}

/*******************************************************************************
* Function Name: getUserPermissions($userID, $mySQLConnection)
* Author: Matt Nutsch
* Date: 3-14-2017
* Description: 
* This function will: 
* Accepts an argument containing the userID.
* The second parameter should be a variable with the connection to the MySQL database.
* The function returns a 3D array containing the values
*******************************************************************************/
function getUserPermissions($userID)
{
  $errorMessage = "security.php getUserPermissions() "; //requires pagevariables.php
  
  $permissionsArray = [[[]]]; //Initialize a 3D array to hold the permissions.
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $result = $mySQLConnectionLocal->query("CALL sp_GetUserPermissions('$userID');"); 
  
    while($row = $result->fetch_assoc())
    { 
 	  $permissionsArray[$row['company']][$row['site']][$row['permission']] = $row['permission_level']; //set the array values: [company][site][permission]
     }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error getting a user's permissions.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
      echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $permissionsArray;
}

/*******************************************************************************
* Function Name: checkPagePermission($argCompany, $argSite, $argDepartment, $userPermissionsArray)
* Author: Matt Nutsch
* Date: 3-14-2017
* Description: 
* This function will connect to the ui_nav_left_links.sql table and read the
* permission level for a web page.
* It will then return a value of "1" if the user is authorized to see the page.
* It will return a 0 if the user is not authorized to see the page.
* $userPermissionsArray should be a value generated from the function getUserPermissions().
* $argCompany, $argSite, and $argDepartment should be the names of the company, site, and department in lowercase:
* $argPageName should be a string containing the file name of the page in question, i.e. "performance.php".
* i.e. "vprop", "granbury", "qc".
*******************************************************************************/
function checkPagePermission($argCompany, $argSite, $argDepartment, $userPermissionsArray, $argPageName)
{
  $errorMessage = "security.php checkPagePermission() "; //requires pagevariables.php
  
  $pagePermissionLevel = 0; //initialize a variable to store the value
  $returnValue = 0; //initialize a variable to store the value
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database

    //get the permission level for this page
    $result = $mySQLConnectionLocal->query("CALL sp_CheckPagePermission('$argCompany', '$argSite', '$argDepartment', '$argPageName');"); //stored procedure method
   
    while($row = $result->fetch_assoc())
    {
      //echo "row found<br/>";
      $pagePermissionLevel = $row['permission_level'];
    }
    
    /*
    echo "DEBUG: the user's page permission level read is " . $pagePermissionLevel . "<br/>";
    echo "DEBUG: argCompany is " . $argCompany. "<br/>";
    echo "DEBUG: argSite is " . $argSite. "<br/>";
    echo "DEBUG: argDepartment is " . $argDepartment. "<br/>";
    */
    
    //if the page isn't in the database then all users will be able to access it
    
    //compare the page permission level and the user permission
    if(isset($userPermissionsArray[$argCompany][$argSite][$argDepartment]))
    {
      //echo "DEBUG: the user's permission level is " . $userPermissionsArray[$argCompany][$argSite][$argDepartment] . "<br/>";
      if($userPermissionsArray[$argCompany][$argSite][$argDepartment] >= $pagePermissionLevel)
      {
        $returnValue = 1;
      }
    }

    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error checking page permissions.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: checkEditPermission($argDepartment, $argPageName, $userID)
* Author: Matt Nutsch
* Date: 4-17-2017
* Description: 
* This function will check if a user has permission to edit a page.
* If the user has permission then it will return the value 1.
* If the user does not have permission then it will return the value 0.
*******************************************************************************/
function checkEditPermission($argDepartment, $argPageName, $userID)
{
  $returnValue = 0; //initialize a variable to store the value
  
  $currentSite = "";
  $currentDepartment = strtolower($argDepartment);
  $currentCompany = "";
  
  try
  {
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database

    $userPermissionsArrayLocal = getUserPermissions($userID, $mySQLConnectionLocal);
    
    $sql = "CALL sp_ui_NavLeftLinksGetAll"; //reused existing stored procedure
    $result = $mySQLConnectionLocal->query($sql);
    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        //echo "Comparing " . $argDepartment . $argPageName . " and " . ($row["DeptName"] . strtolower($row["web_file"])) . "<br/>";
        // Get the current page's company and site
        if(($argDepartment . $argPageName) == ($row["DeptName"] . strtolower($row["web_file"])))
        {
          //echo "Match found!<br/>";
          $currentCompany = $row["company"];
          $currentSite = $row["site"];
        }
      }
    }
      
    //compare the page permission level and the user permission
    if(($userPermissionsArrayLocal != NULL) && isset($userPermissionsArrayLocal[$currentCompany][$currentSite][$currentDepartment])) //if the user has any permissions AND they have this specific permission
    {
      if($userPermissionsArrayLocal[$currentCompany][$currentSite][$currentDepartment] >= 5) 
      {
        $returnValue = 1; //the user has permission to edit
      }
      else
      {
        $returnValue = 0; //the user does not have permission to edit
      }
    }
    else
    {
      $returnValue = 0; //the user does not have permission to edit
    }
      
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error checking user permission to edit page.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: updateUserPassword($userID, $unhashedPassword)
* Author: Matt Nutsch
* Date: 3-16-2017
* Description: 
* This function will: 
* The first parameter should be a userID as an integer.
* The second parameter should be a string with the new unhashed password.
* The function returns 1 if successful and 0 if not successful
*******************************************************************************/
function updateUserPassword($userID, $unhashedPassword)
{
  $errorMessage = "Page: " . $PageName . ". Department: " . $PageDept . ". "; //requires pagevariables.php
  
  //Set Debugging Options
  $debugging = 0; //set this to 1 to see debugging output
  $returnValue = 0;

  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database

    $t=time(); //variable used for obtaining the current time
  
    //echo "updateUserPassword called<br/>";
  
    //hash the password
    $password = password_hash($unhashedPassword, PASSWORD_DEFAULT);
  
    /*
    //create the SQL command to update the database
    $sql = "UPDATE main_users SET password = '" . $password . "', require_password_reset = '0' WHERE id = '" . $userID . "';"; //direct SQL method
  
    //perform the SQL command
    $result =  $mySQLConnectionLocal->query($sql); //direct SQL method
    */
    $result = $mySQLConnectionLocal->query("CALL sp_UpdateUserPassword('$password', '$userID');"); //stored procedure method
  
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
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error updating a user's password.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $returnValue;
  
}

/*******************************************************************************
* Function Name: getUserByToken($tokenid)
* Description: 
* The first parameter should be a string consisting of the token id,
* The object received should have a variable labelled "username": $userObject->vars["id"]
* The function returns a single object containing the user data retrieved.
* The user will be identified based on the user ID.
*******************************************************************************/
function getUserByToken($tokenid)
{
  $errorMessage = "Page: " . $PageName . ". Department: " . $PageDept . ". "; //requires pagevariables.php
  
  $returnValue = 0; //a value to tell us if the process was successful.
 
  try
  {
 
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    //echo "Function: The username received was " . $username . "<br>";
  
    $table_name = "main_users";
  
    //$sql = "SELECT * FROM $table_name WHERE password_reset_token = '$tokenid' LIMIT 1"; //direct SQL method
    //$result =  $mySQLConnectionLocal->query($sql); //direct SQL method
  
    $result = $mySQLConnectionLocal->query("CALL sp_GetUserByToken('$tokenid');"); //stored procedure method
 
 
    while($row = $result->fetch_assoc())
    {
      $testObject->vars["id"] = $row['id'];
      $testObject->vars["first_name"] = $row['first_name'];
      $testObject->vars["last_name"] = $row['last_name'];
      $testObject->vars["display_name"] = $row['display_name'];
      $testObject->vars["email"] = $row['email'];
      $testObject->vars["company"] = $row['company'];
      $testObject->vars["main_department_id"] = $row['main_department_id'];
      $testObject->vars["password"] = $row['password'];
      $testObject->vars["last_logged"] = $row['last_logged'];
      $testObject->vars["start_date"] = $row['start_date'];
      $testObject->vars["separation_date"] = $row['separation_date'];
      $testObject->vars["is_active"] = $row['is_active'];
      $testObject->vars["require_password_reset"] = $row['require_password_reset'];
      $testObject->vars["username"] = $row['username'];
      $testObject->vars["password_reset_token"] = $row['password_reset_token'];
      $testObject->vars["password_token_expiration"] = $row['password_token_expiration'];
      //$testObject->vars["qc_labtech"] = $row['qc_labtech'];
      //$testObject->vars["qc_sampler"] = $row['qc_sampler'];
      //$testObject->vars["qc_operator"] = $row['qc_operator'];
      $testObject->vars["user_type_id"] = $row['user_type_id'];
      $testObject->vars["manager_id"] = $row['manager_id'];
    }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error getting a user by their token.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $testObject;
}

/*******************************************************************************
* Function Name: getHelpText($argPage, $argDepartment)
* Description: 
* This function will get help text from the database. 
* The first paramater should be a string containing the page name.
* The second parameter should be a string containing the department name.
* The function returns a string to be output as HTML.
*******************************************************************************/
function getHelpText($argPage, $argDepartment)
{
  $errorMessage = "security.php getHelpText() "; //requires pagevariables.php
  
  $returnValue = ""; //a value to return.
  
  try
  {
	
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    //$sql = "SELECT * FROM main_help_text WHERE page = '$argPage' AND department = '$argDepartment' LIMIT 1"; //direct SQL method
    //$result =  $mySQLConnectionLocal->query($sql); //direct SQL method
  
    $result = $mySQLConnectionLocal->query("CALL sp_GetHelpText('$argPage','$argDepartment');"); //stored procedure method
 
    while($row = $result->fetch_assoc())
    {
      $returnValue = $row['text'];
    }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
	$errorMessage = $errorMessage . "Error getting the help text.";
	sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
	if($debugging == 1)
	{
	  echo $errorMessage;
	  //$error = $e->getMessage();
      //echo $error;
	}
  }
  
  return $returnValue;
}

/*******************************************************************************
* Function Name: getBackOfficeUserBySilicoreID($userID)
* Description: 
* This function will: 
* The first paramater should be an integer containing the Silicore userID.
* The function returns an integer containing the Back Office userID.
* DEV NOTE: This function was commented out in KACE 18518, because Silicore no 
* longer interfaces with Back Office.
*******************************************************************************/
/*
function getBackOfficeUserBySilicoreID($userID)
{
  $errorMessage = "security.php getBackOfficeUserBySilicoreID() "; //requires pagevariables.php
  $testObject = null;
  $returnValue = 0; //a value to tell us if the process was successful.
  
  try
  {
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $sql = "SELECT * FROM main_user_mapping_bo WHERE silicore_user_id = '$userID' LIMIT 1"; //direct SQL method
    $result =  $mySQLConnectionLocal->query($sql); //direct SQL method
 
    while($row = $result->fetch_array())
    {
      $returnValue = $row[2];     
    }
  
    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error translating a Silicore user ID into a Back Office user ID.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $returnValue;
}
*/


/*******************************************************************************
* Function Name: getDepartments()
* Description: 
* This function will: 
* Returns an array of objects containing department data.
*******************************************************************************/
function getDepartments()
{
  $errorMessage = "security.php getDepartments() "; //requires pagevariables.php
  $departmentArray = NULL;
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $sql = "CALL sp_DepartmentsGet();"; 
    
    $result =  $mySQLConnectionLocal->query($sql); 
  
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $departmentArray[$outputCount]->vars["id"] = $row['id'];
      $departmentArray[$outputCount]->vars["name"] = $row['name'];
      $departmentArray[$outputCount]->vars["name_code"] = $row['name_code'];
      $departmentArray[$outputCount]->vars["description"] = $row['description'];
      $departmentArray[$outputCount]->vars["is_active"] = $row['is_active'];
      
      $outputCount++;
    }

    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error getting info on all departments.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $departmentArray;
}

/*******************************************************************************
* Function Name: getUserTypes()
* Description: 
* This function will: 
* Returns an array of objects containing the user type data.
*******************************************************************************/
function getUserTypes()
{
  $errorMessage = "security.php getUserTypes() "; //requires pagevariables.php
  $testObjects = NULL;
  $returnValue = 0; //a value to tell us if the process was successful.
  $result = 0;
  $sql = 0;
  $row = 0;
  
  try
  {
  
    $mySQLConnectionLocal = connectToMySQLSecurity(); //connect to the database
  
    $result = $mySQLConnectionLocal->query("CALL sp_UserTypesSelectAll();"); //stored procedure method
  
    $outputCount = 0;
    while($row = $result->fetch_assoc())
    {
      $testObjects[$outputCount]->vars["id"] = $row['id'];
      $testObjects[$outputCount]->vars["name"] = $row['name'];
      $testObjects[$outputCount]->vars["description"] = $row['description'];
      $testObjects[$outputCount]->vars["value"] = $row['value'];
      $testObjects[$outputCount]->vars["is_active"] = $row['is_active'];
    
      $outputCount++;
      $returnValue = 1;
    }

    disconnectFromMySQL($mySQLConnectionLocal);
  
  }
  catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error getting info on all users.";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    if($debugging == 1)
    {
      echo $errorMessage;
      //$error = $e->getMessage();
      //echo $error;
    }
  }
  
  return $testObjects;
}


//====================================================================== END PHP
?>