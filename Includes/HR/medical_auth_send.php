<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/22/2019
 * Time: 11:52 AM
 */
require_once '../../../../../../../home/whildebrandt/vendor/autoload.php';
require_once('../../Includes/Security/database.php');
require_once('../../Includes/emailfunctions.php');
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/../../Files/HR/temp']);
$db = new Database();
$requestId = filter_input(INPUT_POST,'requestId');
$userId = filter_input(INPUT_POST,'userId');
$ssn = filter_input(INPUT_POST,'ssn');
if(isset($_POST['dob'])) {
    $dob = filter_input(INPUT_POST,'dob');
}
if(isset($_POST['phone'])) {
    $phone = filter_input(INPUT_POST,'phone');
}
$requestQuery = 'sp_hr_MedicalRequestByIdGet("'. $requestId . '")';
$requestObj = json_decode($db->get($requestQuery));
foreach($requestObj as $request) {
    $clinicName = $request->name;
    $clinicAddress =  $request->address;
    $clinicCity = $request->city;
    $clinicState = $request->state;
    $clinicZip = $request->zip;
    $clinicPhone = $request->phone_number;
    $clinicFax = $request->fax_number;
    $isDot = $request->is_dot;
    $reason = $request->reason;
    $authorizedBy = $request->authorized_by;
    $clinicId = $request->hr_clinic_id;
}
if($isDot === '0') {
    $isDot = 'NON DOT';
} else {
    $isDot = 'DOT';
}

$requestedTestsQuery = 'sp_hr_RequestedTestsGet("' . $requestId . '")';

$tests = json_decode($db->get($requestedTestsQuery));


$appEmpCodeQuery = 'sp_hr_RequestedEmployeeApplicantCodeGet("'. $requestId .'")';
$appEmpCode = json_decode($db->get($appEmpCodeQuery))[0]->code;
if(substr($appEmpCode, 0,3) == '001') { //employee prefix
    $empCode = substr($appEmpCode, 3);
    $empQuery = 'sp_hr_EmployeeByIdGet("' . $empCode . '");';
    $employee = json_decode($db->get($empQuery));
    foreach($employee as $attr) {
        $name = $attr->first_name . ' ' . $attr->last_name;
        $division = $attr->division;
        $location = $attr->site;
        $createDate = $attr->create_date;
    }
    $createDate = date('Y-m-d H:m:s');
} elseif(substr($appEmpCode, 0,3) == '000') { //applicant prefix
    $appCode =  substr($appEmpCode, 3);
    $appQuery = 'sp_hr_ApplicantByIdGet("' . $appCode . '");';
    $applicant = json_decode($db->get($appQuery));
    foreach($applicant as $attr) {
        $name = $attr->first_name . ' ' . $attr->last_name;
        $dob = $attr->dob;
        $phone = $attr->phone_number;
        $division = $attr->division;
        $location = $attr->site;
        $createDate = $attr->create_date;
    }
}

