<?php

/* * *****************************************************************************
 * File Name: cymaobjects.php
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: Oct 5, 2016[11:02:34 AM]
 * Description: This file contains objects for storing Cyma variables.
 * The variables can then be accessed with the name used during input.
 * Notes: Store this file in: /var/www/sites/sandbox/includes
 * **************************************************************************** */

//==================================================================== BEGIN PHP

class sandboxObject
{
  private $vars;
  
  /*****************************************************************************
  * Name: setVariable
  * Description: This function will add a value to an object.
  * Pass the name of the field as the first argument.
  * Pass the value to store as the second argument.
  * Loosely based on: http://php.net/manual/en/language.oop5.interfaces.php
  *****************************************************************************/
  public function setVariable($name, $var)
  {
    $this->vars[$name] = $var;
  }
    
  /*****************************************************************************
  * Name: getVariable
  * Description: This function will return the value of a variable stored in the object.
  * Pass the name of the field as the first argument.
  * Loosely based on: http://php.net/manual/en/language.oop5.interfaces.php
  *****************************************************************************/
  public function getVariable($name)
  {
    return $this->vars[$name] . "";
  }
   
}

/*
//Usage Example:
$testObject = new sandboxObject();
$testObject->setVariable("VendorID", "12345");
echo $testObject->getVariable("VendorID");
*/

//====================================================================== END PHP
?>