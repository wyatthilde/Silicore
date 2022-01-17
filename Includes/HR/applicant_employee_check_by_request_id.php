<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/25/2019
 * Time: 2:03 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$requestId = filter_input(INPUT_POST, 'requestId');

$query = 'sp_hr_ApplicantEmployeeCheckByRequestId("' . $requestId . '")';
$code =  json_decode($db->get($query))[0]->hr_applicant_employee_code;
$resultArry = array();
if(substr($code, 0,3) === '000') {
    $resultArry['type'] = 0;
} elseif(substr($code, 0,3) === '001') {
    $resultArry['type'] = 1;
}
echo json_encode($resultArry);