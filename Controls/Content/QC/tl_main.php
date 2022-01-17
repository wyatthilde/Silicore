<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_main.php
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/11/2017|mnutsch|KACE:17959 - Initial creation
 * 09/25/2017|mnutsch|KACE:18805 - Added code to find the user's IP address
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('../../Includes/QC/tl_qcfunctions.php'); //contains QC database query functions

/*
echo("The UserIP == " . $UserIP . "<br/>"); //ex. 192.168.97.106
echo("The UserIPElements == " . $UserIPElements . "<br/>"); //ex. Array
echo("The UserIPSubnet == " . $UserIPSubnet . "<br/>"); //ex. 97
*/
//echo("DEBUG: The UserIPSubnetFull == " . $UserIPSubnetFull . "<br/>"); //ex. 192.168.97

$siteObject = getSiteById(50);

//echo("DEBUG: the site local_network == " . $siteObject->vars['local_network'] . "<br/>");

$ipArray = explode(",",$siteObject->vars['local_network']);

//echo "DEBUG: ipArray = ";
//echo var_dump($ipArray);
//echo "<br/>";
  
if(in_array($UserIPSubnetFull, $ipArray))
{
  //echo("DEBUG: the user is at the site.<br/>");
}
else
{
  //echo("DEBUG: the user is NOT at the site.<br/>");
  echo("<script language='javascript'>");
    echo("window.addEventListener('load', function(evt)");
    echo("{");
      echo("alert('Warning: You selected Tolar, but it looks like you are logged in from a different site!');");
    echo("});");
  echo("</script>");
}

//========================================================================================== END PHP
?>

Welcome to the Tolar QC department.<br/><br/>
<strong>What does the Quality Control (QC) team do?</strong><br/><br/>
The Quality Control (QC) team is responsible for ensuring that Vista Sand sells the highest quality product possible.<br/>
The QC team tests product during various stages of production to ensure proper refinement.<br/>
The QC team also tests core samples to help direct mining to the most productive areas.