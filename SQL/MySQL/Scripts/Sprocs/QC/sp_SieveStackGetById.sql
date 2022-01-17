/* * *****************************************************************************
 * File Name: sp_GetSieveStackByID.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedure for the function getSieveStackByID.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetSieveStackByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetSieveStackByID
(
    IN  p_sieveStackId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_sieve_stacks
    WHERE id = p_sieveStackId
    ORDER BY sort_order ASC
LIMIT 1; 
END//

DELIMITER ;