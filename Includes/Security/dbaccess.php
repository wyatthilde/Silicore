<?php
/*******************************************************************************************************************************************
 * File Name: dbaccess.php
 * Project: Silicore
 * Description: This file creates an array of all database and email connection information.
 * Notes: The return array is called $databaseAccess, but can be named anything in the consuming pages.
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 06/15/2017|mnutsch|KACE:17136 - Initial creation
 * 07/20/2017|kkuehn|KACE:17624 - Adding new read-only vistasql1.SilicorePLC user, renaming the VISTASQL1_ constants to SILICOREPLC_, changing
 *                                the associated array keys to silicoreplc_. Also updated the external configuration constants in
 *                                db-mysql-vistasql1.php. Updated docblock header to new format.
 * 07/26/2017|mnutsch|KACE:17366 - Added connection variables for db-mysql-backoffice.php.
 * 02/08/2018|kkuehn|KACE:16787 - Added new connedction variables for vistasql1.DataForTransfer
 * 
 ******************************************************************************************************************************************/

require_once('/var/www/configuration/db-mysql-sandbox.php'); //contains mysql database connection info
require_once('/var/www/configuration/db-mysql-silicore.php'); //contains mysql database connection info
require_once('/var/www/configuration/db-mssql-vistasql1.php'); //contains mssql database connection info
require_once('/var/www/configuration/db-mssql-tlsql1.php'); //contains mssql database connection info
require_once('/var/www/configuration/db-mssql-themine.php'); //contains mysql database connection info
require_once('/var/www/configuration/db-mssql-datafortransfer.php'); //contains mssql database connection info
require_once('/var/www/configuration/db-mysql-backoffice.php'); //contains mysql database connection info
require_once('/var/www/configuration/email-system.php'); //contains mysql database connection info

