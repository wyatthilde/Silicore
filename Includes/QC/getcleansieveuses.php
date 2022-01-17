<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/5/2018
 * Time: 1:18 AM
 */
require_once('../../Includes/QC/gb_qcfunctions.php');
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
function dbmysql()
{
    try {
        $dbc = databaseConnectionInfo();
        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        return $dbconn;

        mysqli_close($dbconn);

    } catch (Exception $e) {
        echo("Error while trying to get data" . $e);
    }
}
function getUsesSinceImplementation($stackId, $siteId, $createDate)
{

    if ($siteId == 10 || $siteId == 20 || $siteId == 30) {
        $mydbconn = dbmysql();
        $query = "CALL sp_gb_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $createDate . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            echo $uses;
        } else {
            echo $uses;
        }
    }
    if ($siteId == '50') {
        $mydbconn = dbmysql();
        $query = "CALL sp_tl_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $createDate . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            echo $uses;
        } else {
            echo $uses;
        }

    }
    if ($siteId == '60') {
        $mydbconn = dbmysql();
        $query = "CALL sp_wt_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $createDate . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            echo $uses;
        } else {
            echo $uses;
        }

    }

}
$sieveObject = NULL;
$sieveString= file_get_contents('php://input');
$sieveObject = json_decode($sieveString, true);
$stackId = test_input($sieveObject["sieve_stack_id"]);
$siteId = test_input($sieveObject["site_id"]);
$createDate = test_input($sieveObject["create_date"]);
getUsesSinceImplementation($stackId, $siteId, $createDate);
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}