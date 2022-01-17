<?php

/* * *****************************************************************************************************************************************
 * File Name: file_edit_info.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/13/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

include('../../Includes/Security/database.php');

$database = new Database();

$doc_id= filter_input(INPUT_POST, 'id');
$doc_description =  filter_input(INPUT_POST, 'description');
$doc_category =  filter_input(INPUT_POST, 'category');
$doc_department =  filter_input(INPUT_POST, 'department');
$user = filter_input(INPUT_POST, 'user_id');
echo "sp_adm_DocumentUpdate(" . $doc_id . ",'". $doc_description . "'," . $doc_category . "," . $doc_department . "," . $user . ");";
$database->get("sp_adm_DocumentUpdate(" . $doc_id . ",'". $doc_description . "'," . $doc_category . "," . $doc_department . "," . $user . ");");
$changeLogSQL = "sp_adm_DocumentChangeLogInsert(" . $user . "," . $doc_id . ",'Edit Document')"; 
$database->insert($changeLogSQL);

//========================================================================================== END PHP
?>
