<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/25/2019
 * Time: 11:12 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$requestId = filter_input(INPUT_POST, 'requestId', FILTER_VALIDATE_INT);
$statusId = filter_input(INPUT_POST, 'statusId', FILTER_VALIDATE_INT);
$userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
$paidDate = filter_input(INPUT_POST, 'paidDate', FILTER_SANITIZE_STRING);

if($paidDate != '' && $paidDate != NULL) {
    $query = 'sp_hr_MedicalAuthStatusUpdate("' . $requestId . '","' . $statusId . '","' . $userId . '","' . $paidDate . '");';
} else {
    $query = 'sp_hr_MedicalAuthStatusUpdate("' . $requestId . '","' . $statusId . '","' . $userId . '", NULL);';
}

echo $db->insert($query);
