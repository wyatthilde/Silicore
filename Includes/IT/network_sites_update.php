<?php

/* * *****************************************************************************************************************************************
 * File Name: network_sites_update.php
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
require_once('../../Includes/Security/database.php');

$database = new Database();

$networkInfo = json_decode(file_get_contents('php://input'),true);
$id = $networkInfo['id'];
$site_name = $networkInfo['site_name'];
$server_name = $networkInfo['server_name'];
$rtx_ip = $networkInfo['rtx_ip'];
$rtx_status = $networkInfo['rtx_status'];
$gateway_ip = $networkInfo['gateway_ip'];
$gateway_status = $networkInfo['gateway_status'];
$att_ip = $networkInfo['att_ip'];
$att_status = $networkInfo['att_status'];
$last_alert = $networkInfo['last_alert'];
$last_update = $networkInfo['last_update'];
if($networkInfo['att_circuit'] == '' || $networkInfo['att_circuit'] == null )
  {
  $att_circut = 'null';
  }
else
  {
    $att_circut = "'" . $networkInfo['att_circuit'] . "'";
  }
//echo $last_alert;
$networkSQL = "sp_it_NetworkSiteUpdate(" . $id . ",'" . $site_name . "','" . $server_name . "','" . $rtx_ip . "'," . $rtx_status . ",'" . $gateway_ip . "'," . $gateway_status . ",'" . $att_ip . "', " . $att_status . "," . $att_circut .",'". $last_update . "','". $last_alert . "')";
echo $networkSQL;
$database->insert($networkSQL);



//========================================================================================== END PHP
?>
