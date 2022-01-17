<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/14/2019
 * Time: 2:28 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$read = $database->get('sp_gb_plc_Silo2LevelGet');

echo $read;