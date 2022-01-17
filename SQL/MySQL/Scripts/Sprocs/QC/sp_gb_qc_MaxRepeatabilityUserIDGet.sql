/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_MaxRepeatabilityUserIDGet.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/24/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_gb_qc_MaxRepeatabilityUserIDGet;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_MaxRepeatabilityUserIDGet`
(
    # no input parameters
)
BEGIN
    SELECT MAX(id) 
    FROM gb_qc_user_repeatability
    LIMIT 1;
END$$

DELIMITER ;