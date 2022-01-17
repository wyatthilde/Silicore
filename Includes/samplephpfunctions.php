<?php
/* * *****************************************************************************************************************************************
 * File Name: samplephpfunctions.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/31/2017|nolliff|KACE:17 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('security.php');
require_once ('Security/dbaccess.php');

//series checking if ajax passed a value for various functions, 
//the downside to this method is all variables must have different names to avoid calling hte wrong function
//this could be solved by an additional que such as call_SetToInactive = 1 and checking to see if that is set

if(isset($_POST['void_id']) && $_POST['void_id'] != null )
{
  $id = filter_input(INPUT_POST, 'void_id');
  setToInactive($id);
}
elseif(isset($_POST['void_id']) && $_POST['void_id'] == null)
{
  $_SESSION['sample_error'] = "ID was not entered";
}

if(isset($_POST['active_id'])&& $_POST['active_id'] != null )
{
  $id = filter_input(INPUT_POST, 'active_id');
  setToActive($id);
}
elseif(isset($_POST['active_id']) && $_POST['active_id'] == null)
{
  $_SESSION['sample_error'] = "ID was not entered";
}

if(isset($_POST['fname']) && $_POST['fname'] != null )
{
  if(isset($_POST['lname']) && $_POST['lname'] != null )
  {
    $fname = filter_input(INPUT_POST, 'fname');
    $lname = filter_input(INPUT_POST, 'lname');
    $userID = $_SESSION['user_id'];
    
    addNameToDB($fname, $lname, $userID);    
  }
  elseif(isset($_POST['lname']) && $_POST['lname'] == null)
  {
    $_SESSION['sample_error'] = "Last name was left blank or not entered";
  } 
}  
elseif(isset($_POST['fname']) && $_POST['fname'] == null)
  {
    $_SESSION['sample_error'] = "First name was left blank or not entered";
  }

if(isset($_POST['edit_id']) && $_POST['edit_id'] != null )
{
  if(isset($_POST['fname_edit']) && $_POST['fname_edit'] != null )
  {
    if(isset($_POST['lname_edit']) && $_POST['lname_edit'] != null )
    {
      $id = filter_input(INPUT_POST, 'edit_id');
      $fname = filter_input(INPUT_POST, 'fname_edit');
      $lname = filter_input(INPUT_POST, 'lname_edit');
      $userID = $_SESSION['user_id'];

      editEntry($id, $fname, $lname, $userID);    
    }
    elseif(isset($_POST['lname_edit']) && $_POST['lname_edit'] == null)
    {
      $_SESSION['sample_error'] = "Last name was left blank or not entered";
    }
  } 
  elseif(isset($_POST['fname_edit']) && $_POST['fname_edit'] == null)
  {
    $_SESSION['sample_error'] = "First name was left blank or not entered";
  }
} 
elseif(isset($_POST['edit_id']) && $_POST['edit_id'] == null)
{
  $_SESSION['sample_error'] = "Id left blank";
}

//function that returns connection string
function dbmssql()
{
try
  {
    $dbcreds = databaseConnectionInfo();
    $connarray = array
    (
      "Database" => $dbcreds['silicoreplc_dbname'],
      "Uid" => $dbcreds['silicoreplc_dbuser'],
      "PWD" => $dbcreds['silicoreplc_pwd']
    );
    $dbconn = sqlsrv_connect($dbcreds['silicoreplc_dbhost'],$connarray);

    return $dbconn;
  }
catch (Exception $e)
  {
    $_SESSION['sample_error'] = "Error while trying to get data" . $e;   
  }
}

//Echos checked attribute
function setToCehcked($checkInt)
{
  if($checkInt==1)
  {
    echo("checked = 'checked'"); 
  }
}

//sets record to inactive
function setToInactive($id)
{
  $dbconn = dbmssql();
  $idArray = array($id);
  $query = "Execute sp_dev_TestTableDeactivate @id = ?";  
  $stmt = sqlsrv_query($dbconn, $query, @$idArray);
  if( $stmt === false ) 
    {
     $_SESSION['sample_error'] = "Something went wrong: ".sqlsrv_errors();
    }
}

//sets record to active
function setToActive($id)
{
  $dbconn = dbmssql();
  $idArray = array($id);
  $query = "Execute sp_dev_TestTableActivate @id = ?";  
  $stmt = sqlsrv_query($dbconn, $query, @$idArray);
  if( $stmt === false ) 
    {
     $_SESSION['sample_error'] = "Something went wrong: ".sqlsrv_errors();
    }
}

//add name to database
function addNameToDB($fname,$lname,$userID)
{
  $dbconn = dbmssql();
  $idArray = array($fname,$lname,$userID);
  $query = "Execute sp_dev_TestTableInsert @fname = ?, @lname = ?, @create_user_id = ?";  
  $stmt = sqlsrv_query($dbconn, $query, @$idArray);
 
  if( $stmt === false ) 
  {
    $_SESSION['sample_error'] = "Something went wrong: ".sqlsrv_errors();
  }
  else
  {
    $_SESSION['success_message'] = "Successfully added record"; 
    $_SESSION['sample_error'] = "";
  }

}

//edit entry
function editEntry($id,$fname,$lname,$userID)
{
  $dbconn = dbmssql();
  $idArray = array($id,$fname,$lname,$userID);
  $query = "Execute sp_dev_TestTableUpdate @id=?, @fname = ?, @lname = ?, @edit_user_id = ?";  
  $stmt = sqlsrv_query($dbconn, $query, @$idArray);
 
  if( $stmt === false ) 
  {
    $_SESSION['sample_error'] = "Something went wrong: ".sqlsrv_errors();
  }
  else
  {
    $_SESSION['success_message'] = "Successfully updated record";
    
  }

}

//========================================================================================== END PHP
?>

<!-- HTML -->
