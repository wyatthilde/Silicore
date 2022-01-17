<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/27/2018
 * Time: 11:30 AM
 */

require_once('../../Includes/Security/database.php');
require_once('../../Includes/emailfunctions.php');

$database = new Database();

if (isset($_POST['fromTable'])) {
    $employeeData = json_decode(filter_input(INPUT_POST, 'employeeData'));
    $userId = filter_input(INPUT_POST, 'userId');
    $assetRequests = json_decode($database->get('sp_hr_AssetRequestByIdGet("' . $employeeData->id . '");'), true);
    $accountRequests = json_decode($database->get('sp_hr_AccountRequestsByIdGet("' . $employeeData->id . '");'), true);
    $employeeName = $employeeData->first_name . ' ' . $employeeData->last_name;
    $database->insert('sp_hr_ApproveEmployeeById("' . $employeeData->id . '","' . $userId . '");');
    if ($accountRequests != 0 && !is_string($accountRequests)) {
        $database->insert('sp_hr_ApproveAccountRequest("' . $userId . '","' . $employeeData->id . '");');
        foreach($accountRequests as $request) {
            $subject = $request['type'] . ' Account Request - ' . $employeeName;
            $body = $employeeName . ' needs an ' . $request['type'] . ' account. </br></br> Model after: ' . $request['model'] . '</br></br> Location: ' . $employeeData->site_name . '</br></br> Manager: ' . $employeeData->manager_name . '</br></br> HR Comment: ' . $employeeData->comments;
            sendPHPMail('help@vprop.com', $subject, $body);
        }
    }
    if ($assetRequests != 0 && !is_string($assetRequests)) {
        $database->insert('sp_hr_ApproveAssetRequestByEmployeeId("1","' . $userId . '","' . $employeeData->id . '");');
        foreach ($assetRequests as $request) {
            $subject = $request['type'] . ' Request - ' . $employeeName;
            $body = $employeeData->first_name . ' ' . $employeeData->last_name . ' needs a ' . $request['type'] . '. </br></br> Location: ' . $employeeData->site_name . '</br></br> Manager: ' . $employeeData->manager_name . '</br></br> HR Comment: ' . $employeeData->comments;
            sendPHPMail('help@vprop.com', $subject, $body);
        }
    }
}

