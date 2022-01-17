<?php
/**************************************************************************************************************************************
 * File Name: nav-left.php 
 * Project: Sandbox
 * Author: kkuehn, mnutsch
 * Date Created: 6-9-2017
 * Description: Main left-side navigation structure and content page
 * Notes: Main site navigation menu links. Eventually it should be database-driven, but for now we can hard-code the elements as needed. 
 *        This will be included in the MASTER or any custom templates as needed, but should not be altered for specific pages. Each link 
 *        added to the $navlinks array below must have a corresponding Control/Content page with the same name (php files should be all 
 *        lowercase).
 *
 * Still need to be able to add 'static', non-deparmental links as well (like 'Home'). 
 * 
 * Need to create a new DB table called 'ui_nav_left_links', then add the sort order there (not in the department table). 
 * 
 * The links should be grabbed from the department table only if the department is listed as active (is_active). *** NO! Need to maintain active
 * links separately from active/inactive departments. Context is much different.
 * 
 * All departmental sub links can fall into this table, sorted by sort order within department. Should start the sort orders in the 1000 range, 
 * which will leave plenty of room in each department for new pages. The 'Home' link will be sort order 100, always putting it above the 
 * '1000-level' links, but allowing 100 links to be inserted above it, as wanted.
 * 
 * Need to create a FK to the department table in order to get the department info as needed, but still leave the ability to enter 'static' 
 * links in the link table. 
 * 
 * Having a main_department_id column will also help with sorting of the child links for each department. 
 * 
 * If no main_department_id, then the link can be considered static, and will be sorted by its sort_order, globally.
 * 
 * This will put all of the link sorting functionality into the sproc. Should build a column called 'web_file' into the links table as
 * well. This will contain the PHP (or other) file string that the link is pointed to in the /Controls folder. This will only be for reference
 * in the context of building the menu. We'll still want to use the pagevariables filename functionality for dynamic, self-aware UI enhancements.
 * 
 * 
 * 08/31/2017|nolliff|KACE:18394 - Altered links to directly link to content file for bug fix
 * 09/22/2017|kkuehn|KACE:18762 - Added .navUL CSS class to the menu UL to fix global site issues.
 * 02/13/2018|kkuehn|KACE:20928 - Added is_hidden field to links table, allowing exclusion from the menu while still keeping the page is_active.
 *************************************************************************************************************************************/


//==================================================================== BEGIN PHP

//================================================================================ SAVE THIS COMMENT SECTION TO SHOW KEN THE DIFFERENCES
/*
// TODO: Need to build the navlinks array dynamically from the DB [DONE]
$navlinks = 
 [
  "Home",
  "Accounting",
  "Development",
  "HR",
  "Operations",
  "Production",
  "QC",
  "Safety"    
 ];

$menustring = "";

foreach($navlinks as $value)
{
  // Check if menu link is associated with the current page, if so, remove link, add static class
  if($PageNameShort == strtolower($value))
  {
    $menustring .= '<span class="nav-left-link-dead">' . $value . '</span><br />';
  }
  else
  {
    $menustring .= '<a href="' . strtolower($value) . '.php" class="nav-left-link">' . $value . '</a><br />';
  }
}
echo($menustring);
*/

$debugging = 0; //set this to 1 to see debugging output

//display information if we are in debugging mode
if($debugging == 1)
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

///////////require_once ('../../Includes/security.php'); //contains a function for interacting with the ui-nav-left table

///////////$dbconn = new mysqli(SANDBOX_DB_HOST,SANDBOX_DB_USER,SANDBOX_DB_PWD,SANDBOX_DB_DBNAME001);

$dbc = databaseConnectionInfo();
$dbconn = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );
//--------------------------------------------------------------------------------------- Get menu links from ui_nav_left_links

// TODO: Place this block of code in a try/catch, not 'die'.
// NOTE: Menu links are sorted in the sproc by 'sort_order'

if($dbconn->connect_error)
{
  die("Connection failed: " . $dbconn->connect_error);
}

$sql = "CALL sp_ui_NavLeftLinksGetAll";
$result = $dbconn->query($sql);
$dbconn->close();

$menustring = "";
$rowCounter = 0; //used for setting the first link HTML
$topLevelCounter = 0;

