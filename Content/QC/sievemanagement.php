<?php
/* * *****************************************************************************************************************************************
 * File Name: sievemanagement.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/20/2018|whildebrandt|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */

require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/QC/gb_qcfunctions.php');

function dbmysql()
{
    try {
        $dbc = databaseConnectionInfo();
        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        return $dbconn;

        mysqli_close($dbconn);

    } catch (Exception $e) {
        echo("Error while trying to get data" . $e);
    }
}

function getAllSieveStacks()
{
    $sieveStackArray = NULL;

    $mydbconn = dbmysql();
    $query = "CALL sp_qc_SievesByIsActiveGet";
    $results = $mydbconn->query($query);

    $outputCount = 0;
    while ($row = mysqli_fetch_array($results)) {
        $sieveStackArray[$outputCount]->vars["id"] = $row['id'];
        $sieveStackArray[$outputCount]->vars["description"] = $row['description'];
        $sieveStackArray[$outputCount]->vars["site"] = $row["main_site_id"];
        $sieveStackArray[$outputCount]->vars["last_cleaned"] = $row['last_cleaned'];
        $sieveStackArray[$outputCount]->vars["last_cleaned_by"] = $row['last_cleaned_by'];
        $sieveStackArray[$outputCount]->vars["sort_order"] = $row['sort_order'];
        $sieveStackArray[$outputCount]->vars["is_active"] = $row['is_active'];
        $sieveStackArray[$outputCount]->vars["is_camsizer"] = $row['is_camsizer'];
        $sieveStackArray[$outputCount]->vars["create_date"] = $row['create_date'];
        $sieveStackArray[$outputCount]->vars["create_user"] = $row['create_user'];
        $sieveStackArray[$outputCount]->vars["modify_date"] = $row['modify_date'];
        $sieveStackArray[$outputCount]->vars["modify_user"] = $row['modify_user'];
        $outputCount++;
    }
    return $sieveStackArray;
}

function getUses($stackId, $siteId)
{

    if ($siteId == 10 || $siteId == 20 || $siteId == 30) {
        $mydbconn = dbmysql();
        $query = "CALL sp_gb_qc_UsesGet('" . $stackId . "');";

        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            return $uses;
        } else {
            return $uses;
        }

    }
    if ($siteId == '50') {
        $mydbconn = dbmysql();
        $query = "CALL sp_tl_qc_UsesGet('" . $stackId . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            return $uses;
        } else {
            return $uses;
        }

    }
    if ($siteId == '60') {
        $mydbconn = dbmysql();
        $query = "CALL sp_wt_qc_UsesGet('" . $stackId . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            return $uses;
        } else {
            return $uses;
        }

    }

}

function getUsesSinceLastCleaned($stackId, $siteId, $lastCleanedDate)
{

    if ($siteId == 10 || $siteId == 20 || $siteId == 30) {
        $mydbconn = dbmysql();
        if ($lastCleanedDate == NULL) {
            $lastCleanedDate = date("Y-m-d H:i:s"); //if the date given from the db is null then set last cleaned to now
            $query = "CALL sp_gb_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $lastCleanedDate . "');";
        } else {
            $query = "CALL sp_gb_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $lastCleanedDate . "');";
        }


        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            return $uses;
        } else {
            return $uses;
        }

    }
    if ($siteId == '50') {
        $mydbconn = dbmysql();
        $query = "CALL sp_tl_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $lastCleanedDate . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            return $uses;
        } else {
            return $uses;
        }

    }
    if ($siteId == '60') {
        $mydbconn = dbmysql();
        $query = "CALL sp_wt_qc_UsesSinceLastCleanedGet('" . $stackId . "','" . $lastCleanedDate . "');";
        $results = $mydbconn->query($query);
        $uses = mysqli_num_rows($results);
        if ($uses == NULL) {
            $uses = 0;
            return $uses;
        } else {
            return $uses;
        }

    }

}

function getAllSieveStacksByIdAndSite($sieveId, $siteId)
{
    $sieveStackArray = NULL;
    $mydbconn = dbmysql();
    $query = "CALL sp_qc_SievesAllGet('" . $sieveId . "','" . $siteId . "');";
    $results = $mydbconn->query($query);
    $outputCount = 0;
    while ($row = mysqli_fetch_array($results)) {

        $sieveStackArray[$outputCount]->vars["description"] = $row['description'];
        $sieveStackArray[$outputCount]->vars["main_site_id"] = $row['main_site_id'];
        $sieveStackArray[$outputCount]->vars["site"] = $row['site'];
        $sieveStackArray[$outputCount]->vars["last_cleaned_by_id"] = $row['last_cleaned_by_id'];
        $sieveStackArray[$outputCount]->vars["last_cleaned_by"] = $row['last_cleaned_by'];
        $sieveStackArray[$outputCount]->vars["sort_order"] = $row['sort_order'];
        $sieveStackArray[$outputCount]->vars["edit_index"] = $outputCount;
        $outputCount++;
    }
    return $sieveStackArray;
}

function hasPermission($permissionLevel) {
    $permissionGB = 0;
    $permissionTL = 0;
    $permissionWT = 0;
    if (isset($userPermissionsArray['vista']['granbury']['qc'])) {
        $permissionGB = $userPermissionsArray['vista']['granbury']['qc'] = 0;
    }
    if (isset($userPermissionsArray['vista']['tolar']['qc'])) {
        $permissionTL = $userPermissionsArray['vista']['tolar']['qc'] = 0;
    }
    if (isset($userPermissionsArray['vista']['west_texas']['qc'])) {
        $permissionWT = $userPermissionsArray['vista']['west_texas']['qc'] = 0;
    }
    return $permissionGB > $permissionLevel || $permissionTL > $permissionLevel || $permissionWT > $permissionLevel;
}

function getCleanLog()
{
    $sieveStackArray = NULL;
    $mydbconn = dbmysql();
    $query = "CALL sp_qc_CleanLogGet";
    $results = $mydbconn->query($query);
    $outputCount = 0;
    while ($row = mysqli_fetch_array($results)) {
        $sieveStackArray[$outputCount]->vars["id"] = $row['id'];
        $sieveStackArray[$outputCount]->vars["sieve_stack_id"] = $row['sieve_stack_id'];
        $sieveStackArray[$outputCount]->vars["stack_name"] = $row['stack_name'];
        $sieveStackArray[$outputCount]->vars["site_id"] = $row['site_id'];
        $sieveStackArray[$outputCount]->vars["site_name"] = $row['site_name'];
        $sieveStackArray[$outputCount]->vars["timestamp"] = $row['timestamp'];
        $sieveStackArray[$outputCount]->vars["user_id"] = $row['user_id'];
        $sieveStackArray[$outputCount]->vars["name"] = $row['name'];
        $outputCount++;
    }
    return $sieveStackArray;
}

$sieveStacksObject = getAllSieveStacks();


?>

