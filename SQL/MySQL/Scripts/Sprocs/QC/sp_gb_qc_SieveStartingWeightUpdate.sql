/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SieveStartingWeightUpdate.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_SieveStartingWeightUpdate//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_SieveStartingWeightUpdate
(
    IN p_start_weight DECIMAL(5,1),
    IN p_sieve_stack_id INT(11),
    IN p_screen VARCHAR(16)
)
BEGIN
    UPDATE gb_qc_sieves 
    SET start_weight = p_start_weight 
    WHERE sieve_stack_id = p_sieve_stack_id 
        AND screen = p_screen;
END//

DELIMITER ;


