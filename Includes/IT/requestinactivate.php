<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/17/2018
 * Time: 3:08 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);

$id = test_input($obj['id']);

$insert = $database->insert('sp_it_AssetRequestInactivate("'.$id.'");');

echo $insert;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}