<?php
/* * *****************************************************************************************************************************************
 * File Name: updatepagehelp.php
 * Project: Silicore
 * Description: Content file for updating page help text
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 04/10/2017|mnutsch|KACE:xxxxx - File created.
 * 07/28/2017|mnutsch|KACE:17573 - Corrected bug that appeared in the page after server migration.
 * 
 * **************************************************************************************************************************************** */

?>
<strong>Update Page Help Text</strong>
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
include_once('../../Includes/adminfunctions.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  //echo "The POST form was submitted.<br/>";
  $page_edited = NULL;
  $text_to_insert = NULL;
  
  if(isset($_POST["page_edited"]))
  {
    $page_edited = test_input($_POST["page_edited"]);
  }
  if(isset($_POST["text_to_insert"]))
  {
    $text_to_insert = test_input($_POST["text_to_insert"]);
  }
  
  //echo "The page edited is: " . $page_edited . "<br/>";
  //echo "The text to insert is: " . $text_to_insert . "<br/>";

  //Update the help text in the database
  $updateResult = updatePageHelp($page_edited, $text_to_insert);

  //display a success message to the user
  if($updateResult == 1)
  {
    echo "Successfully updated page help text!";
  }
  else
  {
    echo "Error updating page help text!";
  }
}

if(isset($_GET["page_to_edit"]))
{
  if (($_SERVER["REQUEST_METHOD"] == "GET") && ($_GET["page_to_edit"] != ""))
  {
    //echo "The GET form was submitted.<br/>";
    $page_to_edit = test_input($_GET["page_to_edit"]);
    //echo "The value received is: " . $page_to_edit . "<br/>";

    //read the text of page to edit
    $pageHelpObject = getPageHelpByID($page_to_edit);
    echo "Updating the page help text for the page: <strong>" . $pageHelpObject->vars["department"] . "-" . $pageHelpObject->vars["page"] . "</br><strong>";
    echo "<form action=\"updatepagehelp.php\" method=\"post\">" .
    "Edit the text and click Save:</br>" .
    "<textarea class=\"general_style\" name=\"text_to_insert\" id=\"text_to_insert\">" . $pageHelpObject->vars["text"] . "</textarea>" .  //display the text in the textarea
    "<input type=\"hidden\" value=\"" . $page_to_edit . "\" name=\"page_edited\" id=\"page_edited\">" .  //put the page id into the value of a hidden input
    "<br/>" . 
    "<input type=\"submit\" value=\"Save\" class=\"general_style\">" . " " .
    "<button type=\"cancel\" onclick=\"window.location='updatepagehelp.php';return false;\" class=\"general_style\">Cancel</button>" . 
    "</form>";

  }
  else
  {
    echo "<form action=\"updatepagehelp.php\" method=\"get\">" .
    "Select a page to edit the help text:</br>" .
    "<select class=\"general_style\" id=\"page_to_edit\" name=\"page_to_edit\">"; 

    //read a list of pages to edit
    $pageHelpArray = getPageHelp();      
    
    //put the list in the select dropdown
    foreach ($pageHelpArray as $pageObject) 
    {
      echo "<option value=\"" . $pageObject->vars["id"] . "\">" . $pageObject->vars["department"] . "-" . $pageObject->vars["page"] . "</option>";
    }

    echo "</select><br/>" . 
    "<input type=\"submit\" value=\"Get Details\" class=\"general_style\">" .
    "</form>";
  }
}
else
{
  
  //read a list of pages to edit
  $pageHelpArray = getPageHelp();
  
  echo "<form action=\"updatepagehelp.php\" method=\"get\">" .
  "Select a page to edit the help text:</br>" .
  "<select class=\"general_style\" id=\"page_to_edit\" name=\"page_to_edit\">"; 
  
  //put the list in the select dropdown
  foreach ($pageHelpArray as $pageObject) 
  {
    echo "<option value=\"" . $pageObject->vars["id"] . "\">" . $pageObject->vars["department"] . "-" . $pageObject->vars["page"] . "</option>";
  }
  
  echo "</select><br/>" . 
  "<input type=\"submit\" value=\"Get Details\" class=\"general_style\">" .
  "</form>";
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


