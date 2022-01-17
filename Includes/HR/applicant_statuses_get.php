<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 5/21/2019
 * Time: 3:16 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$query = 'sp_hr_ApplicantStatusesGet()';
echo $db->get($query);