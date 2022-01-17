/********************************************************************************************************************************************
 * File Name: ui_nav_left_links.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/18/2017|kkuehn|KACE:10499 - initial creation
 * 05/30/2017|mnutsch|KACE:(move tables/files from gbdevserver2 to smashbox) - Initial creation based on previous files.
 * 06/28/2017|kkuehn|KACE:16730 - Added two pages to the table, fixed the sort_order issues from previous iteration, adding 10-digit buffer 
 *                                for future sorting and additions. Updated page-level DocBlock to lastest convention. Moved /QC/Add Sample
 *                                Group above "samples".
 * 07/28/2017|mnutsch|KACE:17678 - Added a menu link for the profile page to solve a page permission lookup issue.
 * 08/02/2017|mnutsch|KACE:17366 - Modified a record name.
 * 08/02/2017|kkuehn|KACE:17802 - Added 'Server Notes' page to /Development
 * 08/11/2017|mnutsch|KACE:17916 - Updated QC related links.
 * 09/11/2017|mnutsch|KACE:17959 - Added links for the Tolar QC pages.
 *
 *******************************************************************************************************************************************/

DROP TABLE IF EXISTS `ui_nav_left_links`;

CREATE TABLE `ui_nav_left_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_link_id` int(11) NOT NULL,
  `link_name` varchar(64) NOT NULL,
  `link_title` varchar(256) DEFAULT NULL,
  `main_department_id` int(11) DEFAULT NULL,
  `web_file` varchar(128) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `indent` int(11) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `permission_level` int(11) DEFAULT '0',
  `company` varchar(32) NOT NULL,
  `site` varchar(32) NOT NULL,
  `permission` varchar(32) NOT NULL,
  `is_external` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD DATA

