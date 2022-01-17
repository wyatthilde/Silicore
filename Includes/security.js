/* * *****************************************************************************
 * File Name: security.js
 * Project: Sandbox
 * Author: mnutsch
 * Edited 4-11-2017
 * Description: This file contains Javascript code related to the header and sign in process.
 * Notes: 
 * **************************************************************************** */
 
 
/**************************************************************************
* Name: sign in form javascript
* Author: Matt Nutsch
* Description: This code handles sign in related functions.
* Notes: Based in part sample code at: 
* https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_login_form_modal
**************************************************************************/
// Get the modal
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');
var modal5 = document.getElementById('id05');
var modal6 = document.getElementById('id06');

// When the user clicks anywhere outside of the modal, close it
//window.onclick = function(event) 
//{
//    //console.log("window click detected");
//    //console.log(event.target.id);
//    if (event.target.id == 'id01') 
//    {
//        //console.log("event target modal1");
//        var modal1 = document.getElementById('id01');
//        modal1.style.display = "none";
//    }
//    
//    if (event.target.id == 'id02') 
//    {
//        //console.log("event target modal2");
//        var modal2 = document.getElementById('id02');
//        modal2.style.display = "none";
//    }
//    
//    if (event.target.id == 'id05') 
//    {
//        //console.log("event target modal5");
//        var modal5 = document.getElementById('id05');
//        modal5.style.display = "none";
//    }
//	
//	if (event.target.id == 'id06') 
//    {
//        //console.log("event target modal6");
//        var modal6 = document.getElementById('id06');
//        modal6.style.display = "none";
//    }
//}

/**************************************************************************
* Name: password reset form javascript
* Author: Matt Nutsch
* Date: 3-16-2017
* Description: This code handles password validation functionality.
* Notes: Based in part on sample code at: 
* https://css-tricks.com/password-strength-meter/
**************************************************************************/
function startValidating()
{ 

	var strength = 
	{
	  0: "Worst",
	  1: "Poor",
	  2: "Weak",
	  3: "Good",
	  4: "Strong"
	}

	var password = document.getElementById('password');
	var meter = document.getElementById('password-strength-meter');
	var text = document.getElementById('password-strength-text');
	var debugtext = document.getElementById('debug-password-strength-text');

	var passwordConfirm = document.getElementById('passwordConfirm');
	var meterConfirm = document.getElementById('passwordConfirm-strength-meter');
	var textConfirm = document.getElementById('passwordConfirm-strength-text');

	password.addEventListener('input', function() 
	{
	  //console.log("password change detected");  
	  var val = password.value;
	  var result = zxcvbn(val);
	  
	  // Update the password strength meter
	  meter.value = result.score;

	  // Update the password strength text indicator
	  if (val !== "") 
	  {
		text.innerHTML = "Strength: " + strength[result.score]; 
	  } 
	  else 
	  {
		text.innerHTML = "";
	  }
	  
	  
	  //Update the password match meter
	  var val1 = passwordConfirm.value;
	  var val2 = password.value;
	  
	  //console.log("val1 = " + val1);
	  //console.log("val2 = " + val2);
	  // Update the password match text indicator
	  if (val1 == val2) 
	  {
		meterConfirm.value = 4; // Update the password strength meter
		textConfirm.innerHTML = "Passwords match!"; 
	  } 
	  else 
	  {
		meterConfirm.value = 0;
		textConfirm.innerHTML = "Passwords do not match!";
	  }
	  
	});

	passwordConfirm.addEventListener('input', function() 
	{
	  var val1 = passwordConfirm.value;
	  var val2 = password.value;
	  
	  // Update the text indicator
	  if (val1 == val2) 
	  {
		meterConfirm.value = 4; // Update the password strength meter
		textConfirm.innerHTML = "Passwords match!"; 
	  } 
	  else 
	  {
		meterConfirm.value = 0;
		textConfirm.innerHTML = "Passwords do not match!";
	  }
	});

}

function validateForm() 
{
    console.log("Form validation in progress,");
    console.log("password 1 = " + password.value);
    console.log("password 2 = " + passwordConfirm.value);
    
    if (password.value != passwordConfirm.value) 
    {
        document.getElementById('password_reset_error_text').innerHTML = "Passwords must match.";
        return false;
    }
    
    if (password.value == "") 
    {
        document.getElementById('password_reset_error_text').innerHTML = "You must enter a password.";
        return false;
    }
    
    if (passwordConfirm.value == "") 
    {
        document.getElementById('password_reset_error_text').innerHTML = "You must reenter the password.";
        return false;
    }
}

/**************************************************************************
* Name: changing tooltip question mark on hover and mouseout
* Author: Matt Nutsch
* Date: 4-3-2017
* Description: This code swaps the tooltip icon on hover and mouseout
**************************************************************************/
function questionMarkHover() 
{
	var questionMark = document.getElementById("question_mark");
	var questionMarkHighlight = document.getElementById("question_mark_highlight");
	questionMark.style.visibility = "hidden";
	questionMarkHighlight.style.visibility = "visible";
	
}

function questionMarkMouseOut()
{
	var questionMark = document.getElementById("question_mark");
	var questionMarkHighlight = document.getElementById("question_mark_highlight");
	questionMark.style.visibility = "visible";
	questionMarkHighlight.style.visibility = "hidden";
	
}

/**************************************************************************
* Name: record analytics when modal windows are opened
* Author: Matt Nutsch
* Date: 4-7-2017
* Description: This code displays the page specific help text, while also 
* documenting the call in the web analytics tool.
**************************************************************************/
function showSignIn(action_name, action_values)
{
	//alert("The user clicked on show sign in.");
	document.getElementById('id01').style.display='block';
	addActionTracking(987654321, action_name, action_values); //requires webanalytics.js, which is included by header.php		
}

function showForgotPassword(action_name, action_values)
{
	//alert("The user clicked on show forgot password.");
	document.getElementById('id01').style.display='none';
	document.getElementById('id02').style.display='block';
	addActionTracking(987654321, action_name, action_values); //requires webanalytics.js, which is included by header.php		
}

function showRegister(action_name, action_values)
{
	//alert("The user clicked on show register.");
	document.getElementById('id05').style.display='block';
	addActionTracking(987654321, action_name, action_values); //requires webanalytics.js, which is included by header.php		
}

function showPageHelp(action_name, action_values)
{
	//alert("The user clicked on show help.");
	document.getElementById('id06').style.display='block';
	addActionTracking(987654321, action_name, action_values); //requires webanalytics.js, which is included by header.php		
}

/**************************************************************************
* Name: displaying alert notifications when user clicks on submenu
* Author: Matt Nutsch
* Date: 4-5-2017
* Description: This code displays and controls alert notifications when the user
* clicks on the alert icon.
**************************************************************************/
//DEV NOTE: The widget that calls this function was commented out 4-6-2017 while notification functionality is redefined.
function showAlerts()
{
	alert("This feature is under development.");
}
