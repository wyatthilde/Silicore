<?php
/* * *****************************************************************************************************************************************
 * File Name: tceqreport.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17422 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP


//========================================================================================== END PHP
?>

<!-- HTML -->
<script>
 $(function() 
 {
   var today = new Date()
   var lastYear = new Date();
   lastYear.setFullYear(lastYear.getFullYear() -1);
   
  $("#start-date").datepicker({ dateFormat: 'yy-mm-dd' }).datepicker("setDate",lastYear);
  $("#end-date").datepicker({ dateFormat: 'yy-mm-dd' }).datepicker("setDate",today);
 });
</script>

<h1>TCEQ Production Report</h1>
<div class="prod-datepicker">
  <input type="text" id="start-date" >
  <strong>to</strong>
  <input type="text" id="end-date" > 
  <input type="submit" value="Submit">
</div>

<table style="width:95%">
  <tr>
    <td style="padding-right:100px">
      <div class="prodtable">
        <table style="width:100%;">
          <thead>
            <tr>
              <th colspan="5">Wet Plant #1</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>October, 2016</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>November, 2016</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>December, 2016</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>January, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>February, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>March, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>April, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>May, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>June, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>July, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>August, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>September, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="5" style="background:#fff!important;">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Total</strong></td>
              <td>&nbsp;</td>
              <td><strong>0</strong></td>
              <td><strong>0</strong></td>       
              <td><strong>0</strong></td>
            </tr> 
          </tbody>
          <tfoot>
            <tr>
              <td style="text-color"><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
    <td>
      <div class="prodtable">
        <table style="width: 100%">
          <thead>
            <tr>
              <th colspan="5">Wet Plant #2</th> 
            </tr>
            <tr>
              <th>Month</th>
              <th>Moisture Rate</th>
              <th>Dry Tons</th>
              <th>Uptime</th>
              <th>Tons/Hour</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>October, 2016</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>November, 2016</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>December, 2016</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>January, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>February, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>March, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>April, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>May, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>June, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>July, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>August, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>September, 2017</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td style="background:#fff!important;" colspan="5">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Total</strong></td>
              <td>&nbsp;</td>
              <td><strong>0</strong></td>
              <td><strong>0</strong></td>       
              <td><strong>0</strong></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td><i>Max Allowed</i></td>
              <td>&nbsp;</td>
              <td>0</td>
              <td>0</td>       
              <td>0</strong</td>
            </tr>
          </tfoot>
        </table> 
      </div>
    </td>
  </tr>
</table>