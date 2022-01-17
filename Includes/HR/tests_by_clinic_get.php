<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/18/2019
 * Time: 1:06 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$clinicId = filter_input(INPUT_POST, 'clinicId');

$query = 'sp_hr_TestsByClinicGet("' . $clinicId . '")';
echo $db->get($query);