/*******************************************************************************************************************************************
 * File Name: sp_DepartmentsGet.sql
 * Project: Silicore
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 01/22/2018|mnutsch|KACE:18518 - Initial creation
 * 
 ******************************************************************************************************************************************/

DROP PROCEDURE IF EXISTS sp_DepartmentsGet;

DELIMITER //

CREATE DEFINER=`root`@`localhost` PROCEDURE sp_DepartmentsGet
(
  # no input parameters
)
BEGIN
    SELECT * 
    FROM main_departments;
END//

DELIMITER ;

