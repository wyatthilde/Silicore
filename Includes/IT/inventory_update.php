<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 3/28/2019
 * Time: 2:58 PM
 */
require_once('../../Includes/Security/database.php');

$db = new Database();

$id = filter_input(INPUT_POST, 'id');
$division = filter_input(INPUT_POST, 'division');
$site = filter_input(INPUT_POST, 'site');
$type = filter_input(INPUT_POST, 'type');
$make = filter_input(INPUT_POST, 'make');
$description = filter_input(INPUT_POST, 'description');
$userId = filter_input(INPUT_POST, 'userId');

echo $query = 'sp_it_InventoryUpdate("' . $id . '","' . $division . '","' . $site . '","' . $type  . '","' . $make . '","' . $description . '","' . $userId . '");';

$db->insert($query);
