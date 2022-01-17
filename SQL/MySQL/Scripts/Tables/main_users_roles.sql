
/*******************************************************************************************************************************************
 * File Name: main_users_roles.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/31/2018|whildebrandt|KACE:18405 - Created table that holds definitions for additional job roles
 *
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `main_users_roles`;
CREATE TABLE `main_users_roles` (
  `id` int(11) not null auto_increment,
  `role` varchar(32) not null,
  `description` varchar(64) null,
  primary key (`id`)
); 



