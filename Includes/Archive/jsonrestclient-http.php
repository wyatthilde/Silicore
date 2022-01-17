<?php

/* * *****************************************************************************
 * File Name: jsonrestclient.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Oct 5, 2016[1:54:21 PM], last updated Oct 19, 2016
 * Description: This code connects to a server and POSTs a JSON string.
 * Notes: 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

//DEV NOTE: for debug purposes
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//echo "code found at " . $_SERVER['DOCUMENT_ROOT'];

$jsonStr = '{"customer_id":"APACHE","po_id":"987654","job":"100M","date":"2016-10-16","invoice_id":"201610071503300001","sf_user_id":"mnutsch","total_net_tons":"1000.00","product_id":"100MESH","url_for_invoice":"https://www.salesforce.com/invoice.php?invoice=1234567"}';

function post_to_url($url, $data) {
  $fields = '';
  foreach ($data as $key => $value) {
    $fields .= $key . '=' . $value . '&';
  }
  rtrim($fields, '&');

  $post = curl_init();
  
  curl_setopt($post, CURLOPT_URL, $url);
  curl_setopt($post, CURLOPT_POST, count($data));
  curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($post, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($post, CURLOPT_VERBOSE, true);
  
  //may be unnecessary
  //curl_setopt($post, CURLOPT_PORT, 443);
  
  // Blindly accept the certificate
  //curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
  
  $result = curl_exec($post);

  curl_close($post);
  return $result;
}

$data = array(
  "connectionid" => "123456",
  "json_value" => $jsonStr
);

//$surl = 'https://192.168.88.10/ar/push-invoices-ar.php';
$surl = 'http://sandbox/push-invoices-ar-http.php';
echo post_to_url($surl, $data);

//====================================================================== END PHP
?>