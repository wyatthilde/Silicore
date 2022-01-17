<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/19/2019
 * Time: 1:49 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$allRequestsQuery = 'sp_hr_AllMedicalRequestsGet()';
$allRequestsObj = json_decode($db->get($allRequestsQuery));

$applicantArray = array();
$employeeArray = array();
if(!is_null($allRequestsObj)) {
    $testsArray = Array();
    foreach ($allRequestsObj as $request) {
        if (substr($request->hr_applicant_employee_code, 0, 3) == '001') {
            $singleRequestQuery = 'sp_hr_EmployeeByIdGet("' . substr($request->hr_applicant_employee_code, 3) . '");';
            $employeeArray[$request->id]['personalData'] = $db->get($singleRequestQuery);
            $employeeArray[$request->id]['requestId'] = $request->id;
            $employeeArray[$request->id]['clinicId'] = $request->hr_clinic_id;
            $employeeArray[$request->id]['clinicName'] = $request->clinic_name;
            $employeeArray[$request->id]['clinicCity'] = $request->clinic_city;
            $employeeArray[$request->id]['clinicState'] = $request->clinic_state;
            $employeeArray[$request->id]['clinicTests'] = null;
            $employeeArray[$request->id]['statusCodeId'] = $request->status_code_id;
            $employeeArray[$request->id]['statusCodeText'] = $request->status_code_text;
            $employeeArray[$request->id]['resultCodeId'] = $request->result_code_id;
            $employeeArray[$request->id]['resultCodeText'] = $request->result_code_text;
            $employeeArray[$request->id]['paidDate'] = $request->paid_date;
            $employeeArray[$request->id]['createDate'] = $request->create_date;
            $employeeArray[$request->id]['modifyDate'] = $request->modify_date;
            $labTests = json_decode($db->get('sp_hr_RequestedTestsGet("' . $request->id . '");'));
            foreach($labTests as $key => $value) {
                $query = 'sp_hr_LabTestByIdGet("' . $value->hr_lab_test_id . '");';
                $test = json_decode($db->get($query))[0];
                $testsArray[$request->id][$test->id] = $test->description;
            }

            $employeeArray[$request->id]['clinicTests'] = json_encode($testsArray[$request->id]);
        } elseif (substr($request->hr_applicant_employee_code, 0, 3) == '000') {
            $singleRequestQuery = 'sp_hr_ApplicantByIdGet("' . substr($request->hr_applicant_employee_code, 3) . '");';
            $applicantArray[$request->id]['personalData'] = $db->get($singleRequestQuery);
            $applicantArray[$request->id]['requestId'] = $request->id;
            $applicantArray[$request->id]['clinicId'] = $request->hr_clinic_id;
            $applicantArray[$request->id]['clinicName'] = $request->clinic_name;
            $applicantArray[$request->id]['clinicCity'] = $request->clinic_city;
            $applicantArray[$request->id]['clinicState'] = $request->clinic_state;
            $applicantArray[$request->id]['clinicTests'] = null;
            $applicantArray[$request->id]['statusCodeId'] = $request->status_code_id;
            $applicantArray[$request->id]['statusCodeText'] = $request->status_code_text;
            $applicantArray[$request->id]['resultCodeId'] = $request->result_code_id;
            $applicantArray[$request->id]['resultCodeText'] = $request->result_code_text;
            $applicantArray[$request->id]['paidDate'] = $request->paid_date;
            $applicantArray[$request->id]['createDate'] = $request->create_date;
            $applicantArray[$request->id]['modifyDate'] = $request->modify_date;
            $labTests = json_decode($db->get('sp_hr_RequestedTestsGet("' . $request->id . '");'));
            foreach($labTests as $key => $value) {
                $query = 'sp_hr_LabTestByIdGet("' . $value->hr_lab_test_id . '");';
                $test = json_decode($db->get($query))[0];
                $testsArray[$request->id][$test->id] = $test->description;
            }
            $applicantArray[$request->id]['clinicTests'] = json_encode($testsArray[$request->id]);
        }
    }
    $joinedArray = array_merge($employeeArray, $applicantArray);
    krsort($joinedArray);
    echo json_encode($joinedArray, true);
} else {
    echo 0;
}


