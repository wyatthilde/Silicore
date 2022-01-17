<?php
/*********************************************************************************************************************************************
 * File Name: debug-main.php
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Oct 31, 2016[10:51:25 AM]
 * Edited : Mar 9, 2017 by mnutsch
 * Description: Main include file for debug variables to be displayed in a div at the top of all pages when the 'global' debug variable is set
 *              to '1' in page variables.
 * Notes: Should only use PHP-driven content output in this section, no raw HTML. All DB connections to be made using extraneous config files, 
 *        eclared in pagevariables.php.
 * 08/17/2017|kkuehn|KACE:10499 - Added display functionality for Site title and build
  ********************************************************************************************************************************************/

/*
 * 
 * mnutsch User IP: 192.168.80.104 (from local machine over Maalt VPN)
 * mnutsch User IP: 192.168.88.5 (from Maalt Remote server)
 * 
 */


//==================================================================== BEGIN PHP

echo("ServerName: " . $ServerName . "<br />");
echo("ServerIP: " . $ServerIP . "<br />");
echo("User IP: " . $UserIP . "<br />");
echo("UserIPSubnetFull: " . $UserIPSubnetFull . "<br />");
echo("UserIPSubnet: " . $UserIPSubnet . "<br />");
echo("SiteTitle: " . $SiteTitle . "<br />");
echo("SiteBuild: " . $SiteBuild . "<br />");
echo("SiteBuildType: " . $SiteBuildType . "<br />");
echo("PageName: " . $PageName . "<br />");
echo("PageNameShort: " . $PageNameShort . "<br />");
echo("PageDept: " . $PageDept . "<br />");
echo("Server Document Root: " . filter_input(INPUT_SERVER,'DOCUMENT_ROOT',FILTER_SANITIZE_STRING) . "<br />"); //$_SERVER['DOCUMENT_ROOT']
echo("dirname(__FILE__): " . dirname(__FILE__) . "<br />");
//echo("SANDBOX_DB_USER: " . SANDBOX_DB_USER . "<br />");
//echo("SANDBOX_DB_HOST: " . SANDBOX_DB_HOST . "<br />");
//echo("SANDBOX_DB_DBNAME001: " . SANDBOX_DB_DBNAME001 . "<br />");
//echo("SANDBOX_DB_PWD: " . "No so fast, bucko!" . "<br />");

//Output the cookie and session info if in debug mode
/*
session_start();
echo "User ID Cookie = " . filter_var($_COOKIE['user_id']) . "<br/>";
echo "Password Hash Cookie = " . filter_var($_COOKIE['password_hash']) . "<br/>";
echo "User ID Session = " . filter_var($_SESSION["user_id"]) . "<br/>";
*/
//echo(phpinfo());
/*
$dbconn = new mysqli(SANDBOX_DB_HOST,SANDBOX_DB_USER,SANDBOX_DB_PWD,SANDBOX_DB_DBNAME001);

if($dbconn->connect_error)
{
  die("Connection failed: " . $dbconn->connect_error);
}

$sql = "CALL sp_GetNavLeftLinks";
$result = $dbconn->query($sql);
$menustring = "";

if($result->num_rows > 0)
{
  echo("<br />Returned " . $result->num_rows . " rows from ui_nav_left_links");
  echo
  (
    "<table border = 1>
     <tr>
     <td style='font-weight:bold;color:#660000;'>id</td>
     <td style='font-weight:bold;color:#660000;'>main_department_id</td>
     <td style='font-weight:bold;color:#660000;'>DeptName</td>
     <td style='font-weight:bold;color:#660000;'>parent_link_id</td>
     <td style='font-weight:bold;color:#660000;'>link_name</td>
     <td style='font-weight:bold;color:#660000;'>link_title</td>
     <td style='font-weight:bold;color:#660000;'>web_file</td>
     </tr>"
  );
  while($row = $result->fetch_assoc())
  {
    echo
    (
      "<tr> 
        <td>" . $row["id"] . "</td>
        <td>" . $row["main_department_id"] . "</td>  
        <td>" . $row["DeptName"] . "</td>
        <td>" . $row["parent_link_id"] . "</td>  
        <td>" . $row["link_name"] . "</td>  
        <td>" . $row["link_title"] . "</td>  
        <td>" . $row["web_file"] . "</td>
      </tr>"
    );
  }
  echo("</table>");
}
else
{
  $menustring = "There was an error retreiving the navigation links from the database. Please contact the system administrator.";
}

//echo("Connection successful");


$sql = "CALL sp_GetAllUsers";
$result = $dbconn->query($sql);

//$sql = "SELECT * from main_users";
//$result = $dbconn->query($sql);

if($result->num_rows > 0)
{
  echo("<br />Returned " . $result->num_rows . " rows from main_users <br /><br />");
  while($row = $result->fetch_assoc())
  {
    echo
    (
     "Row #" . 
     "ID: " . $row["id"] . "<br />" . 
     "First Name: " . $row["fname"] . "<br />" . 
     "Last Name: " . $row["lname"] . "<br />" . 
     "Email: " . $row["email"] . "<br />" . 
     "Company: " . $row["company"] . "<br />" . 
     "Start Date: " . $row["start_date"] . "<br /><br />"
    );
  }
}
else
{
  echo("No results");
}


$dbconn->close();
*/

//====================================================================== END PHP



