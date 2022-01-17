<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/2/2019
 * Time: 9:31 AM
 */
require_once '../mpdf/vendor/autoload.php';
require_once('../../Includes/Security/database.php');

require_once('../../Includes/emailfunctions.php');
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/../../Files/QC/temp'], ['format' => 'utf-8', [100, 236]]);

$db = new Database();
$sampleId = filter_input(INPUT_POST, 'sampleId');
$siteId = filter_input(INPUT_POST, 'siteId');
$userId = filter_input(INPUT_POST, 'userId');
$labtechInput = filter_input(INPUT_POST, 'labtech');
$labtechObj = json_decode($db->get('sp_adm_UserGet("' . $labtechInput . '");'));
$labtech = $labtechObj[0]->first_name . ' ' . $labtechObj[0]->last_name;
$weights = json_decode(filter_input(INPUT_POST, 'weights'));
$percentages = json_decode(filter_input(INPUT_POST, 'percentages'));
$inSize = filter_input(INPUT_POST, 'inSize');
$moistureRate = filter_input(INPUT_POST, 'moistureRate');
$siltPercent = filter_input(INPUT_POST, 'siltPercent');

$siteQuery = 'sp_SiteNameByIdGet("' . $siteId . '")';
$siteName = json_decode($db->get($siteQuery))[0]->description;

$filename = $siteId . '-' . $sampleId . '-' . date('Y-m-d') . '.pdf';
$target = '../../Files/QC/COA/' . $filename;
$fileQuery = 'sp_qc_COAFileInsert("'  .  $siteId . '", "' . $sampleId . '", "' . $filename . '", "' . $target . '", "' . $userId . '")';
$coaNo = $siteId . '-0000' . json_decode($db->get($fileQuery))[0]->id;

