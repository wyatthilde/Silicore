<?php
include('../../Includes/Templates/header.php');

require_once('../../Includes/Security/database.php');

if (session_status() == PHP_SESSION_NONE) {

    session_start();

}

$database = new Database();

$all_links_read = $database->get("sp_ui_NavLeftLinksGetAll");

$links_obj = json_decode($all_links_read);

foreach ($links_obj as $item) {

    $pageCompany = $item->company;

    $pageSite = $item->site;

    $pageDepartment = $item->permission;

    $pagePermissionLevel = $item->permission_level;

    $currentPageCompany = $item->company;

    $currentPageSite = $item->site;

    $currentPageDepartment = $item->permission;

    $currentPagePermissionLevel = $item->permission_level;

    $folder = $item->DeptName;

    $file = strtolower($item->web_file);

    $allUrls[] = 'href="../../Controls/' . $folder . '/' . $file . '"';

//main page
    $generalMain = 'href="../../Controls/General/main.php"';
    $gbQcMain = 'href="../../Controls/QC/gb_main.php"';
    $gbQcOverview = 'href="../../Controls/QC/gb_overview.php"';
    $gbQcSampleGroupAdd = 'href="../../Controls/QC/gb_samplegroupadd.php"';
    $gbQcSamples = 'href="../../Controls/QC/gb_samples.php?view=verbose"';
    $gbQcManageSites = 'href="../../Controls/QC/managesites.php"';
    $gbQcManagePlants = 'href="../../Controls/QC/manageplants.php"';
    $gbQcManageLocations = 'href="../../Controls/QC/gb_managelocations.php"';
    $gbQcManageSpecificLocations = 'href="../../Controls/QC/gb_managespecificlocations.php"';
    $gbQcSampleEdit = 'href="../../Controls/QC/gb_sampleedit.php"';
    $gbQcSampleView = 'href="../../Controls/QC/gb_sampleview.php"';
    $gbQcPerformance = 'href="../../Controls/QC/gb_performance.php"';
    $gbQcThresholdMaint = 'href="../../Controls/QC/gb_thresholdmaint.php"';
    $gbQcThresholdEdit = 'href="../../Controls/QC/gb_thresholdedit.php"';
    $gbQcDocumentManagement = 'href="../../Controls/QC/document_management_qc.php"';

//Tl QC
    $tlQcMain = 'href="../../Controls/QC/tl_main.php"';
    $tlQcOverview = 'href="../../Controls/QC/tl_overview.php"';
    $tlQcSampleGroupAdd = 'href="../../Controls/QC/tl_samplegroupadd.php"';
    $tlQcSamples = 'href="../../Controls/QC/tl_samples.php?view=verbose"';
    $tlQcManageSites = 'href="../../Controls/QC/managesites.php"';
    $tlQcManagePlants = 'href="../../Controls/QC/manageplants.php"';
    $tlQcManageLocations = 'href="../../Controls/QC/tl_managelocations.php"';
    $tlQcManageSpecificLocations = 'href="../../Controls/QC/tl_managespecificlocations.php"';
    $tlQcSampleEdit = 'href="../../Controls/QC/tl_sampleedit.php"';
    $tlQcSampleView = 'href="../../Controls/QC/tl_sampleview.php"';
    $tlQcPerformance = 'href="../../Controls/QC/tl_performance.php"';
    $tlQcThresholdMaint = 'href="../../Controls/QC/tl_thresholdmaint.php"';
    $tlQcThresholdEdit = 'href="../../Controls/QC/tl_thresholdedit.php"';
    $tlQcDocumentManagement = 'href="../../Controls/QC/document_management_qc.php"';

//Wt QC
    $wtQcMain = 'href="../../Controls/QC/wt_main.php"';
    $wtQcOverview = 'href="../../Controls/QC/wt_overview.php"';
    $wtQcSampleGroupAdd = 'href="../../Controls/QC/wt_samplegroupadd.php"';
    $wtQcSamples = 'href="../../Controls/QC/wt_samples.php?view=verbose"';
    $wtQcManageSites = 'href="../../Controls/QC/managesites.php"';
    $wtQcManagePlants = 'href="../../Controls/QC/manageplants.php"';
    $wtQcManageLocations = 'href="../../Controls/QC/wt_managelocations.php"';
    $wtQcManageSpecificLocations = 'href="../../Controls/QC/wt_managespecificlocations.php"';
    $wtQcSampleEdit = 'href="../../Controls/QC/wt_sampleedit.php"';
    $wtQcSampleView = 'href="../../Controls/QC/wt_sampleview.php"';
    $wtQcPerformance = 'href="../../Controls/QC/wt_performance.php"';
    $wtQcThresholdMaint = 'href="../../Controls/QC/wt_thresholdmaint.php"';
    $wtQcThresholdEdit = 'href="../../Controls/QC/wt_thresholdedit.php"';
    $wtQcDocumentManagement = 'href="../../Controls/QC/document_management_qc.php"';
//Qc management
    $qcSieveManagement = 'href="../../Controls/QC/sievemanagement.php"';
//Production
    $prodMain = 'href="../../Controls/Production/main.php"';
    $prodKpiDash = 'href="../../Controls/Production/kpidashboard.php"';
    $prodKpiTlDash = 'href="../../Controls/Production/kpidashboard_tl.php"';
    $prodPlantDash = 'href="../../Controls/Production/plantdashboard.php"';
    $prodTceq = 'href="../../Controls/Production/tceqreport.php"';
//$prodCressonMain = 'href="../../Controls/Production/cressondashboard.php"';
    $prodPlantThresholds = 'href="../../Controls/Production/plc_plant_thresholds.php"';
    $prodAddTag = 'href="../../Controls/Production/gb_plc_add_tag.php"';
    $prodEditThreshold = 'href="../../Controls/Production/plc_edit_threshold.php"';
    $prodGbWeatherData = 'href="../../Controls/Production/weather_data_table.php"';
    $prodTlWeatherData = 'href="../../Controls/Production/tl_weatherdata.php"';
    $prodWtWeatherData = 'href="../../Controls/Production/wt_weatherdata.php"';
    $prodGbScorecard = 'href="../../Controls/Production/gb_scorecard.php"';
    $prodTlScorecard = 'href="../../Controls/Production/tl_scorecard.php"';
    $prodExecDashboard = 'href="../../Controls/Production/executive_dashboard.php"';

//Loadout
    $loadoutMain = 'href="../../Controls/Loadout/main.php"';
    $loadoutProductTransfers = 'href="../../Controls/Loadout/producttransfers.php"';
    $loadoutReports = 'href="../../Controls/Loadout/reports.php"';

//Logistics
    $logMain = 'href="../../Controls/Logistics/main.php"';

//It
    $itMain = 'href="../../Controls/IT/main.php"';
    $itAssetManagement = 'href="../../Controls/IT/inventorymanagement.php"';

//Safety
    $safetyMain = 'href="../../Controls/Safety/main.php"';

//Accounting
    $accMain = 'href="../../Controls/Accounting/main.php"';
    $accBackOfficeDocs = 'href="../../Controls/Accounting/LegacyDocuments.php"';

//Hr
    $hrMain = 'href="../../Controls/HR/main.php"';
    $hrOnBoard = 'href="../../Controls/HR/onboarding.php"';
    $hrOffBoard = 'href="../../Controls/HR/hroffboarding.php"';
    $hrPreEmploy = 'href="../../Controls/HR/preemployment.php"';
//Dev
    $devMain = 'href="../../Controls/Development/main.php"';
    $devAnalytics = 'href="../../Controls/Development/analyticsdashboard.php"';
//$devUpdatePage = 'href="../../Controls/Development/updatepagehelp.php"';
//$devEditPage = 'href="../../Controls/Development/editpage.php"';
    $itUsers = 'href="../../Controls/IT/silicoreusers.php"';
//$devUserEdit = 'href="../../Controls/Development/silicoreuseredit.php"';
    $devCodeExamples = 'href="../../Controls/Development/codeexamples.php"';
    $devTestMail = 'href="../../Controls/Development/testmail.php"';
    $devMysqlSproc = 'href="../../Controls/Development/mysqlphpsproc.php"';
    $devMssqlSproc = 'href="../../Controls/Development/mssqlphpsproc.php"';
    $devServerNotes = 'href="../../Controls/Development/doc_servernotes.php"';
    $devDeleteLocation = 'href="../../Controls/Development/deletelocation.php"';

//General
    $genQlMain = 'href="../../Controls/General/quicklinks.php"';
    $genQlVistaSand = 'href="../../Controls/General/http://pweb.vistasand.com/"';
    $genQlMaaltLp = 'href="../../Controls/General/https://www.maaltlp.com/"';
    $genQlMaalt = 'href="../../Controls/General/http://www.maalt.com/"';
    $genQlPaycom = 'href="../../Controls/General/http://www.paycom.com/"';
    $genProfile = 'href="../../Controls/General/profile.php"';

//Style Variables
    $activeLink = 'class="nav-link"';
    $disabledLink = 'style="display:none;"';
}

