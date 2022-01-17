/*******************************************************************************************************************************************
 * File Name: main_user_permissions.sql
 * Project: Silicore
 * Description: This table determines what features a user can access.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 0?/??/2017|?|KACE:????? - Initial creation.
 * 07/03/2017|mnutsch|KACE:????? - modification
 * 08/15/2017|mnutsch|KACE:17957 - updated users.
 * 
 ******************************************************************************************************************************************/

DROP TABLE IF EXISTS `main_user_permissions`;

CREATE TABLE `main_user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission` varchar(32) NOT NULL,
  `permission_level` int(11) NOT NULL,
  `site` varchar(32) NOT NULL,
  `created_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(32) NULL,
  `modified_by` varchar(32) NULL,
  `company` varchar(32) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permission_site_UNIQUE` (`user_id`, `permission`, `site`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `main_user_permissions` (user_id, permission, permission_level, site, created_by, company)
values
('42','qc','2','granbury','mnutsch', 'vista'),
('42','general','2','granbury','mnutsch', 'vista'),
('47','qc','2','granbury','mnutsch', 'vista'),
('47','general','2','granbury','mnutsch', 'vista'),
('7','qc','2','granbury','mnutsch', 'vista'),
('7','general','2','granbury','mnutsch', 'vista'),
('50','qc','2','granbury','mnutsch', 'vista'),
('50','general','2','granbury','mnutsch', 'vista'),
('49','qc','2','granbury','mnutsch', 'vista'),
('49','general','2','granbury','mnutsch', 'vista'),
('48','qc','2','granbury','mnutsch', 'vista'),
('48','general','2','granbury','mnutsch', 'vista'),
('6','qc','2','granbury','mnutsch', 'vista'),
('6','general','2','granbury','mnutsch', 'vista'),
('1','qc','2','granbury','mnutsch', 'vista'),
('1','general','2','granbury','mnutsch', 'vista'),
('16','qc','2','granbury','mnutsch', 'vista'),
('16','general','2','granbury','mnutsch', 'vista'),
('18','qc','2','granbury','mnutsch', 'vista'),
('18','general','2','granbury','mnutsch', 'vista'),
('9','qc','4','granbury','mnutsch', 'vista'),
('9','general','4','granbury','mnutsch', 'vista'),
('15','qc','3','granbury','mnutsch', 'vista'),
('15','general','3','granbury','mnutsch', 'vista'),
('18','qc','4','granbury','mnutsch', 'vista'),
('18','general','4','granbury','mnutsch', 'vista'),
('14','qc','4','granbury','mnutsch', 'vista'),
('14','accounting','40','granbury','mnutsch', 'vista'),
('14','production','40','granbury','mnutsch', 'vista'),
('14','operations','40','granbury','mnutsch', 'vista'),
('14','logistics','40','granbury','mnutsch', 'vista'),
('14','safety','40','granbury','mnutsch', 'vista'),
('14','development','40','granbury','mnutsch', 'vista'),
('14','hr','40','granbury','mnutsch', 'vista'),
('14','loadout','40','granbury','mnutsch', 'vista'),
('14','general','40','granbury','mnutsch', 'vista'),
('11','qc','40','granbury','mnutsch', 'vista'),
('11','accounting','40','granbury','mnutsch', 'vista'),
('11','production','40','granbury','mnutsch', 'vista'),
('11','operations','40','granbury','mnutsch', 'vista'),
('11','logistics','40','granbury','mnutsch', 'vista'),
('11','safety','40','granbury','mnutsch', 'vista'),
('11','development','40','granbury','mnutsch', 'vista'),
('11','hr','40','granbury','mnutsch', 'vista'),
('11','general','40','granbury','mnutsch', 'vista'),
('11','loadout','40','granbury','mnutsch', 'vista'),
('12','qc','40','granbury','mnutsch', 'vista'),
('12','accounting','40','granbury','mnutsch', 'vista'),
('12','production','40','granbury','mnutsch', 'vista'),
('12','operations','40','granbury','mnutsch', 'vista'),
('12','logistics','40','granbury','mnutsch', 'vista'),
('12','safety','40','granbury','mnutsch', 'vista'),
('12','development','40','granbury','mnutsch', 'vista'),
('12','hr','40','granbury','mnutsch', 'vista'),
('12','general','40','granbury','mnutsch', 'vista'),
('12','loadout','40','granbury','mnutsch', 'vista'),
('2','qc','40','granbury','mnutsch', 'vista'),
('2','accounting','40','granbury','mnutsch', 'vista'),
('2','production','40','granbury','mnutsch', 'vista'),
('2','operations','40','granbury','mnutsch', 'vista'),
('2','logistics','40','granbury','mnutsch', 'vista'),
('2','safety','40','granbury','mnutsch', 'vista'),
('2','development','40','granbury','mnutsch', 'vista'),
('2','hr','40','granbury','mnutsch', 'vista'),
('2','general','40','granbury','mnutsch', 'vista'),
('2','loadout','40','granbury','mnutsch', 'vista');