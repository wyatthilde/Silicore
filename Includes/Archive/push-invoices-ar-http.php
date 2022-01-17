<?php

/* * *****************************************************************************
 * File Name: push-invocies-ar-http.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Oct 5, 2016[1:54:06 PM], last updated Nov 8, 2016
 * Description: This code receives a POST of JSON
 * Notes: Store this file in: /var/www/sites/sandbox/content
 * **************************************************************************** */

//==================================================================== BEGIN PHP

$debugging = 1; //set this to 1 to see debugging output

if($debugging)
{
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled</strong>";  
}

//include the other files
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/cymaobjects.php'); //functions for storing and accessing data in an object
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/mysqlinsert.php'); //functions for accessing MySQL
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/mssqlfunctions_ar.php'); //functions for accessing MSSQL - CYMA
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Includes/mailfunctions.php'); //functions for sending emails
require_once('/var/www/configuration/db-mssql-themine.php');
require_once('/var/www/configuration/db-mssql-vistasql1.php');

$isSuccessful = 1; //used to track if the API interaction is successful

//RECEIVE TRANSMISSION FROM SALESFORCE
if ($_POST['json_value']) //json data was sent
{  
  
  //DEV NOTE add code to escape out harmful characters
  $json_data = $_POST["json_value"]; 
  $json_decoded = json_decode($json_data, true);
  
  //extract the values and save them to variables
  $customer_id = $json_decoded['customer_id'];
  $po_id = $json_decoded['po_id'];
  $job = $json_decoded['job'];
  $date = $json_decoded['date'];
  
  $invoice_id = $json_decoded['invoice_id'];
  $sf_user_id = $json_decoded['sf_user_id'];
  $total_net_tons = $json_decoded['total_net_tons'];
  $product_id = $json_decoded['product_id'];
  $url_for_invoice = $json_decoded['url_for_invoice'];
  
  //load variables into objects - requires cymaobjects.php be included
  $importedObject = new sandboxObject(); 
  
  $importedObject->setVariable("customer_id", "$customer_id");
  $importedObject->setVariable("po_id", "$po_id");
  $importedObject->setVariable("job", "$job");
  $importedObject->setVariable("date", "$date");
  $importedObject->setVariable("invoice_id", "$invoice_id");
  $importedObject->setVariable("sf_user_id", "$sf_user_id");
  $importedObject->setVariable("total_net_tons", "$total_net_tons");
  $importedObject->setVariable("product_id", "$product_id");
  $importedObject->setVariable("url_for_invoice", "$url_for_invoice");

  
  //Document incoming content in MySQL log
  $source_for_db = "SalesForce";
  $data_processed_for_db = $json_data;
  $connectionReturn = ConnectToMySQL();
  if($connectionReturn == 1)
  {
    if($debugging)
      echo "<br />Successfully connected to MySQL.<br />";
  }
    else 
  {
    if($debugging)
      echo "<br />Failure to access MySQL: " . $connectionReturn;
    $isSuccessful = 0;
  }
  //$resultOfMySQLInsert = insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db); //direct SQL method
  $resultOfMySQLInsert = $conn->query("CALL insertLogDataARIn('$source_for_db', '$data_processed_for_db', '1')"); //Stored procedure method
  if($resultOfMySQLInsert == 1)
  {
    if($debugging)
      echo "***<br />Successfully added to inbound MySQL log.<br />";
  }
  else 
  {
    if($debugging)
      echo "***<br />Failure to access MySQL log: " . $resultOfMySQLInsert . "<br />";
    $isSuccessful = 0;
  }
  
  //connect to the MSSQL database
  if($debugging)
    echo "***<br />Connecting to MSSQL<br />";
  
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
      echo "***<br />Successfully connected to CYMA-MSSQL.<br />";   
    
    //DEV NOTE: replace this query with MSSQL stored procedure to insert data into MSSQL.
    //Step 1: query the rest of the data from MSSQL
    $queryResultMSSQL = QueryMSSQLAR($customer_id, $product_id);
           
    //dev note: check that CYMA data is there
    if($debugging)
    {
      echo "********************************************************************<br />Values read from the CYMA database:<br />";
      
      echo "cyma_address1: " . $GLOBALS['$cyma_address1'] . "<br />";
      echo "cyma_address2: " . $GLOBALS['$cyma_address2'] . "<br />";
      echo "cyma_city: " . $GLOBALS['$cyma_city'] . "<br />";
      echo "cyma_state: " . $GLOBALS['$cyma_state'] . "<br />";
      echo "cyma_zip: " . $GLOBALS['$cyma_zip'] . "<br />";
      echo "cymae_country: " . $GLOBALS['$cyma_country'] . "<br />"; 
      echo "cyma_terms_code: " . $GLOBALS['$cyma_terms_code'] . "<br />"; 
      echo "cyma_location_id: " . $GLOBALS['$cyma_location_id'] . "<br />"; 
      echo "cyma_ship_name: " . $GLOBALS['$cyma_ship_name'] . "<br />"; 
      echo "cyma_ship_address_1: " . $GLOBALS['$cyma_ship_address_1'] . "<br />"; 
      echo "cyma_ship_address_2: " . $GLOBALS['$cyma_ship_address_2'] . "<br />"; 
      echo "cyma_ship_city: " . $GLOBALS['$cyma_ship_city'] . "<br />"; 
      echo "cyma_ship_state: " . $GLOBALS['$cyma_ship_state'] . "<br />"; 
      echo "cyma_ship_zip: " . $GLOBALS['$cyma_ship_zip'] . "<br />"; 
      echo "cyma_ship_country: " . $GLOBALS['$cyma_ship_country'] . "<br />"; 
      echo "cyma_ship_attn: " . $GLOBALS['$cyma_ship_attn'] . "<br />"; 
      echo "cyma_ship_phone: " . $GLOBALS['$cyma_ship_phone'] . "<br />"; 
      echo "cyma_description: " . $GLOBALS['$cyma_description'] . "<br />"; 
      echo "cyma_taxable: " . $GLOBALS['$cyma_taxable'] . "<br />"; 
      echo "cyma_price: " . $GLOBALS['$cyma_price'] . "<br />"; 
      echo "cyma_sales_account_id: " . $GLOBALS['$cyma_sales_account_id'] . "<br />"; 
      echo "cyma_unit_cost: " . $GLOBALS['$cyma_unit_cost'] . "<br />"; 
      echo "cyma_unit_of_measure: " . $GLOBALS['$cyma_unit_of_measure'] . "<br />"; 
      echo "cyma_tax_id: " . $GLOBALS['$cyma_tax_id'] . "<br />"; 
      echo "cyma_tax_id_taxed: " . $GLOBALS['$cyma_tax_state_sales'] . "<br />"; 
      echo "cyma_tax_accrual_account_id: " . $GLOBALS['$cyma_tax_accrual_id'] . "<br />"; 
      echo "cyma_tax_rate: " . $GLOBALS['$cyma_tax_rate'] . "<br />"; 
      
      echo "cyma_tax_id_taxable: " . $GLOBALS['$cyma_tax_id_taxable'] . "<br />"; 
      
      echo "*************************************************************<br />";
    }
    
    //Add CYMA data to the object
    
    //AR_Inv2
    $importedObject->setVariable("cyma_address1", $GLOBALS['$cyma_address1']);
    $importedObject->setVariable("cyma_address2", $GLOBALS['$cyma_address2']);
    $importedObject->setVariable("cyma_city", $GLOBALS['$cyma_city']);
    $importedObject->setVariable("cyma_state", $GLOBALS['$cyma_state']);
    $importedObject->setVariable("cyma_zip", $GLOBALS['$cyma_zip']);
    $importedObject->setVariable("cyma_country", $GLOBALS['$cyma_country']);
    $importedObject->setVariable("cyma_terms_code", $GLOBALS['$cyma_terms_code']);
    
    //ARInvLn5
    $importedObject->setVariable("cyma_location_id", $GLOBALS['$cyma_location_id']);
    $importedObject->setVariable("cyma_ship_name", $GLOBALS['$cyma_ship_name']);
    $importedObject->setVariable("cyma_ship_address_1", $GLOBALS['$cyma_ship_address_1']);
    $importedObject->setVariable("cyma_ship_address_2", $GLOBALS['$cyma_ship_address_2']);
    $importedObject->setVariable("cyma_ship_city", $GLOBALS['$cyma_ship_city']);
    $importedObject->setVariable("cyma_ship_state", $GLOBALS['$cyma_ship_state']);
    $importedObject->setVariable("cyma_ship_zip", $GLOBALS['$cyma_ship_zip']);
    $importedObject->setVariable("cyma_ship_country", $GLOBALS['$cyma_ship_country']);
    $importedObject->setVariable("cyma_ship_attn", $GLOBALS['$cyma_ship_attn']);
    $importedObject->setVariable("cyma_ship_phone", $GLOBALS['$cyma_ship_phone']);
    
    //PM_Prod3
    $importedObject->setVariable("cyma_description", $GLOBALS['$cyma_description']);
    $importedObject->setVariable("cyma_taxable", $GLOBALS['$cyma_taxable']);
    $importedObject->setVariable("cyma_price", $GLOBALS['$cyma_price']);
    $importedObject->setVariable("cyma_sales_account_id", $GLOBALS['$cyma_sales_account_id']);
    $importedObject->setVariable("cyma_unit_cost", $GLOBALS['$cyma_unit_cost']);
    $importedObject->setVariable("cyma_unit_of_measure", $GLOBALS['$cyma_unit_of_measure']);
    
    //AR_TaxIds2
    $importedObject->setVariable("tax_id", $GLOBALS['$cyma_tax_id']);
    $importedObject->setVariable("tax_id_taxed", $GLOBALS['$cyma_tax_state_sales']);
    $importedObject->setVariable("tax_accrual_account_id", $GLOBALS['$cyma_tax_accrual_id']);
    $importedObject->setVariable("tax_rate", $GLOBALS['$cyma_tax_rate']);
    
    $importedObject->setVariable("tax_id_taxable", $GLOBALS['$cyma_tax_id_taxable']); 
    
    $importedObject->setVariable("charge_state_tax", $GLOBALS['$cyma_tax_state_sales']); // 1 or 0 - DEV NOTE: This is an oversimplification for a process not in use
    
    //Set static object variables for database insertion
    //AR_Inv2
    $importedObject->setVariable("invoice_status", "M");
    if($total_net_tons < 0)
    { 
      $importedObject->setVariable("credit", "1");
    }
    else
    {
      $importedObject->setVariable("credit", "0");
    }
    $importedObject->setVariable("fin_chg_in", "0");
    $importedObject->setVariable("beginning_bal_invoice", "0");
    $importedObject->setVariable("unapplied_pmt", "0");
    $importedObject->setVariable("dep_with_order", "0");
    $importedObject->setVariable("apply_to_invoice", "");
    $importedObject->setVariable("link_to_invoice", "");
    $importedObject->setVariable("ar_account", "1030000");
    $importedObject->setVariable("ordered_by", "");
    $importedObject->setVariable("inv_date", date("Y-m-d")); //DEV NOTE: Test this
    $importedObject->setVariable("due_date", date('Y-m-d', mktime(0, 0, 0, date('m')+2, 14, date('Y')))); //DEV NOTE: Test this
    $importedObject->setVariable("disc_date", date('Y-m-d', mktime(0, 0, 0, date('m')+1, 20, date('Y')))); //DEV NOTE: Test this
    $importedObject->setVariable("tax_cat_id", "TXSALE"); //DEV NOTE: check that this should not be dynamic
    $importedObject->setVariable("tax_amt", 0.00); //DEV NOTE: check that this should not be dynamic
    $importedObject->setVariable("freight_gl_account_id", "4999920"); //DEV NOTE: check that this should not be dynamic
    $importedObject->setVariable("freight_amt", 0.00);  //DEV NOTE: check that this should not be dynamic
    $importedObject->setVariable("inv_total", $importedObject->getVariable("cyma_price") * $importedObject->getVariable("total_net_tons"));
    $importedObject->setVariable("method_of_payment", "0");
    $importedObject->setVariable("check_no", "");
    $importedObject->setVariable("cc_exp_date", "");
    $importedObject->setVariable("bank_id", "");
    $importedObject->setVariable("amt_paid", 0.00);
    $importedObject->setVariable("disc_amt", 0.00);
    $importedObject->setVariable("credit_applied", 0.00);
    $importedObject->setVariable("write_off_amt", 0.00);
    $importedObject->setVariable("write_off_date", NULL);
    $importedObject->setVariable("adjustment_amt", 0.00);
    $importedObject->setVariable("inv_bal", $importedObject->getVariable("inv_total"));
    $importedObject->setVariable("paid_in_full", "0");
    $importedObject->setVariable("paid_in_full_date", "");
    $importedObject->setVariable("so_order_no", "");
    $importedObject->setVariable("so_order_date", NULL);
    $importedObject->setVariable("ship_via", "");
    $importedObject->setVariable("ship_date", $importedObject->getVariable("date"));
    $importedObject->setVariable("reference", "");
    $importedObject->setVariable("reference_2", "");
    $importedObject->setVariable("job_number", "");
    $importedObject->setVariable("job", $importedObject->getVariable("job"));
    $importedObject->setVariable("cust_po", $importedObject->getVariable("po_id"));
    $importedObject->setVariable("seller_id", "");
    $importedObject->setVariable("changed_sold_to", "0");
    $importedObject->setVariable("changed_ship_to", "0");
    $importedObject->setVariable("taxable", "1");
    $importedObject->setVariable("hold", "0");
    $importedObject->setVariable("posted", "1");
    $importedObject->setVariable("date_posted_to_ar", NULL); //DEV NOTE: check that this is right
    $importedObject->setVariable("posted_to_gl", "0");
    $importedObject->setVariable("date_posted_to_gl", "");
    $importedObject->setVariable("source", "0");
    $importedObject->setVariable("payment_date", NULL);
    $importedObject->setVariable("external_source", "");
    $importedObject->setVariable("external_ref", "");
    $importedObject->setVariable("created_by", substr($importedObject->getVariable("sf_user_id"), 0 , 3));
    $importedObject->setVariable("created_date", date("Y-m-d")); //DEV NOTE: Test this
    $importedObject->setVariable("updated_by", "");
    $importedObject->setVariable("updated_date", NULL);
    $importedObject->setVariable("e_mail_addresss", "");
    $importedObject->setVariable("so_order_rcd_id", "0");
    $importedObject->setVariable("cc_order_no", "");
    $importedObject->setVariable("cc_approved", "");
    $importedObject->setVariable("post_date", NULL);
    $importedObject->setVariable("update_ic", "0");
    $importedObject->setVariable("inv_desc", "");
    $importedObject->setVariable("updated_dt_tm", "");
    $importedObject->setVariable("client_code", "");
    $importedObject->setVariable("pymt_type_id", "");
    $importedObject->setVariable("work_order_no", "");
    $importedObject->setVariable("unused", "");
    if($importedObject->getVariable("disc_date") < date("Y-m-d"))  //DEV NOTE: Move this to the end; Also confirm that all customers are allowed a 2% discount
    {
      $importedObject->setVariable("disc_amount", $testObject->getVariable("inv_bal") * 0.02); 
    }
    else
    {
      $importedObject->setVariable("disc_amount", 0.00);
    }
      
    //AR_InvoiceLn5

    //RecNo - need additional details on this, leave blank for now
    //$invoice_id
    //$product_id
    //$importedObject->setVariable("cyma_description", $GLOBALS['$cyma_description']);
    //$importedObject->setVariable("cyma_taxable", $GLOBALS['$cyma_taxable']);
    //$total_net_tons
    //$importedObject->setVariable("cyma_price", $GLOBALS['$cyma_price']);
    $importedObject->setVariable("ext_price", $importedObject->getVariable("disc_date") * $importedObject->getVariable("total_net_tons"));
    $importedObject->setVariable("discount_percent", "0"); //DEV NOTE: Edit this. Look it up from the terms and calculate it.
    $importedObject->setVariable("tax_line_amt", "0.00"); //DEV NOTE: Edit this. Look it up from the taxable status and calculate it.
    $importedObject->setVariable("line_total", $importedObject->getVariable("ext_price") + $importedObject->getVariable("tax_line_amt"));
    $importedObject->setVariable("amt_paid", "0.00");
    $importedObject->setVariable("disc_applied", "0.00");
    $importedObject->setVariable("inv_account_id", "");
    //$importedObject->setVariable("cyma_sales_account_id", $GLOBALS['$cyma_sales_account_id']);
    $importedObject->setVariable("cogs_account_id", "");
    //$importedObject->setVariable("cyma_unit_cost", $GLOBALS['$cyma_unit_cost']);
    $importedObject->setVariable("ext_cost", $importedObject->getVariable("cyma_unit_cost") * $importedObject->getVariable("total_net_tons"));
    $importedObject->setVariable("posted_to_gl", "0"); //(assumes that Accounting manually posts to the GL)
    $importedObject->setVariable("posted_gl_rcd_id", ""); //(assumes that Accounting manually posts to the GL)
    $importedObject->setVariable("posted_gl_stamp", ""); //(assumes that Accounting manually posts to the GL)
    //$job
    $importedObject->setVariable("trans_class_1", "");
    $importedObject->setVariable("trans_class_2", "");
    $importedObject->setVariable("so_line_no", "0");
    $importedObject->setVariable("so_line_ref", "0");
    $importedObject->setVariable("cyma_unit_of_measure", $GLOBALS['$cyma_unit_of_measure']);
    $importedObject->setVariable("grant_id", "");
    $importedObject->setVariable("fund_src", "");
    $importedObject->setVariable("program", "");
    $importedObject->setVariable("activity", "");
    $importedObject->setVariable("jc_rec_no", "0");
    $importedObject->setVariable("cost_code", "");
    $importedObject->setVariable("skill_id", "");
    $importedObject->setVariable("price_code", "");
    $importedObject->setVariable("price_source", "0");
    $importedObject->setVariable("warehouse_id", "");
    //$importedObject->setVariable("cyma_unit_of_measure", $GLOBALS['$cyma_unit_of_measure']);
    //$importedObject->setVariable("created_by", substr($importedObject->getVariable("sf_user_id"), 0 , 3));
    //$importedObject->setVariable("created_date", date("Y-m-d")); //DEV NOTE: Test this
    //$importedObject->setVariable("updated_by", "");
    //$importedObject->setVariable("updated_date", NULL);
    $importedObject->setVariable("sales_code", "");
    //$importedObject->setVariable("updated_dt_tm", "");
    $importedObject->setVariable("activity_date", $date);
    //$importedObject->setVariable("unused", "");

    //**************************************************************************
    //AR_InvoiceLnTax
    
    //$invoice_id
    
    //$importedObject->setVariable("tax_id", $GLOBALS['$cyma_tax_id']);
    //$importedObject->setVariable("tax_id_taxed", $GLOBALS['$cyma_tax_state_sales']);
    //$importedObject->setVariable("tax_accrual_account_id", $GLOBALS['$tax_accrual_id']);
    //$importedObject->setVariable("tax_rate", $GLOBALS['$tax_rate']);
    $importedObject->setVariable("tax_amount", $importedObject->getVariable("tax_rate") * $importedObject->getVariable("ext_price") * $importedObject->getVariable("charge_state_tax"));
    $importedObject->setVariable("tax_amt_paid", 0.00);
    //$importedObject->setVariable("created_by", substr($importedObject->getVariable("sf_user_id"), 0 , 3));
    //$importedObject->setVariable("created_date", date("Y-m-d")); //DEV NOTE: Test this
    //$importedObject->setVariable("updated_by", "");
    //$importedObject->setVariable("updated_date", NULL);
    
    
    

    
    //Step 2: insert the new data into MSSQL
    if($debugging)
    {
      echo "The values to insert into the CYMA database are:<br />";
      echo "<strong>Table AR_Inv2:</strong><br />";
      
      echo "invoice id: " . $importedObject->getVariable("invoice_id") . "<br />";
      echo "invoice status: " . $importedObject->getVariable("invoice_status") . "<br />";
      echo "credit: " . $importedObject->getVariable("credit") . "<br />";
      echo "fin chg in: " . $importedObject->getVariable("fin_chg_in") . "<br />";
      echo "beginning bal invoice: " . $importedObject->getVariable("beginning_bal_invoice") . "<br />";
      echo "unapplied pmt: " . $importedObject->getVariable("unapplied_pmt") . "<br />";
      echo "dep with order: " . $importedObject->getVariable("dep_with_order") . "<br />";
      echo "customer id: " . $importedObject->getVariable("customer_id") . "<br />";
      echo "ship name: " . $importedObject->getVariable("cyma_ship_name") . "<br />"; //DEV NOTE: CHECK THAT THIS IS RIGHT. Maybe it should be read from a different field.
      echo "apply to invoice: " . $importedObject->getVariable("apply_to_invoice") . "<br />";
      echo "link to invoice: " . $importedObject->getVariable("link_to_invoice") . "<br />";
      echo "ar account: " . $importedObject->getVariable("ar_account") . "<br />";
      echo "address 1: " . $importedObject->getVariable("cyma_address1") . "<br />";
      echo "address 2: " . $importedObject->getVariable("cyma_address2") . "<br />";
      echo "city: " . $importedObject->getVariable("cyma_city") . "<br />";
      echo "state: " . $importedObject->getVariable("cyma_state") . "<br />";
      echo "zip: " . $importedObject->getVariable("cyma_zip") . "<br />";
      echo "country: " . $importedObject->getVariable("cyma_country") . "<br />";
      echo "ordered by: " . $importedObject->getVariable("ordered_by") . "<br />";
      echo "location id: " . $importedObject->getVariable("cyma_location_id") . "<br />";
      echo "ship name: " . $importedObject->getVariable("cyma_ship_name") . "<br />";
      echo "ship address 1: " . $importedObject->getVariable("cyma_ship_address_1") . "<br />";
      echo "ship address 2: " . $importedObject->getVariable("cyma_ship_address_2") . "<br />";
      echo "ship city: " . $importedObject->getVariable("cyma_ship_city") . "<br />";
      echo "ship state: " . $importedObject->getVariable("cyma_ship_state") . "<br />";
      echo "ship zip: " . $importedObject->getVariable("cyma_ship_zip") . "<br />";
      echo "ship country: " . $importedObject->getVariable("cyma_ship_country") . "<br />";
      echo "ship attn: " . $importedObject->getVariable("cyma_ship_attn") . "<br />";
      echo "ship phone: " . $importedObject->getVariable("cyma_ship_phone") . "<br />";
      echo "terms code: " . $importedObject->getVariable("cyma_terms_code") . "<br />";
      echo "due date: " . $importedObject->getVariable("due_date") . "<br />";
      echo "disc date: " . $importedObject->getVariable("disc_date") . "<br />";
      echo "disc amount: " . $importedObject->getVariable("disc_amount") . "<br />";
      echo "tax cat id: " . $importedObject->getVariable("tax_cat_id") . "<br />";
      echo "tax amt: " . $importedObject->getVariable("tax_amt") . "<br />";
      echo "freight gl account id: " . $importedObject->getVariable("freight_gl_account_id") . "<br />";
      echo "freight amt: " . $importedObject->getVariable("freight_amt") . "<br />";
      echo "inv total: " . $importedObject->getVariable("inv_total") . "<br />";
      echo "method of payment: " . $importedObject->getVariable("method_of_payment") . "<br />";
      echo "check no: " . $importedObject->getVariable("check_no") . "<br />";
      echo "cc exp date: " . $importedObject->getVariable("cc_exp_date") . "<br />";
      echo "bank id: " . $importedObject->getVariable("bank_id") . "<br />";
      echo "amt paid: " . $importedObject->getVariable("amt_paid") . "<br />";
      echo "disc amt: " . $importedObject->getVariable("disc_amt") . "<br />";
      echo "credit applied: " . $importedObject->getVariable("credit_applied") . "<br />";
      echo "write off amt: " . $importedObject->getVariable("write_off_amt") . "<br />";
      echo "write off date: " . $importedObject->getVariable("write_off_date") . "<br />";
      echo "adjustment amt: " . $importedObject->getVariable("adjustment_amt") . "<br />";
      echo "inv bal: " . $importedObject->getVariable("inv_bal") . "<br />";
      echo "paid in full: " . $importedObject->getVariable("paid_in_full") . "<br />";
      echo "paid in full date: " . $importedObject->getVariable("paid_in_full_date") . "<br />";
      echo "so order no: " . $importedObject->getVariable("so_order_no") . "<br />";
      echo "so order date: " . $importedObject->getVariable("so_order_date") . "<br />";
      echo "ship via: " . $importedObject->getVariable("ship_via") . "<br />";
      echo "ship date: " . $importedObject->getVariable("ship_date") . "<br />";
      echo "reference: " . $importedObject->getVariable("reference") . "<br />";
      echo "reference 2: " . $importedObject->getVariable("reference_2") . "<br />";
      echo "job number: " . $importedObject->getVariable("job_number") . "<br />";
      echo "job: " . $importedObject->getVariable("job") . "<br />";
      echo "cust po: " . $importedObject->getVariable("cust_po") . "<br />";
      echo "seller id: " . $importedObject->getVariable("seller_id") . "<br />";
      echo "changed sold to: " . $importedObject->getVariable("changed_sold_to") . "<br />";
      echo "changed ship to: " . $importedObject->getVariable("changed_ship_to") . "<br />";
      echo "taxable: " . $importedObject->getVariable("taxable") . "<br />";
      echo "hold: " . $importedObject->getVariable("hold") . "<br />";
      echo "posted: " . $importedObject->getVariable("posted") . "<br />";
      echo "date posted to ar: " . $importedObject->getVariable("date_posted_to_ar") . "<br />";
      echo "posted to gl: " . $importedObject->getVariable("posted_to_gl") . "<br />";
      echo "date posted to gl: " . $importedObject->getVariable("date_posted_to_gl") . "<br />";
      echo "source: " . $importedObject->getVariable("source") . "<br />";
      echo "payment date: " . $importedObject->getVariable("payment_date") . "<br />";
      echo "external source: " . $importedObject->getVariable("external_source") . "<br />";
      echo "external ref: " . $importedObject->getVariable("external_ref") . "<br />";
      echo "created by: " . $importedObject->getVariable("created_by") . "<br />";
      echo "created date: " . $importedObject->getVariable("created_date") . "<br />";
      echo "updated by: " . $importedObject->getVariable("updated_by") . "<br />";
      echo "updated date: " . $importedObject->getVariable("updated_date") . "<br />";
      echo "email address: " . $importedObject->getVariable("e_mail_addresss") . "<br />";
      echo "so order rcd id: " . $importedObject->getVariable("so_order_rcd_id") . "<br />";
      echo "cc order no: " . $importedObject->getVariable("cc_order_no") . "<br />";
      echo "cc approved: " . $importedObject->getVariable("cc_approved") . "<br />";
      echo "post date: " . $importedObject->getVariable("post_date") . "<br />";
      echo "update ic: " . $importedObject->getVariable("update_ic") . "<br />";
      echo "inv desc: " . $importedObject->getVariable("inv_desc") . "<br />";
      echo "updated dt tm: " . $importedObject->getVariable("updated_dt_tm") . "<br />";
      echo "client code: " . $importedObject->getVariable("client_code") . "<br />";
      echo "pymt type id: " . $importedObject->getVariable("pymt_type_id") . "<br />";
      echo "word order no: " . $importedObject->getVariable("work_order_no") . "<br />";
      echo "unused: " . $importedObject->getVariable("unused") . "<br />";
   
      //**************************************************************************
      
      echo "*****************************************<br />";
      
      echo "<strong>Table AR_InvoiceLn5:</strong><br />";
      
      echo "invoice id: " . $importedObject->getVariable("invoice_id") . "<br />";
      echo "product id: " . $importedObject->getVariable("product_id") . "<br />";
      echo "description: " . $importedObject->getVariable("cyma_description") . "<br />";
      echo "taxable: " . $importedObject->getVariable("cyma_taxable") . "<br />";
      echo "quantity: " . $importedObject->getVariable("total_net_tons") . "<br />";
      echo "price: " . $importedObject->getVariable("cyma_price") . "<br />";
      echo "ext price: " . $importedObject->getVariable("ext_price") . "<br />";
      echo "discount percent: " . $importedObject->getVariable("discount_percent") . "<br />";
      echo "tax line amt: " . $importedObject->getVariable("tax_line_amt") . "<br />";
      echo "line total: " . $importedObject->getVariable("line_total") . "<br />";
      echo "amt paid: " . $importedObject->getVariable("amt_paid") . "<br />";
      echo "disc applied: " . $importedObject->getVariable("disc_applied") . "<br />";
      echo "inv account id: " . $importedObject->getVariable("inv_account_id") . "<br />";
      echo "sales account id: " . $importedObject->getVariable("cyma_sales_account_id") . "<br />";
      echo "cogs account id: " . $importedObject->getVariable("cogs_account_id") . "<br />";
      echo "cyma unit cost: " . $importedObject->getVariable("cyma_unit_cost") . "<br />";
      echo "ext cost: " . $importedObject->getVariable("ext_cost") . "<br />";
      echo "posted to gl: " . $importedObject->getVariable("posted_to_gl") . "<br />";
      echo "posted to gl rcd id: " . $importedObject->getVariable("posted_gl_rcd_id") . "<br />";
      echo "posted gl stamp: " . $importedObject->getVariable("posted_gl_stamp") . "<br />";
      echo "job: " . $importedObject->getVariable("job") . "<br />";
      echo "trans class 1: " . $importedObject->getVariable("trans_class_1") . "<br />";
      echo "trans class 2: " . $importedObject->getVariable("trans_class_2") . "<br />";
      echo "so line no: " . $importedObject->getVariable("so_line_no") . "<br />";
      echo "so line ref: " . $importedObject->getVariable("so_line_ref") . "<br />";
      echo "grant id: " . $importedObject->getVariable("grant_id") . "<br />";
      echo "fund src: " . $importedObject->getVariable("fund_src") . "<br />";
      echo "program: " . $importedObject->getVariable("program") . "<br />";
      echo "activity: " . $importedObject->getVariable("activity") . "<br />";
      echo "jc rec no: " . $importedObject->getVariable("jc_rec_no") . "<br />";
      echo "cost code: " . $importedObject->getVariable("cost_code") . "<br />";
      echo "skill id: " . $importedObject->getVariable("skill_id") . "<br />";
      echo "price code: " . $importedObject->getVariable("price_code") . "<br />";
      echo "price source: " . $importedObject->getVariable("price_source") . "<br />";
      echo "warehouse id: " . $importedObject->getVariable("warehouse_id") . "<br />";
      echo "unit of measure: " . $importedObject->getVariable("cyma_unit_of_measure") . "<br />";
      echo "created by: " . $importedObject->getVariable("created_by") . "<br />";
      echo "created date: " . $importedObject->getVariable("created_date") . "<br />";
      echo "updated by: " . $importedObject->getVariable("updated_by") . "<br />";
      echo "updated date: " . $importedObject->getVariable("updated_date") . "<br />";
      echo "sales code: " . $importedObject->getVariable("sales_code") . "<br />";
      echo "updated dt tm: " . $importedObject->getVariable("updated_dt_tm") . "<br />";
      echo "activity date: " . $importedObject->getVariable("activity_date") . "<br />";
      echo "unused: " . $importedObject->getVariable("unused") . "<br />";
      
      echo "*****************************************<br />";
      echo "<strong>Table AR_InvoiceLnTax:</strong><br />";
      
      echo "rec no: " . $importedObject->getVariable("invoice_id") . "<br />"; 
      echo "invoice id: " . $importedObject->getVariable("invoice_id") . "<br />"; 
      echo "tax id: " . $importedObject->getVariable("tax_id") . "<br />"; 
      echo "tax_id_taxed: " . $importedObject->getVariable("tax_id_taxed") . "<br />"; 
      echo "tax_accrual_account_id: " . $importedObject->getVariable("tax_accrual_account_id") . "<br />"; 
      echo "tax_rate: " . $importedObject->getVariable("tax_rate") . "<br />"; 
      echo "tax_amount: " . $importedObject->getVariable("tax_amount") . "<br />"; 
      echo "tax_amt_paid: " . $importedObject->getVariable("tax_amt_paid") . "<br />"; 
      echo "created_by: " . $importedObject->getVariable("created_by") . "<br />"; 
      echo "created_date: " . $importedObject->getVariable("created_date") . "<br />"; 
      echo "updated_by: " . $importedObject->getVariable("updated_by") . "<br />"; 
      echo "updated_date: " . $importedObject->getVariable("updated_date") . "<br />"; 
      
    }
    
    if($queryResultMSSQL == 1)
    {
      if($debugging)
        echo "******************************************************************<br />Successfully queried CYMA-MSSQL.<br />";
      //$insertResultMSSQL = InsertMSSQL($importedObject); //DEV NOTE: add this function after permissions are added.
    }
    else
    {
      if($debugging)
        echo "******************************************************************<br />error querying CYMA-MSSQL.<br />";
      $isSuccessful = 0;
    }
    
    if($insertResultMSSQL == 1)
    {
      if($debugging)
        echo "***<br />Successfully inserted data into CYMA-MSSQL.<br />";
    }
    else
    {
      if($debugging)
        echo "***<br />Error inserting data into CYMA-MSSQL.<br />";
      $isSuccessful = 0;
    }
  }
  else
  {
    if($debugging)
      echo "***<br />Failed to connect to CYMA-MSSQL.<br />";  
    $isSuccessful = 0;
  }
  
  //Document outgoing in MySQL log
  $source_for_db = "SalesForce";
  $data_processed_for_db = $json_data;
  
  $importedObject_json = json_encode((array)$importedObject);
  
  if($debugging)
    echo "***<br />Data to insert into MySQL log:<br />" . $importedObject_json . "<br />"; //for debug
  
  //$connectionReturn = ConnectToMySQL(); //already connected from earlier MySQL connection
  if($connectionReturn == 1)
  {
    if($debugging)
      echo "***<br />Successfully connected to MySQL.<br />";
  }
    else 
  {
    if($debugging)
      echo "***<br />Failure to access MySQL: " . $connectionReturn;
    $isSuccessful = 0;
  }
  //$resultOfMySQLInsert = insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db); //direct SQL method
  $resultOfMySQLInsert = $conn->query("CALL insertLogDataAROut('$source_for_db', '$importedObject_json', '$queryResultMSSQL')"); //Stored procedure method
  if($resultOfMySQLInsert == 1)
  {
    if($debugging)
      echo "***<br />Successfully added to outbound MySQL log.<br />";
  }
  else 
  {
    if($debugging)
      echo "Failure to access MySQL log: " . $resultOfMySQLInsert . "<br />";
    $isSuccessful = 0;
  }

}
else //json data was not sent
{
  if($debugging)
    echo "API Connection failure. JSON was not received.<br />";
}

if($debugging)
    echo "***<br />";

//return output to the client
if($isSuccessful == 1)
{
  echo '{"IsSuccessful":"true"}';
}
else
{
  sendFailureMessage($debugging, "SalesForce AR"); 
    
  echo '{"IsSuccessful":"false"}';
}
//====================================================================== END PHP
?>