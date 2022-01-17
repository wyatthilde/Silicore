<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/21/2018
 * Time: 9:28 AM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$sitesObj = NULL;
$sitesString= file_get_contents('php://input');
$sitesObj = json_decode($sitesString, true);
$divisionId = test_input($sitesObj['id']);

$site_read = $database->get("sp_hr_SitesByDivisionGet('".$divisionId."')");

echo $site_read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}