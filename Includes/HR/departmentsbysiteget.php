<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/26/2018
 * Time: 2:30 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;

$string= file_get_contents('php://input');

$obj = json_decode($string, true);

$siteId = test_input($obj['siteId']);

$read = $database->get('sp_hr_DepartmentsBySiteGet("' . $siteId . '");');

echo $read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}