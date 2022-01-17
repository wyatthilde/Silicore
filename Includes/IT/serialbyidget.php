<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/14/2018
 * Time: 10:51 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;

$string = file_get_contents('php://input');

$obj = json_decode($string, true);

$id = test_input($obj['inventory_id']);

$asset_makes_read = $database->get('sp_it_PartNumberByIdGet("' . $id . '");');

echo $asset_makes_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}