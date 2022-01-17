<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/30/2018
 * Time: 9:32 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$inventory_read = $database->get('sp_it_InventoryGet');

echo $inventory_read;