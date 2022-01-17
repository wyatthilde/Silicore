<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/1/2018
 * Time: 2:26 PM
 */
include_once('../../Includes/HR/hrFunctions.php');
$jobTitlesObject = NULL;
$jobTitlesString= file_get_contents('php://input');
$jobTitlesObject = json_decode($jobTitlesString, true);



 $site =  test_input($jobTitlesObject['site']);
 $department =  test_input($jobTitlesObject['department']);
 $title =  test_input($jobTitlesObject['title']);
 $description =  test_input($jobTitlesObject['description']);
 $userType =  test_input($jobTitlesObject['user_type']);
 $userId =  test_input($jobTitlesObject['user_id']);

insertJobTitle($site,$department,$title,$description,$userType,$userId);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}