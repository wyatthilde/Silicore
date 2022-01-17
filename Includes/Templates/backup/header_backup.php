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
 * 05/11/2018|mnutsch|KACE:20174 - Changed placeholder in user registration to say 'not email'.
 * 05/25/2018|mnutsch|KACE:20174 - Added a 10 minute time out for page loads.
 ********************************************************************************************************************************************/

//==================================================================== BEGIN PHP

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

//display information if we are in debugging mode
if($debugging == 1)
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

//set the browser timeout to 10 minutes
set_time_limit(600);

// Start the session
if (session_status() == PHP_SESSION_NONE) 
{
  session_start();
}

//====================================================================== END PHP

?>

<!-- HTML -->
<!DOCTYPE html>
<html>
  <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>
<?php echo($SiteTitle);?>
    </title>	
    
    <script type="text/javascript" src="../../Includes/general.js"></script> 
    <script type="text/javascript" src="../../Includes/security.js"></script> <!-- includes JavaScript functionality for sign in, and other header processes. -->
    <script type="text/javascript" src="../../Includes/navigation.js"></script> <!-- includes JavaScript functionality for the navigation menu. -->
	
    <script type="text/javascript" src="../../Includes/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
    <script type="text/javascript" src="../../Includes/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

    <script src="../../Includes/zxcvbn.js"></script> <!-- includes JavaScript functionality for password strength validation. -->
	
    <script src="../../Includes/webanalytics.js"></script> <!-- includes JavaScript functionality for website analytics. -->
    <script type='text/javascript' src='../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js'></script>
    
    <link type="text/css" rel="stylesheet" href="../../Includes/stylecommon.css"> <!-- includes styles for the CSS sign in/sign out modal dialogue box. -->
    <link type="text/css" rel="stylesheet" href="../../Includes/stylestructure_backup.css">
    <link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/jquery-ui.css">
    
    <link rel="shortcut icon" type="image/x-icon" href="../../logo-favicon.ico">
	
    <script>

    function startTimer(duration, display) 
    {
      var timer = duration, minutes, seconds;
      setInterval(function () 
      {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) 
        {
          window.location = "../../Controls/General/signout.php";
        }
      }, 1000);
    }

    window.onload = function () 
    { 
      //alert("into onload function");
      var countdownTime = 60 * 60 * 3;
      display = document.querySelector('#time');
      startTimer(countdownTime, display);
    //}; //this is commented out because the PHP code below adds JavaScript to the onload() function

<?php
  //send the page information to the web analytics tool

  //create the page_values to send
  $a = array();
  $a["UserID"] = $user_id; //requires pagevariables.php
  $a["PageName"] = $PageName; //requires pagevariables.php
  $a["PageDept"] = $PageDept; //requires pagevariables.php
  $a["UserIP"] = $UserIP; //requires pagevariables.php
  $pageValues = json_encode($a);

  //call the web analytics function when the page loads
  //echo("window.onload = function()" . //this is commented out, because the onload() function is already opened in the javascript code above
  //"{" .
  //
	//requires webanalytics.js (for addPageTracking) and pagevariables.php (for FullPath)
  // Note: The following line includes the closing brace for the window.onload function declared in javascript above
  echo("  addPageTracking(987654321, '" . $FullPath . "', '" . $pageValues . "'); }");

      $pageValues = htmlentities( $pageValues , ENT_QUOTES, "UTF-8"); //this converts " to &quot; for use later in the code
?>
	
    </script>
	
  </head>
  
</html>

<body>

<div class="header_wrapper">
  <div class="header_image">
<?php      
  if($user_id != "") //if the user is signed in, requires pagevariables.php to run first
  {
    $singleUserObject = getUser($user_id); //get the user's info from the database
    
    if($singleUserObject->vars["company"] == "Vista Sand") //if the user is a Vista Sand employee
    {
      echo '<img src="../../../Images/vprop_logo_minborder.png" alt="Vista Proppants and Logistics" height="50">'; //output the Vista Sand logo
    }
    elseif($singleUserObject->vars["company"] == "Maalt") //if the user is a Maalt employee
    {
      echo '<img src="../../../Images/vprop_logo_minborder.png" alt="Vista Proppants and Logistics" height="50">'; //output the Maalt LP logo
    }
    else //if user is signed in, but the company is not one of the above
    {
      echo '<img src="../../../Images/vprop_logo_minborder.png" alt="Vista Proppants and Logistics" height="50">'; //output the Vista Sand logo
    }
  }
  else //if the user is not signed in
  {
    echo '<img src="../../../Images/vprop_logo_minborder.png" alt="Vista Proppants and Logistics" height="50">'; //output the Vista Sand logo
  }
?>
  </div>
  <div class="header_text">
    <div class="site_name">
<?php echo($SiteTitle) ?>
    </div>
    <div class="site_version">
<?php echo($SiteBuildType . " " . $SiteBuild) ?>
    </div>
  </div>
  <div class="sign_in_out">
<?php

echo("<div class=\"sign_in_block\">");

if($UserIP) //requires pagevariables.php
{
  echo($UserIP); //requires pagevariables.php
  echo(" | ");
}

if(isset($singleUserObject))
{
  if($singleUserObject->vars["company"]) //$singleUserObject defined in the previous PHP segment
  {
    echo($singleUserObject->vars["company"]); //$singleUserObject defined in the previous PHP segment
    echo(" | ");
  }
}

echo("> "); //user icon image

if(isset($singleUserObject))
{
  if($singleUserObject->vars["username"]) //$singleUserObjectdefined in a previous PHP segment)
  {
    echo("<div class=\"dropdown\">");
    echo("<span class=\"dropbtn\">");
    echo($singleUserObject->vars["username"]);
    echo("&#x25BE;"); //down arrow
    echo("</span>"); //dropbtn
    echo("<div class=\"dropdown-content\">" .
        "" .
        ">Sign Out</a>" .
    "</div>"); //dropdown-content
    echo("</div>"); //dropdown class
//    
//    echo("
//      <div class=\"dropdown\">
//        <span class=\"dropbtn\">
//          {$singleUserObject->vars["username"]}
//          &#x25BE; <! down arrow !>
//        </span> <! dropbtn !>
//        <div class=\"dropdown-content\">
//          <a href=\"../../Controls/General/profile.php\">My Profile</a>
//          <a href=\"../../Controls/General/signout.php\">Sign Out</a>
//        </div> <! dropdown-content !>
//      </div>
//    ");
  }
  else //if not signed in
  {
    echo("<div class=\"dropdown\">");
    echo("<span class=\"dropbtn\" onclick=\"showSignIn('Sign_in_clicked', '" . $pageValues . "')\">");
    echo("Sign In");
    echo("&#x25BE;"); //down arrow
    echo("</span>"); //dropbtn
    echo("<div class=\"dropdown-content\">" .
      "<a href=\"#\" onclick=\"showSignIn('Sign_in_clicked', '" . $pageValues . "')\">Sign In</a>" .
      "<a href=\"#\" onclick=\"showRegister('Register_new_user_clicked', '" . $pageValues . "')\">Register</a>" .
    "</div>"); //dropdown-content
    echo("</div>"); //dropdown class
  }
}
else //if not signed in
{
  echo("<div class=\"dropdown\">");
  echo("<span class=\"dropbtn\" onclick=\"showSignIn('Sign_in_clicked', '" . $pageValues . "')\">");
  echo("Sign In");
  echo("&#x25BE;"); //down arrow
  echo("</span>"); //dropbtn
  echo("<div class=\"dropdown-content\">" .
    "<a href=\"#\" onclick=\"showSignIn('Sign_in_clicked', '" . $pageValues . "')\">Sign In</a>" .
    "<a href=\"#\" onclick=\"showRegister('Register_new_user_clicked', '" . $pageValues . "')\">Register</a>" .
  "</div>"); //dropdown-content
  echo("</div>"); //dropdown class
}
  
echo(" ");

//send action information to the web analytics tool when the user clicks on the help icon
//$pageValues is defined earlier in header.php
//$pageValues has " converted to &quot; earlier in the code
//render the icon, onclick then pass the parameters in JavaScript
echo("<img src=\"../../Images/question_mark.png\" class=\"question_mark\" id=\"question_mark\" alt=\"tips\" "
        . "onmouseover=\"questionMarkHover()\" onclick=\"showPageHelp('Help_icon_clicked', '" . $pageValues . "')\"> "); //user icon image
echo("<img src=\"../../Images/question_mark_highlight.png\" class=\"question_mark_highlight\" id=\"question_mark_highlight\" alt=\"tips\" "
        . "onmouseout=\"questionMarkMouseOut()\" onclick=\"showPageHelp('Help_icon_clicked', '" . $pageValues . "')\"> "); //user icon image highlighted

echo("</div>"); //sign_in_block

/*
//This section contains code for using buttons to sign in, sign out, and register. This was replaced with a drop down menu.
//If the user is already signed in according to a session variable
if(isset($_SESSION["user_id"])) 
{	
  //then show them the sign out button
  echo("<button class=\"sign_out_button\" onclick=\"document.location.href='../../Controls/General/signout.php'\" style=\"width:auto;\">Sign Out</button>");
}
else
{
  //otherwise show them the register and sign in button
  echo("<button class=\"register_button\" onclick=\"document.getElementById('id05').style.display='block'\" style=\"width:auto;\">Register</button>");
  echo("<button class=\"sign_in_button\" onclick=\"document.getElementById('id01').style.display='block'\" style=\"width:auto;\">Sign In</button>");
}
*/

//if the user tried to sign in and there was an error
if (isset($_SESSION["signin_error_message"])) 
{
  //get the signin error message
  $signin_error_message = filter_var($_SESSION["signin_error_message"], FILTER_SANITIZE_STRING);
  //get the session variables for error messages
  
  //get the username and password that the user tried
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
  
  //unset the error message session variables so they don't accidentally show up again
  unset($_SESSION["signin_error_message"]);
  unset($_SESSION["signin_wrong_username"]);
  unset($_SESSION["signin_wrong_password"]);
  
}

//if the user is required to reset their password
if (isset($_SESSION["signin_password_reset"])) 
{
  if($_SESSION["signin_password_reset"] == true)
  {
    //display the sign in password modal window
    echo("<script>"); //Start JavaScript
    echo("window.onload = function()"); //wait until the window loads to run it
    echo("{");
      //echo("alert('password reset function called');";
      
      //unhide the password modal window
      echo("var passwordModal = document.getElementById('id03');");
      echo("passwordModal.style.display = 'block';");
	  echo("startValidating();"); //call the startValidating function from /Includes/general.js
      
    echo("};");
  
    echo("</script>"); //end the JavaScript
    
  }

}

//if the user is required to reset their password
if (isset($_SESSION["password_reset_message"])) 
{
	$password_reset_message_text = filter_var($_SESSION["password_reset_message"], FILTER_SANITIZE_STRING);
    
	//display the sign in password modal window
    echo("<script>"); //Start JavaScript
    echo("window.onload = function()"); //wait until the window loads to run it
    echo("{");
      //echo("alert('password reset function called');";
      
      //unhide the password modal window
      echo("var passwordModal = document.getElementById('id04');");
      echo("passwordModal.style.display = 'block';");
      
      echo("document.getElementById('password_reset_result_text').innerHTML = '" . $password_reset_message_text . "';");
    echo("};");
  
    echo("</script>"); //end the JavaScript
	unset($_SESSION["password_reset_message"]);
}
?>
  </div> <!-- sign in out -->
</div> <!-- header wrapper -->
<div class="sub_header">
  <div class="sub_header_content">
  <div class="sub_header_text_left">
<?php
if(isset($_SESSION["user_id"])) //if the user is signed in
{
  $userEditAuthorized = checkEditPermission($PageDept, $PageName, $user_id);
  if($userEditAuthorized == 1)
  {
    echo '<strong><a href="../../Controls/Development/editpage.php?pagedept=' . $PageDept . '&pagename=' .
            $PageName . '">Edit Page<a/></strong>';  //display the edit page link
  }
}

?>
  </div>
   <!-- DEV NOTE: commented out 4-6-2017 while notifications design is clarified -->
   <!-- <div class="notifications_icon" onclick="showAlerts();">
      <img id="notification_bell" src="../../Images/notifications_bell.png" alt="Notifications"> 
<?php
/*
//DEV NOTE: commented out 4-6-2017 while notifications design is clarified

if(isset($_SESSION["user_id"])) //if the user is signed in
{
  
  //DEV NOTE: add code to check if the user has notfications, hide if not.
  //DEV NOTE: add code to insert a dynamic notification count value based on a count from the database
  echo("<p id=\"notification_count\">99</p>"; //then display the unread notifications count
  
}
else //otherwise
{
  echo("<p id=\"notification_count\" style=\"display: none;\">99</p>"; //do not display the unread notifications count
}
*/	  
?>
	</div>--> <!-- notifications icon -->
	<div class="sub_header_text_right">
<?php 
echo("Session Timeout: <span id=\"time\">180:00</span>");
?>
    </div> <!-- sub header text -->
  </div> <!-- sub header content -->
</div> <!-- sub header -->


<!-- This div is normally hidden. It appears when the Sign In button is clicked. -->
<div id="id01" class="modal">

  <form class="modal-content animate" method="post" action="../../Controls/General/signin.php">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <!-- uncomment this code to add an image on the sign in form -->
      <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username (not email)" name="user_name" id="username_input" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" id="password_input" required>

              <p id="error_message_text" style="color: red;"></p>

      <button type="submit">Login</button>
      <input type="checkbox" checked="checked" name="remember_me"> Remember me
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
<?php
      echo("<span class=\"psw\"><a href=\"#\" onclick=\"showForgotPassword('Forgot_Password_clicked', '" .
              $pageValues . "')\">Forgot or Change Password</a></span>");
?>
    </div>
  </form>
</div>

<!-- This div is normally hidden. It appears when the Forgot Password button is clicked. -->
<div id="id02" class="modal">

  <form class="modal-content animate" method="post" action="../../Controls/General/securityforgotpassword.php">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <!-- uncomment this code to add an image on the form -->
      <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->
    </div>

    <div class="container" id="password_reset_email_address_content">
      <label><b>Email Address</b></label>
      <input type="email" placeholder="Enter Your Email Address" name="email_address_input" id="email_address_input" required>

      <p id="error_message_text" style="color: red;"></p>

      <button type="submit">Reset Password</button>

    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<!-- This div is normally hidden. It appears when the Reset Password process is initiated. -->
<div id="id03" class="modal">

  <form class="modal-content animate" name="password_reset_form" method="post" action="../../Controls/General/securityresetpassword.php" onsubmit="return validateForm()">
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
      <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Enter Password Again" required><br/>

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

  <form class="modal-content animate" name="forgot_password_message" onsubmit="document.getElementById('id04').style.display='none';">
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
<div id="id05" class="modal">

  <form class="modal-content animate" method="post" action="../../Controls/General/newuseraccountrequest.php">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
      <!-- uncomment this code to add an image on the form -->
      <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->
      <h2>New User</h2>
    </div>

    <div class="container" id="password_reset_email_address_content">

      <!-- first name -->
      <label><b>First Name</b></label>
      <input type="text" placeholder="Enter Your First Name" name="first_name" id="first_name" required>

      <!-- last name -->
      <label><b>Last Name</b></label>
      <input type="text" placeholder="Enter Your Last Name" name="last_name" id="last_name" required>

      <!-- email address -->
      <label><b>Email Address</b></label>
      <input type="email" placeholder="Enter Your Email Address" name="email_address" id="email_address" required>

      <!-- company -->
      <label><b>Company</b></label>
      <select name="company" id="company" required>
        <option value="Vista Sand">Vista Sand</option>
        <option value="Maalt">Maalt LP</option>
        <option value="Rycut">Rycut Construction</option>
        <option value="Texplex">TexPlex Park</option>
        <option value="Blaine Stone">Blaine Stone Lodge</option>
      </select>
          
      <!-- department -->
      <label><b>Department</b></label>
      <select name="department" id="department" required>
      <?php
        $departmentObjectArray = getDepartments(); //get a list of site options
        foreach ($departmentObjectArray as $departmentObject) 
        {
          echo("<option value='" . $departmentObject->vars["id"] . "'>" . $departmentObject->vars["name"] . "</option>");
        }
      ?>
      </select>
      
      <!-- access level -->
      <label><b>Access Level</b></label>
      <select name="accessLevel" id="accessLevel" required>
      <?php
        $userTypeObjectArray = getUserTypes(); //get a list of site options
        foreach ($userTypeObjectArray as $userTypeObject) 
        {
          echo("<option value='" . $userTypeObject->vars["id"] . "'>" . $userTypeObject->vars["name"] . "</option>");
        }
      ?>
      </select>
      
      <p id="error_message_text" style="color: red;"></p>

      <button type="submit">Request Account</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id05').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<!-- This div is normally hidden. It appears when the tooltop button is clicked. -->
<div id="id06" class="modal">

  <form class="modal-content animate" name="help_box" onsubmit="document.getElementById('id06').style.display='none';">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id06').style.display='none';" class="close" title="Close Modal">&times;</span>
      <!-- uncomment this code to add an image on the form -->
      <!-- <img src="vista-logo.png" alt="logo" class="logo"> -->
      
    </div>

    <div class="container" id="help_box_content">
      
      <strong><p>Help For This Page:</p></strong>
      <p id="help_box_text">
<?php
//echo("PageName: " . $PageName . "<br/>"; //requires pagevariables
//echo("PageDept: " . $PageDept . "<br/>"; //requires pagevariables
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