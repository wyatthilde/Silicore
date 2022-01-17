/*******************************************************************************************************************************************
 * File Name: sp_wt_qc_SampleIDsGetByGroupID.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/30/2018|mnutsch|KACE:18968 - Initial creation
 * 
 ******************************************************************************************************************************************/

use silicore_site;
 
DROP PROCEDURE IF EXISTS sp_wt_qc_SampleIDsGetByGroupID;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_wt_qc_SampleIDsGetByGroupID`
(
    IN p_group_id INT(11)
)
BEGIN
    SELECT * 
    FROM wt_qc_sample_groups 
    WHERE group_id = p_group_id;    
END$$

DELIMITER ; 