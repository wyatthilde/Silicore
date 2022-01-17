<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 5/23/2019
 * Time: 9:10 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$id = filter_input(INPUT_POST, 'id');
$division = filter_input(INPUT_POST, 'division');
$site = filter_input(INPUT_POST, 'site');
$fName = filter_input(INPUT_POST, 'fName');
$lName = filter_input(INPUT_POST, 'lName');
$dob = filter_input(INPUT_POST, 'dob');
$phone = filter_input(INPUT_POST, 'phone');
$status = filter_input(INPUT_POST, 'status');
$userId = filter_input(INPUT_POST, 'userId');
$query = 'sp_hr_ApplicantUpdate("' . $id . '", "' . $division . '", "' . $site . '", "' . $fName . '", "' . $lName . '", "' . $dob . '", "' . $phone . '", "' . $status . '", "' . $userId . '");';
echo $db->insert($query);