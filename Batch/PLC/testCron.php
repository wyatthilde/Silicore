<?php
/* * *****************************************************************************************************************************************
 * File Name: testCron.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 06/29/2017|kkuehn|KACE:17349 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

//require_once('/var/www/configuration/email-system.php');
//require_once('../Includes/PHPMailer/PHPMailerAutoload.php');
//require_once('../../Includes/pagevariables.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

// Turn debug mode on/off
$debug = 1;

// Establish connection to silicore-site (MySQL)
// test CRUD permissions

// Establish connection to VistaSQL1 (MSSQL)
// test read permissions

// print to file


// send email [DONE, tested from crontab]
SendPHPMail("blah@blah.com","Batch test subject","Batch test body",("/Batch/PLC/testCron.php"),1,0);

//========================================================================================== END PHP
?>

<!-- HTML -->