/*******************************************************************************************************************************************
 * File Name: main_analytics_websites.sql
 * Project: WebAnalytics
 * Author: mnutsch
 * Date Created: 6-15-2017
 * Description: This table will contain the names and ID's of websites tracked.
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `main_analytics_websites`;

CREATE TABLE `main_analytics_websites` 
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `access_token` varchar(512) NOT NULL,
   PRIMARY KEY (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD DATA

insert into `main_analytics_websites` (name, access_token)
values
('vistasand.com','987654321');

