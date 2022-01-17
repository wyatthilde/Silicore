/* * *****************************************************************************
 * File Name: sp_GetCompositeTypeByID.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-14-2017
 * Description: This file contains the stored procedure for the function getCompositeTypeByID.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetCompositeTypeByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetCompositeTypeByID
(
    IN  p_compositeTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_composites
    WHERE id = p_compositeTypeId
LIMIT 1; 
END//

DELIMITER ;