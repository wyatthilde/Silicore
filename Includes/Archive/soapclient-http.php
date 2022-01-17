<?php

/* * ***************************************************************************
 * File Name: soapclient.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Oct 4, 2016[11:47:24 AM]
 * Description: This script will connect to the SOAP server.
 * Notes: originally based on: https://gist.github.com/elvisciotti/4586286#file-gistfile1-php-L18
 * ****************************************************************************/

//==================================================================== BEGIN PHP

$options= array(
  'location' 	=>	'http://sandbox/push-invoice-ap-http.php',
  'uri'		=>	'http://localhost/'
);

$client=new SoapClient(NULL,$options);

$xml_to_send = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <mydata>
      <VendorID>821</VendorID>
      <InvoiceNumber>7561</InvoiceNumber>
      <InvoiceTransDate>3444</InvoiceTransDate>
      <InvoiceTotal>3861</InvoiceTotal>
      <AmountToPay>7861</AmountToPay>
      <DiscountAllowed>9077</DiscountAllowed>
      <DiscountToTake>8734</DiscountToTake>
      <TermsCode>9851</TermsCode>
      <VendorName>7991</VendorName>
      <VendorType>440</VendorType>
      <VendorAddress1>6322</VendorAddress1>
      <VendorAddress2>8388</VendorAddress2>
      <VendorCity>3663</VendorCity>
      <VendorState>257</VendorState>
      <VendorZip>6487</VendorZip>
      <DueDate>6736</DueDate>
      <PayDate>3649</PayDate>
      <APAccount>4716</APAccount>
      <TenNinetyNineType>123456</TenNinetyNineType>
      <Type>7601</Type>
      <InvoiceDocDate>1512</InvoiceDocDate>
      <bPOBased>7316</bPOBased>
      <CreateDate>7861</CreateDate>
      <CreatedBy>3033</CreatedBy>
      <LastModified>554</LastModified>
      <LineNumber>3318</LineNumber>
      <Description>3707</Description>
      <ExpenseAcct>8797</ExpenseAcct>
      <Amount>3587</Amount>
      <AmountToPay>2604</AmountToPay>
      <AmountPaid>6691</AmountPaid>
      <CurrentBalance>6823</CurrentBalance>
      <Qty>737</Qty>
      <UnitCost>7604</UnitCost>
      <LastModified>9810</LastModified>
      <IsTenNinetyNineType>12312</IsTenNinetyNineType>
      <InvoiceHeaderRecord>1268</InvoiceHeaderRecord>
      </mydata>
  </soap:Body>
</soap:Envelope>';


//send the XML to the API
$testXML = $client->sendMessage($xml_to_send); 

echo $testXML;

//====================================================================== END PHP
?>