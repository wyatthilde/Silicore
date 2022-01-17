/*******************************************************************************************************************************************
 * File Name: sp_TestDepartments.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 07/06/2017|kkuehn|KACE:xxxxx - Initial creation
 * 
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP procedure IF EXISTS `sp_TestDepartments`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TestDepartments`()
BEGIN

  SELECT
/*
      id as 'Dept. ID',
      name as 'Department Name',
      name_code as 'Name Code',
      description as 'Description',
      is_active as 'Active?'
*/

      id,
      name,
      description

  FROM main_departments
  ORDER BY id DESC;

END$$

DELIMITER ;

CALL `sp_TestDepartments`;

