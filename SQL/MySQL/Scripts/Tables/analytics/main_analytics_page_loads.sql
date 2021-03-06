/*******************************************************************************************************************************************
 * File Name: main_analytics_page_loads.sql
 * Project: WebAnalytics
 * Author: mnutsch
 * Date Created: 6-15-2017
 * Description: This table will contain the URLs of page loads tracked.
 * Notes: 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `main_analytics_page_loads`;

CREATE TABLE `main_analytics_page_loads` 
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(2083) NOT NULL,
  `time_called` datetime DEFAULT CURRENT_TIMESTAMP,
  `website_id` int(11) NOT NULL,
   PRIMARY KEY (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=latin1;

# ADD DATA

insert into `main_analytics_page_loads` (url, time_called, website_id)
values
('http://www.mattnutsch.com','2017-04-06 12:00:00','1'),
('http://www.mattnutsch.com?get=variable','2017-04-06 13:00:00','1');

