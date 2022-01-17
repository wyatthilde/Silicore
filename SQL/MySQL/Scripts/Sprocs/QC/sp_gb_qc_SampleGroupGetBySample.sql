/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SampleGroupGetBySample.sql
 * Project: Silicore
 * Description: This stored procedure will read the sample group ID based on the sample ID.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/29/2018|mnutsch|KACE:18968 - Initial creation
 * 
 ******************************************************************************************************************************************/

use silicore_site;

DROP PROCEDURE IF EXISTS sp_gb_qc_SampleGroupGetBySample;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGroupGetBySample`
(
    IN p_sample_id INT(11)
)
BEGIN
    SELECT * 
    FROM gb_qc_sample_groups 
    WHERE sample_id = p_sample_id 
    LIMIT 1;

END$$

DELIMITER ;
