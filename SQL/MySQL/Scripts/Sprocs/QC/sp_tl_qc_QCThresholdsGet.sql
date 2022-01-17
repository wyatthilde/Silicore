/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_QCThresholdsGet.sql
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tl_qc_QCThresholdsGet$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_QCThresholdsGet`
(
    IN  p_location_id INT(11),
    IN  p_screen VARCHAR(16)
)
BEGIN
    SELECT * FROM tl_qc_thresholds 
    WHERE location_id = p_location_id
        AND screen = p_screen;
END$$
DELIMITER ;
