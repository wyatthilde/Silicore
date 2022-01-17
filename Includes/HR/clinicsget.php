<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/16/2019
 * Time: 10:53 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$query = 'sp_hr_ClinicsGet()';
echo $db->get($query);