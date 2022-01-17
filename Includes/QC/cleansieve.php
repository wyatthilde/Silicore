<?php

require_once('../../Includes/QC/gb_qcfunctions.php');

function UpdateSieveStack($id, $siteId, $userId)
{
    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        if($siteId == 10 || $siteId == 20 || $siteId == 30)
        {
            $sql = "CALL sp_gb_qc_CleanSieveStackUpdate('" . $id  . "','" . $siteId . "','" . $userId . "');"; //stored procedure method
            echo $sql;
            mysqli_query($mySQLConnectionLocal,$sql); //Update the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                echo mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                echo mysqli_affected_rows($mySQLConnectionLocal);
            }
            disconnectFromMySQLQC($mySQLConnectionLocal);
            $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
            $sql = "CALL sp_qc_CleanStackLogInsert('" . $id  . "','" . $siteId . "','" . $userId . "');"; //stored procedure method
            echo $sql;
            mysqli_query($mySQLConnectionLocal,$sql); //Update the record
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
        elseif($siteId == 50)
        {
            $sql = "CALL sp_tl_qc_CleanSieveStackUpdate('" . $id  . "','" . $siteId . "','" . $userId . "');"; //stored procedure method
            echo $sql;
            mysqli_query($mySQLConnectionLocal,$sql); //Update the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                echo mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                echo mysqli_affected_rows($mySQLConnectionLocal);
            }
            disconnectFromMySQLQC($mySQLConnectionLocal);
            $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
            $sql = "CALL sp_qc_CleanStackLogInsert('" . $id  . "','" . $siteId . "','" . $userId . "');"; //stored procedure method
            mysqli_query($mySQLConnectionLocal,$sql); //Update the record
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
        elseif($siteId == 60)
        {
            $sql = "CALL sp_wt_qc_CleanSieveStackUpdate('" . $id  . "','" . $siteId . "','" . $userId . "');"; //stored procedure method
            echo $sql;
            mysqli_query($mySQLConnectionLocal,$sql); //Update the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                echo mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                echo mysqli_affected_rows($mySQLConnectionLocal);
            }
            disconnectFromMySQLQC($mySQLConnectionLocal);
            $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
            $sql = "CALL sp_qc_CleanStackLogInsert('" . $id  . "','" . $siteId . "','" . $userId . "');"; //stored procedure method
            mysqli_query($mySQLConnectionLocal,$sql); //Update the record
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
    }
    catch (Exception $e)
    {
        echo "Error Updateing the stack into MySQL.";
    }
}

$sieveStackObject = NULL;
$sieveStackString= file_get_contents('php://input');
$sieveStackObject = json_decode($sieveStackString, true);

$id = test_input($sieveStackObject['id']);
$siteId = test_input($sieveStackObject['site']);
$userId = $_SESSION['user_id'];
UpdateSieveStack($id, $siteId, $userId);



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

