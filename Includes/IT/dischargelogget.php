<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/7/2018
 * Time: 11:59 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$log_read = $database->get('sp_it_DischargeLogGet');

echo $log_read;