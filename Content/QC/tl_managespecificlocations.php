<?php
/* * *****************************************************************************************************************************************
 * File Name: managespecificlocations.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/25/2018|ktaylor|KACE:xxxxx - Initial creation
 * 
 * **************************************************************************************************************************************** */


require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/QC/tl_qcfunctions.php');


function getSpecificLocationNames()
{
    $errorMessage = "getSpecificLocationNames() ";
    $arrayOfSpecificLocations = NULL;
    $result = 0;
    $sql = 0;
    $row = 0;

    try {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database

        $result = $mySQLConnectionLocal->query("CALL sp_tl_qc_LocationDetailsByNameGet();"); //stored procedure method

        $outputCount = 0;
        while ($row = $result->fetch_assoc()) {
            $arrayOfSpecificLocations[$outputCount]->vars["id"] = $row['id'];
            $arrayOfSpecificLocations[$outputCount]->vars["location_id"] = $row['location_id'];
            $arrayOfSpecificLocations[$outputCount]->vars["location"] = $row['location'];
            $arrayOfSpecificLocations[$outputCount]->vars["specific_location"] = $row['specific_location'];
            $arrayOfSpecificLocations[$outputCount]->vars["sort_order"] = $row['sort_order'];
            $arrayOfSpecificLocations[$outputCount]->vars["is_active"] = $row['is_active'];

            $outputCount++;
        }

        disconnectFromMySQLQC($mySQLConnectionLocal);

    } catch (Exception $e) {
        $errorMessage = $errorMessage . "Error querying MySQL for a list of sites.";
        sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
        if ($debugging == 1) {
            echo $errorMessage;
            //$error = $e->getMessage();
            //echo $error;
        }
    }

    return $arrayOfSpecificLocations;
}

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
    // This script sorts the dataTable for locationsData in descending order, based off of the sort order column.
    $(document).ready(function () {
        $('#locationsData').DataTable({
            "order": [[1, "desc"]]
        });
    });
</script>
<!-- dataTable files -->
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"
        defer="defer"></script>

<link href="../../Includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<h1>Manage Specific Locations</h1>

<div class="container">
    <form action="../../Includes/QC/addspecificlocation.php" method="GET">
        <!-- Form is adaptable to browser resizing, and each field is required before submission. -->
        <div class="form-group">
            <label for="siteSelect"><strong>Site:</strong></label>
            <select class="form-control" name="siteSelect" id="siteSelect" readonly>
                <?php
                $siteObjectArray = getSites();

                foreach ($siteObjectArray as $siteObject) {
                    if ($siteObject->vars["id"] == 50) // If the row's ID corresponds to "Granbury" (ID: 50).
                    {
                        echo '<option value="' . $siteObject->vars['id'] . '">' . $siteObject->vars['description'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="locationSelect"><strong>Sample Location:</strong></label>
            <select class="form-control" name="locationSelect" id="locationSelect" required>
                <option value="">Select...</option>
                <?php
                $locationObjectArray = getLocations();

                foreach ($locationObjectArray as $locationObject) {
                    if ($locationObject->vars["site"] == 50) // If the row's ID corresponds to "Granbury" (ID: 50).
                    {
                        echo '<option value="' . $locationObject->vars['id'] . '">' . $locationObject->vars['description'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="nameTextbox"><strong>Name:</strong></label>
            <input type="text" class="form-control" id="nameTextBox" name="name" placeholder="Specific location name"
                   maxlength="255" required>
        </div>
        <div class="form-group">
            <button type="submit" id="addNewButton" class="btn btn-success">Add Location</button>
        </div>
    </form>
    <br/><br/><br/>

    <table class="table table-fluid table-striped table-hover" id="specificLocationsTable">
        <thead style="background-color:#4C7AD0; color:white;">
        <tr>
            <th>ID</th>
            <th>Sample Location</th>
            <th>Specific Location</th>
            <th>Sort Order</th>
            <th>Active</th>
            <th>Edit</th>
        </tr>
        </thead>

        <tbody>

        <!-- Populates dataTable with current locations. -->
        <?php
        $specificspecificObjectArray = getSpecificLocationNames();

        foreach ($specificspecificObjectArray as $specificObject) {
            echo '<tr><td>' . $specificObject->vars['id'] . '</td>';
            echo '<td>' . $specificObject->vars['location'] . '</td>';
            echo '<td>' . $specificObject->vars['specific_location'] . '</td>';
            echo '<td>' . $specificObject->vars['sort_order'] . '</td>';
            // If active status is 0, display the text "No" to user instead.
            if ($specificObject->vars['is_active'] == 0) {
                echo '<td>No</td>';
            } // If active status is 1, display the text "Yes" to user instead.
            else if ($specificObject->vars['is_active'] == 1) {
                echo '<td>Yes</td>';
            }

            // Create a URL to edit this location.
            $editURL = "../../Controls/QC/tl_editspecificlocation.php?specificID=" . urlencode($specificObject->vars['id']) .
                "&locationId=" . urlencode($specificObject->vars['location_id']) .
                "&locationName=" . urlencode($specificObject->vars['location']) .
                "&specificLocationName=" . urlencode($specificObject->vars['specific_location']) .
                "&sortOrder=" . urlencode($specificObject->vars['sort_order']) .
                "&isActive=" . urlencode($specificObject->vars['is_active']);


            echo "<td><a href='" . $editURL . "'><!--Edit--><i class='fa fa-edit' style='font-size:20px;color:green'></i></a></td></tr>";
        }
        ?>

        </tbody>

        <tfoot>
        </tfoot>
    </table>
</div>
<script>
    $(document).ready(function () {
        var table = $('#specificLocationsTable').DataTable({
            scrollY: "450px",
            scrollX: false,
            scrollCollapse: false,
            paging: true,
            pageLength: 50,
            fixedColumn: true,
            order: [
                0,
                'desc'
            ],
        });
    });
</script>
<!-- HTML -->