if (isset($_POST['fromOnBoard'])) {
    $employeeData = json_decode(filter_input(INPUT_POST, 'employeeData'));
    $requests = json_decode(filter_input(INPUT_POST, 'requests'));
    $username = strtolower(substr($employeeData->firstName, 0, 1) . $employeeData->lastName);
    $userId = filter_input(INPUT_POST, 'userId');
    $employeeData->lastName = htmlspecialchars($employeeData->lastName);
    $employeeData->firstName = htmlspecialchars($employeeData->firstName);

    if ($employeeData->paycomId == "") {
         $query = 'sp_hr_EmployeeInsert("' . $employeeData->lastName . '","' . $employeeData->firstName . '", NULL,"' . $employeeData->departmentId . '","' . $employeeData->jobTitleId . '","' . $employeeData->managerId . '","' . $employeeData->startDate . '","' . $employeeData->comments . '", NULL,"' . $employeeData->isApproved . '","' . $userId . '", NULL);';
         echo $employeeId = json_decode($database->get($query))[0]->id;
    } elseif ($employeeData->isApproved == 0) {
         $query = 'sp_hr_EmployeeInsert("' . $employeeData->lastName . '","' . $employeeData->firstName . '","' . $employeeData->paycomId . '","' . $employeeData->departmentId . '","' . $employeeData->jobTitleId . '","' . $employeeData->managerId . '","' . $employeeData->startDate . '","' . $employeeData->comments . '",NULL,"' . $employeeData->isApproved . '","' . $userId . '","' . $userId . '");';
         echo $employeeId = json_decode($database->get($query))[0]->id;
    } else {
         $query = 'sp_hr_EmployeeInsert("' . $employeeData->lastName . '","' . $employeeData->firstName . '","' . $employeeData->paycomId . '","' . $employeeData->departmentId . '","' . $employeeData->jobTitleId . '","' . $employeeData->managerId . '","' . $employeeData->startDate . '","' . $employeeData->comments . '","' . date('Y-m-d H:i:s') . '","' . $employeeData->isApproved . '","' . $userId . '","' . $userId . '");';
        echo $employeeId = json_decode($database->get($query))[0]->id;
    }

    if ($employeeData->isApproved == 1) {
        userInsert($database, $employeeData, $employeeId, $userId);

        emailAccountRequest($database, $employeeData, $employeeId, $userId);

        silicoreAccountRequest($database, $employeeData, $employeeId, $userId);

        foreach ($requests as $request => $key) {
            requestEmailAndInsert($database, $request, $employeeData, $employeeId, $userId);
        }
    }
    if ($employeeData->isApproved == 0) {
         $database->insert('sp_account_request("' . $employeeId . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","Email","' . $employeeData->emailAccount . '","' . $userId . '","0", NULL,NULL)');
         $database->insert('sp_account_request("' . $employeeId . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","Silicore","' . $employeeData->silicoreAccount . '","' . $userId . '","0", NULL, NULL)');
        foreach ($requests as $request => $key) {
             $asset_insert = $database->get('sp_it_auto_asset_request("' . $employeeId . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","' . $request . '","' . $userId . '","0",NULL, NULL);');
        }
    }

}

function userInsert($database, $employeeData, $employeeId, $userId)
{
    $username = strtolower(substr($employeeData->firstName, 0, 1) . $employeeData->lastName);
    $departmentId = json_decode($database->get('sp_hr_MainDeptIdByIdGet("' . $employeeData->departmentId . '");'))[0]->main_department_id;
    $guess_email = $username . '@vprop.com';
    $employeeName = $employeeData->firstName . ' ' . $employeeData->lastName;
    $userInsert = json_decode($database->get('sp_hr_SilicoreUserAutoInsert("' . $employeeId . '","' . $username . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","' . $employeeName . '","' . $guess_email . '","' . $departmentId . '","' . $employeeData->managerId . '","' . $userId . '");"'))[0]->id;
    $modelPermissionsRead = $database->get('sp_hr_UserAccountPermissionsGet("' . $employeeData->silicoreAccount . '");');
    $modelPermissionsObj = json_decode($modelPermissionsRead, false, 512, JSON_OBJECT_AS_ARRAY);
    if (!empty($modelPermissionsObj)) {
        foreach ($modelPermissionsObj as $item) {
             $permissionInsert = $database->insert('sp_hr_MainUserPermissionsInsert("' . $userInsert . '","' . $item->permission . '","' . $item->permission_level . '","' . $item->site . '","' . $userId . '");');
        }
        $modelRolesRead = $database->get('sp_hr_UserAccountRolesGet("' . $employeeData->silicoreAccount . '");');
        $modelRolesObj = json_decode($modelRolesRead, false, 512, JSON_OBJECT_AS_ARRAY);
        if (!empty($modelRolesObj)) {
            foreach ($modelRolesObj as $item) {
                 $roleInsert = $database->insert('sp_hr_MainUserRolesInsert("' . $userInsert . '","' . $item->role_id . '");');
            }
        }
    } else {
         $permissionInsert = $database->insert('sp_hr_MainUserPermissionsInsert("' . $userInsert . '","general","1","granbury","' . $userId . '");');
    }
}

function emailAccountRequest($database, $employeeData, $employeeId, $userId)
{
    $employeeName = $employeeData->firstName . ' ' . $employeeData->lastName;
    $site = json_decode($database->get('sp_hr_SiteByIdGet("' . $employeeData->site . '");'));
    $emailSubject = 'Email Account Request - ' . $employeeName;
    $emailBody = $employeeName . ' needs an email account. </br></br> Model after: ' . $employeeData->emailAccount . '</br></br> Location: ' . $site[0]->site . '</br></br> Manager: ' . $employeeData->managerName;
    $database->insert('sp_account_request("' . $employeeId . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","Email","' . $employeeData->emailAccount . '","' . $userId . '","1", "' . date("Y-m-d H:i:s") . '","' . $userId . '")');
    sendPHPMail('help@vprop.com', $emailSubject, $emailBody);
}

function silicoreAccountRequest($database, $employeeData, $employeeId, $userId)
{
    $employeeName = $employeeData->firstName . ' ' . $employeeData->lastName;
    $site = json_decode($database->get('sp_hr_SiteByIdGet("' . $employeeData->site . '");'));
    $silicoreSubject = 'Silicore Account Request - ' . $employeeName;
    $silicoreBody = $employeeName . ' needs an Silicore account. </br></br> Model after: ' . $employeeData->silicoreAccount . '</br></br> Location: ' . $site[0]->site . '</br></br> Manager: ' . $employeeData->managerName;
    $database->insert('sp_account_request("' . $employeeId . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","Silicore","' . $employeeData->silicoreAccount . '","' . $userId . '","1", "' . date("Y-m-d H:i:s") . '","' . $userId . '")');
    sendPHPMail('help@vprop.com', $silicoreSubject, $silicoreBody);
}

function requestEmailAndInsert($database, $request, $employeeData, $employeeId, $userId)
{
    $employeeName = $employeeData->firstName . ' ' . $employeeData->lastName;
    $site = json_decode($database->get('sp_hr_SiteByIdGet("' . $employeeData->site . '");'));
    $subject = $request . ' Request - ' . $employeeName;
    $body = $employeeData->firstName . ' ' . $employeeData->lastName . ' needs a ' . $request . '. </br></br> Location: ' . $site[0]->site . '</br></br> Manager: ' . $employeeData->managerName . '</br></br> HR Comment: ' . $employeeData->comments;
     $asset_insert = $database->get('sp_it_auto_asset_request("' . $employeeId . '","' . $employeeData->firstName . '","' . $employeeData->lastName . '","' . $request . '","' . $userId . '","1","' . date("Y-m-d H:i:s") . '","' . $userId . '");');
    sendPHPMail('help@vprop.com', $subject, $body);
}