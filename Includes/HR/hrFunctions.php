<?php
/* * *****************************************************************************************************************************************
 * File Name: hrFunctions.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/17/2018|nolliff|KACE:18774 - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('/var/www/configuration/db-mysql-sandbox.php');
require_once('../../Includes/Security/dbaccess.php');

function connectToMySQLQC()
{
    $errorMessage = "Page: QC functionality - connectToMySQLQC() - ";

    global $PageName;
    global $FullPath;

    try {
        $mysql_dbname = SANDBOX_DB_DBNAME001; //sandbox
        $mysql_username = SANDBOX_DB_USER;
        $mysql_pw = SANDBOX_DB_PWD;
        $mysql_hostname = SANDBOX_DB_HOST;
        $mySQLConnection = new mysqli($mysql_hostname, $mysql_username, $mysql_pw, $mysql_dbname);

        if ($mySQLConnection->connect_error) {
            echo $errorMessage . "Error connecting to the MySQL database";
        } else {
            return $mySQLConnection;
        }

    } catch
    (Exception $e) {
        echo $errorMessage . "Error connecting to the MySQL database";

        return 0;
    }
}

/*******************************************************************************
 * Function Name: disconnectFromMySQLQC()
 * Description:
 * This function will:
 * Disconnect from MySQL.
 *******************************************************************************/
function disconnectFromMySQLQC($mySQLConnection)
{
    $errorMessage = "";
    try {
        $mySQLConnection->close();
    } catch (Exception $e) {
        echo $errorMessage . "Error disconnecting to the MySQL database.";

    }
}




function insertJobTitle($site, $department, $title, $description, $userType, $userId)
{

    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database

        $sql = "CALL sp_hr_JobTitleInsert('" . $site .
            "','" . $department .
            "','" . $title .
            "','" . $description .
            "','" . $userType .
            "'," . $userId . ");"; //stored procedure method

        mysqli_query($mySQLConnectionLocal,$sql); //insert the record

        disconnectFromMySQLQC($mySQLConnectionLocal);
        $returnValue = 1;
    }
    catch (Exception $e)
    {
        $errorMessage = $errorMessage . "Error inserting a sample into MySQL.";

        if($debugging == 1)
        {
            echo $errorMessage;
            $error = $e->getMessage();
            echo $error;
        }

        $returnValue = 0;
    }

    echo $returnValue;
}

function getSites()
{
    $arrayOfSites = NULL;

    try {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        $result = $mySQLConnectionLocal->query("CALL sp_GetSites();"); //stored procedure method
        $outputCount = 0;
        while ($row = $result->fetch_assoc()) {
            $arrayOfSites[$outputCount]->vars["id"] = $row['id'];
            $arrayOfSites[$outputCount]->vars["description"] = $row['description'];
            $arrayOfSites[$outputCount]->vars["is_vista_site"] = $row['is_vista_site'];
            $arrayOfSites[$outputCount]->vars["is_qc_samples_site"] = $row['is_qc_samples_site'];
            $arrayOfSites[$outputCount]->vars["local_network"] = $row['local_network'];
            $arrayOfSites[$outputCount]->vars["sort_order"] = $row['sort_order'];
            $arrayOfSites[$outputCount]->vars["is_active"] = $row['is_active'];
            $outputCount++;
        }
        disconnectFromMySQLQC($mySQLConnectionLocal);
    } catch (Exception $e) {
        echo "Error querying MySQL for a list of sites.";
    }
    return $arrayOfSites;
}

function getDepts()
{
    $arrayOfDepartments = NULL;

    try {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database
        $result = $mySQLConnectionLocal->query("CALL sp_hr_DeptSelect();"); //stored procedure method
        $outputCount = 0;
        while ($row = $result->fetch_assoc()) {
            $arrayOfDepartments[$outputCount]->vars["id"] = $row['id'];
            $arrayOfDepartments[$outputCount]->vars["name"] = $row['name'];
            $outputCount++;
        }
        disconnectFromMySQLQC($mySQLConnectionLocal);
    } catch (Exception $e) {
        echo "Error querying MySQL for a list of departments.";
    }
    return $arrayOfDepartments;
}

function getJobTitles()
{
    $sql = mysqli_query(connectToMySQLQC(), "CALL sp_adm_JobTitlesGetAll();");
    $rows = array();
    while ($results = mysqli_fetch_assoc($sql)) {
        $rows[] = $results;
    }
    $formattedResults = json_encode($rows);

    $filename = '../../Includes/jobTitleData.json';
    $handle = fopen($filename, 'w');
    fwrite($handle, $formattedResults);
    fclose($handle);
}

function getJobTitleById($id)
{
    $sql = mysqli_query(connectToMySQLQC(), "CALL sp_adm_JobTitleByIdGet(" . $id . ");");
    $rows = array();
    while ($results = mysqli_fetch_assoc($sql)) {
        $rows[] = $results;
    }
    $formattedResults = json_encode($rows);

    $filename = '../../Includes/jobTitleData.json';
    $handle = fopen($filename, 'w');
    fwrite($handle, $formattedResults);
    fclose($handle);
}

function updateJobTitle($id, $site, $department, $title, $description, $userType, $userId, $isActive)
{

    try
    {
        $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database

        $sql = "CALL sp_hr_JobTitleUpdate('" . $id .
            "','" . $site .
            "','" . $department .
            "','" . $title .
            "','" . $description .
            "','" . $userType .
            "','" . $userId .
            "','" . $isActive . "');"; //stored procedure method

        mysqli_query($mySQLConnectionLocal,$sql); //insert the record
        $returnValue = 1;
        disconnectFromMySQLQC($mySQLConnectionLocal);

    }
    catch (Exception $e)
    {
        $errorMessage = $errorMessage . "Error inserting a sample into MySQL.";

        if($debugging == 1)
        {
            echo $errorMessage;
            $error = $e->getMessage();
            echo $error;
        }

        $returnValue = 0;
    }

    echo $returnValue;
}

//========================================================================================== END PHP
?>
