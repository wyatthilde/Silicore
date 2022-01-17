<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/30/2018
 * Time: 11:33 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$asset_types_read = $database->get('sp_it_AssetTypesGet');
echo $asset_types_read;