<?php
/* * *****************************************************************************************************************************************
 * File Name: upload_document.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/25/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/Security/database.php');
require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
require_once ('../../Includes/General/document_functions.php');
require_once('../../Includes/emailfunctions.php');


$database = new Database();

$uploadCap = 8589934592;

$userId = filter_input(INPUT_POST, 'userId');
$userName = filter_input(INPUT_POST, 'username');
$dateString = date("ymdHis");

$fileDescription = filter_input(INPUT_POST, 'description');
$fileDeparment = filter_input(INPUT_POST, 'department');
$fileDepartmentName = filter_input(INPUT_POST, 'deptName');
$fileCategory = filter_input(INPUT_POST, 'category');
$targetDir = '../../Files/' . $fileDepartmentName . '/';
echo $fileCategory;
$fileArry = ['jpg','png','jpeg','gif','pdf','rtf','txt','doc','dot','wbk','docx','docm','dotx','dotm','docb','csv','xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw','ppt','pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];

$fileExt = preg_replace('/\s+/', '',strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION)));

$fileSize = $_FILES["file"]["size"];
$baseName = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
$fileName = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME) . "_" . $userName . "_" . $dateString;
$targetFile = $targetDir . $fileName . '.' . $fileExt;
$isActive = 1;
$uploadOk = 1;

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



// Check if file already exists
if (file_exists($targetFile)) {
        header('HTTP/1.1 500 Duplicate File');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'File Already Exists', 'code' => 1441)));
}
// Check file size
if ($fileSize > 5 * 1048576)//5mgs
{
        header('HTTP/1.1 500 File too large');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'File too large', 'code' => 889)));
}
// Allow certain file formats
if(!in_array($fileExt, $fileArry)) {
        header('HTTP/1.1 500 Unsupported File Type' . $fileExt);
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Unsuported File Type ' . $fileExt, 'code' => 613)));
}

$fileType = checkType($fileExt);

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
        $fileSQL = "CALL sp_adm_DocumentInsert("
                . "'" . $baseName . "',"
                . "'" . $fileExt . "',"
                . "'" . $fileType . "',"
                . "'" . $fileDescription . "',"
                . "'" . $fileSize . "',"
                . "'" . $targetFile . "',"
                . "'" . $fileDeparment . "',"
                . "" . $fileCategory . ","
                . "'" . $userId . "',"
                . "'" . $isActive ."')";
        
        echo "<br>" . $fileSQL; 
        dbmysqli()->query($fileSQL) or die(mysqli_error(dbmysqli()));;
        
        $docId = json_decode($database->get('sp_adm_DocumentMaxIdGet()'),true)[0]['max(id)'];
        
        $changeLogSQL = "sp_adm_DocumentChangeLogInsert(" . $userId . "," . $docId . ",'New Document: " . $fileType . "')"; 
        $database->insert($changeLogSQL);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}  


function checkType($ext)
{
  $imageArry = ['jpg','png','jpeg','gif'];
  $wordArry = ['rtf','doc','dot','wbk','docx','docm','dotx','dotm','docb']; 
  $pptArry= ['ppt','pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];
  $xcelArry = ['csv', 'xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw'];
  $pdf = 'pdf';
  $txt = 'txt';
  
  echo $ext;
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


<!-- HTML -->