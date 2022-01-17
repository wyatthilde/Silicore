<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/15/2018
 * Time: 8:55 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$log_read = $database->get('sp_it_AssetPricesGet');

echo $log_read;

