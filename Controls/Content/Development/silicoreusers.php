<?php
/* * *****************************************************************************************************************************************
 * File Name: silicoreusers.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/30/2017|nolliff|KACE:18394 - Initial creation
 * 08/31/2017|nolliff|KACE:18394 - Added basic table functionality, data is displayed
 * 08/31/2017|nolliff|KACE:18394 - Added CSS and tablesort
 * 08/31/2017|nolliff|KACE:18394 - Added javascript function to interpret department ID
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');


// Call sproc and populate array with it, database connection is now called with a function below
$dbconn = dbmysql();//returns connection string
$query = 'CALL sp_adm_UserGetAll';//stored sproc to get all values from table, always name fields and do not use SELECT *
$results = $dbconn->query($query);

$rownumber = 0;

//php functions
function dbmysql()
{
  try
    {
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
    (
      $dbc['silicore_hostname'],
      $dbc['silicore_username'],
      $dbc['silicore_pwd'],
      $dbc['silicore_dbname']
    );
    return $dbconn;
    
    mysqli_close($dbconn);
    }
  catch (Exception $e)
  {
    $_SESSION['sample_error'] = "Error while trying to get data" . $e;   
  }
  
}

//========================================================================================== END PHP
?>
<script>
$(document).ready
  (
    function ()
    {
      REinit();
    }
  ); 
//  Calls the table sort
  function REinit()
  {
    $("#myTable").tablesorter();
  }
  
  function departmentSwitch (id)
  {
    switch(id)
    {
      case 1:
        return "General";
        break;
      case 2:
        return "Development";
        break;
      case 3:
        return "Production";
        break;
      case 4:
        return "Quality Control";
        break;    
      case 5:
        return "Loadout";
        break;
      case 6:
        return "Logistics";
        break;      
      case 7:
        return "Accounting";
        break;    
      case 8:
        return "Safety";
        break;        
      case 9:
        return "Human Resources";
        break;
      case 10:
        return "Information Technology";
        break;
      default:
        return "No Department";
    }
  }
  function userTypeSwitch (type)
  {
    switch(type)
    {
      case 1:
        return "Standard";
        break;
      case 2:
        return "Shift Lead";
        break;
      case 3:
        return "Manager";
        break;
      case 4:
        return "Director";
        break;    
      case 5:
        return "Administrator";
        break;
      case 6:
        return "Read Only";
        break;
      default:
        return "No Type ID found";
    }
  }

</script>

<!-- HTML -->
<h2>Silicore Users</h2>
<div class='usertable'>  
  <!--Use table class to call tablesort and pass the function the table name -->
  <table id='myTable' class='tablesorter'>
    <thead>
      <tr>
        <th>ID&ensp;</th>
        <th>First Name&ensp;</th>
        <th>Last Name</th>
        <th>Display Name</th>
        <th>Email</th>
        <th>Company&ensp;</th>
        <th>Department</th>
        <th>User Type</th>
        <th>Last Login</th>
        <th>Start Date</th>
        <th>Separation Date</th>
        <th>Active&ensp;</th>
        <th>Labtech&ensp;</th>
        <th>Sampler&ensp;</th>
        <th>Operator&ensp;</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php
        while ($result = $results->fetch_assoc())
        {
          echo
          ("        
            <tr>
              <td>{$result['id']}</td>
              <td>{$result['first_name']}</td>
              <td>{$result['last_name']}</td>
              <td>{$result['display_name']}</td>
              <td>{$result['email']}</td>
              <td>{$result['company']}</td>
              <td id='department{$rownumber}'>
                <script>
                 document.getElementById('department{$rownumber}').innerHTML = departmentSwitch({$result['main_department_id']})
                </script>
              </td>
              <td id='user_type_id{$rownumber}'>
                <script>
                 document.getElementById('user_type_id{$rownumber}').innerHTML = userTypeSwitch({$result['user_type_id']})
                </script>
              </td>
              <td>".($result['last_logged'] != null ? $result['last_logged'] : "0000-00-00 00:00:00" )."</td>
              <td>".($result['start_date'] != null ? $result['start_date'] : "0000-00-00" )."</td>
              <td>".($result['separation_date'] != null ? $result['separation_date'] : "0000-00-00" )."</td>
              <td>
                <span style='display:none'>{$result['is_active']}</span>
                <input type='checkbox' ".($result['is_active'] == 1 ? "checked" : '')." disabled>
              </td>
              <td>
                <span style='display:none'>{$result['qc_labtech']}</span>
                <input type='checkbox' ".($result['qc_labtech'] == 1 ? "checked" : '')." disabled>
              </td>
              <td>
                <span style='display:none'>{$result['qc_sampler']}</span>
                <input type='checkbox' ".($result['qc_sampler'] == 1 ? "checked" : '')." disabled>
              </td>              
              <td>
                <span style='display:none'>{$result['qc_operator']}</span>
                <input type='checkbox' ".($result['qc_operator'] == 1 ? "checked" : '')." disabled>
              </td>
              <td>
                <form action='../../Controls/Development/silicoreuseredit.php' method='post'>
                  <input type='hidden' name='edit_id' value='{$result['id']}'>
                  <input type='submit' value='Edit'>
                </form>
              </td>
            </tr>
          ");
                
          $rownumber++;
        }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="100:">&nbsp;</td>
      </tr>
    </tfoot>
  </table>
</div>