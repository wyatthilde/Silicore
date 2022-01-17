<?php
/* * *****************************************************************************************************************************************
 * File Name: getData.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/29/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');

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

// ***** Input needs to be sanitized!!! *****
		$main_department = $_GET['main_department'];
    
		$dbconn = dbmysql();
        $query = "CALL sp_dev_UserByDeptGet('$main_department')";
    
		$managers = mysqli_query($dbconn, $query) or die("Error in Selecting " . mysqli_error($dbconn));
    
	    while($row = mysqli_fetch_assoc($managers))
		{
			 echo '<option value="' .$row['id'] .'">' .$row['id'] . ' - ' .$row['first_name'] . ' ' . $row['last_name'].'</option>';
		}
    
//========================================================================================== END PHP
?>

<!-- HTML -->