<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/6/2018
 * Time: 9:37 AM
 */
include_once('../../Includes/Security/database.php');

$database = new Database();

$read = $database->get('sp_adm_UserTypesGet');

echo $read;