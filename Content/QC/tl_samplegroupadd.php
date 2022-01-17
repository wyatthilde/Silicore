<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_samplegroupadd.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 0?/0?/2017|mnutsch|KACE:xxxxx - Initial creation
 * 06/29/2017|mnutsch|KACE:17366 - Continued development
 * 07/20/2017|mnutsch|KACE:17366 - Added permission specific limitations to functionality.
 * 08/03/2017|mnutsch|KACE:17916 - Added user permission specific limitation on changing the Lab Tech.
 * 08/15/2017|kkuehn|KACE:xxxxx - reverted all references to vprop back to vista
 * 08/25/2017|mnutsch|KACE:17957 - Updated options for site selection for low permission level users.
 * 09/14/2017|mnutsch|KACE:17957 - Updated file location and name references.
 * 09/25/2017|mnutsch|KACE:17957 - Added input for selecting the number of sample groups.
 * 09/29/2017|mnutsch|KACE:17957 - Added code to clear Location checkboxes on Plant change.
 * 02/08/2018|mnutsch|KACE:20160 - Limited user's ability to select dates or times in the future.
 * 02/14/2018|mnutsch|KACE:20927 - I fixed a bug where the Lab Tech should have defaulted to the signed in user.
 * 
 * **************************************************************************************************************************************** */

//include other files
require_once('../../Includes/QC/tl_qcfunctions.php'); //contains QC database query functions
require_once('../../Includes/security.php'); //contains user database query functions

