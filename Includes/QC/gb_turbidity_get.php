<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/12/2019
 * Time: 9:43 AM
 */
include('../../Includes/Security/database.php');
$db = new Database();
$sampleId = filter_input(INPUT_POST, 'sampleId');
$query = 'sp_gb_qc_TurbidityBySampleIdGet("' . $sampleId . '")';
echo $db->get($query);