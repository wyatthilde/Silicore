<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_samples.php
 * Project: Silicore
 * Description: This page displays samples within given filter criteria.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 09/12/2017|mnutsch|KACE:17959 - Updated file locations in hyperlinks.
 * 09/15/2017|mnutsch|KACE:17957 - Added code to reverse void status on samples.
 * 09/27/2017|mnutsch|KACE:17957 - Added code for multi-select filters. 
 * 09/27/2017|mnutsch|KACE:17957 - Updated certain JavaScript functions.
 * 09/27/2017|mnutsch|KACE:17957 - Added a multi-select filter for specific location.
 * 09/27/2017|mnutsch|KACE:17957 - Added table sorting on header click.
 * 10/02/2017|mnutsch|KACE:17957 - Added title display on cell hover.
 * 10/27/2017|mnutsch|KACE:19258 - Added -70 +140 column.
 * 10/30/2017|mnutsch|KACE:18588 - Added REST parameters to the void and unvoid links.
 * 10/31/2017|mnutsch|KACE:18789 - Updated filters and function call.
 * 11/02/2017|mnutsch|KACE:19023 - Added three new fields to the table.
 * 11/15/2017|mnutsch|KACE:18470 - Added the field Is COA.
 * 11/17/2017|mnutsch|KACE:18470 - Added a filter for Is COA. 
 * 11/17/2017|mnutsch|KACE:19630 - Changed calculation of $orePercent.
 * 11/21/2017|mnutsch|KACE:18470 - Added REST parameters to Void, Unvoid, and Repeat hyperlink URL's.
 * 11/27/2017|mnutsch|KACE:19520 - Changed default filter settings. Changed text in a column label.
 * 11/27/2017|mnutsch|KACE:19328 - Added code to disable sorting of the checkbox column when the jQuery and jQuery Table Sorter libraries are updated.
 * 11/27/2017|mnutsch|KACE:19703 - Added a 10000 option to the filter Results Per Page.
 * 11/29/2017|mnutsch|KACE:19500 - Set the default setting for the Void filter to Active.
 * 12/04/2017|mnutsch|KACE:19802 - Fixed a bug related to filtering by low permission level users.
 * 12/04/2017|mnutsch|KACE:19803 - Fixed a bug related to views of voided samples for certain permission levels.
 * 01/08/2018|mnutsch|KACE:19775 - Added a table for search result calculations.
 * 01/10/2018|mnutsch|KACE:xxxxx - Corrected a snippet of code to look at Tolar permission instead of Granbury.
 * 01/10/2018|mnutsch|KACE:19775 - Added a duplicate of the summations table at the bottom of the page.
 * 01/15/2018|mnutsch|KACE:19755 - Added samplesTableWrapperBox div around Details table.
 * 01/29/2018|mnutsch|KACE:19775 - Removed unwanted columns from the Summations tables.
 * 02/01/2018|mnutsch|KACE:19755 - Added additional classes and ID's to the Details table.
 * 02/05/2018|mnutsch|KACE:19755 - Added additional code related to fixed headers and left columns in the Details table.
 * 02/07/2018|mnutsch|KACE:19755 - Added additional code related to fixed headers and left columns in the Details table.
 * 02/08/2018|mnutsch|KACE:19755 - Finished code related to fixed headers and left columns in the Details table.
 * 02/13/2018|mnutsch|KACE:xxxxx - Fixed a bug related to hyperlinks while working on something else.
 * 02/13/2018|mnutsch|KACE:19755 - Fixed a bug related to fixed left columns.
 * 02/13/2018|mnutsch|KACE:21241 - Fixed a bug related to filter options not showing text.
 * 06/12/2018|zthale|KACE:23211 - "Select All" header and checkbox now properly functioning. Issue was caused by JQuery. Added a function stopPropagation() which handles an event being fired, which removed the checkbox selection after being checked.
 * 07/09/2018|whildebrandt|KACE:23489 - Updated the design for the detailed samples table, by using datatables. This allows it to be compatible with the new navigation design.
 * 07/09/2018|whildebrandt|KACE:23489 - Removed all functions related reltaed to exporting and checkboxes as that has been offloaded to datatables.
 * 07/16/2018|whildebrandt|KACE:23254 - Added column -50+140 to table. Made changes to sample view and sample edit process to facilitate this change.
 * **************************************************************************************************************************************** */



//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains database connection info
require_once('../../Includes/security.php'); //contains database connection info

