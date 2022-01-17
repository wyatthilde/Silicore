<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/17/2018
 * Time: 1:46 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);

$id = test_input($obj['id']);
$firstName = test_input($obj['firstName']);
$lastName = test_input($obj['lastName']);
$type = test_input($obj['type']);
$userId = test_input($obj['userId']);

$insert = $database->insert('sp_it_AssetRequestInsert("'.$id.'","'.$firstName.'","'.$lastName.'","'.$type.'","'.$userId.'");');

print_r($insert);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}