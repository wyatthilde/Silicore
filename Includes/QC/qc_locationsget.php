<?php

include('../../Includes/Security/database.php');

$database = new Database();

$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);

$id = test_input($obj['id']);

switch ($id) {
    case 50:
        $site = 'tl';
        break;
    case 60:
        $site = 'wt';
        break;
    default:
        $site = 'gb';
}

$read = $database->get('sp_' . $site . '_qc_LocationsGet()');

echo $read;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}