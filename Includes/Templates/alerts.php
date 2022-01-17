<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 11/12/2018
 * Time: 2:35 PM
 */
include('../../Includes/Security/database.php');
$database = new Database();
$alerts_read = $database->get('sp_it_IncompleteRequestsCountGet');
echo $alerts_read;