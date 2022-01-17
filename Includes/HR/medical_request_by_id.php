<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/22/2019
 * Time: 9:40 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$requestId = filter_input(INPUT_POST, 'requestId');

$query = 'sp_hr_MedicalRequestByIdGet("' . $requestId . '")';
echo $db->get($query);