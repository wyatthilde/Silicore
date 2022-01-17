<?php
/* * *****************************************************************************
 * File Name: profile.php
 * Project: Sandbox
 * Author: mnutsch
 * Date Created: 4-4-2017
 * Description:  user profile page
 * Notes: 
 * **************************************************************************** */


//==================================================================== BEGIN PHP
//====================================================================== END PHP
?>

<!-- HTML -->

<strong>User Profile:</strong>
<br/><br/>
<?php
if(isset($_SESSION['user_id']))
{
  echoUserData($singleUserObject); //requires security.php and pagevariables.php
}
 
?>


