<?php
/*********************************************************************************************************************************************
 * File Name: header.php
 * Project: Silicore
 * Description: Main header page for the default Silicore site.
 * Notes: This page will include any metadata, tags, etc., as well as any global content and functionality that needs to happen above the
 *        navigation and specific content pages.
 * ==========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * ==========================================================================================================================================
 * 06/20/2017|kkuehn|KACE:10499 - Initial creation
 * ??/??/2017|mnutsch|KACE:N/A - Multiple edits, add security, navigation and miscellaneous functionality
 * 08/17/2017|kkuehn|KACE:10499 - Added display functionality for site title and build
 * 08/25/2017|nolliff|KACE:18251 - Changed functions to reflect code conventions
 * 08/31/2017|nolliff|KACE:18394 - Added tabesort to header
 * 01/10/2018|mnutsch|KACE:20174 - Added a 10 minute time out for page loads.
 *
 ********************************************************************************************************************************************/

//==================================================================== BEGIN PHP


//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

//display information if we are in debugging mode
if ($debugging == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
}

//set the browser timeout to 10 minutes
set_time_limit(600);

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['user_agent'] = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER['HTTP_USER_AGENT']);
?>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php echo($SiteTitle); ?>
    </title>
    <!-- <script type='text/javascript' src='../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js'></script>
     <script type="text/javascript" src="../../Includes/general.js"></script>
         <script src="../../Includes/zxcvbn.js"></script>
     <script src="../../Includes/webanalytics.js"></script>
     <script type="text/javascript" src="../../Includes/jquery-ui-1.12.1.custom"></script>
     <link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/jquery-ui.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../../Includes/security.js"></script>

    <link href="../../Includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../../Includes/css/sb-admin.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="../../Includes/stylecommon.css">
    <link type="text/css" rel="stylesheet" href="../../Includes/stylestructure.css">

    <link rel="shortcut icon" type="image/x-icon" href="../../logo-favicon.ico">


    <script src="../../Includes/vendor/jquery/jquery.min.js"></script>

    <script>

        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    window.location = "../../Controls/General/signout.php";
                }
            }, 1000);
        }

        window.onload = function () {
            //alert("into onload function");
            var countdownTime = 60 * 60 * 3;
            var display = document.querySelector('#time');
            startTimer(countdownTime, display);
        //}; //this is commented out because the PHP code below adds JavaScript to the onload() function

        <?php
        //send the page information to the web analytics tool

        //create the page_values to send
        $a = array();
        $a["UserID"] = $user_id; //requires pagevariables.php
        $a["PageName"] = $PageName; //requires pagevariables.php
        $a["PageDept"] = $PageDept; //requires pagevariables.php
        //$a["UserIP"] = $UserIP; //requires pagevariables.php
        $pageValues = json_encode($a);

        //call the web analytics function when the page loads
        //echo("window.onload = function()" . //this is commented out, because the onload() function is already opened in the javascript code above
        //"{" .
        //
        //requires webanalytics.js (for addPageTracking) and pagevariables.php (for FullPath)
        // Note: The following line includes the closing brace for the window.onload function declared in javascript above
        echo("}");

        $pageValues = htmlentities($pageValues, ENT_QUOTES, "UTF-8"); //this converts " to &quot; for use later in the code
        ?>

    </script>
    <style>
        .label-align {
            width:125px;
        }
    </style>



<!-- This div is normally hidden. It appears when the Sign In button is clicked. -->
<div id="id01" class="modal" tabindex="-1" role="dialog">
    <div class="container animate">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login
                <button type="button" class="close" onclick="document.getElementById('id01').style.display='none'"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <form method="post" action="../../Controls/General/signin.php">
                    <div class="form-group">
                        <label><b>Username</b></label>
                        <input class="form-control" type="text" placeholder="Enter Username (not email)" name="user_name" id="username_input" required>
                    </div>
                    <div class="form-group">
                        <label><b>Password</b></label>
                        <input class="form-control" type="password" placeholder="Enter Password" name="password"
                               id="password_input" required>
                        <p id="error_message_text" style="color: red;"></p>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" checked="checked" name="remember_me">
                                Remember me</label>
                        </div>
                    </div>
                    <button class="btn btn-success btn-block" type="submit">Login</button>
                </form>
                <div class="text-center">
                    <button class="btn btn-info btn-block" data-toggle="modal" data-target="#id05"
                            onclick="document.getElementById('id01').style.display='none'">Register an Account
                    </button>
                    <?php
                    echo("<a class=\"d-block small\"><a href=\"#\" onclick=\"showForgotPassword('Forgot_Password_clicked', '" .
                        $pageValues . "')\">Forgot password?</a></a>");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- This div is normally hidden. It appears when the Forgot Password button is clicked. -->
<div id="id02" class="modal">

    <form class="modal-content animate" method="post" action="../../Controls/General/securityforgotpassword.php">
        <div class="modal-header"><h4>Forgot Password</h4></div>

        <div class="container" id="password_reset_email_address_content">
            <input type="email" placeholder="Enter Your Email Address" name="email_address_input"
                   id="email_address_input" class="form-control" required>
            <p id="error_message_text" style="color: red;"></p>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="btn btn-basic float-left">
                Cancel
            </button>
            <button class="btn btn-vprop-green float-right" type="submit">Reset Password</button>
        </div>
    </form>
</div>

<!-- This div is normally hidden. It appears when the Reset Password process is initiated. -->
<div id="id03" class="modal">

    <form class="modal-content animate" name="password_reset_form" method="post"
          action="../../Controls/General/securityresetpassword.php" onsubmit="return validateForm()">
        <div class="imgcontainer">
            <!--<span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>-->
            <!-- uncomment this code to add an image on the form -->
            <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->
            <h2>Password reset</h2>
        </div>

        <div class="container" id="password_reset_form_content">
            <label for="password">Enter password</label><br/>
            <input type="password" id="password" name="password" placeholder="Enter Password" required><br/>

            <meter max="4" id="password-strength-meter"></meter>
            <p id="password-strength-text"></p>

            <label for="passwordConfirm">Confirm password</label><br/>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Enter Password Again"
                   required><br/>

            <meter max="4" id="passwordConfirm-strength-meter"></meter>
            <p id="passwordConfirm-strength-text"></p>

            <p id="password_reset_error_text" style="color: red;"></p>

            <button type="submit" id="passwordSubmit">Submit</button>

        </div>

        <div class="container" style="background-color:#f1f1f1">

            <!--<button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>-->
        </div>
    </form>
</div>

<!-- This div is normally hidden. It appears when the Forgot Password message is set. -->
<div id="id04" class="modal">

    <form class="modal-content animate" name="forgot_password_message"
          onsubmit="document.getElementById('id04').style.display='none';">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id04').style.display='none';" class="close" title="Close Modal">&times;</span>
            <!-- uncomment this code to add an image on the form -->
            <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->

        </div>

        <div class="container" id="password_reset_form_content">

            <strong><p>Message:</p></strong>
            <p id="password_reset_result_text"></p>

            <button onsubmit="document.getElementById('id04').style.display='none';">OK</button>

        </div>

        <div class="container" style="background-color:#f1f1f1">

            <!--<button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>-->
        </div>
    </form>
</div>

<!-- This div is normally hidden. It appears when the Request New Account button is clicked. -->
<div id="id05" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register an Account</h5>
                <button type="button" class="btn close" onclick="document.getElementById('id05').style.display='none'" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" method="post" action="../../Controls/General/newuseraccountrequest.php">
            <div class="modal-body">

                    <div id="password_reset_email_address_content">
                        <!-- first name -->
                        <div class="form-group col-xl">
                            <div class="input-group">
                                <input type="text" class="form-control border-right-0" name="first_name" id="first_name" placeholder="First Name" required>
                                <div class="input-group-append">
                                    <span class="input-group-text border-left-0 bg-white"><i class="fa fw fa-user text-secondary"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- last name -->
                        <div class="form-group col-xl">
                            <div class="input-group">
                                <input type="text" class="form-control border-right-0" name="last_name" id="last_name" placeholder="Last Name" required>
                                <div class="input-group-append">
                                    <span class="input-group-text border-left-0 bg-white"><i class="fa fw fa-user text-secondary"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- email address -->
                        <div class="form-group col-xl">
                            <div class="input-group">
                                <input type="text" class="form-control border-right-0" name="email_address" id="email_address" placeholder="Email" required>
                                <div class="input-group-append">
                                    <span class="input-group-text border-left-0 bg-white"><i class="fa fw fa-envelope text-secondary"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- company -->
                        <div class="form-group col-xl">
                            <div class="input-group">
                                <select name="company" class="form-control border-right-0" id="company" required>
                                    <option value="Vista Sand">Vista Sand</option>
                                    <option value="Maalt">Maalt LP</option>
                                    <option value="Rycut">Rycut Construction</option>
                                    <option value="Texplex">TexPlex Park</option>
                                    <option value="Blaine Stone">Blaine Stone Lodge</option>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text border-left-0 bg-white"><i class="fa fw fa-map-marker text-secondary"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- department -->
                        <div class="form-group col-xl">
                            <div class="input-group">
                                <select name="department" class="form-control border-right-0" id="department" required>
                                  <?php
                                  $departmentObjectArray = getDepartments(); //get a list of site options
                                  foreach ($departmentObjectArray as $departmentObject)
                                    {
                                    if($departmentObject->vars["is_active"] == 1)
                                      {
                                        echo("<option value='" . $departmentObject->vars["id"] . "'>" . $departmentObject->vars["name"] . "</option>");
                                      }
                                    }
                                  ?>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text border-left-0 bg-white"><i class="fa fw fa-building text-secondary"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- access level -->
                        <div class="form-group col-xl">
                            <div class="input-group">
                                <select name="accessLevel" class="form-control border-right-0" id="accessLevel" required>
                                    <?php
                                    $userTypeObjectArray = getUserTypes(); //get a list of site options
                                    foreach ($userTypeObjectArray as $userTypeObject) {
                                        echo("<option value='" . $userTypeObject->vars["id"] . "'>" . $userTypeObject->vars["name"] . "</option>");
                                    }
                                    ?>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text border-left-0 bg-white"><i class="fa fw fa-lock text-secondary"></i></span>
                                </div>
                            </div>
                            </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-vprop-green">Request Account</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- This div is normally hidden. It appears when the tooltop button is clicked. -->
<div id="id06" class="modal">

    <form class="modal-content animate" name="help_box"
          onsubmit="document.getElementById('id06').style.display='none';">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id06').style.display='none';" class="close" title="Close Modal">&times;</span>
            <!-- uncomment this code to add an image on the form -->
            <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->

        </div>

        <div class="container" id="help_box_content">

            <strong><p>Help For This Page:</p></strong>
            <p id="help_box_text">
                <?php

                echo getHelpText($PageName, $PageDept); //requires pagevariables and security.php
                ?>
            </p>

            <button onclick="document.getElementById('id06').style.display='none';" type="button">OK</button>

        </div>

        <div class="container" style="background-color:#f1f1f1">

            <!--<button type="button" onclick="document.getElementById('id06').style.display='none'" class="cancelbtn">Cancel</button>-->
        </div>
    </form>
</div>