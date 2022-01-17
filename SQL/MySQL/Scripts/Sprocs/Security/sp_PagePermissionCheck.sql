/* * *****************************************************************************************************************************************
 * File Name: sp_PagePermissionCheck.sql
 * Project: Silicore
 * Description: This file contains the stored procedure for the function CheckPagePermission.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 3/24/2017|mnutsch|KACE:xxxxx - File created.
 * 7/3/2017|mnutsch|KACE:17279 - Corrected a bug in the user permissions checking process.
 * 
 * **************************************************************************************************************************************** */


DELIMITER //

DROP PROCEDURE IF EXISTS sp_CheckPagePermission//

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_CheckPagePermission
(
    IN  p_company varchar(32),
    IN  p_site varchar(32),
    IN  p_permission varchar(32),
    IN  p_web_file varchar(32)
)
BEGIN
SELECT * FROM ui_nav_left_links
    WHERE company = p_company AND site = p_site AND permission = p_permission AND web_file = p_web_file
LIMIT 1; 
END//

DELIMITER ;