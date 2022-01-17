/* * *****************************************************************************
 * File Name: sp_DeleteSample.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedures for DeleteSample.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_DeleteSample//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_DeleteSample
(
    IN  p_sample_id BIGINT(20)
)
BEGIN
DELETE FROM gb_qc_samples
    WHERE id = p_sample_id; 
END//

DELIMITER ;