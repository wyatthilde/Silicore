<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 5/6/2019
 * Time: 2:28 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$requestId = filter_input(INPUT_POST, 'requestId');

$dir = '../../Files/IT/Acknowledgements/';
$filename = basename($_FILES['file']['name']);
$uploadFile = $dir . basename($_FILES['file']['name']);
$fileArry = ['pdf'];
$fileExt = preg_replace('/\s+/', '', strtolower(pathinfo(basename($_FILES['file']['name']),PATHINFO_EXTENSION)));
$fileSize = $_FILES['file']['size'];
$fileType = checkType($fileExt);
$targetFile = $dir . $filename . '.' . $fileExt;

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
    header('HTTP/1.1 500 Unsupported File Type ' . $fileExt);
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'Unsupported File Type ' . $fileExt, 'code' => 613)));
}

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
    echo "";
} else {
    echo "failed";
}

$userId = filter_input(INPUT_POST, 'userId');

echo $db_insert = $db->insert('sp_it_AssetAcknowledgementInsert("' . $requestId . '","' . $filename . '", "' . $uploadFile . '","' . $userId . '");');

function checkType($ext)
{
    $imageArry = ['jpg','png','jpeg','gif'];
    $wordArry = ['rtf','doc','dot','wbk','docx','docm','dotx','dotm','docb'];
    $pptArry= ['ppt','pot','pps','pptx','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];
    $xcelArry = ['csv', 'xls','xlt','xlm','xlsx','xlsm','xltx','xltm','xlsb','xla','xlam','xll','xlw'];
    $pdf = 'pdf';
    $txt = 'txt';

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
