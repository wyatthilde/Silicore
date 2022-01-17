<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/17/2018
 * Time: 4:26 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$response = array();

if(isset($_GET['query'])) {
    $query = test_input($_GET['query']);
    $search = $database->get("sp_hr_EmployeeNamesGet('".$query."');");
    $obj = json_decode($search);
    if (is_array($obj) || is_object($obj)) {
        foreach ($obj as $item) {
            $values['value'] = $item->first_name.' '.$item->last_name;
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
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