//ini_set('memory_limit', '128MB');
ini_set('max_execution_time', 300);
//init variables
$dateTwoWeeksPrior = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d")-14, date("Y")));
$dateYesterday = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d")-2, date("Y"))); //DEV NOTE: the SQL filter currently ignores time. Change the -2 to -1 after updating the filter.
$oneYearInTheFuture = date("Y-m-d G:i", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")+1));
$startDate = "";
$endDate = "";
$startRow = 0;
$resultsPerPage = 20;
$compositeType = "";
$shift = "";
$sampler = "";
$operator = "";
$completionStatus = "";
$view = "";
$void = "";

$value30 = "";
$value35 = "";
$value40 = "";
$value45 = "";
$value50 = "";
$value60 = "";
$value70 = "";
$value80 = "";
$value100 = "";
$value120 = "";
$value140 = "";
$value170 = "";
$value200 = "";
$value230 = "";
$value270 = "";
$value325 = "";
$valuePAN = "";   

$PLCArray = NULL;

$downloadArray = NULL;
$downloadArrayCount = 1;

$orePercent = 0;
$isCOA = "";
$slimesPercent = 0;
$oversizePercent = 0;

$testTypesRESTArray = array(); //stores the REST test types as an array
$testTypesRESTString = NULL; //stores the REST test types as a string
$locationsRESTArray = array(); //stores the REST locations as an array
$locationsRESTString = NULL; //stores the REST locations as a string
$labTechsRESTArray = array(); //stores the REST lab techs as an array
$labTechsRESTString = NULL; //stores the REST lab techs as a string
$sitesRESTArray = array(); //stores the REST sites as an array
$sitesRESTString = NULL; //stores the REST sites as a string
$plantsRESTArray = array(); //stores the REST plants as an array
$plantsRESTString = NULL; //stores the REST plants as a string
$specificLocationsRESTArray = array(); //stores the REST locations as an array
$specificLocationsRESTString = NULL; //stores the REST locations as a string

$drillholeNumber = "";
$depthFrom = "";
$depthTo = "";

//check if the completion status variable was passed in the URL
if(isset($_GET['completionStatus']) && strlen($_GET['completionStatus']) > 0)
{
  $completionStatus = urldecode(test_input($_GET['completionStatus']));
}
//dev note: I commented out this section, because it broke the ability to show all samples regardless of completion status. See KACE # 19520.
/*
else
{
  $completionStatus = 1;
}
*/

//check if the starting date variable was passed in the URL
if(isset($_GET['startDate']) && strlen($_GET['startDate']) > 1)
{
  $startDate = urldecode(test_input($_GET['startDate']));
}
else
{
  //$startDate = $dateTwoWeeksPrior;
  $startDate = $dateYesterday;  
}

//check if the end date variable was passed in the URL
if(isset($_GET['endDate']) && strlen($_GET['endDate']) > 1)
{
  $endDate = urldecode(test_input($_GET['endDate']));
}
else
{
  $endDate = $oneYearInTheFuture;
}

//check if the starting row variable was passed in the URL
if (!isset($_GET['startRow']) or !is_numeric($_GET['startRow'])) 
{
  //we give the value of the starting row to 0 because nothing was found in URL
  $startRow = 0;  
} 
else //otherwise we take the value from the URL
{
  $startRow = (int)$_GET['startRow'];
}
//output a hidden input with this value, so that JavaScript can pick it up  
echo('<input type="hidden" id="startRow" name="startRow" value="' . $startRow . '">');

//check if the results per page variable was passed in the URL
if (!isset($_GET['resultsPerPage']) or !is_numeric($_GET['resultsPerPage'])) 
{
  $resultsPerPage = 100;
} 
else 
{
  $resultsPerPage = (int)$_GET['resultsPerPage'];
}

//composite_type_filter
if(isset($_GET['compositeType']) && strlen($_GET['compositeType']) > 0)
{
  $compositeType = urldecode(test_input($_GET['compositeType']));
}

//shift_filter
if(isset($_GET['shift']) && strlen($_GET['shift']) > 0)
{
  $shift = urldecode(test_input($_GET['shift']));
}

//sampler_filter
if(isset($_GET['sampler']) && strlen($_GET['sampler']) > 0)
{
  $sampler = urldecode(test_input($_GET['sampler']));
}

//operator_filter
if(isset($_GET['operator']) && strlen($_GET['operator']) > 0)
{
  $operator = urldecode(test_input($_GET['operator']));
}

//view_filter
if(isset($_GET['view']) && strlen($_GET['view']) > 0)
{
  $view = urldecode(test_input($_GET['view']));
}

//void_filter
if(isset($_GET['void']) && strlen($_GET['void']) > 0)
{
  $void = urldecode(test_input($_GET['void']));
}

//set the void filter to default to Active if the user's QC permission level < 3
if(isset($userPermissionsArray['vista']['granbury']['qc']))
{
  if($userPermissionsArray['vista']['granbury']['qc'] < 3) 
  {
    $void = "A";
  }
}

//is_coa_filter
if(isset($_GET['isCOA']) && strlen($_GET['isCOA']) > 0)
{
  $isCOA = urldecode(test_input($_GET['isCOA']));
}

//get the location values
if(isset($_GET['locationsRESTString']) && strlen($_GET['locationsRESTString']) > 0)
{
  $locationsRESTString = urldecode(test_input($_GET['locationsRESTString']));
  
  //separate the values
  $locationsRESTArray = explode(",",$locationsRESTString);
}

//get the test type values
if(isset($_GET['testTypesRESTString']) && strlen($_GET['testTypesRESTString']) > 0)
{
  $testTypesRESTString = urldecode(test_input($_GET['testTypesRESTString']));
  
  //separate the values
  $testTypesRESTArray = explode(",",$testTypesRESTString);
}

//get the lab tech values
if(isset($_GET['labTechsRESTString']) && strlen($_GET['labTechsRESTString']) > 0)
{
  $labTechsRESTString = urldecode(test_input($_GET['labTechsRESTString']));
  
  //separate the values
  $labTechsRESTArray = explode(",",$labTechsRESTString);
}

//get the site values
if(isset($_GET['sitesRESTString']) && strlen($_GET['sitesRESTString']) > 0)
{
  $sitesRESTString = urldecode(test_input($_GET['sitesRESTString']));
  
  //separate the values
  $sitesRESTArray = explode(",",$sitesRESTString);
}

//get the plant values
if(isset($_GET['plantsRESTString']) && strlen($_GET['plantsRESTString']) > 0)
{
  $plantsRESTString = urldecode(test_input($_GET['plantsRESTString']));
  
  //separate the values
  $plantsRESTArray = explode(",",$plantsRESTString);
}

//get the specificLocation values
if(isset($_GET['specificLocationsRESTString']) && strlen($_GET['specificLocationsRESTString']) > 0)
{
  $specificLocationsRESTString = urldecode(test_input($_GET['specificLocationsRESTString']));
  
  //separate the values
  $specificLocationsRESTArray = explode(",",$specificLocationsRESTString);
}

?>
<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css">
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<script type="text/javascript" src="../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js"></script>
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>

<style>
    .excel-text {
        mso-number-format:"\@";
    }
</style>



<div id="qc_groups" class="tabcontent">
    
  <div class="right_content">
    <br/>
    <?php 
      //Only display the Repeatability info if the user is a lab tech
      //echo("<br/>DEBUG: user id = " . $user_id . "<br/>"); 
      $labTechArray = NULL;
      $labTechArray = getLabTechs();
      $userIsLabTech = 0;
      //echo("DEBUG: labtechs:<br/>");
      for($i = 0; $i < count($labTechArray); $i++)
      {
        //echo($labTechArray[$i]->vars['id'] . ". " . $labTechArray[$i]->vars['display_name'] . "<br/>");
        if($user_id == $labTechArray[$i]->vars['id'])
        {
          //echo("DEBUG: User is a labtech!<br/>");
          $userIsLabTech = 1;
        }
      }
      if($userIsLabTech == 1)
      {
        echo("Repeatability Counter: " . getRepeatabilityByUserId($user_id)); //requires qcfunctions.php);
      }
    ?>
  </div> <!-- right content -->

  <div class="left_content">
    <h3>Samples</h3>
    <p id="filters_displayed" class="filters_displayed"></p>
  </div> <!-- left content -->

   <button class="btn filter_button" id="filter_button" type="button">Filter Settings</button>

  <div id="filter_options" class="filter_options">
    
    <fieldset>
      <legend>Filters:</legend>
      <div class="form-group">
      <label for="start_date_filter">Start Date:</label>
      <input type="text" id="start_date_filter" name="start_date_filter" value="<?php echo $startDate; ?>" autocomplete="off" /></div>
      <br/>

      <div class="form-group">
      <label for="end_date_filter">End Date:</label> 
      <input type="text" id="end_date_filter" name="end_date_filter" value="<?php echo $endDate; ?>" autocomplete="off"/></div>
      <br/>

      <div class="form-group">  
      <label for="results_per_page">Results Per Page:</label>
      <select id="results_per_page" name="results_per_page" required>
      <?php
      if($resultsPerPage == 20)
      {
        echo('<option value="20" selected="selected">20</option>');
      }
      else
      {
        echo('<option value="20">20</option>');
      }

      if($resultsPerPage == 50)
      {
        echo('<option value="50" selected="selected">50</option>');
      }
      else
      {
        echo('<option value="50">50</option>');
      }

      if($resultsPerPage == 100)
      {
        echo('<option value="100" selected="selected">100</option>');
      }
      else
      {
        echo('<option value="100">100</option>');
      }

      if($resultsPerPage == 1000)
      {
        echo('<option value="1000" selected="selected">1000</option>');
      }
      else
      {
        echo('<option value="1000">1000</option>');
      }
      
      if($resultsPerPage == 10000)
      {
        echo('<option value="10000" selected="selected">10000</option>');
      }
      else
      {
        echo('<option value="10000">10000</option>');
      }

      ?>
      <select>
      </div>
      <br/>

      <div class="form-group">
      <label for="completion_status_filter">Completion Status:</label>
      <select name="completion_status_filter" id="completion_status_filter">
        <option value=""></option>      
        <option value="1" <?php if($completionStatus == "1"){ echo "selected=\"selected\""; } ?>>Complete</option>
        <option value="0" <?php if($completionStatus == "0"){ echo "selected=\"selected\""; } ?>>Incomplete</option>
      </select></div>
      <br/>
      
      <div class="form-group">
      <label for="test_type_button">Test Type:</label> 
      <button class="btn test_type_button" id="test_type_button" type="button">Select Test Types</button>
      <div id="test_type_options" class="test_type_options">
        <div class="testTypeSelect" id="testTypeSelect">
          <?php
            $testTypeObjectArray = getTestTypes(); //get a list of test type options
            foreach ($testTypeObjectArray as $testTypeObject) 
            {
              //if the location was sent as a REST parameter
              if(in_array($testTypeObject->vars["id"], $testTypesRESTArray))
              {
                //display the checkbox as checked
                echo "<div style='display:block;'><input type='checkbox' name='testTypeId[]' id='testTypeId[]' class='testTypeId' value='" . $testTypeObject->vars["id"] . "' checked><span class='testTypeLabels'>" . $testTypeObject->vars["description"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='testTypeId[]' id='testTypeId[]' class='testTypeId' value='" . $testTypeObject->vars["id"] . "'><span class='testTypeLabels'>" . $testTypeObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>

      <div class="form-group">
      <label for="composite_type_filter">Composite Type:</label> 
      <select id="composite_type_filter" name="composite_type_filter" required>
      <option value=""></option>
      <?php
      $compositeTypeObjectArray = getCompositeTypes(); //get a list of Composite Type options
      foreach ($compositeTypeObjectArray as $compositeTypeObject) 
      {
        if($compositeType == $compositeTypeObject->vars["id"])
        { 
          echo "<option value='" . $compositeTypeObject->vars["id"] . "' selected='selected'>" . $compositeTypeObject->vars["description"] . "</option>"; 
        }      
        else 
        { 
          echo "<option value='" . $compositeTypeObject->vars["id"] . "' >" . $compositeTypeObject->vars["description"] . "</option>"; 
        }       
      }
      ?>
      <select>
      </div>
      <br/>

      <div class="form-group">
      <label for="shift_filter">Shift:</label> 
      <select id="shift_filter" name="shift_filter" required>
      <option value=""></option>
      <option value="day" <?php if($shift == "day"){ echo "selected=\"selected\""; } ?>>Day</option>
      <option value="night" <?php if($shift == "night"){ echo "selected=\"selected\""; } ?>>Night</option>
      <select>
      </div>
      <br/>

      <div class="form-group">
      <label for="lab_tech_button">Lab Techs:</label> 
      <button class="btn lab_tech_button" id="lab_techs_button" type="button">Select Lab Techs</button>
      <div id="lab_tech_options" class="lab_tech_options">
        <div class="labTechSelect" id="labTechSelect">
          <?php
            $labTechObjectArray = getLabTechs(); //get a list of location options
            foreach ($labTechObjectArray as $labTechObject) 
            {
              //if the lab tech was sent as a REST parameter
              if(in_array($labTechObject->vars["id"], $labTechsRESTArray))
              {
                //display the checkbox as checked
                echo "<div style='display:block;'><input type='checkbox' name='labTechId[]' id='labTechId[]' class='labTechId' value='" . $labTechObject->vars["id"] . "' checked><span class='labTechLabels'>" . $labTechObject->vars["display_name"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='labTechId[]' id='labTechId[]' class='labTechId' value='" . $labTechObject->vars["id"] . "'><span class='labTechLabels'>" . $labTechObject->vars["display_name"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>

      <div class="form-group">
      <label for="sampler_filter">Sampler:</label>
      <select id="sampler_filter" name="sampler_filter" required>
      <option value=""></option>
      <?php
      $userObjectArray = getSamplers(); //get a list of users, requires security.php
      foreach ($userObjectArray as $userObject) 
      {
        if($sampler == $userObject->vars["id"])
        { 
          echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>"; 
        }      
        else 
        { 
          echo "<option value='" . $userObject->vars["id"] . "' >" . $userObject->vars["display_name"] . "</option>"; 
        }     

      }
      ?>
      </select>
      </div>
      <br/>

      <div class="form-group">
      <label for="operator_filter">Operator:</label>
      <select id="operator_filter" name="operator_filter" required>
      <option value=""></option>
      <?php
      $userObjectArray = getOperators(); //get a list of users, requires security.php
      foreach ($userObjectArray as $userObject) 
      {
        if($operator == $userObject->vars["id"])
        { 
          echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>"; 
        }      
        else 
        { 
          echo "<option value='" . $userObject->vars["id"] . "' >" . $userObject->vars["display_name"] . "</option>"; 
        }    

      }
      ?>
      </select>
      </div>
      <br/>

      <div class="form-group">
      <label for="sites_button">Sites:</label> 
      <button class="btn sites_button" id="sites_button" type="button">Select Sites</button>
      <div id="site_options" class="site_options">
        <div class="siteSelect" id="siteSelect">
          <?php
            $siteObjectArray = getSites(); //get a list of location options
            foreach ($siteObjectArray as $siteObject) 
            {
              //if the site was sent as a REST parameter
              if(in_array($siteObject->vars["id"], $sitesRESTArray))
              {
                //display the checkbox as checked
                echo "<div style='display:block;'><input type='checkbox' name='siteId' id='siteId' class='siteId' "
                        . "value='" . $siteObject->vars["id"] . "' checked><span class='siteLabels'>" . $siteObject->vars["description"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='siteId[]' id='siteId' class='siteId' value='" . $siteObject->vars["id"] . "' ><span class='siteLabels'>" . $siteObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>      

      <div class="form-group">
      <label for="plants_button">Plants:</label> 
      <button class="btn plant_button" id="plants_button" type="button">Select Plants</button>
      <div id="plant_options" class="plant_options">
        <div class="plantSelect" id="plantSelect">

          
          <?php
            $plantObjectArray = getPlants(); //get a list of plant options
            foreach ($plantObjectArray as $plantObject) 
            {
                $siteVar = $plantObject->vars["site"];
              //if the plant was sent as a REST parameter
              if(in_array($plantObject->vars["id"], $plantsRESTArray))
              {                             
               
                //display the checkbox as checked
                echo "<div site-id='". $siteVar ."' class=plantDiv name='plantId' style='display:block;'><input type='checkbox' name='plantId[]' id='plantId[" . $plantObject->vars["id"] . "]' class='plantId' " . "value='" . $plantObject->vars["id"] . "' onchange='filterSampleLocations(" . $plantObject->vars["id"] . ")' checked><span class='plantLabels'>" . $plantObject->vars["description"] . "</span><br></div>"; 
              }
              else if(in_array ($siteVar, $sitesRESTArray))
              {
                echo "<div  site-id='". $siteVar ."' class=plantDiv name='plantId' style='display:block;'><input type='checkbox' name='plantId[]' id='[" . $plantObject->vars["id"] . "]' class='plantId' value='" . $plantObject->vars["id"] . "' " . "onchange='filterSampleLocations(" . $plantObject->vars["id"] . ")'><span class='plantLabels'>" . $plantObject->vars["description"] . "</span><br></div>";
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div  site-id='". $siteVar ."' class=plantDiv name='plantId' style='display:none;'><input type='checkbox' name='plantId[]' id='[" . $plantObject->vars["id"] . "]' class='plantId' value='" . $plantObject->vars["id"] . "' " . "onchange='filterSampleLocations(" . $plantObject->vars["id"] . ")'><span class='plantLabels'>" . $plantObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>
      <div class="form-group">
      <label for="locations_button">Sample Locations:</label> 
      <button class="btn location_button" id="locations_button" type="button">Select Locations</button>
      <div id="location_options" class="location_options">
        <div class="locationSelect" id="locationSelect">
          <?php
            $locationObjectArray = getLocations(); //get a list of location options
            foreach ($locationObjectArray as $locationObject) 
            {
              $plantVar = $locationObject->vars["plant"];
              $siteVar = $locationObject->vars["site"];
              //if the location was sent as a REST parameter
              if(in_array($locationObject->vars["id"], $locationsRESTArray))
              {

                //display the checkbox as checked
                echo "<div site-id='". $siteVar ."' plant-id='". $plantVar ."' class=locationDiv name=locationId[" . $plantVar . "] style='display:block;'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId' value='" . $locationObject->vars["id"] . "' checked><span class='locationLabels'>" . $locationObject->vars["description"] . "</span><br></div>"; 
              }
              else if(in_array($plantVar, $plantsRESTArray))
                {
                //display if they are filtered in
                  echo "<div site-id='". $siteVar ."' plant-id='". $plantVar ."' class=locationDiv name=locationId[" . $plantVar . "] style='display:block;'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId' value='" . $locationObject->vars["id"] . "'><span class='locationLabels'>" . $locationObject->vars["description"] . "</span><br></div>";
                }
              else
              {
                //display the checkbox as unchecked
                echo "<div site-id='". $siteVar ."' plant-id='". $plantVar ."' class=locationDiv name=locationId[" . $plantVar . "] style='display:none;'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId' value='" . $locationObject->vars["id"] . "'><span class='locationLabels'>" . $locationObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>

      
      <div class="form-group">
      <label for="specific_locations_button">Specific Locations:</label> 
      <button class="btn specific_location_button" id="specific_locations_button" type="button">Select Specific Locations</button>
      <div id="specific_location_options" class="specific_location_options">
        <div class="specificLocationSelect" id="specificLocationSelect">
          <?php
            $specificLocationObjectArray = getSpecificLocations(); //get a list of location options
            foreach ($specificLocationObjectArray as $specificLocationObject) 
            {
                $plantVar = $specificLocationObject->vars["plant"];
                $siteVar = $specificLocationObject->vars["site"];
                $locationVar = $specificLocationObject->vars['qc_location_id'];
              //if the location was sent as a REST parameter
              if(in_array($specificLocationObject->vars["id"], $specificLocationsRESTArray))
              {
                //display the checkbox as checked
                echo "<div class='spcLocationDiv' site-id='". $siteVar ."' plant-id='". $plantVar ."'  location-id='". $locationVar ."' style='display:block;'><input type='checkbox' name='specificLocationId[]' id='specificLocationId[]' class='specificLocationId' value='" . $specificLocationObject->vars["id"] . "' checked><span class='specificLocationLabels'>" . $specificLocationObject->vars["description"] . "</span><br></div>"; 
              }
              else if(in_array($locationVar, $locationsRESTArray))
              {
                echo "<div class='spcLocationDiv' site-id='". $siteVar ."' plant-id='". $plantVar ."'  location-id='". $locationVar ."' style='display:block;'><input type='checkbox' name='specificLocationId[]' id='specificLocationId[]' class='specificLocationId' value='" . $specificLocationObject->vars["id"] . "'><span class='specificLocationLabels'>" . $specificLocationObject->vars["description"] . "</span><br></div>";
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div class='spcLocationDiv' site-id='". $siteVar ."' plant-id='". $plantVar ."'  location-id='". $locationVar ."' style='display:none;'><input type='checkbox' name='specificLocationId[]' id='specificLocationId[]' class='specificLocationId' value='" . $specificLocationObject->vars["id"] . "'><span class='specificLocationLabels'>" . $specificLocationObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>

      <div class="form-group">
      <label for="view_filter">View Type:</label>
      <select id="view_filter" name="view_filter" required>
      <?php
      if($view == "verbose")
      { 
        echo "<option value='verbose' selected='selected'>Verbose</option>"; 
      }      
      else 
      { 
        echo "<option value='verbose'>Verbose</option>"; 
      } 

      if($view == "summary")
      { 
        echo "<option value='summary' selected='selected'>Summary</option>"; 
      }      
      else 
      { 
        echo "<option value='summary'>Summary</option>"; 
      }
      ?>
      <select>
      </div>
      <br/>

      <div class="form-group">
      <label for="void_filter">Voided Status:</label>
      <select id="void_filter" name="void_filter" required>
      <?php 
      //If the user's permission level is less than 3 then limit their ability to select a Site.      
      if($userPermissionsArray['vista']['granbury']['qc'] < 3)
      {
        echo "<option value='A' selected='selected'>Active</option>"; 
      }
      else
      {
        if($void == "A")
        { 
          echo "<option value='A' selected='selected'>Active</option>"; 
        }      
        else 
        { 
          echo "<option value='A'>Active</option>"; 
        }
        if($void == "V")
        { 
          echo "<option value='V' selected='selected'>Voided</option>"; 
        }      
        else
        { 
          echo "<option value='V'>Voided</option>"; 
        }     
        if($void == "")
        { 
          echo "<option value='' selected='selected'>All</option>"; 
        }      
        else 
        { 
          echo "<option value=''>All</option>"; 
        }
      }
      ?>
      <select>
      </div>
      <br/>
      
      <div class="form-group">
      <label for="is_coa_filter">Is COA:</label>
      <select id="is_coa_filter" name="is_coa_filter" required>
        <option value=''></option>
      <?php 
      if($isCOA == "1")
      { 
        echo "<option value='1' selected='selected'>Yes</option>"; 
      }      
      else 
      { 
        echo "<option value='2'>Yes</option>"; 
      }

      if($isCOA == "0")
      { 
        echo "<option value='0' selected='selected'>No</option>"; 
      }      
      else
      { 
        echo "<option value='0'>No</option>"; 
      }          
      ?>
      <select>
      </div>
      <br/>      
      <button id="clearFilters" class="btn applyFilters" type="button" onclick="clearFilters()">Clear Filters</button><br/><br/>
      <button style="color:white; background-color: #003087;" id="applyFilters" class="btn applyFilters" type="button" onclick="reloadPage()">Apply Filters</button><br/><br/>
      
    </fieldset>
      
    <br/>
    
  </div>
  
  </select>
  
  <?php
    $sumsArray = getSamplesByFilters($startDate, $endDate, $startRow, $resultsPerPage, $completionStatus, $testTypesRESTString, $compositeType, $shift, $labTechsRESTString, $sampler, $operator, $sitesRESTString, $plantsRESTString, $locationsRESTString, $specificLocationsRESTString, $void, $isCOA);
  $ObjectArray = getSamplesByFilters($startDate, $endDate, $startRow, $resultsPerPage, $completionStatus, $testTypesRESTString, $compositeType, $shift, $labTechsRESTString, $sampler, $operator, $sitesRESTString, $plantsRESTString, $locationsRESTString, $specificLocationsRESTString, $void, $isCOA);
  foreach($sumsArray as $key => $value) {
      if ($value->vars["isRemoved"] == 0 || $value->vars["voidStatusCode"] == "V") unset($sumsArray[$key]);
  }
  ?>
        <form class="form-group">  
          <div class="col">
            <label for="sampleIdSearch">Go To Sample ID: </label> 
                <input type='number' pattern="[0-9]" id='idSearchBox' required>
                  <button class="btn" style="width:150px;"onclick="idSearch()" type="button" >Submit</button>
          </div>
        </form>


  <h4>Summations</h4>
  <div class="tableWrapper">
  <table class="table table-striped table-bordered dt-responsive summationsTable text-nowrap">
      
         <?php
          if($sumsArray == NULL)
          {
            echo "No samples were found.";
          }
          else 
          {
            echo("<thead>");
            echo("<tr><th></th>
                  <th>20</th>
                  <th>25</th>
                  <th>30</th>
                  <th>35</th>
                  <th>40</th>
                  <th>45</th>
                  <th>50</th>
                  <th>60</th>
                  <th>70</th>
                  <th>80</th>
                  <th>100</th>
                  <th>120</th>
                  <th>140</th>
                  <th>170</th>
                  <th>200</th>
                  <th>230</th>
                  <th>270</th>
                  <th>325</th>
                  <th>PAN</th>
                  <th>+10 (OS)</th>
                  <th class='excel-text'>-10+40</th>
                  <th class='excel-text'>-40+70</th>
                  <th class='excel-text'>-60+70</th>
                  <th class='excel-text'>-70+140</th>
                  <th class='excel-text'>-50+140</th>
                  <th>Near Size</th>
                  <th class='excel-text'>-140+325</th>
                  <th>-140</th>
                  <th>Moisture Rate</th>
                  <th>Turbidity</th>
                  </tr>");
            echo("</thead>");
            echo("<tbody>");
            
            $arrayOfAverages = NULL;
            $arrayOfStdDevs = NULL;
            $arrayOfMax = NULL;
            $arrayOfMin = NULL;
                        
            $arrayOfAverages = getObjectArrayPercentAverages($sumsArray);
            $arrayOfStdDevs = getObjectArrayPercentStdDevs($sumsArray, $arrayOfAverages);
            $arrayOfMaximums = getObjectArrayPercentMaximums($sumsArray);
            $arrayOfMinimums = getObjectArrayPercentMinimums($sumsArray);
            
            echo("<tr><td><strong>Avg</strong></td>");
            foreach($arrayOfAverages as $average) {
                if($average != 0) { echo("<td>" . round(($average * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            }

            echo("<tr><td><strong>Std Dev</strong></td>");
              foreach($arrayOfStdDevs as $standardDeviation) {
                  if($standardDeviation != 0) { echo("<td>" . round(($standardDeviation * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
              }


            echo("<tr><td><strong>Max</strong></td>");
              foreach($arrayOfMaximums as $max) {
                  if($max != 0) { echo("<td>" . round(($max * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
              }


            echo("<tr><td><strong>Min</strong></td>");
              foreach($arrayOfMinimums as $min) {
                  if($min != 100) { echo("<td>" . round(($min * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
              }


          }
        ?>
        
      </tbody>
  </table>
  </div>
  
  <hr>
      
  <h4>Details</h4>
 
  <?php
  //If the View filter is not set to verbose, then show the summary version of the Details table.
  if($view != "verbose")
  {
    
    if($ObjectArray == NULL)
    {
      echo "No samples were found.";
    }
    else 
    {
      //Display the Verbose version of the table.

          echo("<table id='samplesTable' name='samplesTable' class='table table-striped table-bordered text-nowrap'>");

            //get a list of PLC Tags to display as columns
            $PLCArray = getPLCTags();
            echo("<thead>");
            echo "<tr>" .

            "<th class='leftHead2 headContent'>Sample ID</th>" . //summary field
            "<th class='leftHead3 headContent'>Date</th>" . //summary field
            "<th class='leftHead4 headContent'>Time</th>" . //summary field
                "<th class='col4 headContent headContentNotLeft'>Location</th>"; //summary field
            echo "<th class='col0 headContent headContentNotLeft'>Test Type</th>" . //summary field
            "<th class='col1 headContent headContentNotLeft'>Composite Type</th>" . //summary field
            "<th class='col2 headContent headContentNotLeft'>Sieve Stack</th>" . //summary field
            "<th class='col3 headContent headContentNotLeft'>Plant</th>"; //summary field

              
            echo "<th class='col5 headContent headContentNotLeft'>Shift</th>" . //summary field
            "<th class='col6 headContent headContentNotLeft'>Sampler</th>" . //summary field
            "<th class='col7 headContent headContentNotLeft'>Lab Tech</th>" . //summary field
            "<th class='col8 headContent headContentNotLeft'>Operator</th>"; //summary field
              
            echo "<th class='col9 headContent headContentNotLeft'>Notes</th>" . //summary field
            "<th class='col10 headContent headContentNotLeft'>Moisture Rate</th>"; //summary field      
                          
            echo("<th class='col11 headContent headContentNotLeft'>Void Status</th>"); //summary field      
            echo("<th class='col12 headContent headContentNotLeft'>Completion Status</th>"); //summary field    

            echo "<th class='col13 headContent headContentNotLeft'>Site</th>"; //summary field  
            
            if(isset($userPermissionsArray['vista']['granbury']['qc']))
            {
              if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has QC permission then show them the hyperlinks
              {
                echo "<th  class='col14 headContent headContentNotLeft'></th>" . //edit
                "<th  class='col15 headContent headContentNotLeft'></th>" . //repeat
                "<th  class='col16 headContent headContentNotLeft'></th>"; //void
              }
              else {
                  echo "<th></th>";
                  echo "<th></th>";
                  echo "<th></th>";
              }
            }

            echo("</tr>");
            echo("</thead>");
            echo("<tbody>");

            /************************************************************************************/
            //create the header row for download
            $downloadArray[0] = "ID,Date,Time,Group Time,Test Type,Composite Type,Sieve Stack,Plant,Location,Specific Location ID,Shift,Sampler,Lab Tech,Operator,Plus Seventy (+70),Minus Seventy (-70),Minus Seventy Plus One Forty (-70 +140),Minus One Forty (-140),Minus Forty Plus Seventy (-40 +70),Beginning Wet Weight,Pre Wash Dry Weight,Post Wash Dry Weight,Split Sample Weight,Turbidity,Tons Represented,TPH Represented,Notes,Moisture Rate,Recovery +140,Group Start Datetime,Finish Datetime,Duration Minutes,Duration,Total Weight,Void Status,Drillhole Number,Depth From,Depth To,Completion Status,Site,Oversize Weight,Oversize Percent,Slimes Percent/Amt Lost in Wash,Ore Percent,Is COA,Description,Near Size,30,35,40,45,50,60,70,80,100,120,140,170,200,230,270,325,PAN";

            //dynamically output the PLC columns based on the values in the database
            for($i = 0; $i < count($PLCArray); $i++)
            {
              $downloadArray[0] = $downloadArray[0] . "," . $PLCArray[$i]->vars['device'];        
            }
            /************************************************************************************/

            $l = 0;
            foreach ($ObjectArray as $Object) 
            {
              $samplerName = NULL;
              $labTechName = NULL;
              $operatorName = NULL;

              //get the test type name //summary field
              $testTypeName = "";
              if($Object->vars["testType"] != NULL)
              {
                $testTypeObject = getTestTypeById($Object->vars["testType"]);
                if($testTypeObject != NULL)
                {
                  $testTypeName = $testTypeObject->vars["description"];
                }
              }

              //get the composite type name //summary field
              $compositeTypeName = "";
              if($Object->vars["compositeType"] != NULL)
              {
                $compositeTypeObject = getCompositeTypeById($Object->vars["compositeType"]);
                if($compositeTypeObject != NULL)
                {
                  $compositeTypeName = $compositeTypeObject->vars["description"];
                }
              }

              //get the sieve stack name //summary field
              $sieveStackName = "";
              if(($Object->vars["sieveMethod"] != NULL) && ($Object->vars["sieveMethod"] != "0"))
              {
                $sieveStackObject = getSieveStackById($Object->vars["sieveMethod"]);
                if($sieveStackObject != NULL)
                {
                  $sieveStackName = $sieveStackObject->vars["description"];
                }
              }

              //get the plant name //summary field
              $plantName = "";
              if($Object->vars["plantId"] != NULL)
              {
                $plantObject = getPlantById($Object->vars["plantId"]);
                if($plantObject != NULL)
                {
                  $plantName = $plantObject->vars["description"];
                }
              }        

              //get the location name //summary field
              $locationName = "";
              if($Object->vars["location"] != NULL)
              {
                $locationObject = getLocationById($Object->vars["location"]);
                if($locationObject != NULL)
                {
                  $locationName = $locationObject->vars["description"];
                }
              }        

              //get the lab tech name //summary field
              $labTechName = "";
              if($Object->vars["labTech"] != NULL)
              {
                $labTechObject = getUser($Object->vars["labTech"]);
                if($labTechObject != NULL)
                {
                  $labTechName = $labTechObject->vars["display_name"];
                }
              }        

              //get the sampler name //summary field
              $samplerName = "";
              if($Object->vars["sampler"] != NULL)
              {
                $samplerObject = getUser($Object->vars["sampler"]);
                if($samplerObject != NULL)
                {
                  $samplerName = $samplerObject->vars["display_name"];
                }
              }        

              //get the operator name //summary field
              $operatorName = "";
              if($Object->vars["operator"] != NULL)
              {
                $operatorObject = getUser($Object->vars["operator"]);
                if($operatorObject != NULL)
                {
                  $operatorName = $operatorObject->vars["display_name"];
                }
              }

              //get the total weight //summary field
              $totalFinalWeight = "";
              if($Object->vars["sieves_raw"] != NULL)
              {
                $sievesRaw = $Object->vars["sieves_raw"];
                $finalWeightArray = decodeWeights($sievesRaw);
                $totalFinalWeight = array_sum($finalWeightArray);                    
              }

              //get the moisture rate //summary field
              if($Object->vars["moisture_rate"] != NULL)
              {
                $moisture_rate = $Object->vars["moisture_rate"];
                $moisture_rate = ($moisture_rate * 100) . "%";
              }
              else
              {
                $moisture_rate = "";
              }  

              //get the name of the Specific Location
              if(isset($Object->vars["specificLocation"]))
              {
                if($Object->vars["specificLocation"] != NULL)
                {
                  $specificLocationObject = getSpecificLocationByID($Object->vars["specificLocation"]); 
                  if(isset($specificLocationObject->vars["description"]))
                  {
                    $specificLocationName = $specificLocationObject->vars["description"];
                  }
                  else
                  {
                    $specificLocationName = "";
                  }
                }
                else
                {
                  $specificLocationName = "";
                }
              }

              //get the screen sizes            
              //reset the values
              $value30 = "";
              $value35 = "";
              $value40 = "";
              $value45 = "";
              $value50 = "";
              $value60 = "";
              $value70 = "";
              $value80 = "";
              $value100 = "";
              $value120 = "";
              $value140 = "";
              $value170 = "";
              $value200 = "";
              $value230 = "";
              $value270 = "";
              $value325 = "";
              $valuePAN = ""; 
              //match the values from the database against the appropraite variable
              //sieve1
              switch ($Object->vars["sieve1Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve1Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve1Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve1Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve1Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve1Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve1Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve1Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve1Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve1Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve1Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve1Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve1Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve1Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve1Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve1Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve1Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve1Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve2
              switch ($Object->vars["sieve2Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve2Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve2Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve2Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve2Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve2Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve2Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve2Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve2Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve2Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve2Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve2Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve2Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve2Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve2Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve2Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve2Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve2Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve3
              switch ($Object->vars["sieve3Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve3Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve3Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve3Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve3Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve3Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve3Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve3Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve3Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve3Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve3Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve3Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve3Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve3Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve3Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve3Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve3Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve3Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve4
              switch ($Object->vars["sieve4Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve4Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve4Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve4Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve4Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve4Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve4Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve4Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve4Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve4Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve4Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve4Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve4Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve4Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve4Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve4Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve4Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve4Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve5
              switch ($Object->vars["sieve5Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve5Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve5Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve5Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve5Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve5Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve5Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve5Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve5Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve5Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve5Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve5Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve5Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve5Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve5Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve5Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve5Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve5Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve6
              switch ($Object->vars["sieve6Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve6Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve6Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve6Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve6Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve6Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve6Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve6Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve6Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve6Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve6Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve6Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve6Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve6Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve6Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve6Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve6Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve6Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve7
              switch ($Object->vars["sieve7Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve7Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve7Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve7Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve7Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve7Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve7Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve7Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve7Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve7Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve7Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve7Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve7Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve7Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve7Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve7Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve7Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve7Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve8
              switch ($Object->vars["sieve8Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve8Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve8Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve8Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve8Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve8Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve8Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve8Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve8Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve8Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve8Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve8Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve8Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve8Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve8Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve8Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve8Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve8Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve9
              switch ($Object->vars["sieve9Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve9Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve9Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve9Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve9Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve9Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve9Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve9Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve9Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve9Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve9Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve9Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve9Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve9Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve9Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve9Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve9Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve9Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }
              //sieve10
              switch ($Object->vars["sieve10Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve10Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve10Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve10Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve10Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve10Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve10Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve10Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve10Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve10Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve10Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve10Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve10Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve10Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve10Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve10Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve10Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve10Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option          
              }

              //sieve11
              switch ($Object->vars["sieve11Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve11Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve11Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve11Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve11Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve11Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve11Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve11Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve11Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve11Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve11Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve11Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve11Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve11Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve11Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve11Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve11Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve11Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve12
              switch ($Object->vars["sieve12Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve12Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve12Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve12Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve12Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve12Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve12Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve12Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve12Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve12Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve12Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve12Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve12Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve12Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve12Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve12Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve12Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve12Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve13
              switch ($Object->vars["sieve13Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve13Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve13Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve13Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve13Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve13Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve13Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve13Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve13Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve13Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve13Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve13Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve13Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve13Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve13Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve13Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve13Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve13Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve14
              switch ($Object->vars["sieve14Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve14Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve14Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve14Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve14Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve14Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve14Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve14Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve14Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve14Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve14Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve14Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve14Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve14Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve14Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve14Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve14Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve14Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve15
              switch ($Object->vars["sieve15Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve15Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve15Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve15Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve15Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve15Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve15Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve15Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve15Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve15Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve15Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve15Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve15Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve15Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve15Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve15Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve15Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve15Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve16
              switch ($Object->vars["sieve16Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve16Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve16Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve16Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve16Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve16Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve16Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve16Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve16Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve16Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve16Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve16Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve16Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve16Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve16Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve16Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve16Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve16Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve17
              switch ($Object->vars["sieve17Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve17Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve17Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve17Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve17Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve17Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve17Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve17Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve17Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve17Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve17Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve17Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve17Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve17Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve17Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve17Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve17Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve17Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //sieve18
              switch ($Object->vars["sieve18Desc"]) 
              {
                case "30":
                    $value30 = $Object->vars["sieve18Value"];
                    break;
                case "35":
                    $value35 = $Object->vars["sieve18Value"];
                    break;
                case "40":
                    $value40 = $Object->vars["sieve18Value"];
                    break;
                case "45":
                    $value45 = $Object->vars["sieve18Value"];
                    break;
                case "50":
                    $value50 = $Object->vars["sieve18Value"];
                    break;
                case "60":
                    $value60 = $Object->vars["sieve18Value"];
                    break;
                case "70":
                    $value70 = $Object->vars["sieve18Value"];
                    break;  
                case "80":
                    $value80 = $Object->vars["sieve18Value"];
                    break;
                case "100":
                    $value100 = $Object->vars["sieve18Value"];
                    break;
                case "120":
                    $value120 = $Object->vars["sieve18Value"];
                    break;
                case "140":
                    $value140 = $Object->vars["sieve18Value"];
                    break;
                case "170":
                    $value170 = $Object->vars["sieve18Value"];
                    break;
                case "200":
                    $value200 = $Object->vars["sieve18Value"];
                    break;  
                case "230":
                    $value230 = $Object->vars["sieve18Value"];
                    break;
                case "270":
                    $value270 = $Object->vars["sieve18Value"];
                    break;
                case "325":
                    $value325 = $Object->vars["sieve18Value"];
                    break;
                case "PAN":
                    $valuePAN = $Object->vars["sieve18Value"];
                    break;
                default:
                    //this Sieve Desc doesn't match a screen size option
              }

              //format the values as pecentages instead of doubles
              if($value30 != 0) { $value30 = ($value30 * 100) . "%"; } else { $value30 = ""; }
              if($value35 != 0) { $value35 = ($value35 * 100) . "%"; } else { $value35 = ""; }
              if($value40 != 0) { $value40 = ($value40 * 100) . "%"; } else { $value40 = ""; }
              if($value45 != 0) { $value45 = ($value45 * 100) . "%"; } else { $value45 = ""; }
              if($value50 != 0) { $value50 = ($value50 * 100) . "%"; } else { $value50 = ""; }
              if($value60 != 0) { $value60 = ($value60 * 100) . "%"; } else { $value60 = ""; }
              if($value70 != 0) { $value70 = ($value70 * 100) . "%"; } else { $value70 = ""; }
              if($value80 != 0) { $value80 = ($value80 * 100) . "%"; } else { $value80 = ""; }
              if($value100 != 0) { $value100 = ($value100 * 100) . "%"; } else { $value100 = ""; }
              if($value120 != 0) { $value120 = ($value120 * 100) . "%"; } else { $value120 = ""; }
              if($value140 != 0) { $value140 = ($value140 * 100) . "%"; } else { $value140 = ""; }
              if($value170 != 0) { $value170 = ($value170 * 100) . "%"; } else { $value170 = ""; }
              if($value200 != 0) { $value200 = ($value200 * 100) . "%"; } else { $value200 = ""; }
              if($value230 != 0) { $value230 = ($value230 * 100) . "%"; } else { $value230 = ""; }
              if($value270 != 0) { $value270 = ($value270 * 100) . "%"; } else { $value270 = ""; }
              if($value325 != 0) { $value325 = ($value325 * 100) . "%"; } else { $value325 = ""; }
              if($valuePAN != 0) { $valuePAN = ($valuePAN * 100) . "%"; } else { $valuePAN = ""; }

              //format the range values
              //save the object values to variables

              $plus40 = $Object->vars["plus40"];
              $neg40Plus70 = $Object->vars["neg40Plus70"];
              $neg60Plus70 = $Object->vars["neg60Plus70"];
              $neg70Plus140 = $Object->vars["neg70Plus140"];
              $neg50Plus140 = $Object->vars["neg50Plus140"];
              $nearSize = $Object->vars["nearSize"];
              $neg140Plus325 = $Object->vars["neg140Plus325"];
              $neg140 = $Object->vars["neg140"];
              //format the values as percentages instead of doubles
              if($plus40 != 0) { $plus40 = ($plus40 * 100) . "%"; } else { $plus40 = ""; }
              if($neg40Plus70 != 0) { $neg40Plus70 = ($neg40Plus70 * 100) . "%"; } else { $neg40Plus70 = ""; }
              if($neg60Plus70 != 0) { $neg60Plus70 = ($neg60Plus70 * 100) . "%"; } else { $neg60Plus70 = ""; }
              if($neg70Plus140 != 0) { $neg70Plus140 = ($neg70Plus140 * 100) . "%"; } else { $neg70Plus140 = ""; }
              if($neg50Plus140 != 0) { $neg50Plus140 = ($neg50Plus140 * 100) . "%"; } else { $neg50Plus140 = ""; }
              if($nearSize != 0) { $nearSize = ($nearSize * 100) . "%"; } else { $nearSize = ""; }
              if($neg140Plus325 != 0) { $neg140Plus325 = ($neg140Plus325 * 100) . "%"; } else { $neg140Plus325 = ""; }
              if($neg140 != 0) { $neg140 = ($neg140 * 100) . "%"; } else { $neg140 = ""; }

              $slimesPercent = $Object->vars["slimesPercent"];
              $oversizePercent = $Object->vars["oversizePercent"];
              if($slimesPercent != 0) { $slimesPercent = ($slimesPercent * 100) . "%"; } else { $slimesPercent = ""; } //$Object->vars["slimesPercent"]

              if($Object->vars["preWashDryWeight"] != 0) { $orePercent = round((($Object->vars["postWashDryWeight"] / $Object->vars["preWashDryWeight"]) * 100), 2) . "%"; } else { $orePercent = ""; }

              if($Object->vars["isCOA"] != NULL)
              {
                $isCOA = $Object->vars["isCOA"];
              }

              if($oversizePercent != 0) { $oversizePercent = ($oversizePercent * 100) . "%"; } else { $oversizePercent = ""; } //$Object->vars["oversizePercent"]

              //get the site name //summary field
              $siteName = "";
              if($Object->vars["siteId"] != NULL)
              {
                $siteObject = getSiteById($Object->vars["siteId"]);
                if($siteObject != NULL)
                {
                  $siteName = $siteObject->vars["description"];
                }
              }

              $drillholeNumber = $Object->vars["drillholeNo"];
              $depthFrom = $Object->vars["depthFrom"];
              $depthTo = $Object->vars["depthTo"];

              echo "<tr>" .
              "<td class='leftCol2' title='Sample ID'><a href='../../Controls/QC/gb_sampleview.php?sampleId=" . $Object->vars["id"] . "'>" . $Object->vars["id"] . "</a></td>" .
              "<td class='leftCol3' title='Date'>" . $Object->vars["date"] . "</td>" .
                  "<td class='leftCol4' title='Time'>" . $Object->vars["time"] . "</td>" .
                  "<td title='Location'>" . $locationName . "</td>";


              echo "<td title='Test Type'>" . $testTypeName . "</td>" . //summary field
              "<td title='Composite Type'>" . $compositeTypeName . "</td>" .  //summary field
              "<td title='Sieve Stack'>" . $sieveStackName . "</td>" .   //summary field
              "<td title='Plant'>" . $plantName . "</td>";  //summary field


              //"<td>" . $Object->vars["shift"] . "</td>" .  //summary field
              if(($Object->vars["time"] < "18:00:00") && ($Object->vars["time"] >= "06:00:00")) //summary field
              {
                echo "<td title='Shift'>Day</td>";
              }
              else
              {
                echo "<td title='Shift'>Night</td>";
              }

              echo "<td title='Sampler'>" . $samplerName . "</td>" .  //summary field
              "<td title='Lab Tech'>" . $labTechName . "</td>" .  //summary field
              "<td title='Operator'>" . $operatorName . "</td>";  //summary field

              echo "<td title='Notes'>" . $Object->vars["notes"] . "</td>" .  //summary field
              "<td title='Moisture Rate'>" . $moisture_rate . "</td>"; //summary field

              echo("<td title='Void Status'>" . $Object->vars["voidStatusCode"] . "</td>"); //summary field

              echo("<td title='Completion Status'>");
              if(checkIfSampleIsComplete($Object->vars["id"]) == 1)
              {
                echo("Complete");
              }
              else
              {
                echo("Incomplete");
              }
              echo("</td>"); //summary field

              echo "<td title='Site'>" . $siteName . "</td>";  //summary field

              if(isset($userPermissionsArray['vista']['granbury']['qc']))
              {
                if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has a QC permission then show them the edit link
                {
                  $i++; //increment the counter for dynamic fixed CSS placement
                  echo "<td>";//summary field
                  echo "<a href='../../Controls/QC/gb_sampleedit.php?sampleId=" . $Object->vars["id"] . "'>Edit</a>";
                  echo "</td>";
                }
                else {
                    $i++; //increment the counter for dynamic fixed CSS placement
                    echo "<td>";//summary field
                    echo "";
                    echo "</td>";
                }
              }

              if(isset($userPermissionsArray['vista']['granbury']['qc']))
              {
                if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has a QC permission then show them the repeat link
                {
                  $i++; //increment the counter for dynamic fixed CSS placement
                  echo "<td>";//summary field
                  echo "<a href='../../Includes/QC/gb_samplerepeat.php?sampleId=" . $Object->vars["id"] . "&userId=" . $user_id . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "'>Repeat</a>";
                  echo "</td>";
                }
                else {
                    $i++; //increment the counter for dynamic fixed CSS placement
                    echo "<td>";//summary field
                    echo "";
                    echo "</td>";
                }
              }

              if(isset($userPermissionsArray['vista']['granbury']['qc']))
              {
                if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has a QC permission then show them the void link
                {
                    echo "<input type='hidden' id='permission-check' value='0'>";
                  $i++; //increment the counter for dynamic fixed CSS placement
                  echo "<td>";//summary field
                  if($Object->vars["voidStatusCode"] == "A")
                  {
                    echo "<a href='../../Includes/QC/gb_samplevoid.php?sampleId=" . $Object->vars["id"] . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "' onclick=\"return confirm('Are you sure?')\">Void</a>";
                  }
                  else
                  {
                    //if the user has permission to unvoid samples, then show them the unvoid link
                    if(isset($userPermissionsArray['vista']['granbury']['qc']))
                    {
                      if($userPermissionsArray['vista']['granbury']['qc'] >= 3)
                      {
                        echo "<a href='../../Includes/QC/gb_samplereversevoid.php?sampleId=" . $Object->vars["id"] . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "' onclick=\"return confirm('Are you sure?')\">UnVoid</a>";
                      }
                    }
                    else
                    {
                      echo "";
                    }
                  }
                  echo "</td>";
                }
                else {
                    echo "<input type='hidden' id='permission-check' value='1'>";
                    $i++; //increment the counter for dynamic fixed CSS placement
                    echo "<td>";//summary field
                    echo "";
                    echo "</td>";
                }
              }

              echo "</tr>";

              /***************************************************************************************/
              //add data to the download array

              $downloadArray[$downloadArrayCount] = NULL;
              $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . $Object->vars["id"];
              $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . "," . $Object->vars["date"];
              $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] .
              "," . $Object->vars["time"] .
              "," . $Object->vars["groupTime"] .
              "," . $testTypeName .
              "," . $compositeTypeName .
              "," . $sieveStackName .
              "," . $plantName .
              "," . $locationName .
              "," . $specificLocationName;

              //add shift
              if(($Object->vars["time"] < "18:00:00") && ($Object->vars["time"] >= "06:00:00")) //summary field
              {
                $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] .  ",Day";
              }
              else
              {
                $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . ",Night";
              }

              $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . "," . $samplerName .
              "," . $labTechName  .  //summary field
              "," . $operatorName  .  //summary field

              "," . $plus40  .
              "," . $neg40Plus70  .
              "," . $neg60Plus70  .
              "," . $neg70Plus140  .
              "," . $neg50Plus140  .
              "," . $nearSize  .
              "," . $neg140Plus325  .
              "," . $neg140  .

              "," . $Object->vars["beginningWetWeight"]  .
              "," . $Object->vars["preWashDryWeight"]  .
              "," . $Object->vars["postWashDryWeight"]  .

              "," . $Object->vars["splitSampleWeight"]  .
              "," . $Object->vars["turbidity"]  .
              "," . $Object->vars["tonsRepresented"]  .
              "," . $Object->vars["tphRepresented"]  .
              "," . $Object->vars["notes"]  .  //summary field
              "," . $moisture_rate  . //summary field
              "," . $Object->vars["recoveryPlusOneForty"]  .
              "," . $Object->vars["groupStartDateTime"]  .
              "," . $Object->vars["finishDateTime"]  .
              "," . $Object->vars["duration"]  .
              "," . $Object->vars["durationMinutes"]  .

              "," . $totalFinalWeight .  //summary field

              "," . $Object->vars["oversizeWeight"]  .
              "," . $Object->vars["oversizePercent"]  .
              ","  . $Object->vars["slimesPercent"]  .
              "," . $orePercent .
              "," . $isCOA .
              "," . $Object->vars["description"]  .
              "," . $value30 .
              "," . $value35 .
              "," . $value40 .
              "," . $value45 .
              "," . $value50 .
              "," . $value60 .
              "," . $value70 .
              "," . $value80 .
              "," . $value100 .
              "," . $value120 .
              "," . $value140 .
              "," . $value170 .
              "," . $value200 .
              "," . $value230 .
              "," . $value270 .
              "," . $value325 .
              "," . $valuePAN .
              "," . $siteName .
              "," . $drillholeNumber .
              "," . $depthFrom .
              "," . $depthTo;

              //dynamically add the PLC columns based on the values in the database
              for($i = 0; $i < count($PLCArray); $i++)
              {
                $PLCDataObject = NULL;
                $PLCDataObject = getPlantSettingsDataByTagAndSampleId($PLCArray[$i]->vars['id'], $Object->vars["id"]);
                if($PLCDataObject == NULL)
                {
                  $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . ","; //add an empty cell
                }
                else
                {
                  $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . "," . $PLCDataObject->vars['value'];
                }
              }

              /***************************************************************************************/

              $l++;
              $downloadArrayCount++;
            }

          echo("</tbody>");
          echo("</table>");

    }
  }
  else
  {
    //Display the table in Verbose format

        echo("<table id='samplesTable' name='samplesTable' class='table table-striped table-bordered nowrap'>");

          //get a list of PLC Tags to display as columns
          $PLCArray = getPLCTags();
          echo("<thead>");
          echo "<tr>" .
              "<th class='leftHead2 headContent'>Sample ID</th>" .
              "<th class='leftHead3 headContent'>Date</th>" .
              "<th class='leftHead4 headContent'>Time</th>" .
              "<th class='col5 headContent headContentNotLeft'>Location</th>";
          //echo "<th class='col0 headContent headContentNotLeft'>Group Time</th>";

          echo "<th class='col1 headContent headContentNotLeft'>Test Type</th>" . //summary field
          "<th class='col2 headContent headContentNotLeft'>Composite Type</th>" . //summary field
          "<th class='col3 headContent headContentNotLeft'>Sieve Stack</th>" . //summary field
          "<th class='col4 headContent headContentNotLeft'>Plant</th>"; //summary field


          echo "<th class='col6 headContent headContentNotLeft'>Specific Location ID</th>";

          echo "<th class='col7 headContent headContentNotLeft'>Shift</th>" . //summary field
          "<th class='col8 headContent headContentNotLeft'>Sampler</th>" . //summary field
          "<th class='col9 headContent headContentNotLeft'>Lab Tech</th>" . //summary field
          "<th class='col10 headContent headContentNotLeft'>Operator</th>"; //summary field

          echo "<th class='verbose col11 headContent headContentNotLeft excel-text'>+10(OS)</th>" .
              "<th class='verbose col11 headContent headContentNotLeft excel-text'>-10+40</th>" .
          "<th class='verbose col12 headContent headContentNotLeft excel-text'>-40+70</th>" .
          "<th class='verbose col12 headContent headContentNotLeft excel-text'>-60+70</th>" .
          "<th class='verbose col12 headContent headContentNotLeft excel-text'>-70+140</th>" .
          "<th class='verbose col13 headContent headContentNotLeft excel-text'>-50+140</th>" .
          "<th class='verbose col14 headContent headContentNotLeft'>Near Size</th>" .
          "<th class='verbose col15 headContent headContentNotLeft excel-text'>-140+325</th>" .
          "<th class='verbose coll6 headContent headContentNotLeft'>-140</th>";

          echo "<th class='verbose col17 headContent headContentNotLeft'>Beginning Wet Weight</th>" .
          "<th class='verbose col18 headContent headContentNotLeft'>Pre Wash Dry Weight</th>" .
          "<th class='verbose col19 headContent headContentNotLeft'>Post Wash Dry Weight</th>" .

          "<th class='verbose col20 headContent headContentNotLeft'>Split Sample Weight</th>" .
          "<th class='verbose col21 headContent headContentNotLeft'>Turbidity</th>" .
          "<th class='verbose col22 headContent headContentNotLeft'>Tons Represented</th>" .
          "<th class='verbose col23 headContent headContentNotLeft'>TPH Represented</th>";

          echo "<th class='col24 headContent headContentNotLeft'>Notes</th>" . //summary field
          "<th class='col25 headContent headContentNotLeft'>Moisture Rate</th>"; //summary field

          echo "<th class='verbose col26 headContent headContentNotLeft'>Recovery +140</th>" .
          "<th class='verbose col27 headContent headContentNotLeft'>Group Start Datetime</th>" .
          "<th class='verbose col28 headContent headContentNotLeft'>Finish Datetime</th>" .
          "<th class='verbose col29 headContent headContentNotLeft'>Duration Minutes</th>" .
          "<th class='verbose col30 headContent headContentNotLeft'>Duration</th>" .

          "<th class='verbose col31 headContent headContentNotLeft'>Total Weight</th>";

          echo("<th class='col32 headContent headContentNotLeft'>Void Status</th>"); //summary field
          echo("<th class='col33 headContent headContentNotLeft'>Completion Status</th>"); //summary field

          echo "<th class='col34 headContent headContentNotLeft'>Site</th>"; //summary field

          echo "<th class='verbose col35 headContent headContentNotLeft'>Drillhole Number</th>" .
          "<th class='verbose col36 headContent headContentNotLeft'>Depth From</th>" .
          "<th class='verbose col37 headContent headContentNotLeft'>Depth To</th>";

          echo "<th class='verbose col38 headContent headContentNotLeft'>Oversize Weight</th>";
          echo "<th class='verbose col39 headContent headContentNotLeft'>Oversize Percent</th>";
          echo "<th class='verbose col40 headContent headContentNotLeft'>Slimes Percent/Amt Lost in Wash</th>";
          echo "<th class='verbose col41 headContent headContentNotLeft'>Ore Percent</th>";
          echo "<th class='verbose col42 headContent headContentNotLeft'>Is COA</th>";
          echo "<th class='verbose col43 headContent headContentNotLeft'>Description</th>";

          echo "<th class='verbose col44 headContent headContentNotLeft'>Near Size</th>" .

          "<th class='verbose col45 headContent headContentNotLeft'>30</th>" .
          "<th class='verbose col46 headContent headContentNotLeft'>35</th>" .
          "<th class='verbose col47 headContent headContentNotLeft'>40</th>" .
          "<th class='verbose col48 headContent headContentNotLeft'>45</th>" .
          "<th class='verbose col49 headContent headContentNotLeft'>50</th>" .
          "<th class='verbose col50 headContent headContentNotLeft'>60</th>" .
          "<th class='verbose col51 headContent headContentNotLeft'>70</th>" .
          "<th class='verbose col52 headContent headContentNotLeft'>80</th>" .
          "<th class='verbose col53 headContent headContentNotLeft'>100</th>" .
          "<th class='verbose col54 headContent headContentNotLeft'>120</th>" .
          "<th class='verbose col55 headContent headContentNotLeft'>140</th>" .
          "<th class='verbose col56 headContent headContentNotLeft'>170</th>" .
          "<th class='verbose col57 headContent headContentNotLeft'>200</th>" .
          "<th class='verbose col58 headContent headContentNotLeft'>230</th>" .
          "<th class='verbose col59 headContent headContentNotLeft'>270</th>" .
          "<th class='verbose col60 headContent headContentNotLeft'>325</th>" .
          "<th class='verbose col61 headContent headContentNotLeft'>PAN</th>";

          //dynamically output the PLC columns based on the values in the database
          for($i = 0; $i < count($PLCArray); $i++)
          {
            //Note: the style left is set dynamically in PHP, because we don't know how many PLC columns there will be
            echo("<th class='verbose headContent headContentNotLeft'>" . $PLCArray[$i]->vars['device'] . "</th>");
          }

          if(isset($userPermissionsArray['vista']['granbury']['qc']))
          {
            if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has QC permission then show them the hyperlinks
            {
              echo "<th class='headContent headContentNotLeft'></th>"; //edit

              echo "<th class='headContent headContentNotLeft'></th>"; //repeat

              echo "<th class='headContent headContentNotLeft'></th>"; //void
            }
            else
            {
                echo"<th></th>";
                echo"<th></th>";
                echo"<th></th>";
            }
          }

          echo("</tr>");
          echo("</thead>");
          echo("<tbody>");

          /************************************************************************************/
          //create the header row for download
          $downloadArray[0] = "ID,Date,Time,Group Time,Test Type,Composite Type,Sieve Stack,Plant,Location,Specific Location ID,Shift,Sampler,Lab Tech,Operator,Plus Seventy (+70),Minus Seventy (-70),Minus Seventy Plus One Forty (-70 +140),Minus One Forty (-140),Minus Forty Plus Seventy (-40 +70),Beginning Wet Weight,Pre Wash Dry Weight,Post Wash Dry Weight,Split Sample Weight,Turbidity,Tons Represented,TPH Represented,Notes,Moisture Rate,Recovery +140,Group Start Datetime,Finish Datetime,Duration Minutes,Duration,Total Weight,Void Status,Drillhole Number,Depth From,Depth To,Completion Status,Site,Oversize Weight,Oversize Percent,Slimes Percent/Amt Lost in Wash,Ore Percent,Is COA,Description,Near Size,30,35,40,45,50,60,70,80,100,120,140,170,200,230,270,325,PAN";

          //dynamically output the PLC columns based on the values in the database
          for($i = 0; $i < count($PLCArray); $i++)
          {
            $downloadArray[0] = $downloadArray[0] . "," . $PLCArray[$i]->vars['device'];
          }
          /************************************************************************************/

          $l = 0;

          foreach ($ObjectArray as $Object)
          {
            $samplerName = NULL;
            $labTechName = NULL;
            $operatorName = NULL;

            //get the test type name //summary field
            $testTypeName = "";
            if($Object->vars["testType"] != NULL)
            {
              $testTypeObject = getTestTypeById($Object->vars["testType"]);
              if($testTypeObject != NULL)
              {
                $testTypeName = $testTypeObject->vars["description"];
              }
            }

            //get the composite type name //summary field
            $compositeTypeName = "";
            if($Object->vars["compositeType"] != NULL)
            {
              $compositeTypeObject = getCompositeTypeById($Object->vars["compositeType"]);
              if($compositeTypeObject != NULL)
              {
                $compositeTypeName = $compositeTypeObject->vars["description"];
              }
            }

            //get the sieve stack name //summary field
            $sieveStackName = "";
            if(($Object->vars["sieveMethod"] != NULL) && ($Object->vars["sieveMethod"] != "0"))
            {
              $sieveStackObject = getSieveStackById($Object->vars["sieveMethod"]);
              if($sieveStackObject != NULL)
              {
                $sieveStackName = $sieveStackObject->vars["description"];
              }
            }

            //get the plant name //summary field
            $plantName = "";
            if($Object->vars["plantId"] != NULL)
            {
              $plantObject = getPlantById($Object->vars["plantId"]);
              if($plantObject != NULL)
              {
                $plantName = $plantObject->vars["description"];
              }
            }

            //get the location name //summary field
            $locationName = "";
            if($Object->vars["location"] != NULL)
            {
              $locationObject = getLocationById($Object->vars["location"]);
              if($locationObject != NULL)
              {
                $locationName = $locationObject->vars["description"];
              }
            }

            //get the lab tech name //summary field
            $labTechName = "";
            if($Object->vars["labTech"] != NULL)
            {
              $labTechObject = getUser($Object->vars["labTech"]);
              if($labTechObject != NULL)
              {
                $labTechName = $labTechObject->vars["display_name"];
              }
            }

            //get the sampler name //summary field
            $samplerName = "";
            if($Object->vars["sampler"] != NULL)
            {
              $samplerObject = getUser($Object->vars["sampler"]);
              if($samplerObject != NULL)
              {
                $samplerName = $samplerObject->vars["display_name"];
              }
            }

            //get the operator name //summary field
            $operatorName = "";
            if($Object->vars["operator"] != NULL)
            {
              $operatorObject = getUser($Object->vars["operator"]);
              if($operatorObject != NULL)
              {
                $operatorName = $operatorObject->vars["display_name"];
              }
            }

            //get the total weight //summary field
            $totalFinalWeight = "";
            if($Object->vars["sieves_raw"] != NULL)
            {
              $sievesRaw = $Object->vars["sieves_raw"];
              $finalWeightArray = decodeWeights($sievesRaw);
              $totalFinalWeight = array_sum($finalWeightArray);
            }

            //get the moisture rate //summary field
            if($Object->vars["moisture_rate"] != NULL)
            {
              $moisture_rate = $Object->vars["moisture_rate"];
              $moisture_rate = ($moisture_rate * 100) . "%";
            }
            else
            {
              $moisture_rate = "";
            }

            //get the name of the Specific Location
            if(isset($Object->vars["specificLocation"]))
            {
              if($Object->vars["specificLocation"] != NULL)
              {
                $specificLocationObject = getSpecificLocationByID($Object->vars["specificLocation"]);
                if(isset($specificLocationObject->vars["description"]))
                {
                  $specificLocationName = $specificLocationObject->vars["description"];
                }
                else
                {
                  $specificLocationName = "";
                }
              }
              else
              {
                $specificLocationName = "";
              }
            }

            //get the screen sizes
            //reset the values
            $value30 = "";
            $value35 = "";
            $value40 = "";
            $value45 = "";
            $value50 = "";
            $value60 = "";
            $value70 = "";
            $value80 = "";
            $value100 = "";
            $value120 = "";
            $value140 = "";
            $value170 = "";
            $value200 = "";
            $value230 = "";
            $value270 = "";
            $value325 = "";
            $valuePAN = "";
            //match the values from the database against the appropraite variable
            //sieve1
            switch ($Object->vars["sieve1Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve1Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve1Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve1Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve1Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve1Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve1Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve1Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve1Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve1Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve1Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve1Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve1Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve1Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve1Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve1Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve1Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve1Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve2
            switch ($Object->vars["sieve2Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve2Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve2Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve2Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve2Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve2Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve2Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve2Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve2Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve2Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve2Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve2Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve2Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve2Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve2Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve2Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve2Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve2Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve3
            switch ($Object->vars["sieve3Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve3Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve3Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve3Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve3Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve3Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve3Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve3Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve3Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve3Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve3Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve3Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve3Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve3Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve3Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve3Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve3Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve3Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve4
            switch ($Object->vars["sieve4Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve4Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve4Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve4Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve4Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve4Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve4Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve4Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve4Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve4Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve4Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve4Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve4Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve4Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve4Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve4Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve4Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve4Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve5
            switch ($Object->vars["sieve5Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve5Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve5Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve5Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve5Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve5Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve5Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve5Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve5Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve5Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve5Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve5Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve5Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve5Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve5Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve5Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve5Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve5Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve6
            switch ($Object->vars["sieve6Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve6Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve6Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve6Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve6Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve6Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve6Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve6Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve6Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve6Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve6Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve6Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve6Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve6Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve6Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve6Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve6Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve6Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve7
            switch ($Object->vars["sieve7Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve7Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve7Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve7Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve7Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve7Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve7Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve7Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve7Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve7Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve7Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve7Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve7Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve7Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve7Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve7Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve7Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve7Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve8
            switch ($Object->vars["sieve8Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve8Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve8Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve8Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve8Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve8Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve8Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve8Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve8Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve8Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve8Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve8Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve8Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve8Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve8Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve8Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve8Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve8Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve9
            switch ($Object->vars["sieve9Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve9Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve9Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve9Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve9Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve9Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve9Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve9Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve9Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve9Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve9Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve9Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve9Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve9Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve9Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve9Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve9Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve9Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }
            //sieve10
            switch ($Object->vars["sieve10Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve10Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve10Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve10Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve10Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve10Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve10Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve10Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve10Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve10Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve10Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve10Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve10Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve10Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve10Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve10Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve10Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve10Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve11
            switch ($Object->vars["sieve11Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve11Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve11Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve11Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve11Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve11Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve11Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve11Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve11Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve11Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve11Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve11Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve11Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve11Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve11Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve11Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve11Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve11Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve12
            switch ($Object->vars["sieve12Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve12Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve12Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve12Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve12Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve12Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve12Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve12Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve12Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve12Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve12Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve12Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve12Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve12Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve12Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve12Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve12Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve12Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve13
            switch ($Object->vars["sieve13Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve13Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve13Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve13Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve13Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve13Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve13Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve13Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve13Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve13Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve13Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve13Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve13Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve13Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve13Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve13Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve13Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve13Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve14
            switch ($Object->vars["sieve14Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve14Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve14Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve14Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve14Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve14Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve14Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve14Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve14Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve14Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve14Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve14Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve14Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve14Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve14Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve14Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve14Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve14Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve15
            switch ($Object->vars["sieve15Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve15Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve15Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve15Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve15Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve15Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve15Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve15Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve15Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve15Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve15Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve15Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve15Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve15Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve15Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve15Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve15Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve15Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve16
            switch ($Object->vars["sieve16Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve16Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve16Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve16Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve16Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve16Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve16Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve16Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve16Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve16Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve16Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve16Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve16Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve16Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve16Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve16Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve16Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve16Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve17
            switch ($Object->vars["sieve17Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve17Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve17Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve17Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve17Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve17Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve17Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve17Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve17Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve17Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve17Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve17Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve17Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve17Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve17Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve17Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve17Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve17Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //sieve18
            switch ($Object->vars["sieve18Desc"])
            {
              case "30":
                  $value30 = $Object->vars["sieve18Value"];
                  break;
              case "35":
                  $value35 = $Object->vars["sieve18Value"];
                  break;
              case "40":
                  $value40 = $Object->vars["sieve18Value"];
                  break;
              case "45":
                  $value45 = $Object->vars["sieve18Value"];
                  break;
              case "50":
                  $value50 = $Object->vars["sieve18Value"];
                  break;
              case "60":
                  $value60 = $Object->vars["sieve18Value"];
                  break;
              case "70":
                  $value70 = $Object->vars["sieve18Value"];
                  break;
              case "80":
                  $value80 = $Object->vars["sieve18Value"];
                  break;
              case "100":
                  $value100 = $Object->vars["sieve18Value"];
                  break;
              case "120":
                  $value120 = $Object->vars["sieve18Value"];
                  break;
              case "140":
                  $value140 = $Object->vars["sieve18Value"];
                  break;
              case "170":
                  $value170 = $Object->vars["sieve18Value"];
                  break;
              case "200":
                  $value200 = $Object->vars["sieve18Value"];
                  break;
              case "230":
                  $value230 = $Object->vars["sieve18Value"];
                  break;
              case "270":
                  $value270 = $Object->vars["sieve18Value"];
                  break;
              case "325":
                  $value325 = $Object->vars["sieve18Value"];
                  break;
              case "PAN":
                  $valuePAN = $Object->vars["sieve18Value"];
                  break;
              default:
                  //this Sieve Desc doesn't match a screen size option
            }

            //format the values as pecentages instead of doubles
            if($value30 != 0) { $value30 = ($value30 * 100) . "%"; } else { $value30 = ""; }
            if($value35 != 0) { $value35 = ($value35 * 100) . "%"; } else { $value35 = ""; }
            if($value40 != 0) { $value40 = ($value40 * 100) . "%"; } else { $value40 = ""; }
            if($value45 != 0) { $value45 = ($value45 * 100) . "%"; } else { $value45 = ""; }
            if($value50 != 0) { $value50 = ($value50 * 100) . "%"; } else { $value50 = ""; }
            if($value60 != 0) { $value60 = ($value60 * 100) . "%"; } else { $value60 = ""; }
            if($value70 != 0) { $value70 = ($value70 * 100) . "%"; } else { $value70 = ""; }
            if($value80 != 0) { $value80 = ($value80 * 100) . "%"; } else { $value80 = ""; }
            if($value100 != 0) { $value100 = ($value100 * 100) . "%"; } else { $value100 = ""; }
            if($value120 != 0) { $value120 = ($value120 * 100) . "%"; } else { $value120 = ""; }
            if($value140 != 0) { $value140 = ($value140 * 100) . "%"; } else { $value140 = ""; }
            if($value170 != 0) { $value170 = ($value170 * 100) . "%"; } else { $value170 = ""; }
            if($value200 != 0) { $value200 = ($value200 * 100) . "%"; } else { $value200 = ""; }
            if($value230 != 0) { $value230 = ($value230 * 100) . "%"; } else { $value230 = ""; }
            if($value270 != 0) { $value270 = ($value270 * 100) . "%"; } else { $value270 = ""; }
            if($value325 != 0) { $value325 = ($value325 * 100) . "%"; } else { $value325 = ""; }
            if($valuePAN != 0) { $valuePAN = ($valuePAN * 100) . "%"; } else { $valuePAN = ""; }

            //format the range values
            //save the object values to variables
              $plus40 = $Object->vars["plus40"];
              $neg40Plus70 = $Object->vars["neg40Plus70"];
              $neg60Plus70 = $Object->vars["neg60Plus70"];
              $neg70Plus140 = $Object->vars["neg70Plus140"];
              $neg50Plus140 = $Object->vars["neg50Plus140"];
              $nearSize = $Object->vars["nearSize"];
              $neg140Plus325 = $Object->vars["neg140Plus325"];
              $neg140 = $Object->vars["neg140"];
              //format the values as percentages instead of doubles
              if($plus40 != 0) { $plus40 = ($plus40 * 100) . "%"; } else { $plus40 = ""; }
              if($neg40Plus70 != 0) { $neg40Plus70 = ($neg40Plus70 * 100) . "%"; } else { $neg40Plus70 = ""; }
              if($neg60Plus70 != 0) { $neg60Plus70 = ($neg60Plus70 * 100) . "%"; } else { $neg60Plus70 = ""; }
              if($neg70Plus140 != 0) { $neg70Plus140 = ($neg70Plus140 * 100) . "%"; } else { $neg70Plus140 = ""; }
              if($neg50Plus140 != 0) { $neg50Plus140 = ($neg50Plus140 * 100) . "%"; } else { $neg50Plus140 = ""; }
              if($nearSize != 0) { $nearSize = ($nearSize * 100) . "%"; } else { $nearSize = ""; }
              if($neg140Plus325 != 0) { $neg140Plus325 = ($neg140Plus325 * 100) . "%"; } else { $neg140Plus325 = ""; }
              if($neg140 != 0) { $neg140 = ($neg140 * 100) . "%"; } else { $neg140 = ""; }

            $slimesPercent = $Object->vars["slimesPercent"];
            $oversizePercent = $Object->vars["oversizePercent"];
            if($slimesPercent != 0) { $slimesPercent = ($slimesPercent * 100) . "%"; } else { $slimesPercent = ""; } //$Object->vars["slimesPercent"]

            if($Object->vars["preWashDryWeight"] != 0) { $orePercent = round((($Object->vars["postWashDryWeight"] / $Object->vars["preWashDryWeight"]) * 100), 2) . "%"; } else { $orePercent = ""; }

            if($Object->vars["isCOA"] != NULL)
            {
              $isCOA = $Object->vars["isCOA"];
            }

            if($oversizePercent != 0) { $oversizePercent = ($oversizePercent * 100) . "%"; } else { $oversizePercent = ""; } //$Object->vars["oversizePercent"]

            //get the site name //summary field
            $siteName = "";
            if($Object->vars["siteId"] != NULL)
            {
              $siteObject = getSiteById($Object->vars["siteId"]);
              if($siteObject != NULL)
              {
                $siteName = $siteObject->vars["description"];
              }
            }

            $drillholeNumber = $Object->vars["drillholeNo"];
            $depthFrom = $Object->vars["depthFrom"];
            $depthTo = $Object->vars["depthTo"];

            echo "<tr>" .
                "<td class='leftCol2' title='Sample ID'><a href='../../Controls/QC/gb_sampleview.php?sampleId=" . $Object->vars["id"] . "'>" . $Object->vars["id"] . "</a></td>" .
                "<td class='leftCol3' title='Date'>" . $Object->vars["date"] . "</td>" .
                "<td class='leftCol4' title='Time'>" . $Object->vars["time"] . "</td>" .
                "<td title='Location'>" . $locationName . "</td>";


            echo "<td title='Test Type'>" . $testTypeName . "</td>" . //summary field
            "<td title='Composite Type'>" . $compositeTypeName . "</td>" .  //summary field
            "<td title='Sieve Stack'>" . $sieveStackName . "</td>" .   //summary field
            "<td title='Plant'>" . $plantName . "</td>";  //summary field


            echo "<td class='verbose' title='Specific Location'>" . $specificLocationName . "</td>";

            //"<td>" . $Object->vars["shift"] . "</td>" .  //summary field
            if(($Object->vars["time"] < "18:00:00") && ($Object->vars["time"] >= "06:00:00")) //summary field
            {
              echo "<td title='Shift'>Day</td>";
            }
            else
            {
              echo "<td title='Shift'>Night</td>";
            }

            echo "<td title='Sampler'>" . $samplerName . "</td>" .  //summary field
            "<td title='Lab Tech'>" . $labTechName . "</td>" .  //summary field
            "<td title='Operator'>" . $operatorName . "</td>";  //summary field

            echo "<td class='verbose' title='+10(OS)'>" . $oversizePercent . "</td>" .
                "<td class='verbose' title='-10+40'>" . $plus40 . "</td>" .
            "<td class='verbose' title='-40+70'>" . $neg40Plus70 . "</td>" .
            "<td class='verbose' title='-60+70'>" . $neg60Plus70 . "</td>" .

            "<td class='verbose' title='-70+140'>" . $neg70Plus140 . "</td>" .
            "<td class='verbose' title='-50+140'>" . $neg50Plus140 . "</td>" .
            "<td class='verbose' title='Near Size'>" . $nearSize . "</td>" .
            "<td class='verbose' title='-140+325'>" . $neg140Plus325 . "</td>" .
            "<td class='verbose' title='-140'>" . $neg140 . "</td>"        ;

            echo "<td class='verbose' title='Beginning Wet Weight'>" . $Object->vars["beginningWetWeight"] . "</td>" .
            "<td class='verbose' title='Pre Wash Dry Weight'>" . $Object->vars["preWashDryWeight"] . "</td>" .
            "<td class='verbose' title='Post Wash Dry Weight'>" . $Object->vars["postWashDryWeight"] . "</td>" .

            "<td class='verbose' title='Split Sample Weight'>" . $Object->vars["splitSampleWeight"] . "</td>" .
            "<td class='verbose' title='Turbidity'>" . $Object->vars["turbidity"] . "</td>" .
            "<td class='verbose' title='Tons Represented'>" . $Object->vars["tonsRepresented"] . "</td>" .
            "<td class='verbose' title='TPH Represented'>" . $Object->vars["tphRepresented"] . "</td>";

            echo "<td title='Notes'>" . $Object->vars["notes"] . "</td>" .  //summary field
            "<td title='Moisture Rate'>" . $moisture_rate . "</td>"; //summary field

            echo "<td class='verbose' title='Recovery +140'>" . $Object->vars["recoveryPlusOneForty"] . "</td>" .
            "<td class='verbose' title='Group Start Datetime'>" . $Object->vars["groupStartDateTime"] . "</td>" .
            "<td class='verbose' title='Finish Datetime'>" . $Object->vars["finishDateTime"] . "</td>" .
            "<td class='verbose' title='Duration Minutes'>" . $Object->vars["durationMinutes"] . "</td>" .
            "<td class='verbose' title='Duration'>" . $Object->vars["duration"] . "</td>" .
            "<td class='verbose' title='Total Weight'>" . $totalFinalWeight . "</td>";

            echo("<td title='Void Status'>" . $Object->vars["voidStatusCode"] . "</td>"); //summary field

            echo("<td title='Completion Status'>");
            if(checkIfSampleIsComplete($Object->vars["id"]) == 1)
            {
              echo("Complete");
            }
            else
            {
              echo("Incomplete");
            }
            echo("</td>"); //summary field

            echo "<td title='Site'>" . $siteName . "</td>";  //summary field

            //dynamically output the PLC columns based on the values in the database
            echo "<td class='verbose' title='Drillhole Number'>" . $drillholeNumber . "</td>";
            echo "<td class='verbose' title='Depth From'>" . $depthFrom . "</td>";
            echo "<td class='verbose' title='Depth To'>" . $depthTo . "</td>";

            echo("<td class='verbose' title='Oversize Weight'>" . $Object->vars["oversizeWeight"] . "</td>");
            echo("<td class='verbose' title='Oversize Percent'>" . $oversizePercent . "</td>");
            echo("<td class='verbose' title='Oversize Slimes Percent/Amt Lost in Wash'>" . $slimesPercent . "</td>");
            echo("<td class='verbose' title='Ore Percent'>" . $orePercent . "</td>");
            echo("<td class='verbose' title='Is COA'>" . $isCOA . "</td>");
            echo("<td class='verbose' title='Description'>" . $Object->vars["description"] . "</td>");

            echo "<td class='verbose' title='Near Size'>" . $nearSize . "</td>";

            //DEV NOTE: update to insert contents
            echo "<td class='verbose' title='30'>$value30</td>" .
            "<td class='verbose' title='35'>$value35</td>" .
            "<td class='verbose' title='40'>$value40</td>" .
            "<td class='verbose' title='45'>$value45</td>" .
            "<td class='verbose' title='50'>$value50</td>" .
            "<td class='verbose' title='60'>$value60</td>" .
            "<td class='verbose' title='70'>$value70</td>" .
            "<td class='verbose' title='80'>$value80</td>" .
            "<td class='verbose' title='100'>$value100</td>" .
            "<td class='verbose' title='120'>$value120</td>" .
            "<td class='verbose' title='140'>$value140</td>" .
            "<td class='verbose' title='170'>$value170</td>" .
            "<td class='verbose' title='200'>$value200</td>" .
            "<td class='verbose' title='230'>$value230</td>" .
            "<td class='verbose' title='270'>$value270</td>" .
            "<td class='verbose' title='325'>$value325</td>" .
            "<td class='verbose' title='PAN'>$valuePAN</td>";

            for($i = 0; $i < count($PLCArray); $i++)
            {
              $PLCDataObject = NULL;
              $PLCDataObject = getPlantSettingsDataByTagAndSampleId($PLCArray[$i]->vars['id'], $Object->vars["id"]);
              if($PLCDataObject == NULL)
              {
                echo("<td class='verbose' title=''></td>"); //output an empty cell
              }
              else
              {
                echo("<td class='verbose' title='" . $PLCDataObject->vars['device'] . "'>" . $PLCDataObject->vars['value'] . "</td>"); //output a cell containing the value
              }
            }

            if(isset($userPermissionsArray['vista']['granbury']['qc']))
            {
              if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has a QC permission then show them the edit link
              {
                  echo "<input type='hidden' id='permission-check' value='0'>";
                $i++; //increment the counter for dynamic fixed CSS placement
                echo "<td>";//summary field
                echo "<a href='../../Controls/QC/gb_sampleedit.php?sampleId=" . $Object->vars["id"] . "'>Edit</a>";
                echo "</td>";
              }              else {
                  $i++; //increment the counter for dynamic fixed CSS placement
                  echo "<td>";
                  echo "";
                  echo "</td>";
              }
            }

            if(isset($userPermissionsArray['vista']['granbury']['qc']))
            {
              if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has a QC permission then show them the repeat link
              {
                $i++; //increment the counter for dynamic fixed CSS placement
                echo "<td>";//summary field
                echo "<a href='../../Includes/QC/gb_samplerepeat.php?sampleId=" . $Object->vars["id"] . "&userId=" . $user_id . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "'>Repeat</a>";
                echo "</td>";
              }
              else {
                  $i++; //increment the counter for dynamic fixed CSS placement
                  echo "<td>";
                  echo "";
                  echo "</td>";
              }
            }

            if(isset($userPermissionsArray['vista']['granbury']['qc']))
            {
              if($userPermissionsArray['vista']['granbury']['qc'] > 0) //if the user has a QC permission then show them the void link
              {
                $i++; //increment the counter for dynamic fixed CSS placement

                echo "<td>";//summary field
                if($Object->vars["voidStatusCode"] == "A")
                {
                  echo "<a href='../../Includes/QC/gb_samplevoid.php?sampleId=" . $Object->vars["id"] . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "' onclick=\"return confirm('Are you sure?')\">Void</a>";
                }
                else
                {
                  //if the user has permission to unvoid samples, then show them the unvoid link
                  if(isset($userPermissionsArray['vista']['granbury']['qc']))
                  {
                    if($userPermissionsArray['vista']['granbury']['qc'] >= 3)
                    {
                      echo "<a href='../../Includes/QC/gb_samplereversevoid.php?sampleId=" . $Object->vars["id"] . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "' onclick=\"return confirm('Are you sure?')\">UnVoid</a>";
                    }
                  }
                  else
                  {
                    echo "";
                  }
                }
                echo "</td>";
              }               else {
echo "<input type='hidden' id='permission-check' value='1'>";
                  $i++; //increment the counter for dynamic fixed CSS placement
                  echo "<td>";
                  echo "";
                  echo "</td>";
              }
            }

            echo "</tr>";

            /***************************************************************************************/
            //add data to the download array

            $downloadArray[$downloadArrayCount] = NULL;
            $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . $Object->vars["id"];
            $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . "," . $Object->vars["date"];
            $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] .
            "," . $Object->vars["time"] .
            "," . $Object->vars["groupTime"] .
            "," . $testTypeName .
            "," . $compositeTypeName .
            "," . $sieveStackName .
            "," . $plantName .
            "," . $locationName .
            "," . $specificLocationName;

            //add shift
            if(($Object->vars["time"] < "18:00:00") && ($Object->vars["time"] >= "06:00:00")) //summary field
            {
              $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] .  ",Day";
            }
            else
            {
              $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . ",Night";
            }

            $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . "," . $samplerName .
            "," . $labTechName  .  //summary field
            "," . $operatorName  .  //summary field

                "," . $plus40  .
                "," . $neg40Plus70  .
                "," . $neg60Plus70  .
                "," . $neg70Plus140  .
                "," . $neg50Plus140  .
                "," . $nearSize  .
                "," . $neg140Plus325  .
                "," . $neg140  .


            "," . $Object->vars["beginningWetWeight"]  .
            "," . $Object->vars["preWashDryWeight"]  .
            "," . $Object->vars["postWashDryWeight"]  .

            "," . $Object->vars["splitSampleWeight"]  .
            "," . $Object->vars["turbidity"]  .
            "," . $Object->vars["tonsRepresented"]  .
            "," . $Object->vars["tphRepresented"]  .
            "," . $Object->vars["notes"]  .  //summary field
            "," . $moisture_rate  . //summary field
            "," . $Object->vars["recoveryPlusOneForty"]  .
            "," . $Object->vars["groupStartDateTime"]  .
            "," . $Object->vars["finishDateTime"]  .
            "," . $Object->vars["duration"]  .
            "," . $Object->vars["durationMinutes"]  .

            "," . $totalFinalWeight .  //summary field

            "," . $Object->vars["oversizeWeight"]  .
            "," . $Object->vars["oversizePercent"]  .
            ","  . $Object->vars["slimesPercent"]  .
            "," . $orePercent .
            "," . $isCOA .
            "," . $Object->vars["description"]  .

            "," . $value30 .
            "," . $value35 .
            "," . $value40 .
            "," . $value45 .
            "," . $value50 .
            "," . $value60 .
            "," . $value70 .
            "," . $value80 .
            "," . $value100 .
            "," . $value120 .
            "," . $value140 .
            "," . $value170 .
            "," . $value200 .
            "," . $value230 .
            "," . $value270 .
            "," . $value325 .
            "," . $valuePAN .
            "," . $siteName .
            "," . $drillholeNumber .
            "," . $depthFrom .
            "," . $depthTo;

            //dynamically add the PLC columns based on the values in the database
            for($i = 0; $i < count($PLCArray); $i++)
            {
              $PLCDataObject = NULL;
              $PLCDataObject = getPlantSettingsDataByTagAndSampleId($PLCArray[$i]->vars['id'], $Object->vars["id"]);
              if($PLCDataObject == NULL)
              {
                $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . ","; //add an empty cell
              }
              else
              {
                $downloadArray[$downloadArrayCount] = $downloadArray[$downloadArrayCount] . "," . $PLCDataObject->vars['value'];
              }
            }

            /***************************************************************************************/

            $l++;
            $downloadArrayCount++;
          }

        echo("</tbody>");
        echo("</table>");

  }
  ?>
        
        
  <div class="detailsTableRelativeSpacer"></div>  
  <br/>
  <form action="fileDownload.php" id="fileDownloadForm" method="post">
    <span id="downloadStringDebug"></span>
    <?php
    //echo "DEBUG: downloadArray = ";
    //echo var_Dump($downloadArray) . "<br/>";   
    $c = 0;
    if(count($downloadArray) > 0)
    {
      foreach($downloadArray as $value)
      {
        echo '<input type="hidden" class="contentStringArray" id="downloadString' . $c . '" name="contentStringArray[]" value="'. $value. '">';
        $c++;
      }
    }
    ?>
   <!-- <input type="submit" value="Export Table to Excel" onclick="readTableContentsToDownload();"> Hiding this as it is no longer necessary after implementing datatables.--> 
  </form>

  <?php

//  //output the pagination navigation links -- removed after adding pagination
//  $prev = $startRow - $resultsPerPage;
//  echo("Showing samples " . $startRow . " through " . ($startRow + ($downloadArrayCount - 1)) . ".<br/><br/>");
//  
//  //only show a "Previous" link if a "Next" was clicked
//  if ($prev >= 0)
//  {
//    echo('<input type="button" value="Previous" onclick="loadPreviousPage();">');  
//  }
//  
//  //only show a space if there are both Previous and Next links
//  if(($prev >= 0) && (($downloadArrayCount - 1) >= $resultsPerPage))
//  {
//    echo " | "; //spacer between buttons
//  }
//  
//  //only show a "Next" link if a there are enough results for another page.
//  if(($downloadArrayCount - 1) >= $resultsPerPage)
//  {
//    echo('<input type="button" value="Next" onclick="loadNextPage();">');
//  }
//  
  ?>
</div> <!-- tabcontent -->

<script>

    function idSearch()
    {
        var idInput = document.getElementById('idSearchBox').value;
        window.location = "gb_sampleedit.php?sampleId=" + idInput;
    }

//call JQuery to render the datepicker tool
$(function() 
{
  
  $("#start_date_filter").datetimepicker(
  {
    format: 'Y-m-d H:i',
    //dateFormat: 'yy-mm-dd',
    onSelect: function(datetext)
    {
      var d = new Date(); // for now
      
      var h = d.getHours();
      h = (h < 10) ? ("0" + h) : h ;
    
      var m = d.getMinutes();
      m = (m < 10) ? ("0" + m) : m ;
      
      var s = d.getSeconds();
      s = (s < 10) ? ("0" + s) : s ;
      
      datetext = datetext + " " + h + ":" + m + ":" + s;
      $('#start_date_filter').val(datetext);
    },
  });
  
  $("#end_date_filter").datetimepicker(
  {
    format: 'Y-m-d H:i',
    //dateFormat: 'yy-mm-dd',
    onSelect: function(datetext)
    {
      var d = new Date(); // for now
      
      var h = d.getHours();
      h = (h < 10) ? ("0" + h) : h ;
    
      var m = d.getMinutes();
      m = (m < 10) ? ("0" + m) : m ;
      
      var s = d.getSeconds();
      s = (s < 10) ? ("0" + s) : s ;
      
      datetext = datetext + " " + h + ":" + m + ":" + s;
      $('#end_date_filter').val(datetext);
    },
  });
});
</script>
<script>
//functionality for the filter accordion box when clicking on the Filter Settings button
var acc = document.getElementsByClassName("filter_button");
var i;
var timesFilterSettingsToggled = 0;

for (i = 0; i < acc.length; i++) 
{
  acc[i].onclick = function()
  {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight)
    {
      panel.style.maxHeight = null;
    } 
    else 
    {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
    timesFilterSettingsToggled = timesFilterSettingsToggled + 1;
  }
}

//when toggling the filter from the bottom of the screen
function toggleFilterReference()
{
  console.log("toggleFilterReference called");
  console.log("timesFilterSettingsToggled = " + timesFilterSettingsToggled);
  console.log("toggleFilterReference mod 2 = " + (timesFilterSettingsToggled % 2));
  
  var filterPanel = document.getElementById("filter_options");
  if((timesFilterSettingsToggled % 2) == 0) //if the filter options panel is not expanded
  {
    //then expand it
    filterPanel.style.maxHeight = filterPanel.scrollHeight + "px";
    
    //keep track of how many times the panel has been expanded and closed
    timesFilterSettingsToggled = timesFilterSettingsToggled + 1;
  }
}

</script>

<script>
//function to filter the content of the table
function tableFilter()
{
  var input, filter, filter2, table, tr, td, td2, i, explodedInput;
  var testTypeIsInhibited, SieveStackIsSelected, TotalWeightIsZero, LocationIsJamesHardieMoisture, MoistureRateIsZero;
  var tablecells;
  var filter_text = "Filters:"; //used to display what the filters are.
  var numberOfFilters = 0; //used to track if we need a leading comma in the filter text
  
  table = document.getElementById("samplesTable");
  
  //init, make every row visible
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    tr[i].style.display = "";
  }
  
  //filter by completion status
  input = document.getElementById("completion_status_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    else
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  }
        

  
  //split the time from the start date
  input = document.getElementById("start_date_filter");
  explodedInput = input.value.split(" ");
  //filter by start date-time
  filter = explodedInput[0]; //date
  filter2 = explodedInput[1]; //time
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " Start Date " + filter;
    filter_text = filter_text + " " + filter2;
    numberOfFilters = numberOfFilters + 1;
  }
     

  
  //split the time from the end date
  input = document.getElementById("end_date_filter");
  if(input.value != "")
  {
    explodedInput = input.value.split(" ");
    //filter by end date-time
    filter = explodedInput[0]; //date
    filter2 = explodedInput[1]; //time
    if(filter.length > 0)
    {
      if(numberOfFilters != 0)
      {
        filter_text = filter_text + ";";
      }
      filter_text = filter_text + " End Date " + filter;
      filter_text = filter_text + " " + filter2;
      numberOfFilters = numberOfFilters + 1;
    }

  }
  
  //filter by shift
  input = document.getElementById("shift_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  }

  
  //filter by test type
  input = document.getElementsByClassName("testTypeId"); //array of checked boxes
  inputLabels = document.getElementsByClassName("testTypeLabels"); //array of checked boxes
  filter = "Test Type="; //string to store the filter name to display
  var inputsChecked = [];  
  //loop through the array and create a label string
  for (var i = 0; i < input.length; i++) 
  {
    if(input[i].checked == true)
    {
      //alert("DEBUG: " + i);
      filter = filter + inputLabels[i].textContent + ",";
      inputsChecked.push(inputLabels[i].textContent); 
    }
  }
  
  if(inputsChecked.length > 0) 
  {
    //trim the last comma from the list
    filter.substring(0, filter.length - 1);
    //add the filter description to display at the top of the screen
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  

  }
  
  //filter by composite type
  input = document.getElementById("composite_type_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  }
        
  
  //filter by lab tech
  input = document.getElementsByClassName("labTechId"); //array of checked boxes
  inputLabels = document.getElementsByClassName("labTechLabels"); //array of checked boxes
  filter = "Lab Tech="; //string to store the filter name to display
  var inputsChecked = [];  
  //loop through the array and create a label string
  for (var i = 0; i < input.length; i++) 
  {
    if(input[i].checked == true)
    {
      //alert("DEBUG: " + i);
      filter = filter + inputLabels[i].textContent + ",";
      inputsChecked.push(inputLabels[i].textContent); 
    }
  }
  
  if(inputsChecked.length > 0) 
  {
    //trim the last comma from the list
    filter.substring(0, filter.length - 1);
    //add the filter description to display at the top of the screen
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  

  }
  
  //filter by sampler
  input = document.getElementById("sampler_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " Sampler=" + filter;
    numberOfFilters = numberOfFilters + 1;
  }
        

  
  //filter by operator
  input = document.getElementById("operator_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " Operator=" + filter;
    numberOfFilters = numberOfFilters + 1;
  }
 
  
  //filter by plant
  input = document.getElementsByClassName("plantId"); //array of checked boxes
  inputLabels = document.getElementsByClassName("plantLabels"); //array of checked boxes
  filter = "Plant="; //string to store the filter name to display
  var inputsChecked = [];  
  //loop through the array and create a label string
  for (var i = 0; i < input.length; i++) 
  {
    if(input[i].checked == true)
    {
      //alert("DEBUG: " + i);
      filter = filter + inputLabels[i].textContent + ",";
      inputsChecked.push(inputLabels[i].textContent); 
    }
  }
  if(inputsChecked.length > 0) 
  {
    //trim the last comma from the list
    filter.substring(0, filter.length - 1);
    //add the filter description to display at the top of the screen
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  

  }
  
  //filter by site
  input = document.getElementsByClassName("siteId"); //array of checked boxes
  inputLabels = document.getElementsByClassName("siteLabels"); //array of checked boxes
  filter = "Site="; //string to store the filter name to display
  var inputsChecked = [];  
  //loop through the array and create a label string
  for (var i = 0; i < input.length; i++) 
  {
    if(input[i].checked == true)
    {
      filter = filter + inputLabels[i].textContent + ",";
      inputsChecked.push(inputLabels[i].textContent); 
    }
  }
  if(inputsChecked.length > 0) 
  {
    //trim the last comma from the list
    filter.substring(0, filter.length - 1);
    //add the filter description to display at the top of the screen
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;

  }
  
  //filter by location
  input = document.getElementsByClassName("locationId"); //array of checked boxes
  inputLabels = document.getElementsByClassName("locationLabels"); //array of checked boxes
  filter = "Location="; //string to store the filter name to display
  var inputsChecked = [];  
  //loop through the array and create a label string
  for (var i = 0; i < input.length; i++) 
  {
    if(input[i].checked == true)
    {
      //alert("DEBUG: " + i);
      filter = filter + inputLabels[i].textContent + ",";
      inputsChecked.push(inputLabels[i].textContent); 
    }
  }
  if(inputsChecked.length > 0) 
  {
    //trim the last comma from the list
    filter.substring(0, filter.length - 1);
    //add the filter description to display at the top of the screen
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
    

  }
  
  //filter by specificLocation
  input = document.getElementsByClassName("specificLocationId"); //array of checked boxes
  inputLabels = document.getElementsByClassName("specificLocationLabels"); //array of checked boxes
  filter = "Specific Location="; //string to store the filter name to display
  var inputsChecked = [];  
  //loop through the array and create a label string
  for (var i = 0; i < input.length; i++) 
  {
    if(input[i].checked == true)
    {
      //alert("DEBUG: " + i);
      filter = filter + inputLabels[i].textContent + ",";
      inputsChecked.push(inputLabels[i].textContent); 
    }
  }
  if(inputsChecked.length > 0) 
  {
    //trim the last comma from the list
    filter.substring(0, filter.length - 1);
    //add the filter description to display at the top of the screen
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;

  }
  
 
  //filter the view method
  input = document.getElementById("view_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  }
  //iterate through all items with the class "verbose", these are items not included in the summary
  var arrayOfVerboseItems = document.getElementsByClassName("verbose");
  var k;
  for (k = 0; k < arrayOfVerboseItems.length; k++) 
  {
    if(filter == "Verbose") //if the filter is set to verbose
    {
      arrayOfVerboseItems[k].style.display = "table-cell"; //display the item
    }
    else
    {
      arrayOfVerboseItems[k].style.display = "none"; //hide the item
    }
  }
  
  //filter by void status
  input = document.getElementById("void_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  //console.log("DEBUG: filter = " + filter);
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " " + filter;
    numberOfFilters = numberOfFilters + 1;
  }

  
  //display the Is COA filter status
  input = document.getElementById("is_coa_filter");
  filter = input.options[input.selectedIndex].innerHTML;
  //console.log("DEBUG: filter = " + filter);
  if(filter.length > 0)
  {
    if(numberOfFilters != 0)
    {
      filter_text = filter_text + ";";
    }
    filter_text = filter_text + " Is COA? " + filter;
    numberOfFilters = numberOfFilters + 1;
  }
  
  //display text telling the user how the page is filtered
  if(numberOfFilters == 0)
  {
    document.getElementById("filters_displayed").innerHTML = "";
  }
  else
  {
    //clean up the text first by replacing ",;" with ";"
    for (var i = 0; i < numberOfFilters; i++) 
    {
      filter_text = filter_text.replace(",;", ";");
    }
    
    document.getElementById("filters_displayed").innerHTML = filter_text;
  }
  
  if(timesFilterSettingsToggled != 0)
  {
    //hide the filter box when Filter Samples is clicked
    var acc = document.getElementById("filter_button");
    acc.classList.toggle("active");
    var panel = acc.nextElementSibling;
    if (panel.style.maxHeight)
    {
      panel.style.maxHeight = null;
    } 
    else 
    {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  }

}

window.onload = function () 
{ 
  //start the Session Timeout counter
  var countdownTime = 60 * 60 * 3;
  display = document.querySelector('#time');
  startTimer(countdownTime, display);
  
  //apply JavaScript filters to the table.
  tableFilter();

  //set the position of the Details table fixed cells appropriately
  //moveCols();
}



</script>

<script type="text/javascript">
 
  //filters sites, plants, locations and specific locations with javascript
  $(document).ready(function(){
    $(".siteId").change(function(){
        var siteId = parseInt(this.value)
        var plantDivs = document.getElementsByClassName('plantDiv');
        var locationDivs = document.getElementsByClassName('locationDiv');
        var spcLocationDivs = document.getElementsByClassName('spcLocationDiv');
         for (var i = 0; i < plantDivs.length; i++)
         {
         	var plantVal = parseInt(plantDivs[i].getAttribute('site-id'));

            if(plantVal === siteId)
            {
                toggleStyle(plantDivs[i], "display", "none")
            }
         }
//        if(this.checked==false)
//            {
//                for(var i=0; i < plantDivs.length; i++)
//                {
//                  box = $(plantDivs[i]).children(":checkbox");
//                  alert(box);
//                }
//            }
    });
    
    $(".plantId").change(function(){
 
        var plantId = parseInt(this.value)
        var locationDivs = document.getElementsByClassName('locationDiv');
        var spcLocationDivs = document.getElementsByClassName('spcLocationDiv');
        for(var i=0; i < locationDivs.length; i++)
         {
           var locVal = parseInt(locationDivs[i].getAttribute('plant-id'));
            if(locVal === plantId)
            {
              toggleStyle(locationDivs[i],"display","none")
              if(this.checked==false)
              {
                
              }
            }
         }         
    });
    $(".locationId").change(function(){
        
        var locationId = parseInt(this.value)
        var spcLocationDivs = document.getElementsByClassName('spcLocationDiv');
        for(var i=0; spcLocationDivs.length; i++)
         {
           var locVal = parseInt(spcLocationDivs[i].getAttribute('location-id'));
            if(locVal === locationId)
            {
              toggleStyle(spcLocationDivs[i],"display","none")
            }
         }
         
    });
});


function toggleStyle(el, styleName, value) {
  if (el.style[styleName] !== value) {  //better to check that it is not the value you have
    el.style[styleName] = value;
  } else {
    el.style[styleName] = 'block';
  }
}


function resetStartRow()
{
  //reset the start row to 0
  document.getElementById('startRow').value = "0";
  
  //reload the page
  reloadPage();
}
  
function reloadPage()
{
  //get the values from the filter options
  var completionStatus = document.getElementById('completion_status_filter').value;
  completionStatus = encodeURI(completionStatus);

  var startDate = document.getElementById('start_date_filter').value;
  startDate = encodeURI(startDate);

  var endDate = document.getElementById('end_date_filter').value;
  endDate = encodeURI(endDate);

  //test types
  //read the test types 
  var testTypeArray = document.getElementsByClassName("testTypeId"); //array of checked boxes
  var testTypeCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < testTypeArray.length; i++) 
  {
    if(testTypeArray[i].checked == true)
    {
      //save the test types into an CSV value
      testTypeCSV = testTypeCSV + testTypeArray[i].value + ",";
    }
  }
  if(testTypeArray.length > 0)
  {
    //trim the last comma from the string
    testTypeCSV = testTypeCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  testTypeCSV = encodeURI(testTypeCSV);
  //alert("DEBUG: testTypeCSV = " + testTypeCSV);

  var compositeType = document.getElementById('composite_type_filter').value;
  compositeType = encodeURI(compositeType);

  var shift = document.getElementById('shift_filter').value;
  shift = encodeURI(shift);

  //lab techs
  //read the lab techs 
  var labTechArray = document.getElementsByClassName("labTechId"); //array of checked boxes
  var labTechCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < labTechArray.length; i++) 
  {
    if(labTechArray[i].checked == true)
    {
      //save the test types into an CSV value
      labTechCSV = labTechCSV + labTechArray[i].value + ",";
    }
  }
  if(labTechArray.length > 0)
  {
    //trim the last comma from the string
    labTechCSV = labTechCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  labTechCSV = encodeURI(labTechCSV);
  //alert("DEBUG: labTechCSV = " + labTechCSV);

  var sampler = document.getElementById('sampler_filter').value;
  sampler = encodeURI(sampler);

  var operator = document.getElementById('operator_filter').value;
  operator = encodeURI(operator);

  //sites
  //read the sites 
  var siteArray = document.getElementsByClassName("siteId"); //array of checked boxes
  var siteCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < siteArray.length; i++) 
  {
    if(siteArray[i].checked == true)
    {
      //save the test types into an CSV value
      siteCSV = siteCSV + siteArray[i].value + ",";
    }
  }
  if(siteArray.length > 0)
  {
    //trim the last comma from the string
    siteCSV = siteCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  siteCSV = encodeURI(siteCSV);
  //alert("DEBUG: siteCSV = " + siteCSV);

  //plants
  //read the plants 
  var plantArray = document.getElementsByClassName("plantId"); //array of checked boxes
  var plantCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < plantArray.length; i++) 
  {
    if(plantArray[i].checked == true)
    {
      //save the test types into an CSV value
      plantCSV = plantCSV + plantArray[i].value + ",";
    }
  }
  if(plantArray.length > 0)
  {
    //trim the last comma from the string
    plantCSV = plantCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  plantCSV = encodeURI(plantCSV);
  //alert("DEBUG: plantCSV = " + plantCSV);

  //locations
  //read the locations 
  var locationArray = document.getElementsByClassName("locationId"); //array of checked boxes
  var locationCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < locationArray.length; i++) 
  {
    if(locationArray[i].checked == true)
    {
      //save the test types into an CSV value
      locationCSV = locationCSV + locationArray[i].value + ",";
    }
  }
  if(locationArray.length > 0)
  {
    //trim the last comma from the string
    locationCSV = locationCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  locationCSV = encodeURI(locationCSV);
  //alert("DEBUG: locationCSV = " + locationCSV);
  
  //specificLocations
  //read the specificLocations 
  var specificLocationArray = document.getElementsByClassName("specificLocationId"); //array of checked boxes
  var specificLocationCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < specificLocationArray.length; i++) 
  {
    if(specificLocationArray[i].checked == true)
    {
      //save the test types into an CSV value
      specificLocationCSV = specificLocationCSV + specificLocationArray[i].value + ",";
    }
  }
  if(specificLocationArray.length > 0)
  {
    //trim the last comma from the string
    specificLocationCSV = specificLocationCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  specificLocationCSV = encodeURI(specificLocationCSV);
  //alert("DEBUG: specificLocationCSV = " + specificLocationCSV);

  var view = document.getElementById('view_filter').value;
  view = encodeURI(view);

  var voidFilter = document.getElementById('void_filter').value;
  voidFilter = encodeURI(voidFilter);

  var resultsPerPage = document.getElementById('results_per_page').value;
  resultsPerPage = encodeURI(resultsPerPage);

  var startRow = document.getElementById('startRow').value;
  startRow = encodeURI(startRow);

  window.location='gb_samples.php?startDate=' + startDate + '&endDate=' + endDate + '&compositeType=' + compositeType + '&shift=' + shift + '&sampler=' + sampler + '&operator=' + operator + '&completionStatus=' + completionStatus + '&view=' + view + '&void=' + voidFilter + '&resultsPerPage=' + resultsPerPage + '&startRow=' + startRow + '&locationsRESTString=' + locationCSV + '&testTypesRESTString=' + testTypeCSV + '&labTechsRESTString=' + labTechCSV + '&sitesRESTString=' + siteCSV + '&plantsRESTString=' + plantCSV + '&specificLocationsRESTString=' + specificLocationCSV;
}

function clearFilters()
{
  window.location = "/Controls/QC/gb_samples.php";
}

function loadNextPage()
{
  //get the values from the filter options
  var completionStatus = document.getElementById('completion_status_filter').value;
  completionStatus = encodeURI(completionStatus);

  var startDate = document.getElementById('start_date_filter').value;
  startDate = encodeURI(startDate);

  var endDate = document.getElementById('end_date_filter').value;
  endDate = encodeURI(endDate);

  //test types
  //read the test types 
  var testTypeArray = document.getElementsByClassName("testTypeId"); //array of checked boxes
  var testTypeCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < testTypeArray.length; i++) 
  {
    if(testTypeArray[i].checked == true)
    {
      //save the test types into an CSV value
      testTypeCSV = testTypeCSV + testTypeArray[i].value + ",";
    }
  }
  if(testTypeArray.length > 0)
  {
    //trim the last comma from the string
    testTypeCSV = testTypeCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  testTypeCSV = encodeURI(testTypeCSV);
  //alert("DEBUG: testTypeCSV = " + testTypeCSV);

  var compositeType = document.getElementById('composite_type_filter').value;
  compositeType = encodeURI(compositeType);

  var shift = document.getElementById('shift_filter').value;
  shift = encodeURI(shift);

  //lab techs
  //read the lab techs 
  var labTechArray = document.getElementsByClassName("labTechId"); //array of checked boxes
  var labTechCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < labTechArray.length; i++) 
  {
    if(labTechArray[i].checked == true)
    {
      //save the test types into an CSV value
      labTechCSV = labTechCSV + labTechArray[i].value + ",";
    }
  }
  if(labTechArray.length > 0)
  {
    //trim the last comma from the string
    labTechCSV = labTechCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  labTechCSV = encodeURI(labTechCSV);
  //alert("DEBUG: labTechCSV = " + labTechCSV);

  var sampler = document.getElementById('sampler_filter').value;
  sampler = encodeURI(sampler);

  var operator = document.getElementById('operator_filter').value;
  operator = encodeURI(operator);

  //sites
  //read the sites 
  var siteArray = document.getElementsByClassName("siteId"); //array of checked boxes
  var siteCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < siteArray.length; i++) 
  {
    if(siteArray[i].checked == true)
    {
      //save the test types into an CSV value
      siteCSV = siteCSV + siteArray[i].value + ",";
    }
  }
  if(siteArray.length > 0)
  {
    //trim the last comma from the string
    siteCSV = siteCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  siteCSV = encodeURI(siteCSV);
  //alert("DEBUG: siteCSV = " + siteCSV);

  //plants
  //read the plants 
  var plantArray = document.getElementsByClassName("plantId"); //array of checked boxes
  var plantCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < plantArray.length; i++) 
  {
    if(plantArray[i].checked == true)
    {
      //save the test types into an CSV value
      plantCSV = plantCSV + plantArray[i].value + ",";
    }
  }
  if(plantArray.length > 0)
  {
    //trim the last comma from the string
    plantCSV = plantCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  plantCSV = encodeURI(plantCSV);
  //alert("DEBUG: plantCSV = " + plantCSV);

  //locations
  //read the locations 
  var locationArray = document.getElementsByClassName("locationId"); //array of checked boxes
  var locationCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < locationArray.length; i++) 
  {
    if(locationArray[i].checked == true)
    {
      //save the test types into an CSV value
      locationCSV = locationCSV + locationArray[i].value + ",";
    }
  }
  if(locationArray.length > 0)
  {
    //trim the last comma from the string
    locationCSV = locationCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  locationCSV = encodeURI(locationCSV);
  //alert("DEBUG: locationCSV = " + locationCSV);
  
  //specificLocations
  //read the specificLocations 
  var specificLocationArray = document.getElementsByClassName("specificLocationId"); //array of checked boxes
  var specificLocationCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < specificLocationArray.length; i++) 
  {
    if(specificLocationArray[i].checked == true)
    {
      //save the test types into an CSV value
      specificLocationCSV = specificLocationCSV + specificLocationArray[i].value + ",";
    }
  }
  if(specificLocationArray.length > 0)
  {
    //trim the last comma from the string
    specificLocationCSV = specificLocationCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  specificLocationCSV = encodeURI(specificLocationCSV);
  //alert("DEBUG: specificLocationCSV = " + specificLocationCSV);

  var view = document.getElementById('view_filter').value;
  view = encodeURI(view);

  var voidFilter = document.getElementById('void_filter').value;
  voidFilter = encodeURI(voidFilter);

  var resultsPerPage = document.getElementById('results_per_page').value;
  resultsPerPage = encodeURI(resultsPerPage);

  var startRow = document.getElementById('startRow').value;
  startRow = encodeURI(startRow);
  
  var newStartRow = parseInt(startRow) + parseInt(resultsPerPage);
  newStartRow = encodeURI(newStartRow);
    
  window.location='gb_samples.php?startDate=' + startDate + '&endDate=' + endDate + '&compositeType=' + compositeType + '&shift=' + shift + '&sampler=' + sampler + '&operator=' + operator + '&completionStatus=' + completionStatus + '&view=' + view + '&void=' + voidFilter + '&resultsPerPage=' + resultsPerPage + '&startRow=' + newStartRow + '&locationsRESTString=' + locationCSV + '&testTypesRESTString=' + testTypeCSV + '&labTechsRESTString=' + labTechCSV + '&sitesRESTString=' + siteCSV + '&plantsRESTString=' + plantCSV + '&specificLocationsRESTString=' + specificLocationCSV;
}

function loadPreviousPage()
{
  //get the values from the filter options
  var completionStatus = document.getElementById('completion_status_filter').value;
  completionStatus = encodeURI(completionStatus);

  var startDate = document.getElementById('start_date_filter').value;
  startDate = encodeURI(startDate);

  var endDate = document.getElementById('end_date_filter').value;
  endDate = encodeURI(endDate);

  //test types
  //read the test types 
  var testTypeArray = document.getElementsByClassName("testTypeId"); //array of checked boxes
  var testTypeCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < testTypeArray.length; i++) 
  {
    if(testTypeArray[i].checked == true)
    {
      //save the test types into an CSV value
      testTypeCSV = testTypeCSV + testTypeArray[i].value + ",";
    }
  }
  if(testTypeArray.length > 0)
  {
    //trim the last comma from the string
    testTypeCSV = testTypeCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  testTypeCSV = encodeURI(testTypeCSV);
  //alert("DEBUG: testTypeCSV = " + testTypeCSV);

  var compositeType = document.getElementById('composite_type_filter').value;
  compositeType = encodeURI(compositeType);

  var shift = document.getElementById('shift_filter').value;
  shift = encodeURI(shift);

  //lab techs
  //read the lab techs 
  var labTechArray = document.getElementsByClassName("labTechId"); //array of checked boxes
  var labTechCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < labTechArray.length; i++) 
  {
    if(labTechArray[i].checked == true)
    {
      //save the test types into an CSV value
      labTechCSV = labTechCSV + labTechArray[i].value + ",";
    }
  }
  if(labTechArray.length > 0)
  {
    //trim the last comma from the string
    labTechCSV = labTechCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  labTechCSV = encodeURI(labTechCSV);
  //alert("DEBUG: labTechCSV = " + labTechCSV);

  var sampler = document.getElementById('sampler_filter').value;
  sampler = encodeURI(sampler);

  var operator = document.getElementById('operator_filter').value;
  operator = encodeURI(operator);

  //sites
  //read the sites 
  var siteArray = document.getElementsByClassName("siteId"); //array of checked boxes
  var siteCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < siteArray.length; i++) 
  {
    if(siteArray[i].checked == true)
    {
      //save the test types into an CSV value
      siteCSV = siteCSV + siteArray[i].value + ",";
    }
  }
  if(siteArray.length > 0)
  {
    //trim the last comma from the string
    siteCSV = siteCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  siteCSV = encodeURI(siteCSV);
  //alert("DEBUG: siteCSV = " + siteCSV);

  //plants
  //read the plants 
  var plantArray = document.getElementsByClassName("plantId"); //array of checked boxes
  var plantCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < plantArray.length; i++) 
  {
    if(plantArray[i].checked == true)
    {
      //save the test types into an CSV value
      plantCSV = plantCSV + plantArray[i].value + ",";
    }
  }
  if(plantArray.length > 0)
  {
    //trim the last comma from the string
    plantCSV = plantCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  plantCSV = encodeURI(plantCSV);
  //alert("DEBUG: plantCSV = " + plantCSV);

  //locations
  //read the locations 
  var locationArray = document.getElementsByClassName("locationId"); //array of checked boxes
  var locationCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < locationArray.length; i++) 
  {
    if(locationArray[i].checked == true)
    {
      //save the test types into an CSV value
      locationCSV = locationCSV + locationArray[i].value + ",";
    }
  }
  if(locationArray.length > 0)
  {
    //trim the last comma from the string
    locationCSV = locationCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  locationCSV = encodeURI(locationCSV);
  //alert("DEBUG: locationCSV = " + locationCSV);
  
  //specificLocations
  //read the specificLocations 
  var specificLocationArray = document.getElementsByClassName("specificLocationId"); //array of checked boxes
  var specificLocationCSV = ""; //string to store the filter name to display 
  //loop through the array and create a string
  for (var i = 0; i < specificLocationArray.length; i++) 
  {
    if(specificLocationArray[i].checked == true)
    {
      //save the test types into an CSV value
      specificLocationCSV = specificLocationCSV + specificLocationArray[i].value + ",";
    }
  }
  if(specificLocationArray.length > 0)
  {
    //trim the last comma from the string
    specificLocationCSV = specificLocationCSV.slice(0, -1);
  }
  //encode the string for use in a URI
  specificLocationCSV = encodeURI(specificLocationCSV);
  //alert("DEBUG: specificLocationCSV = " + specificLocationCSV);

  var view = document.getElementById('view_filter').value;
  view = encodeURI(view);

  var voidFilter = document.getElementById('void_filter').value;
  voidFilter = encodeURI(voidFilter);

  var resultsPerPage = document.getElementById('results_per_page').value;
  resultsPerPage = encodeURI(resultsPerPage);

  var startRow = document.getElementById('startRow').value;
  startRow = encodeURI(startRow);

  var newStartRow = parseInt(startRow) - parseInt(resultsPerPage);
  newStartRow = encodeURI(newStartRow);
  
  var isCOA = document.getElementById('is_coa_filter').value;
  isCOA = encodeURI(isCOA);

  window.location='gb_samples.php?startDate=' + startDate + '&endDate=' + endDate + '&compositeType=' + compositeType + '&shift=' + shift + '&sampler=' + sampler + '&operator=' + operator + '&completionStatus=' + completionStatus + '&view=' + view + '&void=' + voidFilter + '&resultsPerPage=' + resultsPerPage + '&startRow=' + newStartRow + '&locationsRESTString=' + locationCSV + '&testTypesRESTString=' + testTypeCSV + '&labTechsRESTString=' + labTechCSV + '&sitesRESTString=' + siteCSV + '&plantsRESTString=' + plantCSV + '&specificLocationsRESTString=' + specificLocationCSV + '&isCOA=' + isCOA;
}
</script>

<script type="text/javascript">
  var filterPanelGlobal = document.getElementById("filter_options");

  //functionality for toggling the location accordion box based on the button
  var acc;
  var i = 0;

  //toggle the location panel
  acc = document.getElementsByClassName("location_button");
  for (i = 0; i < acc.length; i++) 
  {
    acc[i].onclick = function()
    {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight)
      {
        panel.style.maxHeight = null;
        panel.style.visibility = "hidden";
        
      } 
      else 
      {
        panel.style.visibility = "visible";
        panel.style.maxHeight = "300px";
        
        //expand the filter panel to support the added content
        filterPanelGlobal.style.maxHeight = filterPanelGlobal.scrollHeight + 300 + "px"; 
        
      } 
    }
  }
  
  //toggle the specific location panel
  acc = document.getElementsByClassName("specific_location_button");
  for (i = 0; i < acc.length; i++) 
  {
    acc[i].onclick = function()
    {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight)
      {
        panel.style.maxHeight = null;
        panel.style.visibility = "hidden";
        
      } 
      else 
      {
        panel.style.visibility = "visible";
        panel.style.maxHeight = "300px";
        
        //expand the filter panel to support the added content
        filterPanelGlobal.style.maxHeight = filterPanelGlobal.scrollHeight + 300 + "px"; 
        
      } 
    }
  }
  
  //toggle the test type panel
  acc = document.getElementsByClassName("test_type_button");
  for (i = 0; i < acc.length; i++) 
  {
    acc[i].onclick = function()
    {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight)
      {
        panel.style.maxHeight = null;
        panel.style.visibility = "hidden";
        
      } 
      else 
      {
        panel.style.visibility = "visible";
        panel.style.maxHeight = "300px";
        
        //expand the filter panel to support the added content
        filterPanelGlobal.style.maxHeight = filterPanelGlobal.scrollHeight + 300 + "px"; 
        
      } 
    }
  }
  
  //toggle the lab tech panel
  acc = document.getElementsByClassName("lab_tech_button");
  for (i = 0; i < acc.length; i++) 
  {
    acc[i].onclick = function()
    {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight)
      {
        panel.style.maxHeight = null;
        panel.style.visibility = "hidden";
        
      } 
      else 
      {
        panel.style.visibility = "visible";
        panel.style.maxHeight = "300px";
        
        //expand the filter panel to support the added content
        filterPanelGlobal.style.maxHeight = filterPanelGlobal.scrollHeight + 300 + "px"; 
        
      } 
    }
  }
  
  //toggle the sites panel
  acc = document.getElementsByClassName("sites_button");
  for (i = 0; i < acc.length; i++) 
  {
    acc[i].onclick = function()
    {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight)
      {
        panel.style.maxHeight = null;
        panel.style.visibility = "hidden";
        
      } 
      else 
      {
        panel.style.visibility = "visible";
        panel.style.maxHeight = "300px";
        
        //expand the filter panel to support the added content
        filterPanelGlobal.style.maxHeight = filterPanelGlobal.scrollHeight + 300 + "px"; 
        
      } 
    }
  }
  
  //toggle the plant panel
  acc = document.getElementsByClassName("plant_button");
  for (i = 0; i < acc.length; i++) 
  {
    acc[i].onclick = function()
    {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight)
      {
        panel.style.maxHeight = null;
        panel.style.visibility = "hidden";
        
      } 
      else 
      {
        panel.style.visibility = "visible";
        panel.style.maxHeight = "300px";
        
        //expand the filter panel to support the added content
        filterPanelGlobal.style.maxHeight = filterPanelGlobal.scrollHeight + 300 + "px"; 
        
      } 
    }
  }
</script>
<style>
  .loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<script>
   
//This functions formats the date to be more readable.
function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function formatDate(date) {
     var d = new Date(),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear(),
         h = addZero(d.getHours()),
         m = addZero(d.getMinutes());

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return ([day, month, year].join('-') + ' ' + [h] + [m]);
 }
 
 /**
 * This function formats the table using the bootstrap framework and paginates. 
 * Also it allows the user to multi select and export, export all and search as well. 
 *
 * datatables.net
 *
 * whildebrandt
 */

  $(document).ready(function() {
    var table = $('#samplesTable').DataTable( {
        dom: 'frtipB',
        scrollY:        "450px",
        scrollX:        true,
        select:{
          style: 'multi'
        },         
        scrollCollapse: false,
        paging:         true,
        pageLength:     50,
        fixedColumn:    true,
        order: [
                        1,
                        'desc'
        ],
        fixedColumns: {
          leftColumns: 4,
            rightColumns: 3
        },
                buttons: [
            {
                extend: 'csv',
                text: 'Export All Samples',
                title: function(){
                  var fileDate = formatDate();
                  var sampleCount = table.rows().count();
                  return sampleCount + ' sample(s) exported on ' + fileDate;
                },
                exportOptions: {
                    modifier: {
                        selected: null
                    }
                }
            },
            {
                extend: 'csv',
                text: 'Export Selected Samples',
                title: function(){
                  var fileDate = formatDate();
                  var sampleCount = table.rows( { selected: true } ).count();
                  return sampleCount + ' sample(s) exported on ' + fileDate;
                }
            }, {
            extend: 'colvis'
        }
        ]
    }

            );
      if($('#permission-check').val() === '1'){
          $('.DTFC_RightBodyWrapper').hide();
          $('.DTFC_RightHeadWrapper').hide();
      }
      $('.dt-buttons').removeClass('btn-group');
      $('.buttons-csv').addClass('btn-vprop-blue-medium');
      $('.btn').removeClass('btn-secondary');
} );


</script>
<?php
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
?>

<!-- HTML -->





