/* * *****************************************************************************************************************************************
 * File Name: sp_gb_qc_PlantsGetBySite.sql
 * Project: Silicore
 * Description: 
 * Notes: 
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/10/2017|mnutsch|KACE:17957 - Initial creation
 * 
 * **************************************************************************************************************************************** */

DROP PROCEDURE IF EXISTS sp_gb_qc_PlantsGetBySite;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_PlantsGetBySite`
(
    IN  p_main_site_id INT(11)
)
BEGIN
    SELECT * FROM main_plants 
    WHERE is_active = 1 
    AND main_site_id = p_main_site_id
    ORDER BY sort_order ASC;
END$$

DELIMITER ;