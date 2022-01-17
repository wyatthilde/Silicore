/* * *****************************************************************************
 * File Name: sp_GetSampleByID.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 6-5-2017
 * Description: This file contains the stored procedure for the function getSampleById.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetSampleByID//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_GetSampleByID
(
    IN  p_sampleId varchar(64)
)
BEGIN
SELECT * FROM gb_qc_samples
    WHERE id = p_sampleId
LIMIT 1; 
END//

DELIMITER ;