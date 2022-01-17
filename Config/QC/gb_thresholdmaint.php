<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_thresholdmaint.php
 * Project: Silicore
 * Description: This page allows a manager to maintain QC threshold settings.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/07/2017|mnutsch|KACE:19061 - Initial creation
 * 11/10/2017|mnutsch|KACE:19061 - Added content
 * 11/13/2017|mnutsch|KACE:19061 - Continued development
 * 06/18/2018|zthale|KACE:23088 - Paginated threshold maintenance table, separated "add new" threshold logic from table, commented out original tablesorter functionality, redesigned minor CSS.
 * 06/20/2018|zthale|KACE:23044 - Edited table properties to be more uniform among other site tables.
 * 07/05/2018|zthale|KACE:23088 - Adjusted table style properties to conform to new website redesign.
 * 07/06/2018|zthale|KACE:24019 - Added edit/remove icons in replace of text for threshold table. Enabled a confirmation message for removing a threshold. Restyled the "Add New" threshold button.
 * **************************************************************************************************************************************** */

//==================================================================== BEGIN PHP

require_once('../../Includes/QC/gb_qcfunctions.php'); //contains QC database query functions

$qcThresholdArray = getQCThresholdsAll();

$screenOptions = array("20","30","40","50","60","70","80","100","120","140","170","200","230","270","325","Pan");

//====================================================================== END PHP
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
<link href="../../Content/QC/datastyles.css" rel="stylesheet">

<style>      
      .container {
        float: left;
      }
      
      .form-group {
        max-width: 700px;
      }
  </style>

<h1>Threshold Maintenance (Granbury)</h1><br /><br />

<div class="container">
      <form name="addThresholdForm" id="addThresholdForm" action="../../Includes/QC/gb_thresholdadd.php" method="get">

        <div class="form-group">
            <label for="screenNew"><strong>Screen:</strong></label>
              <select class="form-control" id="screenNew" name="screenNew" required>
                  <?php
                    for($i = 0; $i < count($screenOptions); $i++)
                    {
                      echo("<option value='" . $screenOptions[$i] . "'>" . $screenOptions[$i] . "</option>");
                    }
                  ?>
              </select>
		</div>

	<div class="form-group">
        <label for="locationNew"><strong>Location:</strong></label>
      <select class="form-control" id="locationNew" name="locationNew" required>
              <?php
                    //get an array of objects
                    $locationObjectArray = getLocations();
                    for($j = 0; $j < count($locationObjectArray); $j++)
                    {
                      echo("<option value='" . $locationObjectArray[$j]->vars['id'] . "'>" . $locationObjectArray[$j]->vars['description'] . "</option>");
                    }
              ?>
      </select>
  </div>
    
    <div class="form-group">
      <label for="lowThresholdNew"><strong>Low Threshold:</strong></label>
            <input class="form-control" type="number" id="lowThresholdNew" name="lowThresholdNew" min="0" max="1" step="0.01" required="">
	</div>
    
    <div class="form-group">
       <label for="highThresholdNew"><strong>Low Threshold:</strong></label>
            <input class="form-control" type="number" id="highThresholdNew" name="highThresholdNew" min="0" max="1" step="0.01" required="">
     </div><br>

     <button type="submit" style="width:150px;" id="addNewButton" class="btn btn-success">Add New</button>
     
      </form><br /><br /><br />

  <table class="table table-sm table-striped table-hover dt-responsive" id='qcThresholdMaintenanceTable' name='qcThresholdMaintenanceTable' style="width: 100%;"> 
      <thead id="tableHeader">
        <tr><th>ID</th><th>Screen</th><th>Location</th><th>Low Threshold</th><th>High Threshold</th><th>Edit</th><th>Remove</th></tr>
      </thead>
      <tbody>
      <?php
            for($i = 0; $i < count($qcThresholdArray); $i++)
            {
              //load an object with Location data, so that we can display the name
              $locationObject = getLocationById($qcThresholdArray[$i]->vars['location_id']);

              //create a URL to edit this sample
              $editURL = "../../Controls/QC/gb_thresholdedit.php?thresholdID=" . urlencode($qcThresholdArray[$i]->vars['id']) . "&thresholdScreen=" . urlencode($qcThresholdArray[$i]->vars['screen']) . "&thresholdLocation=" . urlencode($qcThresholdArray[$i]->vars['location_id']) . "&thresholdLow=" . urlencode($qcThresholdArray[$i]->vars['low_threshold']) . "&thresholdHigh=" . urlencode($qcThresholdArray[$i]->vars['high_threshold']) . "&thresholdIsActive=0";            

              //create a URL that would void this sample
              $voidURL = "../../Includes/QC/gb_thresholdupdate.php?thresholdID=" . urlencode($qcThresholdArray[$i]->vars['id']) . "&thresholdScreen=" . urlencode($qcThresholdArray[$i]->vars['screen']) . "&thresholdLocation=" . urlencode($qcThresholdArray[$i]->vars['location_id']) . "&thresholdLow=" . urlencode($qcThresholdArray[$i]->vars['low_threshold']) . "&thresholdHigh=" . urlencode($qcThresholdArray[$i]->vars['high_threshold']) . "&thresholdIsActive=0";            

              echo("<tr><td title='ID'>" . $qcThresholdArray[$i]->vars['id'] . "</td><td title='Screen'>" . $qcThresholdArray[$i]->vars['screen'] . "</td><td title='Location'>" . $locationObject->vars['description'] . "</td><td title='Low Threshold'>" . $qcThresholdArray[$i]->vars['low_threshold'] . "</td><td title='High Threshold'>" . $qcThresholdArray[$i]->vars['high_threshold'] . "</td><td><a href='" . $editURL . "'><!--Edit--><i class='fa fa-edit' style='font-size:20px;color:green'></i></a></td><td><a href='" . $voidURL . "' onclick=\"return confirm('Are you sure you want to delete threshold - (Id #: " . $qcThresholdArray[$i]->vars['id'] . ")?')\"><!--Remove--><i class='fa fa-trash' style='font-size:20px;color:red'></i></a></td></tr>");
            }     
      ?>
      </tbody>
  </table><br>
</div>

<script>
      // This script sorts the dataTable for sampleLocations in descending order, based off of the sort order column.
      $(document).ready(function() {
          $('#qcThresholdMaintenanceTable').DataTable( {
              "order": [[ 0, "desc" ]]
          } );
      } );
</script>