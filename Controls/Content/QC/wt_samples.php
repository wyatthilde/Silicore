<?php

/* * *****************************************************************************************************************************************
 * File Name: wt_samples.php
 * Project: Silicore
 * Description: This page displays samples within given filter criteria.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/04/2018|mnutsch|KACE:20158 - Initial creation
 * 01/08/2018|mnutsch|KACE:19775 - Added a table for search result calculations.
 * 01/08/2018|mnutsch|KACE:19775 - Corrected code to look at west_texas permission instead of tolar.
 * 01/10/2018|mnutsch|KACE:19775 - Added a duplicate of the summations table at the bottom of the page.
 * 01/15/2018|mnutsch|KACE:19755 - Added samplesTableWrapperBox div around Details table.
 * 
 * **************************************************************************************************************************************** */

//include other files
require_once('../../Includes/QC/wt_qcfunctions.php'); //contains database connection info
require_once('../../Includes/security.php'); //contains database connection info

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
  $resultsPerPage = 50;
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
if(isset($userPermissionsArray['vista']['west_texas']['qc']))
{
  if($userPermissionsArray['vista']['west_texas']['qc'] < 3) 
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
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css"> 
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>
<script type="text/javascript" src="../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js"></script>


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
  <button class="filter_button" id="filter_button" type="button">Filter Settings</button>
  
  <div id="filter_options" class="filter_options">
    
    <fieldset>
      <legend>Filters:</legend>
      <div class="form-group">
      <label for="start_date_filter">Start Date:</label>
      <input type="text" id="start_date_filter" name="start_date_filter" value="<?php echo $startDate; ?>"/></div>
      <br/>

      <div class="form-group">
      <label for="end_date_filter">End Date:</label> 
      <input type="text" id="end_date_filter" name="end_date_filter" value="<?php echo $endDate; ?>"/></div>
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
      <button class="test_type_button" id="test_type_button" type="button">Select Test Types</button>
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
      <button class="lab_tech_button" id="lab_techs_button" type="button">Select Lab Techs</button>
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
      <button class="sites_button" id="sites_button" type="button">Select Sites</button>
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
                echo "<div style='display:block;'><input type='checkbox' name='siteId[]' id='siteId[]' class='siteId' value='" . $siteObject->vars["id"] . "' checked><span class='siteLabels'>" . $siteObject->vars["description"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='siteId[]' id='siteId[]' class='siteId' value='" . $siteObject->vars["id"] . "'><span class='siteLabels'>" . $siteObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>      

      <div class="form-group">
      <label for="plants_button">Plants:</label> 
      <button class="plant_button" id="plants_button" type="button">Select Plants</button>
      <div id="plant_options" class="plant_options">
        <div class="plantSelect" id="plantSelect">
          <?php
            $plantObjectArray = getPlants(); //get a list of plant options
            foreach ($plantObjectArray as $plantObject) 
            {
              //if the plant was sent as a REST parameter
              if(in_array($plantObject->vars["id"], $plantsRESTArray))
              {
                //display the checkbox as checked
                echo "<div style='display:block;'><input type='checkbox' name='plantId[]' id='plantId[]' class='plantId' value='" . $plantObject->vars["id"] . "' checked><span class='plantLabels'>" . $plantObject->vars["description"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='plantId[]' id='plantId[]' class='plantId' value='" . $plantObject->vars["id"] . "'><span class='plantLabels'>" . $plantObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>

      <div class="form-group">
      <label for="locations_button">Sample Locations:</label> 
      <button class="location_button" id="locations_button" type="button">Select Locations</button>
      <div id="location_options" class="location_options">
        <div class="locationSelect" id="locationSelect">
          <?php
            $locationObjectArray = getLocations(); //get a list of location options
            foreach ($locationObjectArray as $locationObject) 
            {
              //if the location was sent as a REST parameter
              if(in_array($locationObject->vars["id"], $locationsRESTArray))
              {
                //display the checkbox as checked
                echo "<div style='display:block;'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId' value='" . $locationObject->vars["id"] . "' checked><span class='locationLabels'>" . $locationObject->vars["description"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId' value='" . $locationObject->vars["id"] . "'><span class='locationLabels'>" . $locationObject->vars["description"] . "</span><br></div>";
              }
            }
          ?>
        </div>        
      </div>
      </div>
      
      <div class="form-group">
      <label for="specific_locations_button">Specific Locations:</label> 
      <button class="specific_location_button" id="specific_locations_button" type="button">Select Specific Locations</button>
      <div id="specific_location_options" class="specific_location_options">
        <div class="specificLocationSelect" id="specificLocationSelect">
          <?php
            $specificLocationObjectArray = getSpecificLocations(); //get a list of location options
            foreach ($specificLocationObjectArray as $specificLocationObject) 
            {
              //if the location was sent as a REST parameter
              if(in_array($specificLocationObject->vars["id"], $specificLocationsRESTArray))
              {
                //display the checkbox as checked
                echo "<div style='display:block;'><input type='checkbox' name='specificLocationId[]' id='specificLocationId[]' class='specificLocationId' value='" . $specificLocationObject->vars["id"] . "' checked><span class='specificLocationLabels'>" . $specificLocationObject->vars["description"] . "</span><br></div>"; 
              }
              else
              {
                //display the checkbox as unchecked
                echo "<div style='display:block;'><input type='checkbox' name='specificLocationId[]' id='specificLocationId[]' class='specificLocationId' value='" . $specificLocationObject->vars["id"] . "'><span class='specificLocationLabels'>" . $specificLocationObject->vars["description"] . "</span><br></div>";
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
      if($userPermissionsArray['vista']['west_texas']['qc'] < 3)
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
      
      <button id="applyFilters" class="applyFilters" type="button" onclick="reloadPage()">Apply Filters</button><br/><br/>
      
    </fieldset>
      
    <br/>
    
  </div>
  
  </select>
        
  <?php
    $ObjectArray = getSamplesByFilters($startDate, $endDate, $startRow, $resultsPerPage, $completionStatus, $testTypesRESTString, $compositeType, $shift, $labTechsRESTString, $sampler, $operator, $sitesRESTString, $plantsRESTString, $locationsRESTString, $specificLocationsRESTString, $void, $isCOA);
    //$ObjectArray = getSamplesInDateRangeIncludeVoided($startDate, $endDate, $startRow, $resultsPerPage); //get a list of samples within the date range
  ?>
        
  <h4>Summations</h4>
  <div class="tableWrapper">
  <table>
      
         <?php
          if($ObjectArray == NULL)
          {
            echo "No samples were found.";
          }
          else 
          {
            echo("<thead>");
            echo("<tr><th></th><th>20</th><th>25</th><th>30</th><th>35</th><th>40</th><th>45</th><th>50</th><th>60</th><th>70</th><th>80</th><th>100</th><th>120</th><th>140</th><th>160</th><th>170</th><th>200</th><th>230</th><th>270</th><th>325</th><th>PAN</th><th>Minus Forty Plus Seventy (-40 +70)</th><th>Plus Seventy (+70)</th><th>Minus Seventy (-70)</th><th>Minus One Forty (-140)</th><th>Minus Seventy Plus One Forty (-70 +140)</th><th>Moisture Rate</th><th>Percent Solids</th><th>STPH</th><th>Turbidity</th><th>Plus Seventy Recovery</th><th>Plus One Forty Recovery</th></tr>");            
            echo("</thead>");
            echo("<tbody>");
            
            $arrayOfAverages = NULL;
            $arrayOfStdDevs = NULL;
            $arrayOfMax = NULL;
            $arrayOfMin = NULL;
                        
            $arrayOfAverages = getObjectArrayPercentAverages($ObjectArray);
            $arrayOfStdDevs = getObjectArrayPercentStdDevs($ObjectArray, $arrayOfAverages);
            $arrayOfMaximums = getObjectArrayPercentMaximums($ObjectArray);
            $arrayOfMinimums = getObjectArrayPercentMinimums($ObjectArray);
            
            echo("<tr><td><strong>Avg</strong></td>");
            if($arrayOfAverages[0] != 0) { echo("<td>" . round(($arrayOfAverages[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[1] != 0) { echo("<td>" . round(($arrayOfAverages[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[2] != 0) { echo("<td>" . round(($arrayOfAverages[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[3] != 0) { echo("<td>" . round(($arrayOfAverages[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[4] != 0) { echo("<td>" . round(($arrayOfAverages[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[5] != 0) { echo("<td>" . round(($arrayOfAverages[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[6] != 0) { echo("<td>" . round(($arrayOfAverages[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[7] != 0) { echo("<td>" . round(($arrayOfAverages[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[8] != 0) { echo("<td>" . round(($arrayOfAverages[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[9] != 0) { echo("<td>" . round(($arrayOfAverages[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[10] != 0) { echo("<td>" . round(($arrayOfAverages[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[11] != 0) { echo("<td>" . round(($arrayOfAverages[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[12] != 0) { echo("<td>" . round(($arrayOfAverages[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[13] != 0) { echo("<td>" . round(($arrayOfAverages[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[14] != 0) { echo("<td>" . round(($arrayOfAverages[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[15] != 0) { echo("<td>" . round(($arrayOfAverages[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[16] != 0) { echo("<td>" . round(($arrayOfAverages[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[17] != 0) { echo("<td>" . round(($arrayOfAverages[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[18] != 0) { echo("<td>" . round(($arrayOfAverages[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[19] != 0) { echo("<td>" . round(($arrayOfAverages[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[20] != 0) { echo("<td>" . round(($arrayOfAverages[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[21] != 0) { echo("<td>" . round(($arrayOfAverages[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[22] != 0) { echo("<td>" . round(($arrayOfAverages[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[23] != 0) { echo("<td>" . round(($arrayOfAverages[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[24] != 0) { echo("<td>" . round(($arrayOfAverages[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[25] != 0) { echo("<td>" . round(($arrayOfAverages[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[26] != 0) { echo("<td>" . round(($arrayOfAverages[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[27] != 0) { echo("<td>" . round(($arrayOfAverages[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[28] != 0) { echo("<td>" . round($arrayOfAverages[28], 2) . "</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[29] != 0) { echo("<td>" . round(($arrayOfAverages[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfAverages[30] != 0) { echo("<td>" . round(($arrayOfAverages[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            
            echo("<tr><td><strong>Std Dev</strong></td>");
            if($arrayOfStdDevs[0] != 0) { echo("<td>" . round(($arrayOfStdDevs[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[1] != 0) { echo("<td>" . round(($arrayOfStdDevs[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[2] != 0) { echo("<td>" . round(($arrayOfStdDevs[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[3] != 0) { echo("<td>" . round(($arrayOfStdDevs[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[4] != 0) { echo("<td>" . round(($arrayOfStdDevs[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[5] != 0) { echo("<td>" . round(($arrayOfStdDevs[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[6] != 0) { echo("<td>" . round(($arrayOfStdDevs[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[7] != 0) { echo("<td>" . round(($arrayOfStdDevs[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[8] != 0) { echo("<td>" . round(($arrayOfStdDevs[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[9] != 0) { echo("<td>" . round(($arrayOfStdDevs[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[10] != 0) { echo("<td>" . round(($arrayOfStdDevs[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[11] != 0) { echo("<td>" . round(($arrayOfStdDevs[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[12] != 0) { echo("<td>" . round(($arrayOfStdDevs[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[13] != 0) { echo("<td>" . round(($arrayOfStdDevs[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[14] != 0) { echo("<td>" . round(($arrayOfStdDevs[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[15] != 0) { echo("<td>" . round(($arrayOfStdDevs[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[16] != 0) { echo("<td>" . round(($arrayOfStdDevs[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[17] != 0) { echo("<td>" . round(($arrayOfStdDevs[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[18] != 0) { echo("<td>" . round(($arrayOfStdDevs[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[19] != 0) { echo("<td>" . round(($arrayOfStdDevs[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[20] != 0) { echo("<td>" . round(($arrayOfStdDevs[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[21] != 0) { echo("<td>" . round(($arrayOfStdDevs[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[22] != 0) { echo("<td>" . round(($arrayOfStdDevs[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[23] != 0) { echo("<td>" . round(($arrayOfStdDevs[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[24] != 0) { echo("<td>" . round(($arrayOfStdDevs[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[25] != 0) { echo("<td>" . round(($arrayOfStdDevs[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[26] != 0) { echo("<td>" . round(($arrayOfStdDevs[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[27] != 0) { echo("<td>" . round(($arrayOfStdDevs[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[28] != 0) { echo("<td>" . round($arrayOfStdDevs[28], 2) . "</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[29] != 0) { echo("<td>" . round(($arrayOfStdDevs[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfStdDevs[30] != 0) { echo("<td>" . round(($arrayOfStdDevs[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }                       
            
            echo("<tr><td><strong>Max</strong></td>");
            if($arrayOfMaximums[0] != 0) { echo("<td>" . round(($arrayOfMaximums[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[1] != 0) { echo("<td>" . round(($arrayOfMaximums[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[2] != 0) { echo("<td>" . round(($arrayOfMaximums[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[3] != 0) { echo("<td>" . round(($arrayOfMaximums[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[4] != 0) { echo("<td>" . round(($arrayOfMaximums[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[5] != 0) { echo("<td>" . round(($arrayOfMaximums[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[6] != 0) { echo("<td>" . round(($arrayOfMaximums[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[7] != 0) { echo("<td>" . round(($arrayOfMaximums[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[8] != 0) { echo("<td>" . round(($arrayOfMaximums[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[9] != 0) { echo("<td>" . round(($arrayOfMaximums[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[10] != 0) { echo("<td>" . round(($arrayOfMaximums[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[11] != 0) { echo("<td>" . round(($arrayOfMaximums[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[12] != 0) { echo("<td>" . round(($arrayOfMaximums[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[13] != 0) { echo("<td>" . round(($arrayOfMaximums[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[14] != 0) { echo("<td>" . round(($arrayOfMaximums[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[15] != 0) { echo("<td>" . round(($arrayOfMaximums[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[16] != 0) { echo("<td>" . round(($arrayOfMaximums[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[17] != 0) { echo("<td>" . round(($arrayOfMaximums[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[18] != 0) { echo("<td>" . round(($arrayOfMaximums[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[19] != 0) { echo("<td>" . round(($arrayOfMaximums[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[20] != 0) { echo("<td>" . round(($arrayOfMaximums[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[21] != 0) { echo("<td>" . round(($arrayOfMaximums[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[22] != 0) { echo("<td>" . round(($arrayOfMaximums[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[23] != 0) { echo("<td>" . round(($arrayOfMaximums[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[24] != 0) { echo("<td>" . round(($arrayOfMaximums[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[25] != 0) { echo("<td>" . round(($arrayOfMaximums[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[26] != 0) { echo("<td>" . round(($arrayOfMaximums[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[27] != 0) { echo("<td>" . round(($arrayOfMaximums[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[28] != 0) { echo("<td>" . round($arrayOfMaximums[28], 2) . "</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[29] != 0) { echo("<td>" . round(($arrayOfMaximums[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMaximums[30] != 0) { echo("<td>" . round(($arrayOfMaximums[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }                       
            
            echo("<tr><td><strong>Min</strong></td>");
            if($arrayOfMinimums[0] != 100) { echo("<td>" . round(($arrayOfMinimums[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[1] != 100) { echo("<td>" . round(($arrayOfMinimums[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[2] != 100) { echo("<td>" . round(($arrayOfMinimums[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[3] != 100) { echo("<td>" . round(($arrayOfMinimums[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[4] != 100) { echo("<td>" . round(($arrayOfMinimums[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[5] != 100) { echo("<td>" . round(($arrayOfMinimums[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[6] != 100) { echo("<td>" . round(($arrayOfMinimums[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[7] != 100) { echo("<td>" . round(($arrayOfMinimums[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[8] != 100) { echo("<td>" . round(($arrayOfMinimums[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[9] != 100) { echo("<td>" . round(($arrayOfMinimums[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[10] != 100) { echo("<td>" . round(($arrayOfMinimums[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[11] != 100) { echo("<td>" . round(($arrayOfMinimums[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[12] != 100) { echo("<td>" . round(($arrayOfMinimums[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[13] != 100) { echo("<td>" . round(($arrayOfMinimums[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[14] != 100) { echo("<td>" . round(($arrayOfMinimums[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[15] != 100) { echo("<td>" . round(($arrayOfMinimums[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[16] != 100) { echo("<td>" . round(($arrayOfMinimums[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[17] != 100) { echo("<td>" . round(($arrayOfMinimums[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[18] != 100) { echo("<td>" . round(($arrayOfMinimums[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[19] != 100) { echo("<td>" . round(($arrayOfMinimums[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[20] != 100) { echo("<td>" . round(($arrayOfMinimums[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[21] != 100) { echo("<td>" . round(($arrayOfMinimums[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[22] != 100) { echo("<td>" . round(($arrayOfMinimums[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[23] != 100) { echo("<td>" . round(($arrayOfMinimums[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[24] != 100) { echo("<td>" . round(($arrayOfMinimums[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[25] != 100) { echo("<td>" . round(($arrayOfMinimums[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[26] != 100) { echo("<td>" . round(($arrayOfMinimums[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[27] != 100) { echo("<td>" . round(($arrayOfMinimums[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[28] != 100) { echo("<td>" . round($arrayOfMinimums[28], 2) . "</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[29] != 100) { echo("<td>" . round(($arrayOfMinimums[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
            if($arrayOfMinimums[30] != 100) { echo("<td>" . round(($arrayOfMinimums[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }                       
            
          }
        ?>
        
      </tbody>
  </table>
  </div>
        
  <hr>
  
  <h4>Details</h4>
  <div class="samplesTableWrapperBox">
    <div class="tableWrapper">
      <table id="samplesTable" name="samplesTable" class="tablesorter">
      <?php

      if($ObjectArray == NULL)
      {
        echo "No samples were found.";
      }
      else 
      {

        //get a list of PLC Tags to display as columns
        $PLCArray = getPLCTags();
        echo("<thead>");
        echo "<tr>" .
        "<th name='tableHeaderCheckCell' id='tableHeaderCheckCell' onclick='toggleCheckAll()' class='sorter-false' data-sorter='false'>Select All<br/><input name='tableHeaderCheck' id='tableHeaderCheck' type='checkbox' value='1'></th>" .         
        "<th>Sample ID</th>" . //summary field
        "<th>Date</th>" . //summary field
        "<th>Time</th>" . //summary field
        "<th class='verbose'>Group Time</th>" . 
        "<th>Test Type</th>" . //summary field
        "<th>Composite Type</th>" . //summary field
        "<th>Sieve Stack</th>" . //summary field
        "<th>Plant</th>" . //summary field  
        "<th>Location</th>" . //summary field   
        "<th class='verbose'>Specific Location</th>";

        echo "<th>Shift</th>" . //summary field

        "<th>Sampler</th>" . //summary field
        "<th>Lab Tech</th>" . //summary field
        "<th>Operator</th>"; //summary field

        echo "<th class='verbose'>Plus Seventy (+70)</th>" . 
        "<th class='verbose'>Minus Seventy -70</th>" . 
        "<th class='verbose'>Minus Seventy Plus One Forty (-70 +140)</th>" . 
        //"<th class='verbose'>+140</th>" . 
        "<th class='verbose'>Minus One Forty (-140)</th>" . 
        "<th class='verbose'>Minus Forty Plus Seventy (-40 +70)</th>";

        echo "<th class='verbose'>Beginning Wet Weight</th>" . 
        "<th class='verbose'>Pre Wash Dry Weight</th>" . 
        "<th class='verbose'>Post Wash Dry Weight</th>" . 

        "<th class='verbose'>Split Sample Weight</th>" . 
        "<th class='verbose'>Turbidity</th>" . 
        "<th class='verbose'>Tons Represented</th>" . 
        "<th class='verbose'>TPH Represented</th>" . 
        "<th>Notes</th>" . //summary field
        "<th>Moisture Rate</th>" . //summary field      
        "<th class='verbose'>Recovery +140</th>" . 
        "<th class='verbose'>Group Start Datetime</th>" . 
        "<th class='verbose'>Finish Datetime</th>" . 
        "<th class='verbose'>Duration Minutes</th>" . 
        "<th class='verbose'>Duration</th>" . 

        "<th class='verbose'>Total Weight</th>"; //summary field

        echo("<th>Void Status</th>"); //summary field      
        echo("<th>Completion Status</th>"); //summary field    

        echo "<th>Site</th>"; //summary field  

        echo "<th class='verbose'>Drillhole Number</th>" . 
        "<th class='verbose'>Depth From</th>" . 
        "<th class='verbose'>Depth To</th>";

        echo "<th class='verbose'>Oversize Weight</th>";
        echo "<th class='verbose'>Oversize Percent</th>";
        echo "<th class='verbose'>Slimes Percent/Amt Lost in Wash</th>";
        echo "<th class='verbose'>Ore Percent</th>";
        echo "<th class='verbose'>Is COA</th>";
        echo "<th class='verbose'>Description</th>";


        echo "<th class='verbose'>Near Size</th>" . 

        "<th class='verbose'>30</th>" . 	
        "<th class='verbose'>35</th>" . 	
        "<th class='verbose'>40</th>" . 	
        "<th class='verbose'>45</th>" . 	
        "<th class='verbose'>50</th>" . 	
        "<th class='verbose'>60</th>" . 	
        "<th class='verbose'>70</th>" . 	
        "<th class='verbose'>80</th>" . 	
        "<th class='verbose'>100</th>" . 	
        "<th class='verbose'>120</th>" . 	
        "<th class='verbose'>140</th>" . 	
        "<th class='verbose'>170</th>" . 	
        "<th class='verbose'>200</th>" . 	
        "<th class='verbose'>230</th>" . 	
        "<th class='verbose'>270</th>" . 	
        "<th class='verbose'>325</th>" . 	
        "<th class='verbose'>PAN</th>";



        //dynamically output the PLC columns based on the values in the database
        for($i = 0; $i < count($PLCArray); $i++)
        {
          echo("<th class='verbose'>" . $PLCArray[$i]->vars['device'] . "</th>");        
        }

        /*

        echo "<th class='verbose'>Description</th>" . 
        "<th class='verbose'>Repeatability ID</th>" . 
        "<th class='verbose'>Site ID</th>" . 

        "<th class='verbose'>Date Short</th>" . 

        "<th class='verbose'>Datetime</th>" . 
        "<th class='verbose'>Datetime Short</th>" . 
        "<th class='verbose'>Shift Date</th>" . 
        "<th class='verbose'>Shift</th>" . 
        "<th class='verbose'>Rail Car ID</th>" . 
        "<th class='verbose'>Rail Car Product ID</th>" . 
        "<th class='verbose'>Rail Car Available Datetime</th>" . 
        "<th class='verbose'>Starting Weight</th>" . 
        "<th class='verbose'>Ending Weight</th>" . 
        "<th class='verbose'>Drillhole Number</th>" . 
        "<th class='verbose'>Depth From</th>" . 
        "<th class='verbose'>Depth To</th>" . 

        "<th class='verbose'>Oversize Weight</th>" . 

        "<th class='verbose'>Split Sample Weight Delta</th>" . 
        "<th class='verbose'>Oversize Percent</th>" . 
        "<th class='verbose'>Slimes Percent</th>" .  
        "<th class='verbose'>Review Notes</th>" . 

        "<th class='verbose'>Container Slurry Weight</th>" . 
        "<th class='verbose'>Container Water Weight</th>" . 
        "<th class='verbose'>Container Empty Weight</th>" . 
        "<th class='verbose'>K Value</th>" . 
        "<th class='verbose'>K Pan 1</th>" . 
        "<th class='verbose'>K Pan 2</th>" . 
        "<th class='verbose'>K Pan 3</th>" . 
        "<th class='verbose'>K Percent Fines</th>" . 
        "<th class='verbose'>K Value Fail</th>" . 
        "<th class='verbose'>K Pan 1 Fail</th>" . 
        "<th class='verbose'>K Pan 2 Fail</th>" . 
        "<th class='verbose'>K Pan 3 Fail</th>" . 
        "<th class='verbose'>K Percent Fines Fail</th>" . 
        "<th class='verbose'>Roundness</th>" . 
        "<th class='verbose'>Sphericity</th>" . 
        "<th class='verbose'>Sieve 1 Description</th>" . 
        "<th class='verbose'>Sieve 1 Value</th>" . 
        "<th class='verbose'>Sieve 1 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 1 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 2 Description</th>" . 
        "<th class='verbose'>Sieve 2 Value</th>" . 
        "<th class='verbose'>Sieve 2 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 2 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 3 Description</th>" . 
        "<th class='verbose'>Sieve 3 Value</th>" . 
        "<th class='verbose'>Sieve 3 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 3 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 4 Description</th>" . 
        "<th class='verbose'>Sieve 4 Value</th>" . 
        "<th class='verbose'>Sieve 4 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 4 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 5 Description</th>" . 
        "<th class='verbose'>Sieve 5 Value</th>" . 
        "<th class='verbose'>Sieve 5 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 5 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 6 Description</th>" . 
        "<th class='verbose'>Sieve 6 Value</th>" . 
        "<th class='verbose'>Sieve 6 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 6 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 7 Description</th>" . 
        "<th class='verbose'>Sieve 7 Value</th>" . 
        "<th class='verbose'>Sieve 7 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 7 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 8 Description</th>" . 
        "<th class='verbose'>Sieve 8 Value</th>" . 
        "<th class='verbose'>Sieve 8 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 8 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 9 Description</th>" . 
        "<th class='verbose'>Sieve 9 Value</th>" . 
        "<th class='verbose'>Sieve 9 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 9 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieve 10 Description</th>" . 
        "<th class='verbose'>Sieve 10 Value</th>" . 
        "<th class='verbose'>Sieve 10 Value Cumul.</th>" . 
        "<th class='verbose'>Sieve 10 Value Cum. Passing</th>" . 
        "<th class='verbose'>Sieves Total</th>" . 
        "<th class='verbose'>Start Weights Raw</th>" . 
        "<th class='verbose'>End Weights Raw</th>" . 
        "<th class='verbose'>Sieves Raw</th>" . 
        "<th class='verbose'>Feed Row Number</th>" . 
        "<th class='verbose'>Cut Ratio</th>" . 
        "<th class='verbose'>Moisture Ratio</th>" . 
        "<th class='verbose'>Percent Solids</th>" . 
        "<th class='verbose'>STPH</th>" . 

        "<th class='verbose'>Recovery +70</th>"; 
        */      
        if(isset($userPermissionsArray['vista']['west_texas']['qc']))
        {
          if($userPermissionsArray['vista']['west_texas']['qc'] > 0) //if the user has QC permission then show them the hyperlinks
          {
            echo "<th></th>" . //edit
            "<th></th>" . //repeat
            "<th></th>"; //void
          }
        }

        echo("</tr>");
        echo("</thead>");
        echo("<tbody>");
        /************************************************************************************/
        //create the header row for download
        $downloadArray[0] = "ID,Date,Time,Group Time,Test Type,Composite Type,Sieve Stack,Plant,Location,Specific Location ID,Shift,Sampler,Lab Tech,Operator,Plus Seventy (+70),Minus Seventy (-70),Minus Seventy Plus One Forty (-70 +140),Minus One Forty (-140),Minus Forty Plus Seventy (-40 +70),Beginning Wet Weight,Pre Wash Dry Weight,Post Wash Dry Weight,Split Sample Weight,Turbidity,Tons Represented,TPH Represented,Notes,Moisture Rate,Recovery +140,Group Start Datetime,Finish Datetime,Duration Minutes,Duration,Total Weight,Void Status,Completion Status,Site,Oversize Weight,Oversize Percent,Slimes Percent/Amt Lost in Wash,Ore Percent,Is COA,Description,Near Size,30,35,40,45,50,60,70,80,100,120,140,170,200,230,270,325,PAN";

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
          $plusSeventy = $Object->vars["plusSeventy"];
          $minusSeventy = $Object->vars["minusSeventy"];
          $minusSeventyPlusOneForty = $Object->vars["minusSeventyPlusOneForty"];
          $minusOneForty = $Object->vars["minusOneForty"];
          $minusFortyPlusSeventy = $Object->vars["minusFortyPlusSeventy"];
          $nearSize = $Object->vars["nearSize"];
          //format the values as pecentages instead of doubles
          if($plusSeventy != 0) { $plusSeventy = ($plusSeventy * 100) . "%"; } else { $plusSeventy = ""; }
          if($minusSeventy != 0) { $minusSeventy = ($minusSeventy * 100) . "%"; } else { $minusSeventy = ""; }
          if($minusSeventyPlusOneForty != 0) { $minusSeventyPlusOneForty = ($minusSeventyPlusOneForty * 100) . "%"; } else { $minusSeventyPlusOneForty = ""; }
          if($minusOneForty != 0) { $minusOneForty = ($minusOneForty * 100) . "%"; } else { $minusOneForty = ""; }
          if($minusFortyPlusSeventy != 0) { $minusFortyPlusSeventy = ($minusFortyPlusSeventy * 100) . "%"; } else { $minusFortyPlusSeventy = ""; }
          if($nearSize != 0) { $nearSize = ($nearSize * 100) . "%"; } else { $nearSize = ""; }              

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

          "<td title='Select for Download'><input type='checkbox' name='tableRowCheckbox' id='tableRowCheckbox" . $l . "' value='1' onchange='readTableContentsToDownload();'></td>" .

          "<td title='Sample ID'><a href='../../Controls/QC/wt_sampleview.php?sampleId=" . $Object->vars["id"] . "'>" . $Object->vars["id"] . "</a></td>" .  //summary field
          "<td title='Date'>" . $Object->vars["date"] . "</td>" .  //summary field
          "<td title='Time'>" . $Object->vars["time"] . "</td>" . //summary field

          "<td class='verbose' title='Group Time'>" . $Object->vars["groupTime"] . "</td>" .

          "<td title='Test Type'>" . $testTypeName . "</td>" . //summary field
          "<td title='Composite Type'>" . $compositeTypeName . "</td>" .  //summary field
          "<td title='Sieve Stack'>" . $sieveStackName . "</td>" .   //summary field
          "<td title='Plant'>" . $plantName . "</td>" .  //summary field
          "<td title='Location'>" . $locationName . "</td>" .  //summary field
          "<td class='verbose' title='Specific Location'>" . $specificLocationName . "</td>";                 

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

          echo "<td class='verbose' title='Plus Seventy(+70)'>" . $plusSeventy . "</td>" .
          "<td class='verbose' title='Minus Seventy(-70)'>" . $minusSeventy . "</td>" .
          "<td class='verbose' title='Minus Seventy Plus One Forty (-70 +140)'>" . $minusSeventyPlusOneForty . "</td>" .
          //"<td class='verbose'>" . $Object->vars["plusOneForty"] . "</td>" .
          "<td class='verbose' title='Minus One Forty (-140)'>" . $minusOneForty . "</td>" .
          "<td class='verbose' title='Minus Forty Plus Seventy (-40 +70)'>" . $minusFortyPlusSeventy . "</td>";

          echo "<td class='verbose' title='Beginning Wet Weight'>" . $Object->vars["beginningWetWeight"] . "</td>" .
          "<td class='verbose' title='Pre Wash Dry Weight'>" . $Object->vars["preWashDryWeight"] . "</td>" .
          "<td class='verbose' title='Post Wash Dry Weight'>" . $Object->vars["postWashDryWeight"] . "</td>" .

          "<td class='verbose' title='Split Sample Weight'>" . $Object->vars["splitSampleWeight"] . "</td>" .
          "<td class='verbose' title='Turbidity'>" . $Object->vars["turbidity"] . "</td>" .
          "<td class='verbose' title='Tons Represented'>" . $Object->vars["tonsRepresented"] . "</td>" .
          "<td class='verbose' title='TPH Represented'>" . $Object->vars["tphRepresented"] . "</td>" .      
          "<td title='Notes'>" . $Object->vars["notes"] . "</td>" .  //summary field
          "<td title='Moisture Rate'>" . $moisture_rate . "</td>" . //summary field
          "<td class='verbose' title='Recovery +140'>" . $Object->vars["recoveryPlusOneForty"] . "</td>" . 
          "<td class='verbose' title='Group Start Datetime'>" . $Object->vars["groupStartDateTime"] . "</td>" .
          "<td class='verbose' title='Finish Datetime'>" . $Object->vars["finishDateTime"] . "</td>" .
          "<td class='verbose' title='Duration Minutes'>" . $Object->vars["durationMinutes"] . "</td>" .
          "<td class='verbose' title='Duration'>" . $Object->vars["duration"] . "</td>" .

          "<td class='verbose' title='Total Weight'>" . $totalFinalWeight . "</td>";  //summary field   

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

          //dynamically output the PLC columns based on the values in the database
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

          /*  
          echo "<td class='verbose'>" . $Object->vars["description"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["repeatabilityId"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["siteId"] . "</td>" .        
          "<td class='verbose'>" . $Object->vars["dateShort"] . "</td>" .        
          "<td class='verbose'>" . $Object->vars["dateTime"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["dateTimeShort"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["shiftDate"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["shift"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["railCarId"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["railCarProductId"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["railCarAvailableDateTime"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["startingWeight"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["endingWeight"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["drillholeNo"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["depthFrom"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["depthTo"] . "</td>" .

          "<td class='verbose'>" . $Object->vars["oversizeWeight"] . "</td>" .

          "<td class='verbose'>" . $Object->vars["splitSampleWeightDelta"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["oversizePercent"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["slimesPercent"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["orePercent"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["reviewNotes"] . "</td>" .

          "<td class='verbose'>" . $Object->vars["containerSlurryWeight"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["containerWaterWeight"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["containerEmptyWeight"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["kValue"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["pan1"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["pan2"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["pan3"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["kPercentFines"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["kValueFail"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["pan1Fail"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["pan2Fail"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["pan3Fail"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["kPercentFinesFail"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["roundness"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sphericity"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve1Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve1Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve1ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve1ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve2Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve2Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve2ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve2ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve3Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve3Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve3ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve3ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve4Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve4Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve4ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve4ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve5Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve5Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve5ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve5ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve6Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve6Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve6ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve6ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve7Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve7Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve7ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve7ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve8Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve8Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve8ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve8ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve9Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve9Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve9ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve9ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve10Desc"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve10Value"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve10ValueCumulative"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieve10ValueCumulativePassing"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sievesTotal"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["startWeightsRaw"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["endWeightsRaw"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["sieves_raw"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["feedRowNo"] . "</td>" .        
          "<td class='verbose'>" . $Object->vars["cutRatio"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["wpMoistureRatio"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["percentSolids"] . "</td>" .
          "<td class='verbose'>" . $Object->vars["stph"] . "</td>" .

          "<td class='verbose'>" . $Object->vars["recoveryPlusSeventy"] . "</td>";
          */

          if(isset($userPermissionsArray['vista']['west_texas']['qc']))
          {
            if($userPermissionsArray['vista']['west_texas']['qc'] > 0) //if the user has a QC permission then show them the edit link
            {
              echo "<td>";//summary field
              echo "<a href='../../Controls/QC/wt_sampleedit.php?sampleId=" . $Object->vars["id"] . "'>Edit</a>";
              echo "</td>";
            }       
          }

          if(isset($userPermissionsArray['vista']['west_texas']['qc']))
          {
            if($userPermissionsArray['vista']['west_texas']['qc'] > 0) //if the user has a QC permission then show them the repeat link
            {
              echo "<td>";//summary field
              echo "<a href='../../Includes/QC/wt_samplerepeat.php?sampleId=" . $Object->vars["id"] . "&userId=" . $user_id . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "'>Repeat</a>";
              echo "</td>";
            }
          }        

          if(isset($userPermissionsArray['vista']['west_texas']['qc']))
          {
            if($userPermissionsArray['vista']['west_texas']['qc'] > 0) //if the user has a QC permission then show them the void link
            {
              echo "<td>";//summary field
              if($Object->vars["voidStatusCode"] == "A")
              {
                echo "<a href='../../Includes/QC/wt_samplevoid.php?sampleId=" . $Object->vars["id"] . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "' onclick=\"return confirm('Are you sure?')\">Void</a>";
              }
              else
              {
                //if the user has permission to unvoid samples, then show them the link
                if(isset($userPermissionsArray['vista']['west_texas']['qc']))
                {
                  if($userPermissionsArray['vista']['west_texas']['qc'] >= 3) 
                  {
                    echo "<a href='../../Includes/QC/wt_samplereversevoid.php?sampleId=" . $Object->vars["id"] . "&completionStatus=" . $completionStatus . "&startDate=" . $startDate . "&endDate=" . $endDate . "&startRow=" . $startRow . "&resultsPerPage=" . $resultsPerPage . "&compositeType=" . $compositeType . "&shift=" . $shift . "&sampler=" . $sampler . "&operator=" . $operator . "&view=" . $view . "&void=" . $void . "&locationsRESTString=" . $locationsRESTString . "&testTypesRESTString=" . $testTypesRESTString . "&labTechsRESTString=" . $labTechsRESTString . "&sitesRESTString=" . $sitesRESTString . "&plantsRESTString=" . $plantsRESTString . "&specificLocationsRESTString=" . $specificLocationsRESTString . "&isCOA=" . $isCOA . "' onclick=\"return confirm('Are you sure?')\">UnVoid</a>";
                  }
                }
                else
                {
                  //else, don't show the link, because they are not authorized to see it
                }   
              }
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

          "," . $plusSeventy  .
          "," . $minusSeventy  .
          "," . $minusSeventyPlusOneForty  .
          "," . $minusOneForty  .
          "," . $minusFortyPlusSeventy  .

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

          "," . $nearSize .

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

      }

      ?>
      </tbody>
      </table>
    </div> <!-- tableWrapper -->
  </div> <!-- samplesTableWrapperBox -->
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
    <input type="submit" value="Export Table to Excel" onclick="readTableContentsToDownload();">
  </form>

  <?php

  //output the pagination navigation links
  $prev = $startRow - $resultsPerPage;
  echo("Showing samples " . $startRow . " through " . ($startRow + ($downloadArrayCount - 1)) . ".<br/><br/>");
  
  //only show a "Previous" link if a "Next" was clicked
  if ($prev >= 0)
  {
    echo('<input type="button" value="Previous" onclick="loadPreviousPage();">');  
  }
  
  //only show a space if there are both Previous and Next links
  if(($prev >= 0) && (($downloadArrayCount - 1) >= $resultsPerPage))
  {
    echo " | "; //spacer between buttons
  }
  
  //only show a "Next" link if a there are enough results for another page.
  if(($downloadArrayCount - 1) >= $resultsPerPage)
  {
    echo('<input type="button" value="Next" onclick="loadNextPage();">');
  }
  
  ?>
  
  <?php
    if($ObjectArray == NULL)
    {
      //do nothing, because we display a message at the top of the page
    }
    else 
    {
      echo("<hr>");
      echo("<h4>Summations</h4>");
      echo('<div class="tableWrapper">');
      echo("<table>");

      echo("<thead>");
      echo("<tr><th></th><th>20</th><th>25</th><th>30</th><th>35</th><th>40</th><th>45</th><th>50</th><th>60</th><th>70</th><th>80</th><th>100</th><th>120</th><th>140</th><th>160</th><th>170</th><th>200</th><th>230</th><th>270</th><th>325</th><th>PAN</th><th>Minus Forty Plus Seventy (-40 +70)</th><th>Plus Seventy (+70)</th><th>Minus Seventy (-70)</th><th>Minus One Forty (-140)</th><th>Minus Seventy Plus One Forty (-70 +140)</th><th>Moisture Rate</th><th>Percent Solids</th><th>STPH</th><th>Turbidity</th><th>Plus Seventy Recovery</th><th>Plus One Forty Recovery</th></tr>");            
      echo("</thead>");
      echo("<tbody>");

      echo("<tr><td><strong>Avg</strong></td>");
      if($arrayOfAverages[0] != 0) { echo("<td>" . round(($arrayOfAverages[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[1] != 0) { echo("<td>" . round(($arrayOfAverages[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[2] != 0) { echo("<td>" . round(($arrayOfAverages[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[3] != 0) { echo("<td>" . round(($arrayOfAverages[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[4] != 0) { echo("<td>" . round(($arrayOfAverages[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[5] != 0) { echo("<td>" . round(($arrayOfAverages[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[6] != 0) { echo("<td>" . round(($arrayOfAverages[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[7] != 0) { echo("<td>" . round(($arrayOfAverages[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[8] != 0) { echo("<td>" . round(($arrayOfAverages[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[9] != 0) { echo("<td>" . round(($arrayOfAverages[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[10] != 0) { echo("<td>" . round(($arrayOfAverages[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[11] != 0) { echo("<td>" . round(($arrayOfAverages[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[12] != 0) { echo("<td>" . round(($arrayOfAverages[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[13] != 0) { echo("<td>" . round(($arrayOfAverages[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[14] != 0) { echo("<td>" . round(($arrayOfAverages[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[15] != 0) { echo("<td>" . round(($arrayOfAverages[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[16] != 0) { echo("<td>" . round(($arrayOfAverages[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[17] != 0) { echo("<td>" . round(($arrayOfAverages[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[18] != 0) { echo("<td>" . round(($arrayOfAverages[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[19] != 0) { echo("<td>" . round(($arrayOfAverages[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[20] != 0) { echo("<td>" . round(($arrayOfAverages[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[21] != 0) { echo("<td>" . round(($arrayOfAverages[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[22] != 0) { echo("<td>" . round(($arrayOfAverages[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[23] != 0) { echo("<td>" . round(($arrayOfAverages[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[24] != 0) { echo("<td>" . round(($arrayOfAverages[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[25] != 0) { echo("<td>" . round(($arrayOfAverages[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[26] != 0) { echo("<td>" . round(($arrayOfAverages[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[27] != 0) { echo("<td>" . round(($arrayOfAverages[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[28] != 0) { echo("<td>" . round($arrayOfAverages[28], 2) . "</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[29] != 0) { echo("<td>" . round(($arrayOfAverages[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfAverages[30] != 0) { echo("<td>" . round(($arrayOfAverages[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }

      echo("<tr><td><strong>Std Dev</strong></td>");
      if($arrayOfStdDevs[0] != 0) { echo("<td>" . round(($arrayOfStdDevs[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[1] != 0) { echo("<td>" . round(($arrayOfStdDevs[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[2] != 0) { echo("<td>" . round(($arrayOfStdDevs[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[3] != 0) { echo("<td>" . round(($arrayOfStdDevs[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[4] != 0) { echo("<td>" . round(($arrayOfStdDevs[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[5] != 0) { echo("<td>" . round(($arrayOfStdDevs[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[6] != 0) { echo("<td>" . round(($arrayOfStdDevs[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[7] != 0) { echo("<td>" . round(($arrayOfStdDevs[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[8] != 0) { echo("<td>" . round(($arrayOfStdDevs[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[9] != 0) { echo("<td>" . round(($arrayOfStdDevs[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[10] != 0) { echo("<td>" . round(($arrayOfStdDevs[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[11] != 0) { echo("<td>" . round(($arrayOfStdDevs[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[12] != 0) { echo("<td>" . round(($arrayOfStdDevs[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[13] != 0) { echo("<td>" . round(($arrayOfStdDevs[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[14] != 0) { echo("<td>" . round(($arrayOfStdDevs[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[15] != 0) { echo("<td>" . round(($arrayOfStdDevs[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[16] != 0) { echo("<td>" . round(($arrayOfStdDevs[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[17] != 0) { echo("<td>" . round(($arrayOfStdDevs[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[18] != 0) { echo("<td>" . round(($arrayOfStdDevs[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[19] != 0) { echo("<td>" . round(($arrayOfStdDevs[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[20] != 0) { echo("<td>" . round(($arrayOfStdDevs[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[21] != 0) { echo("<td>" . round(($arrayOfStdDevs[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[22] != 0) { echo("<td>" . round(($arrayOfStdDevs[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[23] != 0) { echo("<td>" . round(($arrayOfStdDevs[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[24] != 0) { echo("<td>" . round(($arrayOfStdDevs[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[25] != 0) { echo("<td>" . round(($arrayOfStdDevs[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[26] != 0) { echo("<td>" . round(($arrayOfStdDevs[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[27] != 0) { echo("<td>" . round(($arrayOfStdDevs[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[28] != 0) { echo("<td>" . round($arrayOfStdDevs[28], 2) . "</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[29] != 0) { echo("<td>" . round(($arrayOfStdDevs[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfStdDevs[30] != 0) { echo("<td>" . round(($arrayOfStdDevs[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }                       

      echo("<tr><td><strong>Max</strong></td>");
      if($arrayOfMaximums[0] != 0) { echo("<td>" . round(($arrayOfMaximums[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[1] != 0) { echo("<td>" . round(($arrayOfMaximums[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[2] != 0) { echo("<td>" . round(($arrayOfMaximums[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[3] != 0) { echo("<td>" . round(($arrayOfMaximums[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[4] != 0) { echo("<td>" . round(($arrayOfMaximums[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[5] != 0) { echo("<td>" . round(($arrayOfMaximums[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[6] != 0) { echo("<td>" . round(($arrayOfMaximums[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[7] != 0) { echo("<td>" . round(($arrayOfMaximums[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[8] != 0) { echo("<td>" . round(($arrayOfMaximums[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[9] != 0) { echo("<td>" . round(($arrayOfMaximums[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[10] != 0) { echo("<td>" . round(($arrayOfMaximums[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[11] != 0) { echo("<td>" . round(($arrayOfMaximums[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[12] != 0) { echo("<td>" . round(($arrayOfMaximums[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[13] != 0) { echo("<td>" . round(($arrayOfMaximums[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[14] != 0) { echo("<td>" . round(($arrayOfMaximums[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[15] != 0) { echo("<td>" . round(($arrayOfMaximums[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[16] != 0) { echo("<td>" . round(($arrayOfMaximums[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[17] != 0) { echo("<td>" . round(($arrayOfMaximums[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[18] != 0) { echo("<td>" . round(($arrayOfMaximums[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[19] != 0) { echo("<td>" . round(($arrayOfMaximums[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[20] != 0) { echo("<td>" . round(($arrayOfMaximums[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[21] != 0) { echo("<td>" . round(($arrayOfMaximums[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[22] != 0) { echo("<td>" . round(($arrayOfMaximums[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[23] != 0) { echo("<td>" . round(($arrayOfMaximums[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[24] != 0) { echo("<td>" . round(($arrayOfMaximums[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[25] != 0) { echo("<td>" . round(($arrayOfMaximums[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[26] != 0) { echo("<td>" . round(($arrayOfMaximums[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[27] != 0) { echo("<td>" . round(($arrayOfMaximums[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[28] != 0) { echo("<td>" . round($arrayOfMaximums[28], 2) . "</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[29] != 0) { echo("<td>" . round(($arrayOfMaximums[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMaximums[30] != 0) { echo("<td>" . round(($arrayOfMaximums[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }                       

      echo("<tr><td><strong>Min</strong></td>");
      if($arrayOfMinimums[0] != 100) { echo("<td>" . round(($arrayOfMinimums[0] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[1] != 100) { echo("<td>" . round(($arrayOfMinimums[1] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[2] != 100) { echo("<td>" . round(($arrayOfMinimums[2] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[3] != 100) { echo("<td>" . round(($arrayOfMinimums[3] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[4] != 100) { echo("<td>" . round(($arrayOfMinimums[4] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[5] != 100) { echo("<td>" . round(($arrayOfMinimums[5] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[6] != 100) { echo("<td>" . round(($arrayOfMinimums[6] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[7] != 100) { echo("<td>" . round(($arrayOfMinimums[7] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[8] != 100) { echo("<td>" . round(($arrayOfMinimums[8] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[9] != 100) { echo("<td>" . round(($arrayOfMinimums[9] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[10] != 100) { echo("<td>" . round(($arrayOfMinimums[10] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[11] != 100) { echo("<td>" . round(($arrayOfMinimums[11] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[12] != 100) { echo("<td>" . round(($arrayOfMinimums[12] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[13] != 100) { echo("<td>" . round(($arrayOfMinimums[13] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[14] != 100) { echo("<td>" . round(($arrayOfMinimums[14] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[15] != 100) { echo("<td>" . round(($arrayOfMinimums[15] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[16] != 100) { echo("<td>" . round(($arrayOfMinimums[16] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[17] != 100) { echo("<td>" . round(($arrayOfMinimums[17] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[18] != 100) { echo("<td>" . round(($arrayOfMinimums[18] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[19] != 100) { echo("<td>" . round(($arrayOfMinimums[19] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[20] != 100) { echo("<td>" . round(($arrayOfMinimums[20] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[21] != 100) { echo("<td>" . round(($arrayOfMinimums[21] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[22] != 100) { echo("<td>" . round(($arrayOfMinimums[22] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[23] != 100) { echo("<td>" . round(($arrayOfMinimums[23] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[24] != 100) { echo("<td>" . round(($arrayOfMinimums[24] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[25] != 100) { echo("<td>" . round(($arrayOfMinimums[25] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[26] != 100) { echo("<td>" . round(($arrayOfMinimums[26] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[27] != 100) { echo("<td>" . round(($arrayOfMinimums[27] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[28] != 100) { echo("<td>" . round($arrayOfMinimums[28], 2) . "</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[29] != 100) { echo("<td>" . round(($arrayOfMinimums[29] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }
      if($arrayOfMinimums[30] != 100) { echo("<td>" . round(($arrayOfMinimums[30] * 100), 2) . "%</td>"); } else { echo("<td></td>"); }                       

      echo("</tbody>");
      echo("</table>");
      echo("</div>");
    }
    
  ?>
  
</div> <!-- tabcontent -->
    

<script>
//call JQuery to add the table sorter.
$(document).ready(function() 
  { 
    $("#samplesTable thead th:eq(0)").data("sorter", false);
    
    $("#samplesTable").tablesorter({
            
      headers: 
      {
        //disable sorting of columns where the class is sorter-false
        '.sorter-false' : {
          // disable it by setting the property sorter to false
          sorter: false
        }
      }
      
    }); 
    
  } 
);

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
        
  /*
  //Replaced by MySQL filter in KACE 18789        
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[36];
    if (td) 
    {
      //console.log("DEBUG: td.innerHTML = " + td.innerHTML);
      if((filter == "Complete") && (td.innerHTML != "Complete"))
      {
        tr[i].style.display = "none";        
      }
      
      if((filter == "Incomplete") && (td.innerHTML != "Incomplete"))
      {
        tr[i].style.display = "none";        
      }                 
    }       
  }
  */
  
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
     
  /*
  //Replaced by MySQL filter in KACE 18789        
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) 
    {
      if (td.innerText > filter) 
      {
        //do nothing
      } 
      else if (td.innerText === filter) //if the record date and the filter date are the same
      {
        td2 = tr[i].getElementsByTagName("td")[3];
        if (td2) 
        {
          if (td2.innerText >= filter2) 
          {
            //do nothing
          } 
          else 
          {
            tr[i].style.display = "none";
          }
        }     
      }
      else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
  */
  
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
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    
    for (i = 0; i < tr.length; i++)
    {
      td = tr[i].getElementsByTagName("td")[2];
      if (td) 
      {
        if (td.innerText < filter)
        {
          //do nothing
        } 
        else if (td.innerText == filter) //if the record date and the filter date are the same
        {
          td2 = tr[i].getElementsByTagName("td")[3];
          if (td2) 
          {
            if (td2.innerText < filter2)
            {
              //do nothing
            } 
            else 
            {
              tr[i].style.display = "none";
            }
          }     
        }
        else 
        {
          tr[i].style.display = "none";
        }
      }       
    }
        
    */
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
  /*
  //Replaced by MySQL filter in KACE 18789        
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[11];
    if (td) 
    {
      if (td.innerHTML.indexOf(filter) > -1) 
      {
        //do nothing
      } else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
  */
  
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
  
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[5];
      if (td) 
      {
        if(inputsChecked.includes(td.innerHTML))// 
        {
          //do nothing
        } else 
        {        
          tr[i].style.display = "none";
        }
      }       
    }
    */
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
        
  /*
  //Replaced by MySQL filter in KACE 18789        
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[6];
    if (td) 
    {
      if (td.innerHTML.indexOf(filter) > -1) 
      {
        //do nothing
      } else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
  */
  
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
  
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[13];
      if (td) 
      {
        if(inputsChecked.includes(td.innerHTML))
        {
          //do nothing
        } else 
        {        
          tr[i].style.display = "none";
        }
      }       
    }
    */
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
        
  /*
  //Replaced by MySQL filter in KACE 18789
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[12];
    if (td) 
    {
      if (td.innerHTML.indexOf(filter) > -1) 
      {
        //do nothing
      } else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
  */
  
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
  /*
  //Replaced by MySQL filter in KACE 18789
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[14];
    if (td) 
    {
      if (td.innerHTML.indexOf(filter) > -1) 
      {
        //do nothing
      } else 
      {
        tr[i].style.display = "none";
      }
    }            
  }
  */        
  
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
  
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[8];
      if (td) 
      {
        if(inputsChecked.includes(td.innerHTML))// (td.innerHTML.indexOf(inputsChecked) > -1) 
        {
          //do nothing
        } else 
        {        
          tr[i].style.display = "none";
        }
      }       
    }
    */
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
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[37];
      if (td) 
      {
        if(inputsChecked.includes(td.innerHTML))
        {
          //do nothing
        } else 
        {        
          tr[i].style.display = "none";
        }
      }       
    }
    */
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
    
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[9];
      if (td) 
      {
        if(inputsChecked.includes(td.innerHTML))// (td.innerHTML.indexOf(inputsChecked) > -1) 
        {
          //do nothing
        } else 
        {        
          tr[i].style.display = "none";
        }
      }       
    }
    */
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
  
    /*
    //Replaced by MySQL filter in KACE 18789
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[10];
      if (td) 
      {
        if(inputsChecked.includes(td.innerHTML))// (td.innerHTML.indexOf(inputsChecked) > -1) 
        {
          //do nothing
        } else 
        {        
          tr[i].style.display = "none";
        }
      }       
    }
    */
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
  /*
  //Replaced by MySQL filter in KACE 18789
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[35];
    if (td) 
    {
      //console.log("DEBUG: td.innerHTML = " + td.innerHTML);
      if((filter == "Active") && (td.innerHTML != "A"))
      {
        tr[i].style.display = "none";        
      }
      
      if((filter == "Voided") && (td.innerHTML != "V"))
      {
        tr[i].style.display = "none";        
      }                 
    }       
  }
  */
  
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
  var countdownTime = 60 * 60 * 3;
  display = document.querySelector('#time');
  startTimer(countdownTime, display);
  tableFilter();

}

//toggle all checkboxes when the upper left is checked - modified for use with table sorting
function toggleCheckAll() 
{
  //console.log("The toggleCheckAll function was called.");
  
  var selectAllCheckBox = document.getElementById("tableHeaderCheck");  
  var wasChecked = selectAllCheckBox.checked;
  var checkboxes = document.getElementsByName('tableRowCheckbox');
  
  if(wasChecked == true)
  {
    //update the select all box
    selectAllCheckBox.checked = false;
    
    //update the other checkboxes    
    for(var i=0, n=checkboxes.length; i<n; i++) 
    {
      checkboxes[i].checked = false;
    }
  }
  else
  {
    //update the select all box
    selectAllCheckBox.checked = true;
    
    //update the other checkboxes    
    for(var i=0, n=checkboxes.length; i<n; i++) 
    {
      checkboxes[i].checked = true;
    }
  }
  
}

//read the filtered contents of the table, then add those contents to hidden form inputs IF the row's checkbox is checked
//this function gets called when the user clicks on the export button
function readTableContentsToDownload()
{
  //console.log("DEBUG: readTableContestToDownload function called!");
  var table = document.getElementById("samplesTable");
  var tempString = null;
  var rowCount = 0;
  var formInputIterator = null;
  var currentColumn = null;
  var tempCheckbox = null;
  var tempCheckboxChecked = null;

  //reset the contents of the hidden inputs
  var contentStringArray = document.getElementsByClassName("contentStringArray");
  for(var i = 0; i < contentStringArray.length; i++)
  {
     contentStringArray[i].value= null;
  }

  for (var i = 0, row; row = table.rows[i]; i++) //iterate through rows
  {
    //console.log("DEBUG: inspecting table row " + i + ". style.display = " + row.style.display);
    tempCheckbox = document.getElementById("tableRowCheckbox" + (i - 1));
    if(tempCheckbox != null)
    {
      tempCheckboxChecked = tempCheckbox.checked;
    }
    else
    {
      tempCheckboxChecked = false;
    }
    
    if((row.style.display != "none") && ((tempCheckboxChecked == true) || (i == 0))) //if the row is visible if the user checked the box for this row OR it is the header row
    {      
      if(i == 0)
      {
        tempString = row.cells[1].innerHTML; //add the first value to the temporary string - skipping the checkbox cell        
      }
      else
      {
        tempString = row.cells[1].firstChild.innerHTML; //add the first value to the temporary string - skipping the checkbox cell        
      }
      currentColumn = 2;
      //console.log("DEBUG: row.length = " + row.cells.length);
      for (var j = 2, col; col = row.cells[j]; j++) //iterate through columns starting with the second value - skipping the checkbox cell
      {
        //console.log("DEBUG: inspecting table column " + j + ". style.display = " + col.style.display + ". col.innerHTML = " + col.innerHTML);
        if(col.style.display != "none")
        {
          if(currentColumn < (row.cells.length - 3)) //skip the last three columns of the table
          {
            //add each subsequent value to the tempString
            tempString = tempString + "," + col.innerHTML;      
          }
        }
        currentColumn++;
      }
      formInputIterator = document.getElementById("downloadString" + rowCount); //get the hidden html input for this row
      formInputIterator.value = tempString; //set the value of the hidden input to the temporary string
      //console.log("DEBUG: tempString = " + tempString);
      
      rowCount++;
    }
  }
}
</script>
<script type="text/javascript">
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

  window.location='wt_samples.php?startDate=' + startDate + '&endDate=' + endDate + '&compositeType=' + compositeType + '&shift=' + shift + '&sampler=' + sampler + '&operator=' + operator + '&completionStatus=' + completionStatus + '&view=' + view + '&void=' + voidFilter + '&resultsPerPage=' + resultsPerPage + '&startRow=' + startRow + '&locationsRESTString=' + locationCSV + '&testTypesRESTString=' + testTypeCSV + '&labTechsRESTString=' + labTechCSV + '&sitesRESTString=' + siteCSV + '&plantsRESTString=' + plantCSV + '&specificLocationsRESTString=' + specificLocationCSV;
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
    
  window.location='wt_samples.php?startDate=' + startDate + '&endDate=' + endDate + '&compositeType=' + compositeType + '&shift=' + shift + '&sampler=' + sampler + '&operator=' + operator + '&completionStatus=' + completionStatus + '&view=' + view + '&void=' + voidFilter + '&resultsPerPage=' + resultsPerPage + '&startRow=' + newStartRow + '&locationsRESTString=' + locationCSV + '&testTypesRESTString=' + testTypeCSV + '&labTechsRESTString=' + labTechCSV + '&sitesRESTString=' + siteCSV + '&plantsRESTString=' + plantCSV + '&specificLocationsRESTString=' + specificLocationCSV;
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

  window.location='wt_samples.php?startDate=' + startDate + '&endDate=' + endDate + '&compositeType=' + compositeType + '&shift=' + shift + '&sampler=' + sampler + '&operator=' + operator + '&completionStatus=' + completionStatus + '&view=' + view + '&void=' + voidFilter + '&resultsPerPage=' + resultsPerPage + '&startRow=' + newStartRow + '&locationsRESTString=' + locationCSV + '&testTypesRESTString=' + testTypeCSV + '&labTechsRESTString=' + labTechCSV + '&sitesRESTString=' + siteCSV + '&plantsRESTString=' + plantCSV + '&specificLocationsRESTString=' + specificLocationCSV + '&isCOA=' + isCOA;
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
        
        //filter the table
        //tableFilter();
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
        
        //filter the table
        //tableFilter();
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





