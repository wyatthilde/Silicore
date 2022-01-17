<?php

/* * *****************************************************************************
 * File Name: cymatest.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Oct 27, 2016[1:54:06 PM], Last Updated Nov 1, 2016
 * Description: This code tests the cyma connection
 * Notes: 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

$debugging = 1;

if($debugging)
{
    //display errors
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled</strong>";  
}

//include the other files
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/cymaobjects.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/mysqlinsert.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/mssqlfunctions_ar.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/mssqlfunctions_so.php');
require_once('/var/www/configuration/db-mssql-themine.php');
require_once('/var/www/configuration/db-mssql-vistasql1.php');

//connect to the MSSQL database
if($debugging)
  echo "***<br />Connecting to MSSQL<br />";

$connectionReturnMSSQL = 0;
try 
  {
    $port = 1433;
    $dbname = THEMINE_DB_DBNAME;
    $username = THEMINE_DB_USER;
    $pw = THEMINE_DB_PWD;
    $hostname = THEMINE_DB_HOST;
    
    $dsn = "sqlsrv:Server=themine,1433";
    $GLOBALS['mssql_conn'] = new PDO($dsn, $username, $pw);
    $GLOBALS['mssql_conn']->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $connectionReturnMSSQL = 1;
  }
  catch (PDOException $e) 
  {
    echo "Failed to connect to MSSQL on TheMine: " . $e->getMessage() . "\n";
    //exit;
  }


if($connectionReturnMSSQL == 1) 
{
    
    
  if($debugging)
    echo "***<br />Successfully connected to CYMA-MSSQL.<br /><br />";   
  ///SO Tables
  $queryResultMSSQLSO_Ord2 = QueryMSSQLSO_Ord2($debugging);

  $queryResultMSSQLSO_OdLn2 = QueryMSSQLSO_OdLn2("2", $debugging);
  
  $queryResultMSSQLSO_ship = QueryMSSQLSO_ship("2", $debugging);
  
  $queryResultMSSQLSO_ShpLn = QueryMSSQLSO_ShpLn("2", $debugging);
  
  $queryResultMSSQLSO_SNote = QueryMSSQLSO_SNote("2", $debugging);
  
  //AR Tables
  $queryResultMSSQLAR_Cust2 = QueryMSSQLAR_Cust2("HALLIBURTON", $debugging);
  
  $queryResultMSSQLAR_CustShip2 = QueryMSSQLAR_CustShip2("HALLIBURTON", $debugging);
  
  $queryResultMSSQLAR_Inv2 = QueryMSSQLAR_Inv2("166393", $debugging);
  
  $queryResultMSSQLAR_InvoiceLn5 = QueryMSSQLAR_InvoiceLn5("9424", $debugging);
  
  $queryResultMSSQLAR_InvoiceLnTax = QueryMSSQLAR_InvoiceLnTax("9377", $debugging);
  
  try
  {
    $queryResultMSSQLAR_TaxIds2 = QueryMSSQLAR_TaxIds2("TXSALE", $debugging);
  } 
  catch (Exception $e) 
  {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
  
  if($debugging)
  {
    echo "<br/>";
        
    //SO Tables
    echo "<strong>These are the contents of object SO_Ord2:</strong> <br/>";
    echo var_dump($queryResultMSSQLSO_Ord2) . "<br />";
    echo "<br/>";
    echo "<strong>These are the contents of object SO_OdLn2:</strong>  <br/>";
    echo var_dump($queryResultMSSQLSO_OdLn2) . "<br />";
    echo "<br/>";
    echo "<strong>These are the contents of object SO_ship:</strong>  <br/>";
    echo var_dump($queryResultMSSQLSO_ship) . "<br />";
    echo "<br/>";
    echo "<strong>These are the contents of object SO_ShpLn:</strong>  <br/>";
    echo var_dump($queryResultMSSQLSO_ShpLn) . "<br />";
    echo "<br/>";
    echo "<strong>These are the contents of object SO_SNote:</strong>  <br/>";
    echo var_dump($queryResultMSSQLSO_SNote) . "<br />";
    
    //AR Tables
    echo "<br/>";
    echo "<strong>These are the contents of object AR_Cust2:</strong>  <br/>";
    echo var_dump($queryResultMSSQLAR_Cust2) . "<br />";
    
    echo "<br/>";
    echo "<strong>These are the contents of object AR_CustShip2:</strong>  <br/>";
    echo var_dump($queryResultMSSQLAR_CustShip2) . "<br />";
    
    echo "<br/>";
    echo "<strong>These are the contents of object AR_Inv2:</strong>  <br/>";
    echo var_dump($queryResultMSSQLAR_Inv2) . "<br />";
    
    echo "<br/>";
    echo "<strong>These are the contents of object AR_InvoiceLn5:</strong>  <br/>";
    echo var_dump($queryResultMSSQLAR_InvoiceLn5) . "<br />";
    
    echo "<br/>";
    echo "<strong>These are the contents of object AR_InvoiceLnTax:</strong>  <br/>";
    echo var_dump($queryResultMSSQLAR_InvoiceLnTax) . "<br />";
    
    echo "<br/>";
    echo "<strong>These are the contents of object AR_TaxIds2:</strong>  <br/>";
    echo var_dump($queryResultMSSQLAR_TaxIds2) . "<br />";
    
    
    //echo "<br/>";
    //echo "<strong>Testing the insertion of data into a MSSQL database table (not CYMA) using PHP:</strong>  <br/>";
    //$importedObject = new sandboxObject();
    //echo InsertMSSQL($importedObject);
    
    
  }
 
  //close the database connection
  $GLOBALS['mssql_conn'] = NULL;
}

//====================================================================== END PHP
?>