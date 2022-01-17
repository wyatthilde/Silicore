<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/19/2019
 * Time: 9:45 AM
 */
require_once '../../../../../../../home/whildebrandt/vendor/autoload.php';
require_once('../../Includes/Security/database.php');
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/../../Files/HR/temp']);

$db = new Database();

$resultArray = Array();
$testsArray = Array();
$applicantEmployeeId = filter_input(INPUT_POST,'applicantEmployeeId');
$clinicId = filter_input(INPUT_POST,'clinicId');
$reasonId = filter_input(INPUT_POST,'reasonId');
$clinicTestIds = filter_input(INPUT_POST,'clinicTestIds');
$isDot = filter_input(INPUT_POST,'isDot');
$comments = filter_input(INPUT_POST,'comments');
$userId = filter_input(INPUT_POST,'userId');

$authQuery = "sp_hr_MedicalAuthInsert('" . $applicantEmployeeId . "','" . $clinicId . "','" . $reasonId . "','" . $isDot . "','" . $comments . "','" . $userId . "')";

$authResult = $db->get($authQuery);

$resultArray['authResult'] = $authResult;

foreach(json_decode($clinicTestIds) as $key => $value) {
    $testsQuery = "sp_hr_MedicalAuthLabTestInsert('" . json_decode($authResult)[0]->id . "','" . $value . "');";
    $testResult = $db->insert($testsQuery);
    $testsArray['testsResult'] = $testResult;
}
$resultArray['tests'] = json_encode($testsArray);
echo json_encode($resultArray);


