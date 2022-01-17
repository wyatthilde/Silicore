<?php


require_once('../../Includes/security.php');

$userid = $_SESSION['user_id'];

$dbc = databaseConnectionInfo();
$dbconn = new mysqli
  (
    $dbc['mysql_hostname'],
    $dbc['mysql_username'],
    $dbc['mysql_pwd'],
    $dbc['mysql_dbname']
  );
  
if($dbconn->connect_error)
{
  die("Connection failed: " . $dbconn->connect_error);
}
$sql = "CALL sp_UserTypeGet($userid)";
$result = $dbconn->query($sql);
$dbconn->close();

$row = $result->fetch_assoc();

      switch($row['user_type_id'])
      {
        case 5:
          $permission = 5;
          break;
        case 4:
          $permission = 4;
          break;
        case 3:
          $permission = 3;
          break;
        case 2:
          $permission = 2;
          break;
        case 1:
          $permission = 1;
          break;
        case 0:
          $permission = 0;
          break;
      }
	  

//echo($userid . '<br>' . $permission);



?>

<div class="list-group" style="max-width:25px;">
  <?php 

$dbc = databaseConnectionInfo();
$dbconn = new mysqli
  (
    $dbc['mysql_hostname'],
    $dbc['mysql_username'],
    $dbc['mysql_pwd'],
    $dbc['mysql_dbname']
  );
  
if($dbconn->connect_error)
{
  die("Connection failed: " . $dbconn->connect_error);
}

$sql1 = "CALL sp_MainNavLinksByPermission($permission)";
$result1 = $dbconn->query($sql1);
$dbconn->close();

$linkToFolder = '';
$linkToFile = '';
$linkName = '';
	while($row1 = $result1->fetch_assoc()) 
        {
		  $linkName = $row1['link_name'];
          $linkToFolder = $row1['folder'];
          $linkToFile = $row1['web_file'];
          echo ('<a class="list-group-item list-group-item-action" href=/Build022/Controls' . $linkToFolder .  $linkToFile . '>' . $linkName . '</a>');
        } 
   ?>
</div> 
