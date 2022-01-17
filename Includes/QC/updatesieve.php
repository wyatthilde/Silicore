<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/28/2018
 * Time: 2:38 PM
 */
require_once('../../Includes/QC/gb_qcfunctions.php');

function updateSieve($id, $stackId, $siteId, $serial, $screen, $startWeight, $status, $sortOrder, $userId)
{

    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        if($siteId == 10)
        {
            $sql = "CALL sp_gb_qc_SieveUpdate('" . $id . "','" . $stackId . "','" . $siteId .  "','" . $serial .  "','" . $screen .  "','" . $startWeight .  "','" . $status .  "','" . $sortOrder . "','" . $userId . "');"; //stored procedure method
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                echo mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                echo mysqli_affected_rows($mySQLConnectionLocal);
            }
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
        elseif($siteId == 50)
        {
            $sql = "CALL sp_tl_qc_SieveUpdate('" . $id . "','" . $stackId . "','" . $siteId .  "','" . $serial .  "','" . $screen .  "','" . $startWeight .  "','" . $status . "','" . $sortOrder . "','" . $userId . "');"; //stored procedure method
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                echo mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                echo mysqli_affected_rows($mySQLConnectionLocal);
            }
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
        elseif($siteId == 60)
        {
            $sql = "CALL sp_wt_qc_SieveUpdate('" . $id . "','" . $stackId . "','" . $siteId .  "','" . $serial .  "','" . $screen .  "','" . $startWeight .  "','" . $status . "','" . $sortOrder . "','" . $userId . "');"; //stored procedure method
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                echo mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                echo mysqli_affected_rows($mySQLConnectionLocal);
            }
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
    }
    catch (Exception $e)
    {
        $errorMessage = $errorMessage . "Error inserting the stack into MySQL.";

        if($debugging == 1)
        {
            echo $errorMessage;
            $error = $e->getMessage();
            echo $error;
        }
    }
}

$sieveObject = NULL;
$sieveString= file_get_contents('php://input');
$sieveObject = json_decode($sieveString, true);

$id = test_input($sieveObject["id"]);
$stackId = test_input($sieveObject["sieve_stack_id"]);
$siteId = test_input($sieveObject["site_id"]);
$serial = test_input($sieveObject["serial_no"]);
$screen = test_input($sieveObject["screen"]);
$startWeight = test_input($sieveObject["start_weight"]);
$status = test_input($sieveObject["status"]);
$sortOrder = test_input($sieveObject["sort_order"]);
$userId = $_SESSION['user_id'];
updateSieve($id, $stackId, $siteId, $serial, $screen, $startWeight, $status, $sortOrder, $userId);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

