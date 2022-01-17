<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/8/2019
 * Time: 3:52 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();


$firstName = filter_input(INPUT_POST,'firstName');
$lastName = filter_input(INPUT_POST,'lastName');
$phone = filter_input(INPUT_POST,'phone');
$dob = filter_input(INPUT_POST,'dob');
$site = filter_input(INPUT_POST,'site');
$division = filter_input(INPUT_POST,'division');
$userId = filter_input(INPUT_POST,'userId');

$query = 'sp_hr_ApplicantInsert("' . $firstName . '","' . $lastName . '","' . $phone . '","' . $dob . '","' . $site . '","' . $division . '","' . $userId . '")';

echo $result = $db->insert($query);

