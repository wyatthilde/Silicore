<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 7/22/2019
 */
include('../../Includes/Security/database.php');
$db = new Database();
$sampleId = filter_input(INPUT_POST, 'sampleId');
$query = 'sp_gb_qc_MoistureRateGet("' . $sampleId . '")';
echo $db->get($query);