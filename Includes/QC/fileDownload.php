<?php
/* * *****************************************************************************************************************************************
 * File Name: fileDownload.php
 * Project: Sandbox
 * Description: This script downloads a file generated from an array of strings passed to it.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 07/10/2017|mnutsch|KACE:17366 - Initial creation
 * 
 * **************************************************************************************************************************************** */

//======================================================================================== BEGIN PHP
$contentStringArray = NULL;

if(isset($_POST['contentStringArray']))
{
  //get the data
  $contentStringArray = $_POST['contentStringArray'];

  $randomString = md5(uniqid(rand(), true)); //this is used to prevent browsers from caching the download file

  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=data' . $randomString . '.csv');

  $output = fopen('php://output', 'w');

  //create a file pointer connected to the output stream
  for($i = 0; $i < count($contentStringArray); $i++)
  {
    fputs($output, ($contentStringArray[$i] . "\n")); //add the string to the file
  }

}

//========================================================================================== END PHP
?>
