<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/28/2019
 * Time: 3:52 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$read = $database->get('sp_gb_plc_Silo9LevelGet');

echo $read;