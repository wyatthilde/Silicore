<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/11/2019
 * Time: 1:56 PM
 */
require_once('../../Includes/Security/database.php');
$sampleId = filter_input(INPUT_POST, 'sampleId');
$db = new Database();
$query = 'sp_gb_qc_KValuesBySampleIdGet("' . $sampleId . '")';

$obj = json_decode($db->get($query));

$array = Array();
//$count = 1;

foreach ($obj as $item) {
    if(!isset($array[$item->k_value_id])) {
        $array[$item->k_value_id] = null;
        //$count = 1;
    }
    if(!isset($array[$item->k_value_id]['value'])) {
        $array[$item->k_value_id]['value'] = null;
    }
    if(!isset($array[$item->k_value_id]['desc'])) {
        $array[$item->k_value_id]['desc'] = null;
    }
    if(!isset($array[$item->k_value_id]['entries'])) {
        $array[$item->k_value_id]['entries'] = null;
    }
    $array[$item->k_value_id]['desc'] = $item->description;
    $array[$item->k_value_id]['value'] += $item->value;
    $array[$item->k_value_id]['entries'] = 3;
    //$count++;
}

echo json_encode($array, true);