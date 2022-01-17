
/*******************************************************************************************************************************************
 * File Name: main_users_roles_check.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/31/2018|whildebrandt|KACE:18405 - Created table that combines additional user roles to their specified user_id and site_id. Site is currently defaulting to granbury
 *
 ******************************************************************************************************************************************/
DROP TABLE IF EXISTS `main_users_roles_check`;
CREATE TABLE `main_users_roles_check` (
  `id` int(11) not null auto_increment,
  `user_id` int(11) not null,
  `site_id` int (11) not null default 10,
  `role_id` int(11) not null default 1,
  primary key (`id`),
  constraint FK_main_users_roles_check_BYmain_users foreign key (`user_id`) references main_users (`id`),
  constraint FK_main_users_roles_check_BYmain_sites foreign key (`site_id`) references main_sites (`id`),
  constraint FK_main_users_roles_check_BYmain_users_roles foreign key (`role_id`) references main_users_roles (`id`),
  index ix_MainUsersRolesCheck_MainUsers (`user_id`),
  index ix_MainUsersRolesCheck_MainSites (`site_id`),
  index ix_MainUsersRolesCheck_MainUserRoles (`role_id`)
);



