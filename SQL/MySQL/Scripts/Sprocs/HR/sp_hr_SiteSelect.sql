/*******************************************************************************************************************************************
 * File Name: sp_hr_SiteSelect.sql
 * Project: silicore
 * Description: SQL used for the creation of a dropdown menu to select sites for HR Checklist.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 08/18/2017|ktaylor|KACE:16070 - Initial creation
 * 09/05/2017|ktaylor|KACE:16070 - Drop procedure if exist added
 * 09/22/2017|kkuehn|KACE:18733 - Added filter to exclude non-vista sites
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP PROCEDURE IF EXISTS `sp_hr_SiteSelect`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_SiteSelect`()
BEGIN
  SELECT id, description from main_sites
  WHERE is_vista_site = 1;
END$$
DELIMITER ;

call sp_hr_SiteSelect();
