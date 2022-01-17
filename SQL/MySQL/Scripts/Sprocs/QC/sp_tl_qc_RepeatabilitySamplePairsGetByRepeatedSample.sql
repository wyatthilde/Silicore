/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_RepeatabilitySamplePairsGetByRepeatedSample.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/09/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tl_qc_RepeatabilitySamplePairsGetByRepeatedSample$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_RepeatabilitySamplePairsGetByRepeatedSample`
(
    IN  p_repeated_sample_id INT(11)
)
BEGIN
    SELECT * FROM tl_qc_repeatability_pairs 
    WHERE repeated_sample = p_repeated_sample_id 
    LIMIT 1
    ;
END$$
DELIMITER ;

