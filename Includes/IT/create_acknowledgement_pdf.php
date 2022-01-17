<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 2/18/2019
 * Time: 2:26 PM
 */
require_once '../../../../../../../home/whildebrandt/vendor/autoload.php';
require_once('../../Includes/Security/database.php');
$database = new Database();
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/../../Files/IT/temp']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $output = 'SAVE';
    $id = filter_input(INPUT_POST, 'id');
    $name = filter_input(INPUT_POST, 'name');
    $inventoryId = filter_input(INPUT_POST, 'inventoryId');
    $type = filter_input(INPUT_POST, 'type');
    $requestId = filter_input(INPUT_POST, 'requestId');
    $userId = filter_input(INPUT_POST, 'userId');
    $paycom = json_decode($database->get('sp_it_PaycomByIdGet("' . $id . '");'))[0]->paycom_id;
    $serial = json_decode($database->get('sp_it_PartNumberByIdGet("' . $inventoryId . '");'))[0]->part_number;
    $assigneeSignature = filter_input(INPUT_POST, 'assigneeSignature');
    $assignerSignature = filter_input(INPUT_POST, 'assignerSignature');
} else {
    $output = 'PRINT';
    $id = filter_input(INPUT_GET, 'id');
    $name = filter_input(INPUT_GET, 'name');
    $inventoryId = filter_input(INPUT_GET, 'inventoryId');
    $type = filter_input(INPUT_GET, 'type');
    $requestId = filter_input(INPUT_GET, 'requestId');
    $userId = filter_input(INPUT_GET, 'userId');
    $paycom = json_decode($database->get('sp_it_PaycomByIdGet("' . $id . '");'))[0]->paycom_id;
    $serial = json_decode($database->get('sp_it_PartNumberByIdGet("' . $inventoryId . '");'))[0]->part_number;

}
$dollar = '';
if ($type === 'Cell Phone') {
    $dollar = '$900';
}
if ($type === 'Radio') {
    $dollar = '$850';
}
if ($type === 'Tablet') {
    $dollar = '$1500';
}
if ($type === 'Desktop') {
    $dollar = '$2000';
}
if ($type === 'Laptop') {
    $dollar = '$2000';
}
if ($type === 'Hotspot') {
    $dollar = '$600';
}
$mpdf->WriteHTML('
<table style="width:100%;table-layout:fixed;">
    <tr>
        <td><img src="../../Images/vprop_logo_minborder.png" style="width:20%;"></td>
        <td>IT Asset Assignment Form</td>
        <td> Date: ' . date("m/d/Y h:i A") . '</td>
    </tr>
    </table>
    
    <div style="margin-top:10px;"></div>
    
    <table style="width:100%;">
    <tr>
        <td>Employee Name: ' . $name . '</td>
        </tr>
        <tr>
        <td>Paycom ID: ' . $paycom . '</td>
    </tr>
    </table>
    
        <div style="margin-bottom:100px;"></div>

    
    <table> 
    <tr>
        <td>
        I understand that <u>' . $dollar . '</u> will be deducted from my final paycheck if I do not return the ' . $type . '(SN:' . $serial . ') assigned to me within 1 day after termination of employment.
        </td>
    </tr>
    </table>
    
        <div style="margin-bottom:250px;"></div>

    
    <table style="width:100%;">
    <tr>
        <td style="width:50%;">');

if ($output == 'SAVE') {
    $mpdf->WriteHTML('<img src="data:image/jpg;base64,' . $assigneeSignature . '" height="50px"></td>
        <td></td>
        <td><div>' . date("m/d/Y") . '</div></td>
    </tr>');
} elseif ($output == 'PRINT') {
    $mpdf->WriteHTML('</td>
            <td></td>
            <td><div></div></td>
        </tr>');
}
$mpdf->WriteHTML('
    <tr>
        <td style="border-top:1px solid #8c8c8c;">Employee Signature<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
        <td></td>
        <td style="border-top:1px solid #8c8c8c;">Date<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td>');

if ($output == 'SAVE') {
    $mpdf->WriteHTML('<img src="data:image/jpg;base64,' . $assignerSignature . '" height="50px"></td><td></td><td><div>' . date("m/d/Y") . '</div></td></tr>');
} elseif ($output == 'PRINT') {
    $mpdf->WriteHTML('</td><td></td><td><div></div></td></tr>');
}

$mpdf->WriteHTML('
        <tr>
            <td style="border-top:1px solid #8c8c8c;">IT Services Signature<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
            <td></td>
            <td style="border-top:1px solid #8c8c8c;">Date<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td>
        </tr>
</table>');

$filename = $type . '-Acknowledgement-' . $name . '-' . Date("m-d-Y") . '.pdf';
$target = '../../Files/IT/Acknowledgements/' . $filename;

if ($output == 'SAVE') {
    $mpdf->Output($target, 'F');
    echo $db_insert = $database->insert('sp_it_AssetAcknowledgementInsert("' . $requestId . '","' . $filename . '", "' . $target . '","' . $userId . '");');
} elseif ($output == 'PRINT') {
    $mpdf->Output();
}
