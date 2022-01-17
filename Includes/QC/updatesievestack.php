<?php

require_once('../../Includes/QC/gb_qcfunctions.php');

function UpdateSieveStack($id, $description,$site,$camsizer, $sort, $status, $userId)
{

    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        if($site == 10)
        {
            $sql = "CALL sp_gb_qc_SieveStackUpdate('" . $id . "','" . $description . "','" . $site . "','" . $camsizer  . "','" . $sort  . "','" . $status . "','" . $userId . "');"; //stored procedure method
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
        }
        elseif($site == 50)
        {
            $sql = "CALL sp_tl_qc_SieveStackUpdate('" . $id . "','" . $description . "','" . $site . "','" . $camsizer  . "','" . $sort  . "','" . $status . "','" . $userId . "');"; //stored procedure method
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
        }
        elseif($site == 60)
        {
            $sql = "CALL sp_wt_qc_SieveStackUpdate('" . $id . "','" . $description . "','" . $site . "','" . $camsizer  . "','" . $sort  . "','" . $status . "','" . $userId . "');"; //stored procedure method
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
        }
    }
    catch (Exception $e)
    {
        //echo "Error Updateing the stack into MySQL.";




    }


}

$sieveStackObject = NULL;
$sieveStackString= file_get_contents('php://input');
$sieveStackObject = json_decode($sieveStackString, true);

$id = test_input($sieveStackObject['id']);
$description = test_input($sieveStackObject['stack']);
$site = test_input($sieveStackObject['site']);
$camsizer = test_input($sieveStackObject['is_camsizer']);
$sort = test_input($sieveStackObject['sort_order']);
$status = test_input($sieveStackObject['status']);
$userId = $_SESSION['user_id'];

UpdateSieveStack($id, $description,$site,$camsizer, $sort, $status, $userId);

$updatedRecord = array("id" => $id, "site" => $site, "description" => $description,  "camsizer" => $camsizer,  "status" => $status,"sort" => $sort);
echo json_encode($updatedRecord);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

