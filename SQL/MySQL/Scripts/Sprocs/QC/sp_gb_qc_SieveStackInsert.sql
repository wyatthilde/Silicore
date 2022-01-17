/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_SieveStackInsert.sql
 * Project: Silicore
 * Description: This stored procedure inserts a new sieve stack record.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/23/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_SieveStackInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_SieveStackInsert
(
    IN p_description VARCHAR(64),
    IN p_main_site_id INT(11),
    IN p_sort_order INT(11),
    IN p_is_active TINYINT(1),
    IN p_is_camsizer TINYINT(1),
    OUT p_insert_id INT
)
BEGIN
  INSERT INTO gb_qc_sieve_stacks 
    (description, main_site_id, sort_order, is_active, is_camsizer) 
  VALUES 
    (p_description, p_main_site_id, p_sort_order, p_is_active, p_is_camsizer);
  SELECT last_insert_id() INTO p_insert_id;
END//

DELIMITER ;
