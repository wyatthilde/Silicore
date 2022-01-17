<?php
/* * *****************************************************************************
 * File Name: main.php
 * Project: Sandbox
 * Author: kkuehn
 * Date Created: Oct 30, 2016[2:28:15 PM]
 * Description:  Content file for the main Development page
 * Notes: 
 * **************************************************************************** */


//==================================================================== BEGIN PHP
/*
//$testfile = fopen("\\\\vssrv1\\departments\\Accounting\\AR\\files_to_import\\TEST_username_DELETE-ME.txt","w") or die("Unable to open file");
//$testfile = fopen("/media/vssrv1-acct-ar-files/TEST_FromPHP2_DELETE-ME.txt","w") or die("Unable to open file");
$testfile = fopen("/var/www/sites/sandbox/Files/Accounting/AR/TEST_FromPHP_FINAL_DELETE-ME.txt","w") or die("Unable to open file");
$text = "Testing write function from PHP\r\n";
fwrite($testfile, $text);
$text = "Testing write function from PHP, line 2\r\n";
fwrite($testfile, $text);
fclose($testfile); 
*/

//====================================================================== END PHP
?>

<!-- HTML -->

<h1>Welcome to Vista Development</h1><hr><br><br>

<!--<a href="http://<?php echo($ServerIP); ?>/Includes/jquery-ui-1.12.1.custom/" target="_blank">Vista JQuery Example Page</a><br /><br />-->
<a href="http://ws-test.vistasand.com/Includes/jquery-ui-1.12.1.custom/" target="_blank">Vista JQuery Example Page</a><br /><br />

<a href="http://pweb.vistasand.com" target="_blank">Vista Public Site</a><br /><br />

<a href="http://www.maalt.com" target="_blank">Maalt Public Site</a><br /><br />

Jquery Datepicker <br />

<input type="text" id="foo-date"/>

<br /><br />

Jquery Accordion <br />

<div id="foocordion" style="width:200px;">
  <h3>Thing 1</h3>
  <div>stuff 1</div>
  <thing>Thing 2.5</thing>
  <div>stuff 2</div>
  <whatev>Thing 3.5</whatev>
  <div>stuff 3</div>
  <h3>Thing 4</h3>
  <div>stuff 4</div>
</div>

<script>
 $(function() 
 {
  $("#foo-date").datepicker();
  $("#foocordion").accordion();
 });
</script>



