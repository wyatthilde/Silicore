<?php
/* * *****************************************************************************
 * File Name: sievetracking.php
 * Project: Silicore
 * Author: mnutsch
 * Date Created: 6-16-2017
 * Description: 
 * Notes: 
 * **************************************************************************** */


//==================================================================== BEGIN PHP
 //include other files
require_once('../../Includes/QC/gb_qcfunctions.php'); //contains database connection info
require_once('../../Includes/security.php'); //contains database connection info


//====================================================================== END PHP
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css"> 
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"defer="defer"></script>
<script type="text/javascript" src="../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js"></script>
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>


<div id="qc_groups" class="container-fluid" style="margin-bottom:100px">
  <h3>Sieve Stacks</h3> 
  <button id="add_new_button" name="add_new_button" class="btn" type="button" onclick="showForm();">Add New</button>

  <form action="../../Includes/QC/sievestackaddprocess.php" method="post">
    <legend>Create a Sieve Stack:</legend><br/>
    <div class="form-group">
    <label for="stackdescription">Description:</label>
    <input class="form-control" type="text" name="stackdescription">
    </div>
    <div class="form-group">
    <label for="siteid">Site:</label>
    <select class="form-control" name='siteid' id='siteId'>
    <option value=""></option>
    <?php
    $siteObjectArray = getSites(); //get a list of site options
    foreach ($siteObjectArray as $siteObject) 
    {
      if($siteObject->vars["id"] == $sampleObject->vars['siteId'])
      {
        echo "<option value='" . $siteObject->vars["id"] . "' selected='selected'>" . $siteObject->vars["description"] . "</option>";
      }
      else 
      {
        echo "<option value='" . $siteObject->vars["id"] . "'>" . $siteObject->vars["description"] . "</option>";
      }
    }
    ?>
    </select>
    <label for="numberofsieves">Number of Sieves:</label>
    <input type="number" name="numberofsieves" min="2" max="10" value="10"><br/><br/>
    <table>
    <tr><th>ID</th><th>Screen Size</th><th>Start Weight</th></tr>
    <tr><td>1</td><td><input type="text" name="screensize1"></td><td><input type="text" name="startweight1"></td></tr>
    <tr><td>2</td><td><input type="text" name="screensize2"></td><td><input type="text" name="startweight2"></td></tr>
    <tr><td>3</td><td><input type="text" name="screensize3"></td><td><input type="text" name="startweight3"></td></tr>
    <tr><td>4</td><td><input type="text" name="screensize4"></td><td><input type="text" name="startweight4"></td></tr>
    <tr><td>5</td><td><input type="text" name="screensize5"></td><td><input type="text" name="startweight5"></td></tr>
    <tr><td>6</td><td><input type="text" name="screensize6"></td><td><input type="text" name="startweight6"></td></tr>
    <tr><td>7</td><td><input type="text" name="screensize7"></td><td><input type="text" name="startweight7"></td></tr>
    <tr><td>8</td><td><input type="text" name="screensize8"></td><td><input type="text" name="startweight8"></td></tr>
    <tr><td>9</td><td><input type="text" name="screensize9"></td><td><input type="text" name="startweight9"></td></tr>
    <tr><td>PAN</td><td><input type="text" name="screensize10" value="PAN" readonly></td><td><input type="text" name="startweight10"></td></tr>
    </table>
    <br/>    
    <input type="submit" value="Save"><br/><br/>
    <hr>
    </div>
  </form>  
  <!-- sievestackform -->

  <div class="listofsievestacks">
  <table id="sievesTable" class="table table-striped table-bordered dt-responsive">
    <thead>
      <tr>
        <th>ID</th>
        <th>Description</th>
        <th>Main Site ID</th>
        <th>Active</th>
        <th>Retire</th>
      </tr>
    </thead>
      <tbody>
        
          <?php

          $ObjectArray = getSieveStacks(); //get a list of sieve stacks

          foreach ($ObjectArray as $Object) 
          {
            echo "<tr> <td>" . $Object->vars["id"] . "</td>" . 
            "<td>" . $Object->vars["description"] . "</td>" . 
            "<td>" . $Object->vars["mainSiteId"] . "</td>" . 
            "<td>" . $Object->vars["isActive"] . "</td>" .  
            "<td><a href='#' onclick=\"return alert('This feature is coming soon.');\">Retire</a></td></tr>";
          }
          ?>
       
      </tbody>
  </table>
  </div> 
</div> 
<script>
function showForm() 
{
  document.getElementById('sievestackform').style.display = 'block';
}

  $(document).ready(function() {
    var table = $('#sievesTable').DataTable( {
        dom: 'frtip',
        scrollY:        "450px",
        scrollX:        false,
         
        scrollCollapse: true,
        paging:         true,
        pageLength:     10,
        fixedColumn:    false,
        order: [
                        1,
                        'desc'
        ]
        
    }

            );


} );

</script>







