<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/19/2018
 * Time: 1:58 AM
 */
require_once('/var/www/sites/silicore/Includes/QC/gb_qcfunctions.php');

function insertSieveStack($description, $site, $camsizer, $userId)
{

    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        if($site == 10)
        {
            $sql = "CALL sp_gb_qc_SieveStackInsert('" . $description . "','" . $site . "','" . $camsizer .  "','" . $userId .  "');"; //stored procedure method
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
        elseif($site == 50)
        {
            $sql = "CALL sp_tl_qc_SieveStackInsert('" . $description . "','" . $site . "','" . $camsizer . "','" . $userId . "');"; //stored procedure method
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
        elseif($site == 60)
        {
            $sql = "CALL sp_wt_qc_SieveStackInsert('" . $description . "','" . $site . "','" . $camsizer . "','" . $userId . "');"; //stored procedure method
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

$sieveStackObject = NULL;
$sieveStackString= file_get_contents('php://input');
$sieveStackObject = json_decode($sieveStackString, true);

$description = test_input($sieveStackObject['description']);
$site = test_input($sieveStackObject['site']);
$camsizer = test_input($sieveStackObject['is_camsizer']);
$userId = $_SESSION['user_id'];


insertSieveStack($description,$site,$camsizer, $userId);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data, ENT_QUOTES);
    return $data;
}

