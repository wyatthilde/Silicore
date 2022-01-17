/*******************************************************************************************************************************************
 * File Name: sp_NavLeftLinksGet.sql
 * Project: Silicore
 * Description: Gets the names of all departments to be included in the main site navigation. 
 * Notes: Only gets the links set as active (is_active), sorted by sort_order, ascending.
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/18/2017|kkuehn|KACE:10499 - Initial creation
 * 07/06/2017|kkuehn|KACE:10499 - Clean up, changed database name, new header format added
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP procedure IF EXISTS `sp_GetNavLeftLinks`;

DELIMITER $$
USE `silicore_site`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetNavLeftLinks`()
BEGIN

  SELECT 
      ul.id, 
      ul.main_department_id, 
      md.name as 'DeptName', 
      ul.parent_link_id, 
      ul.link_name, 
      ul.link_title, 
      ul.web_file, 
      ul.indent, 
      ul.permission_level, 
      ul.company, 
      ul.site, 
      ul.permission, 
      ul.is_external
  FROM ui_nav_left_links ul
  LEFT JOIN main_departments md on ul.main_department_id = md.id
  WHERE ul.is_active = 1
  ORDER BY ul.sort_order; 

END$$

DELIMITER ;

CALL `sp_GetNavLeftLinks`();