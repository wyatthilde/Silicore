/*******************************************************************************************************************************************
 * File Name: sp_hr_SiteNameGetById.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/23/2018|kkuehn|KACE:18774 - Initial creation
 * 
 ******************************************************************************************************************************************/

USE `silicore_site`;
DROP procedure IF EXISTS `sp_hr_SiteNameGetById`;

DELIMITER $$
USE `silicore_site`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hr_SiteNameGetById`(
    IN  p_site_id INT(11)
)
BEGIN
    SELECT * FROM main_sites 
    WHERE id = p_site_id
    LIMIT 1;
END$$

DELIMITER ;



