/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SieveInsert.sql
 * Project: Silicore
 * Description: This stored procedure inserts a new sieve record.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/23/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_SieveInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_SieveInsert
(
    IN p_sieve_stack_id INT(11),
    IN p_screen_size INT(11),
    IN p_start_weight TINYINT(1),
    IN p_sort_order TINYINT(1),
    IN p_is_active TINYINT(1),
    IN p_create_user_id TINYINT(1),
    OUT p_insert_id INT
)
BEGIN
  INSERT INTO gb_qc_sieves 
    (sieve_stack_id, screen, start_weight, sort_order, is_active, create_user_id) 
  VALUES 
    (p_sieve_stack_id, p_screen_size, p_start_weight, p_sort_order, p_is_active, p_create_user_id);
  SELECT last_insert_id() INTO p_insert_id;
END//

DELIMITER ;