$mpdf->WriteHTML('
<style>
table{
border-collapse:collapse;
}
</style>
<table>
<tr>
<td><img src="../../Images/vprop_logo_minborder.png" style="width:20%"></td>
</tr>
</table>
<table align="center">
<tr>
<td><strong>AUTHORIZATION FOR MEDICAL SERVICES</strong></td>
</tr>
</table>
<table style="margin-top:50px;">
    <tr>
        <td>
            <table style="border:1px solid;width:100%;height:100%;">
                <tr>
                    <td style="width:150px;border:1px solid">Name</td>
                    <td style="width:150px;border:1px solid">' . $name . '</td>
                </tr>
                <tr>
                    <td style="width:150px;border:1px solid">Social Security</td>
                    <td style="width:150px;border:1px solid">' . $ssn . '</td>
                </tr>
                <tr>
                    <td style="width:150px;border:1px solid">DOB</td>
                    <td style="width:150px;border:1px solid">' . $dob . '</td>
                </tr>
                <tr>
                    <td style="width:150px;border:1px solid">Emp. Phone #</td>
                    <td style="width:150px;border:1px solid">' . $phone . '</td>
                </tr>
                <tr>
                    <td style="width:150px;border:1px solid">Division</td>
                    <td style="width:150px;border:1px solid">' . $division . '</td>
                </tr>
                <tr>
                    <td style="width:150px;border:1px solid">Location</td>
                    <td style="width:150px;border:1px solid">' . $location . '</td>
                 </tr>
                </tr>
            </table>
        </td>
        <td>
            <table style="width:100%;">
                <tr>
                    <td style="border:1px solid">Test Request #</td>
                    <td style="border:1px solid">' . $requestId . '</td>
                </tr>
                <tr>
                    <td style="border:1px solid">Date Created</td>
                    <td style="border:1px solid">' . $createDate . '</td>
                </tr> 
                <tr>
                    <td style="border:1px solid">Authorized By</td>
                    <td style="border:1px solid">' . $authorizedBy .  '</td>
                </tr>
                <tr>
                    <td style="border:1px solid">Contact Phone</td>
                    <td style="border:1px solid">817-563-3507/682-715-0090</td>
                </tr>
                <tr>
                    <td style="border:1px solid">Results Email</td>
                    <td style="border:1px solid">MedicalResults@vprop.com</td>
                </tr>
                <tr>
                    <td style="border:1px solid">E FAX</td>
                    <td style="border:1px solid">817-977-6458</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width:100%;margin-top:50px;">
                <tr>
                    <td style="border:1px solid">Bill to: <br><br><br>Send disk to:</td>
                    <td style="border:1px solid">MAALT TRANSPORT dba  VPROP <br> VISTA PROPPANTS & LOGISTICS <br> 4413 Carey St. FTW TX 76119</td>
                </tr>
            </table>
        </td>
        <td>
            <table style="width:100%;margin-top:50px;">
                <tr> 
                    <td style="border:1px solid">Phone: 817-563-3550<br>Efax: 817-977-6458</td>
                    <td style="border:1px solid">AP Email: transportap@vprop.com</td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
            <table style="width:100%;margin-top:50px;">
                <thead>
                    <tr>
                        <th colspan="4">Test Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border:1px solid;">Test Type</td>
                        <td style="border:1px solid;">' . $isDot . '</td>
                        <td style="border:1px solid;">Reason</td>
                        <td style="border:1px solid;">' . $reason . '</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid;width:150px;">Scheduled Date</td>
                        <td style="border:1px solid"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid;width:150px;">Expiration Date</td>
                        <td style="border:1px solid"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid;width:150px;">Observed Collection</td>
                        <td style="border:1px solid"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
    <table style="width:100%;margin-top:50px;">
    <tr>
        <td style="border:1px solid;"><strong>Provider</strong></td>
        </tr>
        <tr>');

$mpdf->WriteHTML('<td style="width:200px;border:1px solid;">' . $clinicName . '<br>' . $clinicAddress . ' ' . $clinicCity . ', ' . $clinicState . ' ' . $clinicZip . ' </td>');

$mpdf->WriteHTML('
    </tr>
    </table>
    <table style="width:100%;margin-top:50px;">
    <tr>
        <td style="border:1px solid;"><strong>Tests to Perform</strong></td>
    </tr>');


foreach($tests as $test){
    $mpdf->WriteHTML('<tr><td style="border:1px solid;">' . $test->description . '</td></tr>');
}
$mpdf->WriteHTML('</table>');
$filename = $requestId . '-' . $clinicId . '.pdf';
$emailContent = $mpdf->Output('', 'S');
$emailBody = 'Destination Clinic: ' . $clinicName . '<br> Clinic Fax: ' . $clinicFax;
$emailResult = sendPHPMailWithAttachment('whildebrandt@vprop.com', '', $emailBody, $emailContent, $filename);

if($emailResult == 1) {
    echo 1;
    $query = 'sp_hr_MedicalAuthStatusUpdate("'.$requestId.'","2","' . $userId . '",NULL)';
    $db->insert($query);
}
