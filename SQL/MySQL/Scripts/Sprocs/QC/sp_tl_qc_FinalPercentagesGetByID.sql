/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_FinalPercentagesGetByID.sql
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

DROP PROCEDURE IF EXISTS sp_tl_qc_FinalPercentagesGetByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_FinalPercentagesGetByID
(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM tl_qc_finalpercentages 
    WHERE sample_id = p_sample_id 
    LIMIT 1;
END//

DELIMITER ;

