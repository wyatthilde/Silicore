/* * *****************************************************************************
 * File Name: sp_GetSievesByID.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedure for the function getSievesByID.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetSievesByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetSievesByID
(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieves
WHERE sieve_stack_id = p_sieveStackId; 
END//

DELIMITER ;