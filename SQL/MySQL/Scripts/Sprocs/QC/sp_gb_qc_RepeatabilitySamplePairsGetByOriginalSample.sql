/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_RepeatabilitySamplePairsGetByOriginalSample.sql
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
DROP PROCEDURE IF EXISTS sp_gb_qc_RepeatabilitySamplePairsGetByOriginalSample$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_RepeatabilitySamplePairsGetByOriginalSample`
(
    IN  p_original_sample_id INT(11)
)
BEGIN
    SELECT * FROM gb_qc_repeatability_pairs 
    WHERE original_sample = p_original_sample_id 
    LIMIT 1
    ;
END$$
DELIMITER ;

