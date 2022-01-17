<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/6/2018
 * Time: 9:03 AM
 */
require_once('../../Includes/Security/database.php');
$database = new Database();
$obj = NULL;
$string = file_get_contents('php://input');
$obj = json_decode($string, true);



$userParams = Array(
    $id = test_input($obj['id-input']),
    $first = test_input($obj['first-name']),
    $last = test_input($obj['last-name']),
    $display_name = test_input($obj['display-name']),
    $email = test_input($obj['email']),
    $username = test_input($obj['username']),
    $company = test_input($obj['company']),
    $dept = test_input($obj['department']),
    $start_date = test_input($obj['start-date']),
    $end_date = test_input($obj['separation-date']),
    $status = test_input($obj['status']),
    $labtech = test_input($obj['labtech-check']),
    $sampler = test_input($obj['sampler-check']),
    $operator = test_input($obj['operator-check']),
    $user_type = test_input($obj['user-type']),
    $user = test_input($obj['current_user'])
);
if($end_date == '') {
    $end_date = NULL;
    $params = implode('","',$userParams);
    $paramList = str_replace(',"",', ',NULL,',$params);
    $user_insert = $database->get('sp_adm_UserUpdateV2("' . $paramList . '");');

}



$permParams = Array();
$dev_perm = test_input($obj['Development-check']);
$gen_perm = test_input($obj['General-check']);
if($gen_perm != "") {
    $permParams['general'] = test_input($obj['General-select']);
}
if($dev_perm != ""){
    $permParams['development'] = test_input($obj['Development-select']);
}
$hr_perm = test_input($obj['HR-check']);
if($hr_perm != ""){
    $permParams['hr'] = test_input($obj['HR-select']);
}
$it_perm = test_input($obj['IT-check']);
if($it_perm != ""){
    $permParams['it'] = test_input($obj['IT-select']);
}
$log_perm = test_input($obj['Logistics-check']);
if($log_perm != ""){
    $permParams['logistics'] = test_input($obj['Logistics-select']);
}
$prod_perm = test_input($obj['Production-check']);
if($prod_perm != "") {
    $permParams['production'] = test_input($obj['Production-select']);
}
$qc_gb_perm = test_input($obj['QC-Granbury-check']);
if($qc_gb_perm != "") {
    $permParams['qc_gb'] = test_input($obj['QC-Granbury-select']);
}
$qc_tl_perm = test_input($obj['QC-Tolar-check']);
if($qc_tl_perm != ""){
    $permParams['qc_tl'] = test_input($obj['QC-Tolar-select']);
}
$qc_wt_perm = test_input($obj['QC-west-texas-check']);
if($qc_wt_perm != "") {
    $permParams['qc_wt'] = test_input($obj['QC-west-texas-select']);
}
$safety_perm = test_input($obj['Safety-check']);
if($safety_perm != ""){
    $permParams['safety'] = test_input($obj['Safety-select']);
}
$loadout_perm = test_input($obj['Loadout-check']);
if($loadout_perm != ""){
    $permParams['loadout'] = test_input($obj['Loadout-select']);
}

foreach($permParams as $key => $value) {
    if($value == '-1') {
        $value = '0';
    }
    if ($key == 'qc_gb') {
        $perm_insert = $database->insert('sp_adm_UserUpdatePermission("' . $id . '","' . $user . '","qc","' . $value . '","granbury");');
    }
    if ($key == 'qc_tl') {
        $perm_insert = $database->insert('sp_adm_UserUpdatePermission("' . $id . '","' . $user . '","qc","' . $value . '","tolar");');

    }
    if ($key == 'qc_wt') {
        $perm_insert = $database->insert('sp_adm_UserUpdatePermission("' . $id . '","' . $user . '","qc","' . $value . '","west_texas");');

    } if ($key != 'qc_gb' && $key != 'qc_tl' && $key != 'qc_wt') {
        $perm_insert = $database->insert('sp_adm_UserUpdatePermission("' . $id . '","' . $user . '","' . $key . '","' . $value . '","granbury");');

    }
}

$response = Array('user' => $user_insert, 'permissions' => $perm_insert);

echo json_encode($response);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

