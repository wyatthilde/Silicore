/*******************************************************************************************************************************************
 * File Name: dev_Test123.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/20/2017|kkuehn|KACE:17642 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `dev_Test123`;

CREATE TABLE `dev_Test123` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `edit_date` datetime NOT NULL,
  `edit_user_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `dev_Test123`(fname,lname,create_date,create_user_id,edit_date,edit_user_id)
values 
('Bubba','Jay',curdate(),54321,curdate(),98765),
('Jackson','Hole',curdate(),54321,curdate(),98765),
('Bertram','Gilfoyle',curdate(),54321,curdate(),98765),
('Jared','Dunn',curdate(),54321,curdate(),98765),
('Jin','Yang',curdate(),54321,curdate(),98765);

select * from dev_Test123;
