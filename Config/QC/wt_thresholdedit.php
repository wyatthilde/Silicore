<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_thresholdedit.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/10/2017|mnutsch|KACE:19061 - Initial creation
 * 11/13/2017|mnutsch|KACE:19061 - Continued development
 * 07/06/2018|zthale|KACE:24019 - Enabled a confirmation message for saving a threshold edit.
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP

$screenOptions = array("20","30","40","50","60","70","80","100","120","140","170","200","230","270","325","Pan");

//Set Debugging Options
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
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains QC database query functions

$allValuesPresent = 1;

if(isset($_GET['thresholdID']) && strlen($_GET['thresholdID']) > 0)
{
  //read the ID from REST
  $thresholdID = urldecode(test_input($_GET['thresholdID']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdScreen']) && strlen($_GET['thresholdScreen']) > 0)
{
  //read the ID from REST
  $thresholdScreen = urldecode(test_input($_GET['thresholdScreen']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdLocation']) && strlen($_GET['thresholdLocation']) > 0)
{
  //read the ID from REST
  $thresholdLocation = urldecode(test_input($_GET['thresholdLocation']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdLow']) && strlen($_GET['thresholdLow']) > 0)
{
  //read the ID from REST
  $thresholdLow = urldecode(test_input($_GET['thresholdLow']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdHigh']) && strlen($_GET['thresholdHigh']) > 0)
{
  //read the ID from REST
  $thresholdHigh = urldecode(test_input($_GET['thresholdHigh']));
}
else
{
  $allValuesPresent = 0;
}

if(isset($_GET['thresholdIsActive']) && strlen($_GET['thresholdIsActive']) > 0)
{
  //read the ID from REST
  $thresholdIsActive = urldecode(test_input($_GET['thresholdIsActive']));
}
else
{
  $allValuesPresent = 0;
}

//if all of the inputs were received then, proceed
if($allValuesPresent == 1)
{

  echo("<h1>Edit Threshold</h1><br /><br />");
  
  echo("<form action='../../Includes/QC/tl_thresholdupdate.php' method='get'>");
  
    echo("<div class='form-group'>");
    echo("<label for='thresholdID'>ID:</label>");
    echo("<input type='number' id='thresholdID' name='thresholdID' value='" . $thresholdID . "' readonly>");
    echo("</div>");
    
    echo("<br/>");
    echo("<br/>");
    
    echo("<div class='form-group'>");
    echo("<label for='thresholdScreen'>Screen:</label>");
    echo("<select id='thresholdScreen' name='thresholdScreen' required>");
      for($i = 0; $i < count($screenOptions); $i++)
      {
        if($screenOptions[$i] == $thresholdScreen)
          {
          echo("<option selected value='" . $screenOptions[$i] . "'>" . $screenOptions[$i] . "</option>");
          }
          else
            {
                echo("<option value='" . $screenOptions[$i] . "'>" . $screenOptions[$i] . "</option>");
            }
    
      }
    echo("</select>");
    echo("</div>");
    
    echo("<br/>");
    echo("<br/>");
    
    //get an array of objects
    $locationObjectArray = getLocations();
    echo("<div class='form-group'>");
    echo("<label for='thresholdLocation'>Location:</label>");
    echo("<select id='thresholdLocation' name='thresholdLocation' required>");
      for($j = 0; $j < count($locationObjectArray); $j++)
      {
        echo("<option value='" . $locationObjectArray[$j]->vars['id'] . "'>" . $locationObjectArray[$j]->vars['description'] . "</option>");
      }
    echo("</select>");
    echo("</div>");
        
    echo("<br/>");
    echo("<br/>");
    
    echo("<div class='form-group'>");
    echo("<label for='thresholdLow'>Low Threshold:</label>");
    echo("<input id='thresholdLow' name='thresholdLow' value='" . $thresholdLow . "' type='number' min='0' max='1' step='0.01' required>");
    echo("</div>");
        
    echo("<br/>");
    echo("<br/>");
    
    echo("<div class='form-group'>");
    echo("<label for='thresholdHigh'>High Threshold:</label>");
    echo("<input id='thresholdHigh' name='thresholdHigh' value='" . $thresholdHigh . "' type='number' min='0' max='1' step='0.01' required>");
    echo("</div>");
    
    echo("<input type='hidden' id='thresholdIsActive' name='thresholdIsActive' value='1'");
    
    echo("<br/>");
    echo("<br/>");
    echo("<button type=\"submit\" style=\"width:150px; margin-left: 70px;\" class=\"btn btn-success\" onclick=\"return confirm('Are you sure you want to save this threshold?')\">Save Threshold</button>");

  echo("</form>");
  
}
else 
{
  //redirect the user to the QC Threshold Maintenance page
  echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/wt_thresholdmaint.php\";</script>"; //using JS, because output is already sent in header.php
}


/***************************************
* Name: function test_input($data) 
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
****************************************/
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//========================================================================================== END PHP
?>

<!-- include the QC style sheet -->
<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">

<!-- HTML -->