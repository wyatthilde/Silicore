<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/3/2018
 * Time: 12:24 PM
 */
include_once('../../Includes/Security/database.php');

$database = new Database();

$read = $database->get('sp_adm_DepartmentsGetAll');

echo $read;