<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/7/2018
 * Time: 9:13 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$log_read = $database->get('sp_it_AssignLogGet');

echo $log_read;