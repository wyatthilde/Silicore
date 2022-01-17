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

$singleUserObject = NULL;
//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); 


if($debugging==1)
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
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
include('../../Includes/Templates/navbar.php');

if($debug)
{
  require_once('../../Includes/debug-main.php');  
  echo("<br /><br />");
}
$userAuthorization = 0;

if($userPermissionsArray != NULL)
{
  $userAuthorization = checkPagePermission($pageCompany, $pageSite, strtolower($PageDept), $userPermissionsArray, basename($_SERVER['PHP_SELF']));
}


if ($userAuthorization == 0 && $PageDept !== "General" && $PageName !== "main.php") 
	{
		 echo("<script type=\"text/javascript\">alert('You do not have permission to this page');</script>");
		 echo("<script type=\"text/javascript\">window.location = \"../../Controls/General/main.php\";</script>");
	}

if(($PageDept == "General") && ($PageName == "main.php"))
{
  if($user_id != "")
  {
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
    require_once('../../Content/General/notsignedin.php'); 
  }
}
else
{
  if($user_id != "")
  {
    if(($currentPagePermissionLevel == 0) || ($userAuthorization > 0))
    {
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
      echo("<script type=\"text/javascript\">window.location = \"../../Controls/General/main.php\";</script>"); //using JS, because output is already sent in header.php
      require_once('../../Content/General/notauthorized.php'); 
    }
  }
  else
  {
    echo("<script type=\"text/javascript\">window.location = \"../../Controls/General/main.php\";</script>"); //using JS, because output is already sent in header.php
    require_once('../../Content/General/notsignedin.php');
  }
}
?>
    </div>
    <footer class="sticky-footer">
      <div class="container">

      </div>
    </footer>




  </div>

    <script src="../../Includes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../Includes/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../Includes/js/sb-admin.min.js"></script>
    <link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css">
    <script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>