if (isset($singleUserObject)) {
    $user_links_read = $database->get('sp_ui_NavbarLinksByUserGet(' . "'" . $singleUserObject->vars["username"] . "'" . ')');
    $user_links_obj = json_decode($user_links_read);
    foreach ($user_links_obj as $item) {
        $folder = $item->DeptName;
        $file = strtolower($item->web_file);
        $role = $item->role;
        $pagePermission = $item->permission_level;
        if ($role >= $pagePermission) {
            $permissionUrls[] = 'href="../../Controls/' . $folder . '/' . $file . '"';
        }

    }
}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Wyatt Hildebrandt">
        <title>Silicore</title>
        <!--<link href="../../Includes/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="../../Includes/css/logo-nav.css" rel="stylesheet">
        <style>
            @media (max-width: 991.98px) {
                .navbar-expand-lg > .container, .navbar-expand-lg > .container-fluid {
                    padding-right: 12px !important;
                    padding-left: 12px !important;
                }

                .navbar-nav .dropdown-menu {
                    border-left: 0;
                    border-right: 0;
                    border-radius: 0;
                    /*margin-left: 2rem;*/
                }

            }

            /* rotate caret on hover */
            .dropdown-menu > li > a:hover:after {
                text-decoration: underline;
                transform: rotate(-90deg);
            }

            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu a::after {
                transform: rotate(-90deg);
                position: absolute;
                right: 6px;
                top: .8em;
            }

            .dropdown-submenu .dropdown-menu {
                top: 0;
                left: 100%;
                margin-left: .1rem;
                margin-right: .1rem;
            }

            .container {
                max-width: 100%;
            }

            .navbar-expand-lg .navbar-collapse {
                justify-content: center;
            }

            #nav-icon {
                width: 30px;
                height: 23px;
                position: relative;
                margin-left: 50px;
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
                -webkit-transition: .5s ease-in-out;
                -moz-transition: .5s ease-in-out;
                -o-transition: .5s ease-in-out;
                transition: .5s ease-in-out;
                cursor: pointer;
            }

            #nav-icon span {
                display: block;
                position: absolute;
                height: 5px;
                width: 100%;
                background: #000000;
                border-radius: 5px;
                opacity: 1;
                left: 0;
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
                -webkit-transition: .25s ease-in-out;
                -moz-transition: .25s ease-in-out;
                -o-transition: .25s ease-in-out;
                transition: .25s ease-in-out;
            }

            #nav-icon span:nth-child(1) {
                top: 0px;
            }

            #nav-icon span:nth-child(2), #nav-icon span:nth-child(3) {
                top: 9px;
            }

            #nav-icon span:nth-child(4) {
                top: 18px;
            }

            #nav-icon.open span:nth-child(1) {
                top: 18px;
                width: 0%;
                left: 50%;
            }

            #nav-icon.open span:nth-child(2) {
                -webkit-transform: rotate(45deg);
                -moz-transform: rotate(45deg);
                -o-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            #nav-icon.open span:nth-child(3) {
                -webkit-transform: rotate(-45deg);
                -moz-transform: rotate(-45deg);
                -o-transform: rotate(-45deg);
                transform: rotate(-45deg);
            }

            #nav-icon.open span:nth-child(4) {
                top: 18px;
                width: 0%;
                left: 50%;
            }
        </style>
    </head>

