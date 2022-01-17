<?php
/* * *****************************************************************************************************************************************
 * File Name: filesget.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/06/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

include('../../Includes/Security/database.php');

$database = new Database();

$permString= filter_input(INPUT_POST, 'formData');
$permObj = json_decode($permString, true);
//print_r($permObj);


$dept_id = $permObj['departmentId'];
$departmentName = strtolower($permObj['departmentName']);


if($dept_id !== 4)
  {
  $permissionLevel = $permObj['permArry'][0]['vista']['granbury'][$departmentName];
  }
  else
    {
        $permissionLevelGb = $permissionLevelTl = $permissionLevelWt = -1;
    
      if(isset($permObj['permArry'][0]['vista']['granbury']['qc']))
        {
          $permissionLevelGb = $permObj['permArry'][0]['vista']['granbury']['qc'];
        }
      if(isset($permObj['permArry'][0]['vista']['tolar']['qc']))
        {
          $permissionLevelTl = $permObj['permArry'][0]['vista']['tolar']['qc'];
        }
      if(isset($permObj['permArry'][0]['vista']['west_texas']['qc']))
        {
          $permissionLevelWt = $permObj['permArry'][0]['vista']['west_texas']['qc'];
        }
        $permissionLevel = max($permissionLevelGb,$permissionLevelTl,$permissionLevelWt);
    }

//echo $permissionLevel;

$categoryRes = json_decode($database->get("sp_adm_CategoryByPermissionGet('" . $departmentName . "'," . $permissionLevel . ");"));
//print_r($categoryArry);

$filesread = array();


foreach($categoryRes as $category)
  {
    $id = $category->id ;
//      echo "<br>" . $id;

    //$filesread = json_encode(array_merge(json_decode($filesread, true),json_decode($newFiles, true)));
    $newfiles = array(json_decode($database->get("sp_adm_FilesByCategoryGet(" . $id . ");"),true));
    
//    print_r($newfiles);
    
    if($newfiles[0] !== 0){
//    print_r($newfiles);
    $filesread = array_merge($filesread,$newfiles);
    }
    
    
    
  }
//  echo($ids);
//$filesread = $database->get("sp_adm_FilesByDepartmentGet(" . $dept_id . ");");
$fileString = preg_replace(array('/\],\[/','/\[{2,}/','/\]{2,}/') ,array(',','[',']'), json_encode($filesread));

  echo $fileString;




//========================================================================================== END PHP
?>

