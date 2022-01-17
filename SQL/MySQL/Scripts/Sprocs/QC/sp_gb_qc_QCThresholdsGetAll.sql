/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_QCThresholdsGetAll.sql
 * Project: Silicore
 * Description: This sproc returns all active values in the table gb_qc_thresholds.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 11/10/2017|mnutsch|KACE:19061 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_QCThresholdsGetAll;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_QCThresholdsGetAll`
(
)
BEGIN
    SELECT * FROM gb_qc_thresholds
    WHERE is_active = 1; 
END$$
DELIMITER ;


