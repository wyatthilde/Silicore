/* * *****************************************************************************
 * File Name: sp_VoidSample.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedures for VoidSample.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_VoidSample//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_VoidSample
(
    IN  p_sample_id BIGINT(20)
)
BEGIN
    UPDATE `gb_qc_samples` 
    SET `void_status_code`='V' 
    WHERE id = p_sample_id; 
END//

DELIMITER ;