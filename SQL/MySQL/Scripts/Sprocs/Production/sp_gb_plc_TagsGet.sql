
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_TagsGet.sql
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/22/2018|whildebrandt|KACE:20499 - Added procedure to get data from analog tags
 * 04/18/2018|whildebrandt|KACE:20499 - Only get tags that are kpi and active.
 ******************************************************************************************************************************************/
USE `silicore_site`;
DROP PROCEDURE IF EXISTS `sp_gb_plc_TagsGet`;
DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_TagsGet`()
BEGIN
SELECT 
	id,
  ui_label,
  classification,
  tag,
  address,
  units
FROM 
	gb_plc_tags
WHERE is_active = 1 AND is_kpi = 1; 
END$$
DELIMITER ;



