<?php
/*********************************************************************************************************************************************
 * File Name: testmail.php
 * Project: smashbox
 * Author: kkuehn
 * Date Created: Jun 21, 2017[3:40:57 PM]
 * Description: 
 * Notes: 
 ********************************************************************************************************************************************/


//======================================================================================== BEGIN PHP

/* The first three parameters (address list[CSV for multiples], subject, body) are required. 
 * The last three parameters (source page, debug mode, force text-only email) are optional.
 * Use global variables ("/$PageDept/$PageName") to send the current page (will display like "/Development/testmail.php").
 * The optional parameters are positional-optional, i.e., to set option 6, 4 and 5 also need to be set.
 * By leaving off the optional parameters, the default settings for 4, 5 and 6 are as follows:
 *       4) page source will default to the emailfunctions.php page
 *       5) debug mode will be set to true, and will intercept the original address list and sent to devteam@vistasand.com instead
 *       6) force text-only will be set to false, allowing HTML tags 
 * This function can be used on any page in the site that includes the MASTER template.
 */
SendPHPMail("address1@test.com,address2@test.com,address3@test.com", "Test email subject", "Test email body",("/$PageDept/$PageName"),1,0);
//SendPHPMail("address1@test.com,address2@test.com,address3@test.com", "Test email subject", "Test email body"); // optional parameters excluded

//========================================================================================== END PHP
?>

<!-- HTML -->



