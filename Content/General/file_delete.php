<?php

/* * *****************************************************************************************************************************************
 * File Name: file_delete.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/08/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP


include('../../Includes/Security/database.php');

$database = new Database();

$doc_id= filter_input(INPUT_POST, 'id');
$doc_path =  filter_input(INPUT_POST, 'doc_path');
$file_name = substr($doc_path, strrpos($doc_path, '/') + 1);
$new_path = '../../Files/Archive/' + file_name;
//rename($doc_path, $new_path);
echo($doc_path . "<br>" . $file_name . "<br>" . $new_path);
//sesread = $database->get("sp_adm_DocumentSetInactive(" . $doc_id . ",'". $new_path. "');");


//========================================================================================== END PHP
?>
