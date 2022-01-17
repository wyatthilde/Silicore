<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 5/14/2019
 * Time: 11:28 AM
 */
require_once('../../Includes/Security/database.php');
require_once('../../Includes/emailfunctions.php');
$db = new Database();

$id = filter_input(INPUT_POST, 'id');
$userId = filter_input(INPUT_POST, 'userId');
$userQ = 'sp_adm_UserGet("' . $id .'");';
$userObj = json_decode($db->get($userQ))[0];
$email = $userObj->email;
$user = $userObj->id;
$tempPwd = randomPassword();
$dbPwd = password_hash($tempPwd, PASSWORD_DEFAULT);
$resetQ = 'sp_adm_PasswordReset("' . $dbPwd .'", "1", "' . $userId . '","' . $user . '");';

$eTo = $email;
$eSubject = 'Password Reset';
$eBody = '<table style="width:100%;background-color:whitesmoke;padding-top:100px;padding-bottom:100px;table-layout:fixed;">';
$eBody .= '<tr>';
$eBody .= '<td align="center" style="height:100%;">';
$eBody .= '<table style="width:75%;background-color:white;">';
$eBody .= '<tr>';
$eBody .= '<td align="center"><img src="cid:vprop_logo" width="10%"></td>';
$eBody .= '</tr>';
$eBody .= '<tr>';
$eBody .= '<td align="center" style="border-bottom:1px solid whitesmoke;margin-bottom:25px;">';
$eBody .= '';
$eBody .= '</td>';
$eBody .= '</tr>';
$eBody .= '<tr>';
$eBody .= '<td align="center"><p style="margin-top:10px;">Your silicore password has been reset.</p></td>';
$eBody .= '</tr>';
$eBody .= '<tr>';
$eBody .= '<td align="center"><p style="margin-top:10px;">You may now login with your username and temporary password (available below)</p></td>';
$eBody .= '</tr>';
$eBody .= '<tr>';
$eBody .= '<td align="center"><p style="margin-top:10px;">Temporary password: <strong>' . $tempPwd . '</strong></p></td>';
$eBody .= '</tr>';
$eBody .= '</table>';
$eBody .= '</td>';
$eBody .= '</tr>';
$eBody .= '</table>';

sendPHPMailWithImage($eTo, $eSubject, $eBody, '../../Images/vprop_logo_large.png', 'vprop_logo', '', 0);

echo $dbResult = $db->insert($resetQ);

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%&*';
    $pass = array(); //remember to declare $pass as an array
    $length = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $a = rand(0, $length);
        $pass[] = $alphabet[$a];
    }
    return implode($pass); //turn the array into a string
}