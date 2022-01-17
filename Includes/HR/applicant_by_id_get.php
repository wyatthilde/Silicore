<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 5/9/2019
 * Time: 2:15 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();
$id = filter_input(INPUT_POST, 'id');
$query = 'sp_hr_ApplicantByIdGet("' . $id . '")';
echo $db->get($query);