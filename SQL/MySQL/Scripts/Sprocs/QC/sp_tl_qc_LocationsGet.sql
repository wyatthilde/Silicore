/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_LocationsGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tl_qc_LocationsGet$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_LocationsGet`()
BEGIN
    SELECT * from tl_qc_locations 
    WHERE is_active = 1
    ORDER BY sort_order ASC;
END$$

DELIMITER ;