//header
$mpdf->WriteHTML('
<style>table{margin:10px;}</style>
<div style="position:absolute;float:left;">
    <img src="../../Images/vprop_logo_large.png" width="30%">
</div>

<table style="width:100%;">
    <tr>
        <td align="center"><h3>CERTIFICATE OF ANALYSIS</h3></td>
    </tr>
    <tr>
        <td align="center">Certificate No: ' . $coaNo . '</td>
    </tr>
    <tr>
        <td align="center">Prepared for:</td>
    </tr>
</table>
<table  style="width:100%;border:1px solid;">
    <tr>        
        <td align="center"><strong>Sample Preparation and Analytical Procedures</strong></td>
    </tr>
    <tr>        
        <td align="center"><small>ISO 13503-2:2006 / API 19C: 2008</small></td>    
    </tr>
    <tr>
        <td align="center"><small>ASTM C117 -13 Modified</small></td>
    </tr>
</table>');
if(isset($_POST['productName'])) {
    $productName = filter_input(INPUT_POST, 'productName');
    $mpdf->WriteHTML('Sample ID: ' . $sampleId . '<br>Lab Tech: ' . $labtech . '<br>Product Name: ' . $productName . '<br><br><br>');
} else {
    $mpdf->WriteHTML('Sample ID: ' . $sampleId . '<br>' . 'Lab Tech: ' . $labtech . '<br><br><br>');
}

//Sieve Analysis
$mpdf->WriteHTML('
<table style="width:100%;">
    <tr>
        <td align="left">
            <table border="1" style="border-collapse:collapse">
                <tr>
                    <td align="center" colspan="4">SIEVE ANALYSIS</td>
                </tr>
                    <thead>
                        <tr>
                            <td>Sieve No.</td>
                            <td>Ret. wt%</td>
                            <td>Cum. wt%</td>
                        </tr>
                    </thead>
                    <tbody>');
$totalWeight = 0;
$cumulativePercentage = 0;

$array = Array();

for ($i = 1; $i < 19; $i++) {
    foreach ($weights->vars as $key => $value) {
        if ($value > 0) {
            if ($key == 'weightValue' . $i) {
                $totalWeight += round($value, 3, PHP_ROUND_HALF_DOWN);
            }
        }
    }
}

$wtsAndPcts = (array)array_merge((array)$weights->vars, (array)$percentages->vars);

for ($i = 1; $i < 19; $i++) {
    $mpdf->WriteHTML('<tr>');
    foreach ($wtsAndPcts as $key => $value) {
        if($wtsAndPcts['screenSize' . $i] !== 0) {
            if ($key == 'screenSize' . $i) {
                $mpdf->WriteHTML('<td>' . $value . '</td>');
            }
            if ($key == 'finalpercent' . $i) {
                $cumulativePercentage += $value;
                $mpdf->WriteHTML('<td>' . round($value, 3) * 100 . '%</td><td>' . round($cumulativePercentage, 3) * 100 . '%</td>');
            }
        }

    }


    $mpdf->WriteHTML('</tr>');
}


$mpdf->WriteHTML('
            <tr>
                <td>Total</td>
                <td colspan="2">' . round($cumulativePercentage, 3) * 100 . '%</td>
            </tr>');
if(isset($_POST['inSize'])) {
    $mpdf->WriteHTML('
            <tr>
                <td>In-Size</td>
                <td colspan="2">' . round($inSize, 1) . '%</td>
               
            </tr>
        </tbody>
    </table>
</td>
<td valign="top" >
    <table>
        <tr>');
} else {
    $mpdf->WriteHTML('
              
        </tbody>
    </table>
</td>
<td valign="top" >
    <table>
        <tr>');
}

if (isset($_POST['rndSphere'])) {
    $rndSphere = json_decode(filter_input(INPUT_POST, 'rndSphere'));
    $roundness = $rndSphere->roundness;
    $sphericity = $rndSphere->sphericity;
    $mpdf->WriteHTML('<td valign="top" ><table border="1" style="width:150px;border-collapse:collapse"><tr><td  colspan="2" align="center">Rnd/Sphere</td></tr><tr><td>Roundness</td><td>' . $roundness . '</td></tr><tr><td>Sphericity</td><td>' . $sphericity . '</td></tr></table></td>');
}
if (isset($_POST['acid'])) {
    $acid = filter_input(INPUT_POST, 'acid');
    $mpdf->WriteHTML('<td valign="top" ><table border="1" style="width:150px;border-collapse:collapse"><tr><td  colspan="2" align="center">Acid Solubility</td></tr><tr><td colspan="2">' . $acid . '%</td></tr></table></td>');
}
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('<tr>');
if (isset($_POST['density'])) {
    $density = json_decode(filter_input(INPUT_POST, 'density'));
    $bulkGrams = $density->bulkGrams;
    $bulkLbs = $density->bulkPounds;
    $apparentGrams = $density->apparentGrams;
    $mpdf->WriteHTML('
<td valign="top" >
    <table border="1" style="width:150px;border-collapse:collapse">
        <tr>
            <td  colspan="2" align="center" >Density</td>
        </tr>
        <tr>
            <td>Bulk</td>
            <td>' . $bulkGrams . 'g/cm&sup3;</td>
        </tr>
        <tr>
            <td>Bulk</td>
            <td>' . $bulkLbs . 'lb/ft&sup3;</td>
        </tr>
        <tr>
            <td>Apparent</td>
            <td>' . $apparentGrams . 'g/cm&sup3;</td>
        </tr>
    </table>
</td>');
}
if (isset($_POST['turbidity'])) {
    $turbidity = filter_input(INPUT_POST, 'turbidity');
    $mpdf->WriteHTML('<td valign="top" ><table border="1" style="width:150px;border-collapse:collapse;"><tr><td  colspan="2" align="center">Turbidity</td></tr><tr><td colspan="2">' . $turbidity . ' NTU</td></tr></table></td>');
}
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('<tr>');
if (isset($_POST['kvalues'])) {
    $kvalues = json_decode(filter_input(INPUT_POST, 'kvalues'));
    if(isset($kvalues->hiDesc)) {
        $hiDesc = $kvalues->hiDesc;
        $hiValue = $kvalues->hiValue;
        $loDesc = $kvalues->loDesc;
        $loValue = $kvalues->loValue;
        $mpdf->WriteHTML('<td valign="top" align="center"><table border="1" style="width:150px;border-collapse:collapse;margin-bottom:15px;"><tr><td align="center" colspan="2" >Crush Resistance</td></tr><tr><td>Stress (psi)</td><td>% Fines</td></tr><tr><td>' . $hiDesc . '</td><td>' . $hiValue . '%</td></tr><tr><td>' . $loDesc . '</td><td>' . $loValue . '%</td></tr><tr><td>K-Value</td><td>' . $hiDesc . '</td></tr></table></td>');
    } elseif($kvalues->singleDesc){
        $singleDesc = $kvalues->singleDesc;
        $singleValue = $kvalues->singleValue;
        $mpdf->WriteHTML('<td valign="top" align="center"><table border="1" style="width:150px;border-collapse:collapse;margin-bottom:15px;"><tr><td align="center" colspan="2" >Crush Resistance</td></tr><tr><td>Stress (psi)</td><td>% Fines</td></tr><tr><td>' . $singleDesc . '</td><td>' . $singleValue . '%</td></tr></table></td>');
    }

}

if(isset($_POST['moistureRate'])) {
    $mpdf->WriteHTML('<td valign="top" align="center"><table border="1" style="width:150px;border-collapse:collapse;margin-bottom:15px;"><tr><td>Moisture Rate</td></tr><tr><td>' . $moistureRate . '%</td></tr></table>');
}

if(isset($_POST['siltPercent'])) {
    $mpdf->WriteHTML('<td valign="top" align="center"><table border="1" style="width:150px;border-collapse:collapse;margin-bottom:15px;"><tr><td>Silt</td></tr><tr><td>' . $siltPercent . '%</td></tr></table>');
}
$mpdf->WriteHTML('
</td>
    </tr>
        </table>
            </tr>
                </table>
                <table style="width:100%;">
                    <tr>
                        <td align="right">
                            <table style="margin-top:100px;">
                                <tr><td>______________________________________________</td></tr>
                                <tr><td>QC Manager</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <table style="margin-top:25px;width:100%;">
                    <tr>
                        <td><small style="font-size:9px;">Release of Liability:  This work is provided in good faith;  We are not liable for the use of or damages that may occur from the use of the results.</small>
                    </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="border:1px solid;width:100%;">
                    <tr>
                            <td>VPROP Laboratory</td>
                    </tr>
                    <tr>
                            <td>3549 Monroe Hwy</td>
                    </tr>
                    <tr>
                            <td>Granbury, TX 76049</td>
                    </tr>
                            <td>Phone:</td>
                            <td>(817) 776 - 4953 </td>
                    </tr>
                </table>
        </td>
        </tr>
        
        </table>
');
$emailContent = $mpdf->Output('', 'S');
$emailBody = 'Certificate of analysis for sample #' . $sampleId . ' at ' . $siteName;
$emailResult = sendPHPMailWithAttachment('joe@vprop.com', 'COA #' . $coaNo, $emailBody, $emailContent, $filename);

if($emailResult == 1) {
    echo 1;
}

$mpdf->Output($target, 'F');