/*******************************************************************************************************************************************
 * File Name: main_hr_job_titles.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/21/2017|kkuehn|KACE:xxxxx - Initial creation
 * 
 ******************************************************************************************************************************************/

USE silicore_site;

DROP TABLE IF EXISTS `main_hr_job_titles`;

CREATE TABLE `main_hr_job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `site_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `edit_date` datetime NOT NULL,
  `edit_user_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into main_hr_job_titles(name,description,site_id,department_id,user_type_id,create_date,create_user_id,edit_date,edit_user_id,is_active)
values('Programmer','Standard programmer',10,2,5,now(),11,now(),11,1);
insert into main_hr_job_titles(name,description,site_id,department_id,user_type_id,create_date,create_user_id,edit_date,edit_user_id,is_active)
values('Senior Programmer','Dev lead programmer',10,2,5,now(),11,now(),11,1);
insert into main_hr_job_titles(name,description,site_id,department_id,user_type_id,create_date,create_user_id,edit_date,edit_user_id,is_active)
values('Programming Manager','Development team manager',10,2,5,now(),11,now(),11,1);
insert into main_hr_job_titles(name,description,site_id,department_id,user_type_id,create_date,create_user_id,edit_date,edit_user_id,is_active)
values('Project Manager','Manages projects, deliverables, and timelines',10,2,5,now(),11,now(),11,1);

select * from main_hr_job_titles;

