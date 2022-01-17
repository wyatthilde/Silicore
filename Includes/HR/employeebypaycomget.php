<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 2/12/2019
 * Time: 2:06 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

$paycom = filter_input(INPUT_POST, 'paycomId');

echo $database->get('sp_hr_EmployeeByPaycomGet("' . $paycom . '");');

