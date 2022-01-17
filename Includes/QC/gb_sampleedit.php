<?php
/* * *****************************************************************************************************************************************
 * File Name: sampleedit.php
 * Project: Silicore
 * Description: This file allows the user to edit QC sample details.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 0?/0?/2017|mnutsch|KACE:? - Initial creation
 * 06/23/2017|mnutsch|KACE:17366 - Added new functionality
 * 07/10/2017|mnutsch|KACE:17366 - Continued development.
 * 07/11/2017|mnutsch|KACE:17366 - Continued development.
 * 07/14/2017|mnutsch|KACE:17366 - Added new functionality around saving all K Values input.
 * 07/17/2017|mnutsch|KACE:17366 - Added new functionality around additional Core Sample fields.
 * 07/18/2017|mnutsch|KACE:17366 - Updated value rounding in the Sieve section JavaScript.
 * 07/19/2017|mnutsch|KACE:17366 - Added REST variables to the redirect link.
 * 07/20/2017|mnutsch|KACE:17366 - Added permission specific limitations to functionality.
 * 07/21/2017|mnutsch|KACE:17366 - Added an additional Sieve range calculation.
 * 07/21/2017|mnutsch|KACE:17366 - Added rounding of a field to correct a JavaScript of form submit.
 * 08/01/2017|mnutsch|KACE:17717 - Added new functionality to dynamically call Sieve Stack select box.
 * 08/03/2017|mnutsch|KACE:17803 - Updated core sample filtering options and modified a permission.
 * 08/04/2017|mnutsch|KACE:17803 - Corrected formula for field negOneForty
 * 08/07/2017|mnutsch|KACE:17803 - Added various types of validation and formatting changes
 * 08/09/2017|mnutsch|KACE:17803 - Updated JavaScript code.
 * 08/10/2017|mnutsch|KACE:17803 - Fixed rounding in the Moisture Rate.
 * 08/11/2017|mnutsch|KACE:17916 - Numerous updates.
 * 08/11/2017|mnutsch|KACE:17916 - Modified redirect parameter.
 * 08/14/2017|mnutsch|KACE:xxxxx - reverted if is_camsizer functionality.
 * 08/15/2017|mnutsch|KACE:17978 - fixed bugs involving wet weights and sample description.
 * 08/15/2017|kkuehn|KACE:xxxxx - reverted all references to vprop back to vista
 * 08/15/2017|mnutsch|KACE:17957 - Added a function call on page load to resolve an issue with final weight %'s displaying.
 * 08/18/2017|mnutsch|KACE:17957 - Added read only Sample Locatoin and Date/Time fields at the top of the page.
 * 08/24/2017|mnutsch|KACE:17957 - Added code to account for differences in capitalization of the screen description "pan".
 * 08/24/2017|mnutsch|KACE:17957 - Added code so that the user can manually specify the Moisture Rate.
 * 08/25/2017|mnutsch|KACE:17957 - Updated options for site selection for low permission level users.
 * 08/30/2017|mnutsch|KACE:xxxxx - Changed disabled fields to readonly, so that their values will save in the database.
 * 08/31/2017|mnutsch|KACE:17957 - Added rounding to the Ore Percent field.
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 10/20/2017|mnutsch|KACE:19207 - Updated Display property for the New Split field.
 * 10/25/2017|mnutsch|KACE:xxxxx - Added label and formatting div to New Split Weight.
 * 11/02/2017|mnutsch|KACE:19025 - Added the changeBlankSieveRangesToNA and cleaned up comments on functions.
 * 11/06/2017|mnutsch|KACE:18964 - Rearranged input field locations.
 * 11/14/2017|mnutsch|KACE:19022 - Added ore percent.
 * 11/20/2017|mnutsch|KACE:19628 - Corrected REST parameter in URL redirect.
 * 11/20/2017|mnutsch|KACE:19629 - Modified the calculation of Slimes Percent.
 * 11/21/2017|mnutsch|KACE:19626 - Changed the calculation of Oversize Percent.
 * 11/21/2017|mnutsch|KACE:19627 - Reviewed the calculation of Percent Final.
 * 11/28/2017|mnutsch|KACE:19709 - Cleaned up <div> indentations.
 * 11/29/2017|mnutsch|KACE:19500 - Hardcoded the REST variable void=A for redirects to samples.php.
 * 12/05/2017|mnutsch|KACE:19817 - Added callbacks and a timeout to make sure that JavaScript functions run in the correct order.
 * 01/19/2018|mnutsch|KACE:20439 - Fixed a bug found while working on an unrelated feature.
 * 01/25/2018|mnutsch|KACE:20305 - Added the field Near Size.
 * 01/26/2018|mnutsch|KACE:20305 - Aded Near Size calculation code.
 * 02/08/2018|mnutsch|KACE:20160 - Limited user's ability to select dates or times in the future.
 * 02/09/2018|mnutsch|KACE:20156 - Added nuance to the calculation of the "PAN" Final Percentage.
 * 02/19/2018|mnutsch|KACE:21266 - Fixed a bug related to saving K Values.
 * 
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

//include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains QC database query functions
require_once('../../Includes/Security/database.php');
$db = new Database();


//if there is not a sample ID set, then redirect the user to the samples page
$sampleId = "";
if (isset($_GET['sampleId'])) {
    $sampleId = test_input($_GET['sampleId']);
}
$sampleObject = NULL;
if (strlen($sampleId) == 0) {

    echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/gb_samples.php?void=A&view=summary&completionStatus=0\";</script>"; //using JS, because output is already sent in header.php
} else {
    $sampleObject = getSampleById($sampleId);

    if (isset($sampleObject->vars['plantId']) == false) {
        $sampleObject->vars['plantId'] = 0;
    }
    if (isset($sampleObject->vars['location']) == false) {
        $sampleObject->vars['location'] = 0;
    }
    if (isset($sampleObject->vars['specificLocation']) == false) {
        $sampleObject->vars['specificLocation'] = 0;
    }
}
$sampleRepeatCheckQuery = 'sp_gb_qc_SampleRepeatCheck("' . $sampleId . '");';
$repeatCheck = json_decode($db->get($sampleRepeatCheckQuery))[0];
if ($repeatCheck !== null) {
    if ($repeatCheck->is_repeat_process == 1) {
        if ($repeatCheck->is_repeat_labtech != $_SESSION['user_id']) {
            echo('This sample can only be edited by the original labtech <br>');
            echo('<a href="#" onClick="window.history.back();">Go Back to Samples</a>');
            exit();
        }
    }
}
if (checkIfSampleIsComplete($sampleId) == 1) {
    $sampleObject = getSampleById($sampleId);
    if ($sampleObject->vars['testType'] !== 6) {
        $query = 'sp_gb_qc_RepeatabilitySamplePairsGetByOriginalSample("' . $sampleId . '")';
        $result = json_decode($db->get($query))[0];
        if ($result !== '0') {
            //echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/gb_sampleview.php?sampleId=" . $sampleId . "\";</script>"; //using JS, because output is already sent in header.php

        }
    } else {
        $query = 'sp_gb_qc_RepeatabilitySamplePairsGetByRepeatedSample("' . $sampleId . '")';
        $result = json_decode($db->get($query))[0];
        if ($result !== '0') {
            //echo "<script type=\"text/javascript\">window.location = \"../../Controls/QC/gb_sampleview.php?sampleId=" . $sampleId . "\";</script>"; //using JS, because output is already sent in header.php

        }
    }
}


?>
<!--<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">-->
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css">
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>
<nav>
    <div class="nav nav-tabs nav-justified">
        <a class=" tablinks nav-item nav-link active " onclick="openTab(event, 'qc_general')">General</a>
        <a class=" tablinks nav-item nav-link " onclick="openTab(event, 'qc_characteristics')">Characteristics</a>
        <a class="tablinks nav-item nav-link " onclick="openTab(event, 'qc_plant_settings')">Plant Settings</a>
    </div>
    <div class="nav nav-justified center">
        Location: <span id="sampleLocationSpan"></span>;
        DateTime: <span id="dateTimeSpan"></span>
    </div>
</nav>

<div class="container" style="max-width:85%;">
    <form id="qcForm" name="qcForm" action="../../Includes/QC/gb_sampleeditprocess.php" onsubmit="return validateForm()"
          method="post" autocomplete="off">
        <input type="hidden" name="userId" id="userId" value="<?php echo $user_id; ?>">
        <input type="hidden" name="sampleId" value="<?php echo $sampleId; ?>">
        <div id="qc_general" class="tabcontent">
            <div class="jumbotron" style="background-color:white;">

                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <h4>General</h4>
                    </div>
                    <div class="form-group col-lg-4"></div>
                    <div class="form-group col-lg-2">
                        <button id="minMaxBtn" class="btn btn-vprop-blue-medium" type="button" style="float:right;">Hide
                            Form
                        </button>
                    </div>
                </div>
                <div id="form-content">
                    <div class="form-row">
                        <div class="form-group col-lg-2">
                            <label for="siteId">Site:</label>
                            <select class="form-control" name='siteId' id='siteId'
                                    onchange='loadPlantSelect();loadSieveStackSelect(); confirmSite();'>
                                <?php
                                //If the user's permission level is less than 2 then limit their ability to select a Site.
                                if ($userPermissionsArray['vista']['granbury']['qc'] < 2) {
                                    echo "<option value='10' selected='selected'>Granbury</option>"; //DEV NOTE: hardcoded values; these should be changed if the database info is not static
                                    echo "<option value='20'>Cresson</option>"; //DEV NOTE: hardcoded values; these should be changed if the database info is not static
                                } else //the user has permission to change this
                                {
                                    $siteObjectArray = getSites(); //get a list of site options
                                    echo("<option value=''></option>");
                                    foreach ($siteObjectArray as $siteObject) {
                                        if (($sampleObject->vars['siteId'] == NULL) || ($sampleObject->vars['siteId'] == "")) //if there isn't a site saved in the sample record
                                        {
                                            if ($siteObject->vars["id"] == "10") //match the site to Granbury
                                            {
                                                echo "<option value='" . $siteObject->vars["id"] . "' selected='selected'>" . $siteObject->vars["description"] . "</option>";
                                            } else {
                                                echo "<option value='" . $siteObject->vars["id"] . "'>" . $siteObject->vars["description"] . "</option>";
                                            }
                                        } else {
                                            if ($siteObject->vars["id"] == $sampleObject->vars['siteId']) //match the site to the id saved in the sample record
                                            {
                                                echo "<option value='" . $siteObject->vars["id"] . "' selected='selected'>" . $siteObject->vars["description"] . "</option>";
                                            } else {
                                                echo "<option value='" . $siteObject->vars["id"] . "'>" . $siteObject->vars["description"] . "</option>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <div class="plantSelect" id="plantSelect"></div>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="locationSelect">Location:</label>
                            <div class="locationSelect" id="locationSelect"></div>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="specificLocationSelect">Specific Location:</label>
                            <div class="specificLocationSelect" id="specificLocationSelect"></div>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="dt">DateTime:</label>
                            <input type="text" class="form-control" id="dt" name="dt"
                                   value="<?php if (isset($sampleObject->vars['dt'])) {
                                       echo $sampleObject->vars['dt'];
                                   } ?>" onchange="updateDateTimeSpan();">
                        </div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2">
                            <label for="labTech">Lab Tech:</label>
                            <select class="form-control" id="labTech" name="labTech" required>
                                <?php
                                $userObjectArray = getLabTechs(); //get a list of users, requires security.php
                                //If the user's permission level is less than 3 then limit their ability to select a Lab Tech.
                                if ($userPermissionsArray['vista']['granbury']['qc'] < 3) {
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
                                        if ($userObject->vars["id"] == $sampleObject->vars['labTech']) {
                                            echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
                                        } else {
                                            echo "<option value='" . $userObject->vars["id"] . "'>" . $userObject->vars["display_name"] . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="sampler">Sampler:</label>
                            <select class="form-control" id="sampler" name="sampler" required>
                                <option value=""></option>
                                <?php
                                $userObjectArray = getSamplers(); //get a list of users, requires security.php
                                foreach ($userObjectArray as $userObject) {
                                    if ($userObject->vars["id"] == $sampleObject->vars['sampler']) {
                                        echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
                                    } else {
                                        echo "<option value='" . $userObject->vars["id"] . "'>" . $userObject->vars["display_name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group col-lg-2">
                            <label for="operator">Operator:</label>
                            <select class="form-control" id="operator" name="operator" required>
                                <option value=""></option>
                                <?php
                                $userObjectArray = getOperators(); //get a list of users, requires security.php
                                foreach ($userObjectArray as $userObject) {
                                    if ($userObject->vars["id"] == $sampleObject->vars['operator']) {
                                        echo "<option value='" . $userObject->vars["id"] . "' selected='selected'>" . $userObject->vars["display_name"] . "</option>";
                                    } else {
                                        echo "<option value='" . $userObject->vars["id"] . "'>" . $userObject->vars["display_name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2">
                            <label for="testTypeId">Test Type:</label>
                            <select class="form-control" id="testTypeId" name="testTypeId">
                                <option value=""></option>
                                <?php
                                $testTypeObjectArray = getTestTypes(); //get a list of testType options
                                foreach ($testTypeObjectArray as $testTypeObject) {
                                    if ($testTypeObject->vars["id"] == $sampleObject->vars['testType']) {
                                        echo "<option value='" . $testTypeObject->vars["id"] . "' selected='selected'>" . $testTypeObject->vars["description"] . "</option>";
                                    } else {
                                        echo "<option value='" . $testTypeObject->vars["id"] . "'>" . $testTypeObject->vars["description"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="compositeTypeId">Composite Type:</label>
                            <select class="form-control" id="compositeTypeId" name="compositeTypeId">
                                <option value=""></option>
                                <?php
                                $compositeTypeObjectArray = getCompositeTypes(); //get a list of testType options
                                foreach ($compositeTypeObjectArray as $compositeTypeObject) {
                                    if ($compositeTypeObject->vars["id"] == $sampleObject->vars['compositeType']) {
                                        echo "<option value='" . $compositeTypeObject->vars["id"] . "' selected='selected'>" . $compositeTypeObject->vars["description"] . "</option>";
                                    } else {
                                        echo "<option value='" . $compositeTypeObject->vars["id"] . "'>" . $compositeTypeObject->vars["description"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="sieveStackSelect">Sieve Stack:</label>
                            <div class="sieveStackSelect" id="sieveStackSelect"></div>
                        </div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2" id="beginningWetWeightWrapper">
                            <label for="beginningWetWeight" id="beginningWetWeightLabel">Beginning Wet Weight
                                (g):</label>
                            <input class="form-control" type="number" step="0.1" max="99999" id="beginningWetWeight"
                                   name="beginningWetWeight"
                                   value="<?php echo $sampleObject->vars['beginningWetWeight']; ?>"
                                   onchange="setLostValues(); calculateMoistureRate();">
                        </div>
                        <div class="form-group col-lg-2" id="preWashDryWeightWrapper">
                            <label for="preWashDryWeight" id="preWashDryWeightLabel">Pre-Wash Dry Weight (g):</label>
                            <input class="form-control" type="number" step="0.1" max="99999" id="preWashDryWeight"
                                   name="preWashDryWeight"
                                   value="<?php echo $sampleObject->vars['preWashDryWeight']; ?>"
                                   onchange="setLostValues(); calculateMoistureRate(); calculateOrePercent(); updateOversizePercent();">
                        </div>
                        <div class="form-group col-lg-2" id="postWashDryWeightWrapper">
                            <label for="postWashDryWeight" id="postWashDryWeightLabel">Post-Wash Dry Weight (g):</label>
                            <input class="form-control" type="number" step="0.1" max="99999" id="postWashDryWeight"
                                   name="postWashDryWeight"
                                   value="<?php echo $sampleObject->vars['postWashDryWeight']; ?>"
                                   onchange="setLostValues(); calculateMoistureRate(); calculateOrePercent();">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="description">Sample No./Description:</label>
                            <input class="form-control" type="text" id="description" name="description"
                                   placeholder="XXXX-XXXX" value="<?php
                            if (isset($sampleObject->vars['description'])) {
                                if ($sampleObject->vars['description'] != "") {
                                    echo $sampleObject->vars['description'];
                                } else {
                                    echo $sampleObject->vars['id'];
                                }
                            } else {
                                echo $sampleObject->vars['id'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="oversizeWeight">Oversize Weight:</label>
                            <input class="form-control" type="number" step="0.01" min="0" id="oversizeWeight"
                                   name="oversizeWeight" value="<?php echo $sampleObject->vars['oversizeWeight']; ?>"
                                   onChange="updateOversizePercent(); setLostValues(); calculateRates();">

                        </div>
                        <div class="form-group col-lg-2">
                            <label for="oversizePercent">Oversize Percent:</label>
                            <input class="form-control" type="text" id="oversizePercent" name="oversizePercent">

                        </div>
                        <div class="form-group col-lg-2">
                            <label for="splitSampleWeight">Split Sample Weight (g):</label>
                            <input class="form-control" type="number" step="0.1" max="99999" id="splitSampleWeight"
                                   name="splitSampleWeight"
                                   value="<?php echo $sampleObject->vars['splitSampleWeight']; ?>"
                                   onchange="setLostValues(); calculateMoistureRate();">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="moistureRate">Moisture Rate (%):</label>
                            <input class="form-control" type="text" id="moistureRate" name="moistureRate"
                                   value="<?php echo $sampleObject->vars['moistureRate']; ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="gramsLost">Grams Lost in Wash:</label>
                            <input class="form-control" type="text" id="gramsLost" name="gramsLost" readonly>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="percentLost" id="percentLostLabel">Percent Lost in Wash:</label>
                            <input class="form-control" type="text" id="percentLost" name="percentLost" readonly>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="newSplit" id="newSplitLabel">New Split Weight:</label>
                            <input class="form-control" type="text" id="newSplit" name="newSplit">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="drillholeNo">Drillhole No.:</label>
                            <input class="form-control" type="text" id="drillholeNo" name="drillholeNo"
                                   placeholder="DHXXXX-YY" value="<?php echo $sampleObject->vars['drillholeNo']; ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="depthFrom">Depth From:</label>
                            <input class="form-control" type="text" id="depthFrom" name="depthFrom"
                                   value="<?php echo $sampleObject->vars['depthFrom']; ?>">

                        </div>
                        <div class="form-group col-lg-2">
                            <label for="depthTo">Depth To:</label>
                            <input class="form-control" type="text" id="depthTo" name="depthTo"
                                   value="<?php echo $sampleObject->vars['depthTo']; ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="orePercent">Ore Percent:</label>
                            <input class="form-control" type="text" id="orePercent" name="orePercent" value="" readonly>
                        </div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2"></div>
                        <div class="form-group col-lg-2">
                            <label for="notes">Notes:</label>
                            <input class="form-control" type="text" id="notes" name="notes" pattern="[^'\x22]+"
                                   title="Please remove apostrophes." maxlength="256"
                                   value="<?php echo $sampleObject->vars['notes']; ?>">
                        </div>
                        <div class="form-group form-check col-lg-2" style="padding-left:1.75rem;padding-top:2rem;">
                            <?php
                            if ($userPermissionsArray['vista']['granbury']['qc'] > 3) {
                                if (isset($sampleObject->vars['isComplete'])) {
                                    if ($sampleObject->vars['isComplete'] == 1) {
                                        if (isset($sampleObject->vars['isCOA'])) {
                                            if ($sampleObject->vars['isCOA'] == 1) {
                                                echo("<input type='checkbox' class='form-check-input' id='isCOA' name='isCOA' type='isCOA' value='1' checked>");
                                                echo("<label class='form-check-label' for='isCOA'>COA</label>");
                                            } else {
                                                echo("<input type='checkbox' class='form-check-input' id='isCOA' name='isCOA' type='isCOA' value='1'>");
                                                echo("<label class='form-check-label' for='isCOA'>COA</label>");
                                            }
                                        } else {
                                            echo("<input type='checkbox' class='form-check-input' id='isCOA' name='isCOA' type='isCOA' value='1'>");
                                            echo("<label class='form-check-label' for='isCOA'>COA</label>");
                                        }
                                    }
                                }
                            }

                            ?>
                        </div>
                        <div class="form-group col-lg-8"></div>
                    </div>
                </div>
                <div id="qc_sieves">
                    <div id="sieveSelect"></div>
                </div>
                <button class="btn btn-vprop-green" type="submit">Save to Sample</button>
            </div>
        </div>
        <div id="qc_characteristics" class="tabcontent">
            <h3>Characteristics</h3>
            <div class="form-row">
                <div class="form-group col-lg-2">
                    <label for="turbidity">Turbidity (NTU):</label>
                    <input type="number" id="turbidity" class="form-control" name="turbidity"
                           value="<?php echo $sampleObject->vars['turbidity']; ?>">
                </div>
                <div class="form-group col-lg-10"></div>
                <div class="form-group col-lg-2">
                    <label for="kValue">K Value:</label>
                    <select name="kValue" id="kValue" class="form-control " onChange="showCurrentKValueGroup();">
                        <?php
                        $kValueObjectArray = getKValues(); //get a list of testType options
                        foreach ($kValueObjectArray as $kValueObject) {
                            if ($kValueObject->vars["id"] == $sampleObject->vars['kValue']) {
                                echo "<option value='" . $kValueObject->vars["id"] . "' selected='selected'>" . $kValueObject->vars["description"] . "</option>";
                            } else {
                                echo "<option value='" . $kValueObject->vars["id"] . "'>" . $kValueObject->vars["description"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php
                $kValueObjectArray = getKValues(); //get a list of testType options
                $counter = 0;
                foreach ($kValueObjectArray as $kValueObject) {
                    //read the Pan values from the database
                    $kValueObjectPan1 = NULL;
                    $kValueObjectPan2 = NULL;
                    $kValueObjectPan3 = NULL;

                    $kValuePan1 = "";
                    $kValuePan2 = "";
                    $kValuePan3 = "";

                    $kValueObjectPan1 = getKValueRecord($sampleId, $kValueObject->vars["id"], "kPan1");
                    $kValueObjectPan2 = getKValueRecord($sampleId, $kValueObject->vars["id"], "kPan2");
                    $kValueObjectPan3 = getKValueRecord($sampleId, $kValueObject->vars["id"], "kPan3");

                    if ($kValueObjectPan1 != NULL) {
                        $kValuePan1 = $kValueObjectPan1->vars['value'];
                    }

                    if ($kValueObjectPan2 != NULL) {
                        $kValuePan2 = $kValueObjectPan2->vars['value'];
                    }

                    if ($kValueObjectPan3 != NULL) {
                        $kValuePan3 = $kValueObjectPan3->vars['value'];
                    }

                    echo('<div class="kValueGroup form-group col-lg-12">');
                    //echo('K Value Group: ' . $kValueObject->vars["id"] . '');
                    echo('<div class="form-group col-lg-2">');
                    echo('<label for="kPan1[' . $counter . ']">PAN 1 (g):</label> ');
                    echo('<input type="number" step="0.0001" max="9999999" class="form-control kPan1" id="kPan1[' . $counter . ']" name="kPan1[]" value="' . $kValuePan1 . '" onchange="updateKPan1Calculation()">');
                    echo('<span class="kPan1Calculation badge badge-light" id="kPan1Calculation[]"></span>');
                    echo('</div>');

                    echo('<div class="form-group col-lg-2">');
                    echo('<label for="kPan2[' . $counter . ']">PAN 2 (g):</label> ');
                    echo('<input type="number" step="0.0001" max="9999999" class="form-control kPan2" id="kPan2[' . $counter . ']" name="kPan2[]" value="' . $kValuePan2 . '"  onchange="updateKPan2Calculation()">');
                    echo('<span class="kPan2Calculation  badge badge-light" id="kPan2Calculation[]"></span>');
                    echo('</div>');

                    echo('<div class="form-group col-lg-2">');
                    echo('<label for="kPan3[' . $counter . ']">PAN 3 (g):</label> ');
                    echo('<input type="number" step="0.0001" max="9999999" class="form-control kPan3" id="kPan3[' . $counter . ']" name="kPan3[]" value="' . $kValuePan3 . '"  onchange="updateKPan3Calculation()">');
                    echo('<span class="kPan3Calculation  badge badge-light" id="kPan3Calculation[]"></span>');
                    echo('</div>');
                    echo('</div>');
                    $counter++;
                }
                ?>
                <div class="form-group col-lg-12"></div>
                <div class="form-group col-lg-2">
                    <label>Average:</label>
                    <input type="text" class="form-control" id="kPanAverage" disabled>
                </div>
                <div class="form-group col-lg-2">
                    <label>Status:</label>
                    <input type="text" class="form-control" id="kPanAverageStatus" disabled>
                </div>
                <div class="form-group col-lg-8"></div>
                <div class="form-group col-lg-2">
                    <label for="roundness">Roundness:</label>
                    <input type="number" step="0.1" class="form-control" max="99999" id="roundness" name="roundness"
                           value="<?php echo $sampleObject->vars['roundness']; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="sphericity">Sphericity:</label>
                    <input type="number" class="form-control" step="0.1" max="99999" id="sphericity" name="sphericity"
                           value="<?php echo $sampleObject->vars['sphericity']; ?>">
                </div>
                <div class="form-group col-lg-8"></div>
            </div>
            <button class="btn btn-vprop-green" type="submit">Save to Sample</button>
        </div>
        <div id="qc_plant_settings" class="tabcontent">
            <h3>Plant Settings</h3>
            <div class="form-row" id="plantSettings">Select a Plant to set the Plant Settings.</div>
            <button class="btn btn-vprop-green" type="submit">Save to Sample</button>
    </form>

    <script>
        $(document).ready(function () {
            initialLoad();
            openTab(event, 'qc_general');
            $(".tab").click(function () {
                $(".tab").removeClass("active");
                // $(".tab").addClass("active"); // instead of this do the below
                $(this).addClass("active");
            });
        });
    </script>
    <script>
        //call JQuery to render the datepicker tool
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
        $("#minMaxBtn").click(function () {
            if ($(this).html() == "Hide Form") {
                $(this).html("Show Form");
            }
            else if ($(this).html() == "Show Form") {
                $(this).html("Hide Form");
            }
            else {
                $(this).html("Show Form");
            }
            $("#form-content").slideToggle();
        });
    </script>

    <script>
        //<editor-fold desc="javascript">
        //load the options when the window loads
        //document.getElementsByTagName('body')[0].onload = initialLoad();

        var wetWeightsEnabled = 1; //global variable

        function initialLoad() {
            function runFirst(callback) {
                loadPlantSelect();
                callback();
            }

            function runSecond(callback) {
                loadSieveStackSelect();
                callback();
            }

            function runThird(callback) {
                showCurrentKValueGroup();
                callback();
            }

            function runFourth(callback) {
                setTimeout(function () {
                    calculateTotalFinalWeight();
                }, 1000);
                //dev note: added setTimeout, because this was running before the other data was ready

                callback();
            }

            function runFifth(callback) {
                updateLocationSpan();
                callback();
            }

            function runSixth(callback) {
                updateDateTimeSpan();
                callback();
            }

            runFirst(function () {
                console.log('Finished loadPlantSelect function.');

                runSecond(function () {
                    console.log('Finished loadSieveStackSelect function.');

                    runThird(function () {
                        console.log('Finished showCurrentKValueGroup function.');

                        runFourth(function () {
                            console.log('Finished calculateTotalFinalWeight function.');

                            runFifth(function () {
                                console.log('Finished updateLocationSpan function.');

                                runSixth(function () {
                                    console.log('Finished updateDateTimeSpan function.');

                                });
                            });
                        });
                    });
                });
            });

            //Note: getSieves, getPlantSettings, and loadLocationSelect are called by loadPlantSelect
            //Note: loadSpecificLocationSelect is called by loadLocationSelect

        }

        //calculate and update the Oversize Percentage field
        function updateOversizePercent() {
            //console.log("DEBUG: updateOversizePercent function called!");

            var postWash = null;
            var preWash = null;
            var oversizeWeight = null;
            var totalFinalWeight = null;
            var startWeight1ReadOnly = null;
            var oversizePercent = "";

            //get the value of Post Wash
            postWash = document.getElementById("postWashDryWeight").value;
            //console.log("DEBUG: postWash = "+postWash);

            //get the value of Pre Wash
            preWash = document.getElementById("preWashDryWeight").value;
            //console.log("DEBUG: preWash = "+preWash);

            //get the value of Oversize Weight
            oversizeWeight = document.getElementById("oversizeWeight").value;
            //console.log("DEBUG: oversizeWeight = "+oversizeWeight);

            //get the value of totalFinalWeight
            try {
                totalFinalWeight = document.getElementById("totalFinalWeight").value;
            }
            catch (err) {
                console.log("error: " + err);
                totalFinalWeight = 0;
            }
            //console.log("DEBUG: totalFinalWeight = "+totalFinalWeight);

            //calculate Oversize Percent as oversizeWeight / preWash
            if (oversizeWeight == "") {
                oversizePercent = "";
            }
            else if (preWash == "") {
                oversizePercent = "";
            }
            else {
                oversizePercent = (oversizeWeight / preWash).toFixed(4);
            }

            //set the value of the oversizePercent input
            if (totalFinalWeight == "NaN") {
                oversizePercent = "";
                document.getElementById("oversizePercent").value = oversizePercent;
            }
            else {
                document.getElementById("oversizePercent").value = (oversizePercent * 100).toFixed(2) + "%";
            }
        }

        //check if the selected Sample Location is "Core Sample"
        function checkIfCoreSample() {
            try {
                var sel = document.getElementById("locationId");
                var text = sel.options[sel.selectedIndex].text;
                //console.log("text = " + text);
                if (text == "Core Sample") {
                    return true;
                }
                else if (text == "Core Samples") {
                    return true;
                }
                else {
                    return false;
                }
            }
            catch (err) {
                console.log("error: " + err);
                return false;
            }
        }

        //show or hide fields related to core samples
        function updateCoreSampleFieldVisibility() {
            //console.log("DEBUG: updateCoreSampleFieldVisibility function called!");

            //get the name of the currently selected Location
            var locationIDSelect = document.getElementById("locationId");
            var currentLocationNameSelected = null;
            if (locationIDSelect != null) {
                currentLocationNameSelected = locationIDSelect.options[locationIDSelect.selectedIndex].text;
            }

            //console.log("DEBUG: currentLocationNameSelected = " + currentLocationNameSelected);
            if (currentLocationNameSelected != null) {
                //update the Core Sample fields based on the Test Type ID. Core Sample == 7
                if (currentLocationNameSelected == "Core Sample") {
                    //console.log("DEBUG: currentLocationNameSelected = Core Sample");

                    //show the core sample fields
                    document.getElementById("drillholeNo").parentElement.style.display = "block";
                    document.getElementById("depthFrom").parentElement.style.display = "block";
                    document.getElementById("depthTo").parentElement.style.display = "block";
                    document.getElementById("oversizeWeight").parentElement.style.display = "block";
                    document.getElementById("oversizePercent").parentElement.style.display = "block";
                    document.getElementById("orePercent").parentElement.style.display = "block";

                    document.getElementById("percentLostLabel").innerHTML = "Slimes Percent:";
                }
                else {
                    //hide the core sample fields
                    document.getElementById("drillholeNo").parentElement.style.display = "none";
                    document.getElementById("depthFrom").parentElement.style.display = "none";
                    document.getElementById("depthTo").parentElement.style.display = "none";
                    document.getElementById("oversizeWeight").parentElement.style.display = "none";
                    document.getElementById("oversizePercent").parentElement.style.display = "none";
                    document.getElementById("orePercent").parentElement.style.display = "none";

                    document.getElementById("percentLostLabel").innerHTML = "Percent Lost in Wash:";
                }
            }
            else {
                //hide the core sample fields
                document.getElementById("drillholeNo").parentElement.style.display = "none";
                document.getElementById("depthFrom").parentElement.style.display = "none";
                document.getElementById("depthTo").parentElement.style.display = "none";
                document.getElementById("oversizeWeight").parentElement.style.display = "none";
                document.getElementById("oversizePercent").parentElement.style.display = "none";
                document.getElementById("orePercent").parentElement.style.display = "none";

                document.getElementById("percentLostLabel").innerHTML = "Percent Lost in Wash:";
            }
        }

        //hide the K Value Groups which are not selected
        function showCurrentKValueGroup() {
            //console.log("DEBUG: showCurrentKValueGroup function called!");

            var elementIteratorArray = null;
            var adjustedCurrentKValueSelected = null;
            var i = 0;

            //get the count of the number of K Value divs from the PHP
            var countOfKValueDivs = <?php echo count($kValueObjectArray); ?>;
            console.log("DEBUG: countOfKValueDivs =" + countOfKValueDivs);

            //get the value of the currently selected K Value
            var currentKValueSelected = document.getElementById("kValue").value;
            console.log("DEBUG: currentKValueSelected =" + currentKValueSelected);

            //adjust the value to a count
            if (currentKValueSelected == "") {
                adjustedCurrentKValueSelected = 0;
            }
            else {
                //adjustedCurrentKValueSelected = currentKValueSelected - 4;
                adjustedCurrentKValueSelected = currentKValueSelected - 1;
            }
            console.log("DEBUG: adjustedCurrentKValueSelected =" + adjustedCurrentKValueSelected);

            elementIteratorArray = document.getElementsByClassName("kValueGroup");

            //iterate through all K Value options
            for (i = 0; i < countOfKValueDivs; i++) {
                //console.log("DEBUG: i = " + i);

                //hide the div
                elementIteratorArray[i].style.display = "none";

                //if this is the div we are looking for
                if (i == adjustedCurrentKValueSelected) {
                    //console.log("DEBUG: i = currentKValueSelected!");

                    //unhide that div
                    elementIteratorArray[i].style.display = "block";
                }
            }

            updateKPan1Calculation();
            updateKPan2Calculation();
            updateKPan3Calculation();
            updateKPanAverage(); //update the values in the Average and Status, since we are now looking at a different K Value group
        }


        //populate the select box for Sieve Stack
        function loadSieveStackSelect() {
            //console.log("DEBUG: loadSieveStackSelect function called!");

            //get the value from the select box
            var siteID = document.getElementById("siteId").value;

            if (siteID.length > 0) {
                //update the values
                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("sieveStackSelect").innerHTML = this.responseText;
                        //console.log("DEBUG: this.responseText = "+this.responseText);
                        getSieves();
                    }
                }

                //get the content
                <?php
                if ($sampleObject->vars['sieveMethod'] == NULL) {
                    $sampleObject->vars['sieveMethod'] = 0;
                }
                ?>
                xmlhttp2.open("GET", "../../Includes/QC/gb_sievestacksselectbysite.php?siteID=" + siteID + "&sieveStackID=" +<?php echo $sampleObject->vars['sieveMethod']; ?>, true);
                xmlhttp2.send();

            }

        }


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
                        getSieves();
                        getPlantSettings();
                        calculateOrePercent();
                    }
                }

                //get the content
                xmlhttp2.open("GET", "../../Includes/QC/gb_plantsselectbysite.php?siteId=" + siteId + "&plantId=" +<?php echo $sampleObject->vars['plantId']; ?>, true);
                xmlhttp2.send();

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
                        document.getElementById("locationSelect").innerHTML = this.responseText;
                        loadSpecificLocationSelect();
                        getPlantSettings();
                        updateCoreSampleFieldVisibility();

                        updateLocationSpan();
                        updateDateTimeSpan();
                    }
                }

                //get the content
                xmlhttp2.open("GET", "../../Includes/QC/gb_locationsselectbyplant.php?plantId=" + plantId + "&locationId=" +<?php echo $sampleObject->vars['location']; ?>, true);
                xmlhttp2.send();

            }

        }

        //populate the select box for Specific Location
        function loadSpecificLocationSelect() {
            enableDisableWetWeights();

            //console.log("DEBUG: loadSpecificLocationSelect() function called!");

            //get the value from the select box
            var locationId = document.getElementById("locationId").value;
            //console.log("locationId = "+locationId);

            if (locationId.length > 0) {
                //update the values
                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        //console.log("this.responseText = "+this.responseText);
                        document.getElementById("specificLocationSelect").innerHTML = this.responseText;
                    }
                }

                //get the content
                xmlhttp2.open("GET", "../../Includes/QC/gb_specificlocationsselectbylocation.php?locationId=" + locationId + "&specificLocationId=" +<?php echo $sampleObject->vars['specificLocation']; ?>, true);
                xmlhttp2.send();

            }

        }

        //functionality for the tab navigation
        function openTab(evt, tabName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tabName).style.display = "block";
            //evt.currentTarget.className += " active";
        }

        //update the sieves table when the sieve method changes
        function getSieves() {

            //get the Sieve Stack value from the select box
            if (document.getElementById("sieveStackId") != null) {
                var sieveStackId = document.getElementById("sieveStackId").value;
            }

            if (sieveStackId != null) {
                //update the values
                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("sieveSelect").innerHTML = this.responseText; //display the sievesget.php output inside sampleedit.php

                        calculateRates(); //load the javascript calculations
                        updateKPan1Calculation(); //update KPan calculation
                        updateKPan2Calculation(); //update KPan calculation
                        updateKPan3Calculation(); //update KPan calculation
                        updateKPanAverage(); //update KPan Average calculation
                        calculateTotalFinalWeight();

                        updateOversizePercent();

                        //update empty sieve range values to NA
                        changeBlankSieveRangesToNA();
                    }
                }

                //console.log("DEBUG: getting sieves. sieveStackId = " + sieveStackId);

                //get the content
                xmlhttp2.open("GET", "../../Includes/QC/gb_sievesget.php?stackId=" + sieveStackId + "&sampleId=" +<?php echo $sampleId; ?>, true);
                xmlhttp2.send();

            }
        }

        //update the plant settings input fields when the plant changes
        function getPlantSettings() {
            //console.log("DEBUG: getPlantSettings() function called!");

            //get the value from the select box
            var plantId = document.getElementById("plantId").value;
            //console.log("DEBUG: plantId = "+plantId);

            if (plantId.length > 0) {
                //update the values
                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("plantSettings").innerHTML = this.responseText;
                    }
                }

                //get the content
                xmlhttp2.open("GET", "../../Includes/QC/gb_plantsettingsinputfields.php?plantId=" + plantId + "&sampleId=" +<?php echo $sampleId; ?>, true);
                xmlhttp2.send();

            }

        }

        //utility function to reduce code size, checks if select box is empty
        function checkIfSelected(argValue, argName) {
            if (argValue == "") {
                alert(argName + " must be selected.")
                return false;
            }
            else {
                return true;
            }
        }

        //utility function to reduce code size, checks if text input is empty
        function checkIfEntered(argValue, argName) {
            if (argValue == "") {
                alert(argName + " must be completed.")
                return false;
            }
            else {
                return true;
            }
        }

        //This function validates if a value is a number.
        //It alerts the user with the name of the field if not.
        function checkIfNumber(argValue, argName) {
            if (isNaN(argValue)) {
                alert(argName + " must be a number.")
                return false;
            }
            else {
                return true;
            }
        }

        //This function validates if a value is greater than a maximum.
        //It alerts the user with the name of the field if so.
        function checkIfLessThan(argValue, argName, argMaximum) {
            if (argValue > argMaximum) {
                alert(argName + " must be less than " + argMaximum + ".")
                return false;
            }
            else {
                return true;
            }
        }

        //this function performs validation on the user inputs
        function validateForm() {
            var x;
            var returnValue = true;
            var itemPercent = null;
            var negativeWeightFound = false;
            var sieveCount = null;
            var splitSampleWeightValue = null;
            var postWashDryWeightValue = null;
            var preWashDryWeightValue = null;
            var beginningWetWeightValue = null;

            //make sure that user doesn't type in a date time in the future
            var inputString = document.forms["qcForm"]["dt"].value;
            var inputDt = new Date(inputString);
            var currentDt = new Date();
            if (inputDt > currentDt) {
                alert("The Date/Time cannot be in the future.");
                return false;
            }

            //check that none of the sieve percentages are negative
            sieveCount = document.getElementById('sieveCount').value;

            for (i = 1; i < sieveCount; i++) //iterate through all sieves
            {
                if (parseFloat(document.getElementById('finalWeight' + i).value) < 0) {
                    negativeWeightFound = true;
                }
            }
            if (negativeWeightFound == true) {
                return confirm("Negative Sieve Final Weights were found. Are you Sure?")
            }


            if (wetWeightsEnabled == 1) //only if wet weights are enabled
            {
                //Check that Split Sample Weight ! > Post Wash Dry Weight.
                splitSampleWeightValue = document.getElementById('splitSampleWeight').value;
                postWashDryWeightValue = document.getElementById('postWashDryWeight').value;
                //console.log("DEBUG: splitSampleWeightValue = " + splitSampleWeightValue);
                //console.log("DEBUG: postWashDryWeightValue = " + postWashDryWeightValue);
                if (parseFloat(splitSampleWeightValue) > parseFloat(postWashDryWeightValue)) {
                    alert("Split Sample Weight cannot be greater than Post Wash Dry Weight!")
                    return false;
                }

                //Check that Post Wash Dry Weight ! > Pre Wash Dry Weight.
                preWashDryWeightValue = document.getElementById('preWashDryWeight').value;
                if (parseFloat(postWashDryWeightValue) > parseFloat(preWashDryWeightValue)) {
                    alert("Post Wash Dry Weight cannot be greater than Pre Wash Dry Weight!")
                    return false;
                }

                //Check that Pre Wash Dry Weight ! > Beginning Wet Weight.
                beginningWetWeightValue = document.getElementById('beginningWetWeight').value;
                if (parseFloat(preWashDryWeightValue) > parseFloat(beginningWetWeightValue)) {
                    alert("Pre Wash Dry Weight cannot be greater than Beginning Wet Weight!")
                    return false;
                }
            }


            return returnValue;
        }

        //calculate the average of the KPan values
        function updateKPanAverage() {
            var elementIteratorArray1 = null;
            var elementIteratorArray2 = null;
            var elementIteratorArray3 = null;
            var adjustedCurrentKValueSelected = null;
            var i = 0;

            //get the count of the number of K Value divs from the PHP
            var countOfKValueDivs = <?php echo count($kValueObjectArray); ?>;
            //console.log("DEBUG: countOfKValueDivs =" + countOfKValueDivs);

            //get the value of the currently selected K Value
            var currentKValueSelected = document.getElementById("kValue").value;
            //console.log("DEBUG: currentKValueSelected =" + currentKValueSelected);

            //adjust the value to a count (assumes that the values start at 4 and are sequential, which was correct when this was written)
            if (currentKValueSelected == "") {
                adjustedCurrentKValueSelected = 0;
            }
            else {
                adjustedCurrentKValueSelected = currentKValueSelected - 1;
            }
            //console.log("DEBUG: adjustedCurrentKValueSelected =" + adjustedCurrentKValueSelected);

            elementIteratorArray1 = document.getElementsByClassName("kPan1Calculation");
            elementIteratorArray2 = document.getElementsByClassName("kPan2Calculation");
            elementIteratorArray3 = document.getElementsByClassName("kPan3Calculation");

            var kPanAverage = (parseFloat(elementIteratorArray1[adjustedCurrentKValueSelected].innerHTML) + parseFloat(elementIteratorArray2[adjustedCurrentKValueSelected].innerHTML) + parseFloat(elementIteratorArray3[adjustedCurrentKValueSelected].innerHTML)) / 3;
            kPanAverage = Math.round(kPanAverage * 100) / 100; //round to 2 decimal places
            //console.log("DEBUG: kPanAverage =" + kPanAverage);

            if (kPanAverage <= 10) {
                document.getElementById("kPanAverageStatus").value = "This Crush test passes.";
            }
            else {
                document.getElementById("kPanAverageStatus").value = "This Crush test fails.";
            }
            document.getElementById("kPanAverage").value = kPanAverage + "%";
        }

        //perform the K Pan Calculations
        function updateKPan1Calculation() {
            var elementIteratorArray = null;
            var adjustedCurrentKValueSelected = null;
            var i = 0;

            //get the count of the number of K Value divs from the PHP
            var countOfKValueDivs = <?php echo count($kValueObjectArray); ?>;
            //console.log("DEBUG: countOfKValueDivs =" + countOfKValueDivs);

            //get the value of the currently selected K Value
            var currentKValueSelected = document.getElementById("kValue").value;
            //console.log("DEBUG: currentKValueSelected =" + currentKValueSelected);

            //adjust the value to a count (assumes that the values start at 4 and are sequential, which was correct when this was written)
            if (currentKValueSelected == "") {
                adjustedCurrentKValueSelected = 0;
            }
            else {
                adjustedCurrentKValueSelected = currentKValueSelected - 1;
            }
            //console.log("DEBUG: adjustedCurrentKValueSelected =" + adjustedCurrentKValueSelected);

            elementIteratorArray = document.getElementsByClassName("kPan1");

            var kPanInput = elementIteratorArray[adjustedCurrentKValueSelected].value;
            //console.log("DEBUG: kPanInput =" + kPanInput);

            var outputString = ((kPanInput / 40) * 100).toFixed(2) + "%";
            //console.log("DEBUG: outputString =" + outputString);

            elementIteratorArray = document.getElementsByClassName("kPan1Calculation");

            elementIteratorArray[adjustedCurrentKValueSelected].innerHTML = outputString;

            updateKPanAverage();
        }

        //perform the K Pan Calculations
        function updateKPan2Calculation() {
            var elementIteratorArray = null;
            var adjustedCurrentKValueSelected = null;
            var i = 0;

            //get the count of the number of K Value divs from the PHP
            var countOfKValueDivs = <?php echo count($kValueObjectArray); ?>;
            //console.log("DEBUG: countOfKValueDivs =" + countOfKValueDivs);

            //get the value of the currently selected K Value
            var currentKValueSelected = document.getElementById("kValue").value;
            //console.log("DEBUG: currentKValueSelected =" + currentKValueSelected);

            //adjust the value to a count (assumes that the values start at 4 and are sequential, which was correct when this was written)
            if (currentKValueSelected == "") {
                adjustedCurrentKValueSelected = 0;
            }
            else {
                adjustedCurrentKValueSelected = currentKValueSelected - 1;
            }
            //console.log("DEBUG: adjustedCurrentKValueSelected =" + adjustedCurrentKValueSelected);

            elementIteratorArray = document.getElementsByClassName("kPan2");

            var kPanInput = elementIteratorArray[adjustedCurrentKValueSelected].value;
            //console.log("DEBUG: kPanInput =" + kPanInput);

            var outputString = ((kPanInput / 40) * 100).toFixed(2) + "%";
            //console.log("DEBUG: outputString =" + outputString);

            elementIteratorArray = document.getElementsByClassName("kPan2Calculation");

            elementIteratorArray[adjustedCurrentKValueSelected].innerHTML = outputString;

            updateKPanAverage();
        }

        //perform the K Pan Calculations
        function updateKPan3Calculation() {
            var elementIteratorArray = null;
            var adjustedCurrentKValueSelected = null;
            var i = 0;

            //get the count of the number of K Value divs from the PHP
            var countOfKValueDivs = <?php echo count($kValueObjectArray); ?>;
            //console.log("DEBUG: countOfKValueDivs =" + countOfKValueDivs);

            //get the value of the currently selected K Value
            var currentKValueSelected = document.getElementById("kValue").value;
            //console.log("DEBUG: currentKValueSelected =" + currentKValueSelected);

            //adjust the value to a count (assumes that the values start at 4 and are sequential, which was correct when this was written)
            if (currentKValueSelected == "") {
                adjustedCurrentKValueSelected = 0;
            }
            else {
                adjustedCurrentKValueSelected = currentKValueSelected - 1;
            }
            //console.log("DEBUG: adjustedCurrentKValueSelected =" + adjustedCurrentKValueSelected);

            elementIteratorArray = document.getElementsByClassName("kPan3");

            var kPanInput = elementIteratorArray[adjustedCurrentKValueSelected].value;
            //console.log("DEBUG: kPanInput =" + kPanInput);

            var outputString = ((kPanInput / 40) * 100).toFixed(2) + "%";
            //console.log("DEBUG: outputString =" + outputString);

            elementIteratorArray = document.getElementsByClassName("kPan3Calculation");

            elementIteratorArray[adjustedCurrentKValueSelected].innerHTML = outputString;

            updateKPanAverage();
        }

        function calculateMoistureRate() {
            //console.log("DEBUG: calculateMoistureRate function called");
            var preWashDryWeight = document.getElementById("preWashDryWeight").value;
            var beginningWeight = document.getElementById("beginningWetWeight").value;
            var moistureRateValue = Math.round((1 - (preWashDryWeight / beginningWeight)) * 10000) / 10000; //round to 4 decimal places

            //console.log("DEBUG: Setting Moisture Rate to" + (moistureRateValue * 100) + "%");

            document.getElementById("moistureRate").value = ((moistureRateValue * 100)).toFixed(2) + "%";
            document.getElementById("moistureRate").placeholder = ((moistureRateValue) * 100) + "%";

            var sieveCount = document.getElementById('sieveCount').value
            for (i = 1; i < sieveCount; i++) //iterate through all sieves
            {
                calculateFinalWeight(i); //update all of the other calculations as well
            }

        }

        /******************************************************************************
         * function calculateOrePercent()
         * Date: 11-14-2017
         * Author: Matt Nutsch
         * Description: calculate and update the Ore Percent field.
         *
         ******************************************************************************/
        function calculateOrePercent() {
            var preWashDryWeight = document.getElementById("preWashDryWeight").value;
            var postWashDryWeight = document.getElementById("postWashDryWeight").value;

            var orePercentInput = document.getElementById("orePercent");

            var orePercentValue = "";

            if ((preWashDryWeight == 0) || (postWashDryWeight == 0)) {
                orePercentValue = "";
            }
            else {
                orePercentValue = Math.round(parseFloat(postWashDryWeight / preWashDryWeight) * 10000) / 10000; //initially round to 4 decimal places while a decimal
                orePercentValue = (orePercentValue * 100).toFixed(2) + "%";  //round to 2 decimal places when converting to a percentage
            }
            orePercentInput.value = orePercentValue;
        }

        //disable or enable wet weights based on the location
        function enableDisableWetWeights() {
            //get the value from the location
            var locationId = document.getElementById("locationId").value;

            if (locationId.length > 0) {
                //update the values
                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == "1") {
                            //accept wet weights
                            document.getElementById("beginningWetWeight").style.display = "none";
                            document.getElementById("preWashDryWeight").style.display = "none";
                            document.getElementById("postWashDryWeight").style.display = "none";

                            document.getElementById("beginningWetWeightLabel").style.display = "none";
                            document.getElementById("preWashDryWeightLabel").style.display = "none";
                            document.getElementById("postWashDryWeightLabel").style.display = "none";

                            document.getElementById("beginningWetWeightWrapper").style.display = "none";
                            document.getElementById("preWashDryWeightWrapper").style.display = "none";
                            document.getElementById("postWashDryWeightWrapper").style.display = "none";

                            wetWeightsEnabled = 0;
                        }
                        else {
                            //do not accept wet weights
                            document.getElementById("beginningWetWeight").style.display = "block";
                            document.getElementById("preWashDryWeight").style.display = "block";
                            document.getElementById("postWashDryWeight").style.display = "block";

                            document.getElementById("beginningWetWeightLabel").style.display = "block";
                            document.getElementById("preWashDryWeightLabel").style.display = "block";
                            document.getElementById("postWashDryWeightLabel").style.display = "block";

                            document.getElementById("beginningWetWeightWrapper").style.display = "block";
                            document.getElementById("preWashDryWeightWrapper").style.display = "block";
                            document.getElementById("postWashDryWeightWrapper").style.display = "block";

                            wetWeightsEnabled = 1;
                        }

                        //console.log("DEBUG: wetWeightsEnabled = " + wetWeightsEnabled);
                    }
                }

                //get the content
                xmlhttp2.open("GET", "../../Includes/QC/gb_locationcheckwetweightsfor.php?locationId=" + locationId, true);
                xmlhttp2.send();

            }
        }

        //update the final weight values in the Sieves table
        function calculateFinalWeight(argNumber) {
            //console.log("Calculate Final Rate (item) called");

            var startWeight = null;
            var endWeight = null;
            var finalWeight = null;

            if ((document.getElementById('startWeight' + argNumber) != null) && (document.getElementById('endWeight' + argNumber) != null)) {
                //update the final weight value
                startWeight = document.getElementById('startWeight' + argNumber).value;
                endWeight = document.getElementById('endWeight' + argNumber).value;
                finalWeight = startWeight = endWeight - startWeight;
                finalWeight = Math.round(finalWeight * 100) / 100;
                finalWeight = finalWeight.toFixed(2);
                //alert("DEBUG: Final Weight # " + argNumber + " calculated as " + finalWeight);
                document.getElementById('finalWeight' + argNumber).value = finalWeight;
                calculateTotalFinalWeight();
            }
        }

        //update the total final weight value in the Sieves table
        function calculateTotalFinalWeight() {
            //console.log("Calculate Total Final Weight called");

            try {
                var sieveCount = document.getElementById('sieveCount').value;
            }
            catch (err) {
                var sieveCount = 0;
                console.log("error: " + err);
            }
            var runningTotal = 0;
            var itemWeight = 0;
            for (i = 1; i < sieveCount; i++) {
                itemWeight = parseFloat(document.getElementById('finalWeight' + i).value);
                //console.log(runningTotal + " + " + itemWeight + " = " + (runningTotal + itemWeight));
                runningTotal = runningTotal + itemWeight;
            }
            runningTotal = Math.round(runningTotal * 100) / 100;
            try {
                document.getElementById('totalFinalWeight').value = runningTotal;
            }
            catch (err) {
                console.log("error: " + err);
            }

            calculateRates();

            updateOversizePercent();

            return runningTotal;
        }

        /*******************************************************************************
         * Name: setSplitWeight()
         * Author: Matt Nutsch
         * Date:
         * Description:
         * This function sets the split weight value in the Sieve table to the input
         * amount from the other tab
         *
         ******************************************************************************/
        function setSplitWeight() {
            //console.log("Set Split Weight called");

            var splitWeightValue;
            try //set the split weight value in the Sieves table if the table is loaded and the value is already input
            {
                splitWeightValue = document.getElementById('splitSampleWeight').value;
                if (splitWeightValue.length == 0) //show a 0 instead of a blank when the user hasn't entered split weight yet
                {
                    splitWeightValue = 0;
                }
                document.getElementById('splitWeightSieve').value = splitWeightValue;

                //update the delta between total final weight and split weight
                var deltaWeightValue = document.getElementById('totalFinalWeight').value - document.getElementById('splitWeightSieve').value;
                deltaWeightValue = Math.round(deltaWeightValue * 10) / 10; //round to 1 decimal
                deltaWeightValue = deltaWeightValue.toFixed(1);
                document.getElementById('deltaWeight').value = deltaWeightValue;

            }
            catch (err) {
                //Sometimes this will run while the sieve table is not visible. We don't want to see error messages about this.
            }
        }


        /*******************************************************************************
         * Name: setLostValues()
         * Author: Matt Nutsch
         * Date:
         * Description:
         * This function populates the Grams Lost and Percent Lost fields.
         *
         ******************************************************************************/
        function setLostValues() {
            //console.log("DEBUG: setLostValues called");

            //calculate grams lost
            var preWashDryWeight = document.getElementById('preWashDryWeight').value;
            var postWashWeight = document.getElementById('postWashDryWeight').value;
            var oversizeWeight = document.getElementById('oversizeWeight').value;
            if (oversizeWeight == "") {
                oversizeWeight = 0;
            }

            var gramsLost = preWashDryWeight - postWashWeight;
            document.getElementById('gramsLost').value = gramsLost.toFixed(2);

            //calculate percent lost
            var percentLost = 1 - ((parseInt(postWashWeight) + parseInt(oversizeWeight)) / parseInt(preWashDryWeight));
            //1 - (parseInt(preWashDryWeight)(postWashWeight + oversizeWeight)) / parseInt(preWashDryWeight);

            percentLost = Math.round(percentLost * 10000) / 10000; //round to 4 decimal places
            document.getElementById('percentLost').value = (percentLost * 100).toFixed(2) + "%";

        }

        /*******************************************************************************
         * Name: calculateRates()
         * Author: Matt Nutsch
         * Date:
         * Description:
         * This function populates the Percent Final column in the Edit Sample page.
         *
         ******************************************************************************/
        function calculateRates() {
            try {
                var sieveCount = document.getElementById('sieveCount').value
            }
            catch (err) {
                console.log("error: " + err);
                var sieveCount = 0;
            }

            setLostValues();

            setSplitWeight();

            var preWashDryWeight = document.getElementById("preWashDryWeight").value;
            var beginningWeight = document.getElementById("beginningWetWeight").value;

            //calculate grams lost
            var postWashWeight = document.getElementById('postWashDryWeight').value;
            var preWashWeight = document.getElementById('preWashDryWeight').value;
            var gramsLost = preWashDryWeight - postWashWeight;

            var isCamsizer = null;
            try {
                isCamsizer = document.getElementById('isCamsizer').value;
            }
            catch (e) {
                //console.log(e); // pass exception object to error handler
            }

            document.getElementById('gramsLost').value = gramsLost.toFixed(2);

            //calculate percent lost
            var oversizeWeight = document.getElementById('oversizeWeight').value;
            if (oversizeWeight == "") {
                oversizeWeight = 0;
            }

            var percentLost = 1 - ((parseInt(postWashWeight) + parseInt(oversizeWeight)) / parseInt(preWashDryWeight));

            //console.log("DEBUG: postWashWeight = " + postWashWeight);
            //console.log("DEBUG: preWashDryWeight = " + preWashDryWeight);
            percentLost = Math.round(percentLost * 10000) / 10000; //round to 4 decimal places
            //console.log("DEBUG: percentLost = " + percentLost);
            document.getElementById('percentLost').value = (percentLost * 100).toFixed(2) + "%";

            //Set the Moisture Rate from the database value.
            var moistureRateValueRead = document.getElementById("moistureRate").value;
            //console.log("DEBUG: moistureRateValueRead = " + moistureRateValueRead);
            if ((moistureRateValueRead == 0) || (moistureRateValueRead == "")) //if there isn't a database value
            {
                //calculate moisture rate - dev note: We don't call the calculateMoistureRate() function, because that would result in an infinite loop
                var moistureRateValue = Math.round((1 - (preWashDryWeight / beginningWeight)) * 10000) / 10000; //round to 4 decimal places
                //console.log("DEBUG: Setting Moisture Rate to" + (moistureRateValue * 100) + "%");
                document.getElementById("moistureRate").value = (moistureRateValue * 100).toFixed(2) + "%";
                document.getElementById("moistureRate").placeholder = (moistureRateValue * 100).toFixed(2) + "%";
            }
            else {
                if (!isNaN(moistureRateValueRead)) {
                    document.getElementById("moistureRate").value = (moistureRateValueRead * 100).toFixed(2) + "%";
                }
            }

            //calculate new split weight
            try {
                var totalFinalWeightForCalc = document.getElementById('totalFinalWeight').value;
            }
            catch (err) {
                console.log("error: " + err);
                var totalFinalWeightForCalc = 0;
            }
            //console.log("DEBUG: totalFinalWeightForCalc = " + totalFinalWeightForCalc);
            //console.log("DEBUG: percentLost = " + percentLost);
            var newSplit = totalFinalWeightForCalc * (1 + percentLost);
            //console.log("DEBUG: newSplit before rounding = " + newSplit);
            newSplit = Math.round(newSplit * 100) / 100; //round to 2 decimal places
            //console.log("DEBUG: newSplit after rounding = " + newSplit);
            document.getElementById('newSplit').value = newSplit;
            //console.log("DEBUG: newSplit field value after setting = " + document.getElementById('newSplit').value);

            var tempItem;
            var newPan = 0;
            var panLocation = 0;
            var panPercentageFirstPass = 0;
            var tempName;
            var itemFinalPercentFirstPass = 0;
            var totalFinalPercentFirstPass = 0;
            var plusSeventy = 0;
            var plusFifty = 0;
            var plusForty = 0;
            var minusSeventy = 0;
            var negFortyPlusSeventy = 0;
            var negFiftyPlusOneForty = 0;
            var negSeventyPlusOneForty = 0;
            var negOneForty = 0;
            var orePercentInput;
            var orePercentValueAsNumber = 0;
            var tempValue = 0; //used as a temporary value for formatting
            var nearSize = 0;
            var selectedLocation; //used to determine if this is a Core Sample

            orePercentInput = document.getElementById("orePercent");
            orePercentValueAsNumber = orePercentInput.value;
            orePercentValueAsNumber = orePercentValueAsNumber.slice(0, -1); //trim the % sign
            orePercentValueAsNumber = orePercentValueAsNumber / 100; //convert to a decimal

            for (i = 1; i < sieveCount; i++) //iterate through all sieves
            {
                //calculate the percent finals
                if (checkIfCoreSample()) //if this is a core sample then use the regular weight * ore percent
                {
                    itemFinalPercentFirstPass = parseFloat((document.getElementById('finalWeight' + i).value * orePercentValueAsNumber)) / parseFloat(totalFinalWeightForCalc);
                }
                else {
                    if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                    {
                        itemFinalPercentFirstPass = parseFloat(document.getElementById('finalWeight' + i).value) / parseFloat(newSplit);
                    }
                    else //otherwise use the regular weight
                    {
                        itemFinalPercentFirstPass = parseFloat(document.getElementById('finalWeight' + i).value) / parseFloat(totalFinalWeightForCalc);
                    }
                }
                //set the percentage in the Sieve table
                //console.log("item " + i + " final percent first pass: " + itemFinalPercentFirstPass);
                totalFinalPercentFirstPass = totalFinalPercentFirstPass + itemFinalPercentFirstPass;
                itemFinalPercentFirstPass = itemFinalPercentFirstPass * 100; //this is done to correct a problem with rounding in Javascript
                itemFinalPercentFirstPass = Math.round(itemFinalPercentFirstPass * 100) / 100; //round to 2 decimal places
                document.getElementById('percentFinal' + i).value = itemFinalPercentFirstPass + "%";
                itemFinalPercentFirstPass = itemFinalPercentFirstPass / 100; //this is done to correct a problem with rounding in Javascript

                //also look for the PAN row
                tempName = "screenSize" + i;
                tempItem = document.getElementById(tempName);
                //console.log(tempName + ": " + tempItem.value);
                if (tempItem.value.toUpperCase() == "PAN") {
                    //console.log("PAN found at sieve item #: " + i);
                    panLocation = i;
                    panPercentageFirstPass = itemFinalPercentFirstPass;
                }

                //also update the range values while we are iterating through the table

                //calculate +70 = 70 and below screen size
                if (parseInt(tempItem.value) <= 70) {
                    plusSeventy = plusSeventy + parseFloat(document.getElementById('finalWeight' + i).value);
                }

                //calculate +50 = 50 and below screen size
                if (parseInt(tempItem.value) <= 50) {
                    plusFifty = plusFifty + parseFloat(document.getElementById('finalWeight' + i).value);
                }

                //calculate +40 = 40 and below screen size
                if (parseInt(tempItem.value) <= 40) {
                    plusForty = plusForty + parseFloat(document.getElementById('finalWeight' + i).value);
                }

                //calculate -70 = > 70
                if (parseInt(tempItem.value) > 70) {
                    minusSeventy = minusSeventy + parseFloat(document.getElementById('finalWeight' + i).value);
                }
                //dev note: PAN gets added in later

                //calculate -40 +70 = 70, 60, 50
                if (parseInt(tempItem.value) <= 70) {
                    if (parseInt(tempItem.value) > 40) {
                        negFortyPlusSeventy = negFortyPlusSeventy + parseFloat(document.getElementById('finalWeight' + i).value);
                    }
                }

                //calculate -50 +140 = 60 - 140
                if (parseInt(tempItem.value) <= 140) {
                    if (parseInt(tempItem.value) > 50) {
                        negFiftyPlusOneForty = negFiftyPlusOneForty + parseFloat(document.getElementById('finalWeight' + i).value);
                    }
                }


                //calculate -70 +140 = 80 - 140
                if (parseInt(tempItem.value) <= 140) {
                    if (parseInt(tempItem.value) > 70) {
                        negSeventyPlusOneForty = negSeventyPlusOneForty + parseFloat(document.getElementById('finalWeight' + i).value);
                    }
                }

                //calculate -140 = 200, Pan
                if (parseInt(tempItem.value) > 140) {
                    //console.log(tempName + ": " + tempItem.value + " = " + parseFloat(document.getElementById('finalWeight' + i).value));
                    //console.log("negOneForty was = " + negOneForty);
                    negOneForty = negOneForty + parseFloat(document.getElementById('finalWeight' + i).value);
                    //console.log("negOneForty now = " + negOneForty);
                }

                //calculate Near Size
                if ((parseInt(tempItem.value) == 60) || (parseInt(tempItem.value) == 70) || (parseInt(tempItem.value) == 80)) {
                    //console.log(tempName + ": " + tempItem.value + " = " + parseFloat(document.getElementById('finalWeight' + i).value));
                    //console.log("negOneForty was = " + negOneForty);
                    nearSize = nearSize + parseFloat(document.getElementById('finalWeight' + i).value);
                    //console.log("negOneForty now = " + negOneForty);
                }

                //dev note: PAN gets added in later
            }

            //console.log("total final percent first pass: " + totalFinalPercentFirstPass);

            //calculate the new Pan value
            var percentToAddToPan = 1 - totalFinalPercentFirstPass;
            //console.log("percent to add to pan: " + percentToAddToPan);
            //console.log("Pan location: " + panLocation);

            //calculate the PAN final percentage differently if this is a Core Sample.
            selectedLocation = $("#locationId").text();
            if (checkIfCoreSample()) {
                newPan = parseFloat(panPercentageFirstPass);
            }
            else {
                newPan = parseFloat(percentToAddToPan) + parseFloat(panPercentageFirstPass);
            }

            //console.log("New Pan: " + newPan);
            //set the new pan
            newPan = newPan * 100; //this is done to correct a problem with rounding in Javascript
            newPan = Math.round(newPan * 100) / 100; //round to 2 decimal places
            try {
                document.getElementById('percentFinal' + panLocation).value = newPan + "%";
                newPan = newPan / 100; //this is done to correct a problem with rounding in Javascript
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update the values under the Sieve table
            //update +70
            //console.log("DEBUG: plusSeventy before rounding = " + plusSeventy);
            plusSeventy = Math.round(plusSeventy * 100) / 100;
            //console.log("DEBUG: plusSeventy after rounding = " + plusSeventy);
            if (checkIfCoreSample()) {
                plusSeventy = plusSeventy / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    plusSeventy = plusSeventy / document.getElementById('newSplit').value;
                }
                else {
                    plusSeventy = plusSeventy / parseFloat(totalFinalWeightForCalc);
                }
            }
            //console.log("DEBUG: plusSeventy as percent of split = " + document.getElementById('newSplit').value);
            //console.log("DEBUG: newSplit field value = " + plusSeventy);
            try {
                document.getElementById('plusSeventy').value = (plusSeventy * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update the values under the Sieve table
            //update +50
            //console.log("DEBUG: plusFifty before rounding = " + plusFifty);
            plusFifty = Math.round(plusFifty * 100) / 100;
            //console.log("DEBUG: plusFifty after rounding = " + plusFifty);
            if (checkIfCoreSample()) {
                plusFifty = plusFifty / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    plusFifty = plusFifty / document.getElementById('newSplit').value;
                }
                else {
                    plusFifty = plusFifty / parseFloat(totalFinalWeightForCalc);
                }
            }
            //console.log("DEBUG: plusFifty as percent of split = " + document.getElementById('newSplit').value);
            //console.log("DEBUG: newSplit field value = " + plusFifty);
            try {
                document.getElementById('plusFifty').value = (plusFifty * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update the values under the Sieve table
            //update +40
            //console.log("DEBUG: plusForty before rounding = " + plusForty);
            plusForty = Math.round(plusForty * 100) / 100;
            //console.log("DEBUG: plusForty after rounding = " + plusForty);
            if (checkIfCoreSample()) {
                plusForty = plusForty / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    plusForty = plusForty / document.getElementById('newSplit').value;
                }
                else {
                    plusForty = plusForty / parseFloat(totalFinalWeightForCalc);
                }
            }
            //console.log("DEBUG: plusForty as percent of split = " + document.getElementById('newSplit').value);
            //console.log("DEBUG: newSplit field value = " + plusForty);
            try {
                document.getElementById('plusForty').value = (plusForty * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update -70
            minusSeventy = Math.round(minusSeventy * 100) / 100;
            if (checkIfCoreSample()) {
                minusSeventy = minusSeventy / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    minusSeventy = minusSeventy / document.getElementById('newSplit').value;
                }
                else {
                    minusSeventy = minusSeventy / parseFloat(totalFinalWeightForCalc);
                }
            }
            minusSeventy = minusSeventy + newPan;
            try {
                document.getElementById('minusSeventy').value = (minusSeventy * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update -40 +70
            negFortyPlusSeventy = Math.round(negFortyPlusSeventy * 100) / 100;
            if (checkIfCoreSample()) {
                negFortyPlusSeventy = negFortyPlusSeventy / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    negFortyPlusSeventy = negFortyPlusSeventy / document.getElementById('newSplit').value;
                }
                else {
                    negFortyPlusSeventy = negFortyPlusSeventy / parseFloat(totalFinalWeightForCalc);
                }
            }
            try {
                document.getElementById('negFortyPlusSeventy').value = (negFortyPlusSeventy * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update -50 +140
            negFiftyPlusOneForty = Math.round(negFiftyPlusOneForty * 100) / 100;
            if (checkIfCoreSample()) {
                negFiftyPlusOneForty = negFiftyPlusOneForty / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    negFiftyPlusOneForty = negFiftyPlusOneForty / document.getElementById('newSplit').value;
                }
                else {
                    negFiftyPlusOneForty = negFiftyPlusOneForty / parseFloat(totalFinalWeightForCalc);
                }
            }
            try {
                document.getElementById('negFiftyPlusOneForty').value = (negFiftyPlusOneForty * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update -70 +140
            negSeventyPlusOneForty = Math.round(negSeventyPlusOneForty * 100) / 100;
            if (checkIfCoreSample()) {
                negSeventyPlusOneForty = negSeventyPlusOneForty / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    negSeventyPlusOneForty = negSeventyPlusOneForty / document.getElementById('newSplit').value;
                }
                else {
                    negSeventyPlusOneForty = negSeventyPlusOneForty / parseFloat(totalFinalWeightForCalc);
                }
            }
            try {
                document.getElementById('negSeventyPlusOneForty').value = (negSeventyPlusOneForty * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update -140
            //console.log("negOneForty before rounding = " + negOneForty);
            negOneForty = Math.round(negOneForty * 100) / 100;
            //console.log("negOneForty after rounding = " + negOneForty);
            if (checkIfCoreSample()) {
                negOneForty = negOneForty / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    negOneForty = negOneForty / document.getElementById('newSplit').value;
                }
                else {
                    negOneForty = negOneForty / parseFloat(totalFinalWeightForCalc);
                }
            }
            negOneForty = negOneForty + newPan;
            //console.log("newPan = " + newPan);
            //console.log("negOneForty as percent = " + negOneForty);
            try {
                document.getElementById('negOneForty').value = (negOneForty * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

            //update Near Size
            nearSize = Math.round(nearSize * 100) / 100;
            if (checkIfCoreSample()) {
                nearSize = nearSize / parseFloat(totalFinalWeightForCalc);
            }
            else {
                if (wetWeightsEnabled == 1) //if this is not a core sample AND wet weights are enabled then use the new split
                {
                    //convert to percent of new split
                    nearSize = nearSize / document.getElementById('newSplit').value;
                }
                else {
                    nearSize = nearSize / parseFloat(totalFinalWeightForCalc);
                }
            }
            try {
                document.getElementById('nearSize').value = (nearSize * 100).toFixed(2) + "%";
            }
            catch (err) {
                console.log("error: " + err);
            }

        }

        /*******************************************************************************
         * Name: changeBlankSieveRangesToNA()
         * Author: Matt Nutsch
         * Date: 11-2-2017
         * Description:
         * This function changes the value of any blank sieve ranges to "NA".
         *
         ******************************************************************************/
        function changeBlankSieveRangesToNA() {
            var plusSeventy = document.getElementById('plusSeventy'); //plusSeventy
            var plusFifty = document.getElementById('plusFifty');
            var plusForty = document.getElementById('plusForty');
            var minusSeventy = document.getElementById('minusSeventy'); //minusSeventy
            var negFortyPlusSeventy = document.getElementById('negFortyPlusSeventy'); //negFortyPlusSeventy
            var negFiftyPlusOneForty = document.getElementById('negFiftyPlusOneForty'); //negFiftyPlusOneForty
            var negSeventyPlusOneForty = document.getElementById('negSeventyPlusOneForty'); //negSeventyPlusOneForty
            var negOneForty = document.getElementById('negOneForty'); //negOneForty

            if (plusSeventy.value == "0.00%") {
                plusSeventy.value = "NA";
            }

            if (plusFifty.value == "0.00%") {
                plusFifty.value = "NA";
            }

            if (plusForty.value == "0.00%") {
                plusForty.value = "NA";
            }

            if (minusSeventy.value == "0.00%") {
                minusSeventy.value = "NA";
            }

            if (negFortyPlusSeventy.value == "0.00%") {
                negFortyPlusSeventy.value = "NA";
            }

            if (negFiftyPlusOneForty.value == "0.00%") {
                negFiftyPlusOneForty.value = "NA";
            }

            if (negSeventyPlusOneForty.value == "0.00%") {
                negSeventyPlusOneForty.value = "NA";
            }

            if (negOneForty.value == "0.00%") {
                negOneForty.value = "NA";
            }

        }

        /*******************************************************************************
         * Name: updateLocationSpan()
         * Author: Matt Nutsch
         * Date:
         * Description:
         * This function changes updates the location span at the top of the page.
         *
         ******************************************************************************/
        function updateLocationSpan() {
            //console.log("updateLocationSpan called");
            let sampleLocationSpan = $('#sampleLocationSpan');
            let sampleLocation = $('#locationId');

            try {
                sampleLocationSpan.textContent = sampleLocation.text();
            }
            catch (err) {
                console.log("error: " + err);
            }

        }

        /*******************************************************************************
         * Name: updateDateTimeSpan()
         * Author: Matt Nutsch
         * Date:
         * Description:
         * This function changes updates the datetime span at the top of the page.
         *
         ******************************************************************************/
        function updateDateTimeSpan() {
            //console.log("updateDateTimeSpan called");
            var dateTimeSpan = document.getElementById('dateTimeSpan');
            var dateTimeField = document.getElementById('dt');
            //console.log("dateTimeField.value = " + dateTimeField.value);
            dateTimeSpan.textContent = dateTimeField.value;
            //console.log("dateTimeSpan.textContent = " + dateTimeSpan.textContent);
        }

        /*******************************************************************************
         * Name: confirmSite()
         * Author: Matt Nutsch
         * Date:
         * Description:
         * This function displays a confirmation popup based on the site selection.
         *
         ******************************************************************************/
        function confirmSite() {
            var siteIDSelected = "";
            siteIDSelected = document.getElementById("siteId").value;

            if (siteIDSelected != 10) //DEV NOTE: This site ID is hard coded and should be changed for new mine sites. 10 = Granbury; 50 = Tolar
            {
                confirm("The Site is not set to Granbury. Are you sure?"); //DEV NOTE: This text is hard coded and should be changed for new mine sites
            }
        }

        //</editor-fold>
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

    //====================================================================== END PHP
    ?>

    <!-- HTML -->





