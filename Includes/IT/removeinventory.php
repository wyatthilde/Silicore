<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/6/2018
 * Time: 12:34 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$actionObj = NULL;

$actionString = file_get_contents('php://input');

$actionObj = json_decode($actionString, true);

$id = test_input($actionObj['id']);

$note = test_input($actionObj['note']);

$user_id = test_input($actionObj['user_id']);

$inventory_update = $database->insert('sp_it_RemoveAssetUpdate("' . $id . '","' . $user_id . '","' . $note . '");');

echo $inventory_update;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}