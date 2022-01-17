<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/15/2019
 * Time: 4:24 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$name = filter_input(INPUT_POST,'name');
$address = filter_input(INPUT_POST,'address');
$city = filter_input(INPUT_POST,'city');
$state = filter_input(INPUT_POST,'state');
$zip = filter_input(INPUT_POST,'zip');
$phone = filter_input(INPUT_POST,'phone');
$fax = filter_input(INPUT_POST,'fax');
$email = filter_input(INPUT_POST,'email');
$userId = filter_input(INPUT_POST,'userId');

$query = 'sp_hr_ClinicInsert("' . $name . '","' . $address . '","' . $city . '","' . $state . '","' . $zip . '","' . $phone . '","' . $fax . '","' . $email . '","' . $userId . '")';

echo $result = $db->insert($query);

