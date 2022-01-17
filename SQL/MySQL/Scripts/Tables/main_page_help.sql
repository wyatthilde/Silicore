/* * *****************************************************************************************************************************************
 * File Name: main_page_help.sql
 * Project: Silicore
 * Description: This file contains functions for interacting with and updating the database tables. 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 04/03/2017|mnutsch|KACE:xxxxx - File created.
 * 07/28/2017|mnutsch|KACE:17366 - Added help contents for additional pages.
 * 
 * **************************************************************************************************************************************** */

DROP TABLE IF EXISTS `main_page_help`;

CREATE TABLE `main_page_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(64) NOT NULL,
  `department` varchar(64) NOT NULL,
  `text` varchar(1024) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD DATA

INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('1', 'main.php', 'General', 'This is the main landing page. Welcome!');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('2', 'profile.php', 'General', 'This page shows information about the user profile.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('3', 'main.php', 'QC', 'This page contains information about Quality Control.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('4', 'main.php', 'Production', 'This page contains information about Production.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('5', 'main.php', 'Loadout', 'This page contains information about loadout.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('6', 'main.php', 'Logistics', 'This page contains information about Logistics.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('7', 'main.php', 'Safety', 'This page contains information about safety.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('8', 'main.php', 'Accounting', 'This page contains information about Accounting.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('9', 'main.php', 'HR', 'This page contains information about HR.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('10', 'main.php', 'Development', 'This is the development main page.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('11', 'hrchecklist.php', 'HR', 'This page contains an HR checklist.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('12', 'quicklinks.php', 'General', 'This page contains commonly used links.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('13', 'updatepagehelp.php', 'Development', 'This web form lets you change the help text for pages in the application.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('14', 'analyticsdashboard.php', 'Development', 'This page displays website analytics information.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('15', 'samples.php', 'QC', 'This page lists the QC samples recorded. Cick on Filter Settings to filter the view.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('16', 'samplegroupadd.php', 'QC', 'This page lets you add new samples. Complete the fields and then click Save to start the new samples. Click on Select Locations provides a list of locations to choose from.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('17', 'sievetracking.php', 'QC', 'This page lets you view a list of QC sieve stacks that are available for use.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('18', 'sampleedit.php', 'QC', 'You are editing a QC sample. Complete the fields and click Save to update the record. Click on General, Specifics, or Characteristics to see sections of the sample form.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('19', 'overview.php', 'QC', 'This page shows an overview of QC sample data and statistics for each location at the selected plant.');
INSERT INTO `main_page_help` (`id`, `page`, `department`, `text`) VALUES ('20', 'performance.php', 'QC', 'This page shows counts and statistics on samples by Quality Control laboratory technician.');
