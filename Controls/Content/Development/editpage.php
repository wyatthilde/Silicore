<?php
/* * *****************************************************************************
 * File Name: editpage.php
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 4-11-2017
 * Description:  Content file for updating page content
 * Notes: 
 * **************************************************************************** */
?>
<strong>Edit Page Content</strong>
<br/><br/>

<?php
//==================================================================== BEGIN PHP

$debugging = 0; //set this to 1 to see debugging output
$t=time(); //variable used for obtaining the current time
//display information if we are in debugging mode
if($debugging == 1)
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
include_once('../../Includes/adminfunctions.php'); //function for admin

echo "UNDER DEVELOPMENT, SEE KACE # 16553<br/><br/>";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  echo "The POST form was submitted.<br/>";
  
  //get the values
  $targetPageDept = $_POST["pageDepartment"];
  $targetPageName = $_POST["pageName"];
  $text_to_insert = $_POST["text_to_insert"];
  
  echo "targetPageDept = " . $targetPageDept . "<br/>";
  echo "targetPageName = " . $targetPageName . "<br/>";
  echo "text_to_insert = " . htmlentities($text_to_insert) . "<br/>";
  echo "File URL is: " . "../../Content/" . $targetPageDept . "/" . $targetPageName . "<br/>";
  
  //edit the file
  $targetFile = fopen("../../Content/" . $targetPageDept . "/" . $targetPageName, "w") or die("Error: Unable to open file!");
  fwrite($targetFile, $text_to_insert);
  fclose($targetFile);
  
  //display confirmation
  echo "The file has been updated.<br/>";
}

//page_to_edit corresponds to the field id in the ui-nav-left table.
if((isset($_GET["pagedept"])) && (isset($_GET["pagename"])))
{
  if (($_SERVER["REQUEST_METHOD"] == "GET") && ($_GET["pagedept"] != "") && ($_GET["pagename"] != "")) 
  {
    echo "The GET form was submitted.<br/>";

    $targetPageDept = $_GET["pagedept"];
    $targetPageName = $_GET["pagename"];

    echo "targetPageDept = " . $targetPageDept . "<br/>";
    echo "targetPageName = " . $targetPageName . "<br/>";

    //read the text of page to edit
    $arrContextOptions=array(
      "ssl"=>array(
          "verify_peer"=>false, //do not validate SSL connection for development 
          "verify_peer_name"=>false, //do not validate SSL connection for development 
      ),
    );  
    $pageContent = file_get_contents('../../Content/' . $targetPageDept . '/' . $targetPageName, false, stream_context_create($arrContextOptions));

    //echo "pageContent = " . $pageContent . "<br/>";

    echo "Updating the content the page: <strong>" . $targetPageDept . "-" . $targetPageName . "</br><strong>";
    echo "<form action=\"editpage.php\" method=\"post\">" .
    "Edit the text and click Save:</br>" .
    "<textarea class=\"general_style\" name=\"text_to_insert\" id=\"text_to_insert\">" . htmlentities($pageContent) . "</textarea>" .  //display the text in the textarea
    "<input type=\"hidden\" value=\"" . $targetPageDept . "\" name=\"pageDepartment\" id=\"page_edited\">" .  //put the page id into the value of a hidden input
    "<input type=\"hidden\" value=\"" . $targetPageName . "\" name=\"pageName\" id=\"page_edited\">" .  //put the page id into the value of a hidden input
    "<br/>" . 
    "<input type=\"submit\" value=\"Save\" class=\"general_style\">" . " " .
    "<button type=\"cancel\" onclick=\"window.location='../../Controls/" . $targetPageDept . "/" . $targetPageName . "';return false;\" class=\"general_style\">Cancel</button>" . 
    "</form>";

  } //if variables are not blank
} //if get variables are set
else
{
  echo "Access this page by clicking Edit in the sub-menu of another page.<br/>";
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

//====================================================================== END PHP
?>

<!-- HTML -->


