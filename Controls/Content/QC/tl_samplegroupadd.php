<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_samplegroupadd.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 09/12/2017|mnutsch|KACE:17959 - Updated a file location reference.
 * 09/25/2014|mnutsch|KACE:17957 - Added input for selecting the number of sample groups.
 * 09/29/2017|mnutsch|KACE:17957 - Added code to clear Location checkboxes on Plant change.
 * 
 * **************************************************************************************************************************************** */

//include other files
require_once('../../Includes/QC/tl_qcfunctions.php'); //contains QC database query functions
require_once('../../Includes/security.php'); //contains user database query functions

//begin the session if it isn't already started
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

//initializing variables so that there are no warnings
$siteId = "0";
$plantId = "0";
$dt = "";
$testTypeId = "";
$compositeTypeId = "";
$labTechId = "";
$samplerId = "";
$operatorId = "";
$locationId = "0";
$locationCount = "";
$validationMessage = "";

if(isset($_GET['validationStatus']))
{
  $validationStatus = $_GET['validationStatus'];
  if($validationStatus == "fail")
  {
    $siteId = $_SESSION['siteId'];
    $plantId = $_SESSION['plantId'];
    $dt = $_SESSION['dt'];
    $testTypeId = $_SESSION['testTypeId'];
    $compositeTypeId = $_SESSION['compositeTypeId'];
    $labTechId = $_SESSION['labTech'];
    $samplerId = $_SESSION['sampler'];
    $operatorId = $_SESSION['operator'];
    $locationId = $_SESSION['locationId'];
    $locationCount = $_SESSION['locationCount'];
    $validationMessage = $_SESSION['validationMessage'];
    
    echo "<span style=\"color: red;\">***Important: " . $validationMessage . "***</span>";
  }
}

//==================================================================== BEGIN PHP
?>

<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css"> 
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>

