<?php

/* * *****************************************************************************************************************************************
 * File Name: network_sites_alert_switch.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 04/08/2019|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
include('../../Includes/Security/database.php');

$database = new Database();

$id = filter_input(INPUT_POST, 'siteId');
$status = filter_input(INPUT_POST, 'newStat');
//echo('sp_it_NetowrkAlertUpdate("' . $id . '","' . $status . '");');
$statusUpdate = $database->insert('sp_it_NetworkAlertUpdate("' . $id . '","' . $status . '");');

echo $statusUpdate;

//========================================================================================== END PHP
?>