<?php

if (!isset($singleUserObject->vars["username"])) {


    ?>
    <body class="bg-light">
    <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
    <div class="container bg-white">
    <a class="navbar-brand" href="#">
        <img src="../../Images/vprop_logo_navbar.png" class="mb-1" alt="Vista Proppants and Logistics">
    </a>
    <div id="nav-icon" class="navbar-toggler" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav">
    <?php
    echo('<li class="nav-item dropdown" >');
    echo('<a class="nav-link dropdown-toggle" href="#" id="login" data-toggle="dropdown">Log In</a>');
    echo('<div class="dropdown-menu">
                            <a class="nav-link" href="#"onclick="showSignIn(\'Sign_in_clicked, ' . $pageValues . '\')">Sign In</a>
                            <a class="nav-link" href="#" onclick="showRegister(\'Register_new_user_clicked, ' . $pageValues . '\')">Register</a>
                        </div></li></ul>');


    if (isset($_SESSION["signin_error_message"])) {
        $signin_error_message = filter_var($_SESSION["signin_error_message"], FILTER_SANITIZE_STRING);
        $signin_wrong_username = filter_var($_SESSION["signin_wrong_username"], FILTER_SANITIZE_STRING);
        $signin_wrong_password = filter_var($_SESSION["signin_wrong_password"], FILTER_SANITIZE_STRING);

        echo("<script>"); //Start JavaScript
        echo("var js_signin_error_message = '" . $signin_error_message . "';");
        echo("var js_signin_wrong_username = '" . $signin_wrong_username . "';");
        echo("var js_signin_wrong_password = '" . $signin_wrong_password . "';");

        echo("console.log('JS is running');");

        //on page load (wait until all the other code runs)
        echo("window.onload = function()");
        echo("{");
        echo("console.log(js_signin_error_message);");
        echo("console.log(js_signin_wrong_username);");
        echo("console.log(js_signin_wrong_password);");
        //unhide the modal window
        echo("var modal = document.getElementById('id01');");
        echo("modal.style.display = 'block';");
        //add the error message to the modal window using javascript
        echo("document.getElementById('error_message_text').innerHTML = '" . $signin_error_message . "';");
        //add the username and password entries to the modal window using javascript
        echo("document.getElementById('username_input').value = '" . $signin_wrong_username . "';");
        echo("document.getElementById('password_input').value = '" . $signin_wrong_password . "';");
        echo("};");
        echo("</script>"); //end the JavaScript
        unset($_SESSION["signin_error_message"]);
        unset($_SESSION["signin_wrong_username"]);
        unset($_SESSION["signin_wrong_password"]);
    }
//if the user is required to reset their password
    if (isset($_SESSION["signin_password_reset"])) {
        if ($_SESSION["signin_password_reset"] == true) {
            //display the sign in password modal window
            echo("<script>"); //Start JavaScript
            echo("window.onload = function()"); //wait until the window loads to run it
            echo("{");
            echo("alert('password reset function called');");
            //unhide the password modal window
            echo("var passwordModal = document.getElementById('id03');");
            echo("passwordModal.style.display = 'block';");
            echo("startValidating();"); //call the startValidating function from /Includes/general.js
            echo("};");
            echo("</script>"); //end the JavaScript
        }
    }
    if (isset($_SESSION["password_reset_message"])) {
        $password_reset_message_text = filter_var($_SESSION["password_reset_message"], FILTER_SANITIZE_STRING);
        //display the sign in password modal window
        echo("<script>"); //Start JavaScript
        echo("window.onload = function()"); //wait until the window loads to run it
        echo("{");
        echo("alert('password reset function called');");
        //unhide the password modal window
        echo("var passwordModal = document.getElementById('id04');");
        echo("passwordModal.style.display = 'block';");
        echo("document.getElementById('password_reset_result_text').innerHTML = '" . $password_reset_message_text . "';");
        echo("};");
        echo("</script>"); //end the JavaScript
        unset($_SESSION["password_reset_message"]);
    }
    echo '</div>';
    echo '</nav>';
    echo '<div class="container-fluid mt-5 bg-light">';
} else {
    ?>
    <body class="bg-light">
    <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
        <div class="container bg-white">
            <a class="navbar-brand" href="#">
                <img src="../../Images/vprop_logo_navbar.png" class="mb-1" alt="Vista Proppants and Logistics">
            </a>
            <div id="nav-icon" class="navbar-toggler" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../Controls/General/main.php" title="Home">
                            <span class="nav-link-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if (in_array($gbQcSamples, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">QC</a>';
                        } ?>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Granbury</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php if (in_array($qcSieveManagement, $permissionUrls)) {
                                            echo '<a ' . $qcSieveManagement . $activeLink . '>Sieve Management</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcOverview, $permissionUrls)) {
                                            echo '<a ' . $gbQcOverview . $activeLink . '>Overview</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcSampleGroupAdd, $permissionUrls)) {
                                            echo '<a ' . $gbQcSampleGroupAdd . $activeLink . '>Add Sample Group</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcSamples, $permissionUrls)) {
                                            echo '<a ' . $gbQcSamples . $activeLink . '>Sample Database</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcManageSites, $permissionUrls)) {
                                            echo '<a ' . $gbQcManageSites . $activeLink . '>Manage Sites</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcManagePlants, $permissionUrls)) {
                                            echo ' <a ' . $gbQcManagePlants . $activeLink . ' >Manage Plants</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcManageLocations, $permissionUrls)) {
                                            echo '<a ' . $gbQcManageLocations . $activeLink . '>Manage Locations</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcManageSpecificLocations, $permissionUrls)) {
                                            echo '<a ' . $gbQcManageSpecificLocations . $activeLink . ' >Manage Specific Locations</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcSampleEdit, $permissionUrls)) {
                                            echo ' <a ' . $gbQcSampleEdit . $activeLink . '>Edit Sample</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcSampleView, $permissionUrls)) {
                                            echo '<a ' . $gbQcSampleView . $activeLink . '>View Sample</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcPerformance, $permissionUrls)) {
                                            echo ' <a ' . $gbQcPerformance . $activeLink . ' >Performance</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcThresholdMaint, $permissionUrls)) {
                                            echo '<a ' . $gbQcThresholdMaint . $activeLink . ' >Threshold Maint.</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcThresholdEdit, $permissionUrls)) {
                                            echo '<a ' . $gbQcThresholdEdit . $activeLink . ' >Edit Threshold</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcDocumentManagement, $permissionUrls)) {
                                            echo '<a ' . $gbQcDocumentManagement . $activeLink . ' >Document Management</a>';
                                        } ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Tolar</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a <?php if (in_array($qcSieveManagement, $permissionUrls)) {
                                            echo $qcSieveManagement;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Sieve Management</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcOverview, $permissionUrls)) {
                                            echo $tlQcOverview;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Overview</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcSampleGroupAdd, $permissionUrls)) {
                                            echo $tlQcSampleGroupAdd;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Add Sample Group</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcSamples, $permissionUrls)) {
                                            echo $tlQcSamples;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Sample Database</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcManageSites, $permissionUrls)) {
                                            echo $tlQcManageSites;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Sites</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcManagePlants, $permissionUrls)) {
                                            echo $tlQcManagePlants;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Plants</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcManageLocations, $permissionUrls)) {
                                            echo $tlQcManageLocations;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Locations</a>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcManageSpecificLocations, $permissionUrls)) {
                                            echo '<a ' . $gbQcManageSpecificLocations . $activeLink . ' >Manage Specific Locations</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcManageSpecificLocations, $permissionUrls)) {
                                            echo $tlQcManageSpecificLocations;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Specific Locations</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcSampleEdit, $permissionUrls)) {
                                            echo $tlQcSampleEdit;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Edit Sample</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcSampleView, $permissionUrls)) {
                                            echo $tlQcSampleView;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >View Sample</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcPerformance, $permissionUrls)) {
                                            echo $tlQcPerformance;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Performance</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcThresholdMaint, $permissionUrls)) {
                                            echo $tlQcThresholdMaint;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Threshold Maint.</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($tlQcThresholdEdit, $permissionUrls)) {
                                            echo $tlQcThresholdEdit;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Edit Threshold</a>
                                    </li>
                                    <li>
                                        <?php if (in_array($tlQcDocumentManagement, $permissionUrls)) {
                                            echo '<a ' . $tlQcDocumentManagement . $activeLink . ' >Document Management</a>';
                                        } ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">West Texas</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a <?php if (in_array($qcSieveManagement, $permissionUrls)) {
                                            echo $qcSieveManagement;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Sieve Management</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcOverview, $permissionUrls)) {
                                            echo $wtQcOverview;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Overview</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcSampleGroupAdd, $permissionUrls)) {
                                            echo $wtQcSampleGroupAdd;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Add Sample Group</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcSamples, $permissionUrls)) {
                                            echo $wtQcSamples;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Sample Database</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcManageSites, $permissionUrls)) {
                                            echo $tlQcManageSites;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Sites</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcManagePlants, $permissionUrls)) {
                                            echo $wtQcManagePlants;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Plants</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcManageLocations, $permissionUrls)) {
                                            echo $wtQcManageLocations;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Locations</a>
                                    </li>
                                    <li>
                                        <?php if (in_array($gbQcManageSpecificLocations, $permissionUrls)) {
                                            echo '<a ' . $gbQcManageSpecificLocations . $activeLink . ' >Manage Specific Locations</a>';
                                        } ?>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcManageSpecificLocations, $permissionUrls)) {
                                            echo $wtQcManageSpecificLocations;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Manage Specific Locations</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcSampleEdit, $permissionUrls)) {
                                            echo $wtQcSampleEdit;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Edit Sample</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcSampleView, $permissionUrls)) {
                                            echo $wtQcSampleView;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >View Sample</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcPerformance, $permissionUrls)) {
                                            echo $wtQcPerformance;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Performance</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcThresholdMaint, $permissionUrls)) {
                                            echo $wtQcThresholdMaint;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Threshold Maint.</a>
                                    </li>
                                    <li>
                                        <a <?php if (in_array($wtQcThresholdEdit, $permissionUrls)) {
                                            echo $wtQcThresholdEdit;
                                            echo $activeLink;
                                        } else {
                                            echo $disabledLink;
                                        } ?> >Edit Threshold</a>
                                    </li>
                                    <li>
                                        <?php if (in_array($wtQcDocumentManagement, $permissionUrls)) {
                                            echo '<a ' . $wtQcDocumentManagement . $activeLink . ' >Document Management</a>';
                                        } ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if (in_array($prodGbScorecard, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Production</a>';
                        } ?>
                        <div class="dropdown-menu ">
                            <a <?php if (in_array($prodExecDashboard, $permissionUrls)) {
                                echo $prodExecDashboard;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Executive Dashboard</a>
                            <a <?php if (in_array($prodKpiDash, $permissionUrls)) {
                                echo $prodKpiDash;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >KPI Dashboard</a>
                            <a <?php if (in_array($prodGbScorecard, $permissionUrls)) {
                                echo $prodGbScorecard;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >GB Scorecard</a>
                            <a <?php if (in_array($prodTlScorecard, $permissionUrls)) {
                                echo $prodTlScorecard;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >TL Scorecard</a>
                            <a <?php if (in_array($prodPlantDash, $permissionUrls)) {
                                echo $prodPlantDash;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Plant Dashboard</a>
                            <a <?php if (in_array($prodTceq, $permissionUrls)) {
                                echo $prodTceq;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >TCEQ Report</a>

                            <a <?php if (in_array($prodGbWeatherData, $permissionUrls)) {
                                echo $prodGbWeatherData;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >GB Weather Data</a>
                            <a <?php if (in_array($prodTlWeatherData, $permissionUrls)) {
                                echo $prodTlWeatherData;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >TL Weather Data</a>
                            <a <?php if (in_array($prodWtWeatherData, $permissionUrls)) {
                                echo $prodWtWeatherData;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >WT Weather Data</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if(in_array($loadoutProductTransfers, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Loadout</a>';
                        }?>
                        <div class="dropdown-menu ">
                            <a <?php if (in_array($loadoutProductTransfers, $permissionUrls)) {
                                echo $loadoutProductTransfers;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Transfers</a>
                            <a <?php if (in_array($loadoutReports, $permissionUrls)) {
                                echo $loadoutReports;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Reports</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <?php if(in_array($loadoutProductTransfers, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Logistics</a>';
                        }?>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if(in_array($itMain, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">IT</a>';
                        }?>
                        <div class="dropdown-menu ">
                            <a <?php if (in_array($itMain, $permissionUrls)) {
                                echo $itMain;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >ESP Lane Reports</a>
                            <a <?php if (in_array($itAssetManagement, $permissionUrls)) {
                                echo $itAssetManagement;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Asset Management</a>
                            <a <?php if (in_array($itUsers, $permissionUrls)) {
                                echo $itUsers;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Silicore Users</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if(in_array($accBackOfficeDocs, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Accounting</a>';
                        }?>
                        <div class="dropdown-menu ">
                            <a <?php if (in_array($accBackOfficeDocs, $permissionUrls)) {
                                echo $accBackOfficeDocs;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Back Office Documents</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if(in_array($hrOnBoard, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">HR</a>';
                        }?>
                        <div class="dropdown-menu ">
                            <a <?php if (in_array($hrPreEmploy, $permissionUrls)) {
                                echo $hrPreEmploy;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Pre-employment</a>
                            <a <?php if (in_array($hrOnBoard, $permissionUrls)) {
                                echo $hrOnBoard;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >On Boarding</a>
                            <a <?php if (in_array($hrOffBoard, $permissionUrls)) {
                                echo $hrOffBoard;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Off Boarding</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if(in_array($devMain, $permissionUrls)) {
                            echo '<a class="nav-link dropdown-toggle" href="#" id="prod" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Development</a>';
                        }?>
                        <div class="dropdown-menu ">
                            <a <?php if (in_array($devMain, $permissionUrls)) {
                                echo $devMain;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Examples</a>
                            <a <?php if (in_array($devAnalytics, $permissionUrls)) {
                                echo $devAnalytics;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Analytics Dashboard</a>
                            <a <?php if (in_array($devDeleteLocation, $permissionUrls)) {
                                echo $devDeleteLocation;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Delete Location</a>
                            <a <?php if (in_array($devCodeExamples, $permissionUrls)) {
                                echo $devCodeExamples;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Code Examples</a>
                            <a <?php if (in_array($devTestMail, $permissionUrls)) {
                                echo $devTestMail;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >SendPHPMail()</a>
                            <a <?php if (in_array($devMysqlSproc, $permissionUrls)) {
                                echo $devMysqlSproc;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >MySQL PHP Sproc</a>
                            <a <?php if (in_array($devMssqlSproc, $permissionUrls)) {
                                echo $devMssqlSproc;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >MSSSQL PHP Sproc</a>
                            <a <?php if (in_array($devServerNotes, $permissionUrls)) {
                                echo $devServerNotes;
                                echo $activeLink;
                            } else {
                                echo $disabledLink;
                            } ?> >Server Notes</a>
                        </div>
                    </li>
                    <?php
                    //echo("<button class=\"btn-sm\" id=\"question_mark\" alt=\"tips\" onclick=\"showPageHelp('Help_icon_clicked', '" . $pageValues . "')\"><i class=\"fas fa-question-circle\"></i></button>");


                    if (isset($singleUserObject)) {
                        if ($singleUserObject->vars["username"] !== NULL) //$singleUserObjectdefined in a previous PHP segment)
                        {
                            echo '<li class="nav-item dropdown nav-profile">';
                            echo '<a class="nav-link bg-light dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><span class="badge badge-danger rounded-circle float-right task-alert" style="position: relative;bottom: 8px;right: 6px;"></span>';
                            echo '<i class="fa fa-user"></i> ' . $singleUserObject->vars["username"] . '</a>';
                            echo '<div class="dropdown-menu ">';
                            echo('<a class="nav-link" href="../../Controls/General/profile.php">My Profile</a>');
                            echo('<a class="nav-link" href="../../Controls/General/user_password_reset.php">Change Password</a>');
                            if (array_key_exists('it', $userPermissionsArray['vista']['granbury'])) {
                                if ($userPermissionsArray['vista']['granbury']['it'] > 0) {

                                    echo('<a class="nav-link" href="../../Controls/IT/inventorymanagement.php">Tasks' . ' ' . '<i class="badge badge-danger task-alert rounded-circle"></i></a>');

                                }
                            }
                            echo('<a class="nav-link" href="../../Controls/General/signout.php">Sign Out</a>');

                            echo '</div>';
                            echo '</li>';
                            echo('<span class="nav-item badge bg-white mt-1"><a class="nav-link">Session Timeout: <span id="time">180:00</span></a></span>');
                        } else //if not signed in
                        {
                            echo('<li class="nav-item">');
                            echo('<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseProfile" data-parent="#accordion">');
                            echo('<i class="fa fa-fw fa-user"></i>');
                            echo('<span class="nav-link-text">');
                            echo("Log In");
                            echo('</a></span></a>');
                            echo('<ul class="sidenav-second-level collapse" id="collapseProfile">');
                            echo('<li>');
                            echo('<a  href="#" onclick="showSignIn(\'Sign_in_clicked, ' . $pageValues . '\')">Sign In</a>');
                            echo('</li>');
                            echo('<li>');
                            echo('<a  href="#" onclick="showRegister(\'Register_new_user_clicked, ' . $pageValues . '\')">Register</a>');
                            echo('</li></li></ul>');
                            //echo('<span class="nav-link-text"><div class="alert-light" style="left:0;"><small>Session Timeout:<i><span id="time">180:00</small></span></div></i></span>');
                        }
                    } else //if not signed in
                    {
                        echo('<li class="nav-item">');
                        echo('<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseProfile" data-parent="#accordion">');
                        echo('<i class="fa fa-fw fa-user"></i>');
                        echo('<span class="nav-link-text">');
                        echo("Log In");
                        echo('</a></span></a>');
                        echo('<ul class="sidenav-second-level collapse" id="collapseProfile">');
                        echo('<li>');
                        echo('<a  href="#" onclick="showSignIn(\'Sign_in_clicked, ' . $pageValues . '\')">Sign In</a>');
                        echo('</li>');
                        echo('<li>');
                        echo('<a  href="#" onclick="showRegister(\'Register_new_user_clicked, ' . $pageValues . '\')">Register</a>');
                        echo('</li></li></ul>');

                    }
                    if (isset($_SESSION["signin_error_message"])) {

                        $signin_error_message = filter_var($_SESSION["signin_error_message"], FILTER_SANITIZE_STRING);
                        $signin_wrong_username = filter_var($_SESSION["signin_wrong_username"], FILTER_SANITIZE_STRING);
                        $signin_wrong_password = filter_var($_SESSION["signin_wrong_password"], FILTER_SANITIZE_STRING);

                        echo("<script>"); //Start JavaScript
                        echo("var js_signin_error_message = '" . $signin_error_message . "';");
                        echo("var js_signin_wrong_username = '" . $signin_wrong_username . "';");
                        echo("var js_signin_wrong_password = '" . $signin_wrong_password . "';");

                        echo("console.log('JS is running');");

                        //on page load (wait until all the other code runs)
                        echo("window.onload = function()");
                        echo("{");
                        echo("console.log(js_signin_error_message);");
                        echo("console.log(js_signin_wrong_username);");
                        echo("console.log(js_signin_wrong_password);");

                        //unhide the modal window
                        echo("var modal = document.getElementById('id01');");
                        echo("modal.style.display = 'block';");

                        //add the error message to the modal window using javascript
                        echo("document.getElementById('error_message_text').innerHTML = '" . $signin_error_message . "';");

                        //add the username and password entries to the modal window using javascript
                        echo("document.getElementById('username_input').value = '" . $signin_wrong_username . "';");
                        echo("document.getElementById('password_input').value = '" . $signin_wrong_password . "';");
                        echo("};");
                        echo("</script>"); //end the JavaScript
                        unset($_SESSION["signin_error_message"]);
                        unset($_SESSION["signin_wrong_username"]);
                        unset($_SESSION["signin_wrong_password"]);
                    }
                    //if the user is required to reset their password
                    if (isset($_SESSION["signin_password_reset"])) {
                        if ($_SESSION["signin_password_reset"] == true) {
                            //display the sign in password modal window
                            echo("<script>"); //Start JavaScript
                            echo("window.onload = function()"); //wait until the window loads to run it
                            echo("{");
                            echo("alert('password reset function called');");

                            //unhide the password modal window
                            echo("var passwordModal = document.getElementById('id03');");
                            echo("passwordModal.style.display = 'block';");
                            echo("startValidating();"); //call the startValidating function from /Includes/general.js
                            echo("};");
                            echo("</script>"); //end the JavaScript
                        }
                    }
                    if (isset($_SESSION["password_reset_message"])) {
                        $password_reset_message_text = filter_var($_SESSION["password_reset_message"], FILTER_SANITIZE_STRING);

                        //display the sign in password modal window
                        echo("<script>"); //Start JavaScript
                        echo("window.onload = function()"); //wait until the window loads to run it
                        echo("{");
                        echo("alert('password reset function called');");

                        //unhide the password modal window
                        echo("var passwordModal = document.getElementById('id04');");
                        echo("passwordModal.style.display = 'block';");

                        echo("document.getElementById('password_reset_result_text').innerHTML = '" . $password_reset_message_text . "';");
                        echo("};");

                        echo("</script>"); //end the JavaScript
                        unset($_SESSION["password_reset_message"]);
                    }


                    ?>
                </ul>
            </div>
    </nav>
<div class="container-fluid mt-5 bg-light content-wrapper">
    <script defer>
        $(function () {
            $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');
                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });
                return false;
            });

            <?php
            if ($ServerSubDomain !== 'silicore-dev') {
                if (array_key_exists('it', $userPermissionsArray['vista']['granbury'])) {
                    if ($userPermissionsArray['vista']['granbury']['it'] > 0) {
                        echo('$(document).ready(function(){updateAlerts();});');
                    }
                }
            }
            ?>
            function updateAlerts() {
                setInterval(function () {
                    $.ajax({
                        url: '../../Includes/Templates/alerts.php',
                        dataSrc: '',
                        success: function (response) {
                            let requests = JSON.parse(response);
                            let request_number = requests[0].incomplete_requests;
                            if (request_number > 0) {
                                $('.task-alert').text(request_number);
                            }
                        }
                    });
                }, 1000);
            }

            $('#nav-icon').click(function () {
                $(this).toggleClass('open');
            });

        });
    </script>
<?php } ?>