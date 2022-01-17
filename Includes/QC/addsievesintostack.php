<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/21/2018
 * Time: 9:01 AM
 */

require_once('/var/www/sites/silicore/Includes/QC/gb_qcfunctions.php');

function getAllSieves($description, $siteId)
    {

        $sql = mysqli_query(connectToMySQLQC(), "CALL sp_qc_SievesAllGet('" . $description . "','" . $siteId . "');");


        $rows = array();
        while ($results = mysqli_fetch_assoc($sql)) {
            $rows = $results;
        }
        $formattedResults = json_encode($rows);
        return $formattedResults;
    }
function insertSieves($siteId, $sieveStackId, $screenSize, $startWeight, $serialNo, $sortOrder, $userId)
{

    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        if($siteId == '10')
        {
            $sql = "CALL sp_gb_qc_SieveInsert('" . $sieveStackId .
                "','" . $siteId .
                "','" . $screenSize .
                "','" . $startWeight .
                "','" . $serialNo .
                "','" . $sortOrder .
                "','" . $userId . "');"; //stored procedure method


            //$returnValue = mysqli_affected_rows($mySQLConnectionLocal);
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            echo mysqli_affected_rows($mySQLConnectionLocal);
            disconnectFromMySQLQC($mySQLConnectionLocal);
            $returnValue = 1;
        }
        elseif($siteId == '50')
        {
            $sql = "CALL sp_tl_qc_SieveInsert('" . $sieveStackId .
                "','" . $siteId .
                "','" . $screenSize .
                "','" . $startWeight .
                "','" . $serialNo .
                "','" . $sortOrder .
                "','" . $userId . "');"; //stored procedure method

            //$returnValue = mysqli_affected_rows($mySQLConnectionLocal);
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            echo mysqli_affected_rows($mySQLConnectionLocal);
            disconnectFromMySQLQC($mySQLConnectionLocal);
            $returnValue = 1;
        }
        elseif($siteId == '60')
        {
            $sql = "CALL sp_wt_qc_SieveInsert('" . $sieveStackId .
                "','" . $siteId .
                "','" . $screenSize .
                "','" . $startWeight .
                "','" . $serialNo .
                "','" . $sortOrder .
                "','" . $userId . "');"; //stored procedure method


            //$returnValue = mysqli_affected_rows($mySQLConnectionLocal);
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            echo mysqli_affected_rows($mySQLConnectionLocal);
            disconnectFromMySQLQC($mySQLConnectionLocal);
            $returnValue = 1;
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

        $returnValue = 0;
    }

    return $returnValue;
}

$sieveStackObject = NULL;
$sieveStackString= file_get_contents('php://input');
$sieveStackObject = json_decode($sieveStackString, true);
$description = test_input($sieveStackObject["description"]);
$siteId = test_input($sieveStackObject["siteId"]);
$screenSize = test_input($sieveStackObject['screen']);
$serialNo = test_input($sieveStackObject['serial_no']);
$startWeight = $sieveStackObject['start_weight'];
$sortOrder = test_input($sieveStackObject['sort_order']);
$userId = $_SESSION["user_id"];

if ($startWeight === ''){$startWeight = 0.0;}
$sieveStackId = json_decode(getAllSieves($description, $siteId), true);
$sieveStackId = $sieveStackId['id'];

insertSieves($siteId, $sieveStackId, $screenSize, $startWeight, $serialNo, $sortOrder, $userId);
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}