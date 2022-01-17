<?php

/* * *****************************************************************************
 * File Name: soapserver.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Oct 4, 2016[11:47:24 AM], last updated Oct 19, 2016
 * Description: This script will receive an XML file over a SOAP connection.
 * Notes: Store this file in: /var/www/sites/sandbox/content
 * **************************************************************************** */

//==================================================================== BEGIN PHP

//set to display errors, remove after development
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

$debugging = 0; //set this to 1 to see debugging output
     

//include the other files
require ($_SERVER['DOCUMENT_ROOT'] . '/includes/cymaobjects.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/includes/mysqlinsert.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/includes/mssqlfunctions.php');

//this function strips SOAP tags from the XML, so that the XML can be parsed
//based on post at: http://stackoverflow.com/questions/4194489/how-to-parse-soap-xml
function stripSOAP($argSOAPXML)
{ 
  $clean_xml = str_ireplace(['<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">', 'SOAP-ENV:', 'SOAP:', '</envelope>', '<Body>', '</Body>'], '', $argSOAPXML);
		
  return $clean_xml;
}

// server
class MySoapServer
{
		
  //this function will send a response to the client
  //originally based on: https://gist.github.com/elvisciotti/4586286#file-gistfile1-php-L18
  public function sendMessage($argXML)
  {
    //declaring variables
    $textToReturn = "";    
    $textToReturnIfSuccessful = '<?xml version="1.0" encoding="UTF-8"?>
    <EAMAPIServer versionID="1.0.0" releaseID="1.0" xmlns="http://schema.infor.com/InforOAGIS/2" languageCode="en-US" systemEnvironmentCode="Production">
            <ConnectionResult>
                    Success
            </ConnectionResult>
    </EAMAPIServer>';

    $textToReturnIfFailure = '<?xml version="1.0" encoding="UTF-8"?>
    <EAMAPIServer versionID="1.0.0" releaseID="1.0" xmlns="http://schema.infor.com/InforOAGIS/2" languageCode="en-US" systemEnvironmentCode="Production">
            <ConnectionResult>
                    Failure
            </ConnectionResult>
    </EAMAPIServer>';
    
    if($debugging)
      $textToReturn = $textToReturn . "Connected to SOAP server!";
    
    //Log the incoming transaction in the MySQL database
    $source_for_db = "EAM";
    $data_processed_for_db = $argXML;
    $connectionReturn = ConnectToMySQL();
    if($connectionReturn == 1)
    {
      //echo "Successfully connected to the database.";
    }
    else 
    {
      //echo "Failure to access the MySQL database: " . $connectionReturn;
    }
    //$resultOfMySQLInsert = insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db, $db_connection); //direct SQL method
    $resultOfMySQLInsert = $GLOBALS['conn']->query("CALL insertLogDataAPIn('$source_for_db', '$data_processed_for_db', '$result_status_for_db')"); //Stored Procedure method
    if($resultOfMySQLInsert == 1)
    {
      if($debugging)
        $textToReturn = $textToReturn . "Successfully logged incoming content into MySQL<br />";        
    }
    else 
    {
      if($debugging)
        $textToReturn = $textToReturn . "Failed to log incoming content into MySQL: " . $resultOfMySQLInsert . "<br />";    
    }
    
    try 
    {
      //Prepare the XML by converting it from SOAP XML to regular XML
      $temp1 = stripSOAP($argXML);
      $temp2 = utf8_encode($temp1);
      $xml = simplexml_load_string($temp2);
      
      //extract the values and save them to variables
      $VendorID = $xml->VendorID;
      $InvoiceNumber = $xml->InvoiceNumber;
      /*
      $InvoiceTransDate = $xml->InvoiceTransDate;
      $InvoiceTotal = $xml->InvoiceTotal;
      $AmountToPay = $xml->AmountToPay;
      $DiscountAllowed = $xml->DiscountAllowed;
      $DiscountToTake = $xml->DiscountToTake;
      $TermsCode = $xml->TermsCode;
      $VendorName = $xml->VendorID;
      $VendorType = $xml->VendorType;
      $VendorAddress1 = $xml->VendorAddress1;
      $VendorAddress2 = $xml->VendorAddress2;
      $VendorCity = $xml->VendorCity;
      $VendorState = $xml->VendorState;
      $VendorZip = $xml->VendorZip;
      $DueDate = $xml->DueDate;
      $PayDate = $xml->PayDate;
      $APAccount = $xml->APAccount;
      $TenNinetyNineType = $xml->TenNinetyNineType; //FKA 1099Type
      $InvoiceDocDate = $xml->InvoiceDocDate;
      $bPOBased = $xml->bPOBased;
      $CreateDate = $xml->CreateDate;
      $CreatedBy = $xml->CreatedBy;
      $LastModified = $xml->LastModified;
      $LineNumber = $xml->LineNumber;
      $Description = $xml->Description;
      $ExpenseAcct = $xml->ExpenseAcct;
      $Amount = $xml->Amount;
      $AmountPaid = $xml->AmountPaid;
      $CurrentBalance = $xml->CurrentBalance;
      $Qty = $xml->Qty;
      $UnitCost = $xml->UnitCost;
      $IsTenNinetyNine = $xml->IsTenNinetyNine; //FKA 1099?
      $InvoiceHeaderRecord = $xml->InvoiceHeaderRecord;
      */
      //DEV NOTE: load variables into objects - requires cymaobjects.php be included
      $importedObject = new sandboxObject(); 
      
      $importedObject->setVariable("VendorID", "$VendorID");
      $importedObject->setVariable("InvoiceNumber", "$InvoiceNumber");
      /*
      $importedObject->setVariable("InvoiceTransDate", "$InvoiceTransDate");
      $importedObject->setVariable("InvoiceTotal", "$InvoiceTotal");
      $importedObject->setVariable("AmountToPay", "$AmountToPay");
      $importedObject->setVariable("DiscountAllowed", "$DiscountAllowed");
      $importedObject->setVariable("DiscountToTake", "$DiscountToTake");
      $importedObject->setVariable("TermsCode", "$TermsCode");
      $importedObject->setVariable("VendorName", "$VendorName");
      $importedObject->setVariable("VendorType", "$VendorType");
      $importedObject->setVariable("VendorAddress1", "$VendorAddress1");
      $importedObject->setVariable("VendorAddress2", "$VendorAddress2");
      $importedObject->setVariable("VendorCity", "$VendorCity");
      $importedObject->setVariable("VendorState", "$VendorState");
      $importedObject->setVariable("VendorZip", "$VendorZip");
      $importedObject->setVariable("DueDate", "$DueDate");
      $importedObject->setVariable("PayDate", "$PayDate");
      $importedObject->setVariable("APAccount", "$APAccount");
      $importedObject->setVariable("TenNinetyNineType", "$TenNinetyNineType"); //FKA 1099Type
      $importedObject->setVariable("InvoiceDocDate", "$InvoiceDocDate");
      $importedObject->setVariable("bPOBased", "$bPOBased");
      $importedObject->setVariable("CreateDate", "$CreateDate");
      $importedObject->setVariable("CreatedBy", "$CreatedBy");
      $importedObject->setVariable("LastModified", "$LastModified");
      $importedObject->setVariable("LineNumber", "$LineNumber");
      $importedObject->setVariable("Description", "$Description");
      $importedObject->setVariable("ExpenseAcct", "$ExpenseAcct");
      $importedObject->setVariable("Amount", "$Amount");
      $importedObject->setVariable("AmountPaid", "$AmountPaid");
      $importedObject->setVariable("CurrentBalance", "$CurrentBalance");
      $importedObject->setVariable("Qty", "$Qty");
      $importedObject->setVariable("UnitCost", "$UnitCost");
      $importedObject->setVariable("IsTenNinetyNine", "$IsTenNinetyNine"); //FKA 1099?
      $importedObject->setVariable("InvoiceHeaderRecord", "$InvoiceHeaderRecord");
      */
      
      //DEV NOTE: insert code here to insert objects into the CYMA database
      //connect to the MSSQL database
      if($debugging)
        $textToReturn = $textToReturn . "Connecting to MSSQL<br />";
      $connectionReturnMSSQL = ConnectToMSSQL();
      if($connectionReturnMSSQL == 1) 
      {
        if($debugging)
          $textToReturn = $textToReturn . "Successfully connected to CYMA-MSSQL.<br />";   

        //DEV NOTE: replace this query with MSSQL stored procedure to insert data into MSSQL.
        //Step 1: query the rest of the data from MSSQL
        $queryResultMSSQL = QueryMSSQLAP($customer_id);

        //dev note: check that CYMA data is there
        if($debugging)
        {
          //DEV NOTE: update these to the appropriate Vendor fields.
          $textToReturn = $textToReturn . $GLOBALS['$cyma_address1'] . "<br />";
          $textToReturn = $textToReturn . $GLOBALS['$cyma_address2'] . "<br />";
        }

        //Add CYMA data to the object
        //DEV NOTE: update these to the appropriate Vendor fields.
        $importedObject->setVariable("cyma_address1", "$cyma_address1");
        $importedObject->setVariable("cyma_address2", "$cyma_address2");

        //Step 2: insert the new data into MSSQL
        if($queryResultMSSQL == 1)
          $insertResultMSSQL = InsertMSSQL();
        if($queryResultMSSQL == 1)
        {
          if($debugging)
            $textToReturn = $textToReturn . "Successfully queried CYMA-MSSQL.<br />";
        }
        else
        {
          if($debugging)
            $textToReturn = $textToReturn . "error querying CYMA-MSSQL.<br />";
          $isSuccessful = 0;
        }

        if($insertResultMSSQL == 1)
        {
          if($debugging)
            $textToReturn = $textToReturn . "Successfully inserted into CYMA-MSSQL.<br />";
        }
        else
        {
          if($debugging)
            $textToReturn = $textToReturn . "error inserting into CYMA-MSSQL.<br />";
          $isSuccessful = 0;
        }
      }
      else
      {
        if($debugging)
          $textToReturn = $textToReturn . "Failed to connect to CYMA-MSSQL.<br />";  
        $isSuccessful = 0;
      }

      
      //Log the outgoing transaction in the MySQL database
      //check if the MSSQL database insertion was successful
      if($isSuccessful == 1) 
      {
        $result_status_for_db = "1"; //success
      }
      else
      {
        $result_status_for_db = "0"; //failure
      }
      
      //content to log in MySQL
      
      $importedObject_json = json_encode((array)$importedObject);
      if($debugging)
        $textToReturn = $textToReturn .  $importedObject_json . "<br />"; //for debug
      
      //LOG DATA IN MYSQL
      //assumes previously connected to MySQL
      //$resultOfMySQLInsert = insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db, $db_connection); //direct SQL method
      $resultOfMySQLInsert = $GLOBALS['conn']->query("CALL insertLogDataAPOut('$source_for_db', '$importedObject_json', '$result_status_for_db')"); //Stored Procedure method
      
      if($resultOfMySQLInsert == 1)
      {
        $textToReturn = $textToReturn . $textToReturnIfSuccessful;        
      }
      else 
      {
        if($debugging)
          $textToReturn = $textToReturn . "Failure to access MySQL log: " . $resultOfMySQLInsert;
        $textToReturn = $textToReturn . $textToReturnIfFailure;      
      }
      
      
    } 
    catch (Exception $e) 
    {
      if($debugging)
        $textToReturn = $textToReturn . 'Caught exception: ' . $e->getMessage() . "\n";
      $textToReturn = $textToReturn . $textToReturnIfFailure;  
    }
     
    return $textToReturn;
  }  
  
}

$options = array('uri'=>'http://sandbox');
$server=new SoapServer(NULL,$options);
$server->setClass('MySoapServer');
$server->handle();

//====================================================================== END PHP
?>