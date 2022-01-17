<?php
/* * *****************************************************************************************************************************************
 * File Name: pagevariables.php
 * Project: Silicore
 * Description: Main PHP variables/functions to be included in all pages
 * Notes: Always use 'filter_input()' when accessing Superglobals like server variables.
 *        $_SERVER['REMOTE_ADDR'] becomes filter_input(INPUT_SERVER,'REMOTE_ADDR',FILTER_SANITIZE_STRING)
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * ?/?/?|kkuehn|KACE:10499 - Initial creation
 * ?/?/?|mnutsch|KACE:xxxxx - Added password reset token and cookie login functionality.
 * 6/9/2017|mnutsch|KACE:xxxxx - Continued development.
 * 7/14/2017|mnutsch|KACE:17366 - Added server name variables.
 * 08/17/2017|kkuehn|KACE:10499 - Added display functionality for Site title and build
 * 09/08/2017|mnutsch|KACE:xxxxx - Added reference to security.php which was missing and causing an error message.
 * 09/08/2017|kkuehn|KACE:18598 - Added $HRProgram variable so we can reference the actual program name in page/field labels
 * 09/12/2017|mnutsch|KACE:17959 - Removed the "<!-- HTML -->" text, because it interfered with app functionality.
 * 09/27/2017|kkuehn|KACE:10499 - Added variables for global email settings.
 * 10/23/2017|mnutsch|KACE:19217 - Added username as a session variable for easy access by error messages.
 * 12/05/2017|mnutsch|KACE:18968 - Added $ProdNotify.. variables.
 * 12/07/2017|mnutsch|KACE:19845 - Added code to fix a password reset issue.
 * 12/28/2017|mnutsch|KACE:19861 - Added qc production sample notification email addresses.
 * 01/03/2017|kkuehn|KACE:19861 - Updated qc production sample notification email addresses for Granbury, Tolar and West Texas.
 * 07/17/2018|nolliff|KACE:xxxxx - Added user_agent session variable will be set to 1 if mobile 0 if not
 * 
 * **************************************************************************************************************************************** */
 
//==================================================================== BEGIN PHP

//include other files
require_once ('/var/www/configuration/db-mysql-sandbox.php'); //contains database connection info
require_once ('security.php'); //contains functions for processing user info

$debug = 0; // Set to 1 when testing/debugging, 0 for production

$DevServer = "smashbox";
$TestServer = "progdev001";
$ProdServer = "progtest001";
// Rackspace external production server: score1.vprop.com

$DevServerIP = "192.168.97.40";
$TestServerIP = "192.168.97.41";
$ProdServerIP = "192.168.97.42";
// Rackspace external production server: 172.24.16.236 (this is the local VPN IP, true external is 148.62.48.236

//Email addresses 
$TestEmailTo = "devteam@vprop.com";
$QCNotifyDev = "mnutsch@vprop.com";
$QCNotifyTest = "rbanning@vprop.com";
$QCNotifyProd = "rbanning@vprop.com";
$HRProgram = "Paycom";

$gb_ProdNotifyDev = "mnutsch@vprop.com";
$gb_ProdNotifyTest = "mnutsch@vprop.com";
$gb_ProdNotifyProd = "GB_QCSampleAlerts@vprop.com";

$tl_ProdNotifyDev = "mnutsch@vprop.com";
$tl_ProdNotifyTest = "mnutsch@vprop.com";
$tl_ProdNotifyProd = "TL_QCSampleAlerts@vprop.com";

$wt_ProdNotifyDev = "mnutsch@vprop.com";
$wt_ProdNotifyTest = "mnutsch@vprop.com";
$wt_ProdNotifyProd = "WT_QCSampleAlerts@vprop.com";

//VProp color variables
$vprop_blue = "#003087";
$vprop_blue_medium = "#4C7AD0";
$vprop_blue_light = "#A2BCED";
$vprop_green = "#78D64B";
$vprop_green_light= "#BADBAA";

// Get page information
$ServerName = filter_input(INPUT_SERVER, 'SERVER_NAME',FILTER_SANITIZE_STRING);
$ServerSubDomElements = explode(".",$ServerName);
$ServerSubDomain = $ServerSubDomElements[0];
$ServerIP = filter_input(INPUT_SERVER, 'SERVER_ADDR',FILTER_SANITIZE_STRING);
$FullPath = filter_input(INPUT_SERVER,'HTTP_POST',FILTER_SANITIZE_STRING) . filter_input(INPUT_SERVER,'REQUEST_URI',FILTER_SANITIZE_STRING);
$PathElements = explode("/",$FullPath);
$PathElementCount = count($PathElements);
$PageNameWithQS = $PathElements[$PathElementCount - 1];
// Strip the querystring variables from the page name, if applicable
$PageNameElements = explode("?",$PageNameWithQS);
$PageName = $PageNameElements[0];
$PageNameShort = substr($PageName,0,-4);
$PageDept = $PathElements[$PathElementCount - 2];

