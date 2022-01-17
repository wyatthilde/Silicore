<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/3/2018
 * Time: 12:53 PM
 */
include_once('../../Includes/Security/database.php');

$database = new Database();
$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);
$user_id = test_input($obj['user_id']);
$read = $database->get('sp_adm_UserPermissionsGet("' . $user_id . '")');

echo $read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