//begin the session if it isn't already started
if (session_id() == '' || !isset($_SESSION)) {
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

if (isset($_GET['validationStatus'])) {
    $validationStatus = $_GET['validationStatus'];
    if ($validationStatus == "fail") {
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
<style>
    .scroll {
        min-height: 25px;
        max-height: 200px;
        overflow: auto;
    }
</style>
<form name="main_form" id="main_form" action="../../Includes/QC/tl_qcsamplegroupadd.php" onsubmit="return validateForm()" method="post">
    <input type="hidden" name="userId" id="userId" value="<?php echo $user_id; ?>">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="form-row">
                    <div class="form-group col-xl-6">
                        <h3>Add Sample Group</h3>
                    </div>
                    <div class="form-group col-xl-6">
                            <h5><span class="float-right badge badge-info rounded-0 th-vprop-blue-medium">
                            <?php
                            //Only display the Repeatability info if the user is a lab tech
                            $labTechArray = NULL;
                            $labTechArray = getLabTechs();
                            $userIsLabTech = 0;
                            //echo("DEBUG: labtechs:<br/>");
                            for ($i = 0; $i < count($labTechArray); $i++) {
                                //echo($labTechArray[$i]->vars['id'] . ". " . $labTechArray[$i]->vars['display_name'] . "<br/>");
                                if ($user_id == $labTechArray[$i]->vars['id']) {
                                    //echo("DEBUG: User is a labtech!<br/>");
                                    $userIsLabTech = 1;
                                }
                            }
                            if ($userIsLabTech == 1) {
                                echo("Repeatability Counter: " . getRepeatabilityByUserId($user_id)); //requires qcfunctions.php);
                            }
                            ?></span></h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-xl-12">
                        <label for="siteId">Site:</label>
                        <select class="form-control" name="siteId" id="siteId" required onchange="loadPlantSelect(); confirmSite(); clearSampleLocationCheckboxes();">
                            <?php
                            //If the user's permission level is less than 2 then limit their ability to select a Site.
                            if ($userPermissionsArray['vista']['tolar']['qc'] < 2) {
                                echo "<option value='50' selected='selected'>Tolar</option>"; //DEV NOTE: hardcoded values; these should be changed if the database info is not static
                            } else //the user has permission to change this
                            {
                                $siteObjectArray = getSites(); //get a list of site options
                                echo("<option value=''></option>");
                                foreach ($siteObjectArray as $siteObject) {
                                    if ($siteObject->vars["id"] == "50") {
                                        echo "<option value='" . $siteObject->vars["id"] . "' selected='selected'>" . $siteObject->vars["description"] . "</option>";
                                    } else {
                                        echo "<option value='" . $siteObject->vars["id"] . "'>" . $siteObject->vars["description"] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <div class="plantSelect" id="plantSelect"></div>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="locations_button">Sample Locations:</label>

                        <div id="location_options" class="bg-light scroll">
                            <div class="locationSelect" id="locationSelect">
                                <?php
                                $locationObjectArray = getLocations(); //get a list of location options
                                foreach ($locationObjectArray as $locationObject) {
                                    echo "<div style='display:none;' class='form-control border-0 bg-light'><input type='checkbox' name='locationId[]' id='locationId[]' class='locationId form-check-inline' value='" . $locationObject->vars["id"] . "'>" . $locationObject->vars["description"] . "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="dt">Date/Time:</label>
                        <input class="form-control" type="text" id="dt" name="dt" value="<?php echo $dt; ?>" autocomplete="off" required/>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="numberOfGroups">Number of Groups:</label>
                        <input class="form-control" type="number" id="numberOfGroups" name="numberOfGroups" value="1" min="1" max="20" step="1" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only"/>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="testTypeId">Test Type:</label>
                        <select class="form-control" id="testTypeId" name="testTypeId" required>
                            <option value=""></option>
                            <?php
                            $testTypeObjectArray = getTestTypes(); //get a list of testType options
                            foreach ($testTypeObjectArray as $testTypeObject) {
                                if ($testTypeObject->vars["id"] == "2") {
                                    echo "<option value='" . $testTypeObject->vars["id"] . "' selected='selected'>" . $testTypeObject->vars["description"] . "</option>";
                                } else {
                                    echo "<option value='" . $testTypeObject->vars["id"] . "'>" . $testTypeObject->vars["description"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="compositeTypeId">Composite Type:</label>
                        <select class="form-control" id="compositeTypeId" name="compositeTypeId" required>
                            <option value=""></option>
                            <?php
                            $compositeTypeObjectArray = getCompositeTypes(); //get a list of Composite Type options
                            foreach ($compositeTypeObjectArray as $compositeTypeObject) {
                                if ($compositeTypeObject->vars["id"] == "1") {
                                    echo "<option value='" . $compositeTypeObject->vars["id"] . "' selected='selected'>" . $compositeTypeObject->vars["description"] . "</option>";
                                } else {
                                    echo "<option value='" . $compositeTypeObject->vars["id"] . "'>" . $compositeTypeObject->vars["description"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="labTech">Lab Tech:</label>
                        <select class="form-control" id="labTech" name="labTech" required>

                            <?php
                            $userObjectArray = getLabTechs(); //get a list of users, requires security.php

                            //If the user's permission level is less than 3 then limit their ability to select a Lab Tech.
                            if ($userPermissionsArray['vista']['tolar']['qc'] < 3) {
                                //find the record that matches the logged in user and display that
                                foreach ($userObjectArray as $userObject) {
                                    if ($userObject->vars["id"] == $user_id) {
                                        echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
                                    }
                                }
                            } else //the user has permission to change this
                            {
                                echo('<option value=""></option>');
                                //display all records
                                foreach ($userObjectArray as $userObject) {
                                    if ($userObject->vars["id"] == $user_id) {
                                        echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
                                    } else {
                                        echo "<option value='" . $userObject->vars["id"] . "'>" . $userObject->vars["display_name"] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="sampler">Sampler:</label>
                        <select class="form-control" id="sampler" name="sampler" required>
                            <option value=""></option>
                            <?php
                            $optionObjectArray = getSamplers();
                            foreach ($optionObjectArray as $optionObject) {
                                if ($optionObject->vars["id"] == $samplerId) {
                                    echo "<option value='" . $optionObject->vars["id"] . "' selected='selected'>" . $optionObject->vars["display_name"] . "</option>";
                                } else {
                                    echo "<option value='" . $optionObject->vars["id"] . "'>" . $optionObject->vars["display_name"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="operator">Operator:</label>
                        <select class="form-control" id="operator" name="operator" required>
                            <option value=""></option>
                            <?php
                            $optionObjectArray = getOperators();
                            foreach ($optionObjectArray as $optionObject) {
                                if ($optionObject->vars["id"] == $operatorId) {
                                    echo "<option value='" . $optionObject->vars["id"] . "' selected='selected'>" . $optionObject->vars["display_name"] . "</option>";
                                } else {
                                    echo "<option value='" . $optionObject->vars["id"] . "'>" . $optionObject->vars["display_name"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-vprop-green float-right" value="Save Sample">
            </div>
        </div>
</form>
<script>
    $(function () {
        $("#dt").datetimepicker(
            {
                format: 'Y-m-d H:i',
                //dateFormat: 'yy-mm-dd',
                onSelect: function (datetext) {
                    var d = new Date(); // for now

                    var h = d.getHours();
                    h = (h < 10) ? ("0" + h) : h;

                    var m = d.getMinutes();
                    m = (m < 10) ? ("0" + m) : m;

                    var s = d.getSeconds();
                    s = (s < 10) ? ("0" + s) : s;

                    datetext = datetext + " " + h + ":" + m + ":" + s;
                    $('#dt').val(datetext);
                },
                maxTime: 0,
                maxDate: 0
            });

    });
</script>
<script>

    //initialize the select and checkboxes in order of dependency
    function initialLoad() {
        loadPlantSelect();
    }

    //load the options when the window loads
    document.getElementsByTagName('body')[0].onload = initialLoad();

    //populate the select box for Plant
    function loadPlantSelect() {
        //console.log("DEBUG: loadPlantSelect function called!");

        //get the value from the select box
        var siteId = document.getElementById("siteId").value;

        if (siteId.length > 0) {
            //update the values
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("plantSelect").innerHTML = this.responseText;
                    loadLocationSelect();
                }
            }

            //console.log("DEBUG: the site is "+siteId);

            //get the content
            xmlhttp2.open("GET", "../../Includes/QC/tl_plantsselectbysite.php?siteId=" + siteId + "&plantId=" +<?php echo $plantId; ?>, true);
            xmlhttp2.send();

        }

    }

    function filterLocations(arrayOfValidLocationsAsCSV) {
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

        //dump(arrayOfLocationsCheckboxes); //display the details in console for debug

        //for each checkbox
        for (j = 0; j < arrayOfLocationsCheckboxes.length; j++) {
            //set the checkbox to display by default
            arrayOfLocationsCheckboxes[j].parentNode.style.display = "block";

            //console.log(arrayOfLocationsCheckboxes[j].value);

            //check if this item is in the array of locations for this plant. hide if not
            isInArray = false;
            for (k = 0; k < arrayOfValidLocations.length; k++) {
                //console.log("Checking if "+arrayOfLocationsCheckboxes[j].value+" is equal to "+arrayOfValidLocations[k]);
                if (arrayOfValidLocations[k] == arrayOfLocationsCheckboxes[j].value) {
                    //console.log("This is a match, displaying the item.")
                    isInArray = true;
                }
            }
            //hide the item if it is not in the array
            if (isInArray == false) {
                arrayOfLocationsCheckboxes[j].parentNode.style.display = "none";
            }
        }

    }

    //populate the select box for Location
    function loadLocationSelect() {
        //console.log("DEBUG: loadLocationSelect() function called!");

        //get the value from the select box
        var plantId = document.getElementById("plantId").value;

        if (plantId.length > 0) {
            //update the values
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);
                    filterLocations(this.responseText); //filter the checkbox options
                }
            }

            //get the content
            xmlhttp2.open("GET", "../../Includes/QC/tl_locationslistbyplant.php?plantId=" + plantId + "&locationId=" +<?php echo $locationId; ?>, true);
            xmlhttp2.send();

        }

    }

    //functionality for toggling the location accordion box based on the button
    $(document).ready(function(){
        /*$('#locations_button').on('click', function(){
            $('#location_options').toggle('slow');
        });*/
    });



    //functionality to close the location accordion box when clicking outside the box
    function closeLocationBox(e) {
        var acc = document.getElementsByClassName("location_button");
        var i;

        var locationSelectBox = document.getElementById("location_options");

        if (e.target.id != "location_options") {
            if (e.target.id != "locations_button") {
                if (e.target.id != "locationId[]") {
                    /*                    locationSelectBox.style.maxHeight = null;
                                        locationSelectBox.style.visibility = "hidden";*/
                }
            }
        }
    }

    //used in debug. source: https://stackoverflow.com/questions/323517/is-there-an-equivalent-for-var-dump-php-in-javascript
    function dump(obj) {
        var out = '';
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }

        console.log(out);

        // or, if you wanted to avoid alerts...

        var pre = document.createElement('pre');
        pre.innerHTML = out;
        document.body.appendChild(pre)
    }

    //Ask the user to confirm that they want to select a different site.
    function confirmSite() {
        var siteIDSelected = "";
        siteIDSelected = document.getElementById("siteId").value;

        if (siteIDSelected != 50) {
            confirm("The Site is not set to Tolar. Are you sure?");
        }
    }

    //Uncheck all Sample Location checkboxes.
    //This is necessary to avoid errors that would occur when the user changes Plant after selecting Locations.
    function clearSampleLocationCheckboxes() {
        //console.log("clearSampleLocationCheckboxes() function called.");

        var checkboxes = document.getElementsByClassName('locationId');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }

    //perform additional form validation using JavaScript
    function validateForm() {
        //make sure that user doesn't type in a date time in the future
        var inputString = document.forms["main_form"]["dt"].value;
        var inputDt = new Date(inputString);
        var currentDt = new Date();
        if (inputDt > currentDt) {
            alert("The Date/Time cannot be in the future.");
            return false;
        }

        //make sure that at least one Sample Location checkbox was checked
        var locationButtons = document.getElementsByClassName("locationId");
        var i;
        var locationSelected = 0;
        for (i = 0; i < locationButtons.length; i++) {
            if (locationButtons[i].checked) {
                locationSelected = 1;
            }
        }
        if (locationSelected == 0) {
            alert("A Sample Location must be selected.");
            return false;
        }

        //note all other input validation is performed as HTML5 validation
    }
</script>
<?php
//====================================================================== END PHP
?>

<!-- HTML -->