<!--<editor-fold desc="Header-resources">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css" defer="defer"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" defer="defer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" defer="defer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js" defer="defer"></script>
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js" defer="defer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js" defer="defer"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/custom-data-source/dom-text.js" defer="defer"></script>
<style>
    .scroll {
        max-height: 350px;
        overflow-y: auto;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
    .modal-content {
        width: 100% !important;
        max-width: 1080px !important;
    }
</style>
<!--</editor-fold>-->

<div class="container-fluid w-75" id="display-container">
    <div class="container-fluid bg-light" id="overlay" style="position:fixed; top:56px; left:250px;bottom:0;right:0;z-index:9999;"></div>
    <ul class="nav nav-tabs nav-justified" id="sieve-nav-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active nowrap" data-toggle="tab" id="view-sieve-tab" href="#nav-view-sieves">Manage</a>
        </li>
        <?php
        if($userPermissionsArray['vista']['granbury']['qc'] < 4)
        {

        }
        else
            {
                echo ('<li class="nav-item"><a class="nav-link  nowrap" data-toggle="tab" id="add-sieve-tab" href="#nav-add-sieves">Add</a></li>');

            }
        ?>
    </ul><!--nav-tabs-->
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade " id="nav-add-sieves" role="tabpanel">
            <!--<div class="card-group" id="card-group">-->
            <div id="add-sieve-card" class="card mb-1">
                <form id="add-sieve-stack-form" action="" method="">
                    <div class="card-header">
                        <div id="success-message" class="alert alert-success"></div>
                        <div id="error-message" class="alert alert-danger"></div>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-xl-12">
                                <label for="stack-name-input">Stack Name:</label>
                                <input autocomplete="off" type="text" class="form-control" id="stack-name-input">
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="camsizer-input">Camsizer:</label>
                                <select class="form-control" id="camsizer-input">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="site-select">Site:</label>
                                <select class="form-control" id="site-select">
                                    <?php
                                    $siteObjectArray = NULL;
                                    $siteObjectArray = getSites();
                                    foreach ($siteObjectArray as $siteObjectItem) {
                                        if ($siteObjectItem->vars['id'] == 10 || $siteObjectItem->vars['id'] == 50 || $siteObjectItem->vars['id'] == 60) {
                                            echo '<option value="' . $siteObjectItem->vars['id'] . '" >' . $siteObjectItem->vars['description'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white" id="sieve-stack-card-footer">
                        <button id="sieve-stack-add-btn" class="btn btn-vprop-green center-block float-right" onclick="insertSieveStack()" type="button">Add Sieve Stack</button>
                    </div>
                </form>
            </div><!--add-sieve-stack-card-->
            <div id="add-screen-card" class="card " style="display:none;">
                <div class="card-header vprop-blue-light" id="sieve-counter">
                </div>
                <form action="" method="" novalidate="novalidate" id="add-sieves-form">
                    <div id="sieve-content" class="scroll"></div>
                </form>
                <div class="card-footer bg-white">
                    <div class="input-group" id="number-of-screens-input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"># of sieves:</span>
                        </div>
                        <input autocomplete="off" type="number" class="form-control" id="number-of-screens" maxlength="30" value="10">
                        <div class="input-group-append">
                            <button class="btn btn-vprop-blue" type="button" id="sieve-screen-add-btn">Add Sieves</button>
                        </div>
                    </div>
                    <button class="btn btn-vprop-blue" type="button" id="sieve-screen-add-btn-next">Add Sieves</button>
                    <button class="btn btn-vprop-green center-block float-right" type="button" id="sieve-screen-submit-btn">Submit</button>
                </div><!--card-footer-->
            </div><!--add-sieve-card-body-->
            <!--</div>Card-group-->
        </div><!--add-stacks-tab-pane-->
        <div class="tab-pane fade show active" id="nav-view-sieves" role="tabpanel">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body" id="card-body">
                    <div id="table-wrapper" class="table-responsive-lg">

                            <?php
                            if(hasPermission(4))
                            {
                                echo ('
                            <table id="allSievesTable" class="table table-lg table-bordered nowrap">
                            <thead style="background-color:#4C7AD0; color:white;">
                            <tr>
                                <th>ID</th>
                                <th>Site</th>
                                <th>Stack Name</th>
                                <th>Camsizer</th>
                                <th>Overall Uses</th>
                                <th>Uses Since Wash</th>
                                <th>Last Washed Date</th>
                                <th>Last Wash By</th>
                                <th>Status</th>
                                <th>Started Use</th>
                                <th>Started By</th>
                                <th>Last Update</th>
                                <th>Updated By</th>
                                <th>Sort Order</th>
                                <th style="display:none;">Edit</th>
                                <th>Clean</th>
                                <th style="display:none;">Retire</th>
                            </tr>
                            </thead>
                            <tbody id="all-sieves-table-body" style="display:none;">');

                                foreach ($sieveStacksObject AS $sieveStacks) {
                                    if ($sieveStacks->vars["is_active"] == '1') {
                                        $status = 'Active';
                                    } elseif ($sieveStacks->vars["is_active"] == '0') {
                                        $status = 'Retired';
                                    }
                                    if ($sieveStacks->vars["is_camsizer"] == '1') {
                                        $camsizer = 'Yes';
                                    } elseif ($sieveStacks->vars["is_camsizer"] == '0') {
                                        $camsizer = 'No';
                                    }
                                    $siteId = $sieveStacks->vars["site"];
                                    if ($siteId == 10 || $siteId == 20 || $siteId == 30) {
                                        $site = 'Granbury';
                                    } elseif ($siteId == 50) {
                                        $site = 'Tolar';
                                    } elseif ($siteId == 60) {
                                        $site = 'West Texas';
                                    } else {
                                        $site = 'Unknown';
                                    }
                                    $overallUses = getUses($sieveStacks->vars["id"], $sieveStacks->vars["site"]);
                                    $usesSinceLastCleaned = getUsesSinceLastCleaned($sieveStacks->vars["id"], $sieveStacks->vars["site"], $sieveStacks->vars["last_cleaned"]);
                                    $sieveStackArray = array(
                                        'id' => $sieveStacks->vars["id"],
                                        'site' => $sieveStacks->vars["site"],
                                        'description' => $sieveStacks->vars["description"],
                                        'camsizer' => $sieveStacks->vars["is_camsizer"],
                                        'last_cleaned' => $sieveStacks->vars["last_cleaned"],
                                        'status' => $sieveStacks->vars["is_active"],
                                        'sort_order' => $sieveStacks->vars["sort_order"]
                                    );
                                    echo '<tr>'
                                        . '<td>' . $sieveStacks->vars["id"] . '</td>'
                                        . '<td>' . $site . '</td>'
                                        . '<td>' . $sieveStacks->vars["description"] . '</td>'
                                        . '<td>' . $camsizer . '</td>'
                                        . '<td>' . $overallUses . '</td>'
                                        . '<td>' . $usesSinceLastCleaned . '</td>'
                                        . '<td>' . $sieveStacks->vars['last_cleaned'] . '</td>'
                                        . '<td>' . $sieveStacks->vars['last_cleaned_by'] . '</td>'
                                        . '<td>' . $status . '</td>'
                                        . '<td>' . $sieveStacks->vars["create_date"] . '</td>'
                                        . '<td>' . $sieveStacks->vars["create_user"] . '</td>'
                                        . '<td>' . $sieveStacks->vars["modify_date"] . '</td>'
                                        . '<td>' . $sieveStacks->vars["modify_user"] . '</td>'
                                        . '<td>' . $sieveStacks->vars["sort_order"] . '</td>'
                                        . '<td style="display:none;"></td>
<td><a href="#"><button class="btn btn-light" id="clean-btn" value=\'' . json_encode($sieveStackArray) . '\' onclick="cleanSieveStack.call(this)" data-toggle="tooltip" data-placement="top" title="Clean Sieve Stack"><i class="fas fa-broom text-primary"></i></button></a></td>
<td style="display:none;"></td>'
                                        . '</tr>';
                                }

                            }
                            else{
                                echo ('
                            <table id="allSievesTable" class="table table-lg table-bordered nowrap">
                            <thead class="th-vprop-blue-medium">
                            <tr>
                                <th>ID</th>
                                <th>Site</th>
                                <th>Stack Name</th>
                                <th>Camsizer</th>
                                <th>Overall Uses</th>
                                <th>Uses Since Wash</th>
                                <th>Last Washed Date</th>
                                <th>Last Wash By</th>
                                <th>Status</th>
                                <th>Started Use</th>
                                <th>Started By</th>
                                <th>Last Update</th>
                                <th>Updated By</th>
                                <th>Sort Order</th>
                                <th>Edit</th>
                                <th>Clean</th>
                                <th>Retire</th>
                            </tr>
                            </thead>
                            <tbody id="all-sieves-table-body" style="display:none;">');
                            foreach ($sieveStacksObject AS $sieveStacks) {

                                if ($sieveStacks->vars["is_active"] == '1') {
                                    $status = 'Active';
                                    $disabled = null;
                                } elseif ($sieveStacks->vars["is_active"] == '0') {
                                    $status = 'Retired';
                                    $disabled = 'disabled';
                                }
                                if ($sieveStacks->vars["is_camsizer"] == '1') {
                                    $camsizer = 'Yes';
                                } elseif ($sieveStacks->vars["is_camsizer"] == '0') {
                                    $camsizer = 'No';
                                }
                                $siteId = $sieveStacks->vars["site"];
                                if ($siteId == 10 || $siteId == 20 || $siteId == 30) {
                                    $site = 'Granbury';
                                } elseif ($siteId == 50) {
                                    $site = 'Tolar';
                                } elseif ($siteId == 60) {
                                    $site = 'West Texas';
                                } else {
                                    $site = 'Unknown';
                                }
                                $overallUses = getUses($sieveStacks->vars["id"], $sieveStacks->vars["site"]);
                                $usesSinceLastCleaned = getUsesSinceLastCleaned($sieveStacks->vars["id"], $sieveStacks->vars["site"], $sieveStacks->vars["last_cleaned"]);
                                $sieveStackArray = array(
                                    'id' => $sieveStacks->vars["id"],
                                    'site' => $sieveStacks->vars["site"],
                                    'description' => $sieveStacks->vars["description"],
                                    'camsizer' => $sieveStacks->vars["is_camsizer"],
                                    'last_cleaned' => $sieveStacks->vars["last_cleaned"],
                                    'status' => $sieveStacks->vars["is_active"],
                                    'sort_order' => $sieveStacks->vars["sort_order"]
                                );
                                echo '<tr>'
                                    . '<td>' . $sieveStacks->vars["id"] . '</td>'
                                    . '<td>' . $site . '</td>'
                                    . '<td>' . $sieveStacks->vars["description"] . '</td>'
                                    . '<td>' . $camsizer . '</td>'
                                    . '<td>' . $overallUses . '</td>'
                                    . '<td>' . $usesSinceLastCleaned . '</td>'
                                    . '<td>' . $sieveStacks->vars['last_cleaned'] . '</td>'
                                    . '<td>' . $sieveStacks->vars['last_cleaned_by'] . '</td>'
                                    . '<td>' . $status . '</td>'
                                    . '<td>' . $sieveStacks->vars["create_date"] . '</td>'
                                    . '<td>' . $sieveStacks->vars["create_user"] . '</td>'
                                    . '<td>' . $sieveStacks->vars["modify_date"] . '</td>'
                                    . '<td>' . $sieveStacks->vars["modify_user"] . '</td>'
                                    . '<td>' . $sieveStacks->vars["sort_order"] . '</td>'
                                    . '<td><a href="#"><button class="btn btn-light" id="edit-btn" value=\'' . json_encode($sieveStackArray) . '\' onclick="editSieveStack.call(this)" data-toggle="tooltip" data-placement="top" title="Edit Sieve Stack"><i class="fas fa-edit text-success"></i></button></a></td>
<td><a href="#"><button class="btn btn-light" id="clean-btn" value=\'' . json_encode($sieveStackArray) . '\' onclick="cleanSieveStack.call(this)" data-toggle="tooltip" data-placement="top" title="Clean Sieve Stack"><i class="fas fa-broom text-primary"></i></button></a></td>
<td><a href="#"><span title="Retire Sieve Stack"><button class="btn btn-light" id="retire-btn" value=\'' . json_encode($sieveStackArray) . '\' 
onclick="retireSieveStack.call(this)" data-toggle="tooltip" data-placement="top" title="Retire Sieve Stack" '. $disabled .'><i class="fas fa-ban text-danger"></i></button></a></td>'
                                    . '</tr>';
                            }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="edit-sieve-content" class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-vprop-blue float-right" id="sieves-edit-button">Edit Sieves</button>
                        </div>
                        <div class="card-body">
                            <div class="form-group col-xl-12">
                                <label for="id">ID:</label>
                                <input autocomplete="off" type="text" class="form-control" id="edit-id" disabled>
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="edit-site-id">Site:</label>
                                <select class="form-control" id="edit-site-id" disabled>
                                    <?php
                                    $siteObjectArray = NULL;
                                    $siteObjectArray = getSites();
                                    foreach ($siteObjectArray as $siteObjectItem) {
                                        if ($siteObjectItem->vars['id'] == 10 || $siteObjectItem->vars['id'] == 50 || $siteObjectItem->vars['id'] == 60 || $siteObjectItem->vars['id'] == 20) {
                                            echo '<option value="' . $siteObjectItem->vars['id'] . '" >' . $siteObjectItem->vars['description'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="edit-stack-name">Stack Name:</label>
                                <input autocomplete="off" type="text" class="form-control" id="edit-stack-name">
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="edit-camsizer">Camsizer:</label>
                                <select class="form-control" id="edit-camsizer">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="edit-sort-order">Sort Order:</label>
                                <input autocomplete="off" type="number" class="form-control" id="edit-sort-order">
                            </div>
                            <div class="form-group col-xl-12">
                                <label for="edit-status">Status:</label>
                                <select class="form-control" id="edit-status">
                                    <option value="1">Active</option>
                                    <option value="0">Retired</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary float-left" id="back-button">Cancel</button>
                            <button type="button" class="btn btn-vprop-green float-right" id="sieve-stack-edit-submit-button">Submit</button>
                        </div>
                    </div>
                    <div id="edit-sieves-in-stack-content" class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-secondary float-left" id="sieve-content-back-button"><span><i class="fas fa-arrow-left"></i></span></button>
                            <button type="button" class="btn btn-vprop-blue float-right" id="toggle-retired-sieves-btn">Retired Sieves</button>
                        </div>
                        <div class="card-body" id="sieve-edit-card-body">
                            <div class="container-fluid pr-0 pl-0" id="sieves-content-container">
                                <input autocomplete="off" type="hidden" id="stack-id" value="">
                                <input autocomplete="off" type="hidden" id="site-id" value="">
                                <div class="table-responsive-xl">
                                    <table id="sieves-in-stack-table" class="table table-xl table-bordered nowrap">
                                        <thead class="th-vprop-blue-medium">
                                        <tr>
                                            <th>Serial</th>
                                            <th>Screen</th>
                                            <th>Initial (g)</th>
                                            <th>Current (g)</th>
                                            <th>Δ (g)</th>
                                            <th>Created</th>
                                            <th>Uses</th>
                                            <th>Edited</th>
                                            <th>Order</th>
                                            <th>Update</th>
                                            <th>Retire</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sieves-table-body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="sieve-edit-card-footer" class="card-footer">
                            <div class="form-row">
                                <div class="form-group col">
                                    <button type="button" class="btn btn-primary btn-block" id="edit-add-sieve">Add Sieve +</button>
                                </div>
                            </div>
                        </div>
                    </div><!--responsive-table-wrapper-->
                </div><!--view-sieves-card-body-->
            </div><!--manage-sieves-card-->
        </div> <!--view-sieves-tab-pane-->
    </div> <!--tab-content-->
</div><!--fluid-container-->

<div class="modal" id="wash-log-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wash Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
        <div id="wash-log-content" class="table-responsive-xl">
            <table id="wash-log-table" class="table table-bordered table-hover table-xl nowrap">
                <thead class="th-vprop-blue-medium">
                <tr>
                    <th>Site</th>
                    <th>Stack</th>
                    <th>Timestamp</th>
                    <th>User</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cleanLogObject = NULL;
                $cleanLogObject = getCleanLog();
                foreach($cleanLogObject as $cleanLogItem)
                {
                    echo '<tr>';
                    echo '<td>' . $cleanLogItem->vars["site_name"] . '</td>';
                    echo '<td>' . $cleanLogItem->vars["stack_name"] . '</td>';
                    echo '<td>' . $cleanLogItem->vars["timestamp"] . '</td>';
                    echo '<td>' . $cleanLogItem->vars["name"] . '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
            </div>
        </div>
    </div>
</div>



<script>

   /* $("nav .dropdown").each(function (index, el) {
        $(el).on("click", function () {
            $(el).find(".dropdown-toggle").dropdown('toggle');
        });
    });*/
    $(function () {
        var count = 0;
        $('#wash-log-footer').hide();
        var washLogTable = $('#wash-log-table').DataTable({
            <?php
            if(hasPermission(4))
            {
                echo ('dom: "rt",');

            }
            else
            {
                echo ('dom: "<\'row\'<\'col-xl-6\'B><\'col-xl-6\'f>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",');
            }
            ?>
            scrollY: "300px",
            scrollX: true,
            autoWidth: false,
            paging: true,
            lengthChange: false,
            scrollCollapse: true,
            entries: false,
            order: [
                2,
                'desc'
            ],
            <?php
            if($userPermissionsArray['vista']['granbury']['qc'] < 4) {

            }
            else
            {
                echo ('buttons:[{extend: \'excel\', text: \'Export\', className: \'btn-vprop-green sieves-button-excel\', title: \'Wash Log Export\'}]');
            }
            ?>
        });
        var allSievesTable = $('#allSievesTable').DataTable({
            <?php
            if(hasPermission(4))
            {
                echo ('dom: "ftrip",');

            }
            else
            {
                echo ('dom: "<\'row\'<\'col-xl-8\'B><\'col-xl-4\'f>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",');
            }
            ?>

            scrollY: "600px",
            scrollX: true,
            paging: true,
            lengthChange: false,
            scrollCollapse: true,
            entries: true,
            pageLength: 50,
            columnDefs: [{sortable: false, targets: [14, 15, 16]}, {visible: false, targets: [4, 6, 7, 8, 9, 10, 11, 12, 13]}
            ],
            order: [
                0,
                'desc'
            ],
            <?php
            if($userPermissionsArray['vista']['granbury']['qc'] < 4) {

            }
            else
            {
                echo ('buttons:[{ extend:\'colvis\', text:\'Columns\', className: \'btn-basic\'}, {text:\'Wash Log\', className:\'btn-vprop-blue-light\', action: function(){$("#wash-log-modal").modal(); washLogTable.columns.adjust();}}, {extend: \'excel\', text: \'Export\', className: \'btn-vprop-green sieves-button-excel\', title: \'Sieve Stack Export\'}],');
            }
            ?>
            initComplete: function() {
                $('#allSievesTable').css('width', '100%');
            }
        });

        $('#toggle-retired-sieves-btn').on('click', function() {
            $('.retired-sieve').toggle();
            $('#sieves-in-stack-table').DataTable().columns.adjust();
        });

        $('#edit-sieves-in-stack-content').hide();

        $('#sieve-stack-edit-submit-button').on('click', function (event) {
            var formData = {};
            formData["id"] = $('#edit-id').val();
            formData["site"] = $('#edit-site-id').val();
            formData["stack"] = $('#edit-stack-name').val();
            formData["is_camsizer"] = $('#edit-camsizer').val();
            formData["sort_order"] = $('#edit-sort-order').val();
            formData["status"] = $('#edit-status').val();
            $.ajax
            ({
                dataType: "text",
                type: 'POST',
                url: '../../Includes/QC/updatesievestack.php',
                data: JSON.stringify(formData),
                success: function (data) {

                    $("#success-message").show().text('Stack successfully added.');
                    $('#edit-sieve-content').hide();
                    $('#table-wrapper').show();

                    location.reload();


                },
                error: function () {

                    alert(response);
                    location.reload();
                }
            });

        });
        $('#edit-sieve-content').hide();
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        $('#overlay').hide();

        $('.dt-buttons').removeClass('btn-group');

        $('.sieves-button-excel').removeClass('btn-secondary');
        $('.btn-vprop-blue-light').removeClass('btn-secondary');
        $('.buttons-colvis').removeClass('btn-secondary');
        $('#all-sieves-table-body').show();

        allSievesTable.columns.adjust().draw();

        $('#sieve-screen-submit-btn').hide();

        $('#success-message').hide();

        $('#error-message').hide();

        $('#sieve-counter').hide();

        $('#add-sieves-form').hide();

        $('#sieve-screen-add-btn-next').hide();

        $('#sieve-stack-add-btn').click(function () {
            $('#sieve-stack-add-btn').prop("disabled", true);
            $('#camsizer-input').prop("disabled", true);
            $('#stack-name-input').prop("disabled", true);
            $('#site-select').prop("disabled", true);
            //<editor-fold desc="var newEditCol">
            var newEditCol = $('<ul class="list-group list-group-flush" id="add-lg-' + count + '"><li class="list-group-item bordert-top-0"><div id="screen-form-row' + count + '" class="form-row"><div id="screen-col' + count + '" class="form-group col-xl-12"><label id="screen-name-label' + count + '" for="screenAdd">Screen:</label><input autocomplete="off"  id="screen-name-input' + count + '" type="text" class="form-control" autocomplete="off"></div><div class="form-group col-xl-12" id="serial-col' + count +
                '"><label for="serialAddNumber" id="serial-label' + count + '">Serial:</label><input autocomplete="off"  type="text" class="form-control" id="serial-input' + count + '" autocomplete="off"></div><div id="weight-col' + count + '" class="form-group col-xl-12"><label id="start-weight-label' + count + '" for="start-weight-input">Start Weight:</label><input autocomplete="off"  id="start-weight-input' + count + '" type="number" class="form-control" autocomplete="off"></div></div></li></ul>');
            //</editor-fold>
            count++;
            //$('#sieve-counter').show().text('Number of sieves in stack: 1');
        });

        $('#sieve-screen-add-btn-next').click(function () {
            $('#number-of-screens-input-group').hide();
            $(this).show().text('Add Another Sieve');

            $('#sieve-screen-submit-btn').show();
            //<editor-fold desc="var newEditCol">
            var newEditCol = $('<ul class="list-group list-group-flush" id="add-lg-' + count + '"><li class="list-group-item border-top-0"><div id="screen-form-row' + count + '" ' + 'class="form-row"><div class="form-group col-sm-auto"><span class="badge th-vprop-blue-medium">' + count + '</span></div><div ' +
                'id="screen-col' + count + '" class="form-group col-xl-12"><label id="screen-name-label' + count + '" for="screenAdd">Screen:</label><input autocomplete="off"  id="screen-name-input' + count + '" type="text" class="form-control"></div><div class="form-group col-xl-12" id="serial-col' + count + '"><label for="serialAddNumber" id="serial-label' + count + '">Serial:</label><input autocomplete="off"  type="text" class="form-control" id="serial-input' + count + '"></div><div id="weight-col' + count + '" ' +
                'class="form-group col-xl-12"><label id="start-weight-label' + count + '" for="start-weight-input">Start Weight:</label><input autocomplete="off"  id="start-weight-input' + count + '" type="number" class="form-control"></div></div></li></ul>');
            //</editor-fold>
            //<editor-fold desc="var checkRow">
            var checkRow = $('<div class="form-group col-sm-auto" id="check-row-div' + (count) + '"><button type="button" class="btn btn-light" id="check-screen-btn' + (count) + '" value="' + (count) + '" onclick="checkRow.call' +
                '(this)' +
                '"><span class="fas ' +
                'fa-check" ' +
                'style="color:green;" ></span></button></div>');
            //</editor-fold>
            //<editor-fold desc="var remRow">
            var remRow = $('<div class="form-group col-sm-auto"  id="rem-row-div' + (count) + '"><button type="button" class="btn btn-light" id="rem-screen-btn' + (count) + '" value="' + (count) + '" onclick="remRow.call(this)"><span ' +
                'class="far ' +
                'fa-trash-alt" ' +
                'style="color:red;' +
                '"></span></button></div>');
            //</editor-fold>
            $('#sieve-content').append(newEditCol);
            $('#screen-form-row' + count).append(checkRow).append(remRow);
            count++;


        });

        $('#sieve-screen-add-btn').click(function () {
            var screens = $('#number-of-screens').val();
            if(screens > 30){
                $('#number-of-screens').addClass('is-invalid');
                $.alert({
                   title: 'Error',
                   content: 'Cannot have more than 30 sieves in stack.',
                   type: 'red'
                });
            }else {
                $('#number-of-screens').removeClass('is-invalid').addClass('is-valid');
                $('#number-of-screens-input-group').hide();
                $('#sieve-screen-add-btn-next').show().text('Add Another Sieve');
                $("html, body").animate({scrollTop: $(document).height()}, "slow");
                $(this).text('Add Another Sieve');
                //$('#sieve-counter').show();
                $('#sieve-screen-submit-btn').show();
                //<editor-fold desc="var editCol">
                var editCol = $('<div class="form-group col-sm-2" id="edit-screen-div' + (count - 1) + '"><button type="button" class="btn btn-light mt-1 edit-btn" id="edit-screen-btn' + (count - 1) +
                    '" value="' + (count - 1) + '" onclick="editRow.call(this)"><span class="far fa-edit" ' +
                    'style="color:green;' +
                    '"></span></button></div>');
                var remCol = $('<div class="form-group col-sm-2"  id="rem-screen-div' + (count - 1) + '"><button type="button" class="btn btn-light mt-1 rem-btn" id="rem-screen-btn' + (count - 1) + '" value="' +
                    (count - 1) + '" onclick="remRow.call(this)"><span class="far fa-trash-alt" ' +
                    'style="color:red;' +
                    '"></span></button></div>');
                //</editor-fold>
                if (screens > 0) {
                    for (var i = 0; i < screens; i++) {
                        //<editor-fold desc="var newEditCol">
                        var newEditCol = $('<ul class="list-group list-group-flush" id="add-lg-' + count + '"><li class="list-group-item border-top-0"><div id="screen-form-row' + count + '" ' + 'class="form-row"><div class="form-group col-sm-auto"><span class="badge th-vprop-blue-medium">' + (i + 1) + '</span></div><div ' +
                            'id="screen-col' + count + '" class="form-group col-xl-12"><label id="screen-name-label' + count + '" for="screenAdd">Screen:</label><input autocomplete="off"  id="screen-name-input' + count + '" type="text" class="form-control"></div><div class="form-group col-xl-12" id="serial-col' + count + '"><label for="serialAddNumber" id="serial-label' + count + '">Serial:</label><input autocomplete="off"  type="text" class="form-control" id="serial-input' + count + '"></div><div id="weight-col' + count + '" ' +
                            'class="form-group col-xl-12"><label id="start-weight-label' + count + '" for="start-weight-input">Start Weight:</label><input autocomplete="off"  id="start-weight-input' + count + '" type="number" class="form-control"></div></div></li></ul>');
                        //</editor-fold>
                        //<editor-fold desc="var checkRow">
                        var checkRow = $('<div class="form-group col-sm-auto" id="check-row-div' + (i + 1) + '"><button type="button" class="btn btn-light" id="check-screen-btn' + (i + 1) + '" value="' + (i + 1) + '" onclick="checkRow.call' +
                            '(this)' +
                            '"><span class="fas ' +
                            'fa-check" ' +
                            'style="color:green;" ></span></button></div>');
                        //</editor-fold>
                        //<editor-fold desc="var remRow">
                        var remRow = $('<div class="form-group col-sm-auto"  id="rem-row-div' + (i + 1) + '"><button type="button" class="btn btn-light" id="rem-screen-btn' + (i + 1) + '" value="' + (i + 1) + '" onclick="remRow.call(this)"><span ' +
                            'class="far ' +
                            'fa-trash-alt" ' +
                            'style="color:red;' +
                            '"></span></button></div>');
                        //</editor-fold>
                        $('#sieve-content').append(newEditCol);
                        $('#screen-form-row' + (i + 1)).append(checkRow).append(remRow);
                        count++;
                        $('#add-sieves-form').show();
                        $('#sieve-counter').show().text('Number of sieves in stack: ' + ($('.list-group-item').length));
                    }
                }
                else {
                    //<editor-fold desc="var newEditCol">
                    var newEditCol = $('<ul class="list-group list-group-flush" id="add-lg-' + count + '"><li class="list-group-item border-top-0"><div id="screen-form-row' + count + '" ' + 'class="form-row"><div class="form-group col-sm-auto"><span class="badge th-vprop-blue-medium">' + (count) + '</span></div><div ' +
                        'id="screen-col' + count + '" class="form-group col-xl-12"><label id="screen-name-label' + count + '" for="screenAdd">Screen:</label><input autocomplete="off"  id="screen-name-input' + count + '" type="text" class="form-control"></div><div class="form-group col-xl-12" id="serial-col' + count + '"><label for="serialAddNumber" id="serial-label' + count + '">Serial:</label><input autocomplete="off"  type="text" class="form-control" id="serial-input' + count + '"></div><div id="weight-col' + count + '" ' +
                        'class="form-group col-xl-12"><label id="start-weight-label' + count + '" for="start-weight-input">Start Weight:</label><input autocomplete="off"  id="start-weight-input' + count + '" type="number" class="form-control"></div></div></li></ul>');
                    //</editor-fold>
                    //<editor-fold desc="var checkRow">
                    var checkRow = $('<div class="form-group col-sm-auto" id="check-row-div' + (count) + '"><button type="button" class="btn btn-light" id="check-screen-btn' + (count) + '" value="' + (count) + '" onclick="checkRow.call' +
                        '(this)' +
                        '"><span class="fas ' +
                        'fa-check" ' +
                        'style="color:green;" ></span></button></div>');
                    //</editor-fold>
                    //<editor-fold desc="var remRow">
                    var remRow = $('<div class="form-group col-sm-auto"  id="rem-row-div' + (count) + '"><button type="button" class="btn btn-light" id="rem-screen-btn' + (count) + '" value="' + (count) + '" onclick="remRow.call(this)"><span ' +
                        'class="far ' +
                        'fa-trash-alt" ' +
                        'style="color:red;' +
                        '"></span></button></div>');
                    //</editor-fold>
                    $('#sieve-content').append(newEditCol);
                    $('#screen-form-row' + (count)).append(checkRow).append(remRow);
                }
            }
        });

        $('#sieve-screen-submit-btn').on('click', function () {
            var formData = {};
            var screens = $('.list-group-item').length;
            var i;
            for (i = 1; i <= screens; i++) {
                formData["description"] = $('#stack-name-input').val();
                formData["siteId"] = $('#site-select').val();
                formData['screen'] = $('#screen-name-input' + i).val();
                formData['serial_no'] = $('#serial-input' + i).val();
                formData['start_weight'] = $('#start-weight-input' + i).val();
                formData['sort_order'] = i;
                $.ajax
                ({
                    dataType: "text",
                    type: 'POST',
                    url: '../../Includes/QC/addsievesintostack.php',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        if (response === '1') {
                            $.alert({
                                title: 'Success',
                                content: formData['screen']+ ' added successfully.',
                                type: 'green',
                                buttons: {
                                    ok: {
                                        isHidden: true
                                    }
                                }
                            });
                            location.reload();
                        } else {
                            $.alert({
                                title: 'Failure',
                                content: 'Issue saving '+formData.description+' to stack.',
                                type: 'red'
                            });
                        }
                    },
                    error: function () {
                        $('#sieve-content').empty().append('<div class="alert alert-danger">Sieves failed to add.</div>');
                    }
                });
            }
        });

        $('#sieves-edit-button').on('click', function () {
            $('edit-add-sieve').show();
            var formData = {};
            formData["id"] = $('#edit-id').val();
            formData["site"] = $('#edit-site-id').val();
            $('#edit-sieve-content').hide();
            $('#edit-sieves-in-stack-content').show();
            $.ajax
            ({
                dataType: "text",
                type: 'POST',
                url: '../../Includes/QC/getsievesbystackandsite.php',
                data: JSON.stringify(formData),
                success: function (data) { //get sieve results from database based on id and site
                    var resultCount = Object.keys(JSON.parse(data)).length;
                    $('#site-id').val($('#edit-site-id').val());
                    $('#stack-id').val($('#edit-id').val());
                    $('#sieves-in-stack-table').DataTable().clear().destroy();
                    for (var i = 0; i < resultCount; i++) {
                        var formData = JSON.parse(data);
                        if (formData[i].is_active === '1') {
                            //<editor-fold desc="sievesRowEdit">
                            if(formData[i].edit_date === null) {
                                formData[i].edit_date = '';
                            }else{
                                formData[i].edit_date =  formData[i].edit_date.split(' ')[0];
                            }
                            if(formData[i].serial_no === null) {
                                formData[i].serial_no = '';
                            }
                            if(formData[i].current_weight === '0') {
                                formData[i].current_weight = 'NA';
                            }
                            //<editor-fold desc="sievesRowEdit">
                            var sievesRowEdit = "<tr><input id=\"sieve-id-" + i + "\" type=\"hidden\" value=\"" + formData[i].id + "\"><input id=\"status-" + i + "\" type=\"hidden\" value=\"" + formData[i].is_active + "\">" +
                                "<td><input autocomplete=\"off\"  type=\"text\" style=\"width:95px;\" class=\"form-control\" id=\"serial-sieve-edit-" + i + "\" value=\"" + formData[i].serial_no + "\"></td>" +
                                "<td><input autocomplete=\"off\" style=\"width:55px;\" type=\"text\" class=\"form-control\" id=\"screen-sieve-edit-" + i + "\" value=\"" + formData[i].screen + "\"></td>" +
                                "<td><input autocomplete=\"off\" type=\"number\" style=\"width:80px;\" class=\"form-control\" id=\"start-weight-sieve-edit-" + i + "\" value=\"" + formData[i].start_weight + "\"></td>" +
                                "<td><input class=\"form-control border-0 bg-white\" id=\"current-weight-"+i+"\" style=\"width:65px;\" value=\""+ formData[i].current_weight +"\" disabled></td>" +
                                "<td><input id=\"delta-"+i+"\" style=\"width:55px;\" class=\"form-control border-0 bg-white pr-0 pl-0\" disabled></td>" +
                                "<td><input id=\"create-date-"+i+"\" class=\"form-control border-0 bg-white pr-0 pl-0\" style=\"width:95px;\" value=\"" + formData[i].create_date.split(' ')[0] + "\" disabled></td>" +
                                "<td><input id=\"uses-"+i+"\" class=\"form-control border-0 bg-white pr-0 pl-0\"></td>" +
                                "<td><input class=\"form-control border-0 bg-white pr-0 pl-0\" style=\"width: 95px;\" value=\"" + formData[i].edit_date + "\" disabled></td>" +
                                "<td><input type=\"number\" class=\"form-control\"  id=\"sort-order-" + i + "\" value=\"" + formData[i].sort_order + "\"></td>" +
                                "<td><button type=\"button\" id=\"update-sieve-row-btn-" + i + "\" class=\"btn " +
                                "btn-dark ml-2\" value=\"" + i + "\" onclick=\"updateSieve.call(this)\">Update</button></td>" +
                                "<td><button " +
                                "type=\"button\" class=\"btn btn-danger " +
                                "ml-2\" id=\"retire-sieve-btn-" + i + "\" " +
                                "value=\"" + i + "\" onclick=\"retireSieve.call(this)\">Retire</button></td></tr>";
                            //</editor-fold>
                            $('#sieves-table-body').append(sievesRowEdit);
                            implementedUses(i);
                        }
                        else { //If the sieve isn't active, generate a different row
                            if(formData[i].edit_date === null) {
                                formData[i].edit_date = '';
                            }else{
                                formData[i].edit_date =  formData[i].edit_date.split(' ')[0];
                            }
                            if(formData[i].serial_no === null) {
                                formData[i].serial_no = '';
                            }
                            //<editor-fold desc="sievesRowEdit">
                            var sievesRowEdit = "<tr><input id=\"sieve-id-" + i + "\" type=\"hidden\" value=\"" + formData[i].id + "\"><input id=\"status-" + i + "\" type=\"hidden\" value=\"" + formData[i].is_active + "\">" +
                                "<td class=\"retired-sieve\"><input autocomplete=\"off\"  type=\"text\" class=\"form-control\" id=\"serial-sieve-edit-" + i + "\" value=\"" + formData[i].serial_no + "\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input autocomplete=\"off\" type=\"text\" class=\"form-control\" id=\"screen-sieve-edit-" + i + "\" value=\"" + formData[i].screen + "\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input autocomplete=\"off\" type=\"number\" class=\"form-control\" id=\"start-weight-sieve-edit-" + i + "\" value=\"" + formData[i].start_weight + "\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input class=\"form-control border-0 bg-white\" id=\"current-weight-"+i+"\" style=\"width:65px;\" value=\""+ formData[i].current_weight +"\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input id=\"delta-"+i+"\" class=\"form-control border-0 bg-white pr-0 pl-0\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input id=\"create-date-"+i+"\" class=\"form-control border-0 bg-white pr-0 pl-0\" style=\"width:95px;\" value=\"" + formData[i].create_date.split(' ')[0] + "\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input id=\"uses-"+i+"\" class=\"form-control border-0 bg-white pr-0 pl-0\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input class=\"form-control border-0 bg-white pr-0 pl-0\" style=\"width: 95px;\" value=\"" + formData[i].edit_date + "\" disabled></td>" +
                                "<td class=\"retired-sieve\"><input type=\"number\" class=\"form-control\" id=\"sort-order-" + i + "\" value=\"" + formData[i].sort_order + "\"></td>" +
                                "<td class=\"retired-sieve\"><button type=\"button\" id=\"update-sieve-row-btn-" + i + "\" class=\"btn " +
                                "btn-dark ml-2\" value=\"" + i + "\" onclick=\"updateSieve.call(this)\">Update</button></td>" +
                                "<td class=\"retired-sieve\"><button " +
                                "type=\"button\" class=\"btn btn-light " +
                                "ml-2\" id=\"retire-sieve-btn-" + i + "\" " +
                                "value=\"" + i + "\" onclick=\"retireSieve.call(this)\" disabled>Retire</button></td></tr>";
                            //</editor-fold> //
                            $('#sieves-table-body').append(sievesRowEdit);
                            implementedUses(i);
                        }
                        $('#sieves-in-stack-table').DataTable({
                            dom: "t",
                            scrollY: "400px",
                            retrieve: true,
                            //autoWidth: false,
                            scrollX: true,
                            fixedHeader: true,
                            sort: false,
                            scrollCollapse: true

                        });
                        $('#sieves-in-stack-table').DataTable().columns.adjust();
                    }
                },
                error: function () {
                }
            });
        });

        $('#sieve-content-back-button').on('click', function () {
            $('#edit-sieves-in-stack-content').hide();
            $('.new-sieve-row').remove();
            $('#edit-sieve-content').show();
            $('#sieves-table-body').empty();

        });

        $('#edit-add-sieve').on('click', function () {
            var count = 0;
            //<editor-fold desc="newSieveRow">
            var newSieveRow = "<div class=\"new-sieve-row\"><input autocomplete=\"off\"  type=\"hidden\" id=\"new-sieve-id-" + count + "\" value=\"\"><div class=\"form-row \" id=\"new-form-row-" + count + "\"><div class=\"form-group col-xl-2\"><label for=\"new-serial-" + count +
                "\">Serial:</label><input autocomplete=\"off\"  type=\"text\" class=\"form-control\" id=\"new-serial-sieve-edit-" + count + "\" value=\"\"></div><div class=\"form-group col-xl-2\"><label for=\"new-screen-" + count + "\">Screen:</label><input autocomplete=\"off\"  type=\"text\" class=\"form-control\" id=\"new-screen-sieve-edit-" + count + "\" value=\"\"></div><div class=\"form-group col-xl-2\"><label for=\"new-sieve-edit-start-weight-" + count + "\">Start Weight:</label><input " +
                "autocomplete=\"off\" " +
                " type=\"number\" class=\"form-control\" id=\"new-start-weight-sieve-edit-" + count + "\" value=\"\"></div><div class=\"form-group col-xl-2\"><label for=\"sort-order-" + count + "\">Sort Order</label><input autocomplete=\"off\" type=\"number\" class=\"form-control\" type=\"number\" id=\"new-sieve-edit-sort-order-" + count + "\" value=\"\"></div><div class=\"form-inline\"><button type=\"button\" id=\"new-update-sieve-row-btn-" + count + "\" class=\"btn btn-outline-dark ml-2\" value=\"" + count +
                "\" " +
                "onclick=\"addSieve.call(this)\">Add</button></div></div>"
            //</editor-fold>
            $('#sieve-edit-card-footer').prepend(newSieveRow);
            count++;
            $('#edit-add-sieve').hide();
        });

    });

    function editRow() {
        var id = $(this).val();
        //<editor-fold desc="var checkRow">
        var checkRow = $('<div class="form-group col-xl-3" id="check-row-div' + id + '"><button type="button" class="btn btn-light" id="check-screen-btn' + id + '" value="' + id + '" onclick="checkRow.call' +
            '(this)' +
            '"><span class="fas ' +
            'fa-check" ' +
            'style="color:green;" ></span></button></div>');
        //</editor-fold>
        //<editor-fold desc="var remRow">
        var remRow = $('<div class="form-group col-xl-3"  id="rem-row-div' + id + '"><button type="button" class="btn btn-light" id="rem-screen-btn' + id + '" value="' + id + '" onclick="remRow.call(this)"><span ' +
            'class="far ' +
            'fa-trash-alt" ' +
            'style="color:red;' +
            '"></span></button></div>');
        //</editor-fold>
        $('#screen-col' + id).removeClass("col-sm-4").addClass("col-xl-12");
        $('#weight-col' + id).removeClass("col-sm-4").addClass("col-xl-12");
        $('#serial-col' + id).removeClass("").addClass("col-xl-12");
        $('#screen-name-label' + id).show();
        $('#screen-name-input' + id).removeAttr("disabled");
        $('#serial-label' + id).show();
        $('#serial-input' + id).show();
        $('#start-weight-label' + id).show();
        $('#start-weight-input' + id).removeAttr("disabled");
        $('#edit-screen-div' + id).remove();
        $('#rem-screen-div' + id).remove();
        $('#screen-form-row' + id).append(checkRow).append(remRow);
    }

    function checkRow() {
        var id = $(this).val();
        //<editor-fold desc="editCol">
        var editCol = $('<div class="form-group col-sm-auto" id="edit-screen-div' + id + '"><button type="button" class="btn btn-light mt-1 edit-btn" id="edit-screen-btn' + id + '" value="' + id + '" onclick="editRow.call(this)"><span class="far fa-edit" style="color:green;"></span></button></div>');
        //</editor-fold>
        //<editor-fold desc="remCol">
        var remCol = $('<div class="form-group col-sm-auto"  id="rem-screen-div' + id + '"><button type="button" class="btn btn-light mt-1 rem-btn" id="rem-screen-btn' + id + '" value="' + id + '" onclick="remRow.call(this)"><span class="far fa-trash-alt" style="color:red;"></span></button></div>');
        //</editor-fold>
        $('#screen-col' + id).removeClass("col-xl-12").addClass("col-sm-3");
        $('#weight-col' + id).removeClass("col-xl-12").addClass("col-sm-3");
        $('#save-row-btn' + id).hide();
        $('#serial-col' + id).removeClass("col-xl-12").addClass("col-sm-3");
        $('#screen-name-label' + id).hide();
        $('#screen-name-input' + id).attr("disabled", "disabled");
        $('#serial-label' + id).hide();
        $('#serial-input' + id).attr("disabled", "disabled");
        $('#start-weight-label' + id).hide();
        $('#start-weight-input' + id).attr("disabled", "disabled");
        $('#edit-screen-div' + id).remove();
        $('#rem-screen-div' + id).remove();
        $('#check-row-div' + id).remove();
        $('#rem-row-div' + id).remove();
        $('#screen-form-row' + id).append(editCol).append(remCol);
    }

    function remRow() {
        var id = $(this).val();
        $('#add-lg-' + id).remove();
        $('#sieve-counter').text('Number of sieves in stack:' + ($('.list-group-item').length));

    }

    function insertSieveStack() {

        var formData = {};
        formData["description"] = $('#stack-name-input').val();
        formData["site"] = $('#site-select').val();
        formData["is_camsizer"] = $('#camsizer-input').val();
        $('#sieve-counter').hide();
        $('#add-sieve-stack-form').on('click', function (event) {
            $.ajax
            ({
                dataType: "text",
                type: 'POST',
                url: '../../Includes/QC/addsievestack.php',
                data: JSON.stringify(formData),
                success: function (response) {
                    if (response >= 0) {
                        $("#success-message").show().text('Stack successfully added.').fadeTo(2000, 500).slideUp(500, function(){
                            $("#success-alert").slideUp(1000);
                        });;
                        $.confirm({
                            type: 'green',
                            title: 'Add Sieves?',
                            content: 'Would you like to add sieves to ' + formData.description + '? <br/> You can add them later in Edit.',
                            buttons: {
                                confirm: {
                                    btnClass: 'btn-vprop-green',
                                    action: function () {
                                        $('#sieve-stack-card-footer').hide();
                                        $('#add-screen-card').show();
                                    }
                                },
                                cancel: {
                                    action: function () {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    }
                    else {
                        alert(response);
                        event.stopPropagation();
                        location.reload();
                    }
                },
                error: function (response) {
                    message = 'Error communicating with database. Please contact development.';
                    $("#error-message").show().text(message);
                }
            });

        });
    }

    function editSieveStack() {
        var rowData = $(this).val();
        rowData = JSON.parse(rowData);
        $('#table-wrapper').hide();
        $('#edit-sieve-content').show();
        $('#edit-id').val(rowData.id);
        $('#edit-site-id').val(rowData.site);
        $('#edit-camsizer').val(rowData.camsizer)
        $('#edit-stack-name').val(rowData.description);
        $('#edit-sort-order').val(rowData.sort_order);
        $('#edit-status').val(rowData.status);
        $('#back-button').on("click", function () {
            $('#edit-sieve-content').hide();
            $('#table-wrapper').show();
        })

    }

    function updateSieve() {
        var id = $(this).val();
        var rowData = {};
        rowData["id"] = $('#sieve-id-' + id).val();
        rowData["sieve_stack_id"] = $('#edit-id').val();
        rowData["site_id"] = $('#edit-site-id').val();
        rowData["serial_no"] = $('#serial-sieve-edit-' + id).val();
        rowData["screen"] = $('#screen-sieve-edit-' + id).val();
        rowData["sort_order"] = $('#sort-order-' + id).val();
        rowData["start_weight"] = $('#start-weight-sieve-edit-' + id).val();
        rowData["status"] = $('#status-' + id).val();
        $.ajax
        ({
            dataType: "text",
            type: 'POST',
            url: '../../Includes/QC/updatesieve.php',
            data: JSON.stringify(rowData),
            success: function (response) {
                if (response === '1') {
                    $.alert({
                        title: 'Success!',
                        content: 'Updated ' + rowData.screen + ' successfully.',
                        type: 'green'
                    });
                    $('#update-sieve-row-btn-'+id).removeClass().addClass('btn btn-success ml-2');
                }
                else if (response === '0') {
                    $.alert({
                        title: 'Warning!',
                        content: 'Record unchanged.',
                        type: 'orange'
                    });

                }
                else {
                    $.alert({
                        title: 'Error!',
                        content: response,
                        type: 'red'
                    });

                }
            },
            error: function () {
                $.alert({
                    title: 'Error!',
                    content: 'Issue communicating with server.',
                    type: 'red'
                });
            }
        });


    }

    function retireSieve() {
        var id = $(this).val();
        var rowData = {};
        rowData["id"] = $('#sieve-id-' + id).val();
        rowData["stack_id"] = $('#edit-id').val();
        rowData["site"] = $('#edit-site-id').val();
        $.confirm({
            title: 'Retire Sieve?',
            content: 'Screen: '+$('#screen-sieve-edit-'+id).val(),
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'Yes',
                    btnClass: 'btn-vprop-green',
                    action: function () {
                        $.ajax({
                            dataType: "json",
                            type: 'POST',
                            url: '../../Includes/QC/retiresieve.php',
                            data: JSON.stringify(rowData),
                            success: function (data) {
                                if (data.return === 1) {
                                    $('#retire-sieve-btn-' + id).removeClass().addClass('btn ml-2 btn-outline-danger').text('Retired');

                                } else {
                                    $('#new-update-sieve-row-btn-' + id).removeClass().addClass('btn ml-2 btn-outline-danger');
                                    $.alert({
                                        title: 'Error',
                                        content: data.response
                                    });
                                }
                            },
                            error: function (response) {

                            }
                        });

                    }
                },
                cancel: {
                    text: 'No ',
                    btnClass: 'btn-secondary ',
                }
            }
        });
    }

    /*function unretireSieve() {
        var id = $(this).val();
        var rowData = {};
        rowData["id"] = $('#sieve-id-' + id).val();
        rowData["stack_id"] = $('#edit-id').val();
        rowData["site"] = $('#edit-site-id').val();
        $.ajax
        ({
            dataType: "json",
            type: 'POST',
            url: '../../Includes/QC/unretiresieve.php',
            data: JSON.stringify(rowData),
            success: function (data) {
                if (data.return === 1) {
                    $('#retire-sieve-btn-' + id).removeClass().addClass('btn ml-2 btn-outline-danger').text('Retire');

                } else {
                    $('#new-update-sieve-row-btn-' + id).removeClass().addClass('btn ml-2 btn-outline-danger');
                    $.alert({
                        title: 'Error',
                        content: data.response
                    });
                }
            },
            error: function (response) {

            }
        });
    }*/

    function addSieve() {
        var id = $(this).val();
        var rowData = {};
        rowData["stack_id"] = $('#edit-id').val();
        rowData["description"] = $('#stack-name-input').val();
        rowData["siteId"] = $('#edit-site-id').val();
        rowData['screen'] = $('#new-screen-sieve-edit-' + id).val();
        rowData['serial_no'] = $('#new-serial-sieve-edit-' + id).val();
        rowData['start_weight'] = $('#new-start-weight-sieve-edit-' + id).val();
        rowData['sort_order'] = $('#new-sieve-edit-sort-order-'+id).val();
        $.ajax
        ({
            dataType: "json",
            type: 'POST',
            url: '../../Includes/QC/editaddsieve.php',
            data: JSON.stringify(rowData),
            success: function (data) {
                if (data.return === 1) {
                    $('#new-update-sieve-row-btn-' + id).removeClass().addClass('btn ml-2 btn-outline-success').text('Added').attr("disabled", "disabled");
                    $('#edit-add-sieve').show();
                } else {
                    $('#new-update-sieve-row-btn-' + id).removeClass().addClass('btn ml-2 btn-outline-danger');
                    $.alert({
                        title: 'Error',
                        content: data.response
                    });
                }
            },
            error: function (response) {

            }
        });
    }

    function cleanSieveStack() {
        var rowData = $(this).val();
        rowData = JSON.parse(rowData);
        $.confirm({
            type: 'blue',
            title: 'Clean Sieve Stack?',
            content: rowData.description,
            buttons: {
                confirm: {
                    text: 'Yes',
                    btnClass: 'btn-vprop-green',
                    action: function () {
                        $('#overlay').show();
                        $.ajax({
                            dataType: "text",
                            type: "POST",
                            url: "../../Includes/QC/cleansieve.php",
                            data: JSON.stringify(rowData),
                        });
                        $('#allSievesTable').DataTable().destroy();
                        location.reload(true);
                    }
                },
                cancel: {
                    text: 'Cancel',
                    btnClass: 'btn-secondary',
                }
            }
        });
    }

    function retireSieveStack() {
        var rowData = $(this).val();
        rowData = JSON.parse(rowData);
        $.confirm({
            type: 'red',
            title: 'Retire Sieve Stack?',
            content: rowData.description,
            buttons: {
                confirm: {
                    text: 'Yes',
                    btnClass: 'btn-vprop-green',
                    action: function () {
                        $('#overlay').show();
                        $.ajax({
                            dataType: "text",
                            type: "POST",
                            url: "../../Includes/QC/retiresievestack.php",
                            data: JSON.stringify(rowData),
                        });
                        $('#allSievesTable').DataTable().destroy();
                        location.reload(true);
                    }
                },
                cancel: {
                    text: 'Cancel',
                    btnClass: 'btn-secondary',
                }
            }
        });
    }

    function implementedUses(i) {
            var startWeight = $('#start-weight-sieve-edit-'+i).val();
            var currentWeight = $('#current-weight-'+i).val();
            var delta = startWeight-currentWeight;
            var formData = {};
            formData["sieve_stack_id"] = $('#edit-id').val();
            formData["site_id"] = $('#edit-site-id').val();
            formData["create_date"] = $('#create-date-' + i).val();

            $.ajax({
                type: 'POST',
                url: '../../Includes/QC/getcleansieveuses.php',
                data: JSON.stringify(formData),
                success: function (data) {

                    $('#uses-' + i).val(data);

                },
                error: function () {
                    alert('error');
                }
            });
        $('.retired-sieve').hide();
        if(currentWeight > 0) {
            $('#delta-' + i).val(delta.toFixed(1));
        }
        }


</script>
