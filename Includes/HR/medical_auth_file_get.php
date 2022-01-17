<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/23/2019
 * Time: 1:37 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$requestId = filter_input(INPUT_POST, 'requestId');

$query = 'sp_hr_MedicalAuthFilePathGet("' . $requestId . '")';
echo $db->get($query);