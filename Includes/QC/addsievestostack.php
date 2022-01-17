<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/19/2018
 * Time: 1:58 AM
 */
require_once('/var/www/sites/silicore/Includes/QC/gb_qcfunctions.php');
function insertSieves($description, $site, $camsizer)
{
    $returnValue = 0;
    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        if($site == '10')
        {
            $sql = "CALL sp_gb_qc_SieveStackInsert('" . $description .
                "','" . $site .
                "','" . $camsizer . "');"; //stored procedure method
            echo $sql;
            echo mysqli_affected_rows($mySQLConnectionLocal);
            $returnValue = mysqli_affected_rows($mySQLConnectionLocal);
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record

            disconnectFromMySQLQC($mySQLConnectionLocal);
            $returnValue = 1;
        }
        elseif($site == '50')
        {
            $sql = "CALL sp_tl_qc_SieveStackInsert('" . $description .
                "','" . $site .
                "','" . $camsizer . "');"; //stored procedure method
            echo $sql;
            echo mysqli_affected_rows($mySQLConnectionLocal);
            $returnValue = mysqli_affected_rows($mySQLConnectionLocal);
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record

            disconnectFromMySQLQC($mySQLConnectionLocal);
            $returnValue = 1;
        }
        elseif($site == '60')
        {
            $sql = "CALL sp_wt_qc_SieveStackInsert('" . $description .
                "','" . $site .
                "','" . $camsizer . "');"; //stored procedure method
            echo $sql;
            echo mysqli_affected_rows($mySQLConnectionLocal);
            $returnValue = mysqli_affected_rows($mySQLConnectionLocal);
            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            disconnectFromMySQLQC($mySQLConnectionLocal);
            return $returnValue;
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

$description = $sieveStackObject['description'];
$site = $sieveStackObject['site'];
$camsizer = $sieveStackObject['is_camsizer'];


insertSieveStack($description,$site,$camsizer);

