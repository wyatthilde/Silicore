<?php

include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);

$siteId = test_input($obj['siteId']);
$locationId = test_input($obj['locationId']);
$description = test_input($obj['description']);
$userId = test_input($obj['userId']);
$site = 'gb';

switch ($siteId) {
    case 50:
        $site = 'tl';
        break;
    case 60:
        $site = 'wt';
        break;
    default:
        $site = 'gb';
}

$insert = $database->insert('sp_' . $site . '_qc_LocationDetailsInsert("' . $locationId . '", "' . $description . '","' . $userId . '")');

echo $insert;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}