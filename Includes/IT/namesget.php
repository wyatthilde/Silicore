<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/17/2018
 * Time: 11:22 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();
$obj = NULL;
$string= file_get_contents('php://input');
$obj = json_decode($string, true);
$query = $_GET['query'];
$read = $database->get('sp_it_NamesGet("'.$query.'");');

$obj = json_decode($read);

$response = array();

if (is_array($obj) || is_object($obj)) {

    foreach ($obj as $item) {
        $values['value'] = $item->name;
        $values['data'] = $item->id;
        array_push($response, $values);
    }
    $response_array = array('suggestions' => $response);
    echo json_encode($response_array);
} else {
    $values['value'] = '';
    $values['data'] = '';
    $response['suggestions'] = [$values];
    echo json_encode($response);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}