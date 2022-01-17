<?php

require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/QC/tl_qcfunctions.php');

//======================================================================================== BEGIN PHP
$specificLocationId = $_GET['specificID'];
$locationId = $_GET['locationId'];
$locationName = $_GET['locationName'];
$specificLocationName = $_GET['specificLocationName'];
$sortOrder = $_GET['sortOrder'];
$activeStatus = $_GET['isActive'];

//========================================================================================== END PHP
?>


<h1>Edit Specific Location</h1><br /><br />

<div class="container">
    <form action="../../Includes/QC/tl_updatespecificlocation.php" method="GET">
        <!-- Form is pre-populated with sample location user wants to edit. -->
        <div class='form-group'>
            <label for="specificLocationId"><strong>Specific Location ID:</strong> </label>
            <input type="number" class="form-control" id="specificLocationId" name="specificLocationId" value="<?php echo $specificLocationId;?>"  readonly>
        </div>
        <div class='form-group'>
            <label for="locationId"><strong>Location ID:</strong> </label>
            <input type="number" class="form-control" id="locationId"  name="locationId" value="<?php echo $locationId; ?>"  readonly>
        </div>
        <div class="form-group">
            <label for="locationSelect"><strong>Location:</strong></label>
            <select class="form-control" name="locationSelect" onchange="updateLocationId()" id="locationName" disabled>
                <?php
                $locationsArray = getLocations();
                foreach($locationsArray as $locationObject)
                    if($locationObject->vars['id'] == $locationId) {
                        echo '<option selected value="' . $locationObject->vars['id'] . '">' . $locationObject->vars['description'] . '</option>';
                    }
                    else
                    {
                        echo '<option value="' . $locationObject->vars['id'] . '">' . $locationObject->vars['description'] . '</option>';
                    }
                ?>

            </select>
        </div>



        <div class="form-group">
            <label for="nameTextbox"> <strong>Specific Location Name:</strong> </label>
            <?php
            echo '<input type="text" class="form-control" id="nameTextbox" name="name"  value="' . $specificLocationName .'" maxlength="255" required>';
            ?>
        </div>
        <div class="form-group">
            <label for="orderTextbox"><strong>Order:</strong></label>
            <?php
            echo '<input type="number" class="form-control" id="orderTextbox" name="orderTextbox" value="' . $sortOrder .'" required>';
            ?>
        </div>

        <div class="form-group">
            <label for="isActiveSelect"><strong>Active:</strong></label>
            <select class="form-control" name="isActiveSelect" id="isActiveSelect" required>
                <?php
                // If sample active status is 0, display the text "No" to user instead and make field selected.
                if($activeStatus == 0)
                {
                    echo '<option selected value="0">No</option>';
                }
                else
                {
                    echo '<option value="0">No</option>';
                }

                // If sample active status is 1, display the text "Yes" to user instead and make field selected..
                if($activeStatus == 1)
                {
                    echo '<option selected value="1">Yes</option>';
                }
                else
                {
                    echo '<option value="1">Yes</option>';
                }
                ?>

            </select>
        </div>


        <div class="form-group">
            <button type="submit" id="addNewButton" class="btn btn-success btn-block">Submit Changes</button>
        </div>
    </form>
</div>
<br /><br /><br />

<script>
    function updateLocationId() {
        document.getElementById('locationId').value =  document.getElementById('locationName').value;
    }
</script>