function databaseConnectionInfo()
{

  //mysql
  $mysql_dbname = SANDBOX_DB_DBNAME001;
  $mysql_username = SANDBOX_DB_USER;
  $mysql_pw = SANDBOX_DB_PWD;
  $mysql_hostname = SANDBOX_DB_HOST;
  
  $silicore_dbname = SILICORE_DB_DBNAME;
  $silicore_username = SILICORE_DB_USER;
  $silicore_pwd = SILICORE_DB_PWD;
  $silicore_hostname = SILICORE_DB_HOST;
  
  $backoffice_dbname = BACKOFFICE_DB_DBNAME;
  $backoffice_username = BACKOFFICE_DB_USER;
  $backoffice_pwd = BACKOFFICE_DB_PWD;
  $backoffice_hostname = BACKOFFICE_DB_HOST;

  //mssql  
  $silicoreplc_dbuser = SILICOREPLC_DB_USER;
  $silicoreplc_pwd = SILICOREPLC_DB_PWD;
  $silicoreplc_dbname = SILICOREPLC_DB_DBNAME;
  $silicoreplc_dbhost = SILICOREPLC_DB_HOST;
  
  //tlmssql
  $silicoreplc_tl_dbuser = SILICOREPLC_TL_DB_USER;
  $silicoreplc_tl_pwd = SILICOREPLC_TL_DB_PWD;
  $silicoreplc_tl_dbname = SILICOREPLC_TL_DB_DBNAME;
  $silicoreplc_tl_dbhost = SILICOREPLC_TL_DB_HOST;
  
  //datafortansfer
  $datafortransfer_dbuser = DATAFORTRANSFER_DB_USER;
  $datafortransfer_pwd = DATAFORTRANSFER_DB_PWD;
  $datafortransfer_dbname = DATAFORTRANSFER_DB_DBNAME;
  $datafortransfer_dbhost = DATAFORTRANSFER_DB_HOST;

  //themine
  $themine_dbuser = THEMINE_DB_USER;
  $themine_dbpwd = THEMINE_DB_PWD;
  $themine_dbname = THEMINE_DB_DBNAME;
  $themine_dbhost = THEMINE_DB_HOST;

  //email system
  $sys_email_user = SYS_EMAIL_USER;
  $sys_email_pwd = SYS_EMAIL_PWD;
  $sys_email_server = SYS_EMAIL_SERVER;
  $sys_email_port = SYS_EMAIL_PORT;

  $keys = array
  (
    'mysql_dbname', 
    'mysql_username', 
    'mysql_pw', 
    'mysql_hostname',
  
    'silicore_dbname', 
    'silicore_username', 
    'silicore_pwd', 
    'silicore_hostname', 
      
    'silicore_tl_dbname', 
    'silicore_tl_username', 
    'silicore_tl_pwd', 
    'silicore_tl_hostname', 
    
    'backoffice_dbname', 
    'backoffice_username', 
    'backoffice_pwd', 
    'backoffice_hostname',
      
    'silicoreplc_dbuser', 
    'silicoreplc_pwd', 
    'silicoreplc_dbname', 
    'silicoreplc_dbhost', 
      
    'datafortransfer_dbname', 
    'datafortransfer_username', 
    'datafortransfer_pwd', 
    'datafortransfer_hostname',
    
    'themine_dbuser', 
    'themine_dbpwd', 
    'themine_dbname', 
    'themine_dbhost', 
  
    'sys_email_user', 
    'sys_email_pwd', 
    'sys_email_server', 
    'sys_email_port'
  );

  $databaseAccess = array_fill_keys($keys, "");
  $databaseAccess['mysql_dbname'] = $mysql_dbname;
  $databaseAccess['mysql_username'] = $mysql_username;
  $databaseAccess['mysql_pw'] = $mysql_pw;
  $databaseAccess['mysql_hostname'] = $mysql_hostname;
  
  $databaseAccess['silicore_dbname'] = $silicore_dbname;
  $databaseAccess['silicore_username'] = $silicore_username;
  $databaseAccess['silicore_pwd'] = $silicore_pwd;
  $databaseAccess['silicore_hostname'] = $silicore_hostname;
  
  $databaseAccess['silicore_tl_dbname'] = $silicoreplc_tl_dbname;
  $databaseAccess['silicore_tl_username'] = $silicoreplc_tl_dbuser;
  $databaseAccess['silicore_tl_pwd'] = $silicoreplc_tl_pwd;
  $databaseAccess['silicore_tl_hostname'] = $silicoreplc_tl_dbhost;
  
  $databaseAccess['backoffice_dbname'] = $backoffice_dbname;
  $databaseAccess['backoffice_username'] = $backoffice_username;
  $databaseAccess['backoffice_pwd'] = $backoffice_pwd;
  $databaseAccess['backoffice_hostname'] = $backoffice_hostname;

  $databaseAccess['silicoreplc_dbuser'] = $silicoreplc_dbuser;
  $databaseAccess['silicoreplc_pwd'] = $silicoreplc_pwd;
  $databaseAccess['silicoreplc_dbname'] = $silicoreplc_dbname;
  $databaseAccess['silicoreplc_dbhost'] = $silicoreplc_dbhost;
  
  $databaseAccess['datafortransfer_dbuser'] = $datafortransfer_dbuser;
  $databaseAccess['datafortransfer_pwd'] = $datafortransfer_pwd;
  $databaseAccess['datafortransfer_dbname'] = $datafortransfer_dbname;
  $databaseAccess['datafortransfer_dbhost'] = $datafortransfer_dbhost;

  $databaseAccess['themine_dbuser'] = $themine_dbuser;
  $databaseAccess['themine_dbpwd'] = $themine_dbpwd;
  $databaseAccess['themine_dbname'] = $themine_dbname;
  $databaseAccess['themine_dbhost'] = $themine_dbhost;

  $databaseAccess['sys_email_user'] = $sys_email_user;
  $databaseAccess['sys_email_pwd'] = $sys_email_pwd;
  $databaseAccess['sys_email_server'] = $sys_email_server;
  $databaseAccess['sys_email_port'] = $sys_email_port;

  return $databaseAccess;
}





