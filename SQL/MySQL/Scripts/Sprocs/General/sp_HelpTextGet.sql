/* * *****************************************************************************
 * File Name: sp_GetHelpText.sql
 * Project: Sandbox
 * Author: Matt Nutsch
 * Date Created: 4-3-2017
 * Description: This file contains the stored procedures for GetHelpText.
 * Notes: 
 * **************************************************************************** */

DELIMITER //

DROP PROCEDURE IF EXISTS sp_GetHelpText//

CREATE PROCEDURE sp_GetHelpText
(
    IN  p_page varchar(64),
    IN  p_department varchar(64)
)
BEGIN
SELECT * FROM main_page_help
    WHERE page = p_page AND department = p_department
LIMIT 1; 
END//

DELIMITER ;