<!-- DEV NOTE: add JS code to facilitate this form submittal. -->
<form name="main_form" id="main_form" action="../../Includes/QC/tl_qcsamplegroupadd.php" method="post">
<div id="qc_general" class="tabcontent" onclick="closeLocationBox(event);">
  <input type="hidden" name="userId" id="userId" value="<?php echo $user_id; ?>">
  
  <div class="right_content">
    <br/>
    <?php 
      //Only display the Repeatability info if the user is a lab tech
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
    <h3>Add Sample Group</h3>  
    
    <div class="form-group">
    <label for="siteId">Site:</label>
    <select name="siteId" id="siteId" required onchange="loadPlantSelect(); confirmSite(); clearSampleLocationCheckboxes();">    
      <?php 
        //If the user's permission level is less than 2 then limit their ability to select a Site.      
        if($userPermissionsArray['vista']['tolar']['qc'] < 2)
        {
          echo "<option value='50' selected='selected'>Tolar</option>"; //DEV NOTE: hardcoded value; this should be changed if the database info is not static          
        }
        else //the user has permission to change this
        {
          $siteObjectArray = getSites(); //get a list of site options
          echo("<option value=''></option>");
          foreach ($siteObjectArray as $siteObject) 
          {
            if($siteObject->vars["id"] == "50")
            {
              echo "<option value='" . $siteObject->vars["id"] . "' selected='selected'>" . $siteObject->vars["description"] . "</option>";
            }
            else 
            {
              echo "<option value='" . $siteObject->vars["id"] . "'>" . $siteObject->vars["description"] . "</option>";
            }
          }
        }
      ?>
    </select>
    </div><br/>

    <div class="plantSelect" id="plantSelect"></div>
    <br/>
    
    <div class="form-group">
      <label for="locations_button">Sample Locations:</label> 
      <button class="location_button" id="locations_button" type="button">Select Locations</button>
      <div id="location_options" class="location_options">
        <div class="locationSelect" id="locationSelect">
          <?php
            $locationObjectArray = getLocations(); //get a list of location options
            foreach ($locationObjectArray as $locationObject) 
            {
              echo "<div style='display:none;'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId' value='" . $locationObject->vars["id"] . "'>" . $locationObject->vars["description"] . "<br></div>";
            }
          ?>
        </div>        
      </div>
    </div>
    
    <div class="form-group">
    <label for="dt">Date/Time:</label> 
    <input type="text" id="dt" name="dt" value="<?php echo $dt; ?>"required /><br/><br/>
    </div>
    
    <div class="form-group">
    <label for="dt">Number of Groups:</label> 
    <input type="number" id="numberOfGroups" name="numberOfGroups" value="1" min="1" max="20" step="1" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only" /><br/><br/>
    </div>

    <div class="form-group">
    <label for="testTypeId">Test Type:</label>
    <select id="testTypeId" name="testTypeId">
    <option value=""></option>
    <?php
    $testTypeObjectArray = getTestTypes(); //get a list of testType options
    foreach ($testTypeObjectArray as $testTypeObject) 
    {
      if($testTypeObject->vars["id"] == "2")
      {
        echo "<option value='" . $testTypeObject->vars["id"] . "' selected='selected'>" . $testTypeObject->vars["description"] . "</option>";
      }
      else 
      {
        echo "<option value='" . $testTypeObject->vars["id"] . "'>" . $testTypeObject->vars["description"] . "</option>";
      }
    }
    ?>
    </select>
    </div><br/>

    <div class="form-group">
    <label for="compositeTypeId">Composite Type:</label> 
    <select id="compositeTypeId" name="compositeTypeId">
    <option value=""></option>
    <?php
    $compositeTypeObjectArray = getCompositeTypes(); //get a list of Composite Type options
    foreach ($compositeTypeObjectArray as $compositeTypeObject) 
    {
      if($compositeTypeObject->vars["id"] == "1")
      {
        echo "<option value='" . $compositeTypeObject->vars["id"] . "' selected='selected'>" . $compositeTypeObject->vars["description"] . "</option>";
      }
      else 
      {
        echo "<option value='" . $compositeTypeObject->vars["id"] . "'>" . $compositeTypeObject->vars["description"] . "</option>";
      }
    }
    ?>
    <select>
    </div><br/>

    <div class="form-group">
      <label for="labTech">Lab Tech:</label> 
      <select id="labTech" name="labTech" >

        <?php 
          $userObjectArray = getLabTechs(); //get a list of users, requires security.php

          //If the user's permission level is less than 3 then limit their ability to select a Lab Tech.      
          if($userPermissionsArray['vista']['granbury']['qc'] < 3)
          {
            //find the record that matches the logged in user and display that
            foreach ($userObjectArray as $userObject) 
            {
              if($userObject->vars["id"] == $user_id) 
              {
                echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
              }
            } 
          }
          else //the user has permission to change this
          {
            echo('<option value=""></option>');
            //display all records
            foreach ($userObjectArray as $userObject) 
            {
              if($userObject->vars["id"] == $sampleObject->vars['labTech'])
              {
                echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
              }
              else 
              {
                echo "<option value='" . $userObject->vars["id"] . "'>" . $userObject->vars["display_name"] . "</option>";
              }
            }
          }
        ?>
      </select>  
    </div>
    <br/>

    <div class="form-group">
    <label for="sampler">Sampler:</label> 
    <select id="sampler" name="sampler">
    <option value=""></option>
    <?php
    $optionObjectArray = getSamplers(); 
    foreach ($optionObjectArray as $optionObject) 
    {
      if($optionObject->vars["id"] == $samplerId)
      {
        echo "<option value='" . $optionObject->vars["id"] . "' selected='selected'>" . $optionObject->vars["display_name"] . "</option>";
      }
      else 
      {
        echo "<option value='" . $optionObject->vars["id"] . "'>" . $optionObject->vars["display_name"] . "</option>";
      }
    }
    ?>
    </select>
    </div><br/>

    <div class="form-group">
    <label for="operator">Operator:</label> 
    <select id="operator" name="operator">
    <option value=""></option>
    <?php
    $optionObjectArray = getOperators(); 
    foreach ($optionObjectArray as $optionObject) 
    {
      if($optionObject->vars["id"] == $operatorId)
      {
        echo "<option value='" . $optionObject->vars["id"] . "' selected='selected'>" . $optionObject->vars["display_name"] . "</option>";
      }
      else 
      {
        echo "<option value='" . $optionObject->vars["id"] . "'>" . $optionObject->vars["display_name"] . "</option>";
      }
    }
    ?>
    </select>
    </div>
    <br/>

    <br/>
    <input type="submit" value="Save">
    </form>
  </div> <!-- Left Content  -->
</div>
<script>
$(function() 
{
 $("#dt").datetimepicker(
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
      $('#dt').val(datetext);
    },
  });
  
});
</script>
<script>
  
//initialize the select and checkboxes in order of dependency
function initialLoad()
{
  loadPlantSelect();
}

//load the options when the window loads
document.getElementsByTagName('body')[0].onload = initialLoad();

