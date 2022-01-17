<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/22/2019
 * Time: 3:25 PM
 */
include('../../Includes/Security/database.php');
$db = new Database();

$requestId = $_POST['request'];

$filename =  $_FILES['file']['name'] . $requestId . '.pdf';

$target = '../../Files/IT/Acknowledgements/' . $filename;

$userId = $_POST['userId'];

if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
    $db_insert = $db->get('sp_it_AssetAcknowledgementInsert("' . $requestId . '","' . $filename . '", "' . $target . '","' . $userId . '");');
    echo move_uploaded_file($_FILES['file']['tmp_name'], $target);

}

