/*******************************************************************************************************************************************
 * File Name: main_analytics_actions.sql
 * Project: WebAnalytics
 * Author: mnutsch
 * Date Created: 6-15-2017
 * Description: This table will contain the names of custom actions tracked.
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `main_analytics_actions`;

CREATE TABLE `main_analytics_actions` 
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `time_called` datetime DEFAULT CURRENT_TIMESTAMP,
  `website_id` int(11) NOT NULL,
   PRIMARY KEY (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD DATA

insert into `main_analytics_actions` (name, time_called, website_id)
values
('example action 1','2017-04-06 12:00:00','1'),
('example action 2','2017-04-06 13:00:00','1');

