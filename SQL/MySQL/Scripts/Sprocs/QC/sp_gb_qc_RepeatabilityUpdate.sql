/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_RepeatabilityUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_RepeatabilityUpdate//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_RepeatabilityUpdate
(
    IN p_repeatability_value INT(11),
    IN p_user_id INT(11)
)
BEGIN

    UPDATE gb_qc_user_repeatability 
    SET repeatability_counter = p_repeatability_value 
    WHERE user_id = p_user_id;
END//

DELIMITER ;



