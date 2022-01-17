<?php

/* * *****************************************************************************************************************************************
 * File Name: file_replace.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/09/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
include('../../Includes/Security/database.php');

$database = new Database();

$uploadCap = 8589934592;
$fileArry = ['jpg','png','jpeg','gif','pdf','rtf','txt','doc','dot','wbk','docx','docm','dotx','dotm','docb','csv','xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw','ppt','pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];
$doc_id= filter_input(INPUT_POST, 'fileId');
$newFilename = filter_input(INPUT_POST, 'filename');
$old_doc_path =  filter_input(INPUT_POST, 'oldPath');
$user_id = filter_input(INPUT_POST, 'userId');
$username = filter_input(INPUT_POST, 'username');
$fileDepartmentName = filter_input(INPUT_POST, 'deptName');

$targetDir = '../../Files/' . $fileDepartmentName . '/';
$dateString = date("ymdHis");


$fileExt = preg_replace('/\s+/', '',strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION)));
$fileSize = $_FILES["file"]["size"];
$baseName = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
$fileName = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME) . "_" . $username . "_" . $dateString;

$targetFile = $targetDir . $fileName . '.' . $fileExt;
$old_file =  basename($old_doc_path);

$userUploadsSql = 'sp_adm_DocumentUploadSumGet('.$user_id.')';
$userUploads= json_decode($database->get($userUploadsSql),true)[0]["upload_sum"];

if(!is_numeric($userUploads) || $userUploads=='' || $userUploads == null)
  {
    $userUploads=0;
   }

if($userUploads >= $uploadCap)
  {
    header('HTTP/1.1 500 Upload Limit Reached');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'User has exceeded or met upload limit ', 'code' => 9999)));
  }

if (file_exists($targetFile)) {        
//  echo 'File Already Exists';
  header('HTTP/1.1 500 Duplicate File');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode(array('message' => 'File Already Exists ', 'code' => 1441)));
}
// Check file size
if ($fileSize > 5 * 1048576)//5mgs
{    
//  echo 'File too large, 5mb is the limit';
  header('HTTP/1.1 500 File too large');
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode(array('message' => 'File too large', 'code' => 889)));
}
// Allow certain file formats
if(!in_array($fileExt, $fileArry)) 
{
//  echo 'Unsuported File Type ' . $fileExt;
  header('HTTP/1.1 500 Unsupported File Type' . $fileExt);
  header('Content-Type: application/json; charset=UTF-8');
  die(json_encode(array('message' => 'Unsuported File Type ' . $fileExt, 'code' => 613)));
}
$fileType = checkType($fileExt);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
      

      $fileSQL = "sp_adm_DocumentReplaceFile("
          . "'" . $doc_id . "',"
          . "'" . $baseName . "',"
          . "'" . $fileExt . "',"
          . "'" . $fileType . "',"
          . "'" . $fileSize . "',"
          . "'" . $targetFile . "',"
          . "'" . $user_id . "')";
      echo $fileSQL;
      $success = json_decode($database->get($fileSQL),true)[0]['1'];
      if($success == 1)
        {
          rename("../../Files/" . $fileDepartmentName . "/" . $old_file, "../../Files/Archive/" . $old_file);
          $changeLogSQL = "sp_adm_DocumentChangeLogInsert(" . $user_id . "," . $doc_id . ",'Replace Document: " . $fileType . "')"; 
          $database->insert($changeLogSQL);
        }

    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }


//8589934592 



function checkType($ext)
{
  $imageArry = ['jpg','png','jpeg','gif'];
  $wordArry = ['rtf','doc','dot','wbk','docx','docm','dotx','dotm','docb']; 
  $pptArry= ['ppt','pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];
  $xcelArry = ['csv', 'xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw'];
  $pdf = 'pdf';
  $txt = 'txt';
  
//  echo $ext;
  if(in_array($ext,$imageArry))
  {
    $fileType='Image';
  }
    elseif(in_array($ext,$wordArry))
  {
    $fileType='Word';
  }
    elseif(in_array($ext,$pptArry))
  {
    $fileType='PowerPoint';
  }
    elseif(in_array($ext,$xcelArry))
  {
    $fileType='Excell';
  }
    elseif($pdf == $ext)
  {
    $fileType='PDF';
  }
    elseif($txt == $ext)
  {
    $fileType='Text';
  }
else
  {
    $fileType='unknown';
  }
  return $fileType;
}

//========================================================================================== END PHP
?>
