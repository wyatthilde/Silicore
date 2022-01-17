<?php
/* * ***************************************************************************************************************************************
 * File Name: mssqlphpsproc.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/18/2017|nolliff|KACE:17603 - Initial creation
 * 
 * ****************************************************************************************************************************************/


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/samplephpfunctions.php'); //contains sample functions
// Call sproc and populate array with it, database connection is now called with a function below
$dbconn = dbmssql();//returns connection string
$query = 'EXEC sp_dev_TestTableRead';//stored sproc to get all values from table, always name fields and do not use SELECT *
$results = sqlsrv_query($dbconn, $query);//store values in an array, normally a more descriptive name should be used
echo var_dump($results);
// Declare counter
$rownumber = 0;//counter is used to dynamically give unique idenifiers to rows

$error_message="";
$success_message="";

//Checks to see if an error message has been set and resets it to null if so.
if (isset($_SESSION['sample_error']))
  {
    $error_message = "Error:".$_SESSION['sample_error'];
    $_SESSION['sample_error'] = null;
  }

//does the same for a success message.
if (isset($_SESSION['success_message']))
  {
    $success_message = $_SESSION['success_message'];
    $_SESSION['success_message'] = null;
  }
//========================================================================================== END PHP
?>
<!-- Java and jquery functions-->

<script>
$(document).ready
  (
    function ()
    {
      //the REinit function would hold any javascript functions that should be run upon loading the page.
      REinit();
    }
  ); 
//  Calls the table sort
  function REinit()
  {
    $("#myTable").tablesorter({});
  }



  //declaring global varaibles for allowing only one edit buttton, thinking on how to avoid this as it is not good practice
  var OldRowNumber;
  var OldFnameInner;
  var OldLnameInner;

  //Hides edit button, shows edit submission button and converts the innerhtml of the row to an editible text box
  function makeEditable(rownumber)
  {
    //Simple regex to remove white space, not sure why but I was getting several spaces normally
    var nspreg = new RegExp("[ ]+","g");
    //Storeing ids in varibles makes for easy refactoring later
    var fname = "fnameEdit"+rownumber;
    var lname = "lnameEdit"+rownumber;
    var editButtonID = "editButton"+rownumber;
    var submitButtonID = "submitButton"+rownumber;
    
    //applies regex filter to innerhtml of the first and last name fields passed to it
    var fnameText = document.getElementById(fname).innerHTML.replace(nspreg,"");
    var lnameText = document.getElementById(lname).innerHTML.replace(nspreg,"");
  
    //revert other edit field back to original state if there is an old row number set
    if(typeof(OldRowNumber) !== 'undefined')
    {
      var oldFname = "fnameEdit"+OldRowNumber;
      var oldLname = "lnameEdit"+OldRowNumber;
      var oldEditButton = "editButton"+OldRowNumber;
      var oldSubmitButton = "submitButton"+OldRowNumber;
      
      //finds each element by the OldRowNumber and sets it to its beginning state, the altered data will be gone
      document.getElementById(oldEditButton).style.display = "";//display:nones opposite is effectivly "" ironically
      document.getElementById(oldSubmitButton).style.display = "none";
      document.getElementById(oldFname).innerHTML = OldFnameInner;
      document.getElementById(oldLname).innerHTML = OldLnameInner;
    }
    //replaces the two table cells with input boxes and populates it with the cleaned text
    document.getElementById(fname).innerHTML = "<input class='testtextinput' type='text' id = 'editedFname' value='"+fnameText+"'>"; 
    document.getElementById(lname).innerHTML = "<input class='testtextinput' type='text' id = 'editedLname' value='"+lnameText+"'>";
    
    //shows submission button and hides the edit button
    document.getElementById(editButtonID).style.display = "none";
    document.getElementById(submitButtonID).style.display ="";
    
    //sets global variables used to revert the fields to a their original state
    OldFnameInner = fnameText;
    OldLnameInner = fnameText;
    OldRowNumber = rownumber;    
  }
  function activeChecked(active, row)
  {
    var rowID = "activeCheck"+row;
    if(active === 1)
    {
      document.getElementById(rowID).checked = true;
    }
  }
  function hiddenChecked(visible, row)
  {
    var rowID = "hiddenCheck"+row;
    if(visible === 1)
    {
      document.getElementById(rowID).checked = true;
    }
  }

</script>    

<!--ajax functions-->
<script>
  
  //all the ajac functions are similar so I will only comment on one
  function setToInactive(void_id)
  {
    $.ajax
            ({
              url: '../../Includes/samplephpfunctions.php',
              type: 'POST',
              data: {void_id: void_id}
            });
    //location.reload(true);
  };
  
  function setToActive(active_id)
  {
    $.ajax
            ({
              url: '../../Includes/samplephpfunctions.php',
              type: 'POST',
              data: {active_id: active_id}
            });
    location.reload(true);
  };
  
  function addNameToDB(fname, lname)
  {
    $.ajax
            ({
              url: '../../Includes/samplephpfunctions.php',
              type: 'POST',
              data:
                      {
                        fname: fname,
                        lname: lname
                      }
            });
    location.reload(true);
    REinit();
  };
  
  function editEntry(id, fname, lname)
  {
    $.ajax
            ({
              url: '../../Includes/samplephpfunctions.php',//where all php functions are
              type: 'POST',//post is used to acutally pass the data do the functions page
              data:
                      {
                        edit_id: id,//field name for php function argument on the left, argument passed to the ajax funtion on the right
                        fname_edit: fname,
                        lname_edit: lname
                      }
            });
  //location.reload is used to acutally populate the new or altered data into the page, without it the chages would be made but not visible
    
    location.reload(true);

  }
