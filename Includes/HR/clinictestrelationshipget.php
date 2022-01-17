<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/16/2019
 * Time: 1:43 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$clinicId = filter_input(INPUT_POST, 'clinicId');

$query = 'sp_hr_ClinicTestRelationshipGet("' . $clinicId . '")';
echo $db->get($query);