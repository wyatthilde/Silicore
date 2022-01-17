/*******************************************************************************************************************************************
 * File Name: sp_tl_qc_RepeatabilitySamplePairInsert.sql
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

DROP PROCEDURE IF EXISTS sp_tl_qc_RepeatabilitySamplePairInsert//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_tl_qc_RepeatabilitySamplePairInsert
(
    IN p_original_sample BIGINT(20),
    IN p_repeated_sample BIGINT(20),
    OUT p_insert_id int
)
BEGIN
    INSERT INTO tl_qc_repeatability_pairs 
    (
        original_sample, 
        repeated_sample
    ) 
    VALUES 
    (
        p_original_sample, 
        p_repeated_sample
    );
    select last_insert_id() into p_insert_id;
END//

DELIMITER ;


