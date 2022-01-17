<?php
/* * *****************************************************************************************************************************************
 * File Name: MASTER.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/30/2016|kkuehn|KACE:10499 - Initial creation
 * 4/?/2017|mnutsch|KACE:xxxxx - Added user permissions checking code.
 * 7/3/2017|mnutsch|KACE:17279 - Corrected a bug in the user permissions checking process.
 * 07/20/2017|kkuehn|KACE:17639 - Moved the include call to /Includes/security.php from pagevariables to this template. Added the global
 *                                database access file include call here as well. Changed the call to pagevariables from include to
 *                                require_once.
 * 07/28/2017|mnutsch|KACE:17678 - Corrected bug that appeared in the user profile page.
 * 08/24/2017|nolliff|KACE:18251 - Changed functions to reflect code conventions
 * 08/31/2017|nolliff|KACE:18394 - Altered to fix bug with admin page
 * 09/27/2017|kkuehn|KACE:10499 - Moved the pagevariables include statement above the others.
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

require_once('../../Includes/pagevariables.php');
require_once('../../Includes/security.php'); // Functions for interacting with the main_users table
require_once('../../Includes/Security/dbaccess.php'); // Global database access credentials functionality

//====================================================================== END PHP
?>

<!-- HTML -->



<?php


// Start the session
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}
?>

<div id="controlshell" class="div-master">

  <div id="header" class="div-header">
    <?php require_once('../../Includes/Templates/header.php'); ?>
  </div>

  <div id="mid-nav-and-content" class="div-mid-nav-and-content">
  
    <div id="nav-left" class="div-nav-left">
      <?php require_once('../../Includes/Templates/nav-left.php'); ?>
    </div>

    <div id="content" class="div-content" onmousemove="javascript: resetMenu();"> <!--nav and content wrapper-->
    
<?php  

if($debug)
{
  require_once('../../Includes/debug-main.php');  
  echo("<br /><br />");
}
$userAuthorization = 0;

/*
echo("DEBUG: " . $PageDept . '/' . $PageName . "<br/>");
echo("DEBUG: the permission level needed to access this page is " . $currentPagePermissionLevel . "<br/>");
echo("DEBUG: the pageCompany is " . $pageCompany . "<br/>");
echo("DEBUG: the pageSite is " . $pageSite . "<br/>");
echo("DEBUG: the PageDept is " . $PageDept . "<br/>");
echo("DEBUG: the user permissions array is: ");
echo(var_dump($userPermissionsArray));
echo("<br/>");
echo("DEBUG: the current file name is " . basename($_SERVER['PHP_SELF']) . "<br/>");
*/

$userAuthorization = 0;
if($userPermissionsArray != NULL)
{
  $userAuthorization = checkPagePermission($pageCompany, $pageSite, strtolower($PageDept), $userPermissionsArray, basename($_SERVER['PHP_SELF']));
}

//echo("DEBUG: userAuthorization is " . $userAuthorization . "<br/>");
//$PageDept


//if this is the main page
if(($PageDept == "General") && ($PageName == "main.php"))
{
  //echo("DEBUG: This is the landing page.<br/>");
  //if the user is signed in
  if($user_id != "")
  {
    //echo("DEBUG: the user is signed in<br/>");
    //display the content
    if(isset($IsConfig))
    {
      $parentDir = (($IsConfig === 1) ? "Config" : "Content");
      require_once('../../'. $parentDir . '/' . $PageDept . '/' . $PageName);
    }
    else
    {
      require_once('../../Content/' . $PageDept . '/' . $PageName);
    }
  }
  else
  {
    //echo("DEBUG: The user is not signed in.<br/>");
    //display a sign in form
    require_once('../../Content/General/notsignedin.php'); 
  }
}
else
{
  //echo("DEBUG: this is not the main page<br/>");
  //if the user is signed in
  if($user_id != "")
  {
    //echo("DEBUG: the user is signed in<br/>");
    //if the page requires no permission or the user is authorized
    if(($currentPagePermissionLevel == 0) || ($userAuthorization > 0))
    {
      //echo("DEBUG: the page requires no permission or the user is authorized<br/>");
      //display the content
      if(isset($IsConfig))
      {
        $parentDir = (($IsConfig == 1) ? "Config" : "Content");
        require_once('../../'. $parentDir . '/' . $PageDept . '/' . $PageName);
      }
      else
      {
        require_once('../../Content/' . $PageDept . '/' . $PageName);
      }
    }
    else
    {
      //echo("DEBUG: redirecting the user to the main page<br/>");
      //redirect the user to the main page
      echo("<script type=\"text/javascript\">window.location = \"../../Controls/General/main.php\";</script>"); //using JS, because output is already sent in header.php
      //display the not authorized message as a fallback
      require_once('../../Content/General/notauthorized.php'); 
    }
  }
  else
  {
    //echo("DEBUG: the user is NOT signed in<br/>");
    //redirect the user to the main page
    echo("<script type=\"text/javascript\">window.location = \"../../Controls/General/main.php\";</script>"); //using JS, because output is already sent in header.php
    //display the not signed in message as a fallback
    require_once('../../Content/General/notsignedin.php'); 
  }
}

?>
    </div> <!--content-->
  
  </div> <!--nav and content wrapper-->

  <!--
  <div id="footer" class="div-footer">
    <?php //require_once('../../Includes/Templates/footer.php'); ?>    
  </div>
  -->
</div> 



