<?php

/* * *****************************************************************************************************************************************
 * File Name: rootInfo.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/29/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

if($_SERVER['SERVER_ADDR'] == '172.24.16.236')
  {
    define('__ROOT__', dirname($_SERVER['DOCUMENT_ROOT'])); 
  }
  elseif($_SERVER['SERVER_ADDR'] == '::1')
    {
      define('__ROOT__' , 'C:/Users/nolliff/Documents/NetBeansProjects/Silicore/Includes');
    }
  else
    {
      define('__ROOT__', '/var/www/'); 
//      define('__ROOT__' , 'C:/Users/nolliff/Documents/NetBeansProjects/Silicore/Includes');
    }
//========================================================================================== END PHP
?>