//populate the select box for Plant
function loadPlantSelect()
{
  //console.log("DEBUG: loadPlantSelect function called!");
  
  //get the value from the select box
  var siteId = document.getElementById("siteId").value;

  if(siteId.length > 0)
  {
    //update the values
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() 
    {
      if (this.readyState == 4 && this.status == 200) 
      {
        document.getElementById("plantSelect").innerHTML = this.responseText; 
        loadLocationSelect();
      }
    }
    
    //console.log("DEBUG: the site is "+siteId);
    
    //get the content
    xmlhttp2.open("GET", "../../Includes/QC/tl_plantsselectbysite.php?siteId="+siteId+"&plantId="+<?php echo $plantId; ?>, true);
    xmlhttp2.send();
      
  }
    
}

function filterLocations(arrayOfValidLocationsAsCSV)
{
  //console.log("filterLocations called!");
  var arrayOfLocationsCheckboxes = null;
  var j;
  var k;
  var len;
  var len2;
  var isInArray = false;
  var arrayOfValidLocations;

  arrayOfLocationsCheckboxes = document.getElementsByClassName("locationId");
  
  arrayOfValidLocations = arrayOfValidLocationsAsCSV.split(",");
  
  console.log("DEBUG: arrayOfValidLocationsAsCSV = " + arrayOfValidLocationsAsCSV);
  
  //dump(arrayOfLocationsCheckboxes); //display the details in console for debug
  
  console.log("DEBUG: arrayOfLocationsCheckboxes.length = " + arrayOfLocationsCheckboxes.length);
  console.log("DEBUG: arrayOfValidLocations.length = " + arrayOfValidLocations.length);
  
  //for each checkbox
  for (j = 0; j < arrayOfLocationsCheckboxes.length; j++)
  {
    //set the checkbox to dhide by default
    arrayOfLocationsCheckboxes[j].parentNode.style.display = "none";
    
    //console.log(arrayOfLocationsCheckboxes[j].value);
   
    //check if this item is in the array of locations for this plant. hide if not
    isInArray = false;
    for (k = 0; k < arrayOfValidLocations.length; k++)
    {
      console.log("Checking if "+arrayOfLocationsCheckboxes[j].value+" is equal to "+arrayOfValidLocations[k]);
      if(arrayOfValidLocations[k] == arrayOfLocationsCheckboxes[j].value)
      {
        console.log("This is a match, displaying the item.")
        isInArray = true;
        //display the item
        arrayOfLocationsCheckboxes[j].parentNode.style.display = "block";
      }
    }
   
  }
  
}

//populate the select box for Location
function loadLocationSelect()
{
  //console.log("DEBUG: loadLocationSelect() function called!");
  
  //get the value from the select box
  var plantId = document.getElementById("plantId").value;

  if(plantId.length > 0)
  {
    //update the values
    var xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() 
    {
      if (this.readyState == 4 && this.status == 200) 
      {      
        //console.log(this.responseText);
        filterLocations(this.responseText); //filter the checkbox options
      }
    }
    
    //get the content
    xmlhttp2.open("GET", "../../Includes/QC/tl_locationslistbyplant.php?plantId="+plantId+"&locationId="+<?php echo $locationId; ?>, true);
    xmlhttp2.send();
    
  }
  
}
  
//functionality for toggling the location accordion box based on the button
var acc = document.getElementsByClassName("location_button");
var i;

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
      } 
    }
  }

//functionality to close the location accordion box when clicking outside the box
function closeLocationBox(e)
{
  var acc = document.getElementsByClassName("location_button");
  var i;

  var locationSelectBox = document.getElementById("location_options");
  
  if(e.target.id != "location_options")
  {
    if(e.target.id != "locations_button")
    {
      if(e.target.id != "locationId[]")
      {
        locationSelectBox.style.maxHeight = null;
        locationSelectBox.style.visibility = "hidden";
      }
    }
  }
}

//used in debug. source: https://stackoverflow.com/questions/323517/is-there-an-equivalent-for-var-dump-php-in-javascript
function dump(obj) 
{
    var out = '';
    for (var i in obj) 
    {
        out += i + ": " + obj[i] + "\n";
    }

    console.log(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}

//Ask the user to confirm that they want to select a different site.
function confirmSite()
{
  var siteIDSelected = "";
  siteIDSelected = document.getElementById("siteId").value;
 
  if(siteIDSelected != 50)
  {
    confirm("The Site is not set to Tolar. Are you sure?");
  }
}

//Uncheck all Sample Location checkboxes.
//This is necessary to avoid errors that would occur when the user changes Plant after selecting Locations.
function clearSampleLocationCheckboxes()
{
  //console.log("clearSampleLocationCheckboxes() function called.");
  
  var checkboxes = document.getElementsByClassName('locationId');  
  for(var i=0; i < checkboxes.length; i++) 
  {
    checkboxes[i].checked = false;
  }
}
</script>
<?php
//====================================================================== END PHP
?>

<!-- HTML -->





