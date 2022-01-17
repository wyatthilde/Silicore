
/*******************************************************************************************************************************************
 * File Name: sp_gb_plc_ShiftsMaxIdGet.sql
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/04/2017|whildebrandt|KACE:19563 - Initial creation
 *
 ******************************************************************************************************************************************/
DROP PROCEDURE IF EXISTS `sp_gb_plc_ShiftsMaxIdGet`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gb_plc_ShiftsMaxIdGet`()
SELECT MAX(Xfer_id) As maxId
FROM gb_plc_shifts$$
DELIMITER ;




