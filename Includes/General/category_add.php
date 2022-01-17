<?php

/* * *****************************************************************************************************************************************
 * File Name: category_add.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/12/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

include('../../Includes/Security/database.php');

$database = new Database();

$cat_name= filter_input(INPUT_POST, 'title');
$dept_id= filter_input(INPUT_POST, 'departmentId');
$permission = filter_input(INPUT_POST, 'permission');
$perm_level= filter_input(INPUT_POST, 'permissionLevel');
$user_id = filter_input(INPUT_POST, 'user_id');

$sql = "sp_adm_DocumentCategoryInsert('" . $cat_name . "'," . $dept_id . ",'" . $permission . "'," . $perm_level . "," . $user_id . ");";

$database->get($sql);

echo $sql;

//========================================================================================== END PHP
?>
