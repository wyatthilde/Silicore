<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/5/2018
 * Time: 10:42 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$typeObj = NULL;

$typeString = file_get_contents('php://input');

$typeObj = json_decode($typeString, true);

$type = test_input($typeObj['type']);

$asset_makes_read = $database->get('sp_it_AssetMakesByTypeGet("' . $type . '");');

echo $asset_makes_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}