<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/24/2019
 * Time: 9:36 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);

$id = test_input($obj['id']);

$read = $database->get('sp_it_AcknowledgementGet("' . $id . '")');

if($read !== 0) {
    $filePath = json_decode($read)[0]->file_path;
    echo $filePath;
}
else {
    echo $read;
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}