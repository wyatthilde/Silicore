/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_CompositeTypeGetByID.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/07/2017|mnutsch|KACE:17959 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_tl_qc_CompositeTypeGetByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_CompositeTypeGetByID
(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM tl_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1; 
END//

DELIMITER ;

