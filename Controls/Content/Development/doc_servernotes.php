<?php
/* * *****************************************************************************************************************************************
 * File Name: doc_servernotes.php
 * Project: Silicore
 * Description: Content file for Documenting server platform configuration and maintenance (Ongoing)
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/02/2017|kkuehn|KACE:17802 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

$htmlStr = "";
$htmlStr .= "
<style>
  .tempUL
  {
    margin-left: 0px;
    list-style-type: disc;
  }
</style>
<b>Connecting to MSSQL from Ubuntu 16.04 LTS/PHP 7.0/Apache</b><br /><br />" . 
"In order to connect to MSSQL, we need to enable the appropriate ODBC and PDO drivers on our web servers. 
  (as of PHP 7.0, they pulled native support for MS SQL connections...not sure why)<br /><br />
Steps:<br />
<b>NOTE:</b> Make sure to copy the existing php.ini as a backup before making the changes below.</br />
1) apt-get install php-pear ( library of php components)</br />
2) apt-get install php7.0-dev (has more tools, dev version is necessary)</br />
3) apt-get install libcurl3-openssl-dev</br />

4) curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -</br />
5) curl https://packages.microsoft.com/config/ubuntu/16.04/prod.list > /etc/apt/sources.list.d/mssql-release.list</br />
6) apt-get update</br />
7) ACCEPT_EULA=Y apt-get install -y msodbcsql mssql-tools unixodbc-dev</br />
8) pecl install sqlsrv <b>*See NOTE_01</b></br />
9) pecl install pdo_sqlsrv</br />
10) add 'extension=/usr/lib/php/20151012/sqlsrv.so' to /etc/php/7.0/apache2/php.ini (have to add the path - /usr/lib/php/blah...)</br />
11) add 'extension=/usr/lib/php/20151012/pdo_sqlsrv.so' to /etc/php/7.0/apache2/php.ini (have to add the path - /usr/lib/php/blah...) <b>*See NOTE_02</b></br />
12) restart apache (service apache2 restart || /etc/init.d/apache2 restart)<br />
<br />
<b>NOTE_01:</b>Some users prefer to mount their /tmp directory as noexec for security reasons, but we’ve seen that this can cause a problem for PECL installs. 
Pointing the PECL temp_dir to a new path gets around this problem.<br />
<br />
<b>mkdir /root/tmp<br />
pecl config-set temp_dir /root/tmp</b><br />
<br />
or<br />
<br />
<b>pear config-set temp_dir /root/tmp</b><br />
<br />
(There is a known bug where pecl config-set does not work but pear config-set does. If this is the case for you, simply use the PEAR config command. 
PECL will use PEAR when doing the install.)<br />
<br />
This workaround preserves any security benefit from having /tmp set as noexec, but also allows PECL installs.<br />
<br />
<b>NOTE_02:</b> Steps 10 and 11 WILL be needed in /etc/php/7.0/cli/php.ini as well. 'CLI' stands for 'Command Line Interpreter', which is used for utility/cron/etc php scripts.<br />


<br /><br /><br />
<b>Steps to deploy a new Silicore build from development->test->production</b>
<br /><br />
<i><b>Publishing from dev->test:</b></i>
<ul>
  <li>Document change list of tickets/tasks/changes</li>
  <li>From the command line on the dev server prep the repository for final commit [hg addremove]</li>
  <li>Commit final build from the command line on the dev server [hg commit -m \"Build [xxx] final\"]</li>
  <li>Copy working codebase from dev to test:
    <ul>
      <li>Use Filezilla to pull latest code tree to the staging station from the development server. 
        [Place in /Projects/Vista/VersionDeploy/DevToTest/SiteCode/Silicore/BuildXXX/]</li>
      <li>Remove all Mercurial content [.hg folders and documents]</li>
      <li>Use Filezilla to create a new version/build folder on the test server [/var/www/versions/silicore/BuildXXX/]</li>
      <li>Use Filezilla to push the new build code tree from the staging folder to the new folder on the test server.</li>
    </ul>
  </li>
  <li>Back up test database from the command line on the production server with the following command (as root):
    <ul>
      <li>mysqldump -u root -p silicore_site > [path to backup directory]/silicore_site_YYYYMMDD_buildXXX_publish.sql</li>
    </ul>
  </li>
  <li>From the command line on the test server (as root):
    <ul>
      <li>Delete the existing symlinked folder 'silicore' from the /var/www/sites directory [rm -r silicore]</li>
      <li>Create a new symlink called silicore, and point it to the new version folder: 
        [ln -s /var/www/versions/silicore/BuildXXX /var/www/sites/silicore]</li>
    </ul>
  </li>
  <li>Execute database deploy scripts as necessary, then move them to the appropriate directory in the code tree Deployment folder</li>
  <li>Restart Apache [e.g., /etc/init.d/apache2 restart || systemctl restart apache2.service]</li>
  <li>Have devs verify that their code is working</li>
  <li>Send email to team(s) requesting user testing, attach change list</li>
  <li>Change version/build on the dev server to next increment [/Includes/pagevariables.php]</li>
  <li>Test thoroughly, rinse/repeat until final testing complete and ready for publishing to production</li>
</ul>
  
<i><b>Publishing from test->production</b></i>
<ul>
  <li>Send email to team(s) with arranged downtime schedule</li>
  <li>Copy working codebase from test to production:
    <ul>
      <li>Use Filezilla to pull tested code tree to the staging station from the test server. 
        [Place in /Projects/Vista/VersionDeploy/TestToProd/SiteCode/Silicore/BuildXXX/]</li>
      <li>Check again to remove all Mercurial content in case was missed in dev->test [.hg folders and documents]</li>
      <li>Use Filezilla to create a new version/build folder on the production server [/var/www/versions/silicore/BuildXXX/]</li>
      <li>Use Filezilla to push the new build code tree from the staging folder to the new folder on the production server.</li>
    </ul>
  </li>
  <li>Back up production database from the command line on the production server with the following command (as root):
    <ul>
      <li>mysqldump -u root -p silicore_site > [path to backup directory]/silicore_site_YYYYMMDD_buildXXX_publish.sql</li>
    </ul>
  </li>
  <li> 
    From the command line on the production server (as root):
    <ul>
      <li>Delete the existing symlinked folder 'silicore' from the /var/www/sites directory [rm -r silicore]</li>
      <li>Create a new symlink called silicore, and point it to the new version folder: 
        [ln -s /var/www/versions/silicore/BuildXXX /var/www/sites/silicore]</li>
    </ul>
  </li>
  <li>Execute database deploy scripts as necessary, then move them to the appropriate directory in the code tree Deployment folder</li>
  <li>Restart Apache [e.g., /etc/init.d/apache2 restart || systemctl restart apache2.service]
  <li>Test/verify good build and full site functionality</li>
  <li>Have devs verify that their code is working</li>
  <li>Send email to team(s) announcing completion of Silicore v.X.X (BuildXXX)</li>
</ul>


<br /><br /><br />
<b>Building a new Ubuntu 16.04 LTS LAMP server from scratch</b>
<br /><br />
After installing the base server OS, complete the following:<br />

<ul class='tempUL'>
  <li class = 'tempUL'>Log in with primary user, update/upgrade server</li>
  <li class = 'tempUL'>Add any administrative users, add to groups sudo, users, lxd</li>
  <li class = 'tempUL'>Make sure that Apache is installed, and PHP 7 is installed</li>
  <li class = 'tempUL'>Install MySQL, configure root user</li>
  <li class = 'tempUL'></li>
</ul>


<br /><br /><br />
<b>Steps to add a new user to the site</b>
<br /><br />
1) Use the 'Register' functionality in Silicore to create the initial user.<br />
2) In the main_users table, change the 'is_active' field to a 1, and verifiy that 'separation_date' is NULL.<br />
3) In the main_user_permissions table add a row to the table for 'general' and rows for any other departments the user needs access to.<br />
4) Verify that the permissions levels on the on the pages that the user needs are the same as the user's level.<br /><br />
SQL:<br /><br />
update main_users set is_active = 1 where id = [new user id];<br /><br />
update main_users set separation_date = NULL where id = [new user id];<br /><br />
<i>Create 'General' department record</i><br />
insert into main_user_permissions (user_id,permission,permission_level,site,created_datetime,modified_datetime,created_by,modified_by,company)<br />
values([new user id],'general',3,'granbury',now(),NULL,'[dev user]',NULL,'vista');<br /><br />
<i>Create user's actual department record</i><br />
insert into main_user_permissions (user_id,permission,permission_level,site,created_datetime,modified_datetime,created_by,modified_by,company)<br />
values([new user id],'[new user department]',3,'granbury',now(),NULL,'[dev user]',NULL,'vista');


<br /><br /><br />

<b>Development Machine Tools:</b><br />
<ul class='tempUL'>
  <li class='tempUL'>Netbeans (PHP, latest stable, with Python Module [see Karl for instructions])</li>
  <li class = 'tempUL'>Filezilla</li>
  <li class = 'tempUL'>MySQL Workbench (latest stable)</li>
  <li class = 'tempUL'>Putty (Windows)</li>
  <li class = 'tempUL'>RealVNC Viewer</li>
  <li class = 'tempUL'>MSFT SSMS</li>
  <li class = 'tempUL'>Tortoise HG (Mercurial, latest stable)</li>
  <li class = 'tempUL'>Gimp (latest stable)</li>
  <li class = 'tempUL'>Python 3</li>
  <li class = 'tempUL'>Slack Client</li>
  <li class = 'tempUL'>Chrome, Firefox</li>
</ul><br /><br />
";

echo($htmlStr);
//========================================================================================== END PHP
?>

<!-- HTML -->