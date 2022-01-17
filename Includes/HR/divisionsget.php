<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/26/2018
 * Time: 1:13 PM
 */
include('../../Includes/Security/database.php');

$database = new Database();

echo $database->get('sp_hr_DivisionsGet()');