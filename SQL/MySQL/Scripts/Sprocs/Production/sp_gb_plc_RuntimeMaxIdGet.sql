
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_RuntimeMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/29/2017|whildebrandt|KACE:19563 - Made stored procedure to return max id from gb_plc_runtime table
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_RuntimeMaxIdGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_RuntimeMaxIdGet`()
SELECT MAX(Id)
FROM gb_plc_runtime$$
DELIMITER ;