// Variables for displaying site and build information.
$SiteTitle = "Silicore";
$SiteBuild = "Build 028";
switch($ServerSubDomain)
{
  case "silicore-dev":
    $SiteBuildType = "[Dev]";
    break;
  case "silicore-test":
    $SiteBuildType = "[Test]";
    break;
  case "silicore":
    $SiteBuildType = "[Live]";
    break;
  default:
    $SiteBuildType = "";
    break;
}

// Get user information
$UserIP = filter_input(INPUT_SERVER,'REMOTE_ADDR',FILTER_VALIDATE_IP,FILTER_FLAG_IPV4);
$UserIPElements = explode(".",$UserIP);
$UserIPSubnetFull = $UserIPElements[0] . "." . $UserIPElements[1] . "." . $UserIPElements[2];
$UserIPSubnet = $UserIPElements[2];
$_SESSION['user_agent'] = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT']);
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) 
{
  session_start();
}

//check if there is a password reset token_get_all

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
  //echo "A get variable is set<br/>";
  
  //get values from the web form and sanitize them
  //$tokenid = $_GET["tokenid"];
  $tokenid = filter_input(INPUT_GET, 'tokenid', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  if(isset($tokenid))
  {
      //$tokenid = test_input($_GET["tokenid"]);
	  //echo "The token ID = " . $tokenid . "<br/>";

	  //sign the user in
	  
	  //$mySQLConn = connectToMySQL(); //connect to mysql, requires security.php

	  //"Querying Database for the token..";
	  $singleUserObject = getUserByToken($tokenid); //output details on a user, requires security.php
	  
	  //check if the user is flagged "is active" in the database
	  $is_active = $singleUserObject->vars["is_active"];
	  
	  //display the password reset window
	  
	  //if the user account is active
	  if($is_active == 1)
	  {
		//then set the session variables
		$user_id = $singleUserObject->vars["id"]; //user ID
		$_SESSION["user_id"] = $user_id; //user ID
		
		//$singleUserObject->vars["require_password_reset"] should already equal 1
		$_SESSION["signin_password_reset"] = true; //force the user to reset their password
		
		//header to reload the home page, which will open the password reset modal window
		header('Location: ../../Controls/General/main.php');
	  }
	  else //if not authorized 
	  {
		//A deactivated user tried to log in with a password reset token
		//The user can click the sign in button to sign in manually.
	  }
  
  }
  else
  {
	//echo "the token id is not set"; 
  }
  
  
}

// If the user is not logged AND has a cookie set, then try to automatically log them in
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != '')
{
  $user_id_input = filter_input(INPUT_COOKIE, 'user_id',FILTER_SANITIZE_STRING);
  $password_input = filter_input(INPUT_COOKIE, 'password_hash',FILTER_SANITIZE_STRING);
  
  //get user data from mysql:
  
  $mySQLConn = connectToMySQL(); //connect to mysql, requires security.php

  //"Querying Database for the user id..";
  $singleUserObject = getUser($user_id_input); //output details on a user, requires security.php
  
  //this is the hashed password from the database
  $hashedPassword = $singleUserObject->vars["password"];
  
  //check if the user is flagged "is active" in the database
  $is_active = $singleUserObject->vars["is_active"];
  
  //if the password hash from the cookie and the password hash from the database match
  if(($password_input == $hashedPassword) && ($is_active == 1))   
  {
    //then set the session variables
    $user_id = $singleUserObject->vars["id"];
    $_SESSION["user_id"] = $user_id;
    
    //set the user name for easy access
    $_SESSION["username"] = $singleUserObject->vars["username"];
 	
    //header to reload the signed in home page
    header('Location: ../../Controls/General/main.php');
  }
  else //if not authorized 
  {
    //The password in the cookie is not correct.
	//The user can click the sign in button to sign in manually.
  }
 
}
else //if the user is signed in
{
  //echo "debug: the user is signed in<br/>";
  
  $user_id = "";
  
  if(isset($_SESSION["user_id"]))
  {
    if(strlen($_SESSION["user_id"]) > 0)
    {
      $user_id = $_SESSION["user_id"]; //used by nav-left.php, header.php and MASTER.php

      //set the user name for easy access
      $singleUserObject = getUser($user_id);
      $_SESSION["username"] = $singleUserObject->vars["username"];
    }
  }
  
  //echo "debug: the user ID is: " . $user_id . " <br/>";
  
  $userPermissionsArray = [[[]]]; //Initialize a 3D array to hold the permissions. //used by nav-left.php and MASTER.php
  
  // Get user navigation permission info
  if($user_id != "")
  {
    $userPermissionsArray = getUserPermissions($user_id); //used by nav-left.php and MASTER.php
  }
}

/*******************************************************************************
* Function Name: connectToMySQL()
* Author: Matt Nutsch
* Description: 
* This function will: 
* Connect to MySQL.
* The connection information should be stored as constants, defined in an included file.
* The connection will be stored in a global variable called $GLOBALS['conn'];
* The function will return 1 if the connection was made and 0 if not.
*******************************************************************************/
function connectToMySQL()
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
    echo "Error connecting to MySQL: <br>" . $mySQLConnection->error;
    return 0;
  } 
  else
  {
    return $mySQLConnection;
  }
  
}

//====================================================================== END PHP
?>
