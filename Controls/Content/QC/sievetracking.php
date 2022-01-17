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
require_once('../../Includes/qcfunctions.php'); //contains database connection info


//====================================================================== END PHP
?>

<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">

<div id="qc_groups" class="tabcontent">
  <h3>Sieve Stacks</h3> 
  <button id="add_new_button" name="add_new_button" class="add_new_button" type="button" onclick="showForm();">Add New</button>
  <div class="sievestackform" id="sievestackform">
  <form action="../../Controls/QC/sievestackaddprocess.php" method="post">
    <br/>
    <legend>Create a Sieve Stack:</legend><br/>
    <label for="stackdescription">Description:</label>
    <input type="text" name="stackdescription"><br/>
    <label for="siteid">Site:</label>
    <select name='siteid' id='siteId'>
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
    </select><br/><br/>
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
  </form>  
  </div>   <!-- sievestackform -->

  <div class="listofsievestacks">
  <table>
    <tr>
      <th>ID</th>
      <th>Description</th>
      <th>Main Site ID</th>
      <th>Active</th>
      <th></th>
    </tr>
    <?php

    $ObjectArray = getSieveStacks(); //get a list of sieve stacks

    foreach ($ObjectArray as $Object) 
    {
      echo "<tr>" . 
      "<td>" . $Object->vars["id"] . "</td>" . 
      "<td>" . $Object->vars["description"] . "</td>" . 
      "<td>" . $Object->vars["mainSiteId"] . "</td>" . 
      "<td>" . $Object->vars["isActive"] . "</td>" .  
      "<td><a href='#' onclick=\"return alert('This feature is coming soon.');\">Void</a></td>" . 
      "</tr>";
    }
    ?>
  </table>
  </div> <!-- listofsievestacks -->
</div> <!-- tabcontent -->
<script>
function showForm() 
{
  document.getElementById('sievestackform').style.display = 'block';
}
</script>







