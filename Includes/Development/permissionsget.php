<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/3/2018
 * Time: 12:11 PM
 */
include_once('../../Includes/Security/database.php');

$database = new Database();

$read = $database->get('sp_adm_UserTypesGet');

echo $read;