<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/21/2018
 * Time: 9:01 AM
 */

require_once('/var/www/sites/silicore/Includes/QC/gb_qcfunctions.php');

function sp_qc_SievesAllGet($id, $siteId)
    {
        $sql = mysqli_query(connectToMySQLQC(), "CALL sp_qc_SievesAllGet(" . $id . "','" . $siteId . "');");
        $rows = array();
        while ($results = mysqli_fetch_assoc($sql)) {
            $rows[] = $results;
        }
        $formattedResults = json_encode($rows);
        echo $formattedResults;
    }