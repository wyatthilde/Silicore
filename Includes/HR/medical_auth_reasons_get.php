<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/18/2019
 * Time: 10:24 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$query = 'sp_hr_MedicalAuthReasonsGet()';
echo $db->get($query);