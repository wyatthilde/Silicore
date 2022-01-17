<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/9/2019
 * Time: 9:06 AM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$query = 'sp_hr_ApplicantsGet()';
echo $db->get($query);