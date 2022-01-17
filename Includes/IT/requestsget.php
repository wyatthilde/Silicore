<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/24/2018
 * Time: 3:29 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$requests_read = $database->get('sp_AssetRequestsAllGet');

echo $requests_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}