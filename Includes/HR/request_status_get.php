<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/25/2019
 * Time: 10:30 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$query = 'sp_hr_MedicalAuthStatusCodesGet()';
echo $db->get($query);