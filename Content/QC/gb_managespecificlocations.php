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
require_once('../../Includes/QC/gb_qcfunctions.php');

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<link href="../../Includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<h1>Manage Specific Locations</h1>

<div class="container">
        <!-- Form is adaptable to browser resizing, and each field is required before submission. -->
        <div class="form-group">
            <label for="siteSelect"><strong>Site:</strong></label>
            <select class="form-control" name="siteSelect" id="siteSelect">
                <option value="" readonly>Select...</option>
                <option value="10">Granbury</option>
                <option value="20">Cresson</option>
                <option value="50">Tolar</option>
                <option value="60">West Texas</option>
            </select>
        </div>
        <div class="form-group">
            <label for="locationSelect"><strong>Sample Location:</strong></label>
            <select class="form-control" name="locationSelect" id="locationSelect" required>
                <option value="">Select...</option>
            </select>
        </div>
        <div class="form-group">
            <label for="nameTextbox"><strong>Name:</strong></label>
            <input type="text" class="form-control" id="nameTextBox" name="name" placeholder="Specific location name" maxlength="255" required />
        </div>
        <div class="form-group">
            <button type="submit" id="addNewButton" class="btn btn-success">Add Location</button>
        </div>
    <table id="specificLocationsTable" class="table table-bordered bg-white">
        <thead>
        <th>Site</th>
        <th>Location</th>
        <th>Specific Name</th>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    let siteData;
    let currentForm = {
        inputs: {
            siteId: null,
            locationId: null,
            locationName: null,
            description: null,
            userId: "<?= $_SESSION['user_id']; ?>",
        },
        validForm: false
    };
    $(document).ready(function () {
        loadSelectBoxes();
        $('#siteSelect').on('change', function () {
            updateLocations();
            updateForm();
            loadTable(currentForm.inputs);

        });
        $('#locationSelect').on('change', function () {
            updateForm();
            loadTable(currentForm.inputs);

        });
        $('#addNewButton').on('click', function() {
            updateForm();
            if(checkForm()) {
                $.confirm({
                    title: 'Confirm Changes',
                    content: 'Add ' + currentForm.inputs.description + ' to ' + currentForm.inputs.locationName + ' as a specific location?',
                    buttons: {
                        confirm: function () {
                            save(currentForm.inputs);
                        },
                        cancel: function () {

                        },
                    }
                });
            } else {
                $.alert({
                    title: 'Error',
                    type: 'orange',
                    content: 'Please select an option on all inputs.'
            });
            }
        });
    });
    function updateForm() {
        currentForm.inputs.siteId = document.getElementById("siteSelect").value;
        currentForm.inputs.locationId= document.getElementById("locationSelect").value;
        if(document.getElementById("locationSelect").options.length !== 0) {
            currentForm.inputs.locationName = document.getElementById("locationSelect").options[document.getElementById("locationSelect").selectedIndex].text;
        }
        currentForm.inputs.description = document.getElementById("nameTextBox").value;
    }

    function checkForm() {
        let result = true;
        for (let i in currentForm.inputs) {
            if(currentForm.inputs[i] === null || currentForm.inputs[i] === "") {
                result = false;
            }
        }
        return result;
    }

    function loadSelectBoxes() {
        $.ajax({
            url: '../../Includes/QC/qc_locationsget.php',
            type: 'POST',
            data: JSON.stringify({
                id: document.getElementById("siteSelect").value
            }),
            async: false,
            success: function (response) {
                siteData = JSON.parse(response);
            },
            error: function () {
                errorAlert('Bad server response');
            }
        });
    }

    function save(formData) {
        $.ajax({
            url: '../../Includes/QC/qc_addspecificlocation.php',
            type: 'POST',
            data: JSON.stringify(formData),
            async: false,
            success: function (response) {
                if(response == 1) {
                    $.alert({title:'Success', type:'green', content:'Changes Saved!'});
                    loadTable(formData);
                } else {
                    $.alert({title:'Error', type:'red', content:'Changes could not be saved!'});
                }

            },
            error: function () {
                $.alert({title:'Error', type:'red', content:'Bad server response'});
            }
        });
    }

    function loadTable(formData) {
        $('#specificLocationsTable > tbody').empty();
        $.ajax({
            url: '../../Includes/QC/qc_specificlocationsbysiteidget.php',
            type: 'POST',
            data: JSON.stringify(formData),
            async: true,
            success: function (response) {

                response = JSON.parse(response).filter(function(x) {
                    return x.location_id === document.getElementById("locationSelect").value});
                let table = document.getElementById('specificLocationsTable').getElementsByTagName('tbody')[0];
                response.forEach(function(item) {
                    table.innerHTML = ("<tr><td>" + item.id + "</td><td>" + item.location + "</td><td>" + item.specific_location + "</td></tr>");
                })
            },
            error: function () {
                errorAlert('Bad server response');
            }
        });
    }

    function updateLocations() {
        $('#locationSelect').empty();
        let filteredData = siteData.filter(function(x) { return x.main_site_id === document.getElementById("siteSelect").value});
        for (let i=0; i < filteredData.length; i++) {
            $('#locationSelect').append('<option value="' + filteredData[i].id + '">' + filteredData[i].description + '</option>');
        }
    }

    function json2table(json, classes) {
        json = JSON.parse(json);
        var cols = Object.keys(json[0]);

        var headerRow = '';
        var bodyRows = '';

        classes = classes || '';

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        cols.map(function(col) {
            headerRow += '<th>' + capitalizeFirstLetter(col) + '</th>';
        });
        json.map(function(row) {
            bodyRows += '<tr>';

            cols.map(function(colName) {
                bodyRows += '<td>' + row[colName] + '</td>';
            })

            bodyRows += '</tr>';
        });

        return '<table class="' +
            classes +
            '"><thead><tr>' +
            headerRow +
            '</tr></thead><tbody>' +
            bodyRows +
            '</tbody></table>';
    }




</script>
<!-- HTML -->