</script>

<!-- HTML -->
<script type='text/javascript' src='../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js'></script>
<!--Normally all css should be kept to stylecommon and stylestructure and overwritten with a class-->
<link rel="stylesheet" href="../../Includes/samplesqlstyles.css">
<!--Echo error or success messages if they are set, divs are hidden otherwise-->

<?php 
  if($error_message != "")
  { 
    echo
    ("
      <div class='ui-widget' id='errorWidget'>
        <div class='ui-state-error ui-corner-all' style='padding: 0 .7em; width:90%;'>
          <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>
            <strong>{$error_message}</strong> 
          </p>
        </div>
      </div>
    <br>
    ");
  }

  if ($success_message != "")
  {
    echo
    ("
      <div class='ui-widget' id='successWidget'>
        <div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;  width:90%;'>
          <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
            <strong>{$success_message}</strong>
          </p>
        </div>
      </div>
      <br>
    "); 
  } 
?>

<!--Used a div to set css-->
<div class='datagrid'>  
  <!--Use table class to call tablesort and pass the function the table name -->
  <table id='myTable' class='tablesorter'>
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Creator</th>
        <th>Date Created</th>
        <th>Last Editor</th>
        <th>Last Edit Date</th>
        <th>Active</th>
        <th>Visible</th>
        <th>Edit</th>
        <th>Deactivate</th>
        <th>Reactivate</th>
      </tr>
    </thead>
    <tbody>

<?php while ($result = sqlsrv_fetch_array($results))
{
  echo
    ("
      <tr>
        <!--rownumber is used to dynamically identify each field that can be edited-->
        <!--Hightlight class is used on all cells that ought to be highlighted-->
        <td>
          <div id='idEdit{$rownumber}'>{$result['id']}</div>
        </td>
        
        <td>
          <div id='fnameEdit{$rownumber}'> {$result['fname']}</div>
        </td>
        
        <td>
          <div id='lnameEdit{$rownumber}'>{$result['lname']}</div>
        </td>
        
        <td>
          {$result['create_user_id']} 
        </td>
        
        <td>
          {$result['create_date']->format('Y-m-d H:i:s')}
        </td>
        
        <td>
          ".($result['edit_user_id'] != null ? $result['edit_user_id'] : 'N/A')."
       </td>
        
        <td>
        ".($result['edit_date'] != null ? $result['edit_date']->format('Y-m-d H:i:s') : "0000-00-00 00:00:00" )."</td>
        
        <td>
          <input type='checkbox' id='activeCheck{$rownumber}'>
        </td>
        
        <td>
          <input type='checkbox' id='hiddenCheck{$rownumber}'> 
        </td>
        
        <td>
          <button id='editButton{$rownumber}' class='testtablebutton' onclick='makeEditable({$rownumber})'>
            Edit
          </button>  
          <button style='display:none' id='submitButton{$rownumber}' class='testtablebutton' 
                    onClick= \"editEntry(
                                {$result['id']},
                                document.getElementById('editedFname').value,
                                document.getElementById('editedLname').value);\">Submit Edit
          </button>
        </td>
        <td>
          <button type='button' class='testtablebutton' onclick='setToInactive({$result['id']})'>VOID</button>
        </td>
        <td>
          <button type='button' class='testtablebutton' onclick='setToActive({$result['id']})'>Activate</button>
        </td>
      </tr>
      <script> 
        activeChecked({$result['is_active']}, {$rownumber}) 
        hiddenChecked({$result['is_hidden']}, {$rownumber})
      </script> "
    );
  $rownumber++;          
} 
?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">New Entry: </td>
        <td colspan='4'>
            <label>First Name: </label>
            <!--the style is overwitten here so the label will be on the same line-->
            <input  style="width: 80%;" class= 'testtextinput' type='text' id='fname' pattern="[A-Za-z]" title="Names only, please">
        </td>
        <td colspan='5'>
          <label style='width:20%'> Last Name: </label>
          <!--same is done for last name-->
          <input  style="width: 80%;" class= 'testtextinput' type='text' id='lname' pattern="[A-Za-z]" title="Names only, please">
        </td>
        <td colspan-='2'>
          <!--passes the values in the field to the addNameToDB function-->
          <button type='button' class="testtablebutton"
            onclick="addNameToDB
              (
                getElementById('fname').value,
                getElementById('lname').value
              );"
          >
            Submit
          </button>
        </td>
      </tr>
    </tfoot>
  </table>
</div>

<?php sqlsrv_close(dbmssql()); ?>
