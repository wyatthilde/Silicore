/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SampleGroupMaxGet.sql
 * Project: Silicore
 * Description: This stored procedure will get the max value of sample_group from the sample groups table.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/29/2018|mnutsch|KACE:18968 - Initial creation
 * 
 ******************************************************************************************************************************************/

use silicore_site;

DROP PROCEDURE IF EXISTS sp_gb_qc_SampleGroupMaxGet;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_qc_SampleGroupMaxGet`
(
    # no input parameters
)
BEGIN
    SELECT MAX(group_id)
    FROM gb_qc_sample_groups 
    LIMIT 1;
END$$

DELIMITER ;

