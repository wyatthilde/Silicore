<?php
/* * *****************************************************************************
 * File Name: main.php
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 6-15-2017
 * Description:  Content file for the analytics dashboard page
 * Notes: 
 * **************************************************************************** */
?>

<link type="text/css" rel="stylesheet" href="../../Includes/developmentstyles.css">

<div class="analyticsDashboardContent">
<strong>Analytics Dashboard</strong>
<br /><br />

<span style="color: red;">DEVELOPMENT FOR THIS PAGE WAS PUT ON HOLD. SEE KACE # 16509</span><br/><br/>

<!--
Select a date range:<br/>
<label for="from">From</label>
<input type="text" id="from" name="from" class="analyticsDashboard">
<label for="to">to</label>
<input type="text" id="to" name="to" class="analyticsDashboard">
<br/>
Select the type of data to view:<br/>
<button type="button" class="analyticsDashboard" onclick="alert('under development')">Page Loads</button>
<button type="button" class="analyticsDashboard" onclick="alert('under development')">Custom Actions</button>
-->
<?php
//==================================================================== BEGIN PHP


//include other files
require_once ('../../Includes/analyticsdashboardfunctions.php'); //functions for interacting with the main_users table


  //reload graphs when date range picker changes

//create a table showing all page loads with counts
  //graph
  //drill down links
echo "<hr>";
echo "<strong>Page Loads</strong>";
echo "<table>" .
  "<tr>" .
    "<th>URL</th>" .
    "<th>Calls</th>" .
	"<th>Last Called</th>" .
  "</tr>";
$analyticsObjectArray = getPageLoads(); //output a list of users
foreach ($analyticsObjectArray as $analyticsObject) 
{
  echo "<tr>" . 
  "<td><a href=\"#\">" . $analyticsObject->vars["url"] . "</a></td>" . 
  "<td>" . $analyticsObject->vars["calls"] . "</td>" .
  "<td>" . $analyticsObject->vars["last_called"] . "</td>" .
  "</tr>";
}
echo "</table>";

//create a table showing all customer actions with counts
  //graph
  //drill down links
echo "<hr>";
echo "<strong>Custom Actions</strong>";
echo "<table>" .
  "<tr>" .
    "<th>Name</th>" .
    "<th>Calls</th>" .
	"<th>Last Called</th>" .
  "</tr>";
$analyticsObjectArray2 = getActions(); //output a list of users
foreach ($analyticsObjectArray2 as $analyticsObject2) 
{
  echo "<tr>" . 
  "<td><a href=\"#\">" . $analyticsObject2->vars["name"] . "</a></td>" . 
  "<td>" . $analyticsObject2->vars["calls"] . "</td>" .
  "<td>" . $analyticsObject2->vars["last_called"] . "</td>" .
  "</tr>";
}
echo "</table>";



  
//====================================================================== END PHP
?>
</div> <!-- Analytics Dashboard content -->
<script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>

<!-- HTML -->





