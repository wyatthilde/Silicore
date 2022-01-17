/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_RepeatabilityGetByUserID.sql
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

DROP PROCEDURE IF EXISTS sp_tl_qc_RepeatabilityGetByUserID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_RepeatabilityGetByUserID
(
    IN p_user_id INT(11)
)
BEGIN

    SELECT * 
    FROM tl_qc_user_repeatability 
    WHERE user_id = p_user_id 
    LIMIT 1;
END//

DELIMITER ;



