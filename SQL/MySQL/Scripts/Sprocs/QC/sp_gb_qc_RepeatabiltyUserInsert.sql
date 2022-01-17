/*******************************************************************************************************************************************
 * File Name: sp_gb_qc_RepeatabiltyUserInsert.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 10/06/2017|mnutsch|KACE:17957 - Initial creation
 * 10/09/2017|mnutsch|KACE:17957 - Modified. Added last insert ID output.
 * 
 ******************************************************************************************************************************************/

DELIMITER //

DROP PROCEDURE IF EXISTS sp_gb_qc_RepeatabiltyUserInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_gb_qc_RepeatabiltyUserInsert
(
    IN p_user_id INT(11),
    IN p_repeatability_counter INT(11),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO gb_qc_user_repeatability 
    (
        user_id, 
        repeatability_counter
    ) 
    VALUES 
    (
        p_user_id, 
        p_repeatability_counter
    );
    select last_insert_id() into p_insert_id;
END//

DELIMITER ;


