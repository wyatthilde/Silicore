<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/30/2018
 * Time: 1:22 PM
 */
include_once('../../Includes/Security/database.php');

$database = new Database();

$read = $database->get('sp_adm_UserGetAll');

echo $read;