INSERT INTO `ui_nav_left_links` 
(parent_link_id,link_name,link_title,main_department_id,web_file,sort_order,indent,permission_level,company,site,permission,is_external)
VALUES
(0,'Home','Main Page',1,'main.php',100,0,0,'vista','granbury','all',0),
(0,'QC - GB','Quality Control Department',4,'main.php',1000,0,1,'vista','granbury','qc',0),
(0,'Production','Production Department',3,'main.php',2000,0,1,'vista','granbury','production',0),
(0,'Loadout','Loadout Department',5,'main.php',3000,0,1,'vista','granbury','loadout',0),
(0,'Logistics','Logistics Department',6,'main.php',4000,0,1,'vista','granbury','logistics',0),
(0,'Safety','Safety Department',8,'main.php',5000,0,1,'vista','granbury','safety',0),
(0,'Accounting','Accounting Department',7,'main.php',6000,0,1,'vista','granbury','accounting',0),
(0,'HR','Human Resources Department',9,'main.php',7000,0,1,'vista','granbury','hr',0),
(0,'Development','Development Department',2,'main.php',8000,0,5,'vista','granbury','development',0),
(0,'Quicklinks','Quick Links',1,'quicklinks.php',9000,0,0,'vista','granbury','all',0),
(8,'HR Checklist','Human Resources Employee Checklist',9,'hrchecklist.php',7010,2,5,'vista','granbury','hr',0),
(12,'Vista Sand','Vista Sand External Website',1,'http://pweb.vistasand.com/',9010,2,0,'vista','granbury','all',1),
(12,'Maalt LP','Maalt LP External Website',1,'https://www.maaltlp.com/',9020,2,0,'vista','granbury','all',1),
(12,'Maalt Transportation','Maalt Transportation External Website',1,'http://www.maalt.com/',9030,2,0,'vista','granbury','all',1),
(12,'Paycom','Paycom',1,'http://www.paycom.com/',9040,2,0,'vista','granbury','hr',1),
(9,'Analytics Dashboard','Analytics Dashboard',2,'analyticsdashboard.php',8010,2,5,'vista','granbury','development',0),
(9,'Update Page Help','Update Page Help',2,'updatepagehelp.php',8020,2,5,'vista','granbury','development',0),
(9,'Edit Page Content','Edit Page Content',2,'editpage.php',8030,2,1,'vista','granbury','development',0),
(9,'SendPHPMail()','This page executes SendPHPMail() in debug mode',2,'testmail.php',8340,4,5,'vista','granbury','development',0),
(9,'MySQL-PHP-Sproc','Example of how stored procedures should be used with MySQL',2,'mysqlphpsproc.php',8350,4,5,'vista','granbury','development',0),
(9,'MSSQL-PHP-Sproc','Example of how stored procedures should be used with MSSQL',2,'mssqlphpsproc.php',8360,4,5,'vista','granbury','development',0),
(9,'Server Notes','Ongoing documentation for Silicore platform server configuration and maintenance',2,'doc_servernotes.php',8380,4,5,'vista','granbury','development',0),
(9,'Code Examples','List of code examples',2,'codeexamples.php',8100,2,5,'vista','granbury','development',0),
(2,'Overview','QC Overview',4,'overview.php',1010,2,1,'vista','granbury','qc',0),
(2,'Add Sample Group','Add a New Sample Group',4,'samplegroupadd.php',1020,2,1,'vista','granbury','qc',0),
(2,'Samples','QC Samples',4,'samples.php',1030,2,1,'vista','granbury','qc',0),
(2,'Edit Sample','Edit an Existing Sample',4,'sampleedit.php',1040,2,1,'vista','granbury','qc',0),
(2,'View Sample','View an Existing Sample',4,'sampleview.php',1050,2,1,'vista','granbury','qc',0),
(2,'Performance','QC Performance Metrics',4,'performance.php',1060,2,3,'vista','granbury','qc',0),
(3,'KPI Dashboard','Key Performance Indicators',3,'kpidashboard.php',2010,2,1,'vista','granbury','production',0),
(3,'Plant Dashboard','Production Plant Metrics',3,'plantdashboard.php',2020,2,1,'vista','granbury','production',0),
(3,'TCEQ Report','Environmental Report',3,'tceqreport.php',2030,2,1,'vista','granbury','production',0),
(3,'Cresson Dashboard','Track Cresson/58 Acres Data',3,'cressondashboard.php',2040,2,0,'vista','granbury','production',0),
(0,'User Profile','User Profile',1,'profile.php',10100,2,0,'vista','granbury','general',0);

INSERT INTO `ui_nav_left_links` 
(id, parent_link_id,link_name,link_title,main_department_id,web_file,sort_order,indent,permission_level,company,site,permission,is_external)
VALUES
(37, 0,'QC - TL','Quality Control Department',4,'tl_main.php',1500,0,1,'vista','tolar','qc',0),
(38, 37,'Overview','QC Overview',4,'tl_overview.php',1510,2,1,'vista','tolar','qc',0),
(39, 37,'Add Sample Group','Add a New Sample Group',4,'tl_samplegroupadd.php',1520,2,1,'vista','tolar','qc',0),
(40, 37,'Samples','QC Samples',4,'tl_samples.php',1530,2,1,'vista','tolar','qc',0),
(41, 37,'Edit Sample','Edit an Existing Sample',4,'tl_sampleedit.php',1540,2,1,'vista','tolar','qc',0),
(42, 37,'View Sample','View an Existing Sample',4,'tl_sampleview.php',1550,2,1,'vista','tolar','qc',0),
(43, 37,'Performance','QC Performance Metrics',4,'tl_performance.php',1560,2,3,'vista','tolar','qc',0);

/*
(2,'Sieve Tracking','Sieve Tracking',4,'sievetracking.php',1023,2,1,'vista','granbury','qc',0)
*/

/*
(2,'Targets','Targets',4,'targets.php',1030,2,10,'vista','granbury','qc',0),
(2,'Control Center','Control Center',4,'controlcenter.php',1005,2,5,'vista','granbury','qc',0),
(2,'Performance','Performance',4,'performance.php',1010,2,5,'vista','granbury','qc',0),
*/

