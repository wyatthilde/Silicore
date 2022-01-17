<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/27/2018
 * Time: 4:09 PM
 */

require_once('../../Includes/QC/gb_qcfunctions.php');

function getSievesByIdAndSite($id, $site, $currentWeights)
{

    try {

        $sql = mysqli_query(connectToMySQLQC(), "CALL sp_qc_SievesByIdAndSiteGet('" . $id . "','" . $site . "');");
            $i=0;
            $rows = array();
            while ($results = mysqli_fetch_assoc($sql)) {
                $rows[] = $results;
                $rows[$i]['current_weight'] = $currentWeights[$i];
                $i++;
            }
            return $rows;
    } catch (Exception $e) {
        return "Error connecting to database.";
    }
}

function getCurrentStartWeights($id, $site)
{
    try {
        $sql = mysqli_query(connectToMySQLQC(), "CALL sp_qc_CurrentStartWeightsGet('" . $id . "','" . $site . "');");

        $rows = array();
        if(mysqli_num_rows($sql)>0) {
            while ($results = mysqli_fetch_assoc($sql)) {
                $rows = $results['start_weights_raw'];
            }
            return decodeWeights($rows);
        }
        else{
                return decodeWeights('\'a:18:{i:40;s:1:"0";i:50;s:1:"0";i:60;s:1:"0";i:70;s:1:"0";i:80;s:1:"0";i:100;s:1:"0";i:120;s:1:"0";i:140;s:1:"0";i:200;s:1:"0";s:3:"PAN";s:1:"0";i:0;s:1:"0";i:0;s:1:"0";i:0;s:1:"0";i:0;s:1:"0";i:0;s:1:"0";i:0;s:1:"0";i:0;s:1:"0";i:0;s:1:"0";}\''); //This is a temporary solution to the larger problem of how we are storing starting sieve weights
            }

    } catch (Exception $e) {
        return "Error connecting to database.";
    }

}

$sievesObject = NULL;
$sievesString = file_get_contents('php://input');
$sievesObject = json_decode($sievesString, true);
$id = test_input($sievesObject['id']);
$site = test_input($sievesObject['site']);

if ($site == 20) // This is done because Cresson's sieves are within the Granbury sieves table.
{
    $site = 10;
}

$currentWeights = getCurrentStartWeights($id, $site);
$initialWeights = getSievesByIdAndSite($id, $site, $currentWeights);

echo json_encode($initialWeights);



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