if($result->num_rows > 0)
{  
  while($row = $result->fetch_assoc())
  {
    if($row["is_hidden"] == 1) //Exclude links that are marked as hidden
    {
      $currentPageCompany = $row["company"]; 
      $currentPageSite = $row["site"]; 
      $currentPageDepartment = $row["permission"];
      $currentPagePermissionLevel = $row["permission_level"]; 
    }
    else //Build nav list
    {
      $rowCounter = $rowCounter + 1; //used for setting the first link HTML

      // Check for current page, no link if so
      if(($PageDept . $PageName) == ($row["DeptName"] . strtolower($row["web_file"])))
      {      
        if(($row["indent"] == 0)) //if this is a parent link 
        {
          $topLevelCounter = $topLevelCounter + 1; //used in the JavaScript to unhide child links
          if($rowCounter != 1) //if this is not the first link
          {
            $menustring .= "</ul></li>"; //close the previous parent link's ul and li
          }
          $menustring .= '<li class="navLI">
            <span onmousemove="javascript: navHover(this.className);" class="nav-group-' . $topLevelCounter . ' nav-left-link-current nav-top-level">' . $row["link_name"] . '</span>
            <ul class="navUL">'; //leave this items li open and start an ul
        }
        else
        {
          $menustring .= '<li class="navLI"><span class="nav-left-link-current nav-group-' . $topLevelCounter . ' nav-child-level">' . $row["link_name"] . '</span></li>'; //normal list item
        }	  
        //Set the current page permission information. This is used by MASTER.php.
        $currentPageCompany = $row["company"]; 
        $currentPageSite = $row["site"]; 
        $currentPageDepartment = $row["permission"];
        $currentPagePermissionLevel = $row["permission_level"]; 
      }
      // All other links should be live
      else
      {
        //The user permissions are read in /Includes/pagevariables.php and stored as $userPermissionsArray.      
        //Check whether the user has permission to access the link.
        $pageCompany = $row["company"]; 
        $pageSite = $row["site"]; 
        $pageDepartment = $row["permission"];
        $pagePermissionLevel = $row["permission_level"]; 

        $userHasPermission = 0;
        if(isset($userPermissionsArray[$pageCompany][$pageSite][$pageDepartment]))
        {
          if($userPermissionsArray[$pageCompany][$pageSite][$pageDepartment] >= $pagePermissionLevel)
          {
            $userHasPermission = 1;
          }
        }

        //if page permission level = 0 OR the user has permission then render the link normally
        if(($pagePermissionLevel == 0) || ($userHasPermission == 1))
        {

          if(($row["indent"] == 0)) //if this is a parent link 
          {
            $topLevelCounter = $topLevelCounter + 1; //used in the JavaScript to unhide child links
            if($rowCounter != 1) //if this is not the first link
            {
              $menustring .= "</ul></li>"; //close the previous parent link's ul and li
            }

            if($row["is_external"] == 0) //if it is an internal link then build the URL
            {
              $menustring .= '<li class="navLI">
                <a href="../../Controls/' . $row["DeptName"] . '/' . strtolower($row["web_file"]) . 
                  '" onmousemove="javascript: navHover(this.className);" class="nav-group-' . $topLevelCounter . 
                  ' nav-left-link nav-top-level" title="'. $row["link_title"] . '">' . $row["link_name"] . '
                </a><ul class="navUL">'; //leave this items li open and start an ul
            }
            else //else it is an external link, so just display the URL
            {
              $menustring .= '<li class="navLI">
                <a href="' . strtolower($row["web_file"]) . '" onmousemove="javascript: navHover(this.className);" class="nav-group-' . $topLevelCounter . 
                  ' nav-left-link nav-top-level" title="'. $row["link_title"] . '" target="_blank">' . $row["link_name"] . '
                </a><ul class="navUL">'; //leave this items li open and start an ul
            }
          }
          else
          {
            if($row["is_external"] == 0) //if it is an internal link then build the URL
            {
              $menustring .= '<li class="navLI">
                <a href="../../Controls/' . $row["DeptName"] . '/' . strtolower($row["web_file"]) . '" class="nav-left-link nav-group-' . $topLevelCounter . 
                  ' nav-child-level" title="'. $row["link_title"] . '">' . $row["link_name"] . '
                </a></li>'; //normal list item
            }
            else //else it is an external link, so just display the URL
            {
              $menustring .= '<li class="navLI">
                <a href="' . strtolower($row["web_file"]) . '" class="nav-left-link nav-group-' . $topLevelCounter . 
                  ' nav-child-level" title="'. $row["link_title"] . '" target="_blank">' . $row["link_name"] . '
                </a></li>'; //normal list item
            }
          }
        }
        else //if not, then render the link name in grayed out text without <a href>
        {
          if(($row["indent"] == 0)) //if this is a parent link 
          {
            $topLevelCounter = $topLevelCounter + 1; //used in the JavaScript to unhide child links
            if($rowCounter != 1) //if this is not the first link
            {
              $menustring .= "</ul></li>"; //close the previous parent link's ul and li
            }
            $menustring .= '<li class="navLI">
              <span onmousemove="javascript: navHover(this.className);" class="nav-group-' . $topLevelCounter . ' nav-left-link-dead nav-top-level">' . $row["link_name"] . '</span>
              <ul class="navUL">'; //leave this items li open and start an ul
          }
          else
          {
            $menustring .= '<li class="navLI"><span class="nav-left-link-dead nav-group-' . $topLevelCounter . ' nav-child-level">' . $row["link_name"] . '</span></li>'; //normal list item
          }  
        } //else //if not, then render...
      } //not a current page
    } //check if link is_hidden
  } //while results from the database  
}
else
{
  $menustring = "There was an error retreiving the navigation links from the database. Please contact the system administrator.";
}

echo('<div class="menu">'); //declare a div around the menu for CSS styling
echo('<ul class="navUL">'); //start an unsorted list

echo($menustring);

echo('</ul></li>'); //close the last top level menu item
echo('</ul>'); //end the unsorted list
echo('</div>'); //menu div

//--------------------------------------------------------------------------------------- Do next thing

//====================================================================== END PHP
?>

<!-- This is an oil price ticker -->
<!--
<div class="oil_price_chart">
<script type="text/javascript" src="../../Includes/oilpricechart.js"></script><noscript>Please Enable Javascript for this <a href="https://oilprice.com/">Oil Price</a> widget to work</noscript>
</div>
-->
<!-- HTML -->



