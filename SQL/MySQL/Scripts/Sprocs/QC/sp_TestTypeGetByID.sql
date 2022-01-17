/* * *****************************************************************************
 * File Name: sp_GetTestTypeByID.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-15-2017
 * Description: This file contains the stored procedure for the function getTestTypeByID.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetTestTypeByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetTestTypeByID
(
    IN  p_testTypeId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_test_types
    WHERE id = p_testTypeId
LIMIT 1; 
END//

DELIMITER ;