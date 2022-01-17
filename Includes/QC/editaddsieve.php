<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/21/2018
 * Time: 9:01 AM
 */

require_once('/var/www/sites/silicore/Includes/QC/gb_qcfunctions.php');

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

            mysqli_query($mySQLConnectionLocal,$sql); //insert the record
            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                $return = 0;
                $response = mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                $return = 1;
                $response = 'Success';
            }
            echo json_encode( array('return' => $return, 'response' => $response));
            disconnectFromMySQLQC($mySQLConnectionLocal);
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

            mysqli_query($mySQLConnectionLocal,$sql); //insert the record

            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                $return = 0;
                $response = mysqli_error($mySQLConnectionLocal);
            }
            else
                {
                    $return = 1;
                    $response = 'Success';
                }
            echo json_encode( array('return' => $return, 'response' => $response));
            disconnectFromMySQLQC($mySQLConnectionLocal);
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

            mysqli_query($mySQLConnectionLocal,$sql); //insert the record

            if(mysqli_affected_rows($mySQLConnectionLocal) == -1)
            {
                $return = 0;
                $response = mysqli_error($mySQLConnectionLocal);
            }
            else
            {
                $return = 1;
                $response = 'Success';
            }
            echo json_encode( array('return' => $return, 'response' => $response));
            disconnectFromMySQLQC($mySQLConnectionLocal);
        }
    }
    catch (Exception $e)
    {
        echo "Error inserting the stack into MySQL.";


        echo $returnValue = 0;
    }


}

$sieveStackObject = NULL;
$sieveStackString= file_get_contents('php://input');
$sieveStackObject = json_decode($sieveStackString, true);
$description = test_input($sieveStackObject["description"]);
$siteId = test_input($sieveStackObject["siteId"]);
$screenSize = test_input($sieveStackObject['screen']);
$serialNo = test_input($sieveStackObject['serial_no']);
$startWeight = test_input($sieveStackObject['start_weight']);
$sieveStackId = test_input($sieveStackObject['stack_id']);
$sortOrder = test_input($sieveStackObject['sort_order']);
$userId = $_SESSION['user_id'];
if ($startWeight === ''){$startWeight = 0.0;}
insertSieves($siteId, $sieveStackId, $screenSize, $startWeight, $serialNo, $sortOrder, $userId);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}