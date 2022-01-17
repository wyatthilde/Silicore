<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/23/2019
 * Time: 2:41 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$applicantId = filter_input(INPUT_POST, 'applicantId');

$requestsQuery = 'sp_hr_MedicalAuthByApplicantId("000' . $applicantId . '")';
$requestsObj = json_decode($db->get($requestsQuery));
$testsArray = Array();

$applicantArray = array();
if(!empty($requestsObj)) {
    foreach ($requestsObj as $request) {
        if (substr($request->hr_applicant_employee_code, 0, 3) == '000') {
            $singleRequestQuery = 'sp_hr_ApplicantByIdGet("' . substr($request->hr_applicant_employee_code, 3) . '");';
            $applicantArray[$request->id]['personalData'] = $db->get($singleRequestQuery);
            $applicantArray[$request->id]['requestId'] = $request->id;
            $applicantArray[$request->id]['clinicId'] = $request->hr_clinic_id;
            $applicantArray[$request->id]['clinicName'] = $request->clinic_name;
            $applicantArray[$request->id]['clinicCity'] = $request->clinic_city;
            $applicantArray[$request->id]['clinicState'] = $request->clinic_state;
            $applicantArray[$request->id]['statusCodeId'] = $request->status_code_id;
            $applicantArray[$request->id]['statusCodeText'] = $request->status_code_text;
            $applicantArray[$request->id]['resultCodeId'] = $request->result_code_id;
            $applicantArray[$request->id]['resultCodeText'] = $request->result_code_text;
            $labTests = json_decode($db->get('sp_hr_RequestedTestsGet("' . $request->id . '");'));
            foreach($labTests as $key => $value) {
                $query = 'sp_hr_LabTestByIdGet("' . $value->hr_lab_test_id . '");';
                $test = json_decode($db->get($query))[0];
                $testsArray[$test->id] = $test->description;
            }
            $applicantArray[$request->id]['clinicTests'] = json_encode($testsArray);
        }
    }
    echo json_encode($applicantArray, true);
} else {
    echo 0;
}

