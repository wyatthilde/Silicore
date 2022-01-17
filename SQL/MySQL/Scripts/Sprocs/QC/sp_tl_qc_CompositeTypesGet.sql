/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_CompositeTypesGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tl_qc_CompositeTypesGets$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tl_qc_CompositeTypesGet`()
BEGIN
    SELECT * from tl_qc_composites;
END$$

DELIMITER ;

