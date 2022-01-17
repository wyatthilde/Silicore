<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/16/2019
 * Time: 1:07 PM
 */
require_once('../../Includes/Security/database.php');
$db = new Database();

$clinicId = filter_input(INPUT_POST,'clinicId');
$checkedArray = json_decode(filter_input(INPUT_POST,'checkedArray'));
$unCheckedArray = json_decode(filter_input(INPUT_POST,'unCheckedArray'));
try {
    foreach($checkedArray as $test){
        $query = 'sp_hr_LabTestRelationshipInsert("' . $clinicId . '","' . $test .  '")';
        if(is_array($result = $db->insert($query))) {

        } else {
            echo $result;
        }
    }

    foreach($unCheckedArray as $test){
        $query = 'sp_hr_LabTestRelationshipDelete("' . $clinicId . '","' . $test .  '")';
        if(is_array($result = $db->insert($query))){

        } else {
            echo $result;
        }
    }

} catch(Exception $e) {
    echo 'Error: ' . $e;